<div id="paraTransferir">
<div align="center" style="padding:5">TRANSFERIR LA INTERPRETACIÓN DEL ESTUDIO <span id="estudioTr"></span> CON REFERENCIA <span id="referenciaTr"></span>. DEBE SELECCIONAR A UN MÉDICO RADIÓLOGO.</div>
<input name="idTmedicoR" type="hidden" value="" id="idTmedicoR">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2" id="dataTableTransfer" class="tablilla"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr class="titulos_dataceldas">
    <th id="clickmeTr" align="center" nowrap width="10px">#</th>
    <th align="center" width="">NOMBRE</th>
    <th align="center">APATERNO</th>
    <th align="center" width="" nowrap>AMATERNO</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot class="cuerpo_datatable">
        <tr>
            <th><input name="tX" type="hidden" value="" class="search_init sea1"></th>
            <th><input name="tNombre" id="tNombre" type="text" class="search_init campos_b_t sea1" placeholder="-NOMBRE-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="tApaterno" id="tApaterno" type="text" class="search_init campos_b_t sea1" placeholder="-APATERNO-" onKeyUp="conMayusculas(this);"/</th>
            <th><input name="tAmaterno" id="tAmaterno" type="text" class="search_init campos_b_t sea1" placeholder="-AMATERNO-" onKeyUp="conMayusculas(this);"/</th>
        </tr>
    </tfoot>
</table>
<div id="errorSeleccionMédicoT" style="display:none;"><span class="alerta_no_seleccion">Debe de seleccionar un médico, dé clic sobre uno de ellos.</span></div>
</div>

<div id="yaTransferido">
<div>EL ESTUDIO <span id="estudioYa"></span> CON REFERENCIA <span id="referenciaYa"></span> SE ASIGNÓ CON LOS SIGUENTES DATOS:</div><br>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4" class="tablilla">
  <tr class="ui-widget-header">
    <td>USUARIO QUE ASIGNÓ</td>
    <td>FECHA Y HORA DE ASIGNACIÓN</td>
    <td>MÉDICO ASIGNADO</td>
  </tr>
  <tr>
    <td id="uAsignaT"></td>
    <td id="fAsignaT"></td>
    <td id="mAsignaT"></td>
  </tr>
</table>
</div>