<?php
	include_once 'recursos/session.php';
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'recursos/datauser.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING EMMANUEL ANZURES BAUTISTA">

	<title>PRINCIPAL</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="jquery-ui-1.12.0/jquery-ui.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!--<script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>-->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script>
	<script src="TableTools-2.1.5/media/js/TableTools.js"></script>
    <script src="TableTools-2.1.5/media/js/ZeroClipboard.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script> 
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/cantidad_a_letra.js"></script>
    <script src="funciones/js/redondea.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    <script src="funciones/js/generador_rfc.js"></script>
	<script src='tinymce/tinymce.min.js'></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet">
	<link href="TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">
    <!--<link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet"> -->
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">

    <link href="timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <script src="timepicker/bootstrap-timepicker.min.js"></script>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="myModal20">
<form id="form-2" name="form-2" data-toggle="validator" role="form" >
<div class="modal-dialog modal-lg" role="document" id="contenido_ficha_usuario" style="z-index: 2;">
    <div class="modal-content animated flipInY">
      <div class="modal-header">
        <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td><strong><span id="titulo_modal">NUEVA ORDEN DE VENTA</span></strong></td>
					<td align="right">
						<button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin' aria-hidden='true'></i> Procesando..." class="btn btn-success btn-sm" id="btn_save1">Guardar</button>
            			<!--<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal" id="btn_cancel1">Cancelar</button>-->
						<a href="javascript:window.open('','_self').close(); " class="btn btn-warning btn-sm" data-dismiss="modal" id="btn_cancel1">Cancelar</a>
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
        <input name="id_paciente_ov" type="hidden" value="<?php echo $_GET['idP'];?>" id="id_paciente_ov">
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
                    <li role="presentation"><a href="#tFarmacia" aria-controls="tFarmacia" role="tab" data-toggle="tab" id="t_farm">FARMACIA</a></li>
					<li role="presentation"> <a href="#tResumen" aria-controls="tResumen" role="tab" data-toggle="tab">RESUMEN</a> </li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="tResumen"><br>
                        <div class="row">
						  <div class="" id="" style="font-size: 1em;">
							<div class="col-sm-12 col-xs-12" align="left">
								<select id="forma_pago_ov" name="forma_pago_ov" class="form-control input-sm" required>
								  <option value="">-SELECCIONE UNA FORMA DE PAGO-</option>
								  <option value="1" selected>FORMA PAGO: EFECTIVO</option>
								  <option value="2">FORMA PAGO: TARJETA CRÉDITO</option>
								  <option value="3">FORMA PAGO: TRANSFERENCIA ELECTRÓNICA</option>
								  <option value="4">FORMA PAGO: CHEQUE</option>
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
                                        <th align="center" id="clickmeIm">ESTUDIOS DISPONIBLES. <span class="small">Seleecione con un click</span>.</th>
                                        <th align="center">ÁREA&nbsp;</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
										<th align="center">DICOM</th>
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
										<?php if(isset($_GET['tipoV']) &&  $_GET["tipoV"] == 1){?>
											<th align="center">FECHA</th>
											<th align="center">HORA</th>
										<?php }?>
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
                                     	<input type="text" class="form-control desc_cargo_i" id="po_descuento_i" name="po_descuento_i" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_i(this.value,this.id);">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_img hidden">
                            	<div class="form-group" align="center">
                                     <label for="da_descuento_i">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_i" id="da_descuento_i" name="da_descuento_i" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_i(this.value,this.id);">
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
                                 <label for="motivo_descuento_i">Motivo del descuento o del cargo extra</label>
                                 <input type="text" class="form-control" id="motivo_descuento_i" name="motivo_descuento_i" placeholder="Motivo del descuento o del cargo extra">
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
                                        <?php if(isset($_GET['tipoV']) &&  $_GET["tipoV"] == 1){?>
											<th align="center">FECHA</th>
											<th align="center">HORA</th>
										<?php }?>
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
                                     	<input type="text" class="form-control desc_cargo_l" id="po_descuento_l" name="po_descuento_l" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_l(this.value,this.id);">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_lab hidden">
                            	<div class="form-group" align="center">
                                     <label for="da_descuento_l">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_l" id="da_descuento_l" name="da_descuento_l" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_l(this.value,this.id);">
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
                                 <label for="motivo_descuento_l">Motivo del descuento o del cargo extra</label>
                                 <input type="text" class="form-control" id="motivo_descuento_l" name="motivo_descuento_l" placeholder="Motivo del descuento o del cargo extra">
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
                                        <?php if(isset($_GET['tipoV']) &&  $_GET["tipoV"] == 1){?>
											<th align="center">FECHA</th>
											<th align="center">HORA</th>
										<?php }?>
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
                                     	<input type="text" class="form-control desc_cargo_s" id="po_descuento_s" name="po_descuento_s" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_s(this.value,this.id);">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_ser hidden">
                            	<div class="form-group" align="center">
                                     <label for="da_descuento_s">$ Descuento</label>
                                     <div class="input-group">
                                     	<span class="input-group-addon bootstrap-touchspin-postfix">$</span>
                                     	<input type="text" class="form-control desc_cargo_s" id="da_descuento_s" name="da_descuento_s" placeholder="0" style="text-align:right;" min="0" value="0" data-minlength="0" onKeyUp="cargos_descuentos_s(this.value,this.id);">
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
                                 <input type="text" class="form-control" id="motivo_descuento_s" name="motivo_descuento_s" placeholder="Motivo del descuento o del cargo extra">
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
                                        <th align="center" id="clickmePr">PRODUCTOS DISPONIBLES. <span class="small">Seleecione con un click</span>.</th>
                                        <th align="center">
                                            ÁREA&nbsp;
                                        </th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    <tfoot align="center">
                                        <tr>
                                            <th>
                                                <input type="text" name="te1" class="form-control input-sm" style="width:99%;" placeholder="Buscar">
                                            </th>
                                            <th>
                                                <input type="text" name="te2" class="form-control input-sm" style="width:99%;" placeholder="Buscar">
                                            </th>
                                            <th>
                                            </th>
                                            <th><select id="beneficio_p" name="beneficio_p" class="form-control input-sm" style=""></select></th>
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
                                        <th align="center" id="clickmeCo1">CONSULTAS DISPONIBLES. <span class="small">Seleecione con un click</span>.</th>
                                        <th align="center">MÉDICO</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                      </tr>
                                    </thead>
                                    <tbody align="left"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
                                    <tfoot align="center">
                                        <tr>
                                            <th><input type="text" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
                                            <th><input type="text" class="form-control input-sm" style="width:99%;" placeholder="Buscar"></th>
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
                                        <th id="clickmeCoS1" align="center" width="1%">#</th>
                                        <th align="center">CONSULTAS SELECCIONADAS</th>
                                        <th align="center">MÉDICO</th>
                                        <th align="center">PRECIO</th>
                                        <th align="center">BENEFICIO</th>
                                        <?php if(isset($_GET['tipoV']) &&  $_GET["tipoV"] == 1){?>
											<th align="center">FECHA</th>
											<th align="center">HORA</th>
										<?php }?>
                                        <th align="center" width="1%">ELIMINAR</th>
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
                            <div class="col-sm-4 col-xs-4 depende_con1 hidden">
                            	<div class="form-group" align="center">
                                     <label for="po_descuento_c1">% Descuento</label>
                                     <div class="input-group">
                                     	<input type="text" class="form-control desc_cargo_c1" id="po_descuento_c1" name="po_descuento_c1" placeholder="0" style="text-align:right;" min="0" max="100" value="0" data-minlength="0" data-maxlength="100" onKeyUp="cargos_descuentos_c1(this.value,this.id);">
                                        <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-sm-4 col-xs-4 depende_con1 hidden">
                            	<div class="form-group" align="center">
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
                            <div class="col-sm-12 col-xs-12 depende_descuento_c1 hidden">
                            	<div class="form-group">
                                 <label for="motivo_descuento_c1">Motivo del descuento o del cargo extra</label>
                                 <input type="text" class="form-control" id="motivo_descuento_c1" name="motivo_descuento_c1" placeholder="Motivo del descuento o del cargo extra">
                                 </div>
                            </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
<div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>


<script>
function regresar(){
	$('.si_impre').addClass('hidden'); $('.no_impre').removeClass('hidden'); $('#mi_formato').html('');
}
function crear_formato(nombre_f, id_f, id_p){
	$('.si_impre').removeClass('hidden'); $('.no_impre').addClass('hidden');
	var idForma = {id_f:id_f} //Generamos la nota de evolución si nunca ha sido guardada la consulta
	$.post('pacientes/files-serverside/formato.php',idForma).done(function(datax){
		var datosT = {idP:id_p, idU:$('#id_user').val(), id_vc:1}
		$.post('consultas/files-serverside/cat_texts.php',datosT).done(function(dataT){var datosTe = dataT.split('-{]');
			var alergiasx = datosTe[0], edadx = datosTe[1], sexox = datosTe[2], nombre_pacientex = datosTe[3];
			var nombre_medicox = datosTe[4], svx = datosTe[5], abitusx = datosTe[6], adiccionesx = datosTe[7];
			var puntuacion_glax = datosTe[8], peso_tallax = datosTe[9], fecha_horax = datosTe[10]; //alert(et_firma_medico_atiende_x);
			var nombre_medico_a = datosTe[11], edadx1 = datosTe[12], cedula_p_ma = datosTe[13], nombre_conceptox = datosTe[28];
			var cedula_espe_x = datosTe[14], edad1_x = datosTe[15], especialidadm_x = datosTe[16], fecha_dia_x = datosTe[17];
			var fecha_mes_n_x = datosTe[18], fecha_anio_x = datosTe[19], fecha_hora_x = datosTe[20], nombre_establecimiento_x = datosTe[21];
			var nombre_universidad_x = datosTe[22], peso_x = datosTe[23], et_talla_g = datosTe[24], sex_x = datosTe[25];
			var tiposan_x = datosTe[26], titulom_x = datosTe[27], medico_refiere_x = datosTe[28], fecha_mes_l_x = datosTe[30];
			var firma_medico_atiende_x = datosTe[31], et_t_x = datosTe[34], et_a_x = datosTe[35], et_fc_x = datosTe[36];
			var et_fr_x = datosTe[37], et_temp_x = datosTe[38], et_dx_envio_x = datosTe[39], et_referencia_x = datosTe[40];
			var et_nombre_anestesiologo_x = datosTe[41], et_firma_medico_atiende_x = datosTe[42], et_logo_suc_x = datosTe[43];
			var et_logoe_x = datosTe[44], et_logoee_x = datosTe[45], et_logogm_x = datosTe[46];
			var data = datax; 

			data = data.replace(/{ET_ALERGIAS}/gi, alergiasx);
			data = data.replace(/{ET_EDAD}/gi, edadx1);
			data = data.replace(/{ET_NOMBRE_MEDICO_ATIENDE}/gi, nombre_medicox);
			data = data.replace(/{et_nombre_personal_atiende}/gi, nombre_medico_a);														
			data = data.replace(/{ET_NOMBRE_PACIENTE}/gi, nombre_pacientex);
			data = data.replace(/{ET_SEX}/gi, sexox);
			data = data.replace(/{ET_SV}/gi, svx);
			data = data.replace(/{ET_ABITUS}/gi, abitusx);
			data = data.replace(/{et_adicciones}/gi, adiccionesx);
			data = data.replace(/{et_puntuacion_g}/gi, puntuacion_glax);
			data = data.replace(/{et_pesotalla_g}/gi, peso_tallax);
			data = data.replace(/{et_fechahora}/gi, fecha_horax);
			data = data.replace(/{et_cedulap}/gi, cedula_p_ma);
			data = data.replace(/{et_nombre_procedimiento}/gi, nombre_conceptox);
			data = data.replace(/{et_cedulaesp}/gi, cedula_espe_x);
			data = data.replace(/{et_edad}/gi, edad1_x);
			data = data.replace(/{et_especialidadm}/gi, especialidadm_x);
			data = data.replace(/{et_fecha_dia}/gi, fecha_dia_x);
			data = data.replace(/{et_fecha_mes_numero}/gi, fecha_mes_n_x);
			data = data.replace(/{et_fecha_mes_letra}/gi, fecha_mes_l_x);
			data = data.replace(/{et_fecha_anio}/gi, fecha_anio_x);
			data = data.replace(/{et_fecha_hora}/gi, fecha_hora_x);
			data = data.replace(/{et_nombre_establecimiento}/gi, nombre_establecimiento_x);
			data = data.replace(/{et_nombre_medico_atiende}/gi, nombre_medico_a);
			data = data.replace(/{et_nombre_universidad}/gi, nombre_universidad_x);
			data = data.replace(/{et_nombre_paciente}/gi, nombre_pacientex);
			data = data.replace(/{et_peso_g}/gi, peso_x);
			data = data.replace(/{et_talla_g}/gi, et_talla_g);
			data = data.replace(/{et_sex}/gi, sex_x);
			data = data.replace(/{et_sv}/gi, svx);
			data = data.replace(/{et_tiposan}/gi, tiposan_x);
			data = data.replace(/{et_titulom}/gi, titulom_x);
			data = data.replace(/{et_nombre_medico_refiere}/gi, medico_refiere_x);
			data = data.replace(/{et_t}/gi, et_t_x);
			data = data.replace(/{et_a}/gi, et_a_x);
			data = data.replace(/{et_fc}/gi, et_fc_x);
			data = data.replace(/{et_fr}/gi, et_fr_x);
			data = data.replace(/{et_temp}/gi, et_temp_x);
			data = data.replace(/{et_dx_envio}/gi, et_dx_envio_x);
			data = data.replace(/{et_referencia}/gi, et_referencia_x);
			data = data.replace(/{et_nombre_anestesiologo}/gi, et_nombre_anestesiologo_x);
			data = data.replace(/{et_firma_medico_atiende}/gi, et_firma_medico_atiende_x);
			data = data.replace(/{et_logo_suc}/gi, et_logo_suc_x);
			data = data.replace(/{et_logoe}/gi, et_logoe_x);
			data = data.replace(/{et_logoee}/gi, et_logoee_x);
			data = data.replace(/{et_logogm}/gi, et_logogm_x);

			//$('#mi_formato').html(data);
			tinymce.get('mi_formato').setContent(data);
		});//$('#mi_formato').html(data); 
	});
}
function formatos(id_p, nombre_p){
	$("#myModal1").load('pacientes/htmls/formatos.php', function( response, status, xhr ){ if(status=="success"){
		$('#titulo_modal').text('CREAR UN FORMATO PARA EL PACIENTE '+nombre_p);
		
		setTimeout(function(){
			var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height() - $('#breadc').height() - 245;
			var oTableP = $('#dataTableFormatos').DataTable({
				serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
				"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true } ],
				"sDom": '<"filtro1Principal"><"data_tPrincipal"t><"infoPrincipal"S><"proc">',
				deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/datatable-serverside/dt_formatos.php?id_p="+id_p,
				"fnServerParams": function(aoData, fnCallback){ //var id_p1 = id_p; aoData.push( {"name": "id_p", "value": id_p1 } );
				},
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "FORMATOS FILTRADOS: _END_", "sInfoEmpty": "NINGÚN FORMATO FILTRADO.", "sInfoFiltered": " TOTAL DE FORMATOS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 500, paging: true,
			});

			$('#clickmeFmts').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#clickmeFmts').click();},500);

			//para los fintros individuales por campo de texto
			oTableP.columns().every( function () {
				var that = this;
				$( 'input', this.footer() ).on( 'keyup change', function () { if ( that.search() !== this.value ) { that .search( this.value ) .draw(); } } );
			}); //fin filtros individuales por campo de texto
			
			tinymce.init({
				selector:'#mi_formato',resize:false,height:$('#myModal1').height()*0.63,theme: "modern",
				plugins: 
					"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
				table_default_styles: { width: '100%' },
				relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
				toolbar: 
					"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
				insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
				paste_data_images: true, paste_as_text: true, browser_spellcheck: true, 
				setup: function (editor) {
					editor.addButton( 'mybuttonVP', {
						text: 'IMPRIMIR', icon: false, tooltip: 'Vista de impresión',
						onclick:function(){
							var res = tinyMCE.get("mi_formato").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
							//$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
							$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
						}
					});
				}
			});
		},200);
		
		$('#myModal1').modal('show'); $('#myModal1').on('shown.bs.modal', function (e) { });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
}

function membresia(id_p, nombre_p, estatus_m, costo_m, periodo_m, fecha_i, fecha_f, fecha_i1, fecha_f1){
	if(estatus_m==0){
		swal({
		  title: "PACIENTE NO AFILIADO",
		  text: "EL PACIENTE "+nombre_p+" NO CUENTA CON MEMBRESÍA. ¿DESEAS AFILIAR AL PACIENTE POR UN COSTO DE $"+costo_m+" EN UN PERIODO "+periodo_m+" A PARTIR DE HOY?", type: "",
		  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Aceptar", closeOnConfirm: false, cancelButtonText: "Cancelar"
		},
		function(){
			var datos = {id_p:id_p, costo_m:costo_m, periodo_m:periodo_m, id_u: $('#id_user').val()}
			$.post('pacientes/files-serverside/afiliarPaciente.php',datos).done(function(data){
				if(data==1){ $('#clickme').click();
					swal({ title: "¡CONFIRMACIÓN!", type: "success", text: "El paciente ha sido afiliado.", timer: 1800, showConfirmButton: false }); return;
				}else{alert(data);}
			});
		});
	}else if(estatus_m==1){
		swal({
		  title: "DATOS DE AFILIACIÓN", text: "LA AFILIACIÓN DEL PACIENTE "+nombre_p+" ES DESDE EL DÍA "+costo_m+" HASTA EL DÍA "+periodo_m, type: "",
		  showCancelButton: true, cancelButtonText: "Cerrar", showConfirmButton: false
		});
	}else if(estatus_m==2){
		swal({
		  title: "MEMBRESÍA POR CADUCAR",
		  text: "EL PACIENTE "+nombre_p+" PUEDE RENOVAR SU MEMBRESÍA. ¿DESEAS RENOVAR LA MEMBRESÍA DEL PACIENTE POR UN COSTO DE $"+costo_m+" EN UN PERIODO "+periodo_m+" A PARTIR DE "+fecha_i+" HASTA "+fecha_f+"?", type: "",
		  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Aceptar", closeOnConfirm: false, cancelButtonText: "Cancelar"
		},
		function(){
			var datos = {id_p:id_p, costo_m:costo_m, periodo_m:periodo_m, id_u: $('#id_user').val(), fecha_i:fecha_i1, fecha_f:fecha_f1}
			$.post('pacientes/files-serverside/reAfiliarPaciente.php',datos).done(function(data){
				if(data==1){ $('#clickme').click();
					swal({ title:"¡CONFIRMACIÓN!", type:"success", text:"La afiliación del paciente ha sido renovada.", timer:1800, showConfirmButton:false }); return;
				}else{alert(data);}
			});
		});
	}else if(estatus_m==3){
		swal({
		  title: "AFILIACIÓN VENCIDA",
		  text: "LA AFILIACIÓN DEL PACIENTE "+nombre_p+" ESTÁ VENCIDA DESDE "+fecha_i+". ¿DESEAS RENOVAR LA AFILIACIÓN DEL PACIENTE POR UN COSTO DE $"+costo_m+" EN UN PERIODO "+periodo_m+" A PARTIR DE HOY?", type: "",
		  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Aceptar", closeOnConfirm: false, cancelButtonText: "Cancelar"
		},
		function(){
			var datos = {id_p:id_p, costo_m:costo_m, periodo_m:periodo_m, id_u: $('#id_user').val()}
			$.post('pacientes/files-serverside/afiliarPaciente.php',datos).done(function(data){
				if(data==1){ $('#clickme').click();
					swal({title:"¡CONFIRMACIÓN!", type:"success", text:"La afiliación del paciente ha sido renovada.", timer:1800, showConfirmButton:false }); return;
				}else{alert(data);}
			});
		});
	}
}

function modificarFechaConcepto(datepicker,hora){
	var tipo = datepicker.data('type');
	var id = datepicker.data('id');
	var fecha = datepicker.val();
	var hora = hora;//datepicker.parent().prev().children().val();
	hora += ":00";

	$.ajax({
		type:'POST',
		url: "pacientes/js/datatable-serverside/actualizar_consultas_seleccionadas.php",
		data: {idVC:id,fechaVC:fecha,horaVC:hora}
	}).done(function(data){ console.log(data);});
}

$(document).ready(function(e) {
	
	$(document).on("change",".miTimepicker",function(){
		var datepicker = $(this);
		var tipo = datepicker.data('type');
		var id = datepicker.data('id');
		var hora = datepicker.val();
		var fecha = datepicker.parent().prev().children().val();
		hora += ":00";

		$.ajax({
			type:'POST',
			url: "pacientes/js/datatable-serverside/actualizar_consultas_seleccionadas.php",
			data: {idVC:id,fechaVC:fecha,horaVC:hora}
		}).done(function(data){ console.log(data);});
	});

    $.fn.datetimepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"],
        daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        meridiem: '',
        clear: "Clear"
    };
    nuevaVisita(<?php echo $_GET['idP'];?>, <?php echo '"'.$_GET['nombreP'].'"';?>,<?php echo $_GET['tipoV'];?>);
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>RECEPCIÓN</li><li class="active"><strong>PACIENTES</strong></li>');
	
	//$('body').popover({selector: '[data-toggle="popover"]', 'trigger': 'hover', 'placement': 'left'});
	
	$(document).on('focus', ':not(.popover)', function(){ $('.popover').popover('hide'); }); //$('[data-toggle="popover"]').popover({ });
	
	$('#my_search').removeClass('hidden'); 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-$('#breadc').height()-204;
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, { "bVisible": true }, { "bVisible": true },
			{"bVisible":true}, {"bVisible":true },{ "bVisible": false }, { "bVisible": true }, { "bVisible": true },
			{"bVisible":false}, {"bVisible":false },{ "bVisible": false }, { "bVisible": false }, { "bVisible": true },{"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>Tr<"data_tPrincipal"t><"infoPrincipal"iS><"proc"p>',
		"oTableTools": {
			"sSwfPath": "TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{ "sExtends": "pdf", "sButtonText": "PDF", "sPdfOrientation": "landscape", "sPdfSize": "letter", "sPdfMessage": "Reporte de Ingresos." },
				{ "sExtends": "xls", "sButtonText": "EXCEL" }, { "sExtends": "copy", "sButtonText": "COPIAR" },
				{ "sExtends": "print", "sButtonText": "IMPRIMIR", "sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar." }
			]
		},
		deferRender: true, select: false, "processing": false, "sAjaxSource": "datatable-serverside/pacientes.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de = $('#top-search').val(), cv = $('#convenioP1').val(); 
			aoData.push( {"name": "nombre", "value": de } );
			aoData.push( {"name": "convenio", "value": cv } ); 
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "PACIENTES FILTRADOS: _END_", "sInfoEmpty": "NINGÚN PACIENTE FILTRADO.", "sInfoFiltered": " TOTAL DE PACIENTES: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 25, paging: true,
	});
	
	$('#clickme').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#clickme').click();},500);
	
	//para los fintros individuales por campo de texto
	oTableP.columns().every( function () {
		var that = this;
		$( 'input', this.footer() ).on( 'keyup change', function () { if ( that.search() !== this.value ) { that .search( this.value ) .draw(); } } );
	} );
	//fin filtros individuales por campo de texto
	
	$('#top-search').keyup(function(e) { $('#dataTablePrincipal_filter input').val($(this).val()); $('#dataTablePrincipal_filter input').keyup(); }).focus();
	$('.filtro1Principal').addClass('hidden');

    $("body").removeClass("modal-open");
    $("body").removeAttr("style");

    $("#page-wrapper").removeAttr("style");
    $("#page-wrapper").css({"overflow":"visible", "height":"max-content"});
    
    $("#myModal4").remove();
});



function nuevo_paciente(){ //Para poder crear un usuario nuevo, el usuario actual debe tener por lo menos una empresa asignada
	$("#myModal").load('pacientes/htmls/ficha_paciente.php', function( response, status, xhr ){ if(status=="success"){
        //$.fn.datepicker.defaults.autoclose = true;
         $('#id_usr_reg').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#id_sucu').val(<?PHP echo $id_sucursal_u; ?>);
		$('#fecha_nacimiento_p1').on('changeDate', function(e) { $('#edad_p').text(calcular_edad(e.format())); });
		
		$("#pais_p").load('genera/paises.php',function(response,status,xhr){if(status=="success"){ 
			$(this).val(146);
			$(this).change(function(e) {
                if($(this).val()!=146){ $('.de_mex').addClass('hidden'); }else{ $('.de_mex').removeClass('hidden');}
				$('#form-ficha_us').validator('update');
            });
		}});
		
		$('#edo_nacimiento').load('pacientes/files-serverside/genera_estados.php',function(response,status,xhr){
			// aquí voy a meter lo de las funciones de calcular RFC y CURP
			$('#edo_nacimiento').change(function(e) {
				var nombreXX=$('#nombre_p').val(),apaternoXX=$('#apaterno_p').val(),splitNombres=$('#nombre_p').val().split(" ");
				if (splitNombres[0] == 'JOSE' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'MARIA' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'MA.' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'MA' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'DE' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'LA' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'LAS' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'MC' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'VON' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'DEL' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'LOS' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'Y' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'MAC' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				if (splitNombres[0] == 'VAN' && splitNombres[1] != undefined) { nombreXX = splitNombres[1]; } else {  }
				
				var asa = $('#apaterno_p').val();
				
				if($('#apaterno_p').val()[0]=='Ñ'){ asa = asa.replace("Ñ", "X");} 
				
				$('#curp_p').val((fnCalculaCURP(nombreXX,asa,$('#amaterno_p').val(),$('#fecha_nacimiento_p').val(),$('#sexo_us').val(),$('#edo_nacimiento').find(':selected').text()))); $('#rfc_p').val($('#curp_p').val().substr(0,10));
			});
			$('#nombre_p, #apaterno_p, #amaterno_p').keyup(function(e) {
				if($('#nombre_p').val()!='' & $('#apaterno_p').val()!='' & $('#fecha_nacimiento_p').val()!='' & $('#sexo_us').val()!=''){ $("#edo_nacimiento").load('pacientes/files-serverside/genera_estadosEN.php', function( response, status, xhr ) { if ( status == "success" ) { } });
				}else{ 
					$("#edo_nacimiento").load('pacientes/files-serverside/genera_nada.php', function( response, status, xhr ) {});
					$('#curp_p, #rfc_p').val('');
				}
			});
			$('#fecha_nacimiento_p, #sexo_us').change(function(e) {
				if($('#fecha_nacimiento_p').val()!='' & $('#sexo_us').val()!='' & $('#nombre_p').val()!='' & $('#apaterno_p').val()!=''){ 
					$("#edo_nacimiento").load('pacientes/files-serverside/genera_estadosEN.php',function(response,status,xhr){
						if(status == "success"){ } 
					});
				}else{ 
					$("#edo_nacimiento").load('pacientes/files-serverside/genera_nada.php', function( response, status, xhr ) {});
					$('#curp_p, #rfc_p').val('');
				}
			});
			//Fin funciones calcular rfc y crup
		});
		
		$('#sangre_p').load('pacientes/files-serverside/genera_tsangre.php',function(response,status,xhr){});
			
		$("#estado_dir_p").load('pacientes/files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){
			$("#estado_dir_p").change(function(event){
				$('#municipio_p').val(''); var id = $("#estado_dir_p").find(':selected').text();
				$("#municipio_p").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){if(status=="success"){}});
			});
		}});
		
		$('#estado_dir_p').change(function(e) {
			var address = $('#estado_dir_p').find(':selected').text()+' MÉXICO'; ubicacion(address); $('.mi_dir, #cp_us').val('');
        });
		
		$('.mi_dir').keyup(function(e){
			var address = $('#estado_dir_p').find(':selected').text()+' '+document.getElementById('ciudad_us').value+' '+document.getElementById('colonia_us').value+' '+document.getElementById('calle_us').value; ubicacion(address);
		});
		
		$("#estado_df").load('pacientes/files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){
			$("#estado_df").change(function(event){
				$('#municipio_df').val(''); var id = $("#estado_df").find(':selected').text();
				$("#municipio_df").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){if(status=="success"){}});
			});
		}});
		
		$('#estado_df').change(function(e) { $('#municipio_df').val(''); });
				
		$('#form-ficha_us').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#myModal #form-ficha_us').serialize();
			$.post('pacientes/files-serverside/addPaciente.php',datosP).done(function( data ) { var data2 = data.split(';-:');
				if (data2[0]==1){//si el paciente se Actualizó
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_new_u').show(); $('#myModal').modal('hide');
					swal({
					  title: "¡CONFIRMACIÓN!", text: "El paciente se ha creado satisfactoriamente.", type: "success", showCancelButton: true,
					  confirmButtonColor: "#DD6B55", confirmButtonText: "Orden de venta", cancelButtonText: "Cerrar", closeOnConfirm: false
					}, function(){ swal.close(); nuevaVisita(data2[1], data2[2], 0); }); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) {
			var i=0; $('#t_tDireccion').click(function(e) { if(i%2==0){i++; ubicacion('tren escenico cuautla morelos'); } });
			$('#form-ficha_us').validator(); $('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	} });
}


function siempre(la,lo){
	  var map = new google.maps.Map(document.getElementById('map'), {
		center: new google.maps.LatLng(la, lo), zoom: 16, scrollwheel: false //Cuautla :3
	  });
	  marker = new google.maps.Marker({
		map: map, draggable: true, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la, lo)
	  });
	  $('#lat_us').text(redondear(la,4)); $('#lati_ud').val(la); $('#lon_us').text(redondear(lo,4)); $('#long_ud').val(lo);
	  marker.addListener('dragend', function(){
		  map.panTo(marker.getPosition()); var markerLatLng = marker.getPosition();
		  $('#lat_us').text(redondear(markerLatLng.lat(),4)); $('#lati_ud').val(markerLatLng.lat());
		  $('#lon_us').text(redondear(markerLatLng.lng(),4)); $('#long_ud').val(markerLatLng.lng());
	  });
	  google.maps.event.addListener(marker, 'click', function(){ }); var geocoder = new google.maps.Geocoder();
}
function agregar_me(nombre,apaterno,amaterno,sexo,opc){
	var datos = {nombre:nombre, apaterno:apaterno, amaterno:amaterno, sexo:sexo, id_u:$('#id_user').val()}
	$.post('pacientes/files-serverside/add_medico_e.php',datos).done(function(data){
		if(data==1){
			if(opc == 1){
				$('#medico_i').load('pacientes/genera/medicos_estudios.php',function(response,status,xhr){if(status=="success"){
					$("#medico_i").trigger("chosen:updated");
				}}); $('#cancelMedico_ext').click();
			}
			else{
				$('#medico_l').load('pacientes/genera/medicos_estudios.php',function(response,status,xhr){if(status=="success"){
					$("#medico_l").trigger("chosen:updated");
				}}); $('#cancelMedico_ext1').click();
			}
			swal({title:"MÉDICO AGREGADO",type:"success",text:"El médico se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}

function nuevaVisita(idP, nombreP, tipoVisita){
	camposFechaHora = [];
	esAgenda = "0";
	if(tipoVisita == 1){
		camposFechaHora = [{"bVisible":true},{"bVisible":true}];
		esAgenda = "1";
	}
    
	//$("#myModal4").load('pacientes/htmls/ficha_ov.php', function( response, status, xhr ){ if(status=="success"){
    	$('#altaMedico_e').click(function(e) { $('#new_med_ext').removeClass('hidden'); });
		$('#cancelMedico_ext').click(function(e){ $('.campos_m_e').val(''); $('#new_med_ext').addClass('hidden'); });
		$('#addMedico_ext').click(function(e) {
			if($('#nombre_m_e').val()!='' & $('#apaterno_m_e').val()!='' & $('#sexo_m_e').val()!=''){
				agregar_me($('#nombre_m_e').val(),$('#apaterno_m_e').val(),$('#amaterno_m_e').val(),$('#sexo_m_e').val(),1);
			}else{$("#alerta_me").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_me").slideUp(600); });}
        });
		
		$('#altaMedico_e1').click(function(e) { $('#new_med_ext1').removeClass('hidden'); });
		$('#cancelMedico_ext1').click(function(e){ $('.campos_m_e').val(''); $('#new_med_ext1').addClass('hidden'); });
		$('#addMedico_ext1').click(function(e) {
			if($('#nombre_m_e1').val()!='' & $('#apaterno_m_e1').val()!='' & $('#sexo_m_e1').val()!=''){
				agregar_me($('#nombre_m_e1').val(),$('#apaterno_m_e1').val(),$('#amaterno_m_e1').val(),$('#sexo_m_e1').val(),2);
			}else{$("#alerta_me1").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_me1").slideUp(600); });}
        });
		
        //$.fn.datepicker.defaults.autoclose = true; 
        var nv = new Date(); var k = 0;
		
		$('#aleatorio_ov, #aleatorio_ov_a').val(nv.format('Y-m-d-H-i-s-u').substring(0,22)); 	
		
		//$('#id_paciente_ov').val(idP);
		
		$('#titulo_modal').text('NUEVA VISITA - '+nombreP);
		$('#id_usr_reg').val($('#id_user').val()); $('#alerta1, #alerta_me, #alerta_me1').hide(); $('#id_sucu').val(<?PHP echo $id_sucursal_u; ?>);
		
		$("#beneficio_c,#beneficio_i,#beneficio_l,#beneficio_s,#beneficio_p,#beneficio_c1").load("pacientes/genera/beneficiosP.php?idP="+idP, function(response,status,xhr){});
		
		var oTableCo = $('#dataTableCo').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: false, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<""f>r<""t><""S><"">', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/buscar_consulta.php",
			"fnServerParams": function (aoData, fnCallback) {
				var de = $('#medico_c').val(), idConvenio = $('#mi_id_convenio').val(); //if(idConvenio==null){idConvenio=0;}
				aoData.push({"name": "idMedico", "value": de }); aoData.push({"name": "idConvenio", "value": idConvenio }); aoData.push({"name": "idP", "value": idP }); 
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "CONSULTAS FILTRADAS: _END_", "sInfoEmpty": "NINGUNA CONSULTA FILTRADA.", "sInfoFiltered": " TOTAL DE CONSULTAS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false
		});
		
		$('#clickmeCo').click(function(e){ oTableCo.draw(); reset_totales_consulta(); calcular_totales(); });
		
		$("#beneficio_c").change(function(e){ $('#clickmeCo').click(); $('#mi_id_convenio').val($(this).val())});
		
		$('#btn_liquidar_ov').click(function(e){
			$('#pago_ov_c').val(parseFloat($('#total_c1').val())+parseFloat($('#total_s').val())); $('#pago_ov_i').val($('#total_i').val());
			$('#pago_ov_l').val($('#total_l').val()); $('#pago_ov_f').val($('#total_p').val()); $('#form-2').validator('update');
		});
		
		$('#medico_c').load('pacientes/genera/medicos_consulta.php',function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){$('#medico_c').chosen();},500);
			$('#medico_c').change(function(e) { 
				$('#beneficio_c, #mi_id_convenio').val(0); $('.depende_consulta').addClass('hidden');
				if($(this).val()!=''){ $('.depende_medico_c').removeClass('hidden'); }else{ $('.depende_medico_c, .depende_consulta').addClass('hidden'); }
				$('#clickmeCo').click(); reset_totales_consulta(); calcular_totales();
            });
		}});
		
		var dato = {id_p:idP} 
		$.post('pacientes/files-serverside/datos_paciente_orden_venta.php',dato).done(function(data){
			var mis_datos = data.split(';-{');
			
			$('#sucursal_fi_p').load('pacientes/genera/genera_sucursales_ov.php?idU='+$('#id_user').val(),function(response,status,xhr){if(status=="success"){
				$(this).val(<?PHP echo $id_sucursal_u; ?>);
			}});
			$('#procedencia_fi_p').load('pacientes/genera/procedencia.php',function(response,status,xhr){if(status=="success"){ $(this).val(1); }});
		});
		
		oTableCo.on( 'select', function ( e, dt, type, indexes ) {
			$('.depende_consulta').removeClass('hidden');
			var rowData = oTableCo.rows( indexes ).data().toArray(); //alert(rowData[0][6]);
			totales_consulta(rowData[0][3], $('#po_descuento_c').val(),$('#da_descuento_c').val(),$('#cargo_extra_c').val());
			calcular_totales(); $('#id_consulta_to').val(rowData[0][6]); //alert(rowData[0][12]);
			subir_concepto(1, rowData[0][6], $('#beneficio_c').val(), idP, $('#aleatorio_ov').val(), $('#id_user').val(), $('#medico_c').val(),rowData[0][3]);
		} )
		.on( 'deselect', function ( e, dt, type, indexes ){
			$('.depende_consulta').addClass('hidden'); reset_totales_consulta(); calcular_totales();
		} );
		
		$('.desc_cargo').change(function(e){ nota_desc_cargo(); }); $('.desc_cargo').keyup(function(e) { nota_desc_cargo(); });
		
		$('#beneficio_c').change(function(e){ reset_totales_consulta(); $('#clickmeCo').click(); calcular_totales(); });
		
		$('#cb_facturada_ov').click(function(e) {
            if(k%2==0){ $('#hay_iva_ov').val(1); /*$('#iva_ov_h').val(redondear(parseFloat($('#total_ov_h').val())*0.16,2));*/ calcular_totales();
			}else{ $('#hay_iva_ov').val(0); /*$('#iva_ov_h').val(0);*/ calcular_totales(); } k++;
        });
		
		$('#form-2').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta1").fadeTo(2000,500).slideUp(500,function(){ $("#alerta1").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
			var datosP = $('#myModal20 #form-2').serialize();
			$.post('pacientes/files-serverside/guardar_ov.php',datosP).done(function( data ) { var datil = data.split(';]');
				if (datil[0]==1){//si el paciente se Actualizó 
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel1').show(); $('#myModal4').modal('hide');
					swal({
					  title: "VENTA REALIZADA", text: "¿Deseas imprimir el ticket de venta "+datil[1]+"?", type: "success", showCancelButton: true,
					  confirmButtonText: "Imprimir", cancelButtonText: "Salir", closeOnConfirm: false
					},
					function(confirmado){
						if(!confirmado){
							window.open('','_self').close();
						}else{
						swal.close();
						$("#myModal1").load('pacientes/htmls/ticket.php', function( response, status, xhr ){ if(status=="success"){
							//var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-144;
							$('#contenedorAnteriores, #myAbonadoA').hide();
							var oTableT = $('#dataTableResumenT').DataTable({
								serverSide:true,"sScrollY":'100%',ordering:false,searching:false,scrollCollapse:false,"scrollX": true,
								"fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){ },scroller:false,responsive:false,
								"aoColumns": [
									{"bVisible": true}, {"bVisible": false}, {"bVisible": false}, {"bVisible": true}, {"bVisible": false}, {"bVisible": true}
								],
								"sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
								deferRender: true, select: false, "processing": false, 
								"sAjaxSource": "pacientes/js/datatable-serverside/totales_nvTi.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = $('#aleatorio_ov_a').val(); aoData.push(  {"name": "aleatorio", "value": aleatorio } );
								},
								"oLanguage": {
									"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"LA ORDEN DE VENTA ESTA VACIA",
									"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", "sSearch": "BUSCAR"
								},"iDisplayLength": 50000, paging: false
							});
	
							var datosTi = {noAleatorio:$('#aleatorio_ov_a').val()}
							$.post('pacientes/files-serverside/datosTicketNV.php',datosTi).done(function(data){
								var datosT = data.split(';}'); if(datosT[5]==''){datosT[5]=0;} //alert(data);
								//para el ticket
								$('#fechaT').text(datosT[0]);$('#referenciaT').text(datosT[1]);$('#pacienteT').text(datosT[2]);
								$('#adicionalesT').text(datosT[10]);$('#totalT').text(datosT[4]);$('#pagoT').text(datosT[5]);
								$('#saldoT').text(datosT[6]);$('#usuarioIT').text(datosT[7]);$('#fechaIT').text(datosT[8]);
								$('#horaIT').text(datosT[9]); $('#formaPagoT').text(datosT[11]);
								$('#cantidadLetraT').text(nn(datosT[4])); $('#municipioS').text(datosT[16]);
								$('#calleSucursal').text(datosT[19]); $('#coloniaSucursal').text(datosT[18]);
								$('#cpSucursal').text(datosT[20]);$('#telefonoSucursal').text(datosT[21]);
								$('#municipioSucursal').text(datosT[17]);$('#estadoSucursal').text(datosT[15]);
								$('#sitioS').text(datosT[22]);$('#emailSucursal').text(datosT[23]);$('#descuentoT').text(datosT[24]);
								$('#subTotalT').text(datosT[29]);
								if(datosT[25]>0){
									x='sucursales/documentos/files/'+datosT[26]+'.'+datosT[27]+'?'+Math.round(Math.random()*1000);
									$('#myLogoS').html('<img src='+x+' width="150" style="border:5px none white; background-color:rgba(255, 255, 255, 1);">');
								}
								if(datosT[28]>0){ $('#myIva').removeClass('hidden'); }else{$('#myIva').addClass('hidden');}
								$('#ivaT').text(datosT[28]); $('#abonosT').val(datosT[29]); $('#saldosT').val(datosT[30]);
								
								$('#imprimirTic').click(function(e){ $('#tablaTicket').css('font-size','8px').printElement();});
							});
							
							$('#myModal1').modal('show');
							$('#myModal1').on('shown.bs.modal',function(e){ });
							$('#myModal1').on('hidden.bs.modal',function(e){ $(".modal-content").remove(); $("#myModal1").empty(); window.open('','_self').close();});
						}});		
						}			
					});
					return;
				} else{alert(datil[0]);}
			});
		  }
		});
		
		$('#medico_i').load('pacientes/genera/medicos_estudios.php',function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){
				$('#medico_i').chosen(); window.setTimeout(function(){$('#medico_i_chosen').width(100+'%'); },100);
			},500);
			$('#medico_i').change(function(e) { 
				if($(this).val()!=''){ $('.depende_medico_i').removeClass('hidden'); }
				else{ $('.depende_medico_i, .depende_img').addClass('hidden'); }
				$('#clickmeIm').click(); $('#clickmeEiS').click();
            });
		}});
		$('#medico_l').load('pacientes/genera/medicos_estudios.php',function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){
				$('#medico_l').chosen(); window.setTimeout(function(){$('#medico_l_chosen').width(100+'%'); },100);
			},500);
			$('#medico_l').change(function(e) { 
				if($(this).val()!=''){ $('.depende_medico_l').removeClass('hidden'); }
				else{ $('.depende_medico_l, .depende_lab').addClass('hidden'); }
				$('#clickmeLa').click(); $('#clickmeElS').click();
            });
		}});
		$('#medico_s').load('pacientes/genera/personal_medico_servicios.php',function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){
				$('#medico_s').chosen(); window.setTimeout(function(){$('#medico_s_chosen').width(100+'%'); },100);
			},500);
			$('#medico_s').change(function(e) { 
				if($(this).val()!=''){ $('.depende_medico_s').removeClass('hidden'); }
				else{ $('.depende_medico_s, .depende_ser').addClass('hidden'); }
				$('#clickmeSe').click(); $('#clickmeSmS').click();
            });
		}});
		
		$("#beneficio_i").change(function(e){ $('#mi_id_convenioI').val($(this).val())});
		$("#beneficio_l").change(function(e){ $('#mi_id_convenioL').val($(this).val())});
		$("#beneficio_s").change(function(e){ $('#mi_id_convenioS').val($(this).val())});
		$("#beneficio_p").change(function(e){ $('#mi_id_convenioP').val($(this).val())});
		$('#beneficio_c1').change(function(e){ reset_totales_consulta1(); $('#clickmeCo1').click(); calcular_totales(); });
		
		var oTableEim = $('#dataTableBestudiosI').DataTable({
			serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/buscar_estudios_imagen.php",
			"fnServerParams": function (aoData, fnCallback) {
				var idPaci = $('#id_paciente_ov').val(), idConvenio = $('#mi_id_convenioI').val();//if(idConvenio==null){idConvenio=0;}
				var aleatorio = $('#aleatorio_ov').val(), idSucursal = $('#sucursal_fi_p').val();
				aoData.push({"name": "idSucursal", "value": idSucursal} ); aoData.push({"name": "idConvenio", "value": idConvenio } );
				aoData.push({"name": "aleatorio", "value": aleatorio } ); aoData.push({"name": "idP", "value": idPaci } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "ESTUDIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		});
		$('#clickmeIm').click(function(e){ oTableEim.draw(); });
		//para los fintros individuales por campo de texto
		oTableEim.columns().every( function () {
			var that = this;
	 
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			} );
		} );
		//fin filtros individuales por campo de texto
		oTableEim.on( 'select', function ( e, dt, type, indexes ) {
			$('.depende_img').removeClass('hidden');
			var rowData = oTableEim.rows( indexes ).data().toArray(); //alert(rowData[0][6]); //alert(rowData[0][9]);
			if(rowData[0][8]==undefined){var coveni = 0, ocu = 0;}else{var coveni = rowData[0][8], ocu = rowData[0][9];}
			subirEstudio(rowData[0][7], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(), $('#medico_i').val(),
				$('#mi_id_convenioI').val(),$('#sucursal_fi_p').val(),$('#observacionesI_NV').val(), 2, rowData[0][2], 4, coveni, ocu
			); 
			$('.desc_cargo_i').change(function(e){nota_desc_cargo_i();}); $('.desc_cargo_i').keyup(function(e){nota_desc_cargo_i();});
		} );
		var oTableEimS = $('#dataTableEiS').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":camposFechaHora.concat( [{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}]),
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/estudios_seleccionados_imagen.php?agenda="+esAgenda,
			"fnServerParams": function (aoData, fnCallback) {
				var aleatorio = $('#aleatorio_ov').val();
				aoData.push({"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "NO SE HA SELECCIONADO NINGÚN ESTUDIO", 
				"sInfo": "ESTUDIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
        });

        $('#dataTableEiS').on( 'draw.dt', function () {
			let ahora = new Date();
            let mes = ahora.getMonth()+1;
            let dia = ahora.getDate();
            let fechaActual = ahora.getFullYear() + '-' +(mes<10 ? '0' : '') + mes + '-' +(dia<10 ? '0' : '') + dia;
			
			$(".miDatetimepicker").each(function(){
				let fecha = $(this).val();
				$(this).val("");
				$(this).datetimepicker({			            
					minView: 1,				
					language: 'es',
					format: 'dd/mm/yyyy',
					startDate: fechaActual,
					initialDate: fecha,
					autoclose: true
				}).on('changeDate', function(ev){
					let dateTimePick3r = $(this);
					let timePick3r  = dateTimePick3r.parent().next().children();
					let fechaNueva = ev.date;
					fechaNueva.setHours(fechaNueva.getHours()+10);
					let fechaNueva2 = String(fechaNueva.getFullYear())+"-"+String(fechaNueva.getMonth()+1)+"-"+String(fechaNueva.getDate());
					
					let fechaNueva3 = (fechaNueva.getHours()<10? "0"+String(fechaNueva.getHours()) : String(fechaNueva.getHours()) )  +":00";

					timePick3r.datetimepicker('remove');
					timePick3r.val("");
					timePick3r.datetimepicker({		
						format: 'hh:00',	            
						minView: 1,				
						maxView: 1,             
						startView:1,
						startDate: fechaNueva2,
						endDate: fechaNueva2+' 23:59',
						autoclose: true,
						initialDate: fechaNueva2 + " "+fechaNueva3,
						language: 'es'
					});
					timePick3r.val(fechaNueva3);
					
					modificarFechaConcepto($(this),fechaNueva3);
				});
				$(this).val(fecha);
			});
			

			$(".miTimepicker").each(function(){
				let hora = $(this).val();
				$(this).val("");
				$(this).datetimepicker({		
					format: 'hh:00',	            
					minView: 1,				
					maxView: 1,             
					startView:1,
					startDate: fechaActual,
					endDate: fechaActual+' 23:59',
					autoclose: true,
					initialDate: fechaActual + ' '+hora
					,language: 'es'
				});
				$(this).val(hora);
			});
        });
		$('#clickmeEiS').click(function(e){ oTableEimS.draw(); });
		
		$("#beneficio_i").change(function(e){ $('#clickmeIm').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmeIm').click();});
		
		var oTableEla = $('#dataTableBestudiosL').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){
				//$('body').popover({ selector: '[data-toggle="popover"]', 'trigger': 'hover', 'placement': 'auto' }); //$('[data-toggle="popover"]').popover({ }); 
			}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/buscar_estudios_laboratorio.php",
			"fnServerParams": function (aoData, fnCallback) {
				var idPaci = $('#id_paciente_ov').val(), idConvenio = $('#mi_id_convenioL').val();//if(idConvenio==null){idConvenio=0;}
				var aleatorio = $('#aleatorio_ov').val(), idSucursal = $('#sucursal_fi_p').val();
				aoData.push({"name": "idSucursal", "value": idSucursal } ); aoData.push({"name": "idConvenio", "value": idConvenio} );
				aoData.push({"name": "aleatorio", "value": aleatorio } ); aoData.push({"name": "idP", "value": idPaci } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "ESTUDIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		});
		$('#clickmeLa').click(function(e){ oTableEla.draw(); });
		//para los fintros individuales por campo de texto
		oTableEla.columns().every( function () {
			var that = this;
	 
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			} );
		} );
		//fin filtros individuales por campo de texto
		oTableEla.on( 'select', function ( e, dt, type, indexes ) {
			$('.depende_lab').removeClass('hidden');
			var rowData = oTableEla.rows( indexes ).data().toArray(); //alert(rowData[0][6]); //alert(rowData[0][9]);
			if(rowData[0][8]==undefined){var coveni = 0, ocu = 0;}else{var coveni = rowData[0][8], ocu = rowData[0][9];}
			subirEstudioL(rowData[0][7], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(), $('#medico_l').val(),
				$('#mi_id_convenioL').val(),$('#sucursal_fi_p').val(),$('#observacionesL_NV').val(), 2, rowData[0][2], 3, coveni, ocu
			); 
			$('.desc_cargo_l').change(function(e){nota_desc_cargo_l();}); $('.desc_cargo_l').keyup(function(e){nota_desc_cargo_l();});
		} );
			
		var oTableElaS = $('#dataTableElS').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":camposFechaHora.concat( [{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}] ),
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/estudios_seleccionados_laboratorio.php?agenda="+esAgenda,
			"fnServerParams": function (aoData, fnCallback) {
				var aleatorio = $('#aleatorio_ov').val();
				aoData.push({"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "NO SE HA SELECCIONADO NINGÚN ESTUDIO", 
				"sInfo": "ESTUDIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
        });

        $('#dataTableElS').on( 'draw.dt', function () {
            let ahora = new Date();
            let mes = ahora.getMonth()+1;
            let dia = ahora.getDate();
            let fechaActual = ahora.getFullYear() + '-' +(mes<10 ? '0' : '') + mes + '-' +(dia<10 ? '0' : '') + dia;
			
			$(".miDatetimepicker").each(function(){
				let fecha = $(this).val();
				$(this).val("");
				$(this).datetimepicker({			            
					minView: 1,				
					language: 'es',
					format: 'dd/mm/yyyy',
					startDate: fechaActual,
					initialDate: fecha,
					autoclose: true
				}).on('changeDate', function(ev){
					let dateTimePick3r = $(this);
					let timePick3r  = dateTimePick3r.parent().next().children();
					let fechaNueva = ev.date;
					fechaNueva.setHours(fechaNueva.getHours()+10);
					let fechaNueva2 = String(fechaNueva.getFullYear())+"-"+String(fechaNueva.getMonth()+1)+"-"+String(fechaNueva.getDate());
					
					let fechaNueva3 = (fechaNueva.getHours()<10? "0"+String(fechaNueva.getHours()) : String(fechaNueva.getHours()) )  +":00";

					timePick3r.datetimepicker('remove');
					timePick3r.val("");
					timePick3r.datetimepicker({		
						format: 'hh:00',	            
						minView: 1,				
						maxView: 1,             
						startView:1,
						startDate: fechaNueva2,
						endDate: fechaNueva2+' 23:59',
						autoclose: true,
						initialDate: fechaNueva2 + " "+fechaNueva3,
						language: 'es'
					});
					timePick3r.val(fechaNueva3);
					
					modificarFechaConcepto($(this),fechaNueva3);
				});
				$(this).val(fecha);
			});
			

			$(".miTimepicker").each(function(){
				let hora = $(this).val();
				$(this).val("");
				$(this).datetimepicker({		
					format: 'hh:00',	            
					minView: 1,				
					maxView: 1,             
					startView:1,
					startDate: fechaActual,
					endDate: fechaActual+' 23:59',
					autoclose: true,
					initialDate: fechaActual + ' '+hora
					,language: 'es'
				});
				$(this).val(hora);
			});
        });
        
		$('#clickmeElS').click(function(e){ oTableElaS.draw(); });
		
		$("#beneficio_l").change(function(e){ $('#clickmeLa').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmeLa').click();});
		//Fin Laboratorio
		
		//Servicios
		var oTableSer = $('#dataTableBserviciosM').DataTable({
			serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/buscar_servicios_medicos.php",
			"fnServerParams": function (aoData, fnCallback) {
				var idPaci = $('#id_paciente_ov').val(), idConvenio = $('#mi_id_convenioS').val();//if(idConvenio==null){idConvenio=0;}
				var aleatorio = $('#aleatorio_ov').val(), idSucursal = $('#sucursal_fi_p').val();
				aoData.push({"name": "idSucursal", "value": idSucursal } ); aoData.push({"name": "idConvenio", "value": idConvenio });
				aoData.push({"name": "aleatorio", "value": aleatorio } ); aoData.push({"name": "idP", "value": idPaci } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "SERVICIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		});
		$('#clickmeSe').click(function(e){ oTableSer.draw(); });
		//para los fintros individuales por campo de texto
		oTableSer.columns().every( function () {
			var that = this;
	 
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			} );
		} );
		//fin filtros individuales por campo de texto
		oTableSer.on( 'select', function ( e, dt, type, indexes ) {
			$('.depende_ser').removeClass('hidden');
			var rowData = oTableSer.rows( indexes ).data().toArray(); //alert(rowData[0][6]); //alert(rowData[0][9]);
			if(rowData[0][8]==undefined){var coveni = 0, ocu = 0;}else{var coveni = rowData[0][8], ocu = rowData[0][9];}
			subirEstudioS(rowData[0][4], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(), $('#medico_s').val(),
				$('#mi_id_convenioS').val(),$('#sucursal_fi_p').val(),$('#observacionesS_NV').val(),2,rowData[0][2], 2, coveni, ocu
			); 
			$('.desc_cargo_s').change(function(e){nota_desc_cargo_s();}); $('.desc_cargo_s').keyup(function(e){nota_desc_cargo_s();});
		} );
		
		var oTableSerS = $('#dataTableSmS').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":camposFechaHora.concat( [{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}] ),
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/servicios_medicos_seleccionados.php?agenda="+esAgenda,
			"fnServerParams": function (aoData, fnCallback) {
				var aleatorio = $('#aleatorio_ov').val();
				aoData.push({"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "NO SE HA SELECCIONADO NINGÚN SERVICIO", 
				"sInfo": "SERVICIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
        });

        $('#dataTableSmS').on( 'draw.dt', function () {
            let ahora = new Date();
            let mes = ahora.getMonth()+1;
            let dia = ahora.getDate();
            let fechaActual = ahora.getFullYear() + '-' +(mes<10 ? '0' : '') + mes + '-' +(dia<10 ? '0' : '') + dia;
			
			$(".miDatetimepicker").each(function(){
				let fecha = $(this).val();
				$(this).val("");
				$(this).datetimepicker({			            
					minView: 1,				
					language: 'es',
					format: 'dd/mm/yyyy',
					startDate: fechaActual,
					initialDate: fecha,
					autoclose: true
				}).on('changeDate', function(ev){
					let dateTimePick3r = $(this);
					let timePick3r  = dateTimePick3r.parent().next().children();
					let fechaNueva = ev.date;
					fechaNueva.setHours(fechaNueva.getHours()+10);
					let fechaNueva2 = String(fechaNueva.getFullYear())+"-"+String(fechaNueva.getMonth()+1)+"-"+String(fechaNueva.getDate());
					
					let fechaNueva3 = (fechaNueva.getHours()<10? "0"+String(fechaNueva.getHours()) : String(fechaNueva.getHours()) )  +":00";

					timePick3r.datetimepicker('remove');
					timePick3r.val("");
					timePick3r.datetimepicker({		
						format: 'hh:00',	            
						minView: 1,				
						maxView: 1,             
						startView:1,
						startDate: fechaNueva2,
						endDate: fechaNueva2+' 23:59',
						autoclose: true,
						initialDate: fechaNueva2 + " "+fechaNueva3,
						language: 'es'
					});
					timePick3r.val(fechaNueva3);
					
					modificarFechaConcepto($(this),fechaNueva3);
				});
				$(this).val(fecha);
			});
			

			$(".miTimepicker").each(function(){
				let hora = $(this).val();
				$(this).val("");
				$(this).datetimepicker({		
					format: 'hh:00',	            
					minView: 1,				
					maxView: 1,             
					startView:1,
					startDate: fechaActual,
					endDate: fechaActual+' 23:59',
					autoclose: true,
					initialDate: fechaActual + ' '+hora
					,language: 'es'
				});
				$(this).val(hora);
			});
        });

		$('#clickmeSmS').click(function(e){ oTableSerS.draw(); });
		
		$("#beneficio_s").change(function(e){ $('#clickmeSe').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmeSe').click();});
		//Fin servicios
		
		//CONSULTAS
		var oTableCo1 = $('#dataTableBconsultasM').DataTable({
			serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/buscar_consultas.php",
			"fnServerParams": function (aoData, fnCallback) {
				var idPaci = $('#id_paciente_ov').val(), idConvenio = $('#mi_id_convenioS').val();//if(idConvenio==null){idConvenio=0;}
				var aleatorio = $('#aleatorio_ov').val(), idSucursal = $('#sucursal_fi_p').val();
				aoData.push({"name": "idSucursal", "value": idSucursal } ); aoData.push({"name": "idConvenio", "value": idConvenio });
				aoData.push({"name": "aleatorio", "value": aleatorio } ); aoData.push({"name": "idP", "value": idPaci } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "CONSULTAS FILTRADAS: _END_",
				"sInfoEmpty": "NINGUNA CONSULTA FILTRADA.", "sInfoFiltered": " TOTAL DE CONSULTAS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		});
		$('#clickmeCo1').click(function(e){ oTableCo1.draw(); });
		//para los fintros individuales por campo de texto
		oTableCo1.columns().every( function () {
			var that = this; $('input', this.footer()).on('keyup change', function(){ if(that.search() !== this.value){that.search(this.value).draw();} });
		} );
		//fin filtros individuales por campo de texto
		oTableCo1.on( 'select', function ( e, dt, type, indexes ) {
			$('.depende_con1').removeClass('hidden');
			var rowData = oTableCo1.rows( indexes ).data().toArray(); //alert(rowData[0][6]); //alert(rowData[0][9]);
			if(rowData[0][8]==undefined){var coveni = 0, ocu = 0;}else{var coveni = rowData[0][8], ocu = rowData[0][9];}
			subirEstudioC1(rowData[0][4], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(), $('#medico_c1').val(),
				$('#mi_id_convenioC1').val(),$('#sucursal_fi_p').val(),$('#observacionesC1_NV').val(),2,rowData[0][2], 2, coveni, ocu
			); 
			$('.desc_cargo_c1').change(function(e){nota_desc_cargo_c1();}); $('.desc_cargo_c1').keyup(function(e){nota_desc_cargo_c1();});
		} );
		
		var oTableCoS1 = $('#dataTableCmS1').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":camposFechaHora.concat( [{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}]),
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/consultas_seleccionadas.php?agenda="+esAgenda,
			"fnServerParams": function (aoData, fnCallback) {
				var aleatorio = $('#aleatorio_ov').val(); aoData.push({"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "NO SE HA SELECCIONADO NINGUNA CONSULTA", 
				"sInfo": "CONSULTAS FILTRADAS: _END_",
				"sInfoEmpty": "NINGUNA CONSULTA FILTRADA.", "sInfoFiltered": " TOTAL DE CONSULTAS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
        });


        $('#dataTableCmS1').on( 'draw.dt', function () {
			let ahora = new Date();
            let mes = ahora.getMonth()+1;
            let dia = ahora.getDate();
            let fechaActual = ahora.getFullYear() + '-' +(mes<10 ? '0' : '') + mes + '-' +(dia<10 ? '0' : '') + dia;
			
			$(".miDatetimepicker").each(function(){
				let fecha = $(this).val();
				$(this).val("");
				$(this).datetimepicker({			            
					minView: 1,				
					language: 'es',
					format: 'dd/mm/yyyy',
					startDate: fechaActual,
					initialDate: fecha,
					autoclose: true
				}).on('changeDate', function(ev){
					let dateTimePick3r = $(this);
					let timePick3r  = dateTimePick3r.parent().next().children();
					let fechaNueva = ev.date;
					fechaNueva.setHours(fechaNueva.getHours()+10);
					let fechaNueva2 = String(fechaNueva.getFullYear())+"-"+String(fechaNueva.getMonth()+1)+"-"+String(fechaNueva.getDate());
					
					let fechaNueva3 = (fechaNueva.getHours()<10? "0"+String(fechaNueva.getHours()) : String(fechaNueva.getHours()) )  +":00";

					timePick3r.datetimepicker('remove');
					timePick3r.val("");
					timePick3r.datetimepicker({		
						format: 'hh:00',	            
						minView: 1,				
						maxView: 1,             
						startView:1,
						startDate: fechaNueva2,
						endDate: fechaNueva2+' 23:59',
						autoclose: true,
						initialDate: fechaNueva2 + " "+fechaNueva3,
						language: 'es'
					});
					timePick3r.val(fechaNueva3);
					
					modificarFechaConcepto($(this),fechaNueva3);
				});
				$(this).val(fecha);
			});
			

			$(".miTimepicker").each(function(){
				let hora = $(this).val();
				$(this).val("");
				$(this).datetimepicker({		
					format: 'hh:00',	            
					minView: 1,				
					maxView: 1,             
					startView:1,
					startDate: fechaActual,
					endDate: fechaActual+' 23:59',
					autoclose: true,
					initialDate: fechaActual + ' '+hora
					,language: 'es'
				});
				$(this).val(hora);
			});
        });

		$('#clickmeCoS1').click(function(e){ oTableCoS1.draw(); }); $('#t_con').click(function(e){ $('#clickmeCo1,#clickmeCoS1').click(); });
		
		$("#beneficio_c1").change(function(e){ $('#clickmeCo1').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmeCo1').click();});
		//FIN CONSULTAS
		
		//FARMACIA
		/*var oTablePro = $('#dataTableBproductos').DataTable({
			serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/buscar_productos.php",
			"fnServerParams": function (aoData, fnCallback) {
				var idPaci = $('#id_paciente_ov').val(), idConvenio = $('#mi_id_convenioP').val();//if(idConvenio==null){idConvenio=0;}
				var aleatorio = $('#aleatorio_ov').val(), idSucursal = $('#sucursal_fi_p').val();
				aoData.push({"name": "idSucursal", "value": idSucursal } ); aoData.push({"name": "idConvenio", "value": idConvenio });
				aoData.push({"name": "aleatorio", "value": aleatorio } ); aoData.push({"name": "idP", "value": idPaci } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "PRODUCTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN PRODUCTO FILTRADO.", "sInfoFiltered": " TOTAL DE PRODUCTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		});*/
		$('#clickmePr').click(function(e){ oTablePro.draw(); });
		//para los fintros individuales por campo de texto
		oTablePro.columns().every( function () {
			var that = this;
			$('input', this.footer()).on('keyup change',function(){ if(that.search() !== this.value){that .search(this.value) .draw();} });
		} );
		//fin filtros individuales por campo de texto
		oTablePro.on( 'select', function ( e, dt, type, indexes ) {
			$('.depende_pro').removeClass('hidden');
			var rowData = oTablePro.rows(indexes).data().toArray(); //alert(rowData[0][6]); //alert(rowData[0][9]);
			if(rowData[0][8]==undefined){var coveni = 0, ocu = 0;}else{var coveni = rowData[0][8], ocu = rowData[0][9];}
			subirProductoS(rowData[0][4], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(),
				$('#mi_id_convenioP').val(),$('#sucursal_fi_p').val(),$('#observacionesS_NV').val(),3,rowData[0][2], 5, coveni, ocu
			); 
			$('.desc_cargo_p').change(function(e){nota_desc_cargo_p();}); $('.desc_cargo_p').keyup(function(e){nota_desc_cargo_p();});
		} );
		
		var oTableProS = $('#dataTablePS').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/productos_seleccionados.php",
			"fnServerParams": function (aoData, fnCallback) {
				var aleatorio = $('#aleatorio_ov').val();
				aoData.push({"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "NO SE HA SELECCIONADO NINGÚN PRODUCTO", 
				"sInfo": "PRODUCTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGUN PRODUCTO FILTRADO.", "sInfoFiltered": " TOTAL DE PRODUCTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		});
		$('#clickmePS').click(function(e){ oTableProS.draw(); }); $('#t_farm').click(function(e){ $('#clickmePS,#clickmePr').click(); });
		
		$("#beneficio_p").change(function(e){ $('#clickmePr').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmePr').click();});
		//FIN FARMACIA

		if(tipoVisita == 1){ //Esto indica que es agenda
			$("#t_farm").hide() //Oculta la opcion de farmacia
			$("#tFarmacia").hide(); //Oculta el tab de farmacia
			//$("#btn_save1").hide(); //Oculta el boton guardar
		}else{ //Si no es agenda entonces es orden de venta
			$("#t_farm").show() 
			$("#tFarmacia").show();
			//$("#btn_save1").show(); 
		}
		

		$('#myModal4').modal('show');
		$('#myModal4').on('shown.bs.modal', function (e) {
			$('#form-2').validator(); $('#form-2 input').keyup(function(e) { $('#alerta1').hide(); });
			window.setTimeout(function(){$('#clickmeCo1, #clickmeCoS1').click()},200)
		});
		$('#myModal4').on('hidden.bs.modal', function (e) { 
			//if(ref){ window.setTimeout(function(){historialPaciente($('#mi_histo').val());},300); }else{ }
			$(".modal-content").remove(); $("#myModal4").empty();
		});
	//} });
}

function borrarItemNV(idConcepto){//Imagen
	var datosBINV = {idConcepto:idConcepto}
	$.post('pacientes/files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ $('#clickmeEiS,#clickmeIm').click();
		var datos={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_precios_imagen.php',datos).done(function(data){
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_i').val(), ce = $('#cargo_extra_i').val(), dd = $('#da_descuento_i').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_i').val(data);
			if(parseFloat(pd)){ $('#to_descuento_i').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){$('#to_descuento_i').val(dd);}else{$('#to_descuento_i').val(0);}
			calcular_totales();
		});
	} else{alert(data);} });
}
function borrarItemNVL(idConcepto){
	var datosBINV = {idConcepto:idConcepto}
	$.post('pacientes/files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ $('#clickmeElS,#clickmeLa').click();
		var datos={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_precios_laboratorio.php',datos).done(function(data){
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_l').val(), ce = $('#cargo_extra_l').val(), dd = $('#da_descuento_l').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_l').val(data);
			if(parseFloat(pd)){ $('#to_descuento_l').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){$('#to_descuento_l').val(dd);}else{$('#to_descuento_l').val(0);}
			calcular_totales();
		});
	} else{alert(data);} });
}
function borrarItemNVS(idConcepto){
	var datosBINV = {idConcepto:idConcepto}
	$.post('pacientes/files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ $('#clickmeSmS,#clickmeSe').click();
		var datos={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_precios_servicios.php',datos).done(function(data){
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_s').val(), ce = $('#cargo_extra_s').val(), dd = $('#da_descuento_s').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_s').val(data);
			if(parseFloat(pd)){ $('#to_descuento_s').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){$('#to_descuento_s').val(dd);}else{$('#to_descuento_s').val(0);}
			calcular_totales();
		});
	} else{alert(data);} });
}
function borrarItemNVC1(idConcepto){
	var datosBINV = {idConcepto:idConcepto}
	$.post('pacientes/files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ $('#clickmeCo1,#clickmeCoS1').click();
		var datos={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_precios_consultas.php',datos).done(function(data){
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_c1').val(), ce = $('#cargo_extra_c1').val(), dd = $('#da_descuento_c1').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_c1').val(data);
			if(parseFloat(pd)){ $('#to_descuento_c1').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){$('#to_descuento_c1').val(dd);}else{$('#to_descuento_c1').val(0);}
			calcular_totales();
		});
	} else{alert(data);} });
}
function borrarItemNVP(idConcepto){
	var datosBINV = {idConcepto:idConcepto}
	$.post('pacientes/files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ $('#clickmePS,#clickmePr').click();
		var datos={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_precios_productos.php',datos).done(function(data){
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_p').val(), ce = $('#cargo_extra_p').val(), dd = $('#da_descuento_p').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_p').val(data);
			if(parseFloat(pd)){ $('#to_descuento_p').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){$('#to_descuento_p').val(dd);}else{$('#to_descuento_p').val(0);}
			calcular_totales();
		});
	} else{alert(data);} });
}
function subirEstudio(idE, noAleatorio, idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene,ocup){
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), ocupado:ocup
	}
	$.post('pacientes/files-serverside/guardarEstudioNV.php',datosSENV).done(function( data ) { 
		if(data==1){ 
			$('#clickmeIm,#clickmeEiS').click();
			totales_imagen(p, $('#po_descuento_i').val(),$('#da_descuento_i').val(),$('#cargo_extra_i').val());
			calcular_totales();
		}else{alert(data);} 
	});
}
function subirEstudioL(idE,noAleatorio, idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene,ocup){
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), ocupado:ocup
	}
	$.post('pacientes/files-serverside/guardarEstudioNV.php',datosSENV).done(function( data ) { 
		if(data==1){ 
			$('#clickmeLa,#clickmeElS').click();
			totales_laboratorio(p, $('#po_descuento_l').val(),$('#da_descuento_l').val(),$('#cargo_extra_l').val()); calcular_totales();
		}else{alert(data);} 
	});
}
function subirEstudioS(idE,noAleatorio,idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene,ocup){
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), ocupado:ocup
	}
	$.post('pacientes/files-serverside/guardarEstudioNV.php',datosSENV).done(function( data ) { 
		if(data==1){ 
			$('#clickmeSe,#clickmeSmS').click();
			totales_servicios(p, $('#po_descuento_s').val(),$('#da_descuento_s').val(),$('#cargo_extra_s').val());
			calcular_totales();
		}else{alert(data);} 
	});
}
function subirEstudioC1(idE,noAleatorio,idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene,ocup){
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), ocupado:ocup
	}
	$.post('pacientes/files-serverside/guardarEstudioNV.php',datosSENV).done(function( data ) { 
		if(data==1){ $('#clickmeCo1,#clickmeCoS1').click();
			totales_consultas(p, $('#po_descuento_c1').val(),$('#da_descuento_c1').val(),$('#cargo_extra_c1').val()); calcular_totales();
		}else{alert(data);} 
	});
}
function subirProductoS(idE,noAleatorio,idP, idU, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene,ocup){
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), ocupado:ocup
	}
	$.post('pacientes/files-serverside/guardarEstudioNV.php',datosSENV).done(function( data ) { 
		if(data==1){ 
			$('#clickmePr,#clickmePS').click();
			totales_productos(p, $('#po_descuento_p').val(),$('#da_descuento_p').val(),$('#cargo_extra_p').val());
			calcular_totales();
		}else{alert(data);} 
	});
}
function subir_concepto(tipo_c,id_c,id_beneficio,id_p,aleatorio,id_u,id_medico,precio){
	swal({
	  title: "Cargando datos...", text: "", type: "", showCancelButton: false, closeOnConfirm: false, showLoaderOnConfirm: true,
	  showConfirmButton:false
	});
	var datos={tipo_c:tipo_c,id_c:id_c,id_beneficio:id_beneficio,id_p:id_p,aleatorio:aleatorio,id_u:id_u,id_medico:id_medico,precio:precio}
	$.post('pacientes/files-serverside/subirConcepto.php',datos).done(function(data){ if(data==1){swal.close();}else{alert(data);}});
}

function bajar_concepto(id_c){
	swal({
	  title: "Cargando datos...", text: "", type: "", showCancelButton: false, closeOnConfirm: false, showLoaderOnConfirm: true,
	  showConfirmButton:false
	});
	var datos={id_c:id_c}
	$.post('pacientes/files-serverside/bajarConcepto.php',datos).done(function(data){ if(data==1){swal.close();}else{alert(data);}});
}

function cargos_descuentos_c1(v,id){
	$('.desc_cargo_c1').each(function(index, element) {
		if(this.id==id){} else{ if(parseFloat(v)){$('#'+this.id).val(0);} }
		if(id=='po_descuento_c1'){
			if(v<0){$('#po_descuento_c1').val(0);}else if(v>100){$('#po_descuento_c1').val(100);}
			if(!parseFloat(v)){$('#po_descuento_c1').val('');}
		}
		if(id=='da_descuento_c1'){
			if(v<0){$('#da_descuento_c1').val(0);}
			else if(v>parseFloat($('#precio_c1').val())){$('#da_descuento_c1').val(redondear($('#precio_c1').val(),2));}
			if(!parseFloat(v)){$('#da_descuento_c1').val('');}
		}
		if(id=='cargo_extra_c1'){ if(v<0){$('#cargo_extra_c1').val(0);} if(!parseFloat(v)){$('#cargo_extra_c1').val('');} }
		totales_consultas($('#precio_c1').val(), $('#po_descuento_c1').val(), $('#da_descuento_c1').val(), $('#cargo_extra_c1').val());
    });
}
function cargos_descuentos_i(v,id){
	$('.desc_cargo_i').each(function(index, element) {
		if(this.id==id){} else{ if(parseFloat(v)){$('#'+this.id).val(0);} }
		if(id=='po_descuento_i'){
			if(v<0){$('#po_descuento_i').val(0);}else if(v>100){$('#po_descuento_i').val(100);}
			if(!parseFloat(v)){$('#po_descuento_i').val('');}
		}
		if(id=='da_descuento_i'){
			if(v<0){$('#da_descuento_i').val(0);}
			else if(v>parseFloat($('#precio_i').val())){$('#da_descuento_i').val(redondear($('#precio_i').val(),2));}
			if(!parseFloat(v)){$('#da_descuento_i').val('');}
		}
		if(id=='cargo_extra_i'){
			if(v<0){$('#cargo_extra_i').val(0);} if(!parseFloat(v)){$('#cargo_extra_i').val('');}
		}
		totales_imagen($('#precio_i').val(), $('#po_descuento_i').val(), $('#da_descuento_i').val(), $('#cargo_extra_i').val());
    });
}
function cargos_descuentos_l(v,id){
	$('.desc_cargo_l').each(function(index, element) {
		if(this.id==id){} else{ if(parseFloat(v)){$('#'+this.id).val(0);} }
		if(id=='po_descuento_l'){
			if(v<0){$('#po_descuento_l').val(0);}else if(v>100){$('#po_descuento_l').val(100);}
			if(!parseFloat(v)){$('#po_descuento_l').val('');}
		}
		if(id=='da_descuento_l'){
			if(v<0){$('#da_descuento_l').val(0);}
			else if(v>parseFloat($('#precio_l').val())){$('#da_descuento_l').val(redondear($('#precio_l').val(),2));}
			if(!parseFloat(v)){$('#da_descuento_l').val('');}
		}
		if(id=='cargo_extra_l'){
			if(v<0){$('#cargo_extra_l').val(0);} if(!parseFloat(v)){$('#cargo_extra_l').val('');}
		}
		totales_laboratorio($('#precio_l').val(), $('#po_descuento_l').val(), $('#da_descuento_l').val(), $('#cargo_extra_l').val());
    });
}
function cargos_descuentos_s(v,id){
	$('.desc_cargo_s').each(function(index, element) {
		if(this.id==id){} else{ if(parseFloat(v)){$('#'+this.id).val(0);} }
		if(id=='po_descuento_s'){
			if(v<0){$('#po_descuento_s').val(0);}else if(v>100){$('#po_descuento_s').val(100);}
			if(!parseFloat(v)){$('#po_descuento_s').val('');}
		}
		if(id=='da_descuento_s'){
			if(v<0){$('#da_descuento_s').val(0);}
			else if(v>parseFloat($('#precio_s').val())){$('#da_descuento_s').val(redondear($('#precio_s').val(),2));}
			if(!parseFloat(v)){$('#da_descuento_s').val('');}
		}
		if(id=='cargo_extra_s'){
			if(v<0){$('#cargo_extra_s').val(0);} if(!parseFloat(v)){$('#cargo_extra_s').val('');}
		}
		totales_servicios($('#precio_s').val(), $('#po_descuento_s').val(), $('#da_descuento_s').val(), $('#cargo_extra_s').val());
    });
}
function cargos_descuentos_p(v,id){
	$('.desc_cargo_p').each(function(index, element) {
		if(this.id==id){} else{ if(parseFloat(v)){$('#'+this.id).val(0);} }
		if(id=='po_descuento_p'){
			if(v<0){$('#po_descuento_p').val(0);}else if(v>100){$('#po_descuento_p').val(100);}
			if(!parseFloat(v)){$('#po_descuento_p').val('');}
		}
		if(id=='da_descuento_p'){
			if(v<0){$('#da_descuento_p').val(0);}
			else if(v>parseFloat($('#precio_p').val())){$('#da_descuento_p').val(redondear($('#precio_p').val(),2));}
			if(!parseFloat(v)){$('#da_descuento_p').val('');}
		}
		if(id=='cargo_extra_p'){
			if(v<0){$('#cargo_extra_p').val(0);} if(!parseFloat(v)){$('#cargo_extra_p').val('');}
		}
		totales_productos($('#precio_p').val(), $('#po_descuento_p').val(), $('#da_descuento_p').val(), $('#cargo_extra_p').val());
    });
}
function calcular_totales(){
	$('#pago_ov_c, #pago_ov_i, #pago_ov_l, #pago_ov_f').val('');
	if(parseFloat($('#cargo_extra_c').val())){var cargo_extra = $('#cargo_extra_c').val();}else{var cargo_extra = 0;}
	if(parseFloat($('#cargo_extra_i').val())){var cargo_extra_i = $('#cargo_extra_i').val();}else{var cargo_extra_i = 0;}
	if(parseFloat($('#cargo_extra_l').val())){var cargo_extra_l = $('#cargo_extra_l').val();}else{var cargo_extra_l = 0;}
	if(parseFloat($('#cargo_extra_s').val())){var cargo_extra_s = $('#cargo_extra_s').val();}else{var cargo_extra_s = 0;}
	if(parseFloat($('#cargo_extra_p').val())){var cargo_extra_p = $('#cargo_extra_p').val();}else{var cargo_extra_p = 0;}
	if(parseFloat($('#cargo_extra_c1').val())){var cargo_extra_c = $('#cargo_extra_c1').val();}else{var cargo_extra_c = 0;}
	
	$('#total_i').val( parseFloat($('#precio_i').val())+parseFloat(cargo_extra_i)-parseFloat($('#to_descuento_i').val()) );
	$('#total_l').val( parseFloat($('#precio_l').val())+parseFloat(cargo_extra_l)-parseFloat($('#to_descuento_l').val()) );
	$('#total_s').val( parseFloat($('#precio_s').val())+parseFloat(cargo_extra_s)-parseFloat($('#to_descuento_s').val()) );
	$('#total_p').val( parseFloat($('#precio_p').val())+parseFloat(cargo_extra_p)-parseFloat($('#to_descuento_p').val()) );
	$('#total_c1').val( parseFloat($('#precio_c1').val())+parseFloat(cargo_extra_c)-parseFloat($('#to_descuento_c1').val()) );
	
	$('.1total_i').text( parseFloat($('#precio_i').val())+parseFloat(cargo_extra_i)-parseFloat($('#to_descuento_i').val()) );
	$('.1total_l').text( parseFloat($('#precio_l').val())+parseFloat(cargo_extra_l)-parseFloat($('#to_descuento_l').val()) );
	$('.1total_p').text( parseFloat($('#precio_p').val())+parseFloat(cargo_extra_p)-parseFloat($('#to_descuento_p').val()) );
	$('.1total_s').text(  );
	$('.1total_c1').text( parseFloat($('#precio_c1').val())+parseFloat(cargo_extra_c)-parseFloat($('#to_descuento_c1').val()) +parseFloat($('#precio_s').val())+parseFloat(cargo_extra_s)-parseFloat($('#to_descuento_s').val()) );
	
	if($('.1total_c1').text()<0.0001){ $('#pago_ov_c').val(0); }else{$('#pago_ov_c').val('');}
	if($('.1total_i').text()<0.0001){ $('#pago_ov_i').val(0); }else{$('#pago_ov_i').val('');}
	if($('.1total_l').text()<0.0001){ $('#pago_ov_l').val(0); }else{$('#pago_ov_l').val('');}
	if($('.1total_p').text()<0.0001){ $('#pago_ov_f').val(0); }else{$('#pago_ov_f').val('');}
	
	$('.total_imagen').text('$'+redondear($('#precio_i').val(),2));
	$('.total_laboratorio').text('$'+redondear($('#precio_l').val(),2));
	$('.total_servicios').text('$'+redondear($('#precio_s').val(),2));
	$('.total_productos').text('$'+redondear($('#precio_p').val(),2));
	$('.total_consulta').text('$'+redondear($('#precio_c1').val(),2));
	$('#subtotal_ov').text('$'+redondear(parseFloat($('#precio_i').val())+parseFloat($('#precio_l').val())+parseFloat($('#precio_s').val())+parseFloat($('#precio_p').val())+parseFloat($('#precio_c1').val()),2));
	$('#extras_ov').text('+ $'+redondear(parseFloat(cargo_extra)+parseFloat(cargo_extra_i)+parseFloat(cargo_extra_l)+parseFloat(cargo_extra_s)+parseFloat(cargo_extra_p)+parseFloat(cargo_extra_c),2));
	$('#descuento_ov').text('- $'+redondear(parseFloat($('#to_descuento_i').val())+parseFloat($('#to_descuento_l').val())+parseFloat($('#to_descuento_s').val())+parseFloat($('#to_descuento_p').val())+parseFloat($('#to_descuento_c1').val()),2));
	$('#iva_ov').text('+ $'+redondear($('#iva_ov_h').val(),2));
	$('#total_ov').text('$'+redondear(parseFloat($('#precio_c1').val())+parseFloat($('#precio_i').val())+parseFloat($('#precio_l').val())+parseFloat($('#precio_s').val())+parseFloat($('#precio_p').val())+parseFloat(cargo_extra_c)+parseFloat(cargo_extra_i)+parseFloat(cargo_extra_l)+parseFloat(cargo_extra_s)+parseFloat(cargo_extra_p)-parseFloat($('#to_descuento_c1').val())-parseFloat($('#to_descuento_i').val())-parseFloat($('#to_descuento_l').val())-parseFloat($('#to_descuento_s').val())-parseFloat($('#to_descuento_p').val())+parseFloat($('#iva_ov_h').val()),2));
	$('#total_ov_h').val(redondear(parseFloat($('#precio_c1').val())+parseFloat($('#precio_i').val())+parseFloat($('#precio_l').val())+parseFloat($('#precio_s').val())+parseFloat($('#precio_p').val())+parseFloat(cargo_extra_c)+parseFloat(cargo_extra_i)+parseFloat(cargo_extra_l)+parseFloat(cargo_extra_s)+parseFloat(cargo_extra_p)-parseFloat($('#to_descuento_c1').val())-parseFloat($('#to_descuento_i').val())-parseFloat($('#to_descuento_l').val())-parseFloat($('#to_descuento_s').val())-parseFloat($('#to_descuento_p').val())+parseFloat($('#iva_ov_h').val()),2));
	window.setTimeout(function(){
		if($('#precio_c1').val()>0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_consulta.php',datos).done(function(data){
				var dato = data.split('{:;]}');
				$('#aqui_consulta').html(data);
			});
		}else{ $('#aqui_consulta').html(''); }
		if($('#precio_i').val()>0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_imagen.php',datos).done(function(data){ $('#aqui_imagen').html(data); });
		}else{ $('#aqui_imagen').html(''); }
		if($('#precio_l').val()>0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_laboratorio.php',datos).done(function(data){
				$('#aqui_laboratorio').html(data);
			});
		}else{ $('#aqui_laboratorio').html(''); }
		if($('#precio_s').val()>0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_servicios.php',datos).done(function(data){ $('#aqui_servicios').html(data); });
		}else{ $('#aqui_servicios').html(''); }
		if($('#precio_p').val()>0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_productos.php',datos).done(function(data){ $('#aqui_productos').html(data); });
		}else{ $('#aqui_productos').html(''); }
	},500);
}
function totales_servicios(precio, pd, dd, ce){ //alert(precio+';'+pd+';'+dd+';'+ce);
	if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();} 
	if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
	if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;} //$('#precio_i, #total_i').val(precio);
	//Sumar los precios
	var datos={aleatorio:$('#aleatorio_ov').val()}
	$.post('pacientes/files-serverside/sumar_precios_servicios.php',datos).done(function(data){
		if(!parseFloat(data)){data=0;}else{data=data;}
		$('#precio_s').val(data);
		if(parseFloat(pd)){ $('#to_descuento_s').val( (parseFloat(data)*parseFloat(pd))/100 ); }
		else if(parseFloat(dd)){$('#to_descuento_s').val(dd);}else{$('#to_descuento_s').val(0);}
		calcular_totales();
	});
}
function totales_consultas(precio, pd, dd, ce){ //alert(precio+';'+pd+';'+dd+';'+ce);
	if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();} 
	if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
	if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;} //$('#precio_i, #total_i').val(precio);
	//Sumar los precios
	var datos={aleatorio:$('#aleatorio_ov').val()}
	$.post('pacientes/files-serverside/sumar_precios_consultas.php',datos).done(function(data){
		if(!parseFloat(data)){data=0;}else{data=data;}
		$('#precio_c1').val(data);
		if(parseFloat(pd)){ $('#to_descuento_c1').val( (parseFloat(data)*parseFloat(pd))/100 ); }
		else if(parseFloat(dd)){$('#to_descuento_c1').val(dd);}else{$('#to_descuento_c1').val(0);}
		calcular_totales();
	});
}
function totales_productos(precio, pd, dd, ce){ //alert(precio+';'+pd+';'+dd+';'+ce);
	if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();} 
	if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
	if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;} //$('#precio_i, #total_i').val(precio);
	//Sumar los precios
	var datos={aleatorio:$('#aleatorio_ov').val()}
	$.post('pacientes/files-serverside/sumar_precios_productos.php',datos).done(function(data){
		if(!parseFloat(data)){data=0;}else{data=data;}
		$('#precio_p').val(data);
		if(parseFloat(pd)){ $('#to_descuento_p').val( (parseFloat(data)*parseFloat(pd))/100 ); }
		else if(parseFloat(dd)){$('#to_descuento_p').val(dd);}else{$('#to_descuento_p').val(0);}
		calcular_totales();
	});
}
function totales_imagen(precio, pd, dd, ce){ //alert(precio+';'+pd+';'+dd+';'+ce);
	if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();} 
	if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
	if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;} //$('#precio_i, #total_i').val(precio);
	//Sumar los precios
	var datos={aleatorio:$('#aleatorio_ov').val()}
	$.post('pacientes/files-serverside/sumar_precios_imagen.php',datos).done(function(data){
		if(!parseFloat(data)){data=0;}else{data=data;}
		$('#precio_i').val(data);
		if(parseFloat(pd)){ $('#to_descuento_i').val( (parseFloat(data)*parseFloat(pd))/100 ); }
		else if(parseFloat(dd)){$('#to_descuento_i').val(dd);}else{$('#to_descuento_i').val(0);}
		calcular_totales();
	});
}
function totales_laboratorio(precio, pd, dd, ce){ //alert(precio+';'+pd+';'+dd+';'+ce);
	if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();} 
	if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
	if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;} //$('#precio_i, #total_i').val(precio);
	//Sumar los precios
	var datos={aleatorio:$('#aleatorio_ov').val()}
	$.post('pacientes/files-serverside/sumar_precios_laboratorio.php',datos).done(function(data){
		if(!parseFloat(data)){data=0;}else{data=data;}
		$('#precio_l').val(data);
		if(parseFloat(pd)){ $('#to_descuento_l').val( (parseFloat(data)*parseFloat(pd))/100 ); }
		else if(parseFloat(dd)){$('#to_descuento_l').val(dd);}else{$('#to_descuento_l').val(0);}
		calcular_totales();
	});
}

function totales_consulta(precio_c, pd, dd, ce){ //alert(precio_c+';'+pd+';'+dd+';'+ce);
	if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();} 
	if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
	if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	$('#precio_c, #total_c').val(precio_c); //$('#to_descuento_c, .desc_cargo').val(0);
	if(parseFloat(pd)){ $('#to_descuento_c').val( (parseFloat($('#precio_c').val())*parseFloat(pd))/100 ); }
	else if(parseFloat(dd)){$('#to_descuento_c').val(dd);}else{$('#to_descuento_c').val(0);}
	calcular_totales();
}

function reset_totales_consulta(){
	bajar_concepto($('#id_consulta_to').val());
	$('#precio_c, #to_descuento_c, #total_c, .desc_cargo').val(0); $('#id_consulta_to').val('');
	if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();} 
}

function nota_desc_cargo_c1(){ var i = 0;
	$('.desc_cargo_c1').each(function(index, element) { if($(this).val()>0){i++;} });
	if(i>0){$('.depende_descuento_c1').removeClass('hidden');}else{$('.depende_descuento_c1').addClass('hidden');}
}
function nota_desc_cargo_i(){ var i = 0;
	$('.desc_cargo_i').each(function(index, element) { if($(this).val()>0){i++;} });
	if(i>0){$('.depende_descuento_i').removeClass('hidden');}else{$('.depende_descuento_i').addClass('hidden');}
}
function nota_desc_cargo_l(){ var i = 0;
	$('.desc_cargo_l').each(function(index, element) { if($(this).val()>0){i++;} });
	if(i>0){$('.depende_descuento_l').removeClass('hidden');}else{$('.depende_descuento_l').addClass('hidden');}
}
function nota_desc_cargo_s(){ var i = 0;
	$('.desc_cargo_s').each(function(index, element) { if($(this).val()>0){i++;} });
	if(i>0){$('.depende_descuento_s').removeClass('hidden');}else{$('.depende_descuento_s').addClass('hidden');}
}
function nota_desc_cargo_p(){ var i = 0;
	$('.desc_cargo_p').each(function(index, element) { if($(this).val()>0){i++;} });
	if(i>0){$('.depende_descuento_p').removeClass('hidden');}else{$('.depende_descuento_p').addClass('hidden');}
}
function su_pago_a(v,id){
	if(parseFloat(v)=='' || parseFloat(v)<0){$('#'+id).val(0);} if(!parseFloat(v)){if(parseFloat(v)==''){}else{$('#'+id).val('');}}
	if(parseFloat(v)>parseFloat($('#1total_c1').text())){$('#'+id).val(parseFloat($('#1total_c1').text()));}
}
function su_pago_i(v,id){
	if(parseFloat(v)=='' || parseFloat(v)<0){$('#'+id).val(0);} if(!parseFloat(v)){if(parseFloat(v)==''){}else{$('#'+id).val('');}}
	if(parseFloat(v)>parseFloat($('#1total_i').text())){$('#'+id).val(parseFloat($('#1total_i').text()));}
}
function su_pago_l(v,id){
	if(parseFloat(v)=='' || parseFloat(v)<0){$('#'+id).val(0);} if(!parseFloat(v)){if(parseFloat(v)==''){}else{$('#'+id).val('');}}
	if(parseFloat(v)>parseFloat($('#1total_l').text())){$('#'+id).val(parseFloat($('#1total_l').text()));}
}
function su_pago_p(v,id){
	if(parseFloat(v)=='' || parseFloat(v)<0){$('#'+id).val(0);} if(!parseFloat(v)){if(parseFloat(v)==''){}else{$('#'+id).val('');}}
	if(parseFloat(v)>parseFloat($('#1total_p').text())){$('#'+id).val(parseFloat($('#1total_p').text()));}
}

function historialPaciente(dataH){
	$('#mi_histo').val(dataH); var dataHV = dataH.split(';]{'); var idP = dataHV[0]; var nombreP = dataHV[1];//alert(idP);
	$("#myModal2").load("pacientes/htmls/historial_visitas.php", function(response,status,xhr){ if(status == "success"){
		$('#titulo_modal').text('HISTORIAL DE VISITAS DE '+nombreP);
		
		$('#facturados').click(function(e) {
			if($(this).prop('checked')==true){ $('#miFacturados').val('1'); $('#clickme_hv').click(); }
			else{ $('#miFacturados').val('0,1'); $('#clickme_hv').click(); }
		});
		$('#saldazos').click(function(e) {
			if($(this).prop('checked')==true){ $('#miSaldazos').val('1'); $('#clickme_hv').click(); }
			else{ $('#miSaldazos').val('0'); $('#clickme_hv').click(); }
		});
		
		var hH = $('#referencia').height()-250;
		var oTableHV = $('#dataTableHistorial').DataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
			"bProcessing" : false,"bDestroy" : true,"bAutoWidth" : false,"sScrollY": hH, "bScrollCollapse": false,
			"bSort" : false, "bStateSave": false, "bInfo": false, "bFilter": false, 
			"aaSorting": [[1, "asc"]],"paging": false, ordering: false, "bJQueryUI": false,
			"aoColumns": [
				{ "class": "details-control","bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false },
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false } 
			],
			"iDisplayLength": 500, "bLengthChange": false, "bServerSide": true, 
			"sAjaxSource": "pacientes/datatable-serverside/historial_visitas.php", 
			"fnServerParams": function (aoData, fnCallback) { 
				var idPaciente = idP; aoData.push(  {"name": "idPac", "value": idPaciente } );
				var facturado = $('#miFacturados').val(); aoData.push(  {"name": "facturado", "value": facturado } );
				var zaldazos = $('#miSaldazos').val(); aoData.push(  {"name": "zaldazos", "value": zaldazos } );
			},
			"sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage": { 
				"sLengthMenu": "MONSTRANDO _MENU_ records per page",
				"sZeroRecords": "EL PACIENTE NO CUENTA CON HISTORIAL DE VISITAS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>VISITAS: _MAX_", "sSearch": "BUSCAR" }
		});$('#clickme_hv').click(function(e) { oTableHV.draw(); });
		
		// Array to track the ids of the details displayed rows
		var detailRows = [];
	 
		$('#dataTableHistorial tbody').on( 'click', 'tr td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = oTableHV.row( tr );
			var idx = $.inArray( tr.attr('id'), detailRows );
	 		
			if ( row.child.isShown() ) {
				tr.removeClass( 'details' );
				row.child.hide();
				// Remove from the 'open' array
				detailRows.splice( idx, 1 );
			}
			else {
				tr.addClass( 'details' );
				var datoDHV ={ ref:row.data()[20] }
				$.post('pacientes/datatable-serverside/datosAdicionalesHV.php',datoDHV).done(function(data){
					row.child( format( data ) ).show();
				});
	
				// Add to the 'open' array
				if ( idx === -1 ) { detailRows.push( tr.attr('id') ); }
			}
		} );
	 
		// On each draw, loop over the `detailRows` array and show any child rows
		oTableHV.on( 'draw', function(){ $.each( detailRows, function(i, id){ $('#'+id+' td.details-control').trigger( 'click' ); }); });
				
		$('#myModal2').modal('show');
		$('#myModal2').on('shown.bs.modal', function (e){ });
		$('#myModal2').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal2").empty(); });
	} });//fin de load
}
function format(d){ //alert(d[2]);
	return d;
}
function CancelItem(id, ref, concept){ //id es el id de vc
	swal({
	  title: "ELIMINAR EL CONCEPTO", text: "Esta acción no se puede deshacer", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
		var datos = {id:id}
		$.post('pacientes/files-serverside/eliminarItemOV.php',datos).done(function( data ) { if (data==1){
			$('#clickme_hv').click();
			swal({ title: "", type: "success", text: "El concepto ha sido eliminado.", timer: 1800, showConfirmButton: false });
		} else{alert(data);} });
	});
}

function ubicacion(ubi){	
	var geocoder = new google.maps.Geocoder(), address = ubi;

	geocoder.geocode({'address': address}, function(results, status) { 
		if (status === google.maps.GeocoderStatus.OK) {//alert(results[0].address_components);
			if(results[0].address_components[6]){$('#cp_us').val(results[0].address_components[6].long_name);}
			var l_n = String(results[0].geometry.location), l_n1 = l_n.split(',');
			var lat1 = l_n1[0].split('('), lon1 = l_n1[1].split(')'); //alert(lat1[1]+', '+lon1[0]);

			var map = new google.maps.Map(document.getElementById('map'), {
				center: new google.maps.LatLng(lat1[1], lon1[0]), zoom: 16, scrollwheel: false //Cuautla :3
			});
			marker = new google.maps.Marker({
				map:map, draggable: true, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(lat1[1], lon1[0])
			});
			
			$('#lat_us').text(redondear(lat1[1],4)); $('#lati_ud').val(lat1[1]);
			$('#lon_us').text(redondear(lon1[0],4)); $('#long_ud').val(lon1[0]);
			
			marker.addListener('dragend', function(){
				map.panTo(marker.getPosition());
				var markerLatLng = marker.getPosition();
				$('#lat_us').text(redondear(markerLatLng.lat(),4)); $('#lati_ud').val(markerLatLng.lat());
				$('#lon_us').text(redondear(markerLatLng.lng(),4)); $('#long_ud').val(markerLatLng.lng());
			});
		} //else { alert('Geocode was not successful for the following reason: ' + status); }
	});
}
function cancelar_ov(idVC,nombreP,refe){
	$('#pacienteCancelOV').text(nombreP); $('#refCancelOV').text(refe);
	swal({
	  title: "CANCELAR LA ORDEN DE VENTA "+refe, text: "¿Estás seguro de cancelar la orden?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Cancelarla", 
	  cancelButtonText: "Cerrar", closeOnConfirm: false
	},
	function(){
	  var datosCOV = {refe:refe}
		$.post('pacientes/files-serverside/cancelarOV.php',datosCOV).done(function( data ) { 
			if (data==1){ window.setTimeout(function(){$('#clickme_hv, #clickme').click();},300);
				swal({
				  title: "", type: "success", text: "La orden de venta se ha cancelado", timer: 2000, showConfirmButton: false
				}); return;
			} else{alert(data);} 
		});
	});
}

function initMap() { }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbPi4G3-wjEbEt_77OmTBhxWvmR23ds9Q&signed_in=true&callback=initMap"
	async defer>
</script>