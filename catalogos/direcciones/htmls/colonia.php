<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-colonia" id="form-colonia" target="_self" style="height:100%;">
        <!-- <div class="tab-pane tap-pane-primary" id="t_new_colonia" role="tabpanel" aria-labelledby="new_colonia-tab"><br> -->
            <input name="idColonia" id="idColonia" type="hidden" value="">
            <!-- <input name="idUser_carrera" id="idUser_carrera" type="hidden" value=""> -->
        	<div class="row">
                <div class="form-group col-md-6 col-sm-6 text-primary">
                    <label for="estadoCol" class="col-form-label rec-requeridos">* ESTADO</label>
                    <select name="estadoCol" id="estadoCol" class="form-control form-control-sm" required >
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                    <label for="municipioCol" class="col-form-label rec-requeridos">* MUNICIPIO</label>
                    <select name="municipioCol" id="municipioCol" class="form-control form-control-sm" required >
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8 col-sm-8 text-primary">
                    <label for="col_Col" class="col-form-label rec-requeridos">* COLONIA</label>
                    <input name="col_Col" id="col_Col" type="text" class="form-control form-control-sm" placeholder="Nombre de la Colonia a registrar" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-4 col-sm-4 text-primary">
                    <label for="CP_col" class="col-form-label rec-requeridos ">* CODIGO POSTAL</label>
                    <input name="CP_col" id="CP_col" type="number" class="form-control form-control-sm" placeholder="Ingresa el Código Postal" required>
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
            <button type='submit' id="btn_update_colonia" class="btn btn-success btn-sm hidden" form="form-colonia">Actualizar</button>
            <button type='submit' id="btn_save_colonia" class="btn btn-success btn-sm" form="form-colonia">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
