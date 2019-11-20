<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="buscarEstudiosX">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr height="50%">
    <td>
    <table width="99%" cellspacing="0" id="dataTableBEEndoscopia" height="100%" border="0" cellpadding="4" class="tablilla">
        <thead id="my_head">
          <tr style="font-size:0.8em;" bgcolor="#FF6633">
            <th id="clickme_bee" class="titulosTabs" align="center" style="color:white;">ESTUDIO</th>
            <th class="titulosTabs" align="center">ÁREA</th>
            <th class="titulosTabs" align="center" width="80px">PRECIO</th>
            <th class="titulosTabs" align="center" width="80px">BENEFICIO</th>
          </tr>
        </thead>
        <tbody align="left" style="font-size:11px; color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBEIm" id="mi_pie_tabla" align="center">
            <tr bgcolor="#FF6633">
                <th><input type="text" name="textfield1" id="textfield1" style="height:22px; width:100%;" value=""></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:22px; width:100%;" value=""></th>
                <th> </th>
                <th><select name="beneficioEndoscopia" id="beneficioEndoscopia" style="height:22px;"></select></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionEstudios" style="display:none;">
    <span style="color:black; text-decoration:underline;">Debe de seleccionar al menos un estudio, dé clic sobre ellos.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <div id="estudiosSeleccionadosNV"><span style="color:black; text-decoration:underline; font-size:0.7em;">Estudios seleccionados.</span></div>
    <table width="99%" cellspacing="0" id="dataTableESEndo" height="100%" border="0" cellpadding="4" class="tablilla">
        <thead id="my_head">
          <tr style="font-size:0.8em;" bgcolor="#FF6633">
          	<th id="clickmeESE" class="titulosTabs" align="center" width="10px" style="color:white;">#</th>
            <th class="titulosTabs" align="center" style="color:white;">ESTUDIO</th>
            <th class="titulosTabs" align="center" style="color:white;">ÁREA</th>
            <th class="titulosTabs" align="center" width="80px" style="color:white;">PRECIO</th>
            <th class="titulosTabs" align="center" width="80px" style="color:white;">BENEFICIO</th>
            <th class="titulosTabs" align="center" width="10px" style="color:white;">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="font-size:11px; color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    </td>
  </tr>
</table>
</div>

<div id="buscarServiciosX">
<table width="99%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr height="50%">
    <td>
    <table width="99%" cellspacing="0" id="dataTableBEImagen" height="100%" border="1" cellpadding="4" class="tablilla">
        <thead id="my_head">        	
          <tr style="font-size:0.8em;" bgcolor="#FF6633">
            <th id="clickme_bs" class="titulosTabs" align="center">SERVICIO</th>
            <th class="titulosTabs" align="center" width="80px">DEPARTAMENTO</th>
            <th class="titulosTabs" align="center" width="80px">PRECIO</th>
            <th class="titulosTabs" align="center" width="80px">BENEFICIO</th>
          </tr>
        </thead>
        <tbody align="left" style="font-size:11px; color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBEIm" id="mi_pie_tabla" align="center">
            <tr bgcolor="#AA0000">
                <th><input type="text" name="textfield1" id="textfield1" style="height:100%; width:100%;" value="-Servicio-"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;" value="-Departamento-"></th>
                <th> </th>
                <th><select name="beneficioServicios" id="beneficioServicios"></select></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionEstudios" style="display:none;"><span style="color:black; text-decoration:underline; font-size:0.7em;">Debe de seleccionar al menos un servicio, dé clic sobre ellos.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="99%" cellspacing="0" id="dataTableESImagen" height="100%" border="0" cellpadding="4" class="tablilla">
        <thead id="my_head">
          <tr style="font-size:0.8em;" bgcolor="#FF6633">
          	<th id="clickmeESI" class="titulosTabs" align="center" width="10px" style="color:white;">#</th>
            <th class="titulosTabs" align="center" style="color:white;">SERVICIO</th>
            <th class="titulosTabs" align="center" style="color:white;">DEPARTAMENTO</th>
            <th class="titulosTabs" align="center" width="80px" style="color:white;">PRECIO</th>
            <th class="titulosTabs" align="center" width="80px" style="color:white;">BENEFICIO</th>
            <th class="titulosTabs" align="center" width="10px" style="color:white;">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left" style="font-size:11px; color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="estudiosSeleccionadosNV" style="display:;"><span style="color:black; text-decoration:underline; font-size:0.7em;">Servicios seleccionados.</span></div>
    </td>
  </tr>
</table>
</div>

</body>
</html>
