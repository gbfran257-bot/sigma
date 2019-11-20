<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="tabs" style="width:100%; height:99%;">
  <ul>
    <li><a class="tabs" onClick="generales()" href="#tabs-1" style="color:; background-color:#FF6600;">GENERALES</a></li>
    <li><a class="tabs" onClick="direccion()" id="tabs-2-1" href="#tabs-2" style="color:; background-color:#008F4C;">DIRECCIÓN</a></li>
    <li><a class="tabs" onClick="contacto()" id="tabs-3-1" href="#tabs-3" style="color:; background-color:#0071BC;">CONTACTO</a></li>
    <li><a class="tabs" onClick="adicionales()" id="tabs-4-1" href="#tabs-4" style="color:; background-color:#AA0000;">ADICIONALES</a></li>
  </ul>
  
  <div id="tabs-1" style="width:98%; height:92.3%;">
  	<form action="" method="post" name="formGenerales" id="formGenerales" target="_self" style="height:100%">
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="75%" align="left" valign="top" class="tituloTab">
        DATOS DEL PACIENTE
        </td>
        <td style="color:white;" nowrap align="center">
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td class="titulosTabs" width="1%" nowrap>PACIENTE ACTIVO</td>
            <td align="left"><input name="pacienteActivo" id="pacienteActivo" type="checkbox" value="" checked disabled></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left">
            <td class="titulosTabs" width="33.3%">NOMBRE(S) *</td>
            <td class="titulosTabs" width="33.3%">A.PATERNO *</td>
            <td class="titulosTabs">A.MATERNO</td>
          </tr>
          <tr>
            <td><input name="nombreP" id="nombreP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required"></td>
            <td><input name="apaternoP" id="apaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required"></td>
            <td><input name="amaternoP" id="amaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);"></td>
          </tr>
        </table>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left">
            <td class="titulosTabs" width="33.3%">SEXO *</td>
            <td class="titulosTabs" width="33.3%">NACIONALIDAD *</td>
            <td class="titulosTabs">FECHA DE NACIMIENTO *</td>
          </tr>
          <tr>
            <td><select name="sexoP" id="sexoP" class="required"></select></td>
            <td><input name="nacionalidadP" id="nacionalidadP" type="text" value="MEXICANA" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);"></td>
            <td><input name="fnacP" id="fnacP" type="text" placeholder="DD/MM/AAAA" class="required"></td>
          </tr>
        </table>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left">
            <td class="titulosTabs" width="33.3%">TELÉFONO CELULAR</td>
            <td class="titulosTabs" width="33.3%">TELÉFONO PARTICULAR</td>
            <td class="titulosTabs" width="17%" align="center">EDAD(años)</td>
            <td class="titulosTabs" align="center">HORA NACIDO</td>
          </tr>
          <tr>
            <td><input name="telmovilP" id="telmovilP" type="text" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);"></td>
            <td><input name="telparticularP" id="telparticularP" type="text" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);"></td>
            <td><input name="edadP" id="edadP" type="text" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" readonly class=""></td>
            <td><input id="spinner1" name="spinner1" value="0:00 AM" readonly disabled></td>
          </tr>
        </table>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left">
            <td class="titulosTabs" width="33.3%">CURP</td>
            <td class="titulosTabs" width="17%" align="center">RFC</td>
            <td class="titulosTabs" align="center">HOMOCLAVE</td>
            <td class="titulosTabs" width="33.3%">SUCURSAL</td>
          </tr>
          <tr>
            <td><input name="curpP" type="text" id="curpP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="18"></td>
            <td><input name="rfcP" type="text" id="rfcP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="10"></td>
            <td><input name="homoP" type="text" id="homoP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="3"></td>
            <td><select name="sucursalP" id="sucursalP"></select></td>
          </tr>
        </table>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left">
            <td class="titulosTabs" width="33.3%">NOTAS</td>
          </tr>
          <tr>
            <td><textarea name="notasP" id="notasP" cols="" rows="" style="resize:none;" onKeyUp="conMayusculas(this);"></textarea></td>
          </tr>
        </table>
        </td>
        <td></td>
      </tr>
    </table>
    </form>
  </div>
  
  <div id="tabs-2" style="width:98%; height:92.3%;">
    
  </div>
  
  <div id="tabs-3" style="width:98%; height:92.3%;">

  </div>

  <div id="tabs-4" style="width:98%; height:92.3%;">

  </div>

</div>

</body>
</html>
