<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>

<div id="tabs_c" style="width:100%; height:99%; overflow:hidden;">
<form action="" method="post" name="formConsulta" id="formConsulta" target="_self" style="height:100%">
<input name="idUsuario_c" id="idUsuario_c" type="hidden" value=""> <input name="idPaciente_c" id="idPaciente_c" type="hidden" value="">
<input name="numeroTemporalC" id="numeroTemporalC" type="hidden" value="">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left">
    <ul style="font-size:0.8em;">
        <li><a class="tabs" id="tabs-1-1" href="#tabs-1" style="color:white; font-size:1em;">GENERALES</a></li>
        <li><a class="tabs" id="tabs-6-1" href="#tabs-6" style="color:white; font-size:1em;">S-V</a></li>
        <li><a class="tabs" id="tabs-2-1" href="#tabs-2" style="color:white; font-size:1em;">H-C</a></li>
        <li><a class="tabs" id="tabs-3-1" href="#tabs-3" style="color:white; font-size:1em;">NOTA EVOLUCIÓN</a></li>
        <li><a class="tabs" id="tabs-4-1" href="#tabs-4" style="color:white; font-size:1em;">RECETA (F)</a></li>
        <li><a class="tabs" id="tabs-6-1" href="#tabs-6" style="color:white; font-size:1em;">RECETA (R)</a></li>
        <li><a class="tabs" id="tabs-5-1" href="#tabs-5" style="color:white; font-size:1em;">EXPEDIENTE</a></li>
    </ul>
    </td>
    <td align="right" style="padding-right:20px;">
    <button id="finalizarConsulta" style="font-size:0.8em;">Guardar</button>&nbsp;
    <button id="salirSGconsulta" style="font-size:0.8em;">Salir</button>
    <!--<button id="imprimirReceta" style="font-size:0.8em;">Receta (F)</button> -->
    </td>
  </tr>
</table>
  
  <div id="tabs-1" style="width:99%; height:91%;">
  <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#844386" style="color:white">
    <tbody align="left">
      <tr>
        <td> 
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
          	<td class="titulosTabs">Paciente</td> 
            <td class="titulosTabs" width="130px">Edad</td> 
            <td class="titulosTabs" width="120px">Sexo</td> 
          </tr>
          <tr> 
          	<td><input name="pacienteC" id="pacienteC" type="text" readonly></td> 
            <td><input name="edadC" id="edadC" type="text" readonly></td> 
            <td><input name="sexoC" id="sexoC" type="text" readonly></td> 
          </tr>
        </table>
        </td>
        <td width="20%" style="max-width:100px;border:1px none gold;" rowspan="6" valign="top" id="miFotito"><ul id="gallery" style="border:1px none red; text-align:center;"> <!-- Cargar Fotos --> </ul></td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="200px"> 
                <table width="100%" border="0" cellspacing="2" cellpadding="2"> 
                    <tr> 
                        <td class="titulosTabs" align="left" nowrap width="1%">Fecha de consulta</td> 
                        <td width="80px"><input name="fechaIngresoC" id="fechaIngresoC" type="text" readonly></td> 
                    </tr> 
                </table> 
            </td>
            <td>
                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td class="titulosTabs" align="left" nowrap width="1%">Fecha/hora toma de signos</td>
                    <td width="150px"><input name="fechaSignosC" id="fechaSignosC" type="text" readonly></td>
                    <td width="" align="right">
                    	<button class="botonC bAgregar" name="b_agregarSignosC" id="b_agregarSignosC">Signos</button>&nbsp;
                        <button class="botonC bGraficas" name="b_graficasSignosC" id="b_graficasSignosC">Gráficas</button>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="1" cellspacing="0" cellpadding="2">
          <tr> 
          	<td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>Peso</td>
                <td><input name="pesoC" type="text" id="pesoC" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="6" style="text-align:right;" class="required" readonly></td><td align="left" class="titulosTabs">kg</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>Talla</td>
                <td><input name="tallaC" type="text" id="tallaC" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required" readonly></td><td align="left" class="titulosTabs">mts</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>IMC</td><td><input name="imcC"type="text" id="imcC" style="text-align:right;" readonly class="required"></td><td align="left" class="titulosTabs">kg/m^2</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>Cintura</td><td><input name="cinturaC"type="text"id="cinturaC"onKeyUp="numeros_decimales(this.value, this.name);"maxlength="6"style="text-align:right;" class="required" readonly></td>
                <td align="left" class="titulosTabs">cm</td>
              </tr>
            </table>
            </td> 
          </tr>
          <tr> 
          	<td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>T/A</td><td><input name="tC" type="text" id="tC" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required" readonly></td>
                <td align="left" class="titulosTabs" width="1px" nowrap>/</td><td><input name="aC" type="text" id="aC" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required" readonly></td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>FR</td><td><input name="frC" type="text" id="frC" onKeyUp="solo_numeros(this.value, this.name);" maxlength="3" style="text-align:right;" class="required" readonly></td>
                <td align="left" class="titulosTabs" nowrap>x min</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>FC</td><td><input name="fcC"type="text" id="fcC" onKeyUp="solo_numeros(this.value, this.name);" maxlength="4" style="text-align:right;" class="required" readonly></td>
                <td align="left" class="titulosTabs" nowrap>x min</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>Temp</td><td><input name="tempC"type="text"id="tempC"onKeyUp="numeros_decimales(this.value, this.name);"maxlength="6"style="text-align:right;" class="required" readonly></td>
                <td align="left"class="titulosTabs" nowrap>ºC</td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td align="left"class="titulosTabs"width="160px"nowrap>Notas signos vitales</td>
            <td><textarea name="notasC" id="notasC" cols="1" rows="2" style="resize:none;" readonly></textarea></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td align="left"class="titulosTabs"width="160px"nowrap>Motivo de la consulta</td>
            <td><textarea name="motivoC" id="motivoC" cols="1" rows="2" style="resize:none;" readonly></textarea></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td align="left"class="titulosTabs"width="160px"nowrap>Observaciones</td>
            <td><textarea name="observacionesC" id="observacionesC" cols="1" rows="2" style="resize:none;" onKeyUp="conMayusculas(this);"></textarea></td>
          </tr>
        </table>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  
  <div id="tabs-2" style="width:99%; height:91%;">
  	<input name="id_medicoCo" id="id_medicoCo" type="hidden" value="">
    <input name="id_DepartamentoCo" id="id_DepartamentoCo" type="hidden" value="">
    <input name="id_AreaCo" id="id_AreaCo" type="hidden" value="">
  </div>
  
  <div id="tabs-3" style="width:99%; height:92%; color:white; font-size:0.8em; background-color:#844386; overflow:auto;">
  <input name="id_medicoIm" id="id_medicoIm" type="hidden" value="">
  <input name="id_DepartamentoIm" id="id_DepartamentoIm" type="hidden" value="2">
  <table width="100%" height="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100%" id="contenedorNM">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr><td align="left"class="titulosTabs"width="100%"nowrap valign="top" style="height:1px;">
      	Nota de evolución médica&nbsp;<button id="imprimirNotaE" style="font-size:0.8em; display:none;">Imprimir</button>
      </td></tr>
      <tr>
        <td>
        <input style="resize:none; text-align:left" name="notaMedicaC" id="notaMedicaC" type="text" value="ESCRIBA AQUÍ LA NOTA DE EVOLUCIÓN MÉDICA" class="jqte-test">
        <input name="miDiagnostico" id="miDiagnostico" type="hidden">        
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td id="contenedorDatatableDX" valign="top" style=" padding-top:0px;">
      <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" id="dataTableDX" class="tablilla" bgcolor="#FFFFFF">
        <thead id="cabecera_tBusquedaDX" class="miCabeceraDT">
          <tr>
            <th style="color:white;" id="clickmeDX">#</th>
            <th style="color:white;">
            	DIAGNÓSTICOS&nbsp;<button class="botonC busqueda" name="b_dictamenC" id="b_dictamenC"> </button>
            </th>
          </tr>
        </thead>
        <tbody style=" color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    </td>
  </tr>
  </table>
  </div>

  <div id="tabs-4" style="width:99%; height:91%; color:white; font-size:0.8em; background-color:#844386;"> 
  <input name="id_medicoLab" id="id_medicoLab" type="hidden" value="">
  <input name="id_DepartamentoLab" id="id_DepartamentoLab" type="hidden" value="1">
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="contenedorDatatableMedicamentos" valign="top" style="padding-top:2px;">
      <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" id="dataTableMedi" class="tablilla" bgcolor="#FFFFFF">
        <thead id="cabecera_tBusquedaMedi" class="miCabeceraDT">
          <tr>
            <th id="clickmeMedi" style="color:white;">#</th>
            <th style="color:white;">
            	MEDICAMENTO&nbsp;<button class="botonC busqueda" name="b_medicamentosC" id="b_medicamentosC"> </button>
            </th>
            <th style="color:white;">PRESENTACIÓN</th>
            <th style="color:white;">CONCENTRACIÓN</th>
            <th style="color:white;">CANTIDAD</th>
            <th style="color:white;">UNIDAD</th>
            <th style="color:white;">PERIODICIDAD</th>
            <th style="color:white;">DURACIÓN</th>
          </tr>
        </thead>
        <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
      </table>
    </td>
  </tr>
  </table>
  </div>
  
  <div id="tabs-6" style="width:99%; height:91%; color:white; font-size:0.8em; background-color:#844386;"> 
    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td align="left"class="titulosTabs"width="1%"nowrap valign="top">Indicaciones</td>
        <td><textarea name="notaMedicamentosC" id="notaMedicamentosC" cols="1" rows="4" style="resize:none; height:110px;" onKeyUp="conMayusculas(this);"></textarea></td>
      </tr>
    </table>
  </div>
  
  <div id="tabs-5" style="width:99%; height:91%; color:white;">
  
  <input name="id_pMedico" id="id_pMedico" type="hidden" value=""><input name="id_DepartamentoSer" id="id_DepartamentoSer" type="hidden" value="4">
  <ul style="font-size:0.8em;">
      <li><a class="tabs" id="tabs-1-1h" href="#tabs-1h" style="color:white; font-size:1em;">CONSULTAS</a></li>
      <li><a class="tabs" id="tabs-2-1h" href="#tabs-2h" style="color:white; font-size:1em;">IMAGEN</a></li>
      <li><a class="tabs" id="tabs-3-1h" href="#tabs-3h" style="color:white; font-size:1em;">LABORATORIO</a></li>
      <li style="display:none;"><a class="tabs"id="tabs-4-1h" href="#tabs-4h" style="color:white; font-size:1em;">ENDOSCOPÍA</a></li>
      <li><a class="tabs" id="tabs-5-1h" href="#tabs-5h" style="color:white; font-size:1em;">SERVICIOS</a></li>
  </ul>
  
  <div id="tabs-1h" style="width:99%; height:92%; color:white; font-size:0.8em; background-color:#844386; padding-top:3px;">
  <table width="100%" height="91%" border="0" cellpadding="4" cellspacing="0" id="dataTableHCo" class="tablilla" bgcolor="#FFFFFF">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr>
        <th id="clickmeHCo" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">CONSULTA</th>
        <th style="color:white;">MÉDICO ATENDIÓ</th>
      </tr>
    </thead>
    <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
  <div id="tabs-2h" style="width:99%; height:92%; color:white; font-size:0.8em; background-color:#844386; padding-top:3px;">
  <table width="100%" height="91%" border="0" cellpadding="4" cellspacing="0" id="dataTableHIm" class="tablilla" bgcolor="#FFFFFF">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr>
        <th id="clickmeHIm" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">ESTUDIO</th>
        <th style="color:white;">MÉDICO INTERPRETÓ</th>
      </tr>
    </thead>
    <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
  <div id="tabs-3h" style="width:99%; height:92%; color:white; font-size:0.8em; background-color:#844386; padding-top:3px;">
  <table width="100%" height="93%" border="0" cellpadding="4" cellspacing="0" id="dataTableHLa" class="tablilla" bgcolor="#FFFFFF">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr>
        <th id="clickmeHLa" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">ESTUDIO</th>
        <th style="color:white;">QUÍMICO RESPONSABLE</th>
      </tr>
    </thead>
    <tbody style="color:black"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
  <div id="tabs-4h" style="width:99%; height:92%; color:white; font-size:0.8em; background-color:#844386; padding-top:3px;">
  <table width="100%" height="94%" border="0" cellpadding="4" cellspacing="0" id="dataTableHEn" class="tablilla" bgcolor="#FFFFFF">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr>
        <th id="clickmeHEn" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="130px">ESTUDIO</th>
        <th style="color:white;">MÉDICO REALIZÓ</th>
      </tr>
    </thead>
    <tbody style="text-shadow:1px 1px 1px white;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
  <div id="tabs-5h" style="width:99%; height:92%; color:white; font-size:0.8em; background-color:#844386; padding-top:3px;">
  <table width="100%" height="90%" border="0" cellpadding="4" cellspacing="0" id="dataTableHSe" class="tablilla" bgcolor="#FFFFFF">
    <thead id="cabecera_tBusquedaHco" class="miCabeceraDT">
      <tr>
        <th id="clickmeHSe" style="color:white;" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" width="">SERVICIO</th>
        <th style="color:white;">PERSONAL ATENDIÓ</th>
      </tr>
    </thead>
    <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
</div>
  
<div id="tabs-6" style="width:99%; height:91%; color:white; font-size:0.8em;">
 
<div id="tabs_sv" style="width:100%; height:100%;">
<form action="" method="post" name="formSignosVitales" id="formSignosVitales" target="_self" style="height:100%">
<input name="idUsuario_sv" id="idUsuario_sv" type="hidden" value=""> <input name="idPaciente_sv" id="idPaciente_sv" type="hidden" value="">
<input name="numeroTemporalSV" id="numeroTemporalSV" type="hidden" value="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:0.9em;">
  <tr>
    <td>
    <ul>
        <li><a id="tabs-1-1s" href="#tabs-1s" style="color:white; font-size:1em;">ÚLTIMOS</a></li>
        <li><a id="tabs-2-1s" href="#tabs-2s" style="color:white; font-size:1em;">RIESGOS</a></li>
        <li><a id="tabs-3-1s" href="#tabs-3s" style="color:white; font-size:1em;">RECOMENDACIONES</a></li>
        <li><a id="tabs-4-1s" href="#tabs-4s" style="color:white; font-size:1em;">HISTORIAL</a></li>
        <li><a id="tabs-5-1s" href="#tabs-5s" style="color:white; font-size:1em;">ESTADISTICAS</a></li>
    </ul>
    </td>
    <!--<td align="right" style="padding-right:15px;"> <button id="tomarNSV">Tomar</button>
    <button id="saveNSV">Guardar</button>&nbsp; <button id="cancelNSV">Cancelar</button> </td> -->
  </tr>
</table>
  
  <div id="tabs-1s" style="width:99%; height:93%; background-color:#844386; color:white;">
  <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody align="left">
      <tr>
        <td> 
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr> 
                <td class="titulosTabs">Paciente</td> 
                <td class="titulosTabs" width="130px">Edad</td> 
                <td class="titulosTabs" width="120px">Sexo</td> 
              </tr>
              <tr> 
                <td><input name="pacienteSV" id="pacienteSV" type="text" readonly></td> 
                <td><input name="edadSV" id="edadSV" type="text" readonly></td> 
                <td><input name="sexoSV" id="sexoSV" type="text" readonly></td> 
              </tr>
            </table>
        </td>
        <td width="20%" style="max-width:100px;border:1px none gold;" rowspan="3" valign="top" id="miFotito">
        	<ul id="gallery" style="border:1px none red; text-align:center;"> <!-- Cargar Fotos --> </ul>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="1" cellspacing="0" cellpadding="2">
          <tr> 
          	<td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>Peso</td>
                <td>
                <input name="pesoSV" type="text" id="pesoSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="6" style="text-align:right;" class="required">
                </td>
                <td align="left" class="titulosTabs">kg</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>Talla</td>
                <td><input name="tallaSV" type="text" id="tallaSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required"></td><td align="left" class="titulosTabs">mts</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>IMC</td>
                <td><input name="imcSV"type="text" id="imcSV" style="text-align:right;" readonly class="required"></td>
                <td align="left" class="titulosTabs">kg/m^2</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>Cintura</td><td><input name="cinturaSV"type="text"id="cinturaSV"onKeyUp="numeros_decimales(this.value, this.name);"maxlength="6"style="text-align:right;" class="required"></td>
                <td align="left" class="titulosTabs">cm</td>
              </tr>
            </table>
            </td> 
          </tr>
          <tr> 
          	<td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>T/A</td>
                <td><input name="tSV" type="text" id="tSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required"></td>
                <td align="left" class="titulosTabs" width="1px" nowrap>/</td>
                <td><input name="aSV" type="text" id="aSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required"></td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left" class="titulosTabs" width="1px" nowrap>FR</td><td><input name="frSV" type="text" id="frSV" onKeyUp="solo_numeros(this.value, this.name);" maxlength="3" style="text-align:right;" class="required"></td>
                <td align="left" class="titulosTabs" nowrap>x min</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>FC</td><td><input name="fcSV"type="text" id="fcSV" onKeyUp="solo_numeros(this.value, this.name);" maxlength="4" style="text-align:right;" class="required"></td>
                <td align="left" class="titulosTabs" nowrap>x min</td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
              	<td align="left"class="titulosTabs"width="1px"nowrap>Temp</td><td><input name="tempSV"type="text"id="tempSV"onKeyUp="numeros_decimales(this.value, this.name);"maxlength="5"style="text-align:right;" class="required"></td>
                <td align="left"class="titulosTabs" nowrap>ºC</td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td align="left"class="titulosTabs"width="1px"nowrap valign="top">Notas</td>
            <td>
            <textarea name="notasSV" id="notasSV" cols="1" rows="2" style="resize:none; height:50px;" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></textarea>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  
<div id="tabs-2s" style="width:99%; height:93%; background-color:#844386; color:white;">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td style="font-size:1.1em; color:black;">
  	CLASIFICACIÓN DEL PACIENTE EN CUANTO A SOBREPESO Y <span class="mouseOver" title="La obesidad es una enfermedad sistemática, crónica, progresiva y multifactorial que se define como una acumulación anormal o excesiva de grasa. En su etiología se involucran alteraciones en el gasto energético, desequilibrio en el balance entre el aporte y utilización de las grasas, causas de caracter neuroendocrino, metabólicas, genéticas, factores del medio ambiente y psicógenas. La obesidad se clasifica fundamentalmente con base en el índice de masa corporal (IMC) o índice de Quetelet, que se define como el peso en kg dividido por la talla expresada en metros y elevada al cuadrado, en el adulto un IMC >= 30 kg/m^2 determina obesidad.">OBESIDAD</span>.
  </td> </tr>
  <tr>
    <td align="justify">De acuerdo a los datos proporcionados en los signos vitales del paciente con un <span class="mouseOver" title="El índice de masa corporal (IMC) es una medida de asociación entre la masa y la talla de un individuo ideada por el estadístico belga Adolphe Quetelet, por lo que también se conoce como índice de Quetelet.
Se calcula según la expresión matemática: IMC = masa/(estatura^2). Donde la masa se expresa en kilogramos y el cuadrado de la estatura en metros cuadrados">IMC</span> de <span id="miIMC" style="text-decoration:underline;"></span> y una medida de circunferencia de cintura de <span id="miMedidaCintura" style="text-decoration:underline;"></span> cms</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr>
      	<td>IMC (kg/m^2)</td>
        <td>CLASIFICACIÓN</td>
      </tr>
      <tr>
      	<td class="normalIMC">18.50 - 24.99</td>
        <td align="left" class="normalIMC">Rango normal</td>
      </tr>
      <tr>
      	<td>>= 25.00</td>
        <td align="left">Sobrepeso</td>
      </tr>
      <tr>
      	<td class="sobrepesoIMC">25.00 - 29.99</td>
        <td class="sobrepesoIMC" align="left">Preobesidad</td>
      </tr>
      <tr>
      	<td>>= 30.00</td>
        <td align="left">Obesidad</td>
      </tr>
      <tr>
      	<td class="obesidad1IMC">30.00 - 34.99</td>
        <td class="obesidad1IMC" align="left">Clase I</td>
      </tr>
      <tr>
      	<td class="obesidad2IMC">35.00 - 39.99</td>
        <td class="obesidad2IMC" align="left">Clase II</td>
      </tr>
      <tr>
      	<td class="obesidad3IMC">>= 40.00</td>
        <td class="obesidad3IMC" align="left">Clase III</td>
      </tr>
      <tr>
        <td colspan="2" align="justify" style="font-size:0.8em; color:black; opacity:0.7;">
        	Fuente: World Health Organization 
        	<span style="cursor:pointer" onClick="window.open('http://www.who.int/bmi/index.jsp?introPage=intro_3.html');">
            	http://www.who.int/bmi/index.jsp?introPage=intro_3.html
            </span>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="justify">* Esto indica que el paciente <span id="miRiesgoP" style="text-decoration:underline;"></span> de contraer <span id="defDiabetes" class="mouseOver" title="La diabetes mellitus tipo 2 es un trastorno metabólico que se caracteriza por hiperglucemia (nivel alto de azúcar en la sangre) en el contexto de resistencia a la insulina y falta relativa de insulina; en contraste con la diabetes mellitus tipo 1, en la que hay una falta absoluta de insulina debido a la destrucción de los islotes pancreáticos. Los síntomas clásicos son sed excesiva, micción frecuente y hambre constante. La diabetes tipo 2 representa alrededor del 90 % de los casos de diabetes, con el otro 10 % debido principalmente a la diabetes mellitus tipo 1 y la diabetes gestacional. Se piensa que la obesidad es la causa primaria de la diabetes tipo 2 entre personas con predisposición genética a la enfermedad.">diebetes mellitus tipo 2</span>, <span class="mouseOver" id="defHipertension" title="La hipertensión arterial (HTA) es una enfermedad crónica caracterizada por un incremento continuo de las cifras de la presión sanguínea en las arterias. Aunque no hay un umbral estricto que permita definir el límite entre el riesgo y la seguridad, de acuerdo con consensos internacionales, una presión sistólica sostenida por encima de 139 mmHg o una presión diastólica sostenida mayor de 89 mmHg, están asociadas con un aumento medible del riesgo de aterosclerosis y por lo tanto, se considera como una hipertensión clínicamente significativa.">hipertensión</span> y <span class="mouseOver" id="defEnfermedadC" title="En sentido amplio, el término cardiopatía (del gr. kardí(ā) καρδία 'corazón' y pátheia πάθεια 'enfermedad') puede englobar a cualquier padecimiento del corazón o del resto del sistema cardiovascular. Habitualmente se refiere a la enfermedad cardíaca producida por asma o por colesterol.
Sin embargo, en sentido estricto se suele denominar cardiopatía a las enfermedades propias de las estructuras del corazón.">enfermedad cardiovascular</span></td>
  </tr>
  <tr>
    <td style="font-size:1.1em; color:black;">RIESGO DE ENFERMEDAD PARA EL PACIENTE SEGUN LA MEDIDA DE LA CIRCUNFERENCIA DE SU CINTURA E IMC</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr>
        <td>IMC</td>
        <td colspan="2">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Cintura <strong>hombres</strong> < 90 cms</td>
            <td>Cintura <strong>hombres</strong> > 90 cms</td>
          </tr>
          <tr>
            <td>Cintura <strong>mujeres</strong> < 80 cms</td>
            <td>Cintura <strong>mujeres</strong> > 80 cms</td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>18.5 - 29.5</td>
        <td class="imc_1_1">Sin riesgo</td>
        <td class="imc_1_2">Riesgo alto</td>
      </tr>
      <tr>
        <td>25.0 - 29.9</td>
        <td class="imc_2_1">Riesgo moderado</td>
        <td class="imc_2_2">Riesgo alto</td>
      </tr>
      <tr>
        <td>30.0 - 39.9</td>
        <td class="imc_3_1">Alto a muy alto riesgo</td>
        <td class="imc_3_2">Muy alto riesgo</td>
      </tr>
      <tr>
        <td> > 40 </td>
        <td class="imc_4_1">Extremadamente alto</td>
        <td class="imc_4_2">Extremadamente alto</td>
      </tr>
      <tr>
        <td colspan="3" align="justify" style="font-size:0.8em; color:black; opacity:0.7;">
        Fuente: 
        <span style="cursor:pointer" onClick="window.open('http://www.cenetec.salud.gob.mx/descargas/gpc/CatalogoMaestro/046_GPC_ObesidadAdulto/IMSS_046_08_GRR.pdf');">
        National Health and Medical Research Council. Clinical Practice Guidelines for the Management of Overweight and Obesity in Adults. Australia 2003.
        </span>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</div>
  
<div id="tabs-3s" style="width:99%; height:93%; background-color:#844386; color:white;">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
	<td align="justify">
    De acuerdo con la tabla de IMC para el <span class="mouseOver" title="Los factores de riesgo cardiovascular asociados con la obesidad en la infancia y adolescencia son: hipertensión arterial, dislipidemia, hiperinsulinemia y alteraciones en la masa ventricular cardiaca izquierda.">riesgo de enfermedad</span> en adultos con sobrepeso y obesidad, el paciente se encuantra <span id="miRiesgoE" style="text-decoration:underline"></span>.
    </td>
</tr>
<tr>
	<td align="justify" style="color:white;"> Se recomienda que: </td>
</tr>
<tr id="recomendacionRN">
	<td align="left">
    <li> Se oriente al paciente en una adecuada educación alimentaria.</li>
    <li> Se sugiera un programa de actividad física regular moderada de cuatro veces por semana.</li>
    <li> Recomendar al paciente que evite el alcoholismo y el tabaquismo, que modere la ingesta de café, fomentar la higiene del  sueño y control de estrés.</li>
    <li> Que mantenga vigilado su IMC semestralmente y utilice <span class="mouseOver">medidas de prevención primaria</span>.</li>
    </td>
</tr>
<tr id="recomendacionSP">
	<td align="left">
    <table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2" align="center" style="color:white">El paciente cuenta con enfermedades o condiciones asociadas</td>
      </tr>
      <tr align="center">
        <td width="50%">NO</td>
        <td>SI</td>
      </tr>
      <tr align="justify">
        <td>
        <li> Sugerir un programa dietético personalizado.</li>
        <li> Establecer metas de reducción de peso óptimas (reducción del 5%-10% del peso corporal o reducción de 0.5 a 1 kg por semana por 6 meses).</li>
        <li> Actividad física regular aeróbica moderada individualizada por 155 a 255 minutos por semana.</li>
        <li> Evaluación psicológica y social para la identificación de barreras que limiten el seguimiento de un tratamiento.</li>
        </td>
        <td>
        <li> Manejo integral de la comorbilidad.</li>
        <li> Atención y manejo por equipo transdisciplinario:<br>-Licenciado en nutición, Nutricionista/Dietista<br>-Psicólogo<br>-Trabajo Social<br>-Médico Internista/Endocrinólogo</li>
        <li> Establecer un plan dieto-Terapéutico individualizado, actividad física y cambios en estilos de vida saludable.</li>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" style="color:white;">Logro de metas y éxito terapéutico</td>
      </tr>
      <tr align="center">
        <td>SI</td>
        <td>NO</td>
      </tr>
      <tr>
        <td>Vigilar y promover mantenimiento de reducción de peso, seguimiento al IMC y circunferencia abdominal.</td>
        <td>Volver al principio</td>
      </tr>
    </table>
    </td>
</tr>
<tr id="recomendacionOB">
	<td align="left">
    <table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2">
        <li> Crear e iniciar inmediatamente un programa individualizado y adecuado de dieta para el paciente.</li>
        <li> Crear e iniciar inmediatamente un <span class="mouseOver">programa individualizado y adecuado de actividad física</span> para el paciente.</li>
        <li> Crear e iniciar inmediatamente un programa individualizado y adecuado de terepia cognitivo-conductual para el paciente.</li>
        <li> Apoyo <span class="mouseOver">psicosocial</span>.</li>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center" style="color:white;">
        Éxito terapéutico con evidencia de apego
        </td>
      </tr>
      <tr align="center">
        <td width="50%">SI</td>
        <td>NO</td>
      </tr>
      <tr align="justify">
        <td>
        <li> Reforzar estilos de vida saludables adquiridos.</li>
        <li> Vigilancia estrecha mensual del control de peso por un lapso de 12 meses y en fechas críticas(festividades, reuniones ,etc.).</li>
        <li> Mantener comunicación continua e información de los riesgos y beneficios de los fármacos administrados.</li>
        <li> Continuar con la terapia conductual.</li>
        </td>
        <td>
        <li> Indagar falta de apego al tratamiento farmacológico y no farmacológico.</li>
        <li> Investigar transtornos del estado de ánimo.</li>
        <li> Investigar transtornos de alimentación.</li>
        <li> Investigar transtornos metabólicos.</li>
        <li> Investigar interacciones farmacológicas que influyan en la ganancia de peso.</li>
        <li> Evaluar la adición de otras opciones de tratamiento.</li>
        </td>
      </tr>
    </table>
    </td>
</tr>
</table>
</div>

  <div id="tabs-4s" style="width:99%; height:93%; background-color:#844386; color:white; padding-top:3px;"> 
  <input name="id_medicoLab" id="id_medicoLab" type="hidden" value="">
  <input name="id_DepartamentoLab" id="id_DepartamentoLab" type="hidden" value="1">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTableSV" class="tablilla" style="color:white;" bgcolor="#FFFFFF">
    <thead id="cabecera_tBusquedaSV">
      <tr>
        <th style="color:white;" id="clickmeSV" width="1px">#</th>
        <th style="color:white;" width="10px">FECHA</th>
        <th style="color:white;" nowrap>PESO(kg)</th>
     	<th style="color:white;" nowrap>TALLA(mts)</th>
        <th style="color:white;" nowrap>IMC(kg/m^2)</th>
		<th style="color:white;" nowrap>CINTURA(cm)</th>
        <th style="color:white;" nowrap>T/A</th>
		<th style="color:white;" nowrap>FR(xMin)</th>
        <th style="color:white;" nowrap>FC(xMin)</th>
        <th style="color:white;" nowrap>T(ºc)</th>
      </tr>
    </thead>
    <tbody style="color:navy; font-size:0.9em;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
  
<div id="tabs-5s" style="width:99%; height:93%; background-color:#844386; color:white; padding-top:1px;"> 
<input name="id_pMedico" id="id_pMedico" type="hidden" value="">
<input name="id_DepartamentoSer" id="id_DepartamentoSer" type="hidden" value="4">
	<table id="grafiasSV" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#CCC;">
      <tr>
        <td width="50%" height="50%">
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> <td height="1%" align="center" width="">IMC</td> </tr>
          <tr> <td id="contenedorCH"><canvas class="miCanva" id="myChartIMC" ></canvas></td> </tr>
        </table>
        </td>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> <td height="1%" align="center">T/A</td> </tr>
          <tr> <td id="contenedorCHta"><canvas class="miCanva" id="myChartTA" ></canvas></td> </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> <td height="1%" align="center">FR</td> </tr>
          <tr> <td id="contenedorCHfr"><canvas class="miCanva" id="myChartFR" ></canvas></td> </tr>
        </table>
        </td>
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> <td height="1%" align="center">FC</td> </tr>
          <tr> <td id="contenedorCHfc"><canvas class="miCanva" id="myChartFC" ></canvas></td> </tr>
        </table>
        </td>
      </tr>
    </table>
</div>
  
</form>
</div>
  
</div>
  
</form>
</div>

</body>
</html>
