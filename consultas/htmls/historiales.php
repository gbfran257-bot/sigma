<table id="dHistory" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250" style="font-size:0.8em;" id="listasHistorial">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
      <tr height="10" id="contenedorControles">
        <td align="center">
        <button class="botonControl" id="cAntes">Anterior</button>
        <button class="botonControl" id="cSiguiente">Siguiente</button>
        <!--<button class="botonControl" id="cActual">Actual</button> -->
        <input name="idControl" id="idControl" type="hidden" value="">
        </td>
      </tr>
      <tr>
        <td valign="top" style="font-size:0.8em;" id="contenedorDTHI" bgcolor="">
        <table width="100%"height="100%"border="0"cellpadding="4"cellspacing="0"id="dataTableHis" class="tablilla">
            <thead id="cabecera_tBusquedaHis">
              <tr>
                <th id="clickmeHis" width="1px">#</th>
                <th width="10px">FECHA</th>
                <th id="titulo_concept">CONCEPTO</th>
              </tr>
            </thead>
            <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
          </table>
        </td>
      </tr>
    </table>
    </td>
    <td>
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" align="left">
        <div id="tabs_hist" style="width:99%; height:100%; overflow:hidden; vertical-align:top;">
        <table width="100%" height="" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td align="left">
            <ul style="font-size:0.9em; border:1px none red;" id="miTabsIMG">
                <li id="tah1"><a class="tabsHi" id="thi-1-1" href="#tabs-1hi">NOTA EVOLUCIÓN</a></li>
                <li id="tah2"><a class="tabsHi" id="thi-2-1" href="#tabs-2hi">DX</a></li>
                <li id="tah3"><a class="tabsHi" id="thi-3-1" href="#tabs-3hi">RECETA(F)</a></li>
                <li id="tah4"><a class="tabsHi" id="thi-4-1" href="#tabs-4hi">RECETA(R)</a></li>
            </ul>
            </td>
          </tr>
        </table>
		<div id="tabs-1hi" style="width:99%; height:91%; overflow:scroll;" class="fondo_tab"> </div>
        <div id="tabs-2hi" style="width:99%; height:91%; overflow:scroll;" class="fondo_tab"> </div>
        <div id="tabs-3hi" style="width:99%; height:91%; overflow:scroll;"> </div>
        <div id="tabs-4hi" style="width:99%; height:91%; overflow:scroll;"> </div>
        </div>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>