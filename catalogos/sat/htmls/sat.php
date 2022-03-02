<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-sat" id="form-sat" target="_self" style="height:100%;">
        <!-- <div class="tab-pane tap-pane-primary" id="t_new_colonia" role="tabpanel" aria-labelledby="new_colonia-tab"><br> -->
            <input name="id_sat" id="id_sat" type="hidden" value="">        	
            <input name="idU" id="idU" type="hidden" value="">      
            <div class="row">
                <div class="form-group col-md-4 col-sm-4 text-primary col-md-offset-1">
                    <label for="clave" class="col-form-label rec-requeridos">* CLAVE</label>
                    <input name="clave" id="clave" type="text" class="form-control form-control-sm" placeholder="CLAVE DE CUENTA" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-3 col-sm-3 text-primary ">
                    <label for="clave" class="col-form-label rec-requeridos">* IVA</label>
                    <select name="iva" id="iva" class="form-control form-control-sm" required>
                      <option value="16">16%</option>
                      <option value="10">10%</option>
                      <option value="0">0%</option>
                      <option value="excento">EXCENTO</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary ">
                    <label for="descripcion" class="col-form-label rec-requeridos">* DESCRIPCIÓN</label>
                    <textarea class="form-control form-control-sm" id="descripcion" name="descripcion" rows="2" cols="50" required placeholder="Descripción de la cuenta " ></textarea>
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
            <button type='submit' id="btn_update_colonia" class="btn btn-success btn-sm hidden" form="form-sat">Actualizar</button>
            <button type='submit' id="btn_save_colonia" class="btn btn-success btn-sm" form="form-sat">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
