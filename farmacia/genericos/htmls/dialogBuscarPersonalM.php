<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="buscarMedicoX">
<table width="99%" cellspacing="0" id="dataTableBMConsulta" height="100%" border="0" cellpadding="4" class="tablilla" style=" font-size:12px;">
    <input name="claveMBC" id="claveMBC" type="hidden" value="">
    <thead id="my_head">
      <tr style="font-size:0.1.2em;" bgcolor="#FF6633">
        <th class="titulosTabs" align="center" id="clickme_bme" style="color:white;">NOMBRE</th>
        <th class="titulosTabs" align="center" style="color:white;">APATERNO</th>
        <th class="titulosTabs" align="center" style="color:white;">AMATERNO</th>
        <th class="titulosTabs" align="center" width="40px" style="color:white;">CARGO</th>
      </tr>
    </thead>
    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot class="pieTablaBMCo" id="mi_pie_tabla" align="center">
        <tr bgcolor="#FF6633" height="20px">
            <th><input type="text" name="textfield1" id="textfield1" style="height:22px; width:100%;" class="search_init" value=""></th>
            <th><input type="text" name="textfield2" id="textfield2" style="height:22px; width:100%;" class="search_init" value=""></th>
            <th><input type="text" name="textfield3" id="textfield3" style="height:22px; width:100%;" class="search_init" value=""></th>
            <th><input type="text" name="textfield4" id="textfield4" style="height:22px; width:100%;" class="search_init" value=""></th>
        </tr>
    </tfoot>
  </table>
<div id="errorSeleccionMédico" style="display:none;"><span style="color:#ff0000; text-decoration:underline; font-size:12px;">Debe de seleccionar algún personal médico, dé clic sobre uno de ellos.</span></div>
  
</div>

</body>
</html>
