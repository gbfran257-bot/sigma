<form id="form-principal" name="form-principal" data-toggle="validator" role="form">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close" id="btn_hide_modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">CREAR UN NUEVO EVENTO</span></strong></h4>
      </div>
      <div class="modal-body">
        <input name="id_usr_reg" type="hidden" value="" id="id_usr_reg">
        <input name="id_usr_update" type="hidden" value="" id="id_usr_update">
        <input name="id_eventillo" type="hidden" value="" id="id_eventillo">
        
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title" id="title_panel">Panel title</h3>
          </div>
          <div class="panel-body">
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                 <div class="form-group">
                 <label for="titulo_e">* TÍTULO</label>
                 <input type="text" class="form-control" id="titulo_e" name="titulo_e" placeholder="Título del evento" required>
                 <div class="help-block with-errors"></div>
                 </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                    <div class="form-group">
                    <label for="descripcion_e">DESCRIPCIÓN</label>
                    <textarea name="descripcion_e" cols="" rows="3" id="descripcion_e" class="form-control" style="resize:none;" placeholder="Descripción del evento"></textarea>
                    <div class="help-block with-errors"></div>
                    </div> 
                </div>
            </div>
            <div class="row" id="estatus_evt">
                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                    <div class="form-group">
                    <label for="estatus_e">ESTATUS</label>
                    <select name="estatus_e" id="estatus_e" class="form-control">
                    	<option value="PENDIENTE">PENDIENTE</option>
                        <option value="CONFIRMADO">CONFIRMADO</option>
                        <option value="CANCELADO">CANCELADO</option>
                    </select>
                    <div class="help-block with-errors"></div>
                    </div> 
                </div>
            </div>
            
            <div id="alerta_1" class="alert alert-danger">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, hay algunos errores.
            </div>
        
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_new">Crear evento</button>
            <button type="button" class="btn btn-danger" id="btn_eliminar_e">Eliminar evento</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel_new">Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
