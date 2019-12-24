<div id="ficha_estudio">
<ul id="pestanas">
    <li><a class="tabs" href="#tabs-1">DATOS DEL ESTUDIO</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2">FORMATO</a></li>
</ul>
 <form action="" method="post" name="formEstudio" id="formEstudio" target="_self" style="height:100%;">
 <input name="idEstudioE" type="hidden" id="idEstudioE">
  <div class="miTab" id="tabs-1" style="height:100%;">
    <input name="idUsuarioE" id="idUsuarioE" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3" class="grisecito">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left"> 
          	<td width="">* NOMBRE DEL ESTUDIO</td>
            <td width="350" valign="bottom">ÁREA *</td>
          </tr>
          <tr>
            <td><input name="nombreE" id="nombreE" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
            <td valign="top"><select name="areaE" id="areaE" class="required"></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left">
            <td class="titulosTabs" width="50%" nowrap>* TABULADOR DE MAQUILA($)</td>
            <td class="titulosTabs" nowrap>* TABULADOR DE MAQUILA URGENCIA($)</td>
          </tr>
          <tr>
            <td><input name="precioE" type="text" class="required" id="precioE" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"></td>
            <td style="display:;"><input name="precioUrgenciaE" id="precioUrgenciaE" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"  class="required"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left">
            <td class="titulosTabs" width="50%" nowrap>* TABULADOR DE SUCURSAL($)</td>
            <td class="titulosTabs" nowrap>* TABULADOR DE SUCURSAL URGENCIA($)</td>
          </tr>
          <tr>
            <td><input name="precioE1" type="text" class="required" id="precioE1" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"></td>
            <td style="display:;"><input name="precioUrgenciaE1" id="precioUrgenciaE1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"  class="required"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr style="display:none;">
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL A ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL B ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL C ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL D ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL E ($)</td>
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
  
  <div class="miTab" id="tabs-2">
  	<table width="100%" height="100%" border="0" cellspacing="2" cellpadding="4" class="grisecito">
      <tr align="left"> <td height="1px" nowrap> DISEÑE EL FORMATO DEL ESTUDIO: </td> </tr>
      <tr id="contieneET" align="left"><td colspan="4">
    	<input style="height:90%; resize:none; vertical-align:top;" name="input" id="input" type="text" value="" class="jqte-test">
        <input name="miDiagnostico" id="miDiagnostico" type="hidden">
    </td></tr>
    </table>
  </div>
  
</form>
</div>