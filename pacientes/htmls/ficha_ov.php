<form id="form-2" name="form-2" data-toggle="validator" role="form">
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td><strong><span id="titulo_modal">NUEVA ORDEN DE VENTA</span></strong></td>
					<td align="right">
						<button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success btn-sm" id="btn_save1">Finalizar</button>
            			<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal" id="btn_cancel1">Cancelar</button>
					</td>
				</tr>
			</table>
		</h4>
      </div>
      <div class="modal-body">
		<div id="alerta1" class="alert alert-warning">
        	<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de revisar el formulario, es necesario poner el pago.
        </div>
		  
        <input name="id_usr_reg" type="hidden" value="" id="id_usr_reg">
        <input name="id_usr_update" type="hidden" value="x" id="id_usr_update">
        <input name="id_paciente_ov" type="hidden" value="x" id="id_paciente_ov">
        <input name="id_sucu" type="hidden" value="x" id="id_sucu">
        <input name="mi_id_convenio" type="hidden" value="0" id="mi_id_convenio">
        <input name="mi_id_convenioI" type="hidden" value="0" id="mi_id_convenioI">
        <input name="mi_id_convenioL" type="hidden" value="0" id="mi_id_convenioL">
        <input name="mi_id_convenioS" type="hidden" value="0" id="mi_id_convenioS">
        <input name="mi_id_convenioP" type="hidden" value="0" id="mi_id_convenioP">
        <input name="id_consulta_to" type="hidden" value="" id="id_consulta_to" required>
        
        <input name="aleatorio_ov" type="hidden" value="" id="aleatorio_ov" required>
        <input name="iva_ov_h" type="hidden" value="0" id="iva_ov_h">
        <input name="total_ov_h" type="hidden" value="0" id="total_ov_h">
        <input name="hay_iva_ov" type="hidden" value="0" id="hay_iva_ov">
                
        <div class="row">
			<div class="col-sm-12 col-xs-12"><select id="sucursal_fi_p" name="sucursal_fi_p" class="form-control" required> </select></div><br><br>
            <div class="col-sm-12 col-xs-12">
            	<!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tConsultas" aria-controls="tConsultas" role="tab" data-toggle="tab" id="t_con">CONSULTAS</a></li>
					<li role="presentation" class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							ESTUDIOS <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li role="presentation"><a href="#tImagen" aria-controls="tImagen" role="tab" data-toggle="tab" id="tab_imgen">IMAGEN</a></li>
                    		<li role="presentation"><a href="#tLab" aria-controls="tLab" role="tab" data-toggle="tab">LABORATORIO</a></li>
						</ul>
					</li>
					
                    <li role="presentation"><a href="#tServicios" aria-controls="tServicios" role="tab" data-toggle="tab">SERVICIOS</a></li>
                    <li role="presentation"><a href="#tFarmacia" aria-controls="tFarmacia" role="tab" data-toggle="tab" id="t_farm">FARMACIA / INSUMOS</a></li>
					<li role="presentation"> <a href="#tResumen" aria-controls="tResumen" role="tab" data-toggle="tab">RESUMEN</a> </li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="tResumen"><br>
                        <div class="row">
						  <div class="" id="" style="font-size: 1em;">
							<div class="col-sm-12 col-xs-12" align="left">
								<select id="forma_pago_ov" name="forma_pago_ov" class="form-control input-sm" required>
								  <!-- <option value="">-SELECCIONE UNA FORMA DE PAGO-</option>
								  <option value="1" selected>FORMA PAGO: EFECTIVO</option>
								  <option value="2">FORMA PAGO: TARJETA CRÉDITO</option>
                  <option value="2">FORMA PAGO: TARJETA DE DÉBITO</option>
								  <option value="3">FORMA PAGO: TRANSFERENCIA ELECTRÓNICA</option>
								  <option value="4">FORMA PAGO: CHEQUE</option> -->
								</select>
							</div>
							<div class="col-sm-12 col-xs-12" align="left">
								<div class="checkbox"> <label> <input type="checkbox" id="cb_facturada_ov" name="cb_facturada_ov"> Facturada </label> </div>
							</div>
							  
							<div class="col-sm-6 col-xs-6 text-info" align="left">CONSULTA </div>
							<div class="col-sm-6 col-xs-6 text-info" align="right" style="float:right;"> <span class="total_consulta">$0.00</span> </div>
							<div class="col-sm-12 col-xs-12 col-md-12" align="left" id="aqui_consulta"></div>
							<div class="col-sm-6 col-xs-6 text-info" align="left">IMAGEN </div>
							<div class="col-sm-6 col-xs-6 text-info" align="right" style="float:right;"> <span class="total_imagen">$0.00</span> </div>
							<div class="col-sm-12 col-xs-12 col-md-12" align="left" id="aqui_imagen"></div>
							<div class="col-sm-6 col-xs-6 text-info" align="left">LABORATORIO </div>
							<div class="col-sm-6 col-xs-6 text-info" align="right" style="float:right;"> <span class="total_laboratorio">$0.00</span> </div>
							<div class="col-sm-12 col-xs-12 col-md-12" align="left" id="aqui_laboratorio"></div>
							<div class="col-sm-6 col-xs-6 text-info" align="left">SERVICIOS </div>
							<div class="col-sm-6 col-xs-6 text-info" align="right" style="float:right;"> <span class="total_servicios">$0.00</span> </div>
							<div class="col-sm-12 col-xs-12 col-md-12" align="left" id="aqui_servicios"></div>
							<div class="col-sm-6 col-xs-6 text-info" align="left">PRODUCTOS </div>
							<div class="col-sm-6 col-xs-6 text-info" align="right" style="float:right;"> <span class="total_productos">$0.00</span> </div>
							<div class="col-sm-12 col-xs-12 col-md-12" align="left" id="aqui_productos"></div>
							<div class="col-sm-6 col-xs-6 text-success" align="left">SUBTOTAL </div>
							<div class="col-sm-6 col-xs-6 text-success" align="right" style="float:right;"> <span id="subtotal_ov">$0.00</span> </div>
							<div class="col-sm-6 col-xs-6" align="left">EXTRAS </div>
							<div class="col-sm-6 col-xs-6" align="right" style="float:right;"><span id="extras_ov">+ $0.00</span></div>
							<div class="col-sm-6 col-xs-6" align="left">IVA </div>
							<div class="col-sm-6 col-xs-6" align="right" style="float:right;"><span id="iva_ov">+ $0.00</span></div>
							<div class="col-sm-6 col-xs-6" align="left">DESCUENTO </div>
							<div class="col-sm-6 col-xs-6" align="right" style="float:right;"><span id="descuento_ov">- $0.00</span></div>
              <div class="col-sm-6 col-xs-6" align="left"><span id="descuento_concepto"></span> </div>
							
							<div class="col-sm-12 col-xs-12 text-danger" align="right" style="font-size:1.7em;">
								<strong>TOTAL</strong> <strong><span id="total_ov">$0.00</span></strong>
							</div>
							
							<!--<div class="col-sm-12 col-xs-12" align="left">
								<div class="input-group">
									<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
									<input type="text" class="form-control" id="pago_ov" name="pago_ov" placeholder="Su pago" style="text-align:right;" min="0" required onKeyUp="su_pago(this.value,this.id);">
								</div>
							</div>-->
							  
							<div class="col-sm-3 col-xs-3 text-info" align="center">
								ASOCIACIÓN M. $<span class="1total_c1" id="1total_c1">0.00</span><br>
								<div class="input-group">
									<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
									<input type="text" class="form-control" id="pago_ov_c" name="pago_ov_c" placeholder="Su pago" style="text-align:right;" min="0" required onKeyUp="su_pago_a(this.value,this.id);">
								</div>
							</div>
							<div class="col-sm-3 col-xs-3 text-info" align="center">
								IMAGEN $<span class="1total_i" id="1total_i">0.00</span><br>
								<div class="input-group">
									<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
									<input type="text" class="form-control" id="pago_ov_i" name="pago_ov_i" placeholder="Su pago" style="text-align:right;" min="0" required onKeyUp="su_pago_i(this.value,this.id);">
								</div>
							</div>
							<div class="col-sm-3 col-xs-3 text-info" align="center">
								LABORATORIO $<span class="1total_l" id="1total_l">0.00</span><br>
								<div class="input-group">
									<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
									<input type="text" class="form-control" id="pago_ov_l" name="pago_ov_l" placeholder="Su pago" style="text-align:right;" min="0" required onKeyUp="su_pago_l(this.value,this.id);">
								</div>
							</div>
							<div class="col-sm-3 col-xs-3 text-info" align="center">
								FARMACIA $<span class="1total_p" id="1total_p">0.00</span><br>
								<div class="input-group">
									<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
									<input type="text" class="form-control" id="pago_ov_f" name="pago_ov_f" placeholder="Su pago" style="text-align:right;" min="0" required onKeyUp="su_pago_p(this.value,this.id);">
								</div>
							</div>
							
							<div class="col-sm-12 col-xs-12" align="right"><br>
								<button type="button" class="btn btn-info btn-sm" id="btn_liquidar_ov"><i class="fa fa-dollar" aria-hidden="true"></i> Liquidar</button>
							</div>
							<!--<div class="col-sm-12 col-xs-12"> <br>
								<select id="sucursal_fi_p" name="sucursal_fi_p" class="form-control" required> </select>
							</div>-->
							<div class="col-sm-12 col-xs-12 hidden"> <select id="procedencia_fi_p" name="procedencia_fi_p" class="form-control"> </select> </div>
						  </div>
						</div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="tImagen"><br>
                    	<div class="panel panel-primary hidden" id="new_med_ext">
                          <!-- Default panel contents -->
                          <div class="panel-heading">AGREGAR UN MÉDICO AL SISTEMA</div>
                          <div class="panel-body">
                            <p class="text-primary">Para agregar un médico, indique todos los campos:</p>
                        	<div class="row">
                                <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                     <label for="nombre_m_e">* Nombre del médico</label>
                                     <input type="text"class="form-control input-sm campos_m_e" id="nombre_m_e" name="nombre_m_e" placeholder="Nombre del médico">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                     <label for="apaterno_m_e">* Apellido paterno</label>
                                     <input type="text" class="form-control input-sm campos_m_e" id="apaterno_m_e"name="apaterno_m_e"placeholder="Apellido paterno del médico">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                     <label for="amaterno_m_e">Apellido materno</label>
                                     <input type="text" class="form-control input-sm campos_m_e" id="amaterno_m_e"name="amaterno_m_e"placeholder="Apellido materno del médico">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                     <label for="sexo_m_e">* Sexo</label>
                                     <select id="sexo_m_e" name="sexo_m_e" class="form-control input-sm campos_m_e">
                                     	<option value="">-Seleccionar-</option><option value="1">Femenino</option><option value="2">Masculino</option>
                                     </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div id="alerta_me" class="alert alert-danger">
                            	<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                            </div>
                            <div class="panel-footer">
                            	<div class="row">
                                    <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                                    <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                                        <button type="button" class="btn btn-success btn-sm" id="addMedico_ext">Guardar Médico</button>
                                    </div>
                                    <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                        <button type="button" class="btn btn-warning btn-sm" id="cancelMedico_ext">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    	<div class="row">
                        	<div class="col-sm-10 col-xs-10 col-md-10 col-lg-10">
                                 <select data-placeholder="Selecciona el médico que refiere los estudios" id="medico_i" name="medico_i" class="chosen-select form-control"> </select><br>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            	<button type="button" class="btn btn-primary btn-sm" id="altaMedico_e" alt="Dar de alta un médico">
                                    <i class="fa fa-user-md" aria-hidden="true"></i> Nuevo médico
                                </button>
                            </div>
                    		<div class="col-sm-12 col-xs-12 depende_medico_i hidden">
                            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                              <tr height="50%"> <td>
                                  <table width="100%" cellspacing="0" id="dataTableBestudiosI" height="100%" border="0" cellpadding="0" class="table-striped table-hover table-responsive table table-bordered">
                                    <thead id="my_head">
                                      <tr class="bg-info">
                                        <th align="center" id="clickmeIm">ESTUDIOS DISPONIBLES. <span class="small">Seleccione con un click</span>.</th>
                                        <th align="center">ÁREA&nbsp;</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                        <th align="center">DICOM</th>
                                        <th>INDICA</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    <tfoot id="mi_pie_tabla" align="center">
                                        <tr>
                                            <th> <input type="text" name="text1" class="form-control input-sm" style="width:99%;" placeholder="Buscar"> </th>
                                            <th> <input type="text" name="text2" class="form-control input-sm" style="width:99%;" placeholder="Buscar"> </th>
                                            <th> </th>
                                            <th> <select id="beneficio_i" name="beneficio_i" class="form-control input-sm" style=""> </select> </th>
                                            <th> </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </td>
                              </tr>
                              <tr> 
								  <td>
                                    <table width="100%" cellspacing="0" id="dataTableEiS" height="100%" border="0" cellpadding="0" class="table-bordered table-hover table table-responsive">
                                    <thead>
                                      <tr class="bg-success">
                                        <th id="clickmeEiS" align="center" width="1%">#</th>
                                        <th align="center">ESTUDIOS SELECCIONADOS</th>
                                        <th align="center">ÁREA</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                        <th align="center" width="1%">ELIMINAR</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    </table>
                                  </td>
                              </tr>
                            </table>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_img hidden" style="padding-top: 5px;">
                            	<div class="form-group">
                                	<label for="motivo_i" class="text-info">Motivo de los estudios</label>
                                	<input type="text" class="form-control" id="motivo_i" name="motivo_i" placeholder="Motivo de los estudios">
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_img hidden">
                            	<div class="form-group" align="center">
                                     <label for="po_descuento_i">% Descuento</label>
                                     <div class="input-group">
                                     	<input type="text" class="form-control desc_cargo_i" id="po_descuento_i" name="po_descuento_i" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_i(this.value,this.id);" onclick="alertaEliminarDescuentoI(1)" onblur="mostrarDescuentoPorcentaje();" tabindex="-1">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_img hidden">
                            	<div class="form-group" align="center">
                                     <label for="da_descuento_i">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_i" id="da_descuento_i" name="da_descuento_i" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_i(this.value,this.id);" onblur="mostrarDescuentoDirecto();">
                                     	<input type="hidden" class="form-control" id="da_descuento_i_secreto" name="da_descuento_i_secreto" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_img hidden">
                            	<div class="form-group" align="center">
                                     <label for="cargo_extra_i">Cargo extra</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_i" id="cargo_extra_i" name="cargo_extra_i" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_i(this.value,this.id);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_descuento_i hidden">
                            	<div class="form-group">
                                 <label for="motivo_descuento_i">Motivo del descuento</label>
                                 <input type="text" class="form-control desc_cargo_i" id="motivo_descuento_i" name="motivo_descuento_i" placeholder="Motivo del descuento" onKeyUp="cargos_descuentos_i(0,this.id);" onblur="seleccionarCampoDescuento();">
                                 </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_descuento_i2 hidden">
                            	<div class="form-group">
                                 <label for="motivo_cargo_i">Motivo del cargo extra</label>
                                 <input type="text" class="form-control desc_cargo_i" id="motivo_cargo_i" name="motivo_cargo_i" placeholder="Motivo del cargo extra" onKeyUp="cargos_descuentos_i(0,this.id);">
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_img hidden">
                            	<div class="form-group" align="center">
                                     <label for="precio_i" class="text-info">Precio estudios</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="precio_i" name="precio_i" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_img hidden">
                            	<div class="form-group" align="center">
                                     <label for="to_descuento_i" class="text-info">Total descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="to_descuento_i" name="to_descuento_i" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_img hidden">
                            	<div class="form-group" align="center">
                                     <label for="total_i" class="text-danger">Total</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control" id="total_i" name="total_i" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>

                            <!-- Inicio resumen de imagen -->
                            <div class="col-sm-12 col-xs-12" id="resumen_individual">
                              <span id="resumen_individual_titulo" class="resumen_imagen_titulo" estado='hidden' onclick="showTablaDescuentos('imagen');">Resumen de los descuentos <strong id="resumen_flecha_icono" class="flecha_icono_imagen">↓</strong></span>
                              <table width="100%" cellspacing="0" id="resumen_imagen" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive" style="display: none; margin: 1rem 0px 0px">
                                <thead>
                                  <tr class="bg-success">
                                    <th width='5%' style="text-align: center;">#</th>
                                    <th width='40%'>Estudio</th>
                                    <th width='40%'>Concepto</th>
                                    <th width='15%'>Monto</th>
                                  </tr>
                                </thead>
                                <tbody id="resumen_imagen_body">
                                  <tr id="sin_descuentos_imagen">
                                    <td colspan="4" style="text-align: center;" class="dataTables_empty">Aún no se han aplicados descuentos</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!-- Fin resumen de imagen -->

                        </div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="tLab"><br>
                    	<div class="panel panel-primary hidden" id="new_med_ext1">
                          <!-- Default panel contents -->
                          <div class="panel-heading">AGREGAR UN MÉDICO AL SISTEMA</div>
                          <div class="panel-body">
                            <p class="text-primary">Para agregar un médico, indique todos los campos:</p>
                        	<div class="row">
                                <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                     <label for="nombre_m_e1">* Nombre del médico</label>
                                     <input type="text"class="form-control input-sm campos_m_e" id="nombre_m_e1" name="nombre_m_e1" placeholder="Nombre del médico">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                     <label for="apaterno_m_e1">* Apellido paterno</label>
                                     <input type="text" class="form-control input-sm campos_m_e" id="apaterno_m_e1"name="apaterno_m_e1"placeholder="Apellido paterno del médico">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                     <label for="amaterno_m_e1">Apellido materno</label>
                                     <input type="text" class="form-control input-sm campos_m_e" id="amaterno_m_e1"name="amaterno_m_e1"placeholder="Apellido materno del médico">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                     <label for="sexo_m_e1">* Sexo</label>
                                     <select id="sexo_m_e1" name="sexo_m_e1" class="form-control input-sm campos_m_e">
                                     	<option value="">-Seleccionar-</option><option value="1">Femenino</option><option value="2">Masculino</option>
                                     </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div id="alerta_me1" class="alert alert-danger">
                            	<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de completar los campos con * son obligatorios.
                            </div>
                            <div class="panel-footer">
                            	<div class="row">
                                    <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="right"></div>
                                    <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                                        <button type="button" class="btn btn-success btn-sm" id="addMedico_ext1">Guardar Médico</button>
                                    </div>
                                    <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="left">
                                        <button type="button" class="btn btn-warning btn-sm" id="cancelMedico_ext1">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-sm-10 col-xs-10 col-md-10 col-lg-10">
                                 <select data-placeholder="Selecciona el doctor que refiere los estudios" id="medico_l" name="medico_l" class="chosen-select form-control"> </select><br>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2" align="right">
                            	<button type="button" class="btn btn-primary btn-sm" id="altaMedico_e1" alt="Dar de alta un médico">
                                    <i class="fa fa-user-md" aria-hidden="true"></i> Nuevo médico
                                </button>
                            </div>
                            
                    		<div class="col-sm-12 col-xs-12 depende_medico_l hidden">
                            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                              <tr height="50%"> <td>
                                  <table width="100%" cellspacing="0" id="dataTableBestudiosL" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-bordered table-responsive">
                                    <thead id="my_head">
                                      <tr class="bg-info">
                                        <th align="center" id="clickmeLa">ESTUDIOS DISPONIBLES. <span class="small">Seleecione con un click</span>.</th>
                                        <th align="center">
                                            ÁREA&nbsp;
                                            <button type="button" class="btn btn-success btn-xs hidden altaMedico" id="" alt="Dar de alta un médico">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                        </button>
                                        </th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                        <th align="center">INFO</th>
                                        <th align="center">INDICA</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    <tfoot id="mi_pie_tabla" align="center">
                                        <tr>
                                            <th>
                                                <input type="text" name="text1" class="form-control input-sm" style="width:99%;" placeholder="Buscar">
                                            </th>
                                            <th>
                                                <input type="text" name="text2" class="form-control input-sm" style="width:99%;" placeholder="Buscar">
                                            </th>
                                            <th> </th>
                                            <th><select id="beneficio_l" name="beneficio_l" class="form-control input-sm" style=""> </select></th>
                                            <th> </th>
                                            <th> </th>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </td>
                              </tr>
                              <tr> <td>
                                    <table width="100%" cellspacing="0" id="dataTableElS" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                      <tr class="bg-success">
                                        <th id="clickmeElS" align="center" width="1%">#</th>
                                        <th align="center">ESTUDIOS SELECCIONADOS</th>
                                        <th align="center">ÁREA</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                        <th align="center" width="1%">ELIMINAR</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    </table>
                                </td>
                              </tr>
                            </table>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_lab hidden" style="padding-top: 5px;">
                            	<div class="form-group">
                                 <label for="motivo_l" class="text-info">Motivo de los estudios</label>
                                 <input type="text" class="form-control" id="motivo_l" name="motivo_l" placeholder="Motivo de los estudios">
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_lab hidden">
                            	<div class="form-group" align="center">
                                     <label for="po_descuento_l">% Descuento</label>
                                     <div class="input-group">
                                     	<input type="text" class="form-control desc_cargo_l" id="po_descuento_l" name="po_descuento_l" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_l(this.value,this.id);" onclick="alertaEliminarDescuentoI(2)" oninput="handlerLabDescPorcentaje(this);" tabindex="-1">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_lab hidden">
                            	<div class="form-group" align="center">
                                     <label for="da_descuento_l">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_l" id="da_descuento_l" name="da_descuento_l" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_l(this.value,this.id);" oninput="handlerLabDescDirecto(this);">
                                       <input type="hidden" class="form-control" id="da_descuento_l_secreto" name="da_descuento_l_secreto" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_lab hidden">
                            	<div class="form-group" align="center">
                                     <label for="cargo_extra_l">Cargo extra</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_l" id="cargo_extra_l" name="cargo_extra_l" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_l(this.value,this.id);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_descuento_l hidden">
                            	<div class="form-group">
                                 <label for="motivo_descuento_l">Motivo del descuento</label>
                                 <input type="text" class="form-control" id="motivo_descuento_l" name="motivo_descuento_l" placeholder="Motivo del descuento" onKeyUp="cargos_descuentos_l(0,this.id);" oninput="handlerMotivoDescLab(this);">
                                 </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_descuento_l2 hidden">
                            	<div class="form-group">
                                 <label for="motivo_cargo_l">Motivo del cargo extra</label>
                                 <input type="text" class="form-control" id="motivo_cargo_l" name="motivo_cargo_l" placeholder="Motivo del cargo extra" onKeyUp="cargos_descuentos_l(0,this.id);">
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_lab hidden">
                            	<div class="form-group" align="center">
                                     <label for="precio_l" class="text-info">Precio estudios</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="precio_l" name="precio_l" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_lab hidden">
                            	<div class="form-group" align="center">
                                     <label for="to_descuento_l" class="text-info">Total descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="to_descuento_l" name="to_descuento_l" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_lab hidden">
                            	<div class="form-group" align="center">
                                     <label for="total_l" class="text-danger">Total</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="total_l" name="total_l" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                        </div>

                        <!-- Inicio resumen de lab -->
                        <div class="col-sm-12 col-xs-12" id="resumen_individual">
                          <span id="resumen_individual_titulo" class="resumen_lab_titulo" estado='hidden' onclick="showTablaDescuentos('lab');">Resumen de los descuentos <strong id="resumen_flecha_icono" class="flecha_icono_lab">↓</strong></span>
                          <table width="100%" cellspacing="0" id="resumen_lab" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive" style="display: none; margin: 1rem 0px 0px">
                            <thead>
                              <tr class="bg-success">
                                <th width='5%' style="text-align: center;">#</th>
                                <th width='40%'>Estudio</th>
                                <th width='40%'>Concepto</th>
                                <th width='15%'>Monto</th>
                              </tr>
                            </thead>
                            <tbody id="resumen_lab_body">
                              <tr id="sin_descuentos_lab">
                                <td colspan="4" style="text-align: center;" class="dataTables_empty">Aún no se han aplicados descuentos</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- Fin resumen de lab -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tServicios"><br>
                        <div class="row">
                        	<div class="col-sm-12 col-xs-12">
                                 <select data-placeholder="Selecciona el personal médico para los servicios" id="medico_s" name="medico_s" class="chosen-select form-control"> </select><br>
                            </div>
                    		<div class="col-sm-12 col-xs-12 depende_medico_s hidden">
                            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                              <tr height="50%"> <td>
                                  <table width="100%" cellspacing="0" id="dataTableBserviciosM" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-bordered table-responsive">
                                    <thead id="my_head">
                                      <tr class="bg-info">
                                        <th align="center" id="clickmeSe">SERVICIOS DISPONIBLES. <span class="small">Seleecione con un click</span>.</th>
                                        <th align="center">
                                            ÁREA&nbsp;
                                            <button type="button" class="btn btn-success btn-xs hidden altaMedico" id="" alt="Dar de alta un médico">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Agregar
                                        </button>
                                        </th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    <tfoot align="center">
                                        <tr>
                                            <th> <input type="text" name="text1" class="form-control input-sm" style="width:99%;" placeholder="Buscar"> </th>
                                            <th> <input type="text" name="text2" class="form-control input-sm" style="width:99%;" placeholder="Buscar"> </th>
                                            <th> </th>
                                            <th> <select id="beneficio_s" name="beneficio_s" class="form-control input-sm" style=""> </select> </th>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </td>
                              </tr>
                              <tr> <td>
                                    <table width="100%" cellspacing="0" id="dataTableSmS" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                      <tr class="bg-success">
                                        <th id="clickmeSmS" align="center" width="1%">#</th>
                                        <th align="center">SERVICIOS SELECCIONADOS</th>
                                        <th align="center">ÁREA</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                        <th align="center" width="1%">ELIMINAR</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    </table>
                                </td>
                              </tr>
                            </table>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_ser hidden" style="padding-top: 5px;">
                            	<div class="form-group">
                                 <label for="motivo_s" class="text-info">Motivo de los servicios médicos</label>
                                 <input type="text" class="form-control" id="motivo_s" name="motivo_s" placeholder="Motivo de los servicios médicos">
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_ser hidden">
                            	<div class="form-group" align="center">
                                     <label for="po_descuento_s">% Descuento</label>
                                     <div class="input-group">
                                     	<input type="text" class="form-control desc_cargo_s" id="po_descuento_s" name="po_descuento_s" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_s(this.value,this.id);" onclick="eliminarDescuentosServicios('directo');" oninput="handlerDescuentoPorcentajeServicios(this);">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_ser hidden">
                            	<div class="form-group" align="center">
                                     <label for="da_descuento_s">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_s" id="da_descuento_s" name="da_descuento_s" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_s(this.value,this.id);" onclick="eliminarDescuentosServicios('porcentaje');" oninput="handlerDescuentoDirectoServicios(this);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_ser hidden">
                            	<div class="form-group" align="center">
                                     <label for="cargo_extra_s">Cargo extra</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_s" id="cargo_extra_s" name="cargo_extra_s" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_s(this.value,this.id);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_descuento_s hidden">
                            	<div class="form-group">
                                 <label for="motivo_descuento_s">Motivo del descuento o del cargo extra</label>
                                 <input type="text" class="form-control" id="motivo_descuento_s" name="motivo_descuento_s" placeholder="Motivo del descuento o del cargo extra" oninput="actualizarCoceptoDescuento(this);">
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_ser hidden">
                            	<div class="form-group" align="center">
                                     <label for="precio_s" class="text-info">Precio servicios</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="precio_s" name="precio_s" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_ser hidden">
                            	<div class="form-group" align="center">
                                     <label for="to_descuento_s" class="text-info">Total descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="to_descuento_s" name="to_descuento_s" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_ser hidden">
                            	<div class="form-group" align="center">
                                     <label for="total_s" class="text-danger">Total</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="total_s" name="total_s" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>

                            <!-- Inicio resumen de servicios -->
                            <div class="col-sm-12 col-xs-12" id="resumen_individual">
                              <span id="resumen_individual_titulo" class="resumen_servicios_titulo" estado='hidden' onclick="showTablaDescuentos('servicios');">Resumen de los descuentos <strong id="resumen_flecha_icono" class="flecha_icono_servicios">↓</strong></span>
                              <table width="100%" cellspacing="0" id="resumen_servicios" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive" style="display: none; margin: 1rem 0px 0px">
                                <thead>
                                  <tr class="bg-success">
                                    <th width='5%' style="text-align: center;">#</th>
                                    <th width='40%'>Servicio</th>
                                    <th width='40%'>Concepto</th>
                                    <th width='15%'>Monto</th>
                                  </tr>
                                </thead>
                                <tbody id="resumen_servicios_body">
                                  <tr id="sin_descuentos_servicios">
                                    <td colspan="4" style="text-align: center;" class="dataTables_empty">Aún no se han aplicados descuentos</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!-- Fin resumen de servicios -->

                          </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tFarmacia"><br>
                        <div class="row">
                    		<div class="col-sm-12 col-xs-12">
                            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                              <tr height="50%"> <td>
                                  <table width="100%" cellspacing="0" id="dataTableBproductos" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-bordered table-responsive">
                                    <thead id="my_head">
                                      <tr class="bg-info">
                                        <th align="center" id="clickmePr">
                                          PRODUCTOS DISPONIBLES. <span class="small">Seleecione con un click</span>.
                                        </th>
                                        <th align="center">CÓDIGO DE BARRAS</th>
                                        <th align="center">
                                            ÁREA&nbsp;
                                        </th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> 
                                      <tr> 
                                        <td class="dataTables_empty">Cargando datos del servidor</td>
                                      </tr> 
                                    </tbody>
                                    <tfoot align="center">
                                        <tr>
                                          <th>
                                              <input type="text" name="te1" class="form-control input-sm" style="width:99%;" placeholder="Buscar">
                                          </th>
                                          <th>
                                            <input type="text" name="te2" class="form-control input-sm" style="width:99%;" placeholder="Buscar">
                                          </th>
                                          <th>
                                              <input type="text" name="te3" class="form-control input-sm" style="width:99%;" placeholder="Buscar">
                                          </th>
                                          <th></th>
                                          <th>
                                            <select id="beneficio_p" name="beneficio_p" class="form-control input-sm" style=""></select>
                                          </th>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </td>
                              </tr>
                              <tr> <td>
                                    <table width="100%" cellspacing="0" id="dataTablePS" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                      <tr class="bg-success">
                                        <th id="clickmePS" align="center" width="1%">#</th>
                                        <th align="center">PRODUCTOS SELECCIONADOS</th>
                                        <th align="center">ÁREA</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                        <th align="center" width="1%">ELIMINAR</th>
                                        <th align="center" width="1%">PRINT</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    </table>
                                </td>
                              </tr>
                            </table>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_pro hidden">
                            	<div class="form-group" align="center">
                                     <label for="po_descuento_p">% Descuento</label>
                                     <div class="input-group">
                                     	<input type="text" class="form-control desc_cargo_p" id="po_descuento_p" name="po_descuento_p" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_p(this.value,this.id);">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_pro hidden">
                            	<div class="form-group" align="center">
                                     <label for="da_descuento_p">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_p" id="da_descuento_p" name="da_descuento_p" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_p(this.value,this.id);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_pro hidden">
                            	<div class="form-group" align="center">
                                     <label for="cargo_extra_p">Cargo extra</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_p" id="cargo_extra_p" name="cargo_extra_p" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_p(this.value,this.id);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_descuento_p hidden">
                            	<div class="form-group">
                                 <label for="motivo_descuento_p">Motivo del descuento o del cargo extra</label>
                                 <input type="text" class="form-control" id="motivo_descuento_p" name="motivo_descuento_p" placeholder="Motivo del descuento o del cargo extra">
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_pro hidden">
                            	<div class="form-group" align="center">
                                     <label for="precio_p" class="text-info">Precio productos</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="precio_p" name="precio_p" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_pro hidden">
                            	<div class="form-group" align="center">
                                     <label for="to_descuento_p" class="text-info">Total descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="to_descuento_p" name="to_descuento_p" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_pro hidden">
                            	<div class="form-group" align="center">
                                     <label for="total_p" class="text-danger">Total</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="total_p" name="total_p" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
					<div role="tabpanel" class="tab-pane active" id="tConsultas"><br>
                        <div class="row">
                        	<!--<div class="col-sm-12 col-xs-12">
                                 <select data-placeholder="Selecciona el personal médico para las consultas" id="medico_c1" name="medico_c1" class="chosen-select form-control"> </select><br>
                            </div>-->
                    		<div class="col-sm-12 col-xs-12">
                            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                              <tr height="50%"> <td>
                                  <table width="100%" cellspacing="0" id="dataTableBconsultasM" height="100%" border="0" cellpadding="0" class="table table-striped table-hover table-bordered table-responsive">
                                    <thead id="my_head">
                                      <tr class="bg-info">
                                        <th align="center" id="clickmeCo1">CONSULTAS DISPONIBLES. <span class="small">Seleccione con un click</span>.</th>
                                        <th align="center">MÉDICO</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    <tfoot align="center">
                                        <tr>
                                            <th><input type="text" class="form-control input-sm catemaco_limpia" style="width:99%;" placeholder="Buscar"></th>
                                            <th><input type="text" class="form-control input-sm catemaco_limpia" style="width:99%;" placeholder="Buscar"></th>
                                            <th></th>
                                            <th><select id="beneficio_c1" name="beneficio_c1" class="form-control input-sm" style=""> </select></th>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </td>
                              </tr>
                              <tr> <td>
                                    <table width="100%" cellspacing="0" id="dataTableCmS1" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive">
                                    <thead>
                                      <tr class="bg-success">
                                        <th id="clickmeCoS1" align="center" width="3%">#</th>
                                        <th align="center" width="50%">CONSULTAS SELECCIONADAS</th>
                                        <th align="center" width="20%">MÉDICO</th>
                                        <th align="center" width="4%">PRECIO</th>
                                        <th align="center" width="4%">DESCUENTO</th>
                                        <th align="center" width="4%">SUBTOTAL</th>
                                        <th align="center" width="10%">BENEFICIO</th>
                                        <th align="center" width="5%">&times;</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    </table>
                                </td>
                              </tr>
                            </table>
                            </div>
                            <div class="col-sm-12 col-xs-12 depende_con1 hidden" style="padding-top: 5px;">
                            	<div class="form-group">
                                 	<label for="motivo_c1" class="text-info">Motivo de las consultas</label>
                                 	<input type="text" class="form-control" id="motivo_c1" name="motivo_c1" placeholder="Motivo de las consultas">
                                </div>
                            </div>
                            <div class="depende_con1 hidden">
                            	<div class="form-group hidden" align="center">
                                     <label for="po_descuento_c1">% Descuento</label>
                                     <div class="input-group">
                                     	<input type="text" class="form-control desc_cargo_c1" id="po_descuento_c1" name="po_descuento_c1" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_c1(this.value,this.id);">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="depende_con1 hidden">
                            	<div class="form-group hidden" align="center">
                                     <label for="da_descuento_c1">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_c1" id="da_descuento_c1" name="da_descuento_c1" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_c1(this.value,this.id);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_con1 hidden">
                            	<div class="form-group" align="center">
                                     <label for="cargo_extra_c1">Cargo extra</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_c1" id="cargo_extra_c1" name="cargo_extra_c1" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_c1(this.value,this.id);">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-8 col-xs-8 depende_descuento_c1 hidden">
                            	<div class="form-group">
                                 <label for="motivo_descuento_c1">Motivo del descuento o del cargo extra</label>
                                 <input type="text" class="form-control" id="motivo_descuento_c1" name="motivo_descuento_c1" placeholder="Motivo del descuento o del cargo extra">
                                 </div>
                            </div>
                            <div class="col-xs-12"></div>
                            <div class="col-sm-4 col-xs-4 depende_con1 hidden">
                            	<div class="form-group" align="center">
                                     <label for="precio_c1" class="text-info">Precio consultas</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="precio_c1" name="precio_c1" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_con1 hidden">
                            	<div class="form-group" align="center">
                                     <label for="to_descuento_c1" class="text-info">Total descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="to_descuento_c1" name="to_descuento_c1" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_con1 hidden">
                            	<div class="form-group" align="center">
                                     <label for="total_s" class="text-danger">Total</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     <input type="text" class="form-control" id="total_c1" name="total_c1" style="text-align:right;" readonly value="0">
                                     </div>
                                 </div>
                            </div>

                            <!-- Inicio resumen de consultas -->
                            <div class="col-sm-12 col-xs-12" id="resumen_individual">
                              <span id="resumen_individual_titulo" class="resumen_consultas_titulo" estado='hidden' onclick="showTablaDescuentos('consultas');">Resumen de los descuentos <strong id="resumen_flecha_icono" class="flecha_icono_consultas">↓</strong></span>
                              <table width="100%" cellspacing="0" id="resumen_consultas" height="100%" border="0" cellpadding="0" class="table table-bordered table-hover table-responsive" style="display: none; margin: 1rem 0px 0px">
                                <thead>
                                  <tr class="bg-success">
                                    <th width='5%' style="text-align: center;">#</th>
                                    <th width='40%'>Consulta</th>
                                    <th width='40%'>Concepto</th>
                                    <th width='15%'>Monto</th>
                                  </tr>
                                </thead>
                                <tbody id="resumen_consultas_body">
                                  <tr id="sin_descuentos_consultas">
                                    <td colspan="4" style="text-align: center;" class="dataTables_empty">Aún no se han aplicados descuentos</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!-- Fin resumen de consultas -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
