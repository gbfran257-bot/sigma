

<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
        <div class="modal-header">
            <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
        </div>
        <div class="modal-body">

            <!--contenido aqui--> 
            <div class="panel panel-primary" id="new_consumible">
            <form action="" method="post" name="form-consumible" id="form-consumible" target="_self">
            <input name="idest" id="idest" type="hidden" value="">   
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UN NUEVO CONSUMIBLE PARA LAS BASES</div>
              <div class="panel-body">
              	<div class="panel panel-info hidden" id="new_tipo">
                  <!-- Default panel contents -->
                  <div class="panel-heading">AGREGAR UN NUEVO TIPO DE CONSUMIBLE PARA LAS BASES</div>
                  <div class="panel-body">
                    <p class="text-primary">Para agregar un tipo de consumible, indique los campos:</p>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <label for="nombre_n_tcon">* Nombre</label>
                             <input type="text"class="form-control input-sm campos_tcon" id="nombre_n_tcon" name="nombre_n_tcon" placeholder="Nombre del tipo de consumible">
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- <div id="" class="alert alert-danger alerta_altas1">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                    </div> -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                                <button type="button" class="btn btn-success btn-sm" id="addTipo">Guardar Tipo</button>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                <button type="button" class="btn btn-warning btn-sm" id="cancelTipo">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-info hidden" id="new_unidadC">
                  <!-- Default panel contents -->
                  <div class="panel-heading">AGREGAR UNA NUEVA UNIDAD DE MEDIDA</div>
                  <div class="panel-body">
                    <p class="text-primary">Para agregar una unidad de medida, indique los campos:</p>
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8">
                            <div class="form-group">
                             <label for="nombre_n_umedc">* Nombre</label>
                             <input type="text"class="form-control input-sm campos_umedc" id="nombre_n_umedc" name="nombre_n_umedc" placeholder="Nombre de la unidad de medida">
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                            <div class="form-group">
                             <label for="abreviacion_n_umc">* Abreviación</label>
                             <input type="text" class="form-control input-sm campos_umedc" id="abreviacion_n_umc"name="abreviacion_n_umc"placeholder="Abrevicaión de la unidad de medida" maxlength="20">
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- <div id="" class="alert alert-danger alerta_altas1">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                    </div> -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                                <button type="button" class="btn btn-success btn-sm" id="addUmedC">Guardar Unidad</button>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                <button type="button" class="btn btn-warning btn-sm" id="cancelUmedC">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-info hidden" id="new_presentacion">
                  <!-- Default panel contents -->
                  <div class="panel-heading">AGREGAR UNA NUEVA PRESENTACIÓN</div>
                  <div class="panel-body">
                    <p class="text-primary">Para agregar una presentación, indique los campos:</p>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <label for="nombre_n_presentacion">* Nombre</label>
                             <input type="text"class="form-control input-sm campos_upresentacion" id="nombre_n_presentacion" name="nombre_n_presentacion" placeholder="Nombre de la presentación">
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- <div class="alert alert-danger alerta_altas1">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                    </div> -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-7 col-xs-7 col-md-7 col-lg-7" align="right"></div>
                            <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3" align="right">
                                <button type="button" class="btn btn-success btn-sm" id="addPresentacion">Guardar Presentación</button>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                <button type="button" class="btn btn-warning btn-sm" id="cancelPresentacion">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <p class="text-primary">Para agregar un consumible, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                         <label for="nombre_n_cons">* Nombre</label>
                         <input type="text"class="form-control input-sm campos_cons" id="nombre_n_cons" name="nombre_n_cons" placeholder="Nombre del consumible" required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                         <label for="descripcion_n_cons">Descripción</label>
                         <textarea class="form-control input-sm campos_cons" id="descripcion_n_cons" name="descripcion_n_cons" cols="" rows="3" placeholder="Descripción del consumible" style="resize:none;"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                    	<div class="form-group">
                        	<label for="tipo_n_cons">
                            	* Tipo
                                <button type="button" class="btn btn-xs btn-primary" id="btn-new_tipo_con"><i class="fa fa-plus-circle"></i> Nuevo tipo</button>
                            </label>
                            <select name="tipo_n_cons" id="tipo_n_cons" class="form-control input-sm campos_cons" required></select>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                    	<div class="form-group">
                        	<label for="unidad_n_cons">
                            	* Unidad
                                <button type="button" class="btn btn-xs btn-primary" id="btn-new_unidad_con"><i class="fa fa-plus-circle"></i> Nueva unidad</button>
                            </label>
                            <select name="unidad_n_cons" id="unidad_n_cons" class="form-control input-sm campos_cons" required></select>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                    	<div class="form-group">
                        	<label for="presentacion_n_cons">
                            	* Presentación
                                <button type="button" class="btn btn-xs btn-primary" id="btn-new_presentacion_con"><i class="fa fa-plus-circle"></i> Nueva presentación</button>
                            </label>
                            <select name="presentacion_n_cons" id="presentacion_n_cons" class="form-control input-sm campos_cons" required></select>
                        </div>
                   </div>
                </div>
                </div>
                <!-- <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div> -->
                <div class="panel-footer">
                </div>
               </form>
            </div>
            <!-- fin contenido -->

        </div>

        <div class="modal-footer">
            <div class="form-group">
                <div class="col-sm-offset-0 col-sm-12">
                    <button type='submit' id="btn_update_colonia" class="btn btn-success btn-sm hidden" form="form-consumible">Actualizar</button>
                    <button type='submit' id="btn_save_colonia" class="btn btn-success btn-sm" form="form-consumible">Guardar</button>
                    <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
