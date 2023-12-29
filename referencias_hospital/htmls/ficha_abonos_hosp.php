<form id="form-ficha_abonos" name="form-ficha_abonos" data-toggle="validator" role="form">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_abonos">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">REGISTRO DE ABONO</span></strong></h4>
      </div>
      <div class="modal-body">
        <div> <input type="hidden" name="rh" id="rh" value=""> </div>
       <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="nom_p_abona">NOMBRE DE PERSONA QUE ABONA *</label>
                    <input type="text" class="form-control" id="nom_p_abona" name="nom_p_abona" placeholder="Nombre" required>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="form_pago">FORMA DE PAGO *</label>
                    <!-- <input type="text" class="form-control" id="form_pago" name="form_pago" placeholder="Abreviación de la unidad de medida" required> -->
                    <select title="forma de pago" name='cat_form_pago' id='cat_form_pago' class='form-control input-sm' required></select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="cant_abonada">CANTIDAD A ABONAR *</label>
                    <input type="number" min="1" step="0.01" class="form-control" id="cant_abonada" name="cant_abonada" placeholder="Cantidad" required>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-sm-12 col-xs-12">
                <div class="form-group">
                    <span class="btn btn-info liquidar" name="liquidar" onClick="liquidar()">Liquidar</span>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

        </div>

        <div id="alerta_new_user" class="alert alert-warning hidden">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
        </div>
        
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_abonos"><i class="fa fa-cloud" aria-hidden="true"></i> Guardar</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel_abonos"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
