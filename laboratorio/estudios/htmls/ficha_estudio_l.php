<form action="" method="post" name="formEstudio" id="formEstudio" target="_self">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span id="titulo_modal">NUEVO ESTUDIO DE LABORATORIO</span></strong></h4>
      </div>
      <div class="modal-body">
 		<input name="idEstudioE" type="hidden" id="idEstudioE">
		<!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active no_base" id="tabi_1">
                <a href="#tEstudio" aria-controls="tEstudio" role="tab" data-toggle="tab" id="tab_estudio">ESTUDIO</a>
            </li>
			<li role="presentation" class="no_base"><a href="#tTabulador" aria-controls="tTabulador" role="tab" data-toggle="tab" id="tab_tabulador">TABULADOR</a></li>
            <li role="presentation" id="tabi_2" class="no_base">
                <a href="#tFormato" aria-controls="tFormato" role="tab" data-toggle="tab" id="tab_formato">BASES</a>
            </li>
			<li role="presentation" id="t_tMuestras" class="no_base"><a href="#tMuestras" aria-controls="tMuestras" role="tab" data-toggle="tab">MUESTRAS</a></li>
        	<li role="presentation" id="t_tMetodos" class="no_base"><a href="#tMetodos" aria-controls="tMetodos" role="tab" data-toggle="tab">MÉTODOS</a></li>
            <li role="presentation" id="tabi_3" class="si_base hidden">
                <a href="#tBases" aria-controls="tFormato" role="tab" data-toggle="tab" id="tab_bases">BASES DEL ESTUDIO</a>
            </li>
			<li role="presentation" id="t_tIndicaciones" class="no_base"><a href="#tIndicaciones" aria-controls="tIndicaciones" role="tab" data-toggle="tab">INDICACIONES</a></li>
			<li role="presentation" class="no_base"><a href="#tFormato1" aria-controls="tFormato1" role="tab" data-toggle="tab" id="tab_formato1">FORMATO</a></li>
			<li role="presentation" class="no_base"><a href="#tProductividad" aria-controls="tProductividad" role="tab" data-toggle="tab" id="tab_productividad">PRODUCTIVIDAD</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tEstudio"><br>
            	<input name="idUsuarioE" id="idUsuarioE" type="hidden" value="">
                <div class="col-sm-12 col-xs-12 col-md-12">
                    <div class="form-group">
                     <label for="nombreE">* NOMBRE DEL ESTUDIO</label>
                     <input type="text" class="form-control input-sm" id="nombreE" name="nombreE" required>
                     </div>
                </div>
                <div class="col-sm-6 col-xs-6 col-md-6">
                    <div class="form-group">
                     <label for="precioE">* PRECIO NORMAL($)</label>
                     <input type="text" class="form-control input-sm" id="precioE" name="precioE" required onKeyUp="numeros_decimales(this.value, this.name);">
                     </div>
                </div>
                <div class="col-sm-6 col-xs-6 col-md-6">
                    <div class="form-group">
                     <label for="precioUrgenciaE">* PRECIO URGENCIA($)</label>
                     <input type="text" class="form-control input-sm" id="precioUrgenciaE" name="precioUrgenciaE" required onKeyUp="numeros_decimales(this.value, this.name);">
                     </div>
                </div>
				<div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioME">* PRECIO DE MEMBRESÍA($)</label>
                     <input type="text" class="form-control input-sm" id="precioME" name="precioME" required onKeyUp="numeros_decimales(this.value, this.name);">
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioUrgenciaME">* PRECIO MEMBRESÍA URGENCIA($)</label>
                     <input type="text" class="form-control input-sm" id="precioUrgenciaME" name="precioUrgenciaME" required onKeyUp="numeros_decimales(this.value, this.name);">
                     </div>
                </div>
				<div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioHO">* PRECIO DE HOSPITAL($)</label>
                     <input type="text" class="form-control input-sm" id="precioHO" name="precioHO" required onKeyUp="numeros_decimales(this.value, this.name);">
                     </div>
                </div>
                <div class="col-sm-3 col-xs-3 col-md-3">
                    <div class="form-group">
                     <label for="areaE">* ÁREA</label>
                     <select name="areaE" id="areaE" class="form-control input-sm" required></select>
                     </div>
                </div>
                <div class="col-sm-3 col-xs-3 col-md-3">
                    <div class="form-group">
                     <label for="areaE">* Días de entrega</label>
                     <select name="dEntregaE" id="dEntregaE" class="form-control input-sm" required>
                         <option value="">-SELECCIONAR-</option>
                         <option value="0">MISMO DÍA</option> <option value="1">1</option>
                         <option value="2">2</option> <option value="3">3</option>
                         <option value="4">4</option> <option value="5">5</option>
                         <option value="6">6</option> <option value="7">7</option>
                         <option value="8">8</option> <option value="9">9</option>
                         <option value="10">10</option> <option value="11">11</option>
                         <option value="12">12</option> <option value="13">13</option>
                         <option value="14">14</option> <option value="15">15</option>
                         <option value="16">16</option> <option value="17">17</option>
                         <option value="18">18</option> <option value="19">19</option>
                         <option value="20">20</option> <option value="21">21</option>
                         <option value="22">22</option> <option value="23">23</option>
                         <option value="24">24</option> <option value="25">25</option>
                         <option value="26">26</option> <option value="27">27</option> <option value="28">28</option>
                     </select>
                     </div>
                </div>
                <div class="col-sm-6 col-xs-6 col-md-6 hidden">
                    <div class="form-group">
                     <label for="miSucursalNS">* SUCURSAL</label>
                     <select name='miSucursalNS' class="form-control input-sm" id='miSucursalNS' required></select>
                     </div>
                </div>
            </div>
			
			<div role="tabpanel" class="tab-pane" id="tTabulador"><br>
            	<div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioEM">* TABULADOR ($)</label>
                     <input type="text" class="form-control input-sm" id="precioEM" name="precioEM" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioUrgenciaM">* TABULADOR URGENCIA($)</label>
                     <input type="text" class="form-control input-sm" id="precioUrgenciaM" name="precioUrgenciaM" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div>
                <!--div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioES">* TABULADOR SUCURSAL($)</label>
                     <input type="text" class="form-control input-sm" id="precioES" name="precioES" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioUrgenciaS">* TABULADOR SUCURSAL URGENCIA($)</label>
                     <input type="text" class="form-control input-sm" id="precioUrgenciaS" name="precioUrgenciaS" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div-->
            </div>
			
            <div role="tabpanel" class="tab-pane" id="tFormato"><br>
            	<input name="aleatorioB" type="hidden" id="aleatorioB">
                <table width="100%" id="dataTableBBE" class="table-condensed table-bordered">
                <thead id="cabecera_tBusquedaPrincipal1">
                  <tr id="mymy" class="bg-primary">
                    <th id="clickmeBBE" align="center" width="20px">#</th>
                    <th> BASES <button type="button" class="btn btn-default btn-xs" id="bBaseE"><i class="fa fa-refresh" aria-hidden="true"></i></button></th>
                    <th>AREA</th>
                    <th>UNIDAD</th>
                  </tr>
                </thead>
                	<tbody style="color:black"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
              	</table>
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
				  <div class="panel-heading">Muestras para el estudio</div>
				  <div class="panel-body">
					<div class="row">
					   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
						 <label for="s_add_base">MUESTRA CON LA QUE SE REALIZA EL ESTUDIO</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_muestra"><i class="fa fa-check"></i> Aceptar</button> <button type="button" class="btn btn-xs btn-primary" id="btn-new_muestra"><i class="fa fa-plus-circle"></i> Nueva muestra</button>
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
				  <div class="panel-heading">AGREGAR UN NUEVO MÉTODO PARA LOS ESTUDIOS</div>
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
				  <div class="panel-heading">Métodos para el estudio</div>
				  <div class="panel-body">
					<div class="row">
					   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
						 <label for="s_add_base">MÉTODO CON EL QUE SE REALIZA EL ESTUDIO</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_metodo"><i class="fa fa-check"></i> Aceptar</button> <button type="button" class="btn btn-xs btn-primary" id="btn-new_metodo"><i class="fa fa-plus-circle"></i> Nuevo método</button>
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
            <div role="tabpanel" class="tab-pane" id="tBases"><br>
            	<table width="100%" class="table-condensed">
                  <tr height="50%">
                    <td>
                    <table width="100%" id="dataTableBbasesE" class="table-condensed table-bordered table-hover">
                        <thead id="my_head">
                          <tr class="bg-primary">
                            <th id="clickmeBasesE" align="center" width="20px">ID</th>
                            <th align="center">
                                BASE <!--<button class="botonBase" id="editMetodoB">EDITAR LOS MÉTODOS DE LAS BASES</button> -->
                            </th>
                            <th align="center">ÁREA</th>
                            <th align="center">UNIDAD</th>
                          </tr>
                        </thead>
                        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                        <!--<tfoot class="pieTablaBbaseE" id="mi_pie_tabla" align="center">
                            <tr>
                                <th></th>
                                <th>
                                <input type="text" name="ted2" id="ted2" class="form-control input-sm" placeholder="Nombre de la base">
                                </th>
                                <th>
                                <input type="text" name="ted3" id="ted3" class="form-control input-sm" placeholder="Área">
                                </th>
                                <th>
                                <input type="text" name="ted4" id="ted4" class="form-control input-sm" placeholder="Unidad">
                                </th>
                            </tr>
                        </tfoot> -->
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" id="dataTableBasesSE" class="table-condensed table-bordered table-hover" style="top:10px;">
                        <thead id="my_head">
                          <tr class="bg-primary">
                            <th id="clickmeBBasB" align="center" width="20px">#</th>
                            <th align="center">BASE</th>
                            <th align="center">ÁREA</th>
                            <th align="center">UNIDAD</th>
                            <th align="center" width="100px">ELIMINAR</th>
                          </tr>
                        </thead>
                        <tbody align="left" style="color:black;"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                      </table>
                    <div id="basesSeleccionadosE">
                        <table width="100%" border="0" cellspacing="0" cellpadding="4">
                          <tr>
                            <td width="100%" align="left"><span style="color:black; text-decoration:underline;">Bases seleccionadas.</span></td>
                          </tr>
                        </table>
                    </div>
                    </td>
                  </tr>
                </table>
            </div>
			<div role="tabpanel" class="tab-pane" id="tIndicaciones"><br>
				<div class="panel panel-primary hidden" id="new_indicacion">
				  <!-- Default panel contents -->
				  <div class="panel-heading">AGREGAR UNA NUEVA INDICACIÓN PARA LOS ESTUDIOS</div>
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
				  <div class="panel-heading">Indicaciones para el estudio</div>
				  <div class="panel-body">
					<div class="row">
					   <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
						 <label for="s_add_base">INDICACIONES PARA EL ESTUDIO</label> <button type="button" class="btn btn-xs btn-success" id="btn-add_indicacion"><i class="fa fa-check"></i> Aceptar</button> <button type="button" class="btn btn-xs btn-primary" id="btn-new_indicacion"><i class="fa fa-plus-circle"></i> Nueva indicación</button>
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
			<div role="tabpanel" class="tab-pane" id="tFormato1"><br>
            	<table width="100%" height="100%" border="1" class="table-condensed table-bordered">
                  <tr align="left" style="display:;"> <td height="1px" nowrap>
                    <table width="100%" border="0" cellspacing="1" class="table-condensed">
                      <tr>
                        <td><select name="inserta_algo" id="inserta_algo" onChange="insertAtCaret(this.value);return false;" class="form-control input-sm insers">
                        </select></td>
                        <td align="right" width="1%" nowrap class="text-primary">FORMATO DEL ESTUDIO:</td>
                      </tr>
                    </table>
                  </td> </tr>
                  <tr id="contieneET1" align="left"><td colspan="4">
                    <textarea style="height:90%; resize:none; vertical-align:top;" name="input" id="input" type="text" value="" class="jqte-test"></textarea>
                    <input name="miDiagnostico1" id="miDiagnostico1" type="hidden"> <input name="id_rmed" id="id_rmed" type="hidden">
                    <input name="aleatorio_rmed" id="aleatorio_rmed" type="hidden">
                </td></tr>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tProductividad"><br>
            	<input name="aleatorioB" type="hidden" id="aleatorioB">
              	<div class="row">
              		<div class="col-md-4">
              			<label class="control-label">Costo de producción extra</label>
              			<input type="number" step="0.01" class="form-control" name="costoproduccion" value="0">
              		</div>
              		<div class="col-md-4">
              			<label class="control-label">Motivo del costo extra</label>
              			<input type="text" class="form-control" name="motivocostoproduccion">
              		</div>
              		<div class="col-md-4">
              			<label class="control-label">Costo de producción total</label>
              			<input type="number" step="0.01" class="form-control" name="costototalprod" value="0" disabled>
              		</div>
              	</div>
              	<hr>
                <table width="100%" id="dataTableProd" class="table-condensed table-bordered">
	                <thead id="">
	                  <tr id="" class="bg-primary">
	                    <th id="" align="center" width="20px">#</th>
	                    <th> BASES </th>
	                    <th>AREA</th>
	                    <th>UNIDAD</th>
	                    <th>COSTO</th>
	                  </tr>
	                </thead>
                	<tbody style="color:black"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
              	</table>
            </div>
        </div>
                  
	</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success no_base" id="btn_save1">Guardar</button>
            <button type="button" class="btn btn-warning no_base" data-dismiss="modal" id="btn_cancel1">Cancelar</button>
            <button type="button" class="btn btn-default si_base hidden" id="btn_salir_bases">Aceptar</button>
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
