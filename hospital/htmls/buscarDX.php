<div id="buscarDiagnosticos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style="font-size:0.8em;" bgcolor="#BBB">
  <tr height="50%">
    <td>
    <table width="99%" cellspacing="0" id="dataTableBDX" height="100%" border="0" cellpadding="5" class="tablilla" bgcolor="#FFFFFF">
        <thead id="my_head">
          <tr>
            <th class="titulosTabs" align="center" width="1%;">CLAVE</th>
            <th class="titulosTabs" align="center">
            	DIAGNÓSTICO &nbsp;
                <button id="altaDX">¡Si el diagnóstico no existe en la base de datos, puede dar uno de alta aquí!</button>
            </th>
          </tr>
        </thead>
        <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBDX" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="text" name="textfield1" id="textfield1" style="height:100%; width:100%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:100%;"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionDX" style="display:none;"><span style="color:white; text-decoration:underline;">Debe de seleccionar al menos un diagnóstico, dé clic sobre ellos.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="99%" cellspacing="0" id="dataTableDXS" height="100%" border="0" cellpadding="5" class="tablilla" bgcolor="#FFFFFF">
        <thead id="my_head">
          <tr>
          	<th id="clickmeDXS" class="titulosTabs" align="center" width="1%">#</th>
            <th class="titulosTabs" align="center" width="1%">CLAVE</th>
            <th class="titulosTabs" align="center">DIAGNÓSTICO</th>
            <th class="titulosTabs" align="center" width="1%">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="diagnosticosSeleccionados" style="display:;"><span style="color:white; text-decoration:underline;">Diagnósticos seleccionados.</span></div>
    </td>
  </tr>
</table>
</div>

<div id="buscarMedicamentos">
<table width="99%" height="100%" border="0" cellspacing="0" cellpadding="2" style="font-size:0.8em;" bgcolor="#AAA">
  <tr height="50%">
    <td>
    <table width="100%" cellspacing="0" id="dataTableBMedicamentos" height="100%" border="0" cellpadding="4" class="tablilla" bgcolor="#FFFFFF">
        <thead id="my_head">
          <tr>
            <th class="titulosTabs azulito" align="center" width="1%">CLAVE</th>
            <th class="titulosTabs" align="center">
            	MEDICAMENTO
            </th>
            <th class="titulosTabs" align="center">PRESENTACIÓN</th>
            <th class="titulosTabs" align="center">CONCENTRACIÓN</th>
          </tr>
        </thead>
        <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
        <tfoot class="pieTablaBMedi" id="mi_pie_tabla" align="center">
            <tr>
                <th><input type="text" name="textfield1" id="textfield1" style="height:100%; width:98%;"></th>
                <th><input type="text" name="textfield2" id="textfield2" style="height:100%; width:98%;"></th>
                <th><input type="text" name="textfield3" id="textfield3" style="height:100%; width:98%;"></th>
                <th><input type="text" name="textfield4" id="textfield4" style="height:100%; width:98%;"></th>
            </tr>
        </tfoot>
      </table>
    <div id="errorSeleccionMedicamentos" style="display:none;"><span style="color:white; text-decoration:underline;">Debe de seleccionar al menos un medicamento, dé clic sobre ellos.</span></div>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" cellspacing="0" id="dataTableMS" height="100%" border="0" cellpadding="4" class="tablilla" bgcolor="#FFFFFF">
        <thead id="my_head">
          <tr>
          	<th id="clickmeMS" class="titulosTabs" align="center" width="1%">#</th>
            <th class="titulosTabs" align="center">MEDICAMENTO</th>
            <th class="titulosTabs" align="center">PRESENTACIÓN</th>
            <th class="titulosTabs" align="center">CONCENTRACIÓN</th>
            <th class="titulosTabs" align="center" width="1%">ELIMINAR</th>
          </tr>
        </thead>
        <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    <div id="medicamentosSeleccionados" style="display:;"><span style="color:white; text-decoration:underline;">Medicamentos seleccionados.</span></div>
    </td>
  </tr>
</table>
</div>