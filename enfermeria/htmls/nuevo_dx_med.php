<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<form action="" method="post" name="form-dx" id="form-dx" target="_self" style="width:100%; height:100%;"> <input name="id_u_ndx" type="hidden" value="" id="id_u_ndx"> <input name="id_dx_ndx" type="hidden" value="" id="id_dx_ndx">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#DCDDDE">
  <tr>
    <td align="left">Para dar de alta un nuevo diagnóstico en el sistema, ingrese los siguientes datos:</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td class="titulosTabs" align="left">Nombre del diagnóstico</td>
      </tr>
      <tr>
        <td><input class="required" name="nombre_ndx" type="text" id="nombre_ndx" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td align="right" width="1%" class="titulosTabs" nowrap>Clave del diagnóstico</td>
        <td align="left"><input name="clave_ndx" type="text" class="required" id="clave_ndx" onKeyUp="conMayusculas(this); curp(this.value, this.name);" maxlength="5"></td>
      </tr>
    </table>
</td>
  </tr>
</table>
</form>

<form action="" method="post" name="form-med" id="form-med" target="_self" style="width:100%; height:100%;"> <input name="id_u_nmed" type="hidden" value="" id="id_u_nmed"> <input name="id_med_ndx" type="hidden" value="" id="id_med_ndx">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#DCDDDE">
  <tr>
    <td align="left">Para agregar un nuevo medicamento al catálogo, ingrese los siguientes datos:</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td class="titulosTabs" align="left">Nombre del medicamento</td>
      </tr>
      <tr>
        <td><input class="required" name="nombre_nmed" type="text" id="nombre_nmed" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="50%" class="titulosTabs">Clave</td>
        <td class="titulosTabs">Descripción</td>
      </tr>
      <tr>
        <td><input class="required" name="clave_nmed" type="text" id="clave_nmed" onKeyUp="conMayusculas(this); curp(this.value, this.name);" maxlength="5"></td>
        <td><select class="required" name="descripcion_nmed" id="descripcion_nmed"></select></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="50%" class="titulosTabs">Dosis</td>
        <td class="titulosTabs">Presentación</td>
      </tr>
      <tr>
        <td><input class="required" name="dosis_nmed" type="text" id="dosis_nmed" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
        <td><input class="required" name="presentacion_nmed" type="text" id="presentacion_nmed" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>

</body>
</html>
