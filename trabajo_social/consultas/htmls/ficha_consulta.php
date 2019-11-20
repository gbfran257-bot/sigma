<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div class="" id="ficha_consulta">
<form action="" method="post" name="formFconsulta" id="formFconsulta" target="_self">
 <input name="idConsulta" type="hidden" id="idConsulta">
    <input name="idUsuarioNC" id="idUsuarioNC" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr> 
          	<td class="titulosTabs" width="100%">PARA DAR DE ALTA UNA NUEVA CONSULTA, INDIQUE LOS SIGUIENTES DATOS.</td> 
          </tr>
          <tr align="left"> 
          	<td class="titulosTabs" width="" nowrap>* Nombre de la consulta</td> 
          </tr>
          <tr>
            <td><input name="nombreC" id="nombreC" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
            <td class="titulosTabs" width="100%" nowrap>* Área de la consulta</td>
          </tr>
          <tr>
            <td><select name="areaC" id="areaC" class="required"></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td class="titulosTabs" width="50%" valign="bottom" nowrap>Precio normal($) *</td>
            <td class="titulosTabs" width="" valign="bottom" nowrap>Precio de urgencia($) *</td>
          </tr>
          <tr>
            <td valign="top">
            <input name="precioC" id="precioC" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioCurgencia" id="precioCurgencia" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
</form>
</div>

</body>
</html>
