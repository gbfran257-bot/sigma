<div id="fichaBase">
	
 <div>
    <table width="100%" border="0" cellspacing="0" cellpadding="1" style="float:right;">
      <tr>
      	<td width="97%">
        <ul id="pestanas">
            <li>
            <a class="tabs" id="tabs-1-1" href="#tabs-1">GENERALES</a>
            </li>
            <li><a class="tabs" id="tabs-2-1" href="#tabs-2">MUESTRAS</a></li>
            <li><a class="tabs" id="tabs-3-1" href="#tabs-3">MÉTODOS</a></li>
            <li><a class="tabs" id="tabs-4-1" href="#tabs-4">INDICACIONES</a></li>
            <li><a class="tabs" id="tabs-5-1" href="#tabs-5">REFERENCIAS</a></li>
            <li><a class="tabs" id="tabs-6-1" href="#tabs-6">CONSUMIBLES</a></li>
        </ul>
        </td>
        <td width="1%" nowrap>
        	<button class="botonBa ui-button ui-widget ui-corner-all" id="guardarNuevaBase">
            <span class="ui-icon ui-icon-disk"></span> Guardar
            </button>
        </td>
        <td width="1%" nowrap>
        	<button class="botonBa ui-button ui-widget ui-corner-all" id="actualizarBase">
            <span class="ui-icon ui-icon-refresh"></span> Actualizar
            </button>
        </td>
        <td width="1%" nowrap>
        	<button class="botonBa ui-button ui-widget ui-corner-all" id="cancelarGuardarBase">
            <span class="ui-icon ui-icon-cancel"></span> Cancelar
            </button>
        </td>        
      </tr>
    </table>
 </div>
 <form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
 <input name="idPacienteN" type="hidden" id="idPacienteN"> <input name="aleatorioB" type="hidden" id="aleatorioB">
  <div class="miTab" id="tabs-1">
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="<?php echo $row_usuario['id_u']; ?>">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left"> <td width="" nowrap>* NOMBRE DE LA BASE</td> </tr>
          <tr>
            <td><input name="nombreP" id="nombreP" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <input name="id_areaB" id="id_areaB" type="hidden" value="">
        <input name="id_areaBT" type="hidden" value="" id="id_areaBT">
        <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
          <tr align="left">
            <td width="50%" valign="bottom" nowrap>DEPARTAMENTO</td>
            <td width="" valign="bottom" nowrap>
            	* ÁREA
                <button class="botonBa" id="bAreaB">Buscar la unidad de medida</button>
            </td>
          </tr>
          <tr>
            <td valign="top"><select name="departamentoE" id="departamentoE" class="required"></select></td>
            <td valign="top">
                <input name="areaB" id="areaB" type="text" readonly>
                <input name="areaBT" type="hidden" value="" id="areaBT">
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
            <td width="" nowrap>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>
                	* UNIDAD MEDIDA DEL RESULTADO <button class="botonBa" id="bUnidadM">Buscar la unidad de medida</button>
                </td>
                <td align="right" width="40px"> </td>
              </tr>
            </table>
            </td>
            <td width="190px" nowrap>($) DE PRODUCCIÓN</td>
          </tr>
          <tr>
            <td>
            	<input name="id_umBase" id="id_umBase" type="hidden" value="">
              	<input name="idUMbaseT" type="hidden" value="" id="idUMbaseT">
              	<input name="idUsadaConsulta" type="hidden" value="" id="idUsadaConsulta">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td>
                    <input name="unidadMedidaR1" id="unidadMedidaR1" type="text" readonly>
                    <input name="unidadMedidaRT" type="hidden" value="" id="unidadMedidaRT">
                </td>
                <td width="100px">
                    <input style="text-align:center;" name="abreviacionUMT1" id="abreviacionUMT1" type="text" readonly>
                    <input name="abreviacionUMT" type="hidden" value="" id="abreviacionUMT">
                </td>
              </tr>
            </table>
            </td>
            <td><input name="precioP" type="text" class="required" id="precioP" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" maxlength="7" readonly value="" style="text-align:center;"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr align="left">
          	<td><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="" nowrap align="left" width="">
                    EQUIPO CON EL QUE SE REALIZA LA BASE 
                    <button class="botonBa" id="bEquipoB">Buscar el equipo</button>
                </td> 
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>
            	<input name="id_equipoMu" id="id_equipoMu" type="hidden" value="">
              	<input name="idEquipoMuT" type="hidden" value="" id="idEquipoMuT">
                <input name="equipoMuT" type="hidden" value="" id="equipoMuT">    
                <input name="equipoMu1" id="equipoMu1" type="text" readonly>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-2">
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr id="contieneMuB" align="left"><td>
      
    	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" id="dataTableMuestras" class="tablilla">
            <thead id="cabecera_tBusquedaMuestras">
              <tr class="titulos_dataceldas">
                <th id="clickmeMu" align="center" width="20px">#</th>
                <th align="center">
                	MUESTRAS 
                	<button class="botonBase" id="editMuestraB">EDITAR LAS MUESTRAS PARA LA BASE</button>
                </th>
                <th align="center">CONDICIÓN DE LA MUESTRA</th>
              </tr>
            </thead>
            <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        </table>
  
    </td></tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-3">
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr id="contieneMeB" align="left"><td>
      
    	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" id="dataTableMetodos" class="tablilla">
            <thead id="cabecera_tBusquedaMetodos">
              <tr class="titulos_dataceldas">
                <th id="clickmeMet" align="center" width="20px">#</th>
                <th align="center">
                	MÉTODOS
                    <button class="botonBase" id="editMetodosB">EDITAR LOS MÉTODOS PARA LA BASE</button>
                </th>
              </tr>
            </thead>
            <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        </table>
  
    </td></tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-4">
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr id="contieneInB" align="left"><td>
      
    	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" id="dataTableIndicaciones" class="tablilla">
            <thead id="cabecera_tBusquedaIndicaciones">
              <tr class="titulos_dataceldas">
                <th id="clickmeIn" align="center" width="20px">#</th>
                <th align="center">
                	INDICACIÓN
                    <button class="botonBase" id="editIndicacionB">EDITAR LAS INDICACIONES PARA LA BASE</button>
                </th>
              </tr>
            </thead>
            <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        </table>
  
    </td></tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-5">
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr id="contieneVrB" align="left"><td>
      
    	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" id="dataTableReferencias" class="tablilla">
            <thead id="cabecera_tBusquedaReferencias">
              <tr class="titulos_dataceldas">
                <th id="clickmeRe" align="center" width="20px">#</th>
                <th align="center" nowrap>
                	NOMBRE
                </th>
                <th align="center">
                	VALOR DE REFERENCIA
                    <button class="botonBase" id="editReferenciasB">EDITAR LOS VALORES DE REFERENCIA PARA LA BASE</button>
                </th>
                <th align="center">PARA</th>
                <th align="center" nowrap>EDADES</th>
              </tr>
            </thead>
            <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        </table>
  
    </td></tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-6">
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr id="contieneCoB" align="left"><td>
      
  	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" id="dataTableConsumibles" class="tablilla">
        <thead id="cabecera_tBusquedaConsumibles">
          <tr class="titulos_dataceldas">
            <th id="clickmeCo" align="center" width="20px">#</th>
            <th align="center">
            	CONSUMIBLE
                <button class="botonBase" id="editConsumiblesB">EDITAR LOS CONSUMIBLES PARA LA BASE</button>
            </th>
            <th align="center">TIPO</th>
            <th align="center">UNIDAD</th>
            <th align="center">PRESENTACIÓN</th>
            <th align="center">CANTIDAD</th>
            <th align="center" nowrap>PRECIO($)</th>
          </tr>
        </thead>
        <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    </table>
    
    </td></tr>
    </table>
  </div>
    
</form>
</div>

<div id="buscar_muestras">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="50%">
    <td>
    <table width="100%" cellspacing="1" id="dataTableBmuestrasB" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
            <th id="clickmeMSB" align="center" width="20px">ID</th>
            <th align="center">
            	MUESTRAS
                <button class="botonBase" id="editMuestrasB">EDITAR LAS MUESTRAS</button>
            </th>
            <th align="center">
            	CONDICIÓN DE LA MUESTRA
            </th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBmB" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="hidden" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionMuestras" style="display:none;"><span class="alerta_texto">Debe de seleccionar al menos una muestra, dé clic sobre una de ellas.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellspacing="1" id="dataTableMSBase" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
          	<th id="clickmeBMB" align="center" width="20px">#</th>
            <th align="center">MUESTRAS SELECCIONADAS</th>
            <th align="center">CONDICIÓN DE LA MUESTRA</th>
            <th align="center">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="muestrasSeleccionadosB">
    	<table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="100%" align="left" nowrap>
            	<span style="color:black; text-decoration:underline;">Muestras seleccionadas.</span>
            </td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
</table>
</div>

<div id="nuevaMuestra">
<form action="" method="post" name="formNuevaMuestra" id="formNuevaMuestra" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNMu" id="idUsuarioNMu" class="idUsuarioNM" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" id="textoAddMuestra" align="left">
    	Para dar de alta una nueva muestra en la base de datos, indique los siguientes datos
    </td>
  </tr>
  <tr>
    <td nowrap width="250px" align="left">* Nombre de la muestra</td>
    <td><input name="nombreM" id="nombreM" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
  </tr>
  <tr>
    <td nowrap width="250px" align="left">
    	* Condición de la muestra 
        <button id="addCondicion1">Agregar una nueva condición para la muestra</button>
    </td>
    <td><select name="condicionM" id="condicionM" class="required"></select></td>
  </tr>
</table>
</form>
</div>

<div id="nuevoMetodo">
<form action="" method="post" name="formNuevoMetodo" id="formNuevoMetodo" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNM" id="idUsuarioNM" class="idUsuarioNM" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoMetodo">
    	Para dar de alta un nuevo método en la base de datos, indique lo siguiente
    </td>
  </tr>
  <tr>
    <td nowrap width="220px" align="left">Nombre del método *</td>
    <td><input name="nombreM" id="nombreM" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
  </tr>
</table>
</form>
</div>

<div id="buscar_metodos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="50%">
    <td>
    <table width="100%" cellspacing="1" id="dataTableBmetodosB" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
            <th id="clickmeMeSB" align="center" width="20px">ID</th>
            <th align="center">
            	MÉTODO
                <button class="botonBase" id="editMetodoB">EDITAR LOS MÉTODOS DE LAS BASES</button>
            </th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBmeB" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="hidden" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionMetodos" style="display:none;"><span class="alerta_texto">Debe de seleccionar al menos un método, dé clic sobre uno de ellos.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellspacing="1" id="dataTableMeSBase" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
          	<th id="clickmeBMeB" align="center" width="20px">#</th>
            <th align="center">MÉTODO</th>
            <th align="center" width="100px">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="muestrasSeleccionadosB">
    	<table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="100%" align="left"><span style="color:black; text-decoration:underline;">Métodos seleccionados.</span></td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
</table>
</div>

<div id="buscar_indicaciones">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="50%">
    <td>
    <table width="100%" cellspacing="1" id="dataTableBindicacionesB" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
            <th id="clickmeImSB" align="center" width="20px">ID</th>
            <th align="center">
            	INDICACIONES
                <button class="botonBase" id="editIndicaciones">EDITAR LAS INDICACIONES DE LAS BASES</button>
            </th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBmeB" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="hidden" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionIndicaciones" style="display:none;"><span class="alerta_texto">Debe de seleccionar al menos una indicación, dé clic sobre una de ellas.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellspacing="1" id="dataTableInSBase" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
          	<th id="clickmeBInB" align="center" width="20px">#</th>
            <th align="center">INDICACIÓN</th>
            <th align="center" width="20px">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="muestrasSeleccionadosB">
    	<table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="100%" align="left">
            	<span style="color:black; text-decoration:underline;">Indicaciones seleccionadas.</span>
            </td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
</table>
</div>

<div id="nuevaIndicacion">
<form action="" method="post" name="formNuevaIndicacion" id="formNuevaIndicacion" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNM" id="idUsuarioNM" class="idUsuarioNM" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoIndicacion">
    	Para dar de alta una nueva indicación en la base de datos, indique lo siguiente
    </td>
  </tr>
  <tr>
    <td nowrap width="200px" align="left" valign="top">* Describa la indicación</td>
    <td><textarea onKeyUp="conMayusculas(this);" class="required" name="nombreM" id="nombreM" cols="1" rows="3" style="resize:none; height:100px;"></textarea></td>
  </tr>
</table>
</form>
</div>

<div id="nuevoConsumible">
<form action="" method="post" name="formNuevoConsumible" id="formNuevoConsumible" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNM" id="idUsuarioNM" class="idUsuarioNM" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" id="textoConsumible" align="left">
    	Para dar de alta un nuevo consumible en la base de datos, indique los siguientes datos
    </td>
  </tr>
  <tr>
    <td nowrap width="50px" align="left" valign="top">* Nombre</td>
    <td>
    	<input name="nombreC" id="nombreC" type="text" onKeyUp="conMayusculas(this);" class="required" value="">
    </td>
  </tr>
  <tr>
    <td nowrap width="" align="left" valign="top">Descripción</td>
    <td><textarea onKeyUp="conMayusculas(this);" name="descripcionC" id="descripcionC" cols="1" rows="2" style="resize:none; height:70px;"></textarea></td>
  </tr>
  <tr>
    <td width="100%" colspan="2">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
          	<td width="50%">
            	<input name="id_tipoCosumible" id="id_tipoCosumible" type="hidden" value="">
              	<input name="id_tipoCosumibleT" type="hidden" value="" id="id_tipoCosumibleT">
            	<table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>                  
                    <td nowrap width="90px" align="left" valign="top">
                    	* Tipo
                        <button class="botonBa" id="bTipoCo">Buscar el tipo de consumible</button>
                    </td>
            		<td>
                    	<input name="tipoC1" id="tipoC1" type="text" class="required" value="" readonly>
                        <input name="tipoC1T" type="hidden" value="" id="tipoC1T">
                    </td>
                  </tr>
                </table>
            </td>
            <td width="50%">
            	<input name="id_umBasex" id="id_umBasex" type="hidden" value="">
              	<input name="idUMbaseTx" type="hidden" value="" id="idUMbaseTx">
            	<table width="100%" border="0" cellspacing="2" cellpadding="0">
                  <tr>
                    <td nowrap width="120px" align="left" valign="top">
                    	&nbsp;* Unidad
                        <button class="botonBa" id="bUnidadCo">Buscar la unidad del consumible</button>
                    </td>
            		<td>
                    	<input name="unidadMedidaRTx" type="hidden" value="" id="unidadMedidaRTx">
                    	<input name="unidadC1" id="unidadC1" type="text" class="required" value="" readonly>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
       </table> 
    </td>
  </tr>
  <tr>
    <td nowrap width="1%" align="left" valign="top">
    	<input name="id_presentacionCosumible" id="id_presentacionCosumible" type="hidden" value="">
        <input name="id_presentacionCosumibleT" type="hidden" value="" id="id_presentacionCosumibleT">
                
    	* Presentación
        <button class="botonBa" id="bPresentacionCo">Buscar la presentación del consumible</button>
    </td>
    <td>
    	<input name="presentacionC1" id="presentacionC1" type="text" class="required" value="" readonly>
        <input name="presentacionC1T" type="hidden" value="" id="presentacionC1T">
    </td>
  </tr>
</table>
</form>
</div>

<div id="buscar_consumibles">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="50%">
    <td>
    <table width="100%" cellspacing="1" id="dataTableBconsumiblesB" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
            <th id="clickmeCoSB" align="center" width="20px">ID</th>
            <th align="center">
            	CONSUMIBLE
                <button class="botonBase" id="editConsumibles">EDITAR LOS CONSUMIBLES DE LAS BASES</button>
            </th>
            <th align="center">TIPO</th>
            <th align="center">UNIDAD</th>
            <th align="center">PRESENTACIÓN</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBmeB" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="hidden" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield3" id="textfield3" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield4" id="textfield4" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield5" id="textfield5" style="height:100%; width:100%;"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionConsumibles" style="display:none;"><span class="alerta_texto">Debe de seleccionar al menos un consumible, dé clic sobre uno de ellos.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellspacing="1" id="dataTableCoSBase" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
          	<th id="clickmeBCoB" align="center" width="20px">#</th>
            <th align="center">CONSUMIBLE</th>
            <th align="center">TIPO</th>
            <th align="center">UNIDAD</th>
            <th align="center">PRESENTACIÓN</th>
            <th align="center" width="20px">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="muestrasSeleccionadosB">
    	<table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="100%" align="left"><span style="color:black; text-decoration:underline;">Consumibles seleccionados.</span></td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
</table>
</div>

<div id="buscar_referencias">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="50%">
    <td>
    <table width="100%" cellspacing="1" id="dataTableBreferenciasB" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
            <th id="clickmeVRefe" align="center" width="20px">ID</th>
            <th align="center">VALOR DE REFERENCIA</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBmeB" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="hidden" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <!--<th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;"></th> -->
                <th><input type="text" name="textfield3" id="textfield3" style="height:100%; width:100%;"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionReferencias" style="display:none;"><span class="alerta_texto">Debe de seleccionar al menos un valor de referencia, dé clic sobre alguna de ellas.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellspacing="1" id="dataTableReSBase" height="100%" border="0" cellpadding="0" class="tablilla">
        <thead id="my_head">
          <tr class="titulos_dataceldas">
          	<th id="clickmeBReB" align="center" width="20px">#</th>
            <!--<th align="center">VALOR DE REFERENCIA</th> -->
            <th align="center">VALOR DE REFERENCIA</th>
            <th align="center" width="20px">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="referenciasSeleccionadasB">
    	<table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr>
            <td width="100%" align="left"><span style="color:black; text-decoration:underline;">Referencias seleccionadas.</span></td>
          </tr>
        </table>
    </div>
    </td>
  </tr>
</table>
</div>

<div id="nuevaReferencia">
<form action="" method="post" name="formNuevaReferencia" id="formNuevaReferencia" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNM" id="idUsuarioNM" class="idUsuarioNM" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoAddReferencia">
    	Para dar de alta un nuevo valor de referencia en la base de datos, indique los siguientes datos
    </td>
  </tr>
  <tr>
    <td nowrap width="1%" align="left" valign="top">* Nombre del valor de referencia</td>
    <td><input name="nombreC" id="nombreC" type="text" onKeyUp="conMayusculas(this);" class="required" value=""></td>
  </tr>
  <tr>
    <td nowrap width="1%" align="left" valign="top">* Tipo del valor de referencia</td>
    <td><select name="tipoC" id="tipoC" class="required"></select></td>
  </tr>
  <tr>
    <td nowrap width="1%" align="left" valign="top">Descripción</td>
    <td><textarea onKeyUp="conMayusculas(this);" name="descripcionC" id="descripcionC" cols="1" rows="3" style="resize:none; height:100px;"></textarea></td>
  </tr>
</table>
</form>
</div>

<div id="nuevoEquipo">
<form action="" method="post" name="formNuevoEquipo" id="formNuevoEquipo" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNM" id="idUsuarioNM" class="idUsuarioNM" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoEquipo">Para dar de alta un nuevo equipo en la base de datos, indique lo siguiente.</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="50%" valign="bottom" nowrap>* Modelo del equipo</td>
        <td width="" valign="bottom" nowrap>* Marca del equipo</td>
      </tr>
      <tr>
        <td valign="top">
        	<input name="modeloE" id="modeloE" type="text" onKeyUp="conMayusculas(this);" class="required" value="">
        </td>
        <td valign="top">
        	<input name="marcaE" id="marcaE" type="text" onKeyUp="conMayusculas(this);" class="required" value="">
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td nowrap width="190px" align="left" valign="top">Descripción del equipo </td>
    <td>
    <textarea onKeyUp="conMayusculas(this);" name="descripcionE" id="descripcionE" cols="1" rows="3" style="resize:none;height:100px;"></textarea>
    </td>
  </tr>
</table>
</form>
</div>

<div id="nuevaArea">
<form action="" method="post" name="formNuevaArea" id="formNuevaArea" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNA" id="idUsuarioNA" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoArea">Para dar de alta una nueva área en la base de datos, indique lo siguiente</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="" valign="bottom" nowrap>* Área del departamento de laboratorio</td>
        <td width="150px" valign="bottom" nowrap>* Clave del área</td>
      </tr>
      <tr>
        <td valign="top">
        	<input name="areaE1" id="areaE1" type="text" onKeyUp="conMayusculas(this);" class="required" value="">
        </td>
        <td valign="top">
        	<input name="claveE1" type="text" class="required" id="claveE1" onKeyUp="conMayusculas(this);" value="" maxlength="3">
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editarPara">
<form action="" method="post" name="formEditarPara" id="formEditarPara" target="_self" style="width:100%; height:100%">
<input name="idUsuarioUP" id="idUsuarioUP" type="hidden" value=""> <input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Eliga el sexo al cuál va orientado el valor de referencia.</td>
  </tr>
  <tr align="left">
    <td width="1%" valign="top" nowrap>Sexo *</td>
    <td width="" valign="bottom" nowrap>
        <select name="sexoEP" id="sexoEP" class="required">
          <option value="" selected>-SELECCIONAR-</option>
          <option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option>
          <option value="MUJERES">MUJERES</option>
          <option value="HOMBRES">HOMBRES</option>
        </select>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editEdades" style="height:100%;">
<form action="" method="post" name="formEditEdades" id="formEditEdades" target="_self" style="width:100%; height:100%">
<input name="idUsuarioUE" id="idUsuarioUE" type="hidden" value=""> <input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="">
  <tr>
    <td colspan="2" align="left">Eliga el tipo de edad al cuál va orientado el valor de referencia.</td>
  </tr>
  <tr align="left">
    <td width="1%" valign="top" nowrap>* Tipo de edad</td>
    <td width="" valign="top" nowrap align="left">
        <select name="tipoEdad" id="tipoEdad" class="required">
          <option value="" selected="selected">-SELECCIONAR-</option>
          <option value="TODAS LAS EDADES">TODAS LAS EDADES</option>
          <option value="RANGO DE EDAD">RANGO DE EDAD</option>
        </select>
    </td>
  </tr>
  <tr class="rangoEdad">
  	<td width="1%" nowrap valign="middle" align="left">
    <input name="tipo_edadR" id="tipo_edadR" type="hidden" value="a">
    <div id="radiosB">
    <input class="radio_r rad1" type="radio" id="rAnos" name="radio"><label for="rAnos">Años</label>
    <input class="radio_r rad2" type="radio" id="rMeses" name="radio"><label for="rMeses">Meses</label>
    <input class="radio_r rad3" type="radio" id="rDias" name="radio"><label for="rDias">Días</label>
  	</div>
    </td>
    <td colspan="">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="49%" valign="middle" nowrap align="center">
        	* Edad inicial(<span class="edadA">años</span>)
        </td>
        <td valign="middle" align="center"><input name="edadI" type="text" class="required" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" value="" size="5" maxlength="3"></td>
        
        <td width="49%" valign="middle" nowrap align="center">
        	* Edad final(<span class="edadA">años</span>)
        </td>
        <td valign="middle" align="center"><input name="edadF" type="text" class="required" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" value="" size="5" maxlength="3"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editBooleano">
<form action="" method="post" name="formEditBooleano" id="formEditBooleano" target="_self" style="width:100%; height:100%">
<input name="idUsuarioUB" id="idUsuarioUB" type="hidden" value=""> <input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese el valor normal para el resultado del valor de referencia NEGATIVO-POSITIVO.</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="1%" valign="top" nowrap>* Valor normal</td>
        <td valign="top" align="left">
            <select name="valorBooleano" id="valorBooleano" class="required">
              <option value="" selected="selected">SELECCIONAR</option>
              <option value="1">POSITIVO</option>
              <option value="0">NEGATIVO</option>
            </select>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editarRangoNumerico">
<form action="" method="post" name="formEditarRangoNumerico" id="formEditarRangoNumerico" target="_self" style="width:100%; height:100%">
<input name="idUsuarioUR" id="idUsuarioUR" type="hidden" value="">
<input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese el valor mínimo y el valor máximo para el valor de referencia</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="1" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="50%" valign="bottom" nowrap align="center">* Valor mínimo</td>
        <td width="" valign="bottom" nowrap align="center">* Valor máximo</td>
      </tr>
      <tr>
        <td valign="top" align="center"><input name="rangoI" type="text" class="required" id="rangoI" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td>
        <td valign="top" align="center"><input name="rangoF" type="text" class="required" id="rangoF" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editarValorMaximo">
<form action="" method="post" name="formEditarValorMaximo" id="formEditarValorMaximo" target="_self" style="width:100%;height:100%">
<input name="idUsuarioUR" id="idUsuarioUR" type="hidden" value=""> 
<input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese el valor máximo para el valor de referencia</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="140px" valign="top" nowrap>* Valor máximo</td>
        <td valign="top" align="left">
        	<input name="valorMax" type="text" class="required" id="valorMax" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7" style="width:"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editarValorMinimo">
<form action="" method="post" name="formEditarValorMinimo" id="formEditarValorMinimo" target="_self" style="width:100%;height:100%">
<input name="idUsuarioUR" id="idUsuarioUR" type="hidden" value=""> 
<input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese el valor mínimo para el valor de referencia</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="140px" valign="top" nowrap>* Valor mínimo</td>
        <td valign="top" align="left">
        	<input name="valorMin" type="text" class="required" id="valorMin" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editarValorTexto">
<form action="" method="post" name="formEditarValorTexto" id="formEditarValorTexto" target="_self" style="width:100%;height:100%">
<input name="idUsuarioUR" id="idUsuarioUR" type="hidden" value=""> 
<input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese el valor de texto para el valor de referencia</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="80px" valign="bottom" nowrap>* TEXTO</td>
        <td valign="top" align="left">
        	<input name="valorText" type="text" class="required" id="valorText" onKeyUp="conMayusculas(this);" value="" size="" maxlength="" style="width:100%"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editarRangoMasMenos">
<form action="" method="post" name="formERangoMasMenos" id="formERangoMasMenos" target="_self" style="width:100%;height:100%">
<input name="idUsuarioUR" id="idUsuarioUR" type="hidden" value=""> 
<input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese los valores para el valor de referencia</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="50%" valign="bottom" nowrap>* Valor base</td>
        <td width="50%" valign="bottom" nowrap>* Variación (+-)</td>
      </tr>
      <tr>
        <td valign="top" align="left">
        	<input name="valor" type="text" class="required" id="valor" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td>
        <td valign="top" align="left">
        	<input name="variacion" type="text" class="required" id="variacion" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editValoresNMA">
<form action="" method="post" name="formEditarValoresNMA" id="formEditarValoresNMA" target="_self" style="width:100%; height:100%">
	<input name="idUsuarioUR" id="idUsuarioUR" type="hidden" value=""> 
    <input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese los valores de riesgo normal, moderado y alto para el valor de referencia</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="1" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="150px" valign="bottom" nowrap align="center">* Normal</td>
        <td width="" valign="bottom" nowrap align="center">* Rango riesgo moderado</td>
        <td width="150px" valign="bottom" nowrap align="center">* Riesgo alto</td>
      </tr>
      <tr>
        <td valign="top" align="center">
        < <input name="valorN" type="text" class="required" id="valorN" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
        </td>
        <td valign="top" align="left">
        	<table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="right">DE</td>
                <td>
                <input name="rangoI" type="text" class="required" id="rangoI" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
                </td>
                <td align="right">A</td>
                <td>
                <input name="rangoF" type="text" class="required" id="rangoF" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
                </td>
              </tr>
            </table>
        </td>
        <td valign="top" align="center">
        > <input name="valorA" type="text" class="required" id="valorA" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editValoresNMAi">
<form action="" method="post" name="formEditarValoresNMA" id="formEditarValoresNMA" target="_self" style="width:100%; height:100%">
	<input name="idUsuarioUR" id="idUsuarioUR" type="hidden" value=""> 
    <input name="idAVR" id="idAVR" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese los valores de riesgo normal, moderado y alto para el valor de referencia</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="1" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="150px" valign="bottom" nowrap align="center">* Normal</td>
        <td width="" valign="bottom" nowrap align="center">* Rango riesgo moderado</td>
        <td width="150px" valign="bottom" nowrap align="center">* Riesgo alto</td>
      </tr>
      <tr>
        <td valign="top" align="center">
        > <input name="valorN" type="text" class="required" id="valorN" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
        </td>
        <td valign="top" align="left">
        	<table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="right">DE</td>
                <td>
                <input name="rangoI" type="text" class="required" id="rangoI" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
                </td>
                <td align="right">A</td>
                <td>
                <input name="rangoF" type="text" class="required" id="rangoF" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
                </td>
              </tr>
            </table>
        </td>
        <td valign="top" align="center">
        < <input name="valorA" type="text" class="required" id="valorA" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7">
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
<input name="idUsuarioUC" id="idUsuarioUC" type="hidden" value=""> <input name="idAC" id="idAC" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese la cantidad de éste material consumible para la base.</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="1%" valign="bottom" nowrap>Cantidad *</td>
        <td valign="top" align="left"><input name="cantidadC" type="text" class="required" id="cantidadC" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" maxlength="10"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="editPrecio">
<form action="" method="post" name="formEditPrecio" id="formEditPrecio" target="_self" style="width:100%; height:100%">
<input name="idUsuarioUP" id="idUsuarioUC" type="hidden" value=""> <input name="idAC" id="idAC" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left">Ingrese el precio total de éste material consumible para la base.</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="1%" valign="bottom" nowrap>Precio total ($)*</td>
        <td valign="top" align="left"><input name="precioC" type="text" class="required" id="precioC" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" maxlength="10"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="nuevaUnidadMedida">
<form action="" method="post" name="formNuevaUnidadMedida" id="formNuevaUnidadMedida" target="_self" style="width:100%; height:100%">
<input name="idUsuarioUM" id="idUsuarioUM" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoUM">Para agregar una nueva unidad de medida, indique los siguientes datos.</td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="1%" valign="bottom" nowrap>* Nombre de la unidad de medida</td>
      </tr>
      <tr>
      <td valign="top" align="left"><input name="nombreUM" type="text" class="required" id="nombreUM" onKeyUp="conMayusculas(this);"></td>
      </tr>
      <tr>
      <td valign="" align="left">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="1%" nowrap>* Abrevicaión de la unidad de medida</td>
            <td><input name="abreviacionUM" type="text" class="required" id="abreviacionUM" onKeyUp="" maxlength="20"></td>
          </tr>
        </table>
      </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="nuevaCondicionMuestra">
<form action="" method="post" name="formNuevoItem" id="formNuevoItem" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNI" id="idUsuarioNI" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoAddCondicion">
    	Para agregar una nueva condición para las muestras, indique los siguientes datos
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="1%" valign="bottom" nowrap>* Nombre de la condición</td>
      </tr>
      <tr>
      <td valign="top" align="left"><input name="nombreCM" type="text" class="required" id="nombreCM" onKeyUp="conMayusculas(this);"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="nuevoTipoConsumible">
<form action="" method="post" name="formNuevoItem" id="formNuevoItem" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNI" id="idUsuarioNI" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoAddTipoConsumible">
    	Para agregar un nuevo tipo de consumible, indique los siguientes datos
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="1%" valign="bottom" nowrap>* Nombre del tipo de consumible</td>
      </tr>
      <tr>
      <td valign="top" align="left"><input name="tipoC" type="text" class="required" id="tipoC" onKeyUp="conMayusculas(this);"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="nuevaPresentacionCons">
<form action="" method="post" name="formNuevaPresentacionConsumible" id="formNuevaPresentacionConsumible" target="_self" style="width:100%; height:100%">
<input name="idUsuarioNI" id="idUsuarioNI" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6">
  <tr>
    <td colspan="2" align="left" id="textoAddPresentacionConsumible">
    	Para agregar una nueva presentación para el consumible, indique los siguientes datos
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%">
      <tr align="left">
        <td width="1%" valign="bottom" nowrap>* Nombre de la presentación para el consumible</td>
      </tr>
      <tr>
      <td valign="top" align="left"><input name="presentacionC" type="text" class="required" id="presentacionC" onKeyUp="conMayusculas(this);"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>