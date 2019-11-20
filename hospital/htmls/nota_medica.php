<div id="tabs_nnm" style="width:100%; height:99%; overflow:hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left">
    <ul style="font-size:0.8em;">
        <li><a class="tabsn" id="tabs-1n-1" href="#tabs-1n" style="font-size:1em;">NOTA MÉDICA</a></li>
        <li><a class="tabsn" id="tabs-2n-1" href="#tabs-2n" style="font-size:1em;">INDICACIONES</a></li>
        <li><a class="tabsn" id="tabs-3n-1" href="#tabs-3n" style="font-size:1em;">RECOMENDACIONES</a></li>
    </ul>
    </td>
    <td align="right" width="1%" nowrap>
    <button id="saveNotaM" class="ui-button ui-widget ui-corner-all ui-button-icon mn" title="">
        GUARDAR<span class="ui-icon ui-icon-disk"></span>
    </button>
    <button id="cancelNotaM" class="ui-button ui-widget ui-corner-all ui-button-icon mn" title="">
        CANCELAR<span class="ui-icon ui-icon-close"></span>
    </button>
    </td>
  </tr>
</table>
<form action="" method="post" name="formNotaMed" id="formNotaMed" target="_self" style="height:100%">
<input name="idUsuario_nnm" id="idUsuario_nnm" type="hidden" value=""> 
<input name="idPaciente_nnm" id="idPaciente_nnm" type="hidden" value="">
<input name="aleatorio_nnm" id="aleatorio_nnm" type="hidden" value="">
<input name="id_hospitalizacion" id="id_hospitalizacion" type="hidden" value="">
<input name="idSV" id="idSV" type="hidden" value="">
  <div id="tabs-1n" style="width:99%; height:92%; font-size:0.8em; overflow:auto;">
  <table width="100%" height="95%" border="0" cellspacing="0" cellpadding="0" class="fondo_tab">
  <tr>
    <td height="100%" id="contenedorNM">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
      	<td align="left"width="100%"nowrap valign="top" style="height:1px;">
        	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="1">
              <tr>
                <td width="1%" align="left" style="padding-left:12px; padding-right:12px; font-weight:bold;">SIGNOS VITALES</td>
                <td align="left">
                <td width="1%" align="left" nowrap>TIPO NOTA MÉDICA</td>
                <td>
                    <select name="tipoNotaMed" id="tipoNotaMed" class="required"></select>
                    <button id="imprimirNotaE" style="font-size:0.8em; display:none;">Imprimir</button>
                </td>
                <td width="250" align="right">
                <button class="botonhes historialhes" lang="h" id="verHistorialHcC" style="font-size:0.8em;">HC</button>
                <button class="botonhes historialhes" lang="l" id="verHistorialLabC" style="font-size:0.8em;">LAB</button>
                <button class="botonhes historialhes" lang="u" id="verHistorialUsgC" style="font-size:0.8em;">USG</button>
                <button class="botonhes historialhes" lang="i" id="verHistorialImgC" style="font-size:0.8em;">IMG</button>
                <button class="botonhes historialhes" lang="e" id="verHistorialEndC" style="font-size:0.8em;">END</button>
                <button class="botonhes historialhes" lang="c" id="verHistorialColC" style="font-size:0.8em;">COL</button>
                <button class="botonhes historialhes" lang="o" id="verHistorialOtrosC" style="font-size:0.8em;">OTROS</button>
                <button class="botonhes historialhes" lang="n" id="verHistorialNotasC" style="font-size:0.8em;">CNTS</button>
                </td>
              </tr>
            </table>
      	</td>
      </tr>
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="110" height="100%" align="left" class="textoResaltado">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="1" class="">
              <tr height="1">
                <td align="center" colspan="3" style="font-size:0.65em; font-weight:bold; color:black;">
                	<span id="usuario_sviNNM">USER</span> <span id="fechaHoraNNM">15/10/15 22:49</span>
                </td>
              </tr>
              <tr height="1">
                <td width="33.3%" align="left"><span id="aFC" style="color:#000000;">*</span> FC</td>
                <td width="33.3%" align="right"><span id="fc0"></span></td>
                <td><button class="botonhes grafi gfc" id="graficaFC" style="font-size:0.8em; display:;">Gráfica FC</button></td>
              </tr>
              <tr height="1">
                <td align="left"><span id="aFR" style="color:#000000;">*</span> FR</td>
                <td align="right"><span id="fr0"></span></td>
                <td><button class="botonhes grafi gfr" id="graficaFR" style="font-size:0.8em; display:;">Gráfica FR</button></td>
              </tr>
              <tr height="1">
                <td align="left"><span id="aTA" style="color:#000000;">*</span> T/A</td>
                <td nowrap align="right"><span id="ta0"></span></td>
                <td><button class="botonhes grafi gta" id="graficaTA" style="font-size:0.8em; display:;">Gráfica TA</button></td>
              </tr>
              <tr height="1">
                <td nowrap align="left"><span id="aTEMP" style="color:#000000;">*</span> TEMP</td>
                <td align="right"><span id="temp0"></span></td>
                <td><button class="botonhes grafi gtemp" id="graficaTemp" style="font-size:0.8em; display:;">Gráfica TEMP</button></td>
              </tr>
              <tr height="1">
                <td align="left"><span id="aPESO" style="color:#000000; display:none;">*</span> PESO</td>
                <td align="right"><span id="peso0"></span></td>
                <td><button class="botonhes grafi gpeso" id="graficaPESO" style="font-size:0.8em; display:;">Gráfica PESO</button></td>
              </tr>
              <tr height="1">
                <td nowrap align="left"><span id="aTALLA" style="color:#000000; display:none;">*</span> TALLA</td>
                <td align="right"><span id="talla0"></span></td>
                <td><button class="botonhes grafi gtalla" id="graficaTALLA" style="font-size:0.8em; display:;">Gráfica TALLA</button></td>
              </tr>
              <tr height="1">
                <td align="left"><span id="aIMC" style="color:#000000;">*</span> IMC</td>
                <td align="right"><span id="imc0"></span></td>
                <td><button class="botonhes grafi gimc" id="graficaIMC" style="font-size:0.8em; display:;">Gráfica IMC</button></td>
              </tr>
              <tr>
                <td colspan="3" valign="top" style="font-size:1em; padding:1px; color:#b52327; max-width:110px;" align="left">
                	<div align="center">ALÉRGIAS:</div><span id="alergias0"></span>
				</td>
              </tr>
            </table>
            </td>
            <td>
            <input style="resize:none; text-align:left" name="notaMedicaC" id="notaMedicaC" type="text" placeholder="ESCRIBA AQUÍ LA NOTA MÉDICA" class="jqte-test required">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td id="contenedorDatatableDX" valign="top" style=" padding-top:0px;">
      <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" id="dataTableDX" class="tablilla">
        <thead id="cabecera_tBusquedaDX" class="miCabeceraDT">
          <tr>
            <th id="clickmeDX">#</th>
            <th>DIAGNÓSTICOS&nbsp;
            	<button id="b_dictamenC" class="ui-button ui-widget ui-corner-all ui-button-icon-only botonC busqueda" title="Buscar diagnósticos">
                	<span class="ui-icon ui-icon-search"></span>Buscar
              	</button>
            </th>
            <th>PRIMARIO</th>
          </tr>
        </thead>
        <tbody style=" color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    </td>
  </tr>
  </table>
  </div>

  <div id="tabs-2n" style="width:99%; height:91%; font-size:1em;"> 
  <table width="100%" height="95%" border="0" cellspacing="0" cellpadding="0" class="fondo_tab">
  <tr>
    <td height="100%" id="contenedorRF" valign="top">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr><td align="left"width="100%"nowrap valign="top" style="height:1px;">
      	Medicamentos&nbsp;
        <button id="b_medicamentosC" class="ui-button ui-widget ui-corner-all ui-button-icon-only botonC busqueda" title="Buscar medicamentos">
        <span class="ui-icon ui-icon-search"></span>Buscar medicamentos
      </button>
  
        <button id="imprimirRecetaF" style="font-size:0.8em; display:none;">Imprimir</button>
      </td></tr>
      <tr>
        <td id="recetaFrontC">
        </td>
      </tr>
      <tr>
        <td id="contenedorIndiF" align="left">Escriba las indicaciones:
        	<input style="resize:none; text-align:left" name="indiF" id="indiF" type="text" value="" class="jqte-test">
        </td>
      </tr>
    </table>
    </td>
  </tr>
  </table>
  </div>
  
  <div id="tabs-3n" style="width:99%; height:91%; font-size:0.8em;"> 
    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" class="fondo_tab">
      <tr height="1px">
        <td align="left"width="1%"nowrap valign="top">
        	Escriba las recomendaciones&nbsp;
            <button id="imprimirRecetaT" style="font-size:0.8em; display:none;">Imprimir</button>
        </td>
      </tr>
      <tr>
        <td id="contenedorIndiR"><textarea name="notaMedicamentosC" id="notaMedicamentosC" cols="1" rows="4" style="resize:none; height:110px;" onKeyUp="conMayusculas(this);"></textarea></td>
      </tr>
    </table>
  </div>
  
</form>
</div>