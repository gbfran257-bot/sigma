<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-met" id="form-met" target="_self" style="height:100%;">
            <!-- <div class="tab-pane tap-pane-primary" id="t_new_carrera" role="tabpanel" aria-labelledby="new_carrera-tab"><br> -->
            <input name="idMetodo" id="idMetodo" type="hidden" value="">
            <input name="idUser_met" id="idUser_met" type="hidden" value="">
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 text-primary">
                        <label for="nombre_metodo" class="col-form-label">*NOMBRE DEL METODO</label>
                        <input name="nombre_metodo" id="nombre_metodo" type="text" class="form-control form-control-sm" placeholder="Nombre del Metodo" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            <!-- </div> -->
        </form>

	</div>

      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_update_carrera" class="btn btn-success btn-sm hidden" form="form-met">Actualizar</button>
            <button type='submit' id="btn_save_carrera" class="btn btn-success btn-sm" form="form-met">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
