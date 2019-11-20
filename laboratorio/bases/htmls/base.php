<form action="" method="post" name="form-registro" id="form-registro" target="_self">
	<input name="idPacienteN" type="hidden" id="idPacienteN"> <input name="aleatorioB" type="hidden" id="aleatorioB">
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="<?php echo $row_usuario['id_u']; ?>">
    <input name="id_areaB" id="id_areaB" type="hidden" value=""> <input name="id_areaBT" type="hidden" value="" id="id_areaBT">
    <input name="unidadMedidaRT" type="hidden" value="" id="unidadMedidaRT">
    <input name="abreviacionUMT" type="hidden" value="" id="abreviacionUMT">
    <input name="precioP" type="hidden" value="" id="precioP"> <input name="id_equipoMu" id="id_equipoMu" type="hidden" value="">
    <input name="idEquipoMuT" type="hidden" value="" id="idEquipoMuT"> <input name="equipoMuT" type="hidden" value="" id="equipoMuT">
    <input name="idUMbaseT" type="hidden" value="" id="idUMbaseT"> <input name="areaBT" type="hidden" value="" id="areaBT">
    <input name="idUsadaConsulta" type="hidden" value="" id="idUsadaConsulta">
    
	<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">CREAR UNA NUEVA BASE</span></strong></h4>
      </div>
      <div class="modal-body">
      
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tGenerales" aria-controls="tGenerales" role="tab" data-toggle="tab">GENERALES</a></li>
        <li role="presentation" id="t_tMuestras" class="hidden"><a href="#tMuestras" aria-controls="tMuestras" role="tab" data-toggle="tab">MUESTRAS</a></li>
        <li role="presentation" id="t_tMetodos" class="hidden"><a href="#tMetodos" aria-controls="tMetodos" role="tab" data-toggle="tab">MÉTODOS</a></li>
        <!--<li role="presentation" id="t_tIndicaciones"><a href="#tIndicaciones" aria-controls="tIndicaciones" role="tab" data-toggle="tab">INDICACIONES</a></li>-->
        <li role="presentation" id="t_tReferencias"><a href="#tReferencias" aria-controls="tReferencias" role="tab" data-toggle="tab">REFERENCIAS</a></li>
        <li role="presentation" id="t_tConsumibles"><a href="#tConsumibles" aria-controls="tConsumibles" role="tab" data-toggle="tab">CONSUMIBLES</a></li>
      </ul>
        
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tGenerales"><br>
        	<div class="panel panel-primary hidden" id="new_equipo">
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UN NUEVO EQUIPO</div>
              <div class="panel-body">
                <p class="text-primary">Para agregar un nuevo equipo, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8">
                        <div class="form-group">
                         <label for="nombre_n_eq">* Modelo</label>
                         <input type="text"class="form-control input-sm campos_neq" id="nombre_n_eq" name="nombre_n_eq" placeholder="Modelo del equipo">
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                        <div class="form-group">
                         <label for="marca_n_eq">* Marca</label>
                         <input type="text" class="form-control input-sm campos_neq" id="marca_n_eq"name="marca_n_eq"placeholder="Marca del equipo" maxlength="">
                        </div>
                    </div>
                </div>
                </div>
                <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            <button type="button" class="btn btn-success btn-sm" id="addEquipo">Guardar Equipo</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelEquipo">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-primary hidden" id="new_unidad_medida">
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UNA NUEVA UNIDAD DE MEDIDA</div>
              <div class="panel-body">
                <p class="text-primary">Para agregar la unidad de medida, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8">
                        <div class="form-group">
                         <label for="nombre_n_um">* Nombre</label>
                         <input type="text"class="form-control input-sm campos_num" id="nombre_n_um" name="nombre_n_um" placeholder="Nombre de la unidad de medida">
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                        <div class="form-group">
                         <label for="abreviacion_n_um">* Abreviación</label>
                         <input type="text" class="form-control input-sm campos_num" id="abreviacion_n_um"name="abreviacion_n_um"placeholder="Abrevicaión de la unidad de medida" maxlength="20">
                        </div>
                    </div>
                </div>
                </div>
                <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            <button type="button" class="btn btn-success btn-sm" id="addUnidad">Guardar Unidad</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelUnidad">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-primary hidden" id="new_area">
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UNA NUEVA ÁREA DEL DEPARTAMENTO DE LABORATORIO</div>
              <div class="panel-body">
                <p class="text-primary">Para agregar el área, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8">
                        <div class="form-group">
                         <label for="nombre_n_a">* Nombre</label>
                         <input type="text"class="form-control input-sm campos_na" id="nombre_n_a" name="nombre_n_a" placeholder="Nombre del área">
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                        <div class="form-group">
                         <label for="clave_n_a">* Clave</label>
                         <input type="text" class="form-control input-sm campos_na" id="clave_n_a"name="clave_n_a"placeholder="Clave del área" maxlength="3">
                        </div>
                    </div>
                </div>
                </div>
                <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            <button type="button" class="btn btn-success btn-sm" id="addArea">Guardar Área</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelArea">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="row">
               <div class="col-sm-7 col-xs-7 col-md-7 col-lg-7">
                <div class="form-group">
                 <label for="nombreP">* NOMBRE DE LA BASE</label>
                 <input type="text" class="form-control input-sm" id="nombreP" name="nombreP" placeholder="Nombre" required onKeyUp="conMayusculas(this);">
                 <div class="help-block with-errors"></div>
                </div>
               </div>
               <div class="col-sm-5 col-xs-5 col-md-5 col-lg-5">
                 <div class="form-group">
                  <label for="areaB">* ÁREA </label> <button type="button" class="btn btn-xs btn-primary" id="bAreaB"><i class="fa fa-plus-circle"></i></button>
                  <select name="areaB" id="areaB" class="form-control input-sm" required></select>
                  <div class="help-block with-errors"></div>
                 </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6">
                <div class="form-group">
                 <label for="id_umBase">* UNIDAD MEDIDA DEL RESULTADO</label> <button type="button" class="btn btn-xs btn-primary" id="bUnidadM"><i class="fa fa-plus-circle"></i></button>
                 <select name="id_umBase" id="id_umBase" class="form-control input-sm" required></select>
                 <div class="help-block with-errors"></div>
                </div>
               </div>
               <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6">
                <div class="form-group">
                 <label for="equipoMu1">EQUIPO CON EL QUE SE REALIZA LA BASE</label> <button type="button" class="btn btn-xs btn-primary" id="bEquipoB"><i class="fa fa-plus-circle"></i></button>
                 <select name="equipoMu1" id="equipoMu1" class="form-control input-sm"></select>
                 <div class="help-block with-errors"></div>
                </div>
               </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tMuestras"><br>
        	<div class="panel panel-primary hidden" id="new_muestra">
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UNA NUEVA MUESTRA</div>
              <div class="panel-body">
              	<div class="panel panel-primary hidden" id="new_condicion">
                  <!-- Default panel contents -->
                  <div class="panel-heading">AGREGAR UNA NUEVA CONDICIÓN PARA LA MUESTRA</div>
                  <div class="panel-body">
                    <p class="text-primary">Para agregar una condición para la muestra, indique los campos:</p>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <label for="nombre_n_cm">* Nombre</label>
                             <input type="text"class="form-control input-sm campos_ncm" id="nombre_n_cm" name="nombre_n_cm" placeholder="Nombre de la condición para la muestra">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div id="" class="alert alert-danger alerta_altas1">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                                <button type="button" class="btn btn-success btn-sm" id="addCondicion">Guardar Condición</button>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                <button type="button" class="btn btn-warning btn-sm" id="cancelCondicion">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-primary">Para agregar una nueva muestra, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8">
                        <div class="form-group">
                         <label for="nombre_n_mue">* Nombre</label>
                         <input type="text"class="form-control input-sm campos_nmue" id="nombre_n_mue" name="nombre_n_mue" placeholder="Nombre de la muestra">
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                        <div class="form-group">
                         <label for="condicion_n_mue">
                         	* Condición
                            <button type="button" class="btn btn-primary btn-xs" id="btn-addCondicion">
                            	<i class="fa fa-plus-circle"></i> Nueva condición
                            </button>
                         </label>
                         <select id="condicion_n_mue" name="condicion_n_mue" class="form-control input-sm campos_nmue"></select>
                        </div>
                    </div>
                </div>
                </div>
                <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            <button type="button" class="btn btn-success btn-sm" id="addMuestra">Guardar Muestra</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelMuestra">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
        	<div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Muestras para la base</div>
              <div class="panel-body">
                <div class="row">
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <label for="s_add_base">MUESTRA CON LA QUE SE REALIZA LA BASE</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_muestra"><i class="fa fa-check"></i> Aceptar</button> <button type="button" class="btn btn-xs btn-primary" id="btn-new_muestra"><i class="fa fa-plus-circle"></i> Nueva muestra</button>
                   </div>
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <select name="s_add_muestra" id="s_add_muestra" class="form-control input-sm" style="width:100%;"></select>
                   </div>
                </div>
                <div id="alerta_muestra" class="alert alert-danger">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de seleccionar una muestra.
                </div>
              </div>
              <!-- Table -->
              <table class="table-condensed table-bordered" id="dataTableMuestras">
                <thead id="cabecera_tBusquedaMuestras">
                  <tr class="bg-primary">
                    <th id="clickmeMu" align="center" width="20px">#</th>
                    <th align="center">MUESTRAS</th>
                    <th align="center">CONDICIÓN DE LA MUESTRA</th>
                    <th align="center">ELIMINAR</th>
                  </tr>
                </thead>
                <tbody style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos...</td> </tr> </tbody>
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tMetodos"><br>
        	<div class="panel panel-primary hidden" id="new_metodo">
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UN NUEVO MÉTODO PARA LAS BASES</div>
              <div class="panel-body">
                <p class="text-primary">Para agregar un método, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                         <label for="nombre_n_met">* Nombre</label>
                         <input type="text"class="form-control input-sm campos_met" id="nombre_n_met" name="nombre_n_met" placeholder="Nombre del método">
                        </div>
                    </div>
                </div>
                </div>
                <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            <button type="button" class="btn btn-success btn-sm" id="addMetodo">Guardar Método</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelMetodo">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
        	<div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Métodos para la base</div>
              <div class="panel-body">
                <div class="row">
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <label for="s_add_base">MÉTODO CON EL QUE SE REALIZA LA BASE</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_metodo"><i class="fa fa-check"></i> Aceptar</button> <button type="button" class="btn btn-xs btn-primary" id="btn-new_metodo"><i class="fa fa-plus-circle"></i> Nuevo método</button>
                   </div>
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <select name="s_add_metodo" id="s_add_metodo" class="form-control input-sm"></select>
                   </div>
                </div>
                <div id="alerta_metodo" class="alert alert-danger">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de seleccionar un método.
                </div>
              </div>
              <!-- Table -->
              <table class="table-condensed table-bordered" id="dataTableMetodos">
                <thead id="cabecera_tBusquedaMetodos">
                  <tr class="bg-primary">
                    <th id="clickmeMet" align="center" width="20px">#</th>
                    <th align="center">MÉTODOS</th>
                    <th align="center">ELIMINAR</th>
                  </tr>
                </thead>
                <tbody> <tr> <td class="dataTables_empty">Cargando datos...</td> </tr> </tbody>
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tIndicaciones"><br>
        	<div class="panel panel-primary hidden" id="new_indicacion">
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UNA NUEVA INDICACIÓN PARA LAS BASES</div>
              <div class="panel-body">
                <p class="text-primary">Para agregar una indicación, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                         <label for="nombre_n_ind">* Descripción</label>
                         <textarea class="form-control input-sm campos_ind" id="nombre_n_ind" name="nombre_n_ind" cols="" rows="3" placeholder="Descripción de la indicación" style="resize:none;"></textarea>
                        </div>
                    </div>
                </div>
                </div>
                <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            <button type="button" class="btn btn-success btn-sm" id="addIndicacion">Guardar Indicación</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelIndicacion">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
        	<div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Indicaciones para la base</div>
              <div class="panel-body">
                <div class="row">
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <label for="s_add_base">INDICACIONES PARA LA BASE</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_indicacion"><i class="fa fa-check"></i> Aceptar</button> <button type="button" class="btn btn-xs btn-primary" id="btn-new_indicacion"><i class="fa fa-plus-circle"></i> Nueva indicación</button>
                   </div>
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <select name="s_add_indicacion" id="s_add_indicacion" class="form-control input-sm"></select>
                   </div>
                </div>
                <div id="alerta_indicacion" class="alert alert-danger">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de seleccionar una indicación.
                </div>
              </div>
              <!-- Table -->
              <table class="table-condensed table-bordered" id="dataTableIndicaciones">
                <thead id="cabecera_tBusquedaIndicaciones">
                  <tr class="bg-primary">
                    <th id="clickmeIn" align="center" width="20px">#</th>
                    <th align="center">INDICACIÓN</th>
                    <th align="center">ELIMINAR</th>
                  </tr>
                </thead>
                <tbody> <tr> <td class="dataTables_empty">Cargando datos...</td> </tr> </tbody>
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tReferencias"><br>
        	<div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Valores de referencia para la base</div>
              <div class="panel-body">
                <div class="row">
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <label for="s_add_base">VALORES DE REFERENCIA PARA LA BASE</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_vr"><i class="fa fa-check"></i> Aceptar</button>
                   </div>
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <select name="s_add_vr" id="s_add_vr" class="form-control input-sm"></select>
                   </div>
                </div>
                <div id="alerta_vr" class="alert alert-danger">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de seleccionar un valor de referencia.
                </div>
              </div>
              <!-- Table -->
              <table class="table-condensed table-bordered" id="dataTableReferencias">
                <thead id="cabecera_tBusquedaReferencias">
                      <tr class="bg-primary">
                        <th id="clickmeRe" align="center" width="20px">#</th>
                        <th align="center" nowrap>NOMBRE</th>
                        <th align="center">VALOR DE REFERENCIA</th>
                        <th align="center">PARA</th>
                        <th align="center" nowrap>EDADES</th>
                        <th align="center">ELIMINAR</th>
                      </tr>
                    </thead>
                <tbody> <tr> <td class="dataTables_empty">Cargando datos...</td> </tr> </tbody>
              </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tConsumibles"><br>
        	<div class="panel panel-primary hidden" id="new_consumible">
              <!-- Default panel contents -->
              <div class="panel-heading">AGREGAR UN NUEVO CONSUMIBLE PARA LAS BASES</div>
              <div class="panel-body">
              	<div class="panel panel-info hidden" id="new_tipo">
                  <!-- Default panel contents -->
                  <div class="panel-heading">AGREGAR UN NUEVO TIPO DE CONSUMIBLE PARA LAS BASES</div>
                  <div class="panel-body">
                    <p class="text-primary">Para agregar un tipo de consumible, indique los campos:</p>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <label for="nombre_n_tcon">* Nombre</label>
                             <input type="text"class="form-control input-sm campos_tcon" id="nombre_n_tcon" name="nombre_n_tcon" placeholder="Nombre del tipo de consumible">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div id="" class="alert alert-danger alerta_altas1">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                                <button type="button" class="btn btn-success btn-sm" id="addTipo">Guardar Tipo</button>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                <button type="button" class="btn btn-warning btn-sm" id="cancelTipo">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-info hidden" id="new_unidadC">
                  <!-- Default panel contents -->
                  <div class="panel-heading">AGREGAR UNA NUEVA UNIDAD DE MEDIDA</div>
                  <div class="panel-body">
                    <p class="text-primary">Para agregar una unidad de medida, indique los campos:</p>
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8">
                            <div class="form-group">
                             <label for="nombre_n_umedc">* Nombre</label>
                             <input type="text"class="form-control input-sm campos_umedc" id="nombre_n_umedc" name="nombre_n_umedc" placeholder="Nombre de la unidad de medida">
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                            <div class="form-group">
                             <label for="abreviacion_n_umc">* Abreviación</label>
                             <input type="text" class="form-control input-sm campos_umedc" id="abreviacion_n_umc"name="abreviacion_n_umc"placeholder="Abrevicaión de la unidad de medida" maxlength="20">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div id="" class="alert alert-danger alerta_altas1">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                                <button type="button" class="btn btn-success btn-sm" id="addUmedC">Guardar Unidad</button>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                <button type="button" class="btn btn-warning btn-sm" id="cancelUmedC">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-info hidden" id="new_presentacion">
                  <!-- Default panel contents -->
                  <div class="panel-heading">AGREGAR UNA NUEVA PRESENTACIÓN</div>
                  <div class="panel-body">
                    <p class="text-primary">Para agregar una presentación, indique los campos:</p>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                            <div class="form-group">
                             <label for="nombre_n_presentacion">* Nombre</label>
                             <input type="text"class="form-control input-sm campos_upresentacion" id="nombre_n_presentacion" name="nombre_n_presentacion" placeholder="Nombre de la presentación">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="alert alert-danger alerta_altas1">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-7 col-xs-7 col-md-7 col-lg-7" align="right"></div>
                            <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3" align="right">
                                <button type="button" class="btn btn-success btn-sm" id="addPresentacion">Guardar Presentación</button>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                <button type="button" class="btn btn-warning btn-sm" id="cancelPresentacion">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <p class="text-primary">Para agregar un consumible, indique los campos:</p>
                <div class="row">
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                         <label for="nombre_n_cons">* Nombre</label>
                         <input type="text"class="form-control input-sm campos_cons" id="nombre_n_cons" name="nombre_n_cons" placeholder="Nombre del consumible">
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                         <label for="descripcion_n_cons">Descripción</label>
                         <textarea class="form-control input-sm campos_cons" id="descripcion_n_cons" name="descripcion_n_cons" cols="" rows="3" placeholder="Descripción del consumible" style="resize:none;"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                    	<div class="form-group">
                        	<label for="tipo_n_cons">
                            	* Tipo
                                <button type="button" class="btn btn-xs btn-primary" id="btn-new_tipo_con"><i class="fa fa-plus-circle"></i> Nuevo tipo</button>
                            </label>
                            <select name="tipo_n_cons" id="tipo_n_cons" class="form-control input-sm campos_cons"></select>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                    	<div class="form-group">
                        	<label for="unidad_n_cons">
                            	* Unidad
                                <button type="button" class="btn btn-xs btn-primary" id="btn-new_unidad_con"><i class="fa fa-plus-circle"></i> Nueva unidad</button>
                            </label>
                            <select name="unidad_n_cons" id="unidad_n_cons" class="form-control input-sm campos_cons"></select>
                        </div>
                   </div>
                   <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                    	<div class="form-group">
                        	<label for="presentacion_n_cons">
                            	* Presentación
                                <button type="button" class="btn btn-xs btn-primary" id="btn-new_presentacion_con"><i class="fa fa-plus-circle"></i> Nueva presentación</button>
                            </label>
                            <select name="presentacion_n_cons" id="presentacion_n_cons" class="form-control input-sm campos_cons"></select>
                        </div>
                   </div>
                </div>
                </div>
                <div id="" class="alert alert-danger alerta_altas">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            <button type="button" class="btn btn-success btn-sm" id="addConsumible">Guardar Consumible</button>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                            <button type="button" class="btn btn-warning btn-sm" id="cancelConsumible">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
        	<div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Consumibles para la base</div>
              <div class="panel-body">
                <div class="row">
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <label for="s_add_consumible">CONSUMIBLES PARA LA BASE</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_consumible"><i class="fa fa-check"></i> Aceptar</button> <button type="button" class="btn btn-xs btn-primary" id="btn-new_consumible"><i class="fa fa-plus-circle"></i> Nuevo consumible</button>
                   </div>
                   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                     <select name="s_add_consumible" id="s_add_consumible" class="form-control input-sm"></select>
                   </div>
                </div>
                <div id="alerta_consumible" class="alert alert-danger">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de seleccionar un consumible.
                </div>
              </div>
              <!-- Table -->
              <table class="table-condensed table-bordered" id="dataTableConsumibles">
                <thead id="cabecera_tBusquedaConsumibles">
                  <tr class="bg-primary">
                    <th id="clickmeCo" align="center" width="20px">#</th>
                    <th align="center">CONSUMIBLE</th>
                    <th align="center">TIPO</th>
                    <th align="center">UNIDAD</th>
                    <th align="center">PRESENTACIÓN</th>
                    <th align="center">CANTIDAD</th>
                    <th align="center" nowrap>PRECIO</th>
                    <th align="center">ELIMINAR</th>
                  </tr>
                </thead>
                <tbody> <tr> <td class="dataTables_empty">Cargando datos...</td> </tr> </tbody>
              </table>
            </div>
        </div>
    </div>

	</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_new"> Guardar</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel_new"> Cancelar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>