import axios from 'axios';
import Vue from 'vue';

Vue.component('registration-form', {
    template: `
        <div>
            <form @submit.prevent="registerUser">
                <!-- Campos del formulario -->
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
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
    `,
    data() {
        return {
            formData: {
                name: '',
                email: '',
                password: ''
            }
        };
    },
    methods: {
        registerUser() {
            axios.post('/api/register', this.formData)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error.response.data);
                });
        }
    }
});
