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
        <input name="id_sat" id="id_sat" type="hidden" value="">
        <input name="idU" id="idU" type="hidden" value="">
        <input name="id_impuesto_catalogo" id="id_impuesto_catalogo" type="hidden" value="">

        <!-- Grupo de inputs del primer row -->
        <div class="row" id="row-catalogo-priemr-grupo-campos">
          <div class="form-group col-md-4 col-sm-4 text-primary" id="impuesto-clave">
            <label for="clave" class="col-form-label rec-requeridos">* CLAVE</label>
            <input name="clave" id="clave" type="text" class="form-control form-control-sm" placeholder="CLAVE DE CUENTA" required>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-4 col-sm-4 text-primary ">
            <label for="descripcion" class="col-form-label rec-requeridos">* DESCRIPCIÓN</label>
            <textarea class="form-control form-control-sm" id="descripcion" name="descripcion" rows="2" style="resize: none; width: 400px" required placeholder="Descripción de la cuenta"></textarea>
            <div class="help-block with-errors"></div>
          </div>
        </div>

        <!-- Grupo de inputs del segundo row -->
        <div class="row" style="padding: 1rem;">
          <p style="color: rgb(51, 122, 183); font-size: 14px"><strong>Impuestos</strong></p>
          <div class="form-group col-md-3 col-sm-3 text-primary ">
            <label for=" select_tipo" class="col-form-label rec-requeridos">Tipo*</label>
            <select name="select_tipo" id="select_tipo" class="form-control form-control-sm" required onchange="tipoChangeHandler(this);">
              <option value="" selected></option>
              <option value="1">Traslado</option>
              <option value="2">Retención</option>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3 col-sm-3 text-primary ">
            <label for=" select_impuesto" class="col-form-label rec-requeridos">Impuesto*</label>
            <select name="select_impuesto" id="select_impuesto" class="form-control form-control-sm" required onchange="impuestoChangeHandler(this)">
              <option value="" selected></option>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3 col-sm-3 text-primary ">
            <label for=" select_factor" class="col-form-label rec-requeridos">Factor*</label>
            <select name="select_factor" id="select_factor" class="form-control form-control-sm" required onchange="factorChangeHandler(this)">
              <option value="" selected></option>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3 col-sm-3 text-primary ">
            <label for=" select_tasa_cuota" class="col-form-label rec-requeridos">Tasa/Cuota %*</label>
            <select name="select_tasa_cuota" id="select_tasa_cuota" class="form-control form-control-sm" required onchange="mostrarOcultarInputOtro(this);">
              <option value="" selected></option>
            </select>
            <input type="number" min="0" max="16" step="0.01" id="monto_impuesto" name="monto_impuesto" class="form-control form-control-sm" style="display: none; margin-top: 1rem;" required>
            <div class="help-block with-errors"></div>
          </div>
        </div>
        <div class="alert alert-danger hidden" id="alert_colonia" role="alert">Llenar los campos obligatorios</div>
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