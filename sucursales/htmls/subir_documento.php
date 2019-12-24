<div id="documento">
<form action="" method="post" name="form-documento" id="form-documento" target="_self" style="height:100%;">
<table width="100%" height="100%" border="0" cellspacing="4" cellpadding="6">
  <tr>
    <td colspan="2" align="justify">Para subir un documento es necesario que seleccione un archivo de imagen o PDF.</td>
  </tr>
  <tr>
    <td width="1%" nowrap valign="top">Título del documento</td>
    <td align="left">
    	<input name="titulo_documento" type="text" class="required" id="titulo_documento" style="width:99%;" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="50" autofocus>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span></span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_docu" type="file" name="files[]" class="" style="color:transparent;"accept="image/jpg, image/jpeg, image/png, application/pdf">
    </span>
    <br>
    <div id="progress">
        <div class="bar" style="width: 0%;"></div>
    </div>
    </td>
  </tr>
</table>
</form>
</div>