<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_consulta">
  <div class="modal-content animated flipInY">
    <div class="modal-header">
      <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title"><strong><span id="titulo_modal">CREAR UN NUEVO MEDICAMENTO COMERCIAL</span></strong></h4>
    </div>
    <div class="modal-body">

      <ul class="nav nav-tabs">
        <li role="presentation" class="active" id="t-generales">
          <a href="#tGenerales" aria-controls="tGenerales" role="tab" data-toggle="tab">GENERALES</a>
        </li>
        <li role="presentation" class="hidden ocul" id="t-adicionales">
          <a href="#tAdicionales" aria-controls="tAdicionales" role="tab" data-toggle="tab">ADICIONALES</a>
        </li>
        <li role="presentation" class="hidden" id="t-medicamento">
          <a id="link-tab-3" href="#tMedicamento" aria-controls="tMedicamento" role="tab" data-toggle="tab">NUEVO MEDICAMENTO GENERICO</a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tGenerales">
          <div class="panel panel-success">
            <!-- Default panel contents-->
            <!--<div class="panel-heading"><p>Selecciona un medicamento de la lista de medicamentos genéricos</p></div>-->
            <div class="panel-body"> Selecciona un medicamento de la lista de medicamentos genéricos <span class="btn btn-primary" id="btnNewMedGenerico"><i class="fa fa-plus"></i> Medicamento Generico</span></div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="dataTableM" class="table table-hover table-striped dataTable table-condensed">
              <thead id="cabecera_tBusquedaM">
                <tr role="row" class="bg-success">
                  <th id="clickmeM" style="vertical-align:middle;">MEDICAMENTO GENÉRICO</th>
                  <th style="vertical-align:middle;">DESCRIPCIÓN</th>
                  <th style="vertical-align:middle;">CANTIDAD</th>
                  <th style="vertical-align:middle;">GRUPO</th>
                  <th style="vertical-align:middle;">NIVEL</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="dataTables_empty">Cargando datos del servidor</td>
                </tr>
              </tbody>
              <tfoot>
                <tr class="bg-success">
                  <th><input name="sgen" id="sgen" type="text" class="form-control input-sm" placeholder="Genérico" /></th>
                  <th><input name="sdes" id="sdes" type="text" class="form-control input-sm" placeholder="Descripción" /></th>
                  <th><input name="scan" id="scan" type="text" class="form-control input-sm" placeholder="Cantidad" /></th>
                  <th><input name="sgru" id="sgru" type="text" class="form-control input-sm" placeholder="Grupo" /></th>
                  <th><input name="sniv" id="sniv" type="text" class="form-control input-sm" placeholder="Nivel" /></th>
                </tr>
              </tfoot>
            </table>
            <!-- Table -->
            <form class="form-horizontal ocul hidden" id="form-medicamento"> <input name="id_med_up" id="id_med_up" type="hidden" value="">
              <div class="form-group" id="medicamento_base">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">MEDICAMENTO BASE: </div>
                <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10" id="tex_base"></div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">PRESENTACIÓN: </div>
                <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10" id="tex_presentacion"></div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">VÍA DE ADMINISTRACIÓN: </div>
                <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10" id="tex_via"></div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* NOMBRE COMERCIAL: </div>
                <div class="col-md-5 col-sm-5 col-xs-5 col-lg-5">
                  <input type="text" class="form-control input-sm" placeholder="Ingrese el nombre comercial del medicamento" id="nombre_c_m" name="nombre_c_m" required>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1 text-primary" align="right">* LÍNEA</div>
                <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4">
                  <select name='linea_med' class="form-control input-sm" id='linea_med' required></select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* DOSIS: </div>
                <div class="col-md-10 col-sm-10 col-xs-10 col-lg-10">
                  <textarea class="form-control" rows="3" style="resize:none;" id="tex_dosis" name="tex_dosis" required></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* PRECIO PÚBLICO</div>
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                  <input type="text" class="form-control input-sm" placeholder="Ingrese el precio público" id="precio_p_m" name="precio_p_m" required>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* PRECIO HOSPITAL</div>
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                  <input type="text" class="form-control input-sm" placeholder="Ingrese el precio de hospital" id="precio_h_m" name="precio_h_m" required>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* PRECIO MEMBRESÍA</div>
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                  <input type="text" class="form-control input-sm" placeholder="Ingrese el precio de membresía" id="precio_m_m" name="precio_m_m" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* COSTO</div>
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
                  <input type="text" class="form-control input-sm" placeholder="Ingrese el costo del medicamento" id="costo_m" name="costo_m" required>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">CÓDIGO DE BARRAS: </div>
                <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                  <input type="text" class="form-control input-sm" placeholder="Ingrese el código de barras" id="codigo_b_m" name="codigo_b_m">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* CONVENIO</div>
                <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
                  <select name='miSucursalNS' class="form-control input-sm" id='miSucursalNS' required></select>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1 text-primary" align="right">* MAX</div>
                <div class="col-sm-1 col-xs-1 col-md-1 col-lg-1">
                  <input type="number" class="form-control input-sm" min="2" name="max_p" id="max_p">
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1 text-primary" align="right">* MIN</div>
                <div class="col-sm-1 col-xs-1 col-md-1 col-lg-1">
                  <input type="number" class="form-control input-sm" min="1" name="min_p" id="min_p">
                </div>
                <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                  <select name="sat" id="sat" class="form-control form-control-sm"></select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* SINERGIAS</div>
                <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 text-nowrap">
                  <input type="text" id="buscar_sinergia" class="form-control" placeholder="buscar un medicamento" style="margin-bottom: 0.5rem;">
                  <p class="mensaje_select_multiple">Para agregar o quitar un medicamento manten presionada la tecla CONTROL</p>
                  <select title name='sinergias' class="form-control input-sm" id='sinergias' required multiple style="height: 10rem; width: 80rem;"></select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 text-primary" align="right" id='s_seleccionados'>SINERGIAS SELECCIONADAS</div>
                <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3 text-nowrap">
                  <select title name='sinergias_seleccionadas' class="form-control input-sm" id='sinergias_seleccionadas' multiple style="height: 10rem; width: 40rem;"></select>
                </div>
              </div>
              <!-- <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">SINERGIAS SELECCIONADAS</div>
                <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 text-nowrap">
                  <select title name='sinergias_seleccionadas' class="form-control input-sm" id='sinergias_seleccionadas' multiple style="height: 10rem; width: 80rem;"></select>
                </div>
              </div> -->
              <div class="form-group">
                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 text-primary" align="right">* ANTAGONISMOS</div>
                <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 text-nowrap">
                  <input type="text" id="buscar_antagonismo" class="form-control" placeholder="buscar un medicamento" style="margin-bottom: 0.5rem;">
                  <p class="mensaje_select_multiple">Para agregar o quitar un medicamento manten presionada la tecla CONTROL</p>
                  <select title name='antagonismos' class="form-control input-sm" id='antagonismos' required multiple style="height: 10rem; width: 80rem;"></select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 text-primary" align="right" id='a_seleccionados'>ANTAGONISMOS SELECCIONADOS</div>
                <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3 text-nowrap">
                  <select title name='antagonismos_seleccionados' class="form-control input-sm" id='antagonismos_seleccionados' multiple style="height: 10rem; width: 40rem;"></select>
                </div>
              </div>
              <br>
              <input name="tamHcanvas" id="tamHcanvas" type="hidden" value="">
              <input name="id_mg" id="id_mg" type="hidden" value="">
              <input name="id_user_reg_m" id="id_user_reg_m" type="hidden" value="">
            </form>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tAdicionales"><br>
          <table class="table table-condensed">
            <tr>
              <td class="text-primary" valign="top">GENERALIDADES</td>
              <td id="tex_generalidades"></td>
            </tr>
            <tr>
              <td class="text-primary">INTERACCIONES</td>
              <td id="tex_interacciones"></td>
            </tr>
            <tr>
              <td class="text-primary">EFECTOS ADVERSOS</td>
              <td id="tex_adversos"></td>
            </tr>
            <tr>
              <td class="text-primary">CONTRAINDICACIONES</td>
              <td id="tex_contrain"></td>
            </tr>
            <tr>
              <td class="text-primary">RIESGO DE EMBARAZO</td>
              <td id="tex_cat_re"></td>
            </tr>
            <tr>
              <td></td>
              <td colspan="1" id="tex_re"></td>
            </tr>
          </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="tMedicamento"><br>
          <form action="" id="med_generico">
            <div class="col-md-12">
              <div class="form-group col-md-3">
                <label class="control-label" for="inputWarning1">*Nombre generico </label>
                <input type="text" class="form-control" style="margin-top:10px;" name="nombre_generico_m" required>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label" for="inputError1">*Forma farmacéutica </label>
                <input type="text" class="form-control" style="margin-top:10px;" name="desc_m" required>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label" for="inputWarning1">*Presentación </label>
                <input type="text" class="form-control" style="margin-top:10px;" name="present_m" required>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label" for="inputSuccess1">*Via administración</label>
                <input type="text" class="form-control" style="margin-top:10px;" name="via_administracion_m" required>
              </div>

              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="form-group col-md-2">
                    <label class="control-label" for="inputSuccess1">Clave del medicamento</label>
                    <input type="text" class="form-control" style="margin-top:10px;" name="clv_m">
                  </div>
                  <div class="form-group col-md-2">
                    <label class="control-label" for="inputSuccess1">Concentración</label>
                    <input type="text" class="form-control" style="margin-top:10px;" name="cant_m">
                  </div>
                  <div class="form-group col-md-2">
                    <label class="control-label" for="inputError1">Nivel del medicamento</label>
                    <input type="text" class="form-control" style="margin-top:10px;" name="nivel_m">
                  </div>
                  <div class="form-group col-md-2">
                    <label class="control-label" for="inputError1">R.Embarazo </label>
                    <select name="Rembarazo_m" id="" class="form-control" style="margin-top:10px;">
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                      <option value="X">X</option>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label class="control-label" for="inputSuccess1">Grupo médico</label>
                    <input type="text" class="form-control" style="margin-top:10px;" name=grupoMedico_m>
                  </div>

                  <div class="form-group col-md-2">
                    <label class="control-label" for="inputWarning1">Contenido neto</label>
                    <input type="text" class="form-control" style="margin-top:10px;" name="contenido_m">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputWarning1">Generalidades</label>
                  <textarea name="generalidades_m" rows="2" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1">Efectos adversos </label>
                  <textarea name="efectos_m" rows="2" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1">Contraindicaciones Precauciones </label>
                  <textarea name="contradicciones_m" rows="2" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1">Interacciones medicas </label>
                  <textarea name="interacciones_m" rows="2" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1">Indicaciones medicas </label>
                  <textarea name="indicaciones_m" rows="2" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="inputError1">Vía de Administración / Dosís</label>
                  <textarea name="via_admin_dosis_m" rows="2" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label" for="inputError1">Presentaciones</label>
                  <textarea name="presentaciones_m" rows="1" class="form-control" cols="100"></textarea>
                </div>
              </div>
              <button class="btn btn-primary" style="margin-left:15px" type="submit" id="btn_save_mg" form="med_generico">
                Guardar medicamento generico
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
    <div class="modal-footer">
      <div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <button type='submit' class="btn btn-success btn-sm" id="guardarM" form="form-medicamento">Guardar</button>
          <button type='button' class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->