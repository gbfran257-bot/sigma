<!--Se usa cuando se quiere hospitalizar a alguien, se debe seleccionar una cama-->
<div class="modal-dialog" role="document" id="selecciona_costo">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-selecciona-costo" id="form-selecciona-costo" target="_self" style="height:100%;">
        	<div class="row">
                <div class="form-group col-md-12 col-sm-12 text-primary">
                    <label for="costo_produccion" class="col-form-label" id="text_cama">* COSTO PRODUCCIÓN</label>
                    <input type="number" step="0.01" name="costo_produccion" id="costo_produccion" class="form-control form-control-sm" required>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 col-sm-12 text-primary" id="id_div_motivo">
                    <label for="motivo_costo" class="col-form-label">* MOTIVO COSTO</label>
                    <textarea name="motivo_costo" id="motivo_costo" type="text" class="form-control form-control-sm" placeholder="Motivo del costo de producción" required></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </form>

	</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_selecciona_costo" class="btn btn-success btn-sm" form="form-selecciona-costo">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->