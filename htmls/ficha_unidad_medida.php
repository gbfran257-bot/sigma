<form id="form-ficha_us" name="form-ficha_us" data-toggle="validator" role="form">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">FICHA</span></strong></h4>
      </div>
      <div class="modal-body">
        <input name="id_usr_reg" type="hidden" value="" id="id_usr_reg">
        <input name="id_usr_update" type="hidden" value="x" id="id_usr_update">
        <input name="id_unidad_m" type="hidden" value="x" id="id_unidad_m">
        
       <div class="row">
            <div class="col-sm-7 col-xs-7">
             <div class="form-group">
             <label for="unidad_m">Nombre de la unidad de medida *</label>
             <input type="text" class="form-control" id="unidad_m" name="unidad_m" placeholder="Unidad de medida" required onKeyUp="conMayusculas(this);">
             <div class="help-block with-errors"></div>
             </div>
            </div>
            <div class="col-sm-5 col-xs-5">
             <div class="form-group">
             <label for="abreviacion_u">Abreviación *</label>
             <input type="text" class="form-control" id="abreviacion_u" name="abreviacion_u" placeholder="Abreviación de la unidad de medida" required>
             <div class="help-block with-errors"></div>
             </div>
            </div>
        </div>

        <div id="alerta_new_user" class="alert alert-warning">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
        </div>
        
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_new_u"><i class="fa fa-cloud" aria-hidden="true"></i> Guardar</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel_new_u"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
