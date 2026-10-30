@extends('admin.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><i class="fas fa-user-plus"></i> {{ __('Registro de Usuario') }}</div>

                    <div class="card-body">
                        <div id="app">
                            <registration-form ref="registrationForm"></registration-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-toastr@2.1.2/dist/vue-toastr.umd.min.js"></script>
    <script>
        new Vue({
        el: '#app',
        components: {
            'registration-form': {
                template: `
                    <div>
                        <form @submit.prevent="registerUser">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input id="name" type="text" class="form-control" v-model="formData.name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input id="email" type="email" class="form-control" v-model="formData.email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input id="password" type="password" class="form-control" v-model="formData.password" required>
                            </div>

                            <div class="accordion" id="additionalFieldsAccordion">
                                <div class="card">
                                    <div class="card-header" id="additionalFieldsHeading">
                                        <button class="btn btn-link" type="button"  @click="toggleAdditionalFieldsComponent" data-toggle="collapse" data-target="#additionalFieldsCollapse" aria-expanded="true" aria-controls="additionalFieldsCollapse">
                                            @{{ showAdditionalFields ? 'Ocultar Certificados' : 'Subir Certificados' }}
                                        </button>
                                    </div>

                                    <div id="additionalFieldsCollapse" class="collapse" aria-labelledby="additionalFieldsHeading" data-parent="#additionalFieldsAccordion">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="b64Cert">Certificado</label>
                                                <input v-if="showAdditionalFields" id="b64Cert" type="file" accept=".cer" @change="handleCertFileChange" ref="b64CertInput">
                                            </div>
                                            <div class="form-group">
                                                <label for="b64Key">Clave Base64</label>
                                                <input v-if="showAdditionalFields" id="b64Key" type="file" accept=".key" @change="handleKeyFileChange" ref="b64KeyInput">
                                            </div>
                                            <div class="form-group">
                                                <label for="passwordCertificados">Password Certificados</label>
                                                <input id="passwordCertificados" type="text" class="form-control" v-model="formData.passwordCertificados">
                                            </div>
                                            <div class="form-group">
                                                <label for="codigoPostal">Código Postal</label>
                                                <input id="codigoPostal" type="number" class="form-control" v-model="formData.codigoPostal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                            </div>
                            
                        </form>
                    </div>
                `,
                data() {
                    return {
                        formData: {
                            name: '',
                            email: '',
                            password: '',
                            b64Cert: '',
                            b64Key: '',
                            passwordCertificados: '',
                            codigoPostal: '',
                        },
                        showAdditionalFields: false
                    };
                },
                methods: {
                    registerUser() {
                        this.$root.registerUser();
                    },
                    toggleAdditionalFieldsComponent(){

                        if (this.showAdditionalFields) {
                            this.formData.b64Cert = '';
                            this.formData.b64Key = '';
                            this.formData.passwordCertificados = '';
                            this.formData.codigoPostal = '';
                            this.$refs.b64CertInput.value = '';
                            this.$refs.b64KeyInput.value = '';
                        }
                        
                        this.showAdditionalFields = !this.showAdditionalFields;
                    },
                    handleCertFileChange(event) {
                        const selectedFile = event.target.files[0];
                        if (selectedFile) {
                            const reader = new FileReader();
                            reader.onload = () => {
                                const base64Data = reader.result;
                                this.formData.b64Cert = base64Data.split(',')[1];
                            };
                            reader.readAsDataURL(selectedFile);
                        } else {
                            this.formData.b64Cert = '';
                        }
                    },
                    handleKeyFileChange(event) {
                        const selectedFile = event.target.files[0];
                        if (selectedFile) {
                            const reader = new FileReader();
                            reader.onload = () => {
                                const base64Data = reader.result;
                                this.formData.b64Key = base64Data.split(',')[1];
                            };
                            reader.readAsDataURL(selectedFile);
                        } else {
                            this.formData.b64Key = '';
                        }
                    },
                },
            }
        },
        methods: {
            registerUser() {
                const formData = this.$refs.registrationForm.formData;

                if ((formData.b64Cert || formData.b64Key || formData.codigoPostal) && 
                    (!formData.b64Cert || !formData.b64Key || !formData.codigoPostal)) {
                    this.showToastr('Error', 'Los datos de los certificados no pueden quedar vacíos en caso de llenar al menos uno', 'error');
                    return;
                }

                axios.defaults.withCredentials = true;
                const formDataJson = JSON.stringify(formData);
                axios.defaults.withCredentials = true;

                axios.post('/api/register', formDataJson, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    this.showToastr('Éxito', response.data.message, 'success');

                    if (formData.b64Cert && formData.b64Key && formData.codigoPostal && formData.passwordCertificados) {
                        const data = {
                            id: response.data.messageDetail.id,
                            b64Cert: formData.b64Cert,
                            b64Key: formData.b64Key,
                            password: formData.passwordCertificados,
                            codigoPostal: formData.codigoPostal
                        };

                        axios.get('/api/certificates/store', {
                            params: data,
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => {
                            this.showToastr('Éxito', response.data.message, 'success');
                            this.clearFieldsAndHideAdditional();
                        })
                        .catch(error => {
                            this.showToastr(error.response.data.message, error.response.data.messageDetail, 'error');
                        });
                    }else{
                        this.clearFieldsAndHideAdditional();
                    }
                })
                .catch(error => {
                    this.showToastr(error.response.data.message, error.response.data.messageDetail, 'error');
                });
            },

            clearFieldsAndHideAdditional() {
                this.$refs.registrationForm.formData = {
                    name: '',
                    email: '',
                    password: '',
                    b64Cert: '',
                    b64Key: '',
                    passwordCertificados: '',
                    codigoPostal: '',
                };
                this.showAdditionalFields = false;
            },

            showToastr(title, message, type) {
                if (Array.isArray(message)) {
                    message.forEach(msg => {
                        this.$toastr.Add({
                            name: "UniqueToastName",
                            title: title,
                            msg: msg,
                            clickClose: false,
                            timeout: 5000,
                            progressBarValue: 0,
                            position: "toast-top-center",
                            type: type,
                        });
                    });
                } else {
                    this.$toastr.Add({
                        name: "UniqueToastName",
                        title: title,
                        msg: message,
                        clickClose: false,
                        timeout: 5000,
                        progressBarValue: 0,
                        position: "toast-top-center",
                        type: type,
                    });
                }
            },
        },
    });

    </script>
@endsection