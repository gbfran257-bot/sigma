<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<form action="" method="post" name="formNM" id="formNM" target="_self" style="width:100%; height:100%;">
<input name="idUsuarioNM" type="hidden" id="idUsuarioNM" value="<?php echo $row_usuario['id_u']; ?>">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#FF6600" style="color:white;">
  <tr>
    <td width="150px" align="left" class="titulosTabs">NOMBRE</td>
    <td> <input name="nombreNM" id="nombreNM" onKeyUp="conMayusculas(this);solo_letras(this.value, this.name);" type="text"class="required campoITtab"></td>
  </tr>
  <tr>
    <td align="left">APATERNO</td>
    <td><input name="apaternoNM"id="apaternoNM"onKeyUp="conMayusculas(this);solo_letras(this.value, this.name);"type="text"class="required campoITtab"></td>
  </tr>
  <tr>
    <td align="left">AMATERNO</td>
    <td><input name="amaternoNM"id="amaternoNM"onKeyUp="conMayusculas(this);solo_letras(this.value, this.name);"type="text"class="required campoITtab"></td>
  </tr>
  <tr>
    <td align="left"><span title="Las siglas del usuario en 4 caracteres">IDENTIFICADOR</span></td>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input name="idNM" type="text" id="idNM" maxlength="4" onKeyUp="conMayusculas(this); nick(this.value, this.name);" class="required campoITtab"></td>
            <td class="tAlertaU" nowrap><span id="iconoClaveUsuario" class="ui-icon ui-icon-alert" style="float: left; margin: 0 -5px 0px 3px;"></span><span id="textoClaveUsuarioDisponible" class="textoAlerta" style="text-align:left;">Vacío</span></td>
          </tr>
        </table>
   </td>
  </tr>
</table>
</form>

</body>
</html>
