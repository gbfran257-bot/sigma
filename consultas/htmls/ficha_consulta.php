<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
  <div class="modal-content animated flipInY">
    <div class="modal-header">
      <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h2 class="modal-title"><strong><span id="titulo_modal">CREAR UN NUEVO PACIENTE</span></strong></h2>
      <button type="button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." style="position: absolute;right: 15px;top: 10px;" class="btn btn-success btn-sm btns-consulta" id="finalizarConsulta"><i class="fa fa-check" aria-hidden="true"></i> Finalizar</button>
    </div>
    <div class="modal-body">
      <input name="idUsuario_c" id="idUsuario_c" type="hidden" value="">
      <input name="idPaciente_c" id="idPaciente_c" type="hidden" value="">
      <input name="id_cons" id="id_cons" type="hidden" value="">
      <input name="numeroTemporalC" id="numeroTemporalC" type="hidden" value="">
      <input name="id_primer_vc" id="id_primer_vc" type="hidden" value="">
      <input name="nombre_primer_vc" id="nombre_primer_vc" type="hidden" value="">
      <input name="indicador_histo" id="indicador_histo" type="hidden" value="">
      <!-- Nav tabs -->
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td nowrap>
            <ul class="nav nav-tabs" role="tablist" id="tabs_consulta">
              <li role="presentation" class="tab_consulta hide_nhc hide_dx hide_meds no_graf no_histo">
                <a href="#taSV" aria-controls="taSV" role="tab" data-toggle="tab" id="tab_sv_1">S-V</a>
              </li>
              <li role="presentation" class="tab_consulta hide_nsv hide_dx hide_meds no_graf no_histo">
                <a href="#tHC" aria-controls="tHC" role="tab" data-toggle="tab" id="tab_my_hc_x">H-C</a>
              </li>
              <li role="presentation" class="active tab_consulta hide_nsv hide_nhc hide_dx hide_meds no_graf no_histo hsh" id="tab_nme">
                <a href="#tNM" aria-controls="tNM" role="tab" data-toggle="tab" id="my_tb_nm">NOTA MÉDICA</a>
              </li>
              <li role="presentation" class="tab_consulta hide_nsv hide_nhc hide_dx hide_meds no_graf no_histo hsh" id="tabs_receta">
                <a href="#tReceta" aria-controls="tReceta" role="tab" data-toggle="tab" id="my_tb_re">RECETA</a>
              </li>
              <li role="presentation" class="tab_consulta hide_nsv hide_nhc hide_dx hide_meds no_graf no_histo hsh" id="tabs_imagenes">
                <a href="#tImgs" aria-controls="tImgs" role="tab" data-toggle="tab">IMÁGENES</a>
              </li>
              <li role="presentation" class="tab_consulta hidden hsh" id="tab_dx">
                <a href="#tDx" aria-controls="tDx" role="tab" data-toggle="tab" id="mi_tab_dx">DIAGNÓSTICOS</a>
              </li>
              <li role="presentation" class="tab_consulta hidden hsh" id="tab_medis">
                <a href="#tMeds" aria-controls="tMeds" role="tab" data-toggle="tab" id="mi_tab_meds">MEDICAMENTOS</a>
              </li>
              <li role="presentation" class="tab_consulta hidden si_graf hsh" id="tab_graficas">
                <a href="#tGrafs" aria-controls="tGrafs" role="tab" data-toggle="tab" id="mi_tab_grafs">GRÁFICAS</a>
              </li>
              <li role="presentation" class="tab_consulta hidden si_histo hsh" id="tab_historial">
                <a href="#tHisto" aria-controls="tHisto" role="tab" data-toggle="tab" id="mi_tab_histo">HISTORIAL CLÍNICO</a>
              </li>
            </ul>
          </td>
          <td align="right" nowrap>
            <?php if ($_POST['opcion'] == 3) : ?>
              <button type="button" class="btn btn-warning btn-sm" id="imprimir">
                <svg style="fill: rgb(30, 48, 80);" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                  <path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                </svg>
              </button>
            <?php endif; ?>
            <select id="select-almacen" class="hidden"></select>
            <button type="button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-primary btn-sm btns-consulta" id="salvarConsulta"><i class="fa fa-cloud" aria-hidden="true"></i> Guardar</button>

            <?php
              require("../../Connections/horizonte.php");
              require_once("../../funciones/php/values.php");

              mysql_select_db($database_horizonte, $horizonte); 
              $resultRu = mysql_query("SELECT COUNT(*) FROM modificaciones_sigma WHERE nombre = 'hospitalizacion' AND habilitado = 1 ", $horizonte) or die(mysql_error()); 
              $rowRu = mysql_fetch_row($resultRu);
              $visualizarT2 = $rowRu[0];

            ?>
            <?php if($visualizarT2 <= 0):  ?>
              <button type="button" class="btn btn-info btn-sm" id="hospitalizarP"><i class="fa fa-bed" aria-hidden="true"></i> </button>
            <?php else:  ?> <!-- TICKET SIN DATOS DE HOSPITALIZACION-->
              <button type="button" class="btn btn-info btn-sm" id="hospitalizarP2"><i class="fa fa-bed" aria-hidden="true"></i> </button>
            <?php endif; ?>

            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="salirSGconsulta">Salir</button>
            <button type="submit" class="btn btn-success btn-sm hidden" id="btn_guardar_sv" form="formSignosVitales">Guardar</button>
            <button type="submit" class="btn btn-success btn-sm hidden" id="b_actualizarHC" form="formHistoriaClinica">Guardar</button>
            <button type="button" class="btn btn-warning btn-sm hidden" id="btn_cancelar_sv">Cancelar</button>
            <button type="button" class="btn btn-warning btn-sm hidden" id="b_cancelHC">Cancelar</button>
            <button type="button" class="btn btn-warning btn-sm hidden" id="b_cancel_dxs">Regresar</button>
            <button type="button" class="btn btn-warning btn-sm hidden" id="b_cancel_medis">Regresar</button>
            <button type="button" class="btn btn-warning btn-sm hidden si_graf" onClick="no_graficas();">Regresar</button>
            <button type="button" class="btn btn-warning btn-sm hidden si_histo no_img_h" onClick="no_historiales();">Regresar</button>
            <button type="button" class="btn btn-warning btn-sm hidden si_img_h" onClick="no_img_h();">Regresar</button>
          </td>
        </tr>
      </table>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="taSV"><br>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist" id="tabs_sv">
            <li role="presentation" class="active tab_sv"><a href="#tUT_sv" aria-controls="tUT_sv" role="tab" data-toggle="tab">ÚLTIMA TOMA</a></li>
            <li role="presentation" class="tab_sv hide_nsv"><a href="#tRI_sv" aria-controls="tRI_sv" role="tab" data-toggle="tab">RIESGOS</a></li>
            <li role="presentation" class="tab_sv hide_nsv"><a href="#tRE_sv" aria-controls="tRE_sv" role="tab" data-toggle="tab">RECOMENDACIONES</a></li>
            <li role="presentation" class="tab_sv hide_nsv" id="mi_tab_h_sv"><a href="#tHi_sv" aria-controls="tHi_sv" role="tab" data-toggle="tab">HISTORIAL</a></li>
            <li role="presentation" class="tab_sv hide_nsv"><a href="#tEs_sv" aria-controls="tEs_sv" role="tab" data-toggle="tab">ESTADISTICAS</a></li>
            <button type="button" class="btn btn-primary btn-sm" id="print_SignosV" style="float:right; margin-left: 5px;"> Imprimir signos vitales</button>
            <button type="button" class="btn btn-warning btn-sm" id="b_agregarSignosC" style="float:right; "><i class="fa fa-plus" aria-hidden="true"></i> Tomar signos vitales</button>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tUT_sv"><br>
              <form name="formSignosVitales" id="formSignosVitales" data-toggle="validator" role="form">
                <input name="idUsuario_sv" id="idUsuario_sv" type="hidden" value="">
                <input name="idPaciente_sv" id="idPaciente_sv" type="hidden" value="">
                <input name="numeroTemporalSV" id="numeroTemporalSV" type="hidden" value="">
                <div class="panel panel-info" id="panel_sv">
                  <div class="panel-heading">
                    <h3 class="panel-title" id="titulo_toma_sv">
                      SIGNOS VITALES | FECHA DE LA TOMA:
                      <span id="fechaSignosC" name="fechaSignosC"></span> POR <span id="usuario_svi1"></span>
                    </h3>
                  </div>
                  <div class="panel-body" style="font-size:15px">
                    <div class="row">
                      <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                          <label for="fcSV">Frecuencia cardiaca</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="fcSV" name="fcSV" required>
                            <div class="input-group-addon">x min</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                          <label for="oxiSV">Oximetría</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="oxiSV" name="oxiSV">
                            <div class="input-group-addon" style="font-size:0.8em;">% SaO<sub>2</sub></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="tSV">Presión arterial sistólica (T)</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="tSV" name="tSV">
                            <div class="input-group-addon">mmHg</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="aSV">Presión arterial diastólica (A)</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="aSV" name="aSV">
                            <div class="input-group-addon">mmHg</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="aSV">Destroxtis</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="dtxis" name="dtxis" step="0.01">
                            <div class="input-group-addon">mg/dl</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="frSV">Frecuencia respiratoria</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="frSV" name="frSV" required step="1">
                            <div class="input-group-addon">x min</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="tempSV">Temperatura</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="tempSV" name="tempSV" required step="0.1">
                            <div class="input-group-addon">ºC</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="pesoSV">Peso</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="pesoSV" name="pesoSV" step="0.01">
                            <div class="input-group-addon">kg</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="tallaSV">Talla</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="tallaSV" name="tallaSV" min="0" step="0.01">
                            <div class="input-group-addon">mts</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="cinturaSV">Cintura</label>
                          <div class="input-group">
                            <input type="number" class="form-control sv_ro no-spin" id="cinturaSV" name="cinturaSV" step="0.1">
                            <div class="input-group-addon">cm</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                          <label for="imcSV">IMC</label>
                          <div class="input-group">
                            <input type="number" class="form-control no-spin" id="imcSV" name="imcSV" readonly>
                            <div class="input-group-addon" style="font-size:0.8em;">kg/m<sup>2</sup></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                          <label for="notasSV">Observación en toma de signos vitales</label>
                          <input type="text" class="form-control" id="notasSV" name="notasSV" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-md-12" align="center">
                        <pre>CALCULADORA MÉDICA</pre>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="abertura_ocular">Abertura ocular</label>&nbsp;
                          <span id="ocular_val" class="abertura_ocular">0</span>
                          <select id="abertura_ocular" name="abertura_ocular" class="form-control escala_g sv_ro" onchange="checarEscala(this.id)">
                            <option value="0" selected>-SELECCIONAR-</option>
                            <option value="1">Ninguna</option>
                            <option value="2">Dolor</option>
                            <option value="3">Voz</option>
                            <option value="4">Espontanea</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="respuesta_verbal">Respuesta Verbal</label>&nbsp;
                          <span id="verbal_val" class="respuesta_verbal">0</span>
                          <select id="respuesta_verbal" name="respuesta_verbal" class="form-control escala_g sv_ro" onchange="checarEscala(this.id)">
                            <option value="0" selected>-SELECCIONAR-</option>
                            <option value="1">Ninguna</option>
                            <option value="2">Sonidos</option>
                            <option value="3">Inapropiada</option>
                            <option value="4">Confusa</option>
                            <option value="5">Orientada</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="respuesta_motriz">Respuesta Motriz</label>&nbsp;
                          <span id="motriz_val" class="respuesta_motriz">0</span>
                          <select id="respuesta_motriz" name="respuesta_motriz" class="form-control escala_g sv_ro" onchange="checarEscala(this.id)">
                            <option value="0" selected>-SELECCIONAR-</option>
                            <option value="1">Ninguna</option>
                            <option value="2">Extensión</option>
                            <option value="3">Flexión</option>
                            <option value="4">Retirada</option>
                            <option value="5">Localiza</option>
                            <option value="6">Obedece</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row" id="row_texto_puntuacion_g">
                      <div class="col-sm-12" align="right"> <var>Puntuación: </var> <samp id="total_escala_g">0</samp> </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="tRI_sv"><br>
              <div class="panel panel-warning">
                <div class="panel-heading">
                  <h3 class="panel-title"> CLASIFICACIÓN DEL PACIENTE EN CUANTO A SOBREPESO Y OBESIDAD </h3>
                </div>
                <div class="panel-body">
                  <div align="justify" class="well well-sm">De acuerdo a los datos proporcionados en los signos vitales del paciente con un <var class="mouseOver" title="El índice de masa corporal (IMC) es una medida de asociación entre la masa y la talla de un individuo ideada por el estadístico belga Adolphe Quetelet, por lo que también se conoce como índice de Quetelet.
Se calcula según la expresión matemática: IMC = masa/(estatura^2). Donde la masa se expresa en kilogramos y el cuadrado de la estatura en metros cuadrados">IMC</var> de <var id="miIMC"></var> y una medida de circunferencia de cintura de <var id="miMedidaCintura"></var> cms</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed table-bordered">
                    <tr class="bg-info">
                      <td align="center">IMC (kg/m^2)</td>
                      <td align="center">CLASIFICACIÓN</td>
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
                      <td colspan="2" align="justify" class="bg-success">
                        <samp align="justify">* Esto indica que el paciente <span id="miRiesgoP"></span> de contraer <span id="defDiabetes" class="mouseOver" title="La diabetes mellitus tipo 2 es un trastorno metabólico que se caracteriza por hiperglucemia (nivel alto de azúcar en la sangre) en el contexto de resistencia a la insulina y falta relativa de insulina; en contraste con la diabetes mellitus tipo 1, en la que hay una falta absoluta de insulina debido a la destrucción de los islotes pancreáticos. Los síntomas clásicos son sed excesiva, micción frecuente y hambre constante. La diabetes tipo 2 representa alrededor del 90 % de los casos de diabetes, con el otro 10 % debido principalmente a la diabetes mellitus tipo 1 y la diabetes gestacional. Se piensa que la obesidad es la causa primaria de la diabetes tipo 2 entre personas con predisposición genética a la enfermedad.">diebetes mellitus tipo 2</span>, <span class="mouseOver" id="defHipertension" title="La hipertensión arterial (HTA) es una enfermedad crónica caracterizada por un incremento continuo de las cifras de la presión sanguínea en las arterias. Aunque no hay un umbral estricto que permita definir el límite entre el riesgo y la seguridad, de acuerdo con consensos internacionales, una presión sistólica sostenida por encima de 139 mmHg o una presión diastólica sostenida mayor de 89 mmHg, están asociadas con un aumento medible del riesgo de aterosclerosis y por lo tanto, se considera como una hipertensión clínicamente significativa.">hipertensión</span> y <span class="mouseOver" id="defEnfermedadC" title="En sentido amplio, el término cardiopatía (del gr. kardí(ā) καρδία 'corazón' y pátheia πάθεια 'enfermedad') puede englobar a cualquier padecimiento del corazón o del resto del sistema cardiovascular. Habitualmente se refiere a la enfermedad cardíaca producida por asma o por colesterol.
Sin embargo, en sentido estricto se suele denominar cardiopatía a las enfermedades propias de las estructuras del corazón.">enfermedad cardiovascular.</span></samp>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" align="justify" style="font-size:0.8em; opacity:0.7;">
                        Fuente: World Health Organization
                        <cite><span style="cursor:pointer" onClick="window.open('http://www.who.int/bmi/index.jsp?introPage=intro_3.html');">
                            http://www.who.int/bmi/index.jsp?introPage=intro_3.html
                          </span></cite>
                      </td>
                    </tr>
                  </table>

                  <div align="justify" class="well well-sm">Riesgo de enfermedad para el paciente según la medida de la circunferencia de su cintura e imc</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed table-bordered">
                    <tr class="bg-info">
                      <td rowspan="2" align="center" valign="middle">IMC</td>
                      <td>Cintura <strong>hombres</strong>
                        < 90 cms</td>
                      <td>Cintura <strong>hombres</strong> >= 90 cms</td>
                    </tr>
                    <tr class="bg-info">
                      <td>Cintura <strong>mujeres</strong>
                        < 80 cms</td>
                      <td>Cintura <strong>mujeres</strong> >= 80 cms</td>
                    </tr>

                    </tr>
                    <tr>
                      <td align="left">18.5 - 24.9</td>
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
                        <cite><span style="cursor:pointer" onClick="window.open('http://www.cenetec.salud.gob.mx/descargas/gpc/CatalogoMaestro/046_GPC_ObesidadAdulto/IMSS_046_08_GRR.pdf');">
                            National Health and Medical Research Council. Clinical Practice Guidelines for the Management of Overweight and Obesity in Adults. Australia 2003.</cite>
                        </span>
                      </td>
                    </tr>
                  </table>

                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tRE_sv"><br>
              <div class="panel panel-warning">
                <div class="panel-body">
                  <div align="justify" class="well well-sm">
                    De acuerdo con la tabla de IMC para el <span class="mouseOver" title="Los factores de riesgo cardiovascular asociados con la obesidad en la infancia y adolescencia son: hipertensión arterial, dislipidemia, hiperinsulinemia y alteraciones en la masa ventricular cardiaca izquierda.">riesgo de enfermedad</span> en adultos con sobrepeso y obesidad, el paciente se encuantra <span id="miRiesgoE"></span>.
                  </div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed table-bordered">
                    <tr class="bg-info">
                      <td align="center" valign="middle" colspan="2">Se recomienda que:</td>
                    </tr>
                    <tr id="recomendacionRN">
                      <td align="left" colspan="2">
                        <li> Se oriente al paciente en una adecuada educación alimentaria.</li>
                        <li> Se sugiera un programa de actividad física regular moderada de cuatro veces por semana.</li>
                        <li> Recomendar al paciente que evite el alcoholismo y el tabaquismo, que modere la ingesta de café, fomentar la higiene del sueño y control de estrés.</li>
                        <li> Que mantenga vigilado su IMC semestralmente y utilice <span class="mouseOver">medidas de prevención primaria</span>.</li>
                      </td>
                    </tr>
                    <tr class="recomendacionSP bg-info">
                      <td colspan="2" align="center">El paciente cuenta con enfermedades o condiciones asociadas</td>
                    </tr>
                    <tr class="recomendacionSP bg-success" align="center">
                      <td width="50%">NO</td>
                      <td>SI</td>
                    </tr>
                    <tr class="recomendacionSP" align="justify">
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
                    <tr class="recomendacionSP bg-info">
                      <td colspan="2" align="center">Logro de metas y éxito terapéutico</td>
                    </tr>
                    <tr class="recomendacionSP bg-success" align="center">
                      <td>SI</td>
                      <td>NO</td>
                    </tr>
                    <tr class="recomendacionSP">
                      <td>Vigilar y promover mantenimiento de reducción de peso, seguimiento al IMC y circunferencia abdominal.</td>
                      <td>Volver al principio</td>
                    </tr>
                    <tr class="recomendacionOB">
                      <td colspan="2">
                        <li> Crear e iniciar inmediatamente un programa individualizado y adecuado de dieta para el paciente.</li>
                        <li> Crear e iniciar inmediatamente un <span class="mouseOver">programa individualizado y adecuado de actividad física</span> para el paciente.</li>
                        <li> Crear e iniciar inmediatamente un programa individualizado y adecuado de terepia cognitivo-conductual para el paciente.</li>
                        <li> Apoyo <span class="mouseOver">psicosocial</span>.</li>
                      </td>
                    </tr>
                    <tr class="recomendacionOB bg-info">
                      <td colspan="2" align="center">Éxito terapéutico con evidencia de apego</td>
                    </tr>
                    <tr class="recomendacionOB bg-success" align="center">
                      <td width="50%">SI</td>
                      <td>NO</td>
                    </tr>
                    <tr class="recomendacionOB" align="justify">
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
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tHi_sv"><br>
              <input name="id_medicoLab" id="id_medicoLab" type="hidden" value="">
              <input name="id_DepartamentoLab" id="id_DepartamentoLab" type="hidden" value="1">
              <table width="100%" id="dataTableSV" class="table table-hover table-striped dataTable table-condensed" role="grid">
                <thead id="">
                  <tr role="row" class="bg-info">
                    <th id="clickmeSV">#</th>
                    <th>FECHA</th>
                    <th>PESO</th>
                    <th>TALLA</th>
                    <th>IMC</th>
                    <th>CINTURA</th>
                    <th>T/A</th>
                    <th>FR</th>
                    <th>FC</th>
                    <th>TEMP</th>
                    <th>OXI</th>
                  </tr>
                </thead>
                <tbody class="cuerpo_datatable">
                  <tr>
                    <td class="dataTables_empty">Cargando datos del servidor</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tEs_sv"><br>
              <input name="id_pMedico" id="id_pMedico" type="hidden" value="">
              <input name="id_DepartamentoSer" id="id_DepartamentoSer" type="hidden" value="4">
              <table id="grafiasSV" width="100%" class="table table-condensed table-bordered">
                <tr>
                  <td colspan="2" class="bg-info" align="center" style="font-size: 2rem;">GRÁFICAS DE LOS PRINCIPALES SIGNOS VITALES</td>
                </tr>
                <tr>
                  <td width="50%" height="50%">
                    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td height="1%" align="center" width="">Presión arterial sistólica (T)</td>
                      </tr>
                      <tr>
                        <td id="contenedorCHT">
                          <div class="miCanva" id="myChartT1"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td height="1%" align="center">Presión arterial diastólica (A)</td>
                      </tr>
                      <tr>
                        <td id="contenedorCHta">
                          <div class="miCanva" id="myChartTA"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td height="1%" align="center">Frecuencia respiratoria</td>
                      </tr>
                      <tr>
                        <td id="contenedorCHfr">
                          <div class="miCanva" id="myChartFR"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td height="1%" align="center">Frecuencia cardiaca</td>
                      </tr>
                      <tr>
                        <td id="contenedorCHfc">
                          <div class="miCanva" id="myChartFC"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td width="50%" height="50%">
                    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td height="1%" align="center" width="">Índice de Masa Corporal</td>
                      </tr>
                      <tr>
                        <td id="contenedorCH">
                          <div class="miCanva" id="myChartIMC"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td height="1%" align="center">Temperatura</td>
                      </tr>
                      <tr>
                        <td id="contenedorCHt">
                          <div class="miCanva" id="myChartT"></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tHC"><br>
          <form action="" method="post" name="formHistoriaClinica" id="formHistoriaClinica" target="_self" style="height:100%">
            <input name="idUsuario_hc" id="idUsuario_hc" type="hidden" value="">
            <input name="idPaciente_hc" id="idPaciente_hc" type="hidden" value="">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#tahf" aria-controls="tahf" role="tab" data-toggle="tab" id="mi_tab_hc1">AHF</a>
              </li>
              <li role="presentation"><a href="#tapnp" aria-controls="tapnp" role="tab" data-toggle="tab">APNP</a></li>
              <li role="presentation"><a href="#tapp" aria-controls="tapp" role="tab" data-toggle="tab">APP</a></li>
              <li role="presentation"><a href="#tago" aria-controls="tago" role="tab" data-toggle="tab">AGO</a></li>
              <span class="label label-info" id="datos_toma_hc">
                ÚLTIMA TOMA: <span id="fecha_toma_hc"></span> POR: <span id="usuario_toma_hc"></span>
              </span>
              <button type="button" class="btn btn-warning btn-sm" id="b_editarHC" style="float:right;">
                <i class="fa fa-pencil" aria-hidden="true"></i> Editar
              </button>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="tahf"><br>
                <table width="100%" class="table table-condensed table-bordered table-striped">
                  <tr>
                    <td colspan="6" align="center" class="bg-info">ANTECEDENTES HEREDOFAMILIARES</td>
                  </tr>
                  <tr>
                    <td align="left" class="text-info">Padre</td>
                    <td width="17%"> <select class="estatusVive selectHC form-control" name="estatus_padre" id="estatus_padre"> </select> </td>
                    <td width="17%"> <select class="enfermedad selectHC form-control" name="ahf_padre_1" id="ahf_padre_1"> </select></td>
                    <td width="17%"> <select class="enfermedad selectHC form-control" name="ahf_padre_2" id="ahf_padre_2"> </select></td>
                    <td width="17%"> <select class="enfermedad selectHC form-control" name="ahf_padre_3" id="ahf_padre_3"> </select></td>
                    <td width="17%"> <select class="enfermedad selectHC form-control" name="ahf_padre_4" id="ahf_padre_4"> </select> </td>
                  </tr>
                  <tr>
                    <td align="left" class="text-info">Madre</td>
                    <td> <select class="estatusVive selectHC form-control" name="estatus_madre" id="estatus_madre"> </select> </td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_madre_1" id="ahf_madre_1"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_madre_2" id="ahf_madre_2"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_madre_3" id="ahf_madre_3"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_madre_4" id="ahf_madre_4"> </select></td>
                  </tr>
                  <tr>
                    <td align="left" class="text-info">Hermanos</td>
                    <td>
                      <select name="noHnos" id="noHnos" class="selectHC form-control">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hnos_1" id="ahf_hnos_1"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hnos_2" id="ahf_hnos_2"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hnos_3" id="ahf_hnos_3"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hnos_4" id="ahf_hnos_4"> </select></td>
                  </tr>
                  <tr>
                    <td align="left" class="text-info">Conyugue</td>
                    <td> <select class="estatusVive selectHC form-control" name="estatus_conyugue" id="estatus_conyugue"> </select> </td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_conyugue_1" id="ahf_conyugue_1"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_conyugue_2" id="ahf_conyugue_2"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_conyugue_3" id="ahf_conyugue_3"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_conyugue_4" id="ahf_conyugue_4"> </select></td>
                  </tr>
                  <tr>
                    <td align="left" class="text-info">Hijos</td>
                    <td>
                      <select name="noHijos" id="noHijos" class="selectHC form-control">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                      </select>
                    </td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hijos_1" id="ahf_hijos_1"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hijos_2" id="ahf_hijos_2"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hijos_3" id="ahf_hijos_3"> </select></td>
                    <td> <select class="enfermedad selectHC form-control" name="ahf_hijos_4" id="ahf_hijos_4"> </select></td>
                  </tr>
                  <tr>
                    <td align="left" class="text-info">Notas</td>
                    <td colspan="5">
                      <input class="textHC form-control" name="ahf_notas" type="text" id="ahf_notas" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);">
                    </td>
                  </tr>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="tapnp"><br>
                <table width="100%" class="table table-condensed table-bordered table-striped">
                  <tr>
                    <td colspan="6" align="center" class="bg-info">ANTECEDENTES PERSONALES NO PATOLÓGICOS</td>
                  </tr>
                  <tr class="">
                    <td align="center" width="16.6%" class="text-info">Adicciones</td>
                    <td align="center" width="16.6%" class="text-info">Inicio</td>
                    <td align="center" width="16.6%" class="text-info">Frecuencia</td>
                    <td align="center" width="16.6%" class="text-info">Deportes</td>
                    <td align="center" width="16.6%" class="text-info">Frecuencia</td>
                    <td align="center" class="text-info">Recreaciones</td>
                  </tr>
                  <tr>
                    <td> <select class="adiccion selectHC form-control" name="adiccion1" id="adiccion1"> </select> </td>
                    <td> <select class="inicio selectHC form-control" name="inicio_adiccion1" id="inicio_adiccion1"> </select> </td>
                    <td> <select class="frecuencia selectHC form-control" name="frecuencia_adiccion1" id="frecuencia_adiccion1"> </select> </td>
                    <td> <select class="deporte selectHC form-control" name="deporte1" id="deporte1"> </select> </td>
                    <td> <select class="frecuencia selectHC form-control" name="frecuencia_deporte1" id="frecuencia_deporte1"> </select> </td>
                    <td> <select class="recreacion selectHC form-control" name="recreacion1" id="recreacion1"> </select> </td>
                  </tr>
                  <tr>
                    <td> <select class="adiccion selectHC form-control" name="adiccion2" id="adiccion2"> </select> </td>
                    <td> <select class="inicio selectHC form-control" name="inicio_adiccion2" id="inicio_adiccion2"> </select> </td>
                    <td> <select class="frecuencia selectHC form-control" name="frecuencia_adiccion2" id="frecuencia_adiccion2"> </select> </td>
                    <td> <select class="deporte selectHC form-control" name="deporte2" id="deporte2"> </select> </td>
                    <td> <select class="frecuencia selectHC form-control" name="frecuencia_deporte2" id="frecuencia_deporte2"> </select> </td>
                    <td> <select class="recreacion selectHC form-control" name="recreacion2" id="recreacion2"> </select> </td>
                  </tr>
                  <tr>
                    <td> <select class="adiccion selectHC form-control" name="adiccion3" id="adiccion3"> </select> </td>
                    <td> <select class="inicio selectHC form-control" name="inicio_adiccion3" id="inicio_adiccion3"> </select> </td>
                    <td> <select class="frecuencia selectHC form-control" name="frecuencia_adiccion3" id="frecuencia_adiccion3"> </select> </td>
                    <td> <select class="deporte selectHC form-control" name="deporte3" id="deporte3"> </select> </td>
                    <td> <select class="frecuencia selectHC form-control" name="frecuencia_deporte3" id="frecuencia_deporte2"> </select> </td>
                    <td> <select class="recreacion selectHC form-control" name="recreacion3" id="recreacion3"> </select> </td>
                  </tr>
                  <tr>
                    <td align="center" class="text-info">Aseo Personal</td>
                    <td> <select class="selectHC form-control" name="aseo_personal" id="aseo_personal"> </select> </td>
                    <td align="center" class="text-info">Alimentación</td>
                    <td> <select class="form-control" name="alimentacion_hc" id="alimentacion_hc"> </select> </td>
                    <td align="center" class="text-info">Hrs/Dormir</td>
                    <td>
                      <select class="form-control" name="hrs_dormir" id="hrs_dormir">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" class="text-info">Vivienda</td>
                    <td> <select name="vivienda_hc" id="vivienda_hc" class="selectHC form-control"> </select> </td>
                    <td align="center" class="text-info">Habitantes</td>
                    <td>
                      <select name="habitantes" id="habitantes" class="selectHC form-control">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                    <td align="center" class="text-info">Material Vivienda</td>
                    <td><select class="matV selectHC form-control" name="mat_vivienda1" id="mat_vivienda1"> </select></td>
                  </tr>
                  <tr>
                    <td align="center" class="text-info">Servicios</td>
                    <td> <select class="servicio_hc selectHC form-control" name="servicios1_hc" id="servicios1_hc"> </select> </td>
                    <td> <select class="servicio_hc selectHC form-control" name="servicios2_hc" id="servicios2_hc"> </select> </td>
                    <td> <select class="servicio_hc selectHC form-control" name="servicios3_hc" id="servicios3_hc"> </select> </td>
                    <td> <select class="servicio_hc selectHC form-control" name="servicios4_hc" id="servicios4_hc"> </select> </td>
                    <td> <select class="servicio_hc selectHC form-control" name="servicios5_hc" id="servicios5_hc"> </select> </td>
                  </tr>
                  <tr>
                    <td align="center" class="text-info">Mascotas</td>
                    <td> <select class="mascota form-control" name="mascota1" id="mascota1"> </select> </td>
                    <td> <select class="mascota form-control" name="mascota2" id="mascota2"> </select> </td>
                    <td> <select class="mascota form-control" name="mascota3" id="mascota3"> </select> </td>
                    <td> <select class="mascota form-control" name="mascota4" id="mascota4"> </select> </td>
                    <td> <select class="mascota form-control" name="mascota5" id="mascota5"> </select> </td>
                  </tr>
                  <tr>
                    <td align="center" class="text-info">Vacunas</td>
                    <td> <select class="vacuna form-control" name="vacunas1" id="vacunas1"> </select> </td>
                    <td> <select class="vacuna form-control" name="vacunas2" id="vacunas2"> </select> </td>
                    <td> <select class="vacuna form-control" name="vacunas3" id="vacunas3"> </select> </td>
                    <td> <select class="vacuna form-control" name="vacunas4" id="vacunas4"> </select> </td>
                    <td> <select class="vacuna form-control" name="vacunas5" id="vacunas5"> </select> </td>
                  </tr>
                  <tr>
                    <td align="center" class="text-info">Notas</td>
                    <td colspan="5"> <input class="textHC form-control" name="apnp_notas" type="text" id="apnp_notas" value="" size="" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"> </td>
                  </tr>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="tapp"><br>
                <table width="100%" class="table table-condensed table-bordered table-striped">
                  <tr>
                    <td colspan="6" align="center" class="bg-info">ANTECEDENTES PATOLÓGICOS PERSONALES</td>
                  </tr>
                  <tr>
                    <td align="" class="text-info">Enfermedad</td>
                    <td width="17%"> <select class="enfermedad form-control" name="enfermedad1" id="enfermedad1"> </select></td>
                    <td width="17%"> <select class="enfermedad form-control" name="enfermedad2" id="enfermedad2"> </select></td>
                    <td width="17%"> <select class="enfermedad form-control" name="enfermedad3" id="enfermedad3"> </select></td>
                    <td width="17%"> <select class="enfermedad form-control" name="enfermedad4" id="enfermedad4"> </select></td>
                    <td width="17%"> <select class="enfermedad form-control" name="enfermedad5" id="enfermedad5"> </select></td>
                  </tr>
                  <tr>
                    <td align="" valign="middle" class="text-info">Alérgias</td>
                    <td>
                      <input class="form-control" name="alergia1" type="text" id="alergia1" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);">
                    </td>
                    <td>
                      <input class="form-control" name="alergia2" type="text" id="alergia2" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);">
                    </td>
                    <td>
                      <input class="form-control" name="alergia3" type="text" id="alergia3" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);">
                    </td>
                    <td>
                      <input class="form-control" name="alergia4" type="text" id="alergia4" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);">
                    </td>
                    <td>
                      <input class="form-control" name="alergia5" type="text" id="alergia5" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);">
                    </td>
                  </tr>
                  <tr>
                    <td align="" class="text-info">Cirugías</td>
                    <td> <input class="form-control" name="cirugia1" type="text" id="cirugia1" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
                    <td> <input class="form-control" name="cirugia2" type="text" id="cirugia2" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
                    <td> <input class="form-control" name="cirugia3" type="text" id="cirugia3" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
                    <td align="center" class="text-info">Transfusiones</td>
                    <td>
                      <select class="form-control" name="transfusiones" id="transfusiones">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="" class="text-info">Notas</td>
                    <td colspan="5"> <input class="form-control" name="app_notas" type="text" id="app_notas" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"> </td>
                  </tr>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="tago"><br>
                <table width="100%" class="table table-condensed table-bordered table-striped">
                  <tr>
                    <td colspan="6" align="center" class="bg-info">ANTECEDENTES GINECOOBSTETRICOS</td>
                  </tr>
                  <tr>
                    <td align="" class="text-info" width="16%">Menarca</td>
                    <td width="">
                      <select class="form-control" name="menarca" id="menarca">
                        <option value="">-EDAD-</option>
                        <option value="8">8 AÑOS</option>
                        <option value="9">9 AÑOS</option>
                        <option value="10">10 AÑOS</option>
                        <option value="11">11 AÑOS</option>
                        <option value="12">12 AÑOS</option>
                        <option value="13">13 AÑOS</option>
                        <option value="14">14 AÑOS</option>
                        <option value="15">15 AÑOS</option>
                        <option value="16">16 AÑOS</option>
                        <option value="17">17 AÑOS</option>
                      </select>
                    </td>
                    <td align="" class="text-info" width="15%">Ritmo</td>
                    <td width=""> <select class="form-control" name="ritmo" id="ritmo">
                        <option value="">-SELECCIONAR-</option>
                        <option value="1">REGULAR</option>
                        <option value="2">IRREGULAR</option>
                      </select> </td>
                    <td align="" class="text-info" width="15%">Duración</td>
                    <td width="">
                      <select class="form-control" name="duracionR" id="duracionR">
                        <option value="">-DÍAS-</option>
                        <option value="1">1 DÍA</option>
                        <option value="2">2 DÍAS</option>
                        <option value="3">3 DÍAS</option>
                        <option value="4">4 DÍAS</option>
                        <option value="5">5 DÍAS</option>
                        <option value="6">6 DÍAS</option>
                        <option value="7">7 DÍAS</option>
                        <option value="8">8 DÍAS</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="" class="text-info"><span title="Fecha de última regla">F.U.R.</span></td>
                    <td> <input name="fur" type="text" id="fur" class="form-control" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></td>
                    <td align="" class="text-info"><span title="Iniciación de vida sexual activa">I.V.S.A.</span></td>
                    <td>
                      <select class="form-control" name="ivsa" id="ivsa">
                        <option value="">-EDAD-</option>
                        <option value="8">8 AÑOS</option>
                        <option value="9">9 AÑOS</option>
                        <option value="10">10 AÑOS</option>
                        <option value="11">11 AÑOS</option>
                        <option value="12">12 AÑOS</option>
                        <option value="13">13 AÑOS</option>
                        <option value="14">14 AÑOS</option>
                        <option value="15">15 AÑOS</option>
                        <option value="16">16 AÑOS</option>
                        <option value="17">17 AÑOS</option>
                        <option value="18">18+ AÑOS</option>
                      </select>
                    </td>
                    <td align="" class="text-info">Gestas</td>
                    <td>
                      <select class="form-control" name="gestas" id="gestas">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="" class="text-info">Partos</td>
                    <td>
                      <select class="form-control" name="partos" id="partos">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                    <td align="" class="text-info">Cesareas</td>
                    <td>
                      <select class="form-control" name="cesareas" id="cesareas">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                    <td align="" class="text-info">Abortos</td>
                    <td>
                      <select class="form-control" name="abortos" id="abortos">
                        <option value="">-NÚMERO-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10+</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="" class="text-info">Anticonceptivo</td>
                    <td> <select class="form-control" name="anticonceptivo" id="anticonceptivo">
                        <option value="">-SELECCIONAR-</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                      </select> </td>
                    <td align="" class="text-info">Tipo</td>
                    <td> <select class="form-control" name="tipo_anticon" id="tipo_anticon"> </select> </td>
                    <td align="" class="text-info">Tiempo uso</td>
                    <td><select class="form-control" name="tiempo_uso" id="tiempo_uso">
                        <option value="">-AÑOS-</option>
                        <option value="1">1 AÑO</option>
                        <option value="2">2 AÑOS</option>
                        <option value="3">3 AÑOS</option>
                        <option value="4">4 AÑOS</option>
                        <option value="5">5+ AÑOS</option>
                      </select> </td>
                  </tr>
                  <tr>
                    <td align="" class="text-info">Notas</td>
                    <td colspan="5"> <input class="form-control" name="ago_notas" type="text" id="ago_notas" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"> </td>
                  </tr>
                </table>
              </div>
            </div>
          </form>
        </div>
        <div role="tabpanel" class="tab-pane active" id="tNM">
          <form name="formConsulta" id="formConsulta" data-toggle="validator" role="form">
            <input name="id_medicoIm" id="id_medicoIm" type="hidden" value="">
            <input name="id_DepartamentoIm" id="id_DepartamentoIm" type="hidden" value="2">
            <table class="" width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="99%">
                  Motivo de la consulta:
                  <mark><var><span id="motivoC" name="motivoC" class=""></span></var></mark>
                </td>
              </tr>
            </table>
            <table width="100%" class="table table-condensed table-striped table-bordered">
              <tr>
                <td width="150" colspan="3" align="center" class="text-primary">SIGNOS VITALES</td>
                <td align="center">
                  <span class="text-success">NOTA MÉDICA</span>&nbsp;
                  <button type="button" class="btn btn-success btn-xs" id="imprimirNotaE" style="display:none;"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR</button>
                </td>
                <td align="right">
                  <button type="button" class="btn btn-info btn-xs" id="dictado" onclick="procesarV()"><i class="fa fa-microphone" aria-hidden="true"></i> INICIAR DICTADO</button>
                  <button type="button" class="btn btn-default btn-xs historialhes" id="verHistorialHcC" lang="h" onClick="historiales(1);">HC</button>
                  <button type="button" class="btn btn-default btn-xs historialhes" id="verHistorialLabC" lang="l" onClick="historiales(2);">LAB</button>
                  <button type="button" class="btn btn-default btn-xs historialhes" id="verHistorialUsgC" lang="u" onClick="historiales(3);">USG</button>
                  <button type="button" class="btn btn-default btn-xs historialhes" id="verHistorialImgC" lang="i" onClick="historiales(4);">IMG</button>
                  <button type="button" class="btn btn-default btn-xs historialhes" id="verHistorialEndC" lang="e" onClick="historiales(5);">END</button>
                  <button type="button" class="btn btn-default btn-xs historialhes" id="verHistorialColC" lang="c" onClick="historiales(6);">COL</button>
                  <button type="button" class="btn btn-default btn-xs historialhes hidden" id="verHistorialOtrosC" lang="o" onClick="historiales();">OTROS</button>
                  <button type="button" class="btn btn-default btn-xs historialhes" id="verHistorialNotasC" lang="n" onClick="historiales(7);">CNTS</button>
                </td>
              </tr>

              <tr height="1">
                <td align="left"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true" id="aFC"></i> FC</td>
                <td align="right"><span id="fc0"></span></td>
                <td class="small">
                  <span id="graficaFC" style="cursor:pointer;" onClick="graficas(1)"></span>
                </td>
                <td colspan="2" rowspan="10">
                  <select class="form-control input-sm" name="tipoNotaMed" id="tipoNotaMed"> </select>
                  <input style="resize:none; text-align:left" name="notaMedicaC" id="notaMedicaC" type="text" value="" class="jqte-test">
                </td>
              </tr>
              <tr height="1">
                <td align="left">
                  <i id="aFR" class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> FR
                </td>
                <td align="right"><span id="fr0"></span></td>
                <td class="small">
                  <span id="graficaFR" style="cursor:pointer;" onClick="graficas(2)"></span>
                </td>
              </tr>
              <tr height="1">
                <td align="left">
                  <i id="aT" class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> T
                </td>
                <td align="right"><span id="t0"></span></td>
                <td class="small">
                  <span id="graficaT" style="cursor:pointer;" onClick="graficas(3)"></span>
                </td>
              </tr>
              <tr height="1">
                <td align="left">
                  <i id="aTA" class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> A
                </td>
                <td nowrap align="right"><span id="ta0"></span></td>
                <td class="small">
                  <span id="graficaTA" style="cursor:pointer;" onClick="graficas(4)"></span>
                </td>
              </tr>
              <tr height="1">
                <td nowrap align="left">
                  <i id="aTEMP" class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> TEMP
                </td>
                <td align="right"><span id="temp0"></span></td>
                <td class="small">
                  <span id="graficaTemp" style="cursor:pointer;" onClick="graficas(5)"></span>
                </td>
              </tr>
              <tr height="1">
                <td align="left"><span id="aPESO" style="color:#000000; display:none;">*</span> PESO</td>
                <td align="right"><span id="peso0"></span></td>
                <td class="small">
                  <span id="graficaPESO" style="cursor:pointer;" onClick="graficas(6)"></span>
                </td>
              </tr>
              <tr height="1">
                <td nowrap align="left"><span id="aTALLA" style="color:black; display:none;">*</span> TALLA</td>
                <td align="right"><span id="talla0"></span></td>
                <td class="small">
                  <span id="graficaTALLA" style="cursor:pointer;" onClick="graficas(7)"></span>
                </td>
              </tr>
              <tr height="1">
                <td align="left">
                  <i id="aIMC" class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> IMC
                </td>
                <td align="right"><span id="imc0"></span></td>
                <td class="small">
                  <span id="graficaIMC" style="cursor:pointer;" onClick="graficas(8)"></span>
                </td>
              </tr>
              <tr height="1">
                <td align="left">
                  DEX
                </td>
                <td align="right">
                  <span id="dex0"></span>
                </td>
                <td class="small">
                  <span id="graficaDex" style="cursor:pointer;"></span>
                </td>
              </tr>
              <tr height="1">
                <td class="text-primary small" align="" colspan="3" style="">
                  <span id="usuario_svi">USER</span> <span id="fechaHoraC">15/10/15 22:49</span>
                </td>
              </tr>
              <tr>
                <td colspan="3" valign="top" style="max-width:150px;" align="left" class="text-danger small">
                  ALÉRGIAS: <span id="alergias0"></span>
                </td>
              </tr>
            </table>
          </form>
        </div>
        <div role="tabpanel" class="tab-pane" id="tReceta"><br>
          <div class="panel panel-info">
            <div class="panel-heading">
              <div id="acciones_receta_medica">
                <h3 id="titulo_receta" class="panel-title">RECETA <span class="hidden">(Frontal)</span>
                  <button type="button" class="btn btn-success btn-xs" id="imprimirRecetaF" style="display:none;"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR</button>
                </h3>
                <button id="medicamentos" class="btn btn-success">MEDICAMENTOS</button>
                <button id="descargar_receta" class="btn btn-info">DESCARGAR RECETA</button>
              </div>
            </div>
            <div class="panel-body">
              <!-- Se comentaron las siguientes dos lineas para cambiar el diseño de la visualización de la receta 23/08/23 -->
              <select class="form-control input-sm" name="tipoRecetaMed" id="tipoRecetaMed"> </select>
              <input style="resize:none; text-align:left" name="indiF" id="indiF" type="text" value="" class="jqte-test">
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tImgs">
          <table width="100%" id="tablaVideos" class="table table-condensed table-bordered">
            <tr>
              <td id="celdaVideo" width="50%" valign="top">
                <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr style="display:none;">
                    <td id="imagenesEndo" valign="top"></td>
                  </tr>
                  <tr height="1%">
                    <td valign="top" align="center" style="padding-bottom:3px;">
                      <button type="button" class="btn btn-success botonE btn-xs" id="start"> <i class="fa fa-video-camera" aria-hidden="true"></i> Iniciar video</button>
                      <button type="button" class="btn btn-primary botonE btn-xs hidden" id="capture"><i class="fa fa-camera" aria-hidden="true"></i> Capturar imagen</button>
                      <button type="button" class="btn btn-warning botonE btn-xs hidden" id="stop"><i class="fa fa-stop" aria-hidden="true"></i> Detener video</button>
                    </td>
                  </tr>
                  <tr>
                    <td id="contenedorVideo" valign="top"><video id="video" autoplay width="" height=""></video></td>
                  </tr>
                </table>
              </td>
              <td id="contenedorCanvas" valign="top" style="overflow:scroll;">
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

        <div role="tabpanel" class="tab-pane" id="tDx"><br>
          <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
            <tr height="50%">
              <td>
                <div class="panel panel-info">
                  <!-- Default panel contents -->
                  <div class="panel-heading">
                    <strong>LISTA DE DIAGNÓSTICOS DISPONIBLES.</strong> Seleccione los diagnósticos deseados con un <strong>click</strong>.
                  </div>
                  <table width="100%" cellspacing="0" id="dataTableBDX" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-condensed table-responsive">
                    <thead id="my_head">
                      <tr class="bg-info">
                        <th align="center" width="100px" id="clickmeDXD">CLAVE</th>
                        <th align="center">
                          DIAGNÓSTICO &nbsp;
                          <button type="button" class="btn btn-success btn-xs hidden" id="altaDX" alt="Dar de alta un diagnóstico">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody align="left">
                      <tr>
                        <td class="dataTables_empty">Cargando datos del servidor</td>
                      </tr>
                    </tbody>
                    <tfoot class="pieTablaBDX" id="mi_pie_tabla" align="center">
                      <tr>
                        <th><input type="text" name="textfield1" id="textfield1" class="form-control" style="width:99%;" placeholder="Buscar"></th>
                        <th><input type="text" name="textfield2" id="textfield2" class="form-control" style="width:99%;" placeholder="Buscar"></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="panel panel-success">
                  <!-- Default panel contents -->
                  <div class="panel-heading"> <strong>LISTA DE DIAGNÓSTICOS SELECCIONADOS</strong> </div>
                  <table width="100%" cellspacing="0" id="dataTableDXS" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-condensed table-responsive">
                    <thead id="my_head">
                      <tr class="bg-success">
                        <th id="clickmeDXS" align="center" width="1%">#</th>
                        <th align="center" width="1%">CLAVE</th>
                        <th align="center">DIAGNÓSTICO</th>
                        <th align="center" width="1%">PRIMARIO</th>
                        <th align="center" width="1%">GPC</th>
                        <th align="center" width="1%">ELIMINAR</th>
                      </tr>
                    </thead>
                    <tbody align="left">
                      <tr>
                        <td class="dataTables_empty">Cargando datos del servidor</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>
          </table>
        </div>

        <div role="tabpanel" class="tab-pane" id="tMeds"><br>
          <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
            <tr height="50%">
              <td>
                <div class="panel panel-info">
                  <!-- Default panel contents -->
                  <div class="panel-heading">
                    <strong>LISTA DE MEDICAMENTOS DISPONIBLES.</strong> Seleccione los medicamentos deseados con un <strong>click</strong>.
                  </div>
                  <table width="100%" cellspacing="0" id="dataTableBMedicamentos" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-condensed table-responsive">
                    <thead id="my_head">
                      <tr class="bg-info">
                        <th align="center" width="100px" id="clickmeMEDS">#</th>
                        <th align="center">
                          MEDICAMENTO&nbsp;
                          <button type="button" class="btn btn-success btn-xs hidden" id="altaMedicamento" alt="Dar de alta un medicamento">
                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                          </button>
                        </th>
                        <th align="center">BASE</th>
                        <th align="center">PRESENTACIÓN</th>
                        <th align="center">CONCENTRACIÓN</th>
                        <th align="center">VÍA</th>
                        <th align="center">LOTE</th>
                        <th align="center">EXISTENCIAS</th>
                        <th align="center">PLM</th>
                      </tr>
                    </thead>
                    <tbody align="left">
                      <tr>
                        <td class="dataTables_empty">Cargando datos del servidor</td>
                      </tr>
                    </tbody>
                    <tfoot id="mi_pie_tabla" align="center">
                      <tr>
                        <th></th>
                        <th><input type="text" name="tex" id="tex" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                        <th><input type="text" name="tex2" id="tex2" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                        <th><input type="text" name="tex3" id="tex3" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                        <th><input type="text" name="tex4" id="tex4" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                        <th><input type="text" name="tex5" id="tex5" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                        <th><input type="text" name="tex6" id="tex6" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                        <th><input type="text" name="tex7" id="tex7" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="panel panel-success">
                  <!-- Default panel contents -->
                  <div id="div_medicamentos_seleccionados_consulta" class="panel-heading">
                    <strong>LISTA DE MEDICAMENTOS SELECCIONADOS</strong>
                    <button id="button_agregar_medicamentos_receta" type="button" class="btn btn-info">Agregar medicamentos</button>
                  </div>
                  <table width="100%" cellspacing="0" id="dataTableMS" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-condensed table-responsive">
                    <thead id="my_head">
                      <tr class="bg-success">
                        <th id="clickmeMS" align="center" width="1%">#</th>
                        <th align="center">MEDICAMENTO</th>
                        <th align="center" style="color: #00FF00;">SINERGIAS</th>
                        <th align="center" style="color: #FF0000;">ANTAGONISMOS</th>
                        <th align="center">BASE</th>
                        <th align="center">PRESENTACIÓN</th>
                        <th align="center">CONCENTRACIÓN</th>
                        <th align="center">VÍA</th>
                        <th align="center" width="1%">ELIMINAR</th>
                      </tr>
                    </thead>
                    <tbody align="left">
                      <tr>
                        <td class="dataTables_empty">Cargando datos del servidor</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>
          </table>
        </div>

        <div role="tabpanel" class="tab-pane" id="tGrafs"><br>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist" id="tabs_graficas">
            <li role="presentation" class="tab_graficas">
              <a href="#tGrafi1" aria-controls="tGrafi1" role="tab" data-toggle="tab" id="tab_grafi_1">FC</a>
            </li>
            <li role="presentation" class="tab_graficas">
              <a href="#tGrafi2" aria-controls="tGrafi2" role="tab" data-toggle="tab" id="tab_grafi_2">FR</a>
            </li>
            <li role="presentation" class="active tab_graficas">
              <a href="#tGrafi3" aria-controls="tGrafi3" role="tab" data-toggle="tab" id="tab_grafi_3">T</a>
            </li>
            <li role="presentation" class="tab_graficas">
              <a href="#tGrafi4" aria-controls="tGrafi4" role="tab" data-toggle="tab" id="tab_grafi_4">A</a>
            </li>
            <li role="presentation" class="tab_graficas">
              <a href="#tGrafi5" aria-controls="tGrafi5" role="tab" data-toggle="tab" id="tab_grafi_5">TEMP</a>
            </li>
            <li role="presentation" class="tab_graficas">
              <a href="#tGrafi6" aria-controls="tGrafi6" role="tab" data-toggle="tab" id="tab_grafi_6">PESO</a>
            </li>
            <li role="presentation" class="tab_graficas">
              <a href="#tGrafi7" aria-controls="tGrafi7" role="tab" data-toggle="tab" id="tab_grafi_7">TALLA</a>
            </li>
            <li role="presentation" class="tab_graficas">
              <a href="#tGrafi8" aria-controls="tGrafi8" role="tab" data-toggle="tab" id="tab_grafi_8">IMC</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="tGrafi1" align="center">
              <p class="bg-info" align="center">FRECUENCIA CARDIACA</p>
              <div class="miCanva" id="myChart1"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tGrafi2" align="center">
              <p class="bg-info" align="center">FRECUENCIA RESPIRATORIA</p>
              <div class="miCanva" id="myChart2"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tGrafi3" align="center">
              <p class="bg-info" align="center">PRESIÓN ARTERIAL SISTÓLICA</p>
              <div class="miCanva" id="myChart3"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tGrafi4" align="center">
              <p class="bg-info" align="center">PRESIÓN ARTERIAL DIASTÓLICA</p>
              <div class="miCanva" id="myChart4"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tGrafi5" align="center">
              <p class="bg-info" align="center">TEMPERATURA</p>
              <div class="miCanva" id="myChart5"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tGrafi6" align="center">
              <p class="bg-info" align="center">PESO</p>
              <div class="miCanva" id="myChart6"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tGrafi7" align="center">
              <p class="bg-info" align="center">TALLA</p>
              <div class="miCanva" id="myChart7"></div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tGrafi8" align="center">
              <p class="bg-info" align="center">ÍNDICE DE MASA CORPORAL</p>
              <div class="miCanva" id="myChart8"></div>
            </div>
          </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="tHisto"><br>
          <div class="si_img_h" id="mostrar_img_histor" align="center"></div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs no_img_h" role="tablist" id="tabs_historiales">
            <li role="presentation" class="tab_historiales active">
              <a href="#tHisto1" aria-controls="tHisto1" role="tab" data-toggle="tab" id="tab_histo_1">HC</a>
            </li>
            <li role="presentation" class="tab_historiales">
              <a href="#tHisto2" aria-controls="tHisto2" role="tab" data-toggle="tab" id="tab_histo_2">LAB</a>
            </li>
            <li role="presentation" class="tab_historiales">
              <a href="#tHisto3" aria-controls="tHisto3" role="tab" data-toggle="tab" id="tab_histo_3">USG</a>
            </li>
            <li role="presentation" class="tab_historiales">
              <a href="#tHisto4" aria-controls="tHisto4" role="tab" data-toggle="tab" id="tab_histo_4">IMG</a>
            </li>
            <li role="presentation" class="tab_historiales">
              <a href="#tHisto5" aria-controls="tHisto5" role="tab" data-toggle="tab" id="tab_histo_5">END</a>
            </li>
            <li role="presentation" class="tab_historiales">
              <a href="#tHisto6" aria-controls="tHisto6" role="tab" data-toggle="tab" id="tab_histo_6">COL</a>
            </li>
            <li role="presentation" class="tab_historiales">
              <a href="#tHisto7" aria-controls="tHisto7" role="tab" data-toggle="tab" id="tab_histo_7">CNTS</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content no_img_h">
            <div role="tabpanel" class="tab-pane active" id="tHisto1"><br>
            </div>
            <div role="tabpanel" class="tab-pane" id="tHisto2">
              <table width="100%" border="0">
                <tr>
                  <td width="30%">
                    <table width="100%" height="100%" class="table table-bordered table-hover table-condensed table-striped" id="dataTableHLab">
                      <thead>
                        <tr class="bg-info">
                          <th id="clickmeHLab">#</th>
                          <th align="center">FECHA</th>
                          <th align="center">
                            ESTUDIO
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody align="left">
                        <tr>
                          <td class="dataTables_empty">Cargando datos del servidor</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td valign="top">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histos" style="margin-top:6px;">
                      <li role="presentation" class="tab_sub_histos active">
                        <a href="#tHLab" aria-controls="tHLab" role="tab" data-toggle="tab" id="tab_histo_lab">RESULTADOS</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="tHLab" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">

                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tHisto3">
              <table width="100%" border="0">
                <tr>
                  <td width="30%">
                    <table width="100%" height="100%" class="table table-bordered table-hover table-condensed table-striped" id="dataTableHusg">
                      <thead>
                        <tr class="bg-info">
                          <th id="clickmeHusg">#</th>
                          <th align="center">FECHA</th>
                          <th align="center">
                            ESTUDIO
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody align="left">
                        <tr>
                          <td class="dataTables_empty">Cargando datos del servidor</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td valign="top">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosU" style="margin-top:6px;">
                      <li role="presentation" class="tab_sub_histosU active">
                        <a href="#tHusg" aria-controls="tHusg" role="tab" data-toggle="tab" id="tab_histo_usg">INTERPRETACIÓN</a>
                      </li>
                      <li role="presentation" class="tab_sub_histosU">
                        <a href="#tHusg1" aria-controls="tHusg1" role="tab" data-toggle="tab" id="tab_histo_usg1">IMÁGENES</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="tHusg" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" class="table table-condensed table-bordered">
                          <tr>
                            <td id="dx_ehu" align="left" valign="top"> </td>
                          </tr>
                          <tr height="1px">
                            <td nowrap align="right" id="doctor_ehu"></td>
                          </tr>
                        </table>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="tHusg1" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" border="0" class="table table-condensed table-bordered">
                          <tr>
                            <td id="deCanvas1" align="center" valign="top" align="center"></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tHisto4">
              <table width="100%" border="0">
                <tr>
                  <td width="30%">
                    <table width="100%" height="100%" class="table table-bordered table-hover table-condensed table-striped" id="dataTableHimg">
                      <thead>
                        <tr class="bg-info">
                          <th id="clickmeHimg">#</th>
                          <th align="center">FECHA</th>
                          <th align="center">
                            ESTUDIO
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </button>
                          </th>
                          <th align="center" style="width:1px;">PACS</th>
                        </tr>
                      </thead>
                      <tbody align="left">
                        <tr>
                          <td class="dataTables_empty">Cargando datos del servidor</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td valign="top">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosIm" style="margin-top:6px;">
                      <li role="presentation" class="tab_sub_histosIm active">
                        <a href="#tHimg" aria-controls="tHimg" role="tab" data-toggle="tab" id="tab_histo_img">INTERPRETACIÓN</a>
                      </li>
                      <li role="presentation" class="tab_sub_histosIm">
                        <a href="#tHimg2" aria-controls="tHimg2" role="tab" data-toggle="tab" id="tab_histo_img2">CAPTURAS</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="tHimg" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" class="table table-condensed table-bordered">
                          <tr>
                            <td id="dx_ehi" align="left" valign="top"> </td>
                          </tr>
                          <!--<tr height="1px"> <td nowrap align="right" id="doctor_ehi"></td> </tr> -->
                        </table>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="tHimg2" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" border="0" class="table table-condensed table-bordered">
                          <tr>
                            <td id="deCanvas2i" align="center" valign="top" align="center"></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tHisto5">
              <table width="100%" border="0">
                <tr>
                  <td width="30%">
                    <table width="100%" height="100%" class="table table-bordered table-hover table-condensed table-striped" id="dataTableHend">
                      <thead>
                        <tr class="bg-info">
                          <th id="clickmeHend">#</th>
                          <th align="center">FECHA</th>
                          <th align="center">
                            ESTUDIO
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody align="left">
                        <tr>
                          <td class="dataTables_empty">Cargando datos del servidor</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td valign="top">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosEn" style="margin-top:6px;">
                      <li role="presentation" class="tab_sub_histosEn active">
                        <a href="#tHend" aria-controls="tHend" role="tab" data-toggle="tab" id="tab_histo_end">INTERPRETACIÓN</a>
                      </li>
                      <li role="presentation" class="tab_sub_histosEn">
                        <a href="#tHend1" aria-controls="tHend1" role="tab" data-toggle="tab" id="tab_histo_end1">IMÁGENES</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="tHend" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" class="table table-condensed table-bordered">
                          <tr>
                            <td id="dx_ehe" align="left" valign="top"> </td>
                          </tr>
                          <tr height="1px">
                            <td nowrap align="right" id="doctor_ehe"></td>
                          </tr>
                        </table>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="tHend1" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" border="0" class="table table-condensed table-bordered">
                          <tr>
                            <td id="deCanvas1e" align="center" valign="top" align="center"></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tHisto6">
              <table width="100%" border="0">
                <tr>
                  <td width="30%">
                    <table width="100%" height="100%" class="table table-bordered table-hover table-condensed table-striped" id="dataTableHcol">
                      <thead>
                        <tr class="bg-info">
                          <th id="clickmeHcol">#</th>
                          <th align="center">FECHA</th>
                          <th align="center">
                            ESTUDIO
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody align="left">
                        <tr>
                          <td class="dataTables_empty">Cargando datos del servidor</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td valign="top">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosCo" style="margin-top:6px;">
                      <li role="presentation" class="tab_sub_histosCo active">
                        <a href="#tHcol" aria-controls="tHcol" role="tab" data-toggle="tab" id="tab_histo_col">INTERPRETACIÓN</a>
                      </li>
                      <li role="presentation" class="tab_sub_histosCo">
                        <a href="#tHcol1" aria-controls="tHcol1" role="tab" data-toggle="tab" id="tab_histo_col1">IMÁGENES</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="tHcol" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" class="table table-condensed table-bordered">
                          <tr>
                            <td id="dx_ehc" align="left" valign="top"> </td>
                          </tr>
                          <tr height="1px">
                            <td nowrap align="right" id="doctor_ehc"></td>
                          </tr>
                        </table>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="tHcol1" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" border="0" class="table table-condensed table-bordered">
                          <tr>
                            <td id="deCanvas1c" align="center" valign="top" align="center"></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tHisto7">
              <table width="100%" border="0">
                <tr>
                  <td width="30%">
                    <table width="100%" height="100%" class="table table-bordered table-hover table-condensed table-striped" id="dataTableHnot">
                      <thead>
                        <tr class="bg-info">
                          <th id="clickmeHnot">#</th>
                          <th align="center">FECHA</th>
                          <th align="center">
                            CONCEPTO
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-left" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" id="">
                              <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody align="left">
                        <tr>
                          <td class="dataTables_empty">Cargando datos del servidor</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td valign="top">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="tabs_sub_histosNo" style="margin-top:6px;">
                      <li role="presentation" class="tab_sub_histosNo active">
                        <a href="#tHnot" aria-controls="tHnot" role="tab" data-toggle="tab" id="tab_histo_not">NOTA MÉDICA</a>
                      </li>
                      <li role="presentation" class="tab_sub_histosNo">
                        <a href="#tHnot1" aria-controls="tHnot1" role="tab" data-toggle="tab" id="tab_histo_not1">RECETA</a>
                      </li>
                      <li role="presentation" class="tab_sub_histosNo">
                        <a href="#tHnot2" aria-controls="tHnot2" role="tab" data-toggle="tab" id="tab_histo_not2">CAPTURAS</a>
                      </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="tHnot" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" class="table table-condensed table-bordered">
                          <tr>
                            <td id="dx_ehn" align="left" valign="top"> </td>
                          </tr>
                          <tr height="1px">
                            <td nowrap align="right" id="doctor_ehn"></td>
                          </tr>
                        </table>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="tHnot1" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" class="table table-condensed table-bordered">
                          <tr>
                            <td id="dx_ehn1" align="left" valign="top"> </td>
                          </tr>
                          <tr height="1px">
                            <td nowrap align="right" id="doctor_ehn1"></td>
                          </tr>
                        </table>
                      </div>
                      <div role="tabpanel" class="tab-pane" id="tHnot2" align="center" style="height:100px; overflow:scroll; vertical-align:top; border:1px none red;">
                        <table width="100%" border="0" class="table table-condensed table-bordered">
                          <tr>
                            <td id="deCanvas1n" align="center" valign="top" align="center"></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- Tab panes -->
      <div class="hidden">
        <canvas id="miFotoX" width="700" height="525"></canvas> <canvas id="miFotoX1" width="200" height="150"></canvas>
      </div>

    </div>
  </div>
</div>