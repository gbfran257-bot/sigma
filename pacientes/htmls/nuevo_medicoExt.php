<form action="" method="post" name="form-nmE" id="form-nmE" target="_self" style="width:100%; height:100%;">
<input name="id_u_nm" type="hidden" value="" id="id_u_nm">
<input name="sucursalUs" type="hidden" id="sucursalUs">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4" class="fondo_tab">
  <tr height="1%">
  <td align="center" style="text-transform:uppercase;" valign="top"><div class="ui-state-default ui-corner-all ui-helper-clearfix"><h3>Indique los siguientes datos del médico:</h3></div></td>
  </tr>
  <tr>
    <td width="" align="left" valign="">
        <table width="100%" border="0" cellspacing="4" cellpadding="2">
          <tr align="left">
            <td width="33.3%">Nombre(s) *</td>
            <td width="33.3%">A. Paterno *</td>
            <td >A. Materno</td>
          </tr>
          <tr>
            <td><input name="nombreUs" id="nombreUs" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value=""></td>
            <td><input name="apaternoUs" id="apaternoUs" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value=""></td>
            <td><input name="amaternoUs" id="amaternoUs" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" value=""></td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="4" cellpadding="2">
      <tr align="left">
        <td nowrap width="18%">Sexo *</td>
        <td nowrap width="18%">Fecha de nacimiento *</td>
        <td nowrap width="18%">Teléfono celular</td>
        <td><span title="El nombre de usuario que se utilizará para firmarse y entrar al sistema. Por defaul al crear un usuario su contraseña será la misma que el nommbre de usuario.">Nombre de usuario *</span></td>
      </tr>
      <tr>
        <td><select name="sexoUs" id="sexoUs" class="required">
          <option value="" selected>-SELECCIONAR-</option>
          <option value="1">FEMENINO</option>
          <option value="2">MASCULINO</option>
        </select></td>
        <td><input name="fnacUs" id="fnacUs" type="text" placeholder="DD/MM/AAAA" class=""></td>
        <td>
        <input name="telmovilUs" id="telmovilUs" type="text" maxlength="15">
        </td>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="100%"><input name="username" id="username" type="text" maxlength="15" onKeyUp="conMayusculas(this); nick(this.value, this.name);" class="required"></td>
            <td class="tAlertaU" nowrap valign="top"><div style="height:30px; width:100px; color:red;"><span id="iconoUsuario" class="ui-icon ui-icon-alert" style="float: left; margin: 0 -5px 0px 16px;"></span><span id="textoUsuarioDisponible" class="textoAlerta">Vacío</span></div></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <table width="100%" border="0" cellspacing="4" cellpadding="2">
      <tr align="left">
        <td >ESPECIALIDAD DEL MÉDICO</td>
      </tr>
      <tr>
        <td><select name="especialidadU" id="especialidadU" class="required"></select></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>