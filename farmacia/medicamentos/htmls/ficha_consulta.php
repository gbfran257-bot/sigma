<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div class="" id="ficha_consulta" style="background-color:#E6E7E8; overflow:hidden;">
<form action="" method="post" name="formFconsulta" id="formFconsulta" target="_self" style="height:100%;">
 <input name="idConsulta" type="hidden" id="idConsulta">
    <input name="idUsuarioNC" id="idUsuarioNC" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left"> 
          	<td class="titulosTabs" width="1%" nowrap valign="">* NOMBRE DEL PRODUCTO</td> 
            <td valign="">
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
            <td class="titulosTabs" nowrap width="50%">* ÁREA DEL PRODUCTO</td>
            <td class="titulosTabs" nowrap>* CATEGORÍA <button id="bCategoria" class="botoncillo"></button></td>
          </tr>
          <tr>
            <td><select name="areaC" id="areaC" class="required"></select></td>
            <td><select name="categoriaP" id="categoriaP" class="required"></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr id="esMedicamento">
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
            <td class="titulosTabs" nowrap width="50%">
            	* MEDICAMENTO GENÉRICO <button id="bMedG" class="botoncillo"></button>
            </td>
            <td class="titulosTabs" nowrap>* NIVEL MEDICAMENTO</td>
          </tr>
          <tr>
            <td><select name="medicamentoG" id="medicamentoG" class="required"></select></td>
            <td><select name="nivelMedi" id="nivelMedi" class="required">
              <option value="">-SELECCIONAR-</option>
              <option value="PRIMER NIVEL">PRIMER NIVEL</option>
              <option value="SEGUNDO NIVEL">SEGUNDO NIVEL</option>
              <option value="TERCER NIVEL">TERCER NIVEL</option>
            </select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left"> 
          	<td class="titulosTabs" width="1%" nowrap valign="">* CÓDIGO DE BARRAS</td> 
            <td valign="">
            <input name="codigo_barrasP" id="codigo_barrasP" type="text" onKeyUp="solo_numeros(this.value, this.name);" class="required">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td class="titulosTabs" width="25%%" valign="bottom" nowrap align="center">PRECIO / TABULADOR</td>
            <td class="titulosTabs" width="25%" valign="bottom" nowrap align="center">LOCAL</td>
            <td class="titulosTabs" width="25%" valign="bottom" nowrap align="center">SUCURSAL</td>
            <td class="titulosTabs" width="" valign="bottom" nowrap align="center">MEMBRESÍA</td>
          </tr>
          <tr>
            <td valign="">$ NORMAL</td>
            <td valign="">
            <input name="precioC" id="precioC" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="">
            <input name="precioC1" id="precioC1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="">
            <input name="precioMe" id="precioMe" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
          </tr>
          <tr>
            <td valign="">$ URGENTE</td>
            <td valign="">
            <input name="precioCurgencia" id="precioCurgencia" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="">
            <input name="precioCurgencia1" id="precioCurgencia1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="">
            <input name="precioMe1" id="precioMe1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
          </tr>
          <tr>
            <td valign="">$ HOSPITAL</td>
            <td valign="">
            <input name="precioH" id="precioH" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="">
            <input name="precioHS" id="precioHS" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
            </td>
            <td valign="">
            <input name="precioHM" id="precioHM" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" class="required" value="">
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

</body>
</html>
