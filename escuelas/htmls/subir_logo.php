<div class="modal-dialog modal-lg" role="document" id="">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal"></span></strong></h4>
      </div>
      <div class="modal-body">

<form action="" method="post" name="form-documento" id="form-documento" target="_self" style="height:1%;">
<table width="100%" height="1%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left" class="text-primary">
    	<p>Para subir el logotipo es necesario que seleccione un archivo de imagen jpg o png.</p>
    </td>
  </tr>
  <tr> <td align="left"> <input name="titulo_d" type="hidden" class="required" id="titulo_d"> </td> </tr>
  <tr>
    <td align="left">
    	<button class="btn btn-sm btn-primary" type="button" onClick="$('#fileupload_logo').click();">Cargar Archivo</button>
        <input id="fileupload_logo" type="file" name="files[]" class="btn-primary btn-sm hidden" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
    <br>
    <div id="progress"> <div class="bar" style="width: 0%;"></div> </div>
    </td>
  </tr>
</table>
</form>

	</div>
      
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
            <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>     
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->