<form id="form-ficha_us" name="form-ficha_us" data-toggle="validator" role="form">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">FICHA</span></strong></h4>
      </div>
      <div class="modal-body">
        <input name="id_usr_reg" type="hidden" value="" id="id_usr_reg">
        <input name="id_usr_update" type="hidden" value="x" id="id_usr_update">
        <input name="id_unidad_m" type="hidden" value="x" id="id_unidad_m">
        
<!--  -->
<div class="panel panel-primary" id="new_muestra">
				  <!-- Default panel contents -->
				  <div class="panel-heading">AGREGAR UNA NUEVA MUESTRA</div>
				  <div class="panel-body">
					<div class="panel panel-primary hidden" id="new_condicion">
					  <!-- Default panel contents -->
					  <div class="panel-heading">AGREGAR UNA NUEVA CONDICIÓN PARA LA MUESTRA</div>
					  <div class="panel-body">
						<p class="text-primary">Para agregar una condición para la muestra, indique los campos:</p>
						<div class="row">
							<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
								<div class="form-group">
								 <label for="nombre_n_cm">* Nombre</label>
								 <input type="text"class="form-control input-sm campos_ncm" id="nombre_n_cm" name="nombre_n_cm" placeholder="Nombre de la condición para la muestra">
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
									<button type="button" class="btn btn-success btn-sm" id="addCondicion">Guardar Condición</button>
								</div>
								<div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
									<button type="button" class="btn btn-warning btn-sm" id="cancelCondicion">Cancelar</button>
								</div>
							</div>
						</div>
					</div>
					<p class="text-primary">Para agregar una nueva muestra, indique los campos:</p>
					<div class="row">
						<div class="col-sm-8 col-xs-8 col-md-8 col-lg-8">
							<div class="form-group">
							 <label for="nombre_n_mue">* Nombre</label>
							 <input type="text"class="form-control input-sm campos_nmue" id="nombre_n_mue" name="nombre_n_mue" placeholder="Nombre de la muestra" required>
							</div>
						</div>
						<div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
							<div class="form-group">
							 <label for="condicion_n_mue">
								* Condición
								<button type="button" class="btn btn-primary btn-xs" id="btn-addCondicion">
									<i class="fa fa-plus-circle"></i> Nueva condición
								</button>
							 </label>
							 <select id="condicion_n_mue" name="condicion_n_mue" class="form-control input-sm campos_nmue" required></select>
							</div>
						</div>
					</div>
					</div>
					<!-- <div id="" class="alert alert-danger alerta_altas">
						<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
					</div> -->
					<div class="panel-footer hidden">
						<div class="row">
							<div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
							<div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
								<button type="button" class="btn btn-success btn-sm" id="addMuestra">Guardar Muestra</button>
							</div>
							<div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
								<button type="button" class="btn btn-warning btn-sm" id="cancelMuestra">Cancelar</button>
							</div>
						</div>
					</div>
				</div>

<!--  -->

        <div id="alerta_new_user" class="alert alert-warning">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
        </div>
        
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_new_u"><i class="fa fa-cloud" aria-hidden="true"></i> Guardar</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel_new_u"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
