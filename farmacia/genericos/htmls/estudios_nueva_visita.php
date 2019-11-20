<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="buscar_estudios">

<div class="botones1" id="botones1">
    <table width="100%">
      <tr>
        <td><img id="resete1" title="Reiniciar la Búsqueda" src="../imagenes/botones/_buscar.png" width="" height="37"></td>
        <td><img id="addMedico1x" src="../imagenes/botones/_agregar.png" width="" height="37"></td>
      </tr>
    </table>
</div>
  <input name="numFilaEstudios" id="numFilaEstudios" type="hidden" value="">
    <table width="100%" cellspacing="0" id="dataTable1">
    <thead id="my_head1">
      <tr>
        <th>CLAVE</th>
        <th>DESCRIPCIÓN</th>
        <th>DEPARTAMENTO</th>
        <th>PRECIO</th>
        <th>+</th>
      </tr>
    </thead>
    <tbody>
		<tr>
        	<input name="mi_clave_e" id="mi_clave_e" type="hidden" value="">
            <input name="mi_nombre_e" id="mi_nombre_e" type="hidden" value="">
            <input name="mi_depto_e" id="mi_depto_e" type="hidden" value="">
            <input name="mi_precio_e" id="mi_precio_e" type="hidden" value="">
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
    <tfoot class="t1" id="mi_pie_tabla1">
        <tr>
            <td><input type="text" name="textfield1_1" id="textfield1_1"></td>
            <td><input type="text" name="textfield2_1" id="textfield2_1"></td>
            <td><input type="text" name="textfield3_1" id="textfield3_1"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
  </table>
  <hr>

<div id="titulo_dt2" style="font-size:1em; text-align:center; font-weight:bold; color:rgba(23,44,128,1)" align="left">ESTUDIOS AGREGADOS</div>
    
    <table width="100%" cellspacing="0" id="dataTable2">
        <thead id="my_head2">
          <tr id="cabecera_maestra" class="cabecera_maestra">
            <th>CLAVE</th>
            <th>DESCRIPCIÓN</th>
            <th>DEPARTAMENTO</th>
            <th>PRECIO</th>
            <th align="center">-&nbsp;&nbsp;</th>
          </tr>
        </thead>
        <tbody>
            <tr id="celda_maestra" class="celda_maestra">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
  
<div id="div_falta_m1" class="falta_s"></div>
  
  
  <table id="ovTotalDatosEstudios" width="100%" class="ui-widget-content tablasContenidos">
  <tr>
    <td class="ui-widget-header" align="center">ESTUDIOS</td>
  </tr>
  <tr>
    <td>
    	<table width="100%">
 		 <tr>
    		<td class="deGris">Clave</td>
    		<td class="deGris">Médico</td>
    		<td class="deGris">Especialidad</td>
  		</tr>
  		<tr>
    		<td><span id="mi_dato_clave_m_ov"></span></td>
    		<td><span id="mi_dato_medico_m_ov"></span></td>
    		<td><span id="mi_dato_especialidad_m_ov"></span></td>
  		</tr>
	   </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%" id="mi_tabla_estudios_TOTAL" style="font-size:0.8em;">
 		 <tr>
    		<td class="deGris">#Est</td>
    		<td class="deGris">Clave</td>
    		<td class="deGris">Descripción</td>
            <td class="deGris">Departamento</td>
            <td class="deGris">Precio/P</td>
            <td class="deGris">Precio/C</td>
            <td class="deGris">Precio/D</td>
  		</tr>
  		<tr id="celda_maestra_est_TOTAL" class="celda_maestra_est_TOTAL">
    		<td></td>
    		<td class="puto"></td>
    		<td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
  		</tr>
	   </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%" id="tablaTotalesEstudios1" style="font-size:0.9em;">
 		 <tr>
    		<td class="deGris">Urgencia($)</td>
    		<td><input name="campoUrgenciaEovT" id="campoUrgenciaEovT" type="text" value="0" size="3" readonly class="campoUIc"></td>
    		<td class="deGris">TomaDom($)</td>
            <td><input name="campoTomaDomEovT" id="campoTomaDomEovT" type="text" value="0" size="3" readonly class="campoUIc"></td>
            <td class="deGris">EntregaDom($)</td>
            <td><input name="campoEntregaDomEovT1" id="campoEntregaDomEovT1" type="text" value="0" size="3" readonly class="campoUIc"></td>
            <td class="deGris">TotalToma($)</td>
            <td><input name="campoSumaTomaEovT" id="campoSumaTomaEovT" type="text" value="0" size="3" readonly class="campoUIc"></td>
  		</tr>
	   </table>
    </td>
  </tr>
</table>
</div>


</div>

</body>
</html>
