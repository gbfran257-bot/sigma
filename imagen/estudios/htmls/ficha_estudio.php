<form action="" method="post" name="formEstudio" id="formEstudio" target="_self">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" height="1%">
				<tr>
					<td align="left" width="95%"> <strong><span id="titulo_modal">NUEVO ESTUDIO DE IMAGEN</span></strong> </td>
					<td nowrap align="right">
						<button type="submit" form="formEstudio" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success" id="btn_save1">Guardar</button>
            			<button type="button" class="btn btn-warning" data-dismiss="modal" id="btn_cancel1">Cancelar</button>
					</td>
				</tr>
			</table>
		</h4>
      </div>
      <div class="modal-body">
 		<input name="idEstudioE" type="hidden" id="idEstudioE">
		<!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tEstudio" aria-controls="tEstudio" role="tab" data-toggle="tab" id="tab_estudio">ESTUDIO</a></li>
            <li role="presentation"><a href="#tTabulador" aria-controls="tTabulador" role="tab" data-toggle="tab" id="tab_tabulador">TABULADOR</a></li>
			<li role="presentation"><a href="#tFormato" aria-controls="tFormato" role="tab" data-toggle="tab" id="tab_formato">FORMATO</a></li>
      <li role="presentation" class="no_base"><a href="#tProductividad" aria-controls="tProductividad" role="tab" data-toggle="tab" id="tab_productividad">PRODUCTIVIDAD</a></li>
          <li role="presentation" class="no_base">
            <a href="#tIndicaciones" aria-controls="tIndicaciones" role="tab" data-toggle="tab" id="tab_indicaciones">INDICACIONES</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tEstudio"><br>
            	<input name="idUsuarioE" id="idUsuarioE" type="hidden" value="">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="nombreE">* NOMBRE DEL ESTUDIO</label>
                     <input type="text" class="form-control input-sm" id="nombreE" name="nombreE" required>
                     </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                     <label for="linea_img">* LÍNEA</label>
                     <select name="linea_img" id="linea_img" class="form-control input-sm" required>
                     </select>
                     </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                     <label for="dicom_i">* DICOM</label>
                     <select name="dicom_i" id="dicom_i" class="form-control input-sm" required>
                          <option value="1" selected>SI</option> <option value="0">NO</option>
                     </select>
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioE">* PRECIO PÚBLICO($)</label>
                     <input type="text" class="form-control input-sm" id="precioE" name="precioE" required onKeyUp="numeros_decimales(this.value, this.name);">
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioUrgenciaE">* PRECIO PÚBLICO URGENCIA($)</label>
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
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="areaE">* ÁREA</label>
                     <select name="areaE" id="areaE" class="form-control input-sm" required></select>
                     </div>
                </div>
                <div class="col-sm-12 col-md-12 hidden">
                    <div class="form-group">
                     <label for="miSucursalNS">* SUCURSAL</label>
                     <select name='miSucursalNS' class="form-control input-sm" id='miSucursalNS' required></select>
                     </div>
                </div>
            </div>
			<div role="tabpanel" class="tab-pane" id="tTabulador"><br>
            	<div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioEM">* TABULADOR MAQUILA($)</label>
                     <input type="text" class="form-control input-sm" id="precioEM" name="precioEM" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioUrgenciaM">* TABULADOR MAQUILA URGENCIA($)</label>
                     <input type="text" class="form-control input-sm" id="precioUrgenciaM" name="precioUrgenciaM" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioES">* TABULADOR CONVENIO($)</label>
                     <input type="text" class="form-control input-sm" id="precioES" name="precioES" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <label for="precioUrgenciaS">* TABULADOR CONVENIO URGENCIA($)</label>
                     <input type="text" class="form-control input-sm" id="precioUrgenciaS" name="precioUrgenciaS" required onKeyUp="numeros_decimales(this.value, this.name);" required>
                     </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tFormato"><br>
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
              		<div class="col-md-6">
              			<label class="control-label">Costo de producción </label>
              			<input type="number" step="0.01" class="form-control" name="costoproduccion" id="costoproduccion" value="0">
              		</div>
              		<div class="col-md-6">
              			<label class="control-label">Motivo del costo </label>
              			<input type="text" class="form-control" name="motivocostoproduccion" id="motivocostoproduccion">
              		</div>
              	</div>
              	<hr>
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
                        <label for="s_add_base">INDICACIONES PARA EL ESTUDIO</label>
                        <button type="button" class="btn btn-xs btn-success" id="btn-add_indicacion">
                         <i class="fa fa-check"></i> Aceptar
                        </button> 
                        <button type="button" class="btn btn-xs btn-primary" id="btn-new_indicacion">
                          <i class="fa fa-plus-circle"></i> Nueva indicación
                        </button>
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
                <tbody> 
                  <tr> 
                    <td class="dataTables_empty">Cargando datos...</td> 
                  </tr> 
                </tbody>
              </table>
            </div>
          </div>
        </div>       
	</div>
      <div class="modal-footer">
      	<div class="form-group">
        <div class="col-sm-offset-0 col-sm-12">
          <div class="checkbox">
            
          </div>
        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form> 
