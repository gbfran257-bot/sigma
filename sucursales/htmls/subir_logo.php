<div id="documento">
<form action="" method="post" name="form-documento" id="form-documento" target="_self" style="height:1%;">
<table width="100%" height="1%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left">
    	Para subir el logotipo es necesario que seleccione un archivo de imagen jpg o png. 
        <button onClick='info_logo()' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title='INFORMACIÓN' style="width:20px; height:25px;"><span class='ui-icon ui-icon-info'></span>INFORMACIÓN</button>
    </td>
  </tr>
  <tr> <td align="left"> <input name="titulo_d" type="hidden" class="required" id="titulo_d"> </td> </tr>
  <tr>
    <td align="left">
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span></span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_logo" type="file" name="files[]" class="" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
    </span>
    <br>
    <div id="progress"> <div class="bar" style="width: 0%;"></div> </div>
    </td>
  </tr>
</table>
</form>
</div>

<div id="membrete">
<form action="" method="post" name="form-membrete" id="form-membrete" target="_self" style="height:1%;">
<table width="100%" height="1%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left">
    	Para subir el membrete es necesario que seleccione un archivo de imagen jpg o png. 
        <button onClick='info_logo()' class='ui-button ui-widget ui-corner-all ui-button-icon-only' title='INFORMACIÓN' style="width:20px; height:25px;"><span class='ui-icon ui-icon-info'></span>INFORMACIÓN</button>
    </td>
  </tr>
  <tr> <td align="left"> <input name="titulo_d" type="hidden" class="required" id="titulo_d"> </td> </tr>
  <tr>
    <td align="left">
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span></span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_mem" type="file" name="files[]" class="" style="color:transparent;"accept="image/jpg, image/jpeg, image/png">
    </span>
    <br>
    <div id="progress"> <div class="bar" style="width: 0%;"></div> </div>
    </td>
  </tr>
</table>
</form>
</div>