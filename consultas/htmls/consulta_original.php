<div id="tabs_c" style="width:100%; height:99%; overflow:hidden;">
<form action="" method="post" name="formConsulta" id="formConsulta" target="_self" style="height:100%">
<input name="idUsuario_c" id="idUsuario_c" type="hidden" value=""> 
<input name="idPaciente_c" id="idPaciente_c" type="hidden" value="">
<input name="numeroTemporalC" id="numeroTemporalC" type="hidden" value="">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left">
    <ul style="font-size:0.8em;">
        <li><a class="tabs" id="tabs-6-1" href="#tabs-6" style="font-size:1em;">S-V</a></li>
        <li><a class="tabs" id="tabs-2-1" href="#tabs-2" style="font-size:1em;">H-C</a></li>
        <li><a class="tabs" id="tabs-3-1" href="#tabs-3" style="font-size:1em;">NOTA MÉDICA</a></li>
        <li><a class="tabs" id="tabs-4-1" href="#tabs-4" style="font-size:1em;">RECETA</a></li>
        <li><a class="tabs" id="tabs-8-1" href="#tabs-8" style="font-size:1em;">IMÁGENES</a></li>
        <li id="tabRevisiones" style="display:none;"><a class="tabs" id="tabs-5-1" href="#tabs-5" style="font-size:1em;">REVISIONES</a></li>
        <li style="display:none;"><a class="tabs" id="tabs-9-1" href="#tabs-9" style="font-size:1em;">oculta</a></li>
    </ul>
    </td>
    <td align="right" style="padding-right:20px;">
    <button id="salvarConsulta" style="font-size:0.8em;">Guardar</button>
    <button id="finalizarConsulta" style="font-size:0.8em;">Finalizar</button>
    <button id="salirSGconsulta" style="font-size:0.8em;">Salir</button>
    <button id="hospitalizarP" style="font-size:0.8em;">Hospitalizar</button>
    </td>
  </tr>
</table>

	<div class="miTab" id="tabs-9">
        <canvas id="miFotoX" width="700" height="525"></canvas>
        <canvas id="miFotoX1" width="200" height="150"></canvas>
      </div>
  
  <div id="tabs-8" style="width:99%; height:91%;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2" id="tablaVideos" class="fondo_tab">
      <tr>
        <td id="celdaVideo" width="60%" valign="top">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
       	  <tr style="display:none;">
            <td id="imagenesEndo" valign="top"></td>
          </tr>
          <tr height="1%">
            <td valign="top">
            	<button class="botonE" id="start">Iniciar video</button> 
                <button class="botonE" id="capture">Capturar imagen</button>
                <button class="botonE" id="stop">Detener video</button>
            </td>
          </tr>
          <tr>
            <td id="contenedorVideo" valign="top"><video id="video" autoplay width="" height=""></video></td>
          </tr>
        </table>
        </td>
        <td  id="contenedorCanvas" valign="top" style="overflow:scroll;">
        <div id="divCanvas">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
          <td id="deCanvas" align="center" valign="top" align="center"></td>
          </tr>
        </table>
        </div>
        </td>
        <td width="35%" id="contieneImgUsg" style="display:none;">
        <div id="miDivImgs" style="height:100%; overflow:scroll; border:1px none green; vertical-align:middle;">
        	<table id="imgUsg" width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" align="center" style="vertical-align:middle;"> </table>
        </div>
        </td>
      </tr>
    </table>
  </div>
    
  <div id="tabs-2" style="width:99%; height:91%;" class="">
  	<input name="id_medicoCo" id="id_medicoCo" type="hidden" value="">
    <input name="id_DepartamentoCo" id="id_DepartamentoCo" type="hidden" value="">
    <input name="id_AreaCo" id="id_AreaCo" type="hidden" value="">
  </div>
  
  <div id="tabs-3" style="width:99%; height:94%; font-size:0.8em; overflow:auto;">
  <input name="id_medicoIm" id="id_medicoIm" type="hidden" value="">
  <input name="id_DepartamentoIm" id="id_DepartamentoIm" type="hidden" value="2">
  <table width="100%" height="98%" border="0" cellspacing="0" cellpadding="0" class="fondo_tab">
  <tr>
    <td height="100%" id="contenedorNM">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
      	<td align="left"width="100%"nowrap valign="top" style="height:1px;">
        	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="250" align="left" style="padding-left:15px;">SIGNOS VITALES</td>
                <td align="center">
                	NOTA MÉDICA&nbsp;
                    <button id="imprimirNotaE" style="font-size:0.8em; display:none;" class="ui-button ui-widget ui-corner-all">
                        <span class="ui-icon ui-icon-print"></span> IMPRIMIR
                      </button>
                </td>
                <td width="250" align="right">
                <button id="dictado" onclick="procesarV()"class="ui-button ui-widget ui-corner-all" style="font-size:0.8em;"><span class="ui-icon ui-icon-pencil"></span> INICIAR DICTADO</button>
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
                	<span id="usuario_svi">USER</span> <span id="fechaHoraC">15/10/15 22:49</span>
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
                <td colspan="3" valign="top" style="font-size:0.8em; padding:1px; color:#b52327; max-width:110px;" align="left">
                	<div align="center">ALÉRGIAS:</div><span id="alergias0"></span>
				</td>
              </tr>
            </table>
            </td>
            <td>
            <input style="resize:none; text-align:left" name="notaMedicaC" id="notaMedicaC" type="text" value="" class="jqte-test">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  </table>
  </div>

  <div id="tabs-4" style="width:99%; height:92%; font-size:1em;"> 
  <table width="100%" height="99%" border="0" cellspacing="0" cellpadding="0" class="fondo_tab">
  <tr>
    <td height="100%" id="contenedorRF" valign="top">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr><td align="left"width="100%"nowrap valign="top" style="height:1px;">
      	Receta (frontal)
        <button id="imprimirRecetaF" style="font-size:0.8em; display:none;" class="ui-button ui-widget ui-corner-all">
        	<span class="ui-icon ui-icon-print"></span> IMPRIMIR
      	</button>
      </td></tr>
      <tr>
        <td id="contenedorIndiF" align="left">
        	<input style="resize:none; text-align:left" name="indiF" id="indiF" type="text" value="" class="jqte-test">
        </td>
      </tr>
    </table>
    </td>
  </tr>
  </table>
  </div>
  
  <div id="tabs-5" style="width:99%; height:91%; color:black; font-size:0.8em; border:1px solid #999; background-color:white;">
  
</div>
  
<div id="tabs-6" style="width:99%; height:91%; font-size:0.8em;" class="">
 
<div id="tabs_sv" style="width:100%; height:100%;" class="fondoDataT">
<form action="" method="post" name="formSignosVitales" id="formSignosVitales" target="_self" style="height:100%">
<input name="idUsuario_sv" id="idUsuario_sv" type="hidden" value=""> <input name="idPaciente_sv" id="idPaciente_sv" type="hidden" value="">
<input name="numeroTemporalSV" id="numeroTemporalSV" type="hidden" value="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:0.9em;">
  <tr>
    <td>
    <ul>
        <li><a id="tabs-1-1s" href="#tabs-1s" style="font-size:1em;">ÚLTIMA TOMA</a></li>
        <li><a id="tabs-2-1s" href="#tabs-2s" style="font-size:1em;">RIESGOS</a></li>
        <li><a id="tabs-3-1s" href="#tabs-3s" style="font-size:1em;">RECOMENDACIONES</a></li>
        <li><a id="tabs-4-1s" href="#tabs-4s" style="font-size:1em;">HISTORIAL</a></li>
        <li><a id="tabs-5-1s" href="#tabs-5s" style="font-size:1em;">ESTADISTICAS</a></li>
    </ul>
    </td>
    <td align="right"><button class="botonC bAgregar" name="b_agregarSignosC" id="b_agregarSignosC" style="font-size:1em;">Signos vitales</button></td>
  </tr>
</table>
  
  <div id="tabs-1s" style="width:99%; height:93%;">
  <table width="100%" height="100%" border="0" align="center" cellpadding="4" cellspacing="4" class="fondoDataT" style="font-size:0.9em; overflow:hidden;"> <tbody align="left">
      <tr height="1%">
        <td valign="top"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr class="titulos_dataceldas"> 
                <td width="1%">PACIENTE</td>
                <td id="campo_paciente_sv" align="left" nowrap><input name="pacienteSV" id="pacienteSV" type="text" readonly></td>
                <td width="1%">EDAD</td> 
                <td align="left" nowrap width="100px"><input name="edadSV" id="edadSV" type="text" readonly></td> 
                <td width="1%">SEXO</td> 
                <td id="campo_sx_sv" align="left" nowrap width="130px"><input name="sexoSV" id="sexoSV" type="text" readonly></td> 
              </tr>
              <tr class="titulos_dataceldas"> 
                <td align="left" nowrap>FECHA CONSULTA</td> 
                <td colspan="1"><input name="fechaIngresoC" id="fechaIngresoC" type="text" readonly></td> 
                <td align="left" nowrap>FECHA SIGNOS VITALES</td>
                <td colspan="3"><input name="fechaSignosC" id="fechaSignosC" type="text" readonly></td>
              </tr>
            </table>
        </td>
        <td width="20%" style="max-width:100px;border:1px none gold;" rowspan="3" valign="top" id="miFotito">
            <ul id="gallery" style="border:1px none red; text-align:center;"> <!-- Cargar Fotos --> </ul>
        </td>
      </tr>
      <tr height="1%" class="titulos_dataceldas">
        <td>
        <table width="100%" height="1%" border="0" cellspacing="2" cellpadding="4" id="tabla_sv">
          <tr>
            <td align="right">PESO</td>
            <td><input name="pesoSV" type="text" id="pesoSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="6" style="text-align:right;" class="required ignore sv_ro"></td>
            <td style="opacity:0.7;">kg</td>
            <td align="right">TALLA</td>
            <td><input name="tallaSV" type="text" id="tallaSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="5" style="text-align:right;" class="required ignore sv_ro"></td>
            <td style="opacity:0.7;">mts</td>
            <td align="right">IMC</td>
            <td><input name="imcSV"type="text" id="imcSV" style="text-align:right;" readonly class="required ignore"></td>
            <td style="opacity:0.7;">kg/m^2</td>
          </tr>
          <tr>
            <td align="right">T/A</td>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td><input name="tSV" type="text" id="tSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required ignore sv_ro"></td>
                    <td>/</td>
                    <td><input name="aSV" type="text" id="aSV" onKeyUp="numeros_decimales(this.value, this.name);" maxlength="4" style="text-align:right;" class="required ignore sv_ro"></td>
                  </tr>
                </table>
            </td>
            <td style="opacity:0.7;">mm Hg</td>
            <td align="right">FR</td>
            <td><input name="frSV" type="text" id="frSV" onKeyUp="solo_numeros(this.value, this.name);" maxlength="3" style="text-align:right;" class="required ignore sv_ro"></td>
            <td nowrap style="opacity:0.7;">x min</td>
            <td align="right">FC</td>
            <td><input name="fcSV"type="text" id="fcSV" onKeyUp="solo_numeros(this.value, this.name);" maxlength="4" style="text-align:right;" class="required ignore sv_ro"></td>
            <td style="opacity:0.7;">x min</td>
          </tr>
          <tr>
            <td align="right">OXIMETRÍA</td>
            <td><input name="oxiSV" type="text" id="oxiSV" onKeyUp="solo_numeros(this.value, this.name);" maxlength="3" style="text-align:right;" class="sv_ro"></td>
            <td nowrap style="opacity:0.7;">% SaO<sub>2</sub></td>
            <td align="right">CINTURA</td>
            <td><input name="cinturaSV"type="text"id="cinturaSV"onKeyUp="numeros_decimales(this.value, this.name);"maxlength="6"style="text-align:right;" class="sv_ro"></td>
            <td style="opacity:0.7;">cm</td>
            <td align="right">TEMP</td>
            <td><input name="tempSV"type="text"id="tempSV"onKeyUp="numeros_decimales(this.value, this.name);"maxlength="5"style="text-align:right;" class="required ignore sv_ro"></td>
            <td style="opacity:0.7;">ºC</td>
          </tr>
        </table>
        </td>
      </tr>
      <tr height="1%" class="titulos_dataceldas">
        <td valign="top">
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr style="font-weight:bold;">
          	<td align="left"width="1%"nowrap valign="top">MOTIVO DE CONSULTA:</td>
            <td valign="top" id="motivoC" nowrap width="45%"></td>
            <td align="left"width="1%"nowrap valign="top" id="texto_notas_sv">NOTAS:</td>
            <td id="notasSV" width="" nowrap> </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr height="1%">
        <td valign="top" align="center" colspan="2" class="ui-widget-header">CALCULADORA MÉDICA</td>
      </tr>
      <tr class="titulos_dataceldas">
        <td valign="top" align="center" colspan="2">
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="1%" nowrap align="left">ABERTURA OCULAR</td>
            <td align="left" id="conte_a_ocu"><select name="abertura_ocular" id="abertura_ocular" class="escala_g sv_ro" onChange="checarEscala(this.id)">
              <option value="0">-SELECCIONAR-</option>
              <option value="1">NINGUNA</option>
              <option value="2">DOLOR</option>
              <option value="3">VOZ</option>
              <option value="4">ESPONTÁNEA</option>
            </select></td>
            <td width="50px" nowrap align="right" id="ocular_val" class="abertura_ocular">0</td>
          </tr>
          <tr>
            <td width="1%" nowrap align="left">RESPUESTA VERBAL</td>
            <td align="left" id="conte_r_ver">
            <select name="respuesta_verbal" id="respuesta_verbal" class="escala_g sv_ro" onChange="checarEscala(this.id)">
              <option value="0">-SELECCIONAR-</option>
              <option value="1">NINGUNA</option>
              <option value="2">SONIDOS</option>
              <option value="3">INAPROPIADA</option>
              <option value="4">CONFUSA</option>
              <option value="5">ORIENTADA</option>
            </select>
            </td>
            <td nowrap align="right" id="verbal_val" class="respuesta_verbal">0</td>
          </tr>
          <tr>
            <td width="1%" nowrap align="left">RESPUESTA MOTRIZ</td>
            <td align="left" id="conte_r_mot">
            <select name="respuesta_motriz" id="respuesta_motriz" class="escala_g sv_ro" onChange="checarEscala(this.id)">
              <option value="0">-SELECCIONAR-</option>
              <option value="1">NINGUNA</option>
              <option value="2">EXTENSIÓN</option>
              <option value="3">FLEXIÓN</option>
              <option value="4">RETIRADA</option>
              <option value="5">LOCALIZA</option>
              <option value="6">OBEDECE</option>
            </select>
            </td>
            <td nowrap align="right" id="motriz_val" class="respuesta_motriz">0</td>
          </tr>
          <tr>
            <td width="1%" nowrap align="left"></td>
            <td align="right">PUNTUACIÓN</td>
            <td nowrap align="right" id="total_escala_g">0</td>
          </tr>
        </table>
        </td>
      </tr>
    </tbody> </table>
  </div>
  
<div id="tabs-2s" style="width:99%; height:93%; font-size:0.9em;">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="fondo_tab">
  <tr> <td style="font-size:1.1em;" class="ui-widget-header">
  	CLASIFICACIÓN DEL PACIENTE EN CUANTO A SOBREPESO Y <span class="mouseOver" title="La obesidad es una enfermedad sistemática, crónica, progresiva y multifactorial que se define como una acumulación anormal o excesiva de grasa. En su etiología se involucran alteraciones en el gasto energético, desequilibrio en el balance entre el aporte y utilización de las grasas, causas de caracter neuroendocrino, metabólicas, genéticas, factores del medio ambiente y psicógenas. La obesidad se clasifica fundamentalmente con base en el índice de masa corporal (IMC) o índice de Quetelet, que se define como el peso en kg dividido por la talla expresada en metros y elevada al cuadrado, en el adulto un IMC >= 30 kg/m^2 determina obesidad.">OBESIDAD</span>.
  </td> </tr>
  <tr>
    <td align="justify">De acuerdo a los datos proporcionados en los signos vitales del paciente con un <span class="mouseOver" title="El índice de masa corporal (IMC) es una medida de asociación entre la masa y la talla de un individuo ideada por el estadístico belga Adolphe Quetelet, por lo que también se conoce como índice de Quetelet.
Se calcula según la expresión matemática: IMC = masa/(estatura^2). Donde la masa se expresa en kilogramos y el cuadrado de la estatura en metros cuadrados">IMC</span> de <span id="miIMC"></span> y una medida de circunferencia de cintura de <span id="miMedidaCintura"></span> cms</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="1" cellspacing="0" cellpadding="1" style="margin-left:5px;">
      <tr>
      	<td>IMC (kg/m^2)</td>
        <td>CLASIFICACIÓN</td>
      </tr>
      <tr>
      	<td class="normalIMC" align="left">18.50 - 24.99</td>
        <td align="left" class="normalIMC">Rango normal</td>
      </tr>
      <tr>
      	<td align="left">>= 25.00</td>
        <td align="left">Sobrepeso</td>
      </tr>
      <tr>
      	<td class="sobrepesoIMC" align="left">25.00 - 29.99</td>
        <td class="sobrepesoIMC" align="left">Preobesidad</td>
      </tr>
      <tr>
      	<td align="left">>= 30.00</td>
        <td align="left">Obesidad</td>
      </tr>
      <tr>
      	<td class="obesidad1IMC" align="left">30.00 - 34.99</td>
        <td class="obesidad1IMC" align="left">Clase I</td>
      </tr>
      <tr>
      	<td class="obesidad2IMC" align="left">35.00 - 39.99</td>
        <td class="obesidad2IMC" align="left">Clase II</td>
      </tr>
      <tr>
      	<td class="obesidad3IMC" align="left">>= 40.00</td>
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
    <td align="justify">* Esto indica que el paciente <span id="miRiesgoP"></span> de contraer <span id="defDiabetes" class="mouseOver" title="La diabetes mellitus tipo 2 es un trastorno metabólico que se caracteriza por hiperglucemia (nivel alto de azúcar en la sangre) en el contexto de resistencia a la insulina y falta relativa de insulina; en contraste con la diabetes mellitus tipo 1, en la que hay una falta absoluta de insulina debido a la destrucción de los islotes pancreáticos. Los síntomas clásicos son sed excesiva, micción frecuente y hambre constante. La diabetes tipo 2 representa alrededor del 90 % de los casos de diabetes, con el otro 10 % debido principalmente a la diabetes mellitus tipo 1 y la diabetes gestacional. Se piensa que la obesidad es la causa primaria de la diabetes tipo 2 entre personas con predisposición genética a la enfermedad.">diebetes mellitus tipo 2</span>, <span class="mouseOver" id="defHipertension" title="La hipertensión arterial (HTA) es una enfermedad crónica caracterizada por un incremento continuo de las cifras de la presión sanguínea en las arterias. Aunque no hay un umbral estricto que permita definir el límite entre el riesgo y la seguridad, de acuerdo con consensos internacionales, una presión sistólica sostenida por encima de 139 mmHg o una presión diastólica sostenida mayor de 89 mmHg, están asociadas con un aumento medible del riesgo de aterosclerosis y por lo tanto, se considera como una hipertensión clínicamente significativa.">hipertensión</span> y <span class="mouseOver" id="defEnfermedadC" title="En sentido amplio, el término cardiopatía (del gr. kardí(ā) καρδία 'corazón' y pátheia πάθεια 'enfermedad') puede englobar a cualquier padecimiento del corazón o del resto del sistema cardiovascular. Habitualmente se refiere a la enfermedad cardíaca producida por asma o por colesterol.
Sin embargo, en sentido estricto se suele denominar cardiopatía a las enfermedades propias de las estructuras del corazón.">enfermedad cardiovascular</span></td>
  </tr>
  <tr>
    <td style="font-size:1.1em;" class="ui-widget-header">RIESGO DE ENFERMEDAD PARA EL PACIENTE SEGUN LA MEDIDA DE LA CIRCUNFERENCIA DE SU CINTURA E IMC</td>
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
        <td align="left">18.5 - 29.5</td>
        <td class="imc_1_1" align="left">Sin riesgo</td>
        <td class="imc_1_2" align="left">Riesgo alto</td>
      </tr>
      <tr>
        <td align="left">25.0 - 29.9</td>
        <td class="imc_2_1" align="left">Riesgo moderado</td>
        <td class="imc_2_2" align="left">Riesgo alto</td>
      </tr>
      <tr>
        <td align="left">30.0 - 39.9</td>
        <td class="imc_3_1" align="left">Alto a muy alto riesgo</td>
        <td class="imc_3_2" align="left">Muy alto riesgo</td>
      </tr>
      <tr>
        <td align="left"> > 40 </td>
        <td class="imc_4_1" align="left">Extremadamente alto</td>
        <td class="imc_4_2" align="left">Extremadamente alto</td>
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
  
<div id="tabs-3s" style="width:99%; height:93%; font-size:1.1em;">
<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="3" class="fondo_tab">
<tr height="1%">
	<td align="justify" class="ui-widget-header">
    De acuerdo con la tabla de IMC para el <span class="mouseOver" title="Los factores de riesgo cardiovascular asociados con la obesidad en la infancia y adolescencia son: hipertensión arterial, dislipidemia, hiperinsulinemia y alteraciones en la masa ventricular cardiaca izquierda.">riesgo de enfermedad</span> en adultos con sobrepeso y obesidad, el paciente se encuantra <span id="miRiesgoE"></span>.
    </td>
</tr>
<tr height="1%">
	<td align="justify" style="color:black;"> Se recomienda que: </td>
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
        <td colspan="2" align="center" class="ui-widget-header">El paciente cuenta con enfermedades o condiciones asociadas</td>
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
        <td colspan="2" align="center" class="ui-widget-header">Logro de metas y éxito terapéutico</td>
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
        <td colspan="2" align="center" style="color:black;">
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

  <div id="tabs-4s" style="width:99%; height:93%; padding-top:3px;"> 
  <input name="id_medicoLab" id="id_medicoLab" type="hidden" value="">
  <input name="id_DepartamentoLab" id="id_DepartamentoLab" type="hidden" value="1">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0" id="dataTableSV" class="tablilla">
    <thead id="cabecera_tBusquedaSV">
      <tr class="titulos_dataceldas">
        <th id="clickmeSV" width="1px">#</th>
        <th width="10px">FECHA</th>
        <th nowrap>PESO(kg)</th>
     	<th nowrap>TALLA(mts)</th>
        <th nowrap>IMC(kg/m^2)</th>
		<th nowrap>CINTURA(cm)</th>
        <th nowrap>T/A</th>
		<th nowrap>FR(xMin)</th>
        <th nowrap>FC(xMin)</th>
        <th nowrap>T(ºc)</th>
        <th nowrap>OXI(%)</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>
  </div>
  
<div id="tabs-5s" style="width:99%; height:93%; padding-top:1px;"> 
<input name="id_pMedico" id="id_pMedico" type="hidden" value="">
<input name="id_DepartamentoSer" id="id_DepartamentoSer" type="hidden" value="4">
	<table id="grafiasSV" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333">
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