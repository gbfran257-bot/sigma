<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-est" id="form-est" target="_self" style="height:100%;">
        <!-- <div class="tab-pane tap-pane-primary" id="t_new_colonia" role="tabpanel" aria-labelledby="new_colonia-tab"><br> -->
            <input name="idest" id="idest" type="hidden" value="">        	
            <input name="idU" id="idU" type="hidden" value="">      
            <div class="row">
                <div class="form-group col-md-4 col-sm-4 text-primary col-md-offset-2">
                    <label for="linea" class="col-form-label rec-requeridos">* LÍNEA</label>
                    <input name="linea" id="linea" type="text" class="form-control form-control-sm" placeholder="Nombre del Estatus" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary ">
                    <label for="descripcion" class="col-form-label rec-requeridos">* DESCRIPCIÓN</label>
                    <textarea class="form-control form-control-sm" id="descripcion" name="descripcion" rows="2" cols="50" required placeholder="Descripción de la línea a ingresar" ></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="alert alert-danger hidden" id="alert_colonia" role="alert">Llenar los campos obligatorios</div>
        <!-- </div> -->
        </form>

	</div>

      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_update_colonia" class="btn btn-success btn-sm hidden" form="form-est">Actualizar</button>
            <button type='submit' id="btn_save_colonia" class="btn btn-success btn-sm" form="form-est">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
