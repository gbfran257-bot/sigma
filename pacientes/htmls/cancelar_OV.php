<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form_cov" id="form_cov" target="_self" style="height:100%;">
        <!-- <div class="tab-pane tap-pane-primary" id="t_new_colonia" role="tabpanel" aria-labelledby="new_colonia-tab"><br> -->
            <input name="idest" id="idest" type="hidden" value="">        	
            <input name="idU" id="idU" type="hidden" value="">      
            <div class="row" style="display:flex; justify-content:center;">
                <div class="form-group col-md-8 col-sm-8 text-primary">
                    <label for="m_cancelacion" class="col-form-label rec-requeridos">* MOTIVO DE LA CANCELACIÓN</label>
                    <input name="m_cancelacion" id="m_cancelacion" type="text" class="form-control form-control-sm" placeholder="Motivo de la Cancelación" required>
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
            <!-- <button type='submit' id="btn_update_colonia" class="btn btn-success btn-sm hidden" form="form_cov">Actualizar</button> -->
            <button type='submit' id="btn_cancer_OV" class="btn btn-success btn-sm" form="form_cov">Cancelar Orden de Venta</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Salir</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
