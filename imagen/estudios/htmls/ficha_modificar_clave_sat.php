<div class="modal-dialog" role="document" id="selecciona_clave_sat">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" name="form-selecciona-clave-sat" id="form-selecciona-clave-sat" target="_self" style="height:100%;">
        	<div class="row">
                <div class="form-group col-md-12 col-sm-12 col-lg-12 text-primary">
                    <label for="id_clave_sat" class="col-form-label" id="text_clave_sat">* CLAVE SAT</label>
                    <select name="id_clave_sat" id="id_clave_sat" class="form-control form-control-sm" required> </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </form>

	</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='submit' id="btn_selecciona_clave_sat" class="btn btn-success btn-sm" form="form-selecciona-clave-sat">Guardar</button>
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(document).ready(function (e) {
    /*select2ini(
        "#id_cama_h", 
        "hospital/camas/files-serverside/select2Cama.php", 
        "Selecciona una cama disponible",
        { ocupado: 0 }    
    );*/
    select2ini(
        "#id_clave_sat", 
        "sat.php", 
        "Selecciona una clave SAT",  
    );
})
</script>