<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="buscarItemsX">
<input name="clave_medico_E" id="clave_medico_E" type="hidden" value="">
  <input name="numFilaEstudios" id="numFilaEstudios" type="hidden" value="">
    <table width="99%" cellspacing="0" id="dataTable1" height="" border="0" cellpadding="5">
    <thead id="my_head1">
      <tr style="color:; background-color:#FF6600; font-size:1.2em;">
        <th class="titulosTabs" align="center">CLAVE</th>
        <th class="titulosTabs" align="center">DESCRIPCIÓN</th>
        <th class="titulosTabs" align="center">ÁREA</th>
        <th class="titulosTabs" align="center">PRECIO</th>
        <th class="titulosTabs" align="center">+</th>
      </tr>
    </thead>
    <tbody align="left">
		<tr>
        	<input name="mi_clave_e" id="mi_clave_e" type="hidden" value="">
            <input name="mi_nombre_e" id="mi_nombre_e" type="hidden" value="">
            <input name="mi_depto_e" id="mi_depto_e" type="hidden" value="">
            <input name="mi_precio_e" id="mi_precio_e" type="hidden" value="">
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
    <tfoot class="t1_1" id="mi_pie_tabla1" align="center">
        <tr bgcolor="#AA0000">
            <th><input type="text" name="textfield1_1" id="textfield1_1" style="height:100%; width:100%;" value="-Clave-"></th>
            <th><input type="text" name="textfield2_1" id="textfield2_1" style="height:100%; width:100%;" value="-Descripción-"></th>
            <th><input type="text" name="textfield3_1" id="textfield3_1" style="height:100%; width:100%;" value="-Área-"></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </tfoot>
  </table>
  <hr>

	<div id="titulo_dt2" style="font-size:1em; text-align:center; font-weight:bold; color:red" align="left">ESTUDIOS AGREGADOS</div>
<table width="100%" cellspacing="0" id="dataTable2" height="" border="0" cellpadding="5">
    <thead id="my_head2">
      <tr id="cabecera_maestra" class="cabecera_maestra" style="color:; background-color:#FF6600; font-size:1.2em;">
        <th class="titulosTabs" align="center">CLAVE</th>
        <th class="titulosTabs" align="center">DESCRIPCIÓN</th>
        <th class="titulosTabs" align="center">ÁREA</th>
        <th class="titulosTabs" align="center">PRECIO</th>
        <th class="titulosTabs" align="center">-&nbsp;&nbsp;</th>
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
  
</div>

</body>
</html>
