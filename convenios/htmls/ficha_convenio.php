<div class="" id="ficha_convenio" style="color:white;">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="90%">
    <ul id="pestanas">
    <li><a class="tabs" href="#tabs-1">BENEFICIO</a></li>
    <li><a class="tabs" id="tabs-2-1" href="#tabs-2">CONCEPTOS</a></li>
	</ul>
	</td>
    <td nowrap>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
      	<td id="bActualizaB"><button id="updateNbeneficio">Actualizar</button></td>
        <td id="bGuardaB"><button id="saveNbeneficio">Guardar</button></td>
        <td><button id="cancelNbeneficio">Cancelar</button></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
 <form action="" method="post" name="formNbeneficio" id="formNbeneficio" target="_self">
 <input name="idBeneficio" type="hidden" id="idBeneficio"> <input name="aleatorioB" type="hidden" id="aleatorioB">
  <div class="miTab" id="tabs-1">
    <input name="idUsuarioB" id="idUsuarioB" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left"> <td class="" width="" style="color:white;">* NOMBRE DEL BENEFICIO</td> </tr>
          <tr>
            <td><input name="nombreB" id="nombreB" type="text" onKeyUp="conMayusculas(this);" class="required" value="" autofocus></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
            <td class="" width="100%" nowrap style="color:white;">DESCRIPCIÓN</td>
          </tr>
          <tr>
            <td style="display:;">
            <textarea name="descripcionB" cols="1" rows="4" id="descripcionB" onKeyUp="conMayusculas(this);" style="resize:none"></textarea>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-2">
  	<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" id="dataTableAB" class="tablilla">
    <thead id="cabecera_tBusquedaAB">
      <tr bgcolor="#FF6633" style="font-size:1em;">
        <th id="clickmeAB" class="" align="center" style="color:white;">#</th>
        <th class="" align="center" style="color:white;">CONCEPTO&nbsp;<button id="asignaConvenio"></button></th>
        <th class="" align="center" style="color:white;">TIPO</th>
        <th class="" align="center" style="color:white;">ÁREA</th>
        <th class="" align="center" style="color:white;">PRECIO($)</th>
        <th class="" align="center" style="color:white;">PRECIO URGENCIA($)</th>
        <th class="" align="center" style="color:white;">CANTIDAD</th>
      </tr>
    </thead>
    <tbody style="text-align:left">
		<tr>
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
  </table>
  </div>
  
</form>
</div>

<div id="buscar_conceptos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr height="50%">
    <td>
    <table width="99%" cellspacing="0" id="dataTableBconceptos" height="100%" border="0" cellpadding="5" class="tablilla">
        <thead id="my_head">
          <tr style="font-size:1.1em;" bgcolor="#FF6633">
            <th id="clickmeCoB" class="" align="center" style="color:white;">ID</th>
            <th class="" align="center" style="color:white;">CONCEPTO</th>
            <th class="" align="center" style="color:white;">TIPO</th>
            <th class="" align="center" style="color:white;">ÁREA</th>
          </tr>
        </thead>
        <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBco" id="mi_pie_tabla" align="center">
            <tr bgcolor="#FF6633" style="color:white;">
                <th><input type="hidden" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;" placeholder="Concepto"></th>
                <th><input type="text" name="textfield3" id="textfield3" style="height:100%; width:100%;" placeholder="Tipo"></th>
                <th><input type="text" name="textfield4" id="textfield4" style="height:100%; width:100%;" placeholder="Área"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionConceptos" style="display:none;"><span style="color:black; text-decoration:underline;">Debe de seleccionar al menos un concepto, dé clic sobre alguno de ellos.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="99%" cellspacing="0" id="dataTableCoSBeneficio" height="100%" border="0" cellpadding="5" class="tablilla">
        <thead id="my_head">
          <tr style="font-size:1.1em;" bgcolor="#FF6633">
          	<th id="clickmeCoSB" class="" align="center" style="color:white;">#</th>
            <th class="" align="center" style="color:white;">CONCEPTO</th>
            <th class="" align="center" style="color:white;">TIPO</th>
            <th class="" align="center" style="color:white;">ÁREA</th>
            <th class="" align="center" style="color:white;">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    </td>
  </tr>
</table>
</div>

<div id="editPrecios">
<form action="" method="post" name="formEditPrecios" id="formEditPrecios" target="_self" style="width:100%; height:100%">
<input name="idUsuarioEP" id="idUsuarioEP" class="" type="hidden" value=""> 
<input name="idAC" id="idAC" class="" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Indique los precios normal y de urgencia del concepto para el beneficio.</td>
  </tr>
  <tr class="">
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td class="" width="1%" valign="bottom" nowrap style="color:;">Precio de beneficio($)*</td>
        <td valign="top" align="left">
        	<input style="text-align:right;" name="precioB" type="text" class="required" id="precioB" onKeyUp="numeros_decimales(this.value, this.name);" value="" maxlength="10">
        </td>
      </tr>
      <tr align="left">
        <td class="" width="1%" valign="bottom" nowrap style="color:;">Precio de beneficio urgencia($)*</td>
        <td valign="top" align="left">
        	<input style="text-align:right;" name="precioBu" type="text" class="required" id="precioBu" onKeyUp="numeros_decimales(this.value, this.name);" value="" maxlength="10">
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editCantidad">
<form action="" method="post" name="formEditCantidad" id="formEditCantidad" target="_self" style="width:100%; height:100%">
<input name="idUsuarioEC" id="idUsuarioEC" class="" type="hidden" value=""> 
<input name="idAC" id="idAC" class="" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Indique el número de este concepto para el beneficio.</td>
  </tr>
  <tr class="">
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td class="" width="1%" valign="bottom" nowrap style="color:;" valign="top">Cantidad de conceptos*</td>
        <td valign="top" align="left">
        	<select name="cantidadC" id="cantidadC" class="required">
        	  <option value="">-SELECCIONAR-</option>
        	  <option value="100">INDEFINIDAS</option>
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
        	</select>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>