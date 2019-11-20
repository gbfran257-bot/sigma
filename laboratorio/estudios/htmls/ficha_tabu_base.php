<div id="ficha_estudio">
 <form action="" method="post" name="formEstudio" id="formEstudio" target="_self" style="width:99%; height:100%;">
 <input name="idEstudioE" type="hidden" id="idEstudioE">
    <input name="idUsuarioE" id="idUsuarioE" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="3" cellpadding="1" class="fondoDataT">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left"> <td width="">* NOMBRE DEL ESTUDIO</td> </tr>
          <tr>
            <td><input name="nombreE" id="nombreE" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
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
            <td><input name="precioUrgenciaE" id="precioUrgenciaE" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"  class="required"></td>
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
            <td><input name="precioUrgenciaE1" id="precioUrgenciaE1" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);"  class="required"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2" height="100%">
          <tr align="left">
            <td width="" valign="bottom">* ÁREA</td>
            <td width="200px" valign="bottom">* DÍAS DE ENTREGA</td>
          </tr>
          <tr>
            <td valign="top"><select name="areaE" id="areaE" class="required"></select></td>
            <td valign="top">
            	<select name="dEntregaE" id="dEntregaE" class="required">
            	  <option value="">-SELECCIONAR-</option>
            	  <option value="0">MISMO DÍA</option>
            	  <option value="1">1</option>
            	  <option value="2">2</option>
            	  <option value="3">3</option>
            	  <option value="4">4</option>
            	  <option value="5">5</option>
            	  <option value="6">6</option>
            	  <option value="7">7</option>
            	  <option value="8">8</option>
            	  <option value="9">9</option>
            	  <option value="10">10</option>
            	  <option value="11">11</option>
            	  <option value="12">12</option>
            	  <option value="13">13</option>
            	  <option value="14">14</option>
            	  <option value="15">15</option>
            	  <option value="16">16</option>
            	  <option value="17">17</option>
            	  <option value="18">18</option>
            	  <option value="19">19</option>
            	  <option value="20">20</option>
            	  <option value="21">21</option>
            	  <option value="22">22</option>
            	  <option value="23">23</option>
            	  <option value="24">24</option>
            	  <option value="25">25</option>
            	  <option value="26">26</option>
            	  <option value="27">27</option>
            	  <option value="28">28</option>
            	</select>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr style="display:none;">
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2" height="100%">
          <tr align="left">
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL A ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL B ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL C ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL D ($)</td>
            <td width="25%" valign="bottom" nowrap>PRECIO NIVEL E ($)</td>
          </tr>
          <tr>
            <td valign="top">
            <input name="precioNa" id="precioNa" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="">
            </td>
            <td valign="top">
            <input name="precioNb" id="precioNb" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="">
            </td>
            <td valign="top">
            <input name="precioNc" id="precioNc" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="">
            </td>
            <td valign="top">
            <input name="precioNd" id="precioNd" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="">
            </td>
            <td valign="top">
            <input name="precioNe" id="precioNe" type="text" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
</form>
</div>
