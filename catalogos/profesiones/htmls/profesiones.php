<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-profesion" id="form-profesion" target="_self" style="height:100%;">
            <!-- <div class="tab-pane tap-pane-primary" id="t_new_carrera" role="tabpanel" aria-labelledby="new_carrera-tab"><br> -->
            <input name="idProfesion" id="idProfesion" type="hidden" value="">
            <input name="idUser_carrera" id="idUser_carrera" type="hidden" value="">
                <div class="row">
                    <div class="form-group col-md-4 col-sm-4 text-primary">
                        <label for="clv_carrera" class="col-form-label">CLAVE DE LA PROFESIÓN</label>
                        <input name="clv_carrera" id="clv_carrera" type="text" class="form-control form-control-sm" placeholder="Clave de la profesión" >
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-md-8 col-sm-8 text-primary">
                        <label for="nombre_carrera" class="col-form-label rec-requeridos">* NOMBRE DE LA CARRERA</label>
                        <input name="nombre_carrera" id="nombre_carrera" type="text" class="form-control form-control-sm" placeholder="Nombre de la Carrera o Profesión" required>
                        <div class="help-block with-errors">
                            <div class="alert alert-danger hidden" id="alert_carrera" role="alert">Llenar los campos obligatorios</div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </form>

	</div>

      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_update_carrera" class="btn btn-success btn-sm hidden" form="form-profesion">Actualizar</button>
            <button type='submit' id="btn_save_carrera" class="btn btn-success btn-sm" form="form-profesion">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
