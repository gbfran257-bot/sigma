<div id="ficha_estudio">
<ul id="pestanas">
    <li><a class="tabs" href="#tabs-1">DATOS DEL ESTUDIO</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2">BASES</a></li>
</ul>
 <form action="" method="post" name="formEstudio" id="formEstudio" target="_self" style="width:99%; height:100%;">
 <input name="idEstudioE" type="hidden" id="idEstudioE">
  <div class="miTab" id="tabs-1">
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
            <td width="25%" nowrap>* PRECIO($)</td>
            <td nowrap width="25%">* PRECIO DE URGENCIA($)</td>
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
        <table width="100%" border="0" cellspacing="2" cellpadding="2" height="100%">
          <tr align="left">
            <td width="" valign="bottom">* ÁREA</td>
            <td width="200px" valign="bottom">* DÍAS DE ENTREGA</td>
            <td width="50%" valign="bottom">* SUCURSAL</td>
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
            <td valign="top"><select name='miSucursalNS' class="required" id='miSucursalNS'></select></td>
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
  </div>
  
  <div class="miTab" id="tabs-2">
  	<input name="aleatorioB" type="hidden" id="aleatorioB">
  	<table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTableBBE" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal1">
      <tr id="mymy" class="titulos_dataceldas">
      	<th id="clickmeBBE" align="center" width="20px">#</th>
        <th>
        	BASES
            <button class="botonBa" id="bBaseE">Buscar las bases para el estudio</button>
        </th>
        <th>AREA</th>
        <th>UNIDAD</th>
      </tr>
    </thead>
    <tbody style="color:black"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
</form>
</div>

<div id="buscar_basesE">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="tablilla">
  <tr height="50%">
    <td>
    <table width="100%" cellspacing="1" id="dataTableBbasesE" height="100%" border="0" cellpadding="0">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
            <th id="clickmeBasesE" align="center" width="20px">ID</th>
            <th align="center">
            	BASE <!--<button class="botonBase" id="editMetodoB">EDITAR LOS MÉTODOS DE LAS BASES</button> -->
            </th>
            <th align="center">ÁREA</th>
            <th align="center">UNIDAD</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBbaseE" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="hidden" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <th>
                <input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;" placeholder="-Nombre de la base-">
                </th>
                <th>
                <input type="text" name="textfield3" id="textfield3" style="height:100%; width:100%;" placeholder="-Área-">
                </th>
                <th>
                <input type="text" name="textfield4" id="textfield4" style="height:100%; width:100%;" placeholder="-Unidad-">
                </th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionBases" style="display:none;"><span style="color:black; text-decoration:underline;">Debe de seleccionar al menos una base, dé clic sobre una de ellas.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellspacing="1" id="dataTableBasesSE" height="100%" border="0" cellpadding="0" class="tablilla" style="top:10px;">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
          	<th id="clickmeBBasB" align="center" width="20px">#</th>
            <th align="center">BASE</th>
            <th align="center">ÁREA</th>
            <th align="center">UNIDAD</th>
            <th align="center" width="100px">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="basesSeleccionadosE">
    	<table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="100%" align="left"><span style="color:black; text-decoration:underline;">Bases seleccionadas.</span></td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
</table>
</div>