<form action="" method="post" style="height:100%;" name="form-asignaC" id="form-asignaC" target="_self">
<input name="idP_AC" id="idP_AC" class="idP_fichaP" type="hidden" value=""><input name="idU_AC" id="idU_AC" class="idU_fichaP" type="hidden" value="<?php echo $row_usuario['id_u']; ?>"><input name="idC_AC" id="idC_AC" type="hidden" value="">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr align="left">
    <td class="" nowrap width="1%">Paciente</td>
    <td><input name="pacienteAC" id="pacienteAC" type="text" readonly></td>
  </tr>
  <tr align="left">
    <td class="" nowrap>Beneficio</td>
    <td><input name="convenioAC" id="convenioAC" type="text" readonly></td>
  </tr>
  <tr align="left">
    <td class="" nowrap>Fecha de expedición</td>
    <td><input class="calendario required" name="fechaIC" id="fechaIC" type="text"></td>
  </tr>
  <tr align="left">
    <td class="" nowrap>Fecha de expiración</td>
    <td><input class="calendario required" name="fechaFC" id="fechaFC" type="text" ></td>
  </tr>
</table>
</form>

<table width="100%" cellspacing="0" id="dataTableBuscarConvenio" height="100%" border="0" cellpadding="5">
    <thead>
        <tr style="color:; background-color:; font-size:1em;">
            <th class="titulosTabs" align="center" id="miClick6">CLAVE</th>
            <th class="titulosTabs" align="center">BENEFICIO</th>
            <th class="titulosTabs" align="center">ASIGNAR</th>
        </tr>
    </thead>
    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
</table>