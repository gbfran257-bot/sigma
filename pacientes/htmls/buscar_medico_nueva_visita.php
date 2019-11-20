<div id="visita" style="width:100%; height:99%;">

<table id="tablaContenedoraTablaBuscarMedico" width="100%">
  <tr>
    <td><table id="tabla_buscar_medico" class="ui-widget-content tablaBordesSuperioresRedondeados" width="100%" cellpadding="0">
  <tr>
    <td width="10%" class="t3">Médico</td>
    <td><button name="b_buscarm_o" id="b_buscarm_o" class="b_bme"></button>
    </td>
  </tr>
		</table>
</td>
  </tr>
</table>

<div id="div_datos_medico" align="center">

<table class="miTablaSeleccion tablaBordesRedondeados ui-widget-content" id="miTablaMedicoSeleccionado">
  <tr>
  	<td colspan="3" class="ui-widget-header1 tituloT" align="center" nowrap style="background-color:black; color:white;">
    	<table width="100%" cellpadding="0" cellspacing="0">
		  <tr>
		    <td width="42%" align="right"><button name="b_cambiarm_o" id="b_cambiarm_o" class="b_bme"></button></td>
		    <td align="left">&nbsp;MÉDICO</td>
            <td width="42%" align="right"><button name="b_eliminarEstudios" id="b_eliminarEstudios" class="b_bme" style="display:none;"></button></td>
		  </tr>
		</table>
    </td>
  </tr>
  <tr class="" style="background-color:#CCC;">
    <td class="titulosTabla3">Clave</td>
    <td class="titulosTabla3">Nombre</td>
    <td class="titulosTabla3">Especialidad</td>
  </tr>
  <tr>
    <td class=""><span id="mi_dato_clave_m"></span></td>
    <td class=""><span id="mi_dato_nombre_m"></span></td>
    <td class=""><span id="mi_dato_especialidad_m"></span></td>
  </tr>
</table>
</div>

<table id="tablaContenedoraBuscarEstudios" width="100%">
  <tr>
    <td><table id="tabla_buscar_estudios" class="ui-widget-content tablaBordesInferioresRedondeados" width="100%">
  			<tr>
    			<td width="10%" class="t3">Estudios</td>
    			<td><button name="b_agregar_e" id="b_agregar_e" class="b_bme"></button></td>
  			</tr>
		</table>
	</td>
  </tr>
</table>

<div id="div_datos_estudios" align="center">
<table width="99.8%" class="miTablaSeleccion ui-widget-content" id="mi_tabla_estudios">
  <tr>
  	<td colspan="5" class="ui-widget-header tituloT">
    	<table width="100%" cellpadding="0" cellspacing="0">
  			<tr>
    			<td width="46%" align="right"><button name="b_modificar_e" id="b_modificar_e" class="b_bme"></button></td>
    			<td>&nbsp;ESTUDIOS</td>
  			</tr>
		</table>
    </td>
  </tr>
  <tr id="cabecera_tabla_estudios" class="">
    <td class="titulosTabla3">#Est</td>
    <td class="titulosTabla3">Clave</td>
    <td class="titulosTabla3">Descripción</td>
    <td class="titulosTabla3">Departamento</td>
    <td class="titulosTabla3">Precio</td>
  </tr>
  <tr id="celda_maestra_est" class="celda_maestra_est">
    <td class=""></td>
    <td class=""></td>
    <td class=""></td>
    <td class=""></td>
    <td class=""></td>
  </tr>
</table>

<table width="100%" cellspacing="0" class="ui-widget-content" id="tablaTotalEstudiosE">
  <tr>
    <td class="ui-widget-header SubtitulosTabla">Subtotal($)</td>
    <td class="ui-widget-header SubtitulosTabla">Descuento/C($)</td>
    <td class="ui-widget-header SubtitulosTabla">Descuento/A($)</td>
    <td class="ui-widget-header SubtitulosTabla">Urgencia($)</td>
    <td class="ui-widget-header SubtitulosTabla">Toma/Dom($)</td>
    <td class="ui-widget-header SubtitulosTabla">EntregaDom($)</td>
    <td class="ui-widget-header SubtitulosTabla">Total($)</td>
  </tr>
  <tr><input name="urgenciaH" type="hidden" value="" id="urgenciaH"><input name="tomaDomicilioH" type="hidden" value="" id="tomaDomicilioH">
  		<input name="entregaDomH" type="hidden" value="" id="entregaDomH"><input name="descuentoH" type="hidden" value="" id="descuentoH">
        <input name="subTotalEH" type="hidden" value="" id="subTotalEH">
    <td><input name="box_subtotal_estudios_e" id="box_subtotal_estudios_e" class="box_resultado" type="text" readonly></td>
    <td><input name="box_descuentoConvenio_e" type="text" class="box_resultado" id="box_descuentoConvenio_e" value="0" readonly ></td>
    <td><input name="box_descuentoAdicional_e" type="text" class="box_resultado" id="box_descuentoAdicional_e" value="0" readonly ></td>
    <td><input name="box_urgencia_e" type="text" class="box_resultado" id="box_urgencia_e" value="0" ></td>
    <td><input name="box_tomaDom_e" type="text" class="box_resultado" id="box_tomaDom_e" value="0" ></td>
    <td><input name="box_entregaDom_e" type="text" class="box_resultado" id="box_entregaDom_e" value="0" ></td>
    <td><input name="box_total_e" id="box_total_e" class="box_resultado textRed" type="text" readonly></td>
  </tr>
</table>

</div>

<div class="datos1_o" id="datos1_o">
<table width="100%">
  <tr>
    <td width="8%">FechaEntrega</td>
    <td width="8%"><input class="ui-widget-content camposUi" name="c_fechae_o" id="c_fechae_o" type="text" readonly value="<?php echo date("d/m/Y"); ?>"></td>
    <td align="left" width="8%">
    	<input class="camposUi" name="horaEntrega" id="horaEntrega" type="text" readonly value="18:00">     
    <td width="10%">Observaciones</td>
    <td valign="top" width="90%">
	    <input class="camposUi" name="c_observaciones_o" id="c_observaciones_o" onKeyUp="conMayusculas(this);" type="text"></td>
    </td>
  </tr>
  <tr>
    <td nowrap>Descuento(%)</td>
    <td nowrap="nowrap" colspan="2" valign="middle" width="10%">
		<input name="descuentoAdicional" type="text" id="descuentoAdicional" value="0" size="3" onKeyUp="solo_numeros(this.value, this.name);" maxlength="3" class="campoUIc">
    </td>
    <td><span class="notaDescuentoE">NOTA:</span></td>
    <td><span class="notaDescuentoE"><input name="notaDescuentoE" type="text" onKeyUp="conMayusculas(this);" id="notaDescuentoE"class="campoUIc"></span></td>
  </tr>
</table>

</div>

</div>

<div id="buscar_medico">
	<input name="clave_medico_E" id="clave_medico_E" type="hidden" value="">
    <div class="botonesBME" id="botonesBME">
    <table width="100%">
      <tr>
        <td><img id="reseteBME" src="../imagenes/botones/_buscar.png" width="" height="37"></td>
        <td><img id="addMedicoBME" src="../imagenes/botones/_agregar.png" width="" height="37"></td>
      </tr>
    </table>
</div>
  
    <table width="100%" cellspacing="0" id="dataTableBME">
    <thead id="my_headBME">
      <tr>
        <th>CLAVE</th>
        <th>NOMBRE</th>
        <th>APATERNO</th>
        <th>AMATERNO</th>
        <th>ESPECIALIDAD</th>
     	<th>SELECT</th>
      </tr>
    </thead>
    <tbody>
		<tr>
        	<input name="mi_clave_m" id="mi_clave_m" type="hidden" value="">
            <input name="mi_nombre_m" id="mi_nombre_m" type="hidden" value="">
            <input name="mi_especialidad_m" id="mi_especialidad_m" type="hidden" value="">
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
    <tfoot class="pieTablaBM" id="mi_pie_tabla">
        <tr>
            <td><input type="text" name="textfield1" id="textfield1" value=""></td>
            <td><input type="text" name="textfield2" id="textfield2" value=""></td>
            <td><input type="text" name="textfield3" id="textfield3" value=""></td>
            <td><input type="text" name="textfield4" id="textfield4" value=""></td>
            <td><input type="text" name="textfield5" id="textfield5" value=""></td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
  </table>
  <div id="div_falta_m" class="falta_s"></div>
</div>