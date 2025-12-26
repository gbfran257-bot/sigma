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
            <input name="idConcepto" id="idConcepto" type="hidden" value="">        	
            <div class="row">
                <div class="form-group col-md-8 col-sm-8 text-primary col-md-offset-2">
                    <label for="input_dosis" class="col-form-label rec-requeridos">* DOSIS</label>
                    <!--<input name="input_dosis" id="input_dosis" type="text" class="form-control form-control-sm" placeholder="Escribe aqui la dósis" style="width: 600px; height: 50px;" required>-->
                     <textarea name="input_dosis" id="input_dosis" class="form-control form-control-sm" rows="4" placeholder="Escribe aqui la dósis" required></textarea>
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
