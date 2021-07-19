<!--Se usa cuando se quiere hospitalizar a alguien, se debe seleccionar una cama-->
<div class="modal-dialog" role="document" id="selecciona_cama">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-selecciona-cama" id="form-selecciona-cama" target="_self" style="height:100%;">
        	<div class="row">
                <div class="form-group col-md-6 col-sm-6 text-primary">
                    <label for="id_cama_h" class="col-form-label">* CAMA</label>
                    <select name="id_cama_h" id="id_cama_h" class="form-control form-control-sm" required> </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group col-md-6 col-sm-6 text-primary">
                    <label for="motivo_h" class="col-form-label">* MOTIVO</label>
                    <textarea name="motivo_h" id="motivo_h" type="text" class="form-control form-control-sm" placeholder="Identificador de la cama" required></textarea>
                    <div class="help-block with-errors"></div>
                    
                </div>
            </div>
        </form>

	</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_selecciona_cama" class="btn btn-success btn-sm" form="form-selecciona-cama">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(document).ready(function (e) {
    select2ini(
        "#id_cama_h", 
        "hospital/camas/files-serverside/select2Cama.php", 
        "Selecciona una cama disponible",
        { ocupado: 0 }    
    );
})
</script>