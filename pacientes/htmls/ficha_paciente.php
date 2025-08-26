<form id="form-ficha_us" name="form-ficha_us" data-toggle="validator" role="form">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">CREAR UN NUEVO PACIENTE</span></strong></h4>
      </div>
      <div class="modal-body">
        <input name="id_usr_reg" type="hidden" value="" id="id_usr_reg">
        <input name="id_usr_update" type="hidden" value="x" id="id_usr_update">
        <input name="id_sucu" type="hidden" value="x" id="id_sucu">
        <input name="id_paciente_v" type="hidden" value="x" id="id_paciente_v">
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tPersonales" aria-controls="tPersonales" role="tab" data-toggle="tab">PERSONALES</a></li>
            <li role="presentation" id="t_tDireccion"><a href="#tDireccion" aria-controls="tDireccion" role="tab" data-toggle="tab">DIRECCIÓN</a></li>
            <li role="presentation"><a href="#tAcceso" aria-controls="tAcceso" role="tab" data-toggle="tab">FISCALES</a></li>
            <li role="presentation"><a href="#tImagen" aria-controls="tImagen" role="tab" data-toggle="tab">IMAGENES</a></li>
            <li role="presentation"><a href="#tAdicionales" aria-controls="tAdicionales" role="tab" data-toggle="tab">ADICIONALES</a></li>

        </ul>
        
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tPersonales"><br>
                <div class="row">
                    <div class="col-sm-4 col-xs-4">
                     <div class="form-group">
                     <label for="nombre_p">Nombre *</label>
                     <input type="text" class="form-control" id="nombre_p" name="nombre_p" placeholder="Nombre" required onKeyUp="conMayusculas(this);">
                     <div class="help-block with-errors"></div>
                     </div>
                    </div>
                    <div class="col-sm-4 col-xs-4">
                     <div class="form-group">
                     <label for="apaterno_p">Apellido paterno *</label>
                     <input type="text" class="form-control" id="apaterno_p" name="apaterno_p" placeholder="Apellido paterno" required onKeyUp="conMayusculas(this);">
                     <div class="help-block with-errors"></div>
                     </div>
                    </div>
                    <div class="col-sm-4 col-xs-4">
                     <div class="form-group">
                     <label for="amaterno_p">Apellido materno</label>
                     <input type="text" class="form-control" id="amaterno_p" name="amaterno_p" placeholder="Apellido materno" onKeyUp="conMayusculas(this);">
                     <div class="help-block with-errors"></div>
                     </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-4">
                        <div class="form-group">
                         <label for="fecha_nacimiento_p">Fecha de nacimiento *</label>
                         <span id="edad_p" style="float:right;"></span>
                         <div class="hidden" id="fecha_nacimiento_p1_poredad">
                            <input type="number" min="0" max="120" step="1" class="form-control" id="fecha_nacimiento_p_poredad" name="fecha_nacimiento_p_poredad" placeholder="Edad" style="width: 70px;
    padding: 3px;
    position: absolute;
    top: -10px;
    right: 15px;
    font-size: 12px;
    height: 30px;">
                         </div>
                         <div class="input-group date" data-provide="datepicker" id="fecha_nacimiento_p1">
                            <input type="text" class="form-control datepi" id="fecha_nacimiento_p" name="fecha_nacimiento_p" required>
                            <div class="input-group-addon"> <i class="fa fa-calendar" aria-hidden="true"></i> </div>
                         </div>
                         <div class="help-block with-errors"></div>
                         
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4">
                    	<div class="form-group">
                        <label for="sexo_us">Sexo *</label>
                        <select id="sexo_us" name="sexo_us" class="form-control" required>
                          <option value="">-SELECCIONAR-</option>
                          <option value="1">FEMENINO</option>
                          <option value="2">MASCULINO</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    	</div> 
                    </div>
                    <div class="col-sm-4 col-xs-4">
                    	<div class="form-group">
                        <label for="pais_p">País origen *</label>
                        <select id="pais_p" name="pais_p" class="form-control" required> </select>
                        <div class="help-block with-errors"></div>
                    	</div> 
                    </div>
                </div>
                
                <div class="row de_mex">
                    <div class="col-sm-4 col-xs-4">
                        <div class="form-group">
                         <label for="edo_nacimiento">Entidad de nacimiento *</label>
                         <select id="edo_nacimiento" name="edo_nacimiento" placeholder="Estado" class="form-control" required></select>
                         <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4">
                    	<div class="form-group">
                        <label for="curp_p">CURP</label>
                        <input name="curp_p" type="text" class="form-control" id="curp_p" size="18" maxlength="18" placeholder="CLAVE ÚNICA DE REGISTRO DE POBLACIÓN" >
                        <div class="help-block with-errors"></div>
                    	</div> 
                    </div>
                    <div class="col-sm-4 col-xs-4">
                    	<div class="form-group">
                        <label for="rfc_p">RFC</label>
                        <input name="rfc_p" type="text" class="form-control" id="rfc_p" size="10" maxlength="10" placeholder="RFC" data-mask="aaaa999999">
                        <div class="help-block with-errors"></div>
                    	</div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xs-6"> 
                        <div class="form-group">
                            <label for="derechoabiencia">DERECHOHABIENCIA</label>
                            <!-- <input type="text" class="form-control" id="derechoabiencia" name="derechoabiencia" placeholder="Derechoabiencia" > -->
                             <select class="form-control" id="derechoabiencia" name="derechoabiencia">
                                <option value="" selected disabled>Elige una opción</option>
                                <option value="1">IMSS</option>
                                <option value="2">ISSSTE</option>
                                <option value="0">N/A</option>
                             </select>
                            <div class="help-block with-errors"></div>
                        </div> 
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="seccion_ine">SECCIÓN (INE)</label>
                            <input type="number" class="form-control" id="seccion_ine" name="seccion_ine" placeholder="Sección" >
                            <div class="help-block with-errors"></div>
                        </div>
                     </div>
                </div>
              
                <div class="row">
                    <div class="col-sm-3 col-xs-3"> <div class="form-group">
                    <label for="tel_personal_p">Teléfono personal</label>
                    <input type="text" class="form-control" id="tel_personal_p" name="tel_personal_p" placeholder="Teléfono personal" data-mask="(999) 999-9999" data-error="Ingresar un número válido." maxlength="12" min="10" onKeyUp="">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-3 col-xs-3"> <div class="form-group">
                    <label for="tel_particular_p">Teléfono particular</label>
                    <input type="text" class="form-control" id="tel_particular_p" name="tel_particular_p" placeholder="Teléfono particular" data-mask="(999) 999-9999" data-error="Ingresar un número válido." maxlength="12" min="10">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-3 col-xs-3"> <div class="form-group">
                    <label for="tel_trabajo_p">Teléfono trabajo</label>
                    <input type="text" class="form-control" id="tel_trabajo_p" name="tel_trabajo_p" placeholder="Teléfono de oficina" data-mask="(999) 999-9999" data-error="Ingresar un número válido." maxlength="12" min="10">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-3 col-xs-3"> <div class="form-group">
                    <label for="tel_trabajo_ext_p">Extensión</label>
                    <input type="text" class="form-control" id="tel_trabajo_ext_p" name="tel_trabajo_ext_p" placeholder="Extensión" data-error="Ingresar un número válido." maxlength="6" data-mask="99****">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div> 
                <div class="row">
                    <div class="col-sm-3 col-xs-3">
                        <div class="form-group">
                            <label for="tarjeton-parentesco">Parentesco</label>
                            <input type="text" class="form-control" id="tarjeton-parentesco" name="tarjeton-parentesco" placeholder="Parentesco" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tarjeton-clave-trabajador">Clave del trabajador</label>
                            <input type="text" class="form-control" id="tarjeton-clave-trabajador" name="tarjeton-clave-trabajador" placeholder="Clave del trabajador" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tarjeton-tipo-trabajador">Tipo del trabajador</label>
                            <input type="text" class="form-control" id="tarjeton-tipo-trabajador" name="tarjeton-tipo-trabajador" placeholder="Tipo del trabajador" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tarjeton-departamento">Departamento</label>
                            <input type="text" class="form-control" id="tarjeton-departamento" name="tarjeton-departamento" placeholder="Departamento" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="tarjeton-titular" id="label-tarjeton-titular">Titular del tarjetón</label>
                            <select name="select-titular-tarjeton" id="select-titular-tarjeton" class="form-control"></select>
                            <input class="form-control" type="text" id="input-titular-tarjeton" name="input-titular-tarjeton" value="" style="display: none;" readonly/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6"> 
                        <div class="form-group">
                            <label for="facebook_p">Facebook</label>
                            <input type="text" class="form-control" id="facebook_p" name="facebook_p" placeholder="Facebook" >
                            <div class="help-block with-errors"></div>
                        </div> 
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="instagram_p">Instagram</label>
                            <input type="text" class="form-control" id="instagram_p" name="instagram_p" placeholder="Instagram" >
                            <div class="help-block with-errors"></div>
                        </div>
                     </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-8 col-xs-8"> 
                        <div class="form-group">
                            <label for="puesto_p">Puesto</label>
                            <input type="text" class="form-control" id="puesto_p" name="puesto_p" placeholder="Puesto" >
                        </div> 
                    </div>
                    <div class="col-sm-4 col-xs-4">
                        <div class="form-group">
                            <label for="clave_p">Clave</label>
                            <input type="text" class="form-control" id="clave_p" name="clave_p" placeholder="Clave" >
                            <div class="help-block with-errors"></div>
                        </div>
                     </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-xs-8"> <div class="form-group">
                    <label for="email_p">Correo electrónico</label>
                    <input type="email" class="form-control" id="email_p" name="email_p" placeholder="Correo electrónico">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-4 col-xs-4">
                    	<div class="form-group">
                        <label for="sangre_p">Tipo sanguíneo</label>
                        <select id="sangre_p" name="sangre_p" class="form-control"> </select>
                        <div class="help-block with-errors"></div>
                    	</div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8 col-xs-8"> <div class="form-group">
                    <label for="contacto_emergencia_p">Contacto de emergencia</label>
                    <input type="text" class="form-control" id="contacto_emergencia_p" name="contacto_emergencia_p" placeholder="En caso de emergencia avisar a">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-4 col-xs-4">
                    	<div class="form-group">
                        <label for="tel_emergencia_p">Teléfono de emergencia</label>
                    	<input type="text" class="form-control" id="tel_emergencia_p" name="tel_emergencia_p" placeholder="Teléfono de emergencia" data-mask="(999) 999-9999" data-error="Ingresar un número válido." maxlength="12" min="10">
                        <div class="help-block with-errors"></div>
                    	</div> 
                    </div>
                </div>
              
            </div>
            
            <div role="tabpanel" class="tab-pane" id="tDireccion"><br>
				<div class="row">
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="estado_dir_p">Estado</label>
                    <select id="estado_dir_p" name="estado_dir_p" placeholder="Estado" class="form-control"> </select>
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="municipio_p">Municipio</label>
                    <select id="municipio_p" name="municipio_p" placeholder="Municipio" class="form-control">
                    	<option value="">-MUNICIPIO-</option>
                    </select>
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="ciudad_us">Localidad</label>
                    <input type="text" class="form-control mi_dir" id="ciudad_us" name="ciudad_us" placeholder="Ciudad o Localidad">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="colonia_us">Colonia</label>
                    <input type="text" class="form-control mi_dir" id="colonia_us" name="colonia_us" placeholder="Colonia">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="calle_us">Calle y Número</label>
                    <input type="text" class="form-control mi_dir" id="calle_us" name="calle_us" placeholder="Calle y Número">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="cp_us">Código Postal</label>
                    <input type="text" class="form-control" id="cp_us" name="cp_us" placeholder="Código Postal" data-mask="99999">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
                <div class="row" id="gmaps">
                    <div class="col-sm-12 col-xs-12">
                        <button onclick="calculaUbica();" type="button">Calcular Ubicación</button>
                    <div class="form-group">
                        <input name="lati_ud" id="lati_ud" type="hidden" value="">
                        <input name="long_ud" id="long_ud" type="hidden" value="">
                        <label for="lat_us" class="col-sm-3 col-xs-3">Latitud</label>
                        <div class="col-sm-3 col-xs-3" align="left"> <span id="lat_us"></span> </div>
                        <label for="lon_us" class="col-sm-3 col-xs-3">Longitud</label>
                        <div class="col-sm-3 col-xs-3" align="left"> <span id="lon_us"></span> </div>
                    </div> </div>
                </div>
                <div class="row" id="gmaps2">
                    <div class="col-sm-12" id="map" style="width:100%; height:300px; border:1px solid black;"></div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tAcceso"><br>
                <div class="row">
                    <div class="col-sm-8 col-xs-8"> <div class="form-group">
                    <label for="razon_social">Nombre o razón social</label>
                    <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Nombre o razón social">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-4 col-xs-4"> <div class="form-group">
                    <label for="rfc_fp">RFC</label>
                    <input name="rfc_fp" type="text" class="form-control" id="rfc_fp" size="13" maxlength="13" placeholder="RFC">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12"> <div class="form-group">
                    <label for="email_pf">Email</label>
                    <input type="email" class="form-control" id="email_pf" name="email_pf" placeholder="Correo electrónico">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="uso_cfdi">USO CFDI</label>
                            <select id="uso_cfdi" name="uso_cfdi" class="form-control dirf">
                    	        <option value="" selected>-SELECCIONAR-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="regimen_fiscal">RÉGIMEN FISCAL</label>
                            <select id="regimen_fiscal" name="regimen_fiscal" class="form-control dirf">
                                <option value="" selected>-SELECCIONAR-</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="estado_df">Estado</label>
                    <select id="estado_df" name="estado_df" placeholder="Estado" class="form-control"> </select>
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="municipio_df">Municipio</label>
                    <select id="municipio_df" name="municipio_df" placeholder="Municipio" class="form-control dirf">
                    	<option value="">-MUNICIPIO-</option>
                    </select>
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="ciudad_df">Localidad</label>
                    <input type="text" class="form-control dirf" id="ciudad_df" name="ciudad_df" placeholder="Ciudad o Localidad">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="colonia_df">Colonia</label>
                    <input type="text" class="form-control dirf" id="colonia_df" name="colonia_df" placeholder="Colonia">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="calle_df">Calle y Número</label>
                    <input type="text" class="form-control dirf" id="calle_df" name="calle_df" placeholder="Calle y Número">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                    <div class="col-sm-6"> <div class="form-group">
                    <label for="cp_df">Código Postal</label>
                    <input type="text" class="form-control dirf" id="cp_df" name="cp_df" placeholder="Código Postal" data-mask="99999">
                    <div class="help-block with-errors"></div>
                    </div> </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tImagen"><br>
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center text-primary">
                        PARA CARGAR UNA NUEVA IMAGEN, INGRESE EL TÍTULO Y SELECCIONE EL ARCHIVO A CARGAR.
                    </div>
                    <div class="col-sm-12 " id="img_block_1">
                        <label class="col-sm-3 col-md-3 text-center" for="">Título de la imagen:</label>
                        <input name="titulo_foto" type="text" class="form-control col-sm-6 col-md-6" id="titulo_foto" maxlength="50">
                        <div class="row boton_img  col-sm-3 col-md-3">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-default btn-sm disabled" id="btn_add_doc"><i class="fa fa-file-text fa-4x cel" aria-hidden="true"></i><i class="fa fa-file-text compu fa-1x" aria-hidden="true"></i></button>
                                <input id="fileupload_foto" type="file" name="files[]" class="hide" accept="image/jpg, image/jpeg, image/png">
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-default btn-sm disabled" id="btn_send_doc"><i class="fa fa-cloud-upload fa-4x cel" aria-hidden="true">                               
                                </i><i class="fa fa-cloud-upload compu fa-1x" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table-condensed no_document ">
                        <tr>
                            <td colspan="3" class="text-primary" align="">
                                PARA CARGAR UNA NUEVA IMAGEN, INGRESE EL TÍTULO Y SELECCIONE EL ARCHIVO A CARGAR.
                            </td>
                        </tr>
                        <tr>
                            <td width="1%" nowrap valign="middle">Título de la imagen</td>
                            <td align="left">
                                <input name="titulo_foto" type="text" class="form-control" id="titulo_foto" maxlength="50">
                            </td>
                            <td width="1px" nowrap>
                            <button type="button" class="btn btn-default btn-sm disabled" id="btn_add_doc"><i class="fa fa-file-text fa-4x cel" aria-hidden="true"></i><i class="fa fa-file-text compu fa-1x" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-default btn-sm disabled" id="btn_add_doc"><i class="fa fa-file-text" aria-hidden="true"></i></button>
                            </td>
                            <td>
                            <button type="button" class="btn btn-default btn-sm disabled" id="btn_send_doc"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <tr class="hidden">
                            <td colspan="3" align="left">
                                <input id="fileupload_foto" type="file" name="files[]" class="" accept="image/jpg, image/jpeg, image/png">
                            </td>
                        </tr>
                    </table> -->
                    <div id="progress"> <div class="bar" style="width: 0%;"></div> </div>
                    <table width="100%" height="96%" border="0" cellpadding="0" cellspacing="0" id="dataTableDocs" class="table table-hover table-striped table-condensed no_document" role="grid"> 
                    <thead>
                    <tr role="row" class="bg-info">
                        <th id="clickmeDocs" class='text-center' nowrap data-priority="1">#</th>
                        <th class='text-center' data-priority="2" nowrap style="white-space:nowrap;">NOMBRE ARCHIVO</th>
                        <th class='text-center' data-priority="3" style="white-space:nowrap;">USUARIO CARGÓ</th>
                        <th class='text-center' nowrap data-priority="4" style="white-space:nowrap;">FECHA</th>
                        <th class='text-center'nowrap data-priority="4" style="white-space:nowrap;">VER</th>
                        <!-- <th class='text-center'nowrap data-priority="4" style="white-space:nowrap;">IMAGEN MEMBRESÍA</th> -->
                        <th class='text-center' nowrap data-priority="5" style="white-space:nowrap;">ELIMINAR</th>
                    </tr>
                    </thead> 
                    <tbody id="tableImg"> 
                        <tr> 
                            <td class="dataTables_empty">Cargando datos del servidor</td> 
                        </tr> 
                    </tbody> 
                    </table>
                    <table id="tablaMiPDF" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-condensed si_document"> <tr> 
                    <td id="mi_documento" style="vertical-align:middle;"> <a class="media" href=""> </a> </td>
                    </tr></table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="tAdicionales"><br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group" style="display: flex;">
                            <div class="form-check" style="display: flex; align-items: center; margin-right: 1rem;">
                                <input style="margin: 0px 0.2rem 0px 0px;" class="form-check-input" type="checkbox" id="facturar">
                                <label style="margin: 0px;" class="form-check-label" for="facturar">FACTURAR</label>
                            </div>
                            <div class="form-check" style="display: flex; align-items: center; margin-right: 1rem;">
                                <input style="margin: 0px 0.2rem 0px 0px;" class="form-check-input" type="checkbox" id="proveedor">
                                <label style="margin: 0px;" class="form-check-label" for="proveedor">PROVEEDOR</label>
                            </div>
                            <div class="form-check" style="display: flex; align-items: center;">
                                <input style="margin: 0px 0.2rem 0px 0px;" class="form-check-input" type="checkbox" id="titular-check">
                                <label style="margin: 0px;" class="form-check-label" for="titular-check">TITULAR</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="table_adicionales" class="table table-hover table-striped table-condensed no_document" role="grid"> 
                            <thead>
                                <tr role="row" class="bg-danger">
                                    <th colspan="1" class='text-center' data-priority="1" nowrap style="vertical-align: middle;">#</th>
                                    <th colspan="4" class='text-center' data-priority="2" nowrap style="white-space:nowrap; vertical-align: middle;">CLIENTES PARA FACTURACIÓN
                                        <button type="button" id="nuevo_cliente" class="btn btn-info" style="padding: 0.5rem; margin-left: 0.5rem;">Nuevo cliente</button>
                                    </th>
                                    <th colspan="1" class='text-center' data-priority="3" style="white-space:nowrap; vertical-align: middle;">ACCIÓN</th>
                                </tr>
                            </thead> 
                            <tbody id="table_body_adicionales"> </tbody> 
                        </table>
                    </div>
                </div>
            </div>
            
        </div>

        <div id="alerta_new_user" class="alert alert-warning">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
        </div>
        
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="button" class="btn btn-info privacidad_hide si_document hidden" onClick="cerrar_ver_doc();" id="btn_salir_document">Regresar</button>
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_new_u"><i class="fa fa-cloud" aria-hidden="true"></i> Guardar</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel_new_u"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
