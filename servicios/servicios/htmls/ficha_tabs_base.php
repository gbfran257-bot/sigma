<div class="fondoDataT" id="ficha_servicio">
 <form action="" method="post" name="formServicio" id="formServicio" target="_self" style="height:100%;">
 <input name="idServicio" type="hidden" id="idServicio">
  <div class="miTab" id="tabs-1">
    <input name="idUsuarioS" id="idUsuarioS" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="4">
          <tr align="left"> <td class="titulosTabs" width="">* NOMBRE DEL SERVICIO</td> </tr>
          <tr>
            <td><input name="nombreS" id="nombreS" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="4">
          <tr align="left">
            <td class="titulosTabs" width="50%" nowrap>* TABULADOR BASE($)</td>
            <td class="titulosTabs" nowrap>* TABULADOR BASE DE URGENCIA($)</td>
          </tr>
          <tr>
            <td><input name="precioS" type="text" class="required" id="precioS" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"></td>
            <td style="display:;"><input name="precioUrgenciaS" id="precioUrgenciaS" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"  class="required"></td>
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
            <input name="precioNa" id="precioNa" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="" value="">
            </td>
            <td valign="top">
            <input name="precioNb" id="precioNb" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="" value="">
            </td>
            <td valign="top">
            <input name="precioNc" id="precioNc" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="" value="">
            </td>
            <td valign="top">
            <input name="precioNd" id="precioNd" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="" value="">
            </td>
            <td valign="top">
            <input name="precioNe" id="precioNe" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
</form>
</div>