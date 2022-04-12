<div class="modal-dialog" role="document" id="contenido_ficha_consulta">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-escuela" id="form-escuela" target="_self" style="height:100%;">
            <input name="usuario_ca" id="usuario_ca" type="hidden" value="">
        	<div class="row">
                <div class="form-group col-md-6 col-sm-6 text-primary">
                    <label for="no_ca" class="col-form-label">* IDENTIFICADOR DE LA CAMA</label>
                    <input name="no_ca" id="no_ca" type="number" class="form-control form-control-sm" placeholder="Identificador de la cama" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                    <label for="area_ca" class="col-form-label">* ÁREA</label>
                    <select name="area_ca" id="area_ca" class="form-control form-control-sm" required> </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-12 col-sm-12 text-primary">
                    <label for="ubicacion_ca" class="col-form-label">* UBICACIÓN DE LA CAMA</label>
                    <input name="ubicacion_ca" id="ubicacion_ca" type="text" class="form-control form-control-sm" placeholder="Ubicación de la cama" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-12 col-sm-12 text-primary">
                    <label for="hora_ca" class="col-form-label">COSTO POR HORA</label>
                    <input name="hora_ca" id="hora_ca" type="number" class="form-control form-control-sm" placeholder="Costo por hora">
                    <div class="help-block with-errors"></div>
                </div>
				<div class="form-group col-md-12 col-sm-12 text-primary">
                    <label for="descripcion_ca" class="col-form-label">DESCRIPCIÓN</label>
                    <input name="descripcion_ca" id="descripcion_ca" type="text" class="form-control form-control-sm" placeholder="Descripción">
                </div>
            </div>
        </form>

	</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_save_escuela" class="btn btn-success btn-sm" form="form-escuela">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(document).ready(function (e) {
    select2ini("#area_ca", "hospital/camas/files-serverside/select2Area.php", "Áreas");
})
</script>
