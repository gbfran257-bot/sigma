<div id="ficha_consulta" style="background-color:#E6E7E8; overflow:hidden;">
<form action="" method="post" name="formFconsulta" id="formFconsulta" target="_self" style="height:100%;">
 <input name="idConsulta" type="hidden" id="idConsulta">
    <input name="idUsuarioNC" id="idUsuarioNC" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left"> 
          	<td class="titulosTabs" width="" nowrap valign="bottom">* NOMBRE DE LA CONSULTA</td> 
          </tr>
          <tr>
            <td valign="top">
            	<input name="nombreC" id="nombreC" type="text" onKeyUp="conMayusculas(this);" class="required" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
            <td class="titulosTabs" width="100%" nowrap>* ÁREA DE LA CONSULTA</td>
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
            <td class="titulosTabs" width="50%" valign="bottom" nowrap>PRECIO($) *</td>
            <td class="titulosTabs" width="" valign="bottom" nowrap>PRECIO URGENCIA($) *</td>
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
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td class="titulosTabs" width="50%" valign="bottom" nowrap>PRECIO SUCURSAL($) *</td>
            <td class="titulosTabs" width="" valign="bottom" nowrap>PRECIO SUCURSAL URGENCIA($) *</td>
          </tr>
          <tr>
            <td valign="top">
            <input name="precioC1" id="precioC1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioCurgencia1" id="precioCurgencia1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td class="titulosTabs" width="50%" valign="bottom" nowrap>PRECIO MEMBRESÍA($) *</td>
            <td class="titulosTabs" width="" valign="bottom" nowrap>PRECIO MEMBRESÍA URGENCIA($) *</td>
          </tr>
          <tr>
            <td valign="top">
            <input name="precioMe" id="precioMe" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioMe1" id="precioMe1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr style="display:none;">
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td class="titulosTabs" width="25%" valign="bottom" nowrap>PRECIO NIVEL A ($)</td>
            <td class="titulosTabs" width="25%" valign="bottom" nowrap>PRECIO NIVEL B ($)</td>
            <td class="titulosTabs" width="25%" valign="bottom" nowrap>PRECIO NIVEL C ($)</td>
            <td class="titulosTabs" width="25%" valign="bottom" nowrap>PRECIO NIVEL D ($)</td>
            <td class="titulosTabs" width="25%" valign="bottom" nowrap>PRECIO NIVEL E ($)</td>
          </tr>
          <tr>
            <td valign="top">
            <input name="precioNa" id="precioNa" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioNb" id="precioNb" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioNc" id="precioNc" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioNd" id="precioNd" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="top">
            <input name="precioNe" id="precioNe" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
</form>
</div>