<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div class="" id="ficha_servicio">
 <form action="" method="post" name="formServicio" id="formServicio" target="_self">
 <input name="idServicio" type="hidden" id="idServicio">
  <div class="miTab" id="tabs-1">
    <input name="idUsuarioS" id="idUsuarioS" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left"> <td class="titulosTabs" width="">* NOMBRE DEL SERVICIO</td> </tr>
          <tr>
            <td><input name="nombreS" id="nombreS" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
            <td class="titulosTabs" width="50%" nowrap>* PRECIO($)</td>
            <td class="titulosTabs" nowrap>* PRECIO DE URGENCIA($)</td>
          </tr>
          <tr>
            <td><input name="precioS" type="text" class="required" id="precioS" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"></td>
            <td style="display:;"><input name="precioUrgenciaS" id="precioUrgenciaS" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"  class="required"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td class="titulosTabs" width="100%" valign="bottom">DEPARTAMENTPO *</td>
          </tr>
          <tr>
            <td valign="top">
            	<select name="departamentoS" id="departamentoS" class="required">
            	  <option value="1">LABORATORIO</option>
            	</select>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
</form>
</div>

</body>
</html>
