<div class="modal-dialog modal-lg" role="document" id="">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><strong><span id="titulo_modal">SUBIR UNA FOTOGRAFÍA</span></strong></h4>
      </div>
      <div class="modal-body">
      
      <div class="panel panel-info">
          <!-- Default panel contents -->
          <div class="panel-heading">Para subir una fotografía es necesario que seleccione un archivo de imagen.</div>
          <div class="panel-body">
      
<form action="" method="post" name="form-fotografia" id="form-fotografia" target="_self" style="height:100%;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
  <tr>
    <td width="1%" nowrap valign="top">Título de la fotografía</td>
    <td align="left">
    	<input name="titulo_foto" type="text" class="form-control" id="titulo_foto" style="width:99%;" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="50" autofocus required>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
        <input id="fileupload_foto" type="file" name="files[]" class="btn btn-success btn-sm disabled" accept="image/jpg, image/jpeg, image/png">
    <div id="progress"> <div class="bar" style="width: 0%;"></div> </div>
    </td>
  </tr>
</table>
</form>

</div>
      </div>

</div>
<div class="modal-footer">
    <div class="form-group">
    <div class="col-sm-offset-0 col-sm-12">
        <button type='button' class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar</button>     
    </div>
    </div>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->