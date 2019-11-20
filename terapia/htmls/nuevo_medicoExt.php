<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<form action="" method="post" name="form-nmE" id="form-nmE" target="_self" style="width:100%; height:100%;"> <input name="id_u_nm" type="hidden" value="" id="id_u_nm"> <input name="id_medExt" type="hidden" value="" id="id_medExt">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#EEE">
  <tr>
    <td align="center" style="color:; text-transform:uppercase;">Indique los siguientes datos del médico:</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td class="titulosTabs" align="left" width="170" style="color:black;">* Nombre</td>
        <td><input class="required" name="nombre_nmE" type="text" id="nombre_nmE" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td class="titulosTabs" align="left" width="170" style="color:black;">* Apellido paterno</td>
        <td><input class="required" name="apaterno_nmE" type="text" id="apaterno_nmE" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td class="titulosTabs" align="left" width="170" style="color:black;">Apellido materno</td>
        <td><input class="" name="amaterno_nmE" type="text" id="amaterno_nmE" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="left" width="170" class="titulosTabs" nowrap style="color:black;">* Clave (iniciales)</td>
        <td align="left" width=""><input name="clave_nmE" type="text" class="required" id="clave_nmE" onKeyUp="conMayusculas(this); curp(this.value, this.name);" maxlength="4"></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="left" width="170" class="titulosTabs" nowrap style="color:black;">Teléfono</td>
        <td align="left" width=""><input name="telefono_nmE" type="text" class="" id="telefono_nmE" onKeyUp="solo_letras_numeros(this.value, this.name);" maxlength="15"> </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>

</body>
</html>
