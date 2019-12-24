<table id="dHistory" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250" style="font-size:0.8em;" id="listasHistorial">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
      <tr height="10" id="contenedorControles">
        <td align="center" valign="top" nowrap>        
        <!--<button id="cAntes" class="ui-button ui-widget ui-corner-all ui-button-icon-only botonControl on" title="Nota anterior">
        	<span class="ui-icon ui-icon-seek-prev"></span>Anterior
        </button>
        <button id="cSiguiente"class="ui-button ui-widget ui-corner-all ui-button-icon-only botonControl on"title="Nota siguiente">
        	<span class="ui-icon ui-icon-seek-next"></span>Siguiente
        </button>
        <button id="cActual" class="ui-button ui-widget ui-corner-all ui-button-icon-only botonControl on" title="Última nota">
        	<span class="ui-icon ui-icon-seek-end"></span>Última
        </button> -->
        <button id="nuevaNotaM" class="ui-button ui-widget ui-corner-all ui-button-icon on" title="">
        	<span class="ui-icon ui-icon-plusthick"></span>CREAR NOTA MÉDICA
        </button>
  
        <input name="idControl" id="idControl" type="hidden" value="">
        </td>
      </tr>
      <tr class="on">
        <td valign="top" style="font-size:0.8em;" id="contenedorDTHI" bgcolor="">
        <table width="100%"height="100%"border="0"cellpadding="4"cellspacing="0"id="dataTableHis" class="tablilla">
            <thead id="cabecera_tBusquedaHis">
              <tr>
                <th id="clickmeHis" width="1px">#</th>
                <th width="10px">FECHA</th>
                <th id="titulo_concept">NOTA</th>
                <th>MÉDICO</th>
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
                <li id="tah6"><a class="tabsHi" id="thi-6-1" href="#tabs-6hi">S-V</a></li>
                <li id="tah7"><a class="tabsHi" id="thi-7-1" href="#tabs-7hi">H-C</a></li>
                <li id="tah1"><a class="tabsHi on" id="thi-1-1" href="#tabs-1hi">NOTA MÉDICA</a></li>
                <li id="tah2"><a class="tabsHi on" id="thi-2-1" href="#tabs-2hi">DX</a></li>
                <li id="tah3"><a class="tabsHi on" id="thi-3-1" href="#tabs-3hi">INDICACIONES</a></li>
                <li id="tah4"><a class="tabsHi on" id="thi-4-1" href="#tabs-4hi">RECOMENDACIONES</a></li>
                <li id="tah8"><a class="tabsHi on" id="thi-8-1" href="#tabs-8hi">IMÁGENES</a></li>
                <li id="tah9"><a class="tabsHi on" id="thi-9-1" href="#tabs-9hi">TRANSFUSIONES</a></li>
            </ul>
            </td>
          </tr>
        </table>
		<div id="tabs-1hi" style="width:99%; height:91%; overflow:scroll;" class="fondo_tab">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="fondo_tab">
          <tr height="1%">
            <td align="left" height="1px">
            <table width="100%" border="0" cellspacing="0" cellpadding="4" style="border-bottom:1px dashed black;">
              <tr> <td style="display:none">FECHA:</td><td align="right"><span id="fechaNE" class="cursi"></span></td> </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td valign="top" height="1px">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="5cm" align="left" valign="top" style="display:none;">
                <table width="100%" border="0" cellspacing="0" cellpadding="4" id="signos_hnota" class="textoResaltado">
                  <tr> <td width="100px">FC</td> <td align="right"><span id="fcNE"></span></td> </tr>
                  <tr> <td>FR</td> <td align="right"><span id="frNE"></span></td> </tr>
                  <tr> <td>T/A</td> <td align="right"><span id="taNE"></span></td> </tr>
                  <tr> <td>TEMP</td> <td align="right"><span id="tempNE"></span></td> </tr>
                  <tr> <td>PESO</td> <td align="right"><span id="pesoNE"></span></td> </tr>
                  <tr> <td>TALLA</td> <td align="right"><span id="tallaNE"></span></td> </tr>
                  <tr> <td>IMC</td> <td align="right"><span id="imcNE"></span></td> </tr>
                </table>
                </td>
                <td valign="top" align="justify" style="border-left:1px dashed black; padding-left:3px;border-bottom:1px dashed black;">
                    <span id="notaNE"></span>
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr id="trAlergias" style="display:none;">
          <td height="1px">
            <table width="100%" border="0" cellspacing="0" cellpadding="4" style="border-bottom:1px dashed black;">
              <tr align="left"> <td width="80">ALÉRGIAS:</td> <td align="left"><span id="alergiasNE"></span></td> </tr>
            </table>
          </td>
          </tr>
          <tr>
            <td height="1px"><br>
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr> <td align="right"><span id="doctorNE"></span></td> </tr>
            </table>
            </td>
          </tr>
        </table>
        </div>
        <div id="tabs-2hi" style="width:99%; height:91%; overflow:scroll;" class="fondo_tab">
        <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" id="dataTableDXh" class="tablilla">
            <thead id="cabecera_tBusquedaDXh" class="miCabeceraDT">
              <tr>
                <th id="clickmeDXh">#</th>
                <th> DIAGNÓSTICOS </th>
                <th>PRIMARIO</th>
              </tr>
            </thead>
            <tbody style=" color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
          </table>
        </div>
        
        <div id="tabs-3hi" style="width:99%; height:91%; overflow:scroll;">
        <table width="100%" height="100%" border="0" cellspacing="3" cellpadding="2" class="fondo_tab"> 
        	<tr height="1%">
            	<td id="titulo_indi_nh" align="left">MEDICAMENTOS:</td>
            </tr>
            <tr valign="top">
            	<td id="medicamentos_indi_nh">&nbsp;</td>
            </tr>
            <tr height="1%">
            	<td id="indicaciones_indi_nh">&nbsp;</td>
            </tr>
            <tr height="99%">
            	<td id="nada_indi_nh"></td>
            </tr>
        </table>
        </div>
        
        <div id="tabs-4hi" style="width:99%; height:91%; overflow:scroll;">
        <table width="100%" height="100%" border="0" cellspacing="4" cellpadding="2" class="fondo_tab"> <tr>
            <td id="recomendaciones_nh" valign="top">&nbsp;</td>
        </tr> </table>
        </div>
        
        <div id="tabs-7hi" style="width:99%; height:91%; overflow:scroll;"> </div>
        
        <div id="tabs-8hi" style="width:99%; height:91%; overflow:scroll;font-size:0.8em;">
        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" id="dataTableArchivos" class="tablilla">
        <thead id="cabecera_tBusquedaArchivos" class="">
          <tr style="font-size:1.25em;">
            <th id="clickmeArch"class="titulosTabs"align="center" nowrap width="1px">#</th>
            <th class="titulosTabs" align="center" width="">
            	FOTOGRAFÍA <input id="name_archivo" type="hidden" value="">
                <button class="ui-button ui-widget ui-corner-all ui-button-icon-only" title="Button with icon only">
                    <span class="ui-icon ui-icon-gear"></span> Button with icon only
                </button>
                </th>
            <th class="titulosTabs" align="center" width="10px" nowrap>
                <span title="Ver la fotografía">VISUALIZAR</span> <input id="idH_archivo" type="hidden" value="">
            </th>
            <th class="titulosTabs" align="center" width="10px" nowrap> <span title="Eliminar la fotografía">ELIMINAR</span> </th>
          </tr>
        </thead> <tbody style="color:black; text-align:justify;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
            <tfoot> <tr>
                <th><input name="dX" type="hidden" class="fotos_b"></th>
                <th><input name="dDocumento" id="dDocumento" type="text" class="search_init campos_b_t fotos_b" placeholder="-TÍTULO-" onKeyUp="conMayusculas(this);"/></th>
                <th><input name="dX1" type="hidden" class="fotos_b"></th>
                <th><input name="dX2" type="hidden" class="fotos_b"></th>
            </tr> </tfoot>
        </table>
        </div>
        <div id="tabs-9hi" style="width:99%; height:91%; overflow:scroll;">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" class="fondo_tab"> <tr>
            <td>&nbsp;</td>
        </tr> </table>
        </div>
        
        <div id="tabs-6hi" style="width:99%; height:91%; overflow:scroll;">
            <div id="tabs_sv" style="width:100%; height:100%;">
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
                <td align="right">
                <button id="b_agregarSignosC" class="ui-button ui-widget ui-corner-all botonC bAgregar" title=""> <span class="ui-icon ui-icon-plusthick"></span>Tomar signos vitales</button>
                </td>
              </tr>
            </table>
              
              <div id="tabs-1s" style="width:99%; height:93%;">
              <table width="100%" height="100%" border="0" align="center" cellpadding="4" cellspacing="4" class="fondoDataT" style="font-size:0.9em; overflow:hidden;"> <tbody align="left">
              <tr height="1%">
        		<td valign="top"> 
                <table width="100%" border="0" cellspacing="4" cellpadding="2">
                 <tr> 
                    <td width="1%" align="right">PACIENTE:</td>
                    <td id="campo_paciente_sv" align="left" nowrap>
                    	<span class="textoA" name="pacienteC" id="pacienteC"></span>
                    </td>
                    <td width="1%" align="right">EDAD:</td> 
                    <td align="left" nowrap width="100px">
                    	<span class="textoA" name="edadC" id="edadC"></span>
                    </td> 
                    <td width="1%">SEXO:</td> 
                    <td id="campo_sx_sv" align="left" nowrap width="130px">
                    	<span class="textoA" name="sexoC" id="sexoC"></span>
                    </td> 
                  </tr>
                  <tr> 
                    <td align="left" nowrap>FECHA HOSPITALIZACIÓN:</td> 
                    <td colspan="1">
                    	<span class="textoA" name="fechaIngresoC" id="fechaIngresoC"></span>
                    </td> 
                    <td align="left" nowrap>FECHA SIGNOS VITALES:</td>
                    <td colspan="3">
                    	<span class="textoA" name="fechaSignosC" id="fechaSignosC"></span>
                    </td>
                 </tr>
                </table>
                </td>
              </tr>
              <tr>
              <td align="left">
              <table width="100%" height="" border="1" align="center" cellpadding="4" cellspacing="0" class="fondoDataT" style="font-size:0.9em; float:;">
                <td align="right">PESO</td>
                <td id="pesoC"></td>
                <td style="opacity:0.7;">Kg</td>
                <td align="right">TALLA</td>
                <td id="tallaC"></td>
                <td style="opacity:0.7;">m</td>
                <td align="right">IMC</td>
                <td id="imcC"></td>
                <td style="opacity:0.7;">Kg/m^2</td>
              </tr>
              <tr>
                <td align="right">T/A</td>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td id="tC"></td>
                        <td>/</td>
                        <td id="aC"></td>
                      </tr>
                    </table>
                </td>
                <td style="opacity:0.7;">mm Hg</td>
                <td align="right">FR</td>
                <td id="frC"></td>
                <td nowrap style="opacity:0.7;">x min</td>
                <td align="right">FC</td>
                <td id="fcC"></td>
                <td style="opacity:0.7;">x min</td>
              </tr>
              <tr>
                <td align="right">OXIMETRÍA</td>
                <td id="oxiSV"></td>
                <td nowrap style="opacity:0.7;">% SaO<sub>2</sub></td>
                <td align="right">CINTURA</td>
                <td id="cinturaC"></td>
                <td style="opacity:0.7;">cm</td>
                <td align="right">TEMP</td>
                <td id="tempC"></td>
                <td style="opacity:0.7;">ºC</td>
              </tr>
            </table>
            </td>
              </tr>
              <tr>
                <td valign="top">
                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td align="left"width="1%"nowrap>NOTAS SIGNOS VITALES:</td>
                    <td><span name="notasC" id="notasC"></span></td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td valign="top">
                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td align="left"width="1%"nowrap>MOTIVO DE LA HOSPITALIZACIÓN:</td>
                    <td><span name="motivoC" id="motivoC"></span></td>
                  </tr>
                </table>
                </td>
              </tr>
            </tbody>
          </table>
            </div>
              
            <div id="tabs-2s" style="width:99%; height:93%; font-size:0.9em;">
            <table width="100%" border="0" cellspacing="0" cellpadding="3" class="fondo_tab">
              <tr> <td style="font-size:1.1em; color:black;">
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
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3" class="fondo_tab">
            <tr>
                <td align="justify">
                De acuerdo con la tabla de IMC para el <span class="mouseOver" title="Los factores de riesgo cardiovascular asociados con la obesidad en la infancia y adolescencia son: hipertensión arterial, dislipidemia, hiperinsulinemia y alteraciones en la masa ventricular cardiaca izquierda.">riesgo de enfermedad</span> en adultos con sobrepeso y obesidad, el paciente se encuantra <span id="miRiesgoE"></span>.
                </td>
            </tr>
            <tr>
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
                    <td colspan="2" align="center" style="color:black;">Logro de metas y éxito terapéutico</td>
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
                  </tr>
                </thead>
                <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
              </table>
              </div>
              
            <div id="tabs-5s" style="width:99%; height:93%; padding-top:1px;"> 
            <input name="id_pMedico" id="id_pMedico" type="hidden" value="">
            <input name="id_DepartamentoSer" id="id_DepartamentoSer" type="hidden" value="4">
                <table id="grafiasSV" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
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
        
        </div>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>

<div id="holi" style="display:none;"></div>