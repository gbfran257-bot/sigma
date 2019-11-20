<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="buscarConsulta" style="overflow:hidden;">
<table width="100%" cellspacing="0" id="dataTableBConsulta" height="100%" border="0" cellpadding="4" style=" font-size:12px;" class="tablilla">
    <thead id="my_head">
      <tr style=" font-size:1.3em;" bgcolor="#FF6633">
        <th class="titulosTabs" align="center" id="clickme_bc" width="" style="color:white;">CONSULTA</th>
        <th class="titulosTabs" align="center" style="color:white;">ÁREA</th>
        <th class="titulosTabs" align="center" width="50px" style="color:white;">PRECIO</th>
        <th class="titulosTabs" align="center" width="50px" style="color:white;">BENEFICIO</th>
      </tr>
    </thead>
    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot class="pieTablaBMCo" id="mi_pie_tabla" align="center">
        <tr bgcolor="#FF6633" height="20px">
            <th><input type="text" name="textfield2" id="textfield2" style="height:22px; width:100%;" class="search_init" value=""></th>
            <th><input type="text" name="textfield3" id="textfield3" style="height:22px; width:100%;" class="search_init" value=""></th>
            <th><input type="hidden" name="textfield4" id="textfield4" class="search_init"></th>
            <th><select name="beneficioConsulta" id="beneficioConsulta" style="height:22px;"></select></th>
        </tr>
    </tfoot>
  </table>
<div id="errorSeleccionConsulta" style="display:none;"><span style="color:#ff0000; text-decoration:underline; font-size:12px;">Debe de seleccionar la consulta, dé clic sobre una de ellas.</span></div>
  
</div>

</body>
</html>
