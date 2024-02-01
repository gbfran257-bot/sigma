<?php
	include_once 'recursos/session.php';
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'recursos/datauser.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING JESUS DIAZ CONTRERAS">
    
    <title>SISTEMA - ENFERMERÍA</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">

    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8"></script>
    <script src='tinymce/tinymce.min.js'></script>
    <script src='c3/c3.min.js'></script>
    <script src='c3/d3/d3.min.js'></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script> 
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
    <link href="c3/c3.css" rel="stylesheet">

	<!--Select2-->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="js/select2Gen.js"></script>

	<style>
		/* Estilo necesario para que se muestre el select2 en el modal */
		.select2-container {
			z-index: 9999;
		}
	</style>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">REFERENCIA</th>
    <th style="vertical-align:middle;">PACIENTE</th>
    <th style="vertical-align:middle;">CONCEPTO</th>
    <th style="vertical-align:middle;">ESTATUS</th>
    <th style="vertical-align:middle;">SUCURSAL</th>
    <th style="vertical-align:middle;">FUTSV</th>
    <th style="vertical-align:middle;">FUTHC</th>
    <th style="vertical-align:middle;">DEPARTAMENTO</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot> <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Referencia" style="max-width:100px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Paciente"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Concepto"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Estatus"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Sucursal"/></th>
            <th></th>
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Departamento"/></th>
    </tr> </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li class="active"><strong>ENFERMERÍA</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-149-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true},{"bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "enfermeria/datatable-serverside/consultas.php?idU="+$('#id_user').val(),
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val();
			var de = $('#fechaDe').val()+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
			var accesoU = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } );
			aoData.push(  {"name": "accesoU", "value": accesoU } );
			aoData.push(  {"name": "idU", "value": idU } );
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SERVICIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 50000, paging: false,
	});
	
	$('#clickme').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#clickme').click();},500);
	
	//para los fintros individuales por campo de texto
	oTableP.columns().every( function () {
		var that = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
		} );
	} );
	//fin filtros individuales por campo de texto
	$('#top-search').keyup(function(e) {
        $('#dataTablePrincipal_filter input').val($(this).val()); $('#dataTablePrincipal_filter input').keyup();
    }).focus();
	$('.filtro1Principal').addClass('hidden');
	
	$('.infoPrincipal').append('<div id="divRangoFechas" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">De &nbsp;</td> <td width="1%"> <input name="fechaDe" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly> </td> <td id="rangosFechas">&nbsp; <input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');
	
	$('#radio1').click(function(e){
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>');$('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#radio2').click(function(e){
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#fechaDe').on('changeDate', function(e) { oTableP.draw(); });
	$("#fechaA").on('changeDate', function(e) { oTableP.draw(); });
});

function verSignosV(idP,idC,opc,concept,id_s,estat, idH){
	var datosCon = {idP:idP, idC:idC}
	const datosCC = { id_vc: idC };
	$.post('enfermeria/files-serverside/datosSV.php',datosCon).done(function(data){var datos=data.split(';*-');
		$("#myModalx").load('consultas/htmls/ficha_consulta.php',function(response,status,xhr){ if(status=="success"){
			$('#titulo_modal').text('PACIENTE: '+datos[22]+' - EDAD: '+datos[1]+' - SEXO: '+datos[2]+' | FECHA: '+datos[24]);
			$('#idUsuario_hc').val($('#id_user').val()); $('#id_cons').val(idC); $('#idPaciente_c').val(idP);
			$('.hsh, .btns-consulta').remove(); 
			window.setTimeout(function(){ if(opc==0){$('#tab_sv_1').click();} else if(opc==1){$('#tab_my_hc_x').click();} },500);
			
			//bloqueamos los campos que no son necesarios mantener abiertos para edición
			$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro').prop('readonly','readonly');
			$('.escala_g').prop('disabled','disabled');
			
			$('#print_SignosV').click(function(e) { 
				imprimirSV(idP,idC, idC);
			});

			$('#b_agregarSignosC').click(function(e) { tomar_sv(idP,2,idC, id_s); });
			
			// Se replica la funcionalidad para mostrar el modal que permite hospitalizar a un paciente
			$('#hospitalizarP').click(function(e) {
				$("#myModal1").load('consultas/htmls/selecciona_cama.php', function(response, status, xhr) {
					if (status == "success") {
						// $("#myModal1").attr('tabindex', 2);
						$('#titulo_modal').text('SELECCIONA UNA CAMA DEL HOSPITAL');

						$('#form-selecciona-cama').validator().on('submit', function(e) {
							if (e.isDefaultPrevented()) { // handle the invalid form...
							} else { // everything looks good!
								e.preventDefault();
								var datosP = $('#myModal1 #form-selecciona-cama').serialize();
								datosP += "&idP=" + idP + "&idU=" + $("#id_user").val() + "&id_vc=" + idC;

								// Aqui ya se hospitaliza
								$.post('consultas/files-serverside/check_hospitalizado.php', datosCC).done(function(data) {
									if (data < 1) {
										swal({
											title: "",
											text: "¿Desea hospitalizar a éste paciente?",
											buttons: {
												confirm: {
													text: "Hospitalizar",
													closeModal: false,
												},
												cancel: {
													text: "Cancelar",
													visible: true,
													className: "hospitalizar_cancel-button"
												}
											},
											type: "warning",
										}, (isConfirmed) => {
											if (isConfirmed) {
												setTimeout(() => {
													$.post("consultas/files-serverside/hospitalizar.php", datosP).done((data) => {
														if (data == 1) {
															swal("¡HECHO!", "Paciente hospitalizacion correctamente", "success");
															$("#myModal1").modal("hide");
														}
													});
												}, 400);
											}
										});
									} else {
										swal({
											title: "No se puede hospitalizar",
											type: "error",
											text: "El paciente ya se encuentra hospitalizado.",
											timer: 1800,
											buttons: false
										});
										$('#hospitalizarP').remove();
									}
								});
							}
						});

						$('#myModal1').modal('show');
						$('#myModal1').on('shown.bs.modal', function(e) {
							$('#form-selecciona-cama').validator();
						});
						$('#myModal1').on('hidden.bs.modal', function(e) {
							$("#myModal1 .modal-content").remove();
							$("#myModal1").empty();
						});
					}
				});
			});

			$('#hospitalizarP2').click(function(e){
				$("#myModal1").load('consultas/htmls/selecciona_cama.php', function(response, status, xhr){ if(status=="success"){
					
					var select_cama = $("#id_cama_h");
					var select_medico = $("#id_medico_t");

					select_cama.removeAttr("required");
					select_medico.removeAttr("required");

					select_cama.prop("disabled", true);
					select_medico.prop("disabled", true);

					$('#form-selecciona-cama').validator().on('submit', function (e) {

						if (e.isDefaultPrevented()) { // handle the invalid form...
						} else { // everything looks good!
							e.preventDefault(); 
							//var datosP = $('#myModal1 #form-selecciona-cama').serialize();

							datosPrevios = { 
								idP:idP, 
								idU:$('#id_user').val(), 
								id_vc:idC, 
								motivo_h: $('#motivo_h').val()
							}
							$.post('consultas/files-serverside/insert_datos_prev_hosp.php',datosPrevios).done(function(data_dph){
								if(data_dph==1){
									swal({title:"¡Listo!",type:"success",text:"Se ha registrado la solicitud de hospitalización para el paciente " + datos[22], timer: 2000, showConfirmButton: false });
									$('#myModal1').modal('hide');
								}else if(data_dph==2){
									swal({title:"Alerta!!",type:"warning",text:"Ya existe(o existio) una petición para este paciente", timer: 2000, showConfirmButton: false });
									$('#myModal1').modal('hide');
								}
							});

						}

					});

					$('#myModal1').modal('show');
					$('#myModal1').on('shown.bs.modal', function(e){ $('#form-selecciona-cama').validator(); });
					$('#myModal1').on('hidden.bs.modal', function(e){ $("#myModal1 .modal-content").remove(); $("#myModal1").empty(); });
				}});
			});

			//Cargamos los datos de los Signos Vitales y Cargamos los datos de Historia Clínica
			cargar_todo_signos_vitales(idP,idC); cargar_todo_historia_clinica(idP,idC,id_s);
											
			$('#myModalx').modal('show');
			$('#myModalx').on('shown.bs.modal', function (e) { $('#form-ficha_us').validator(); 
				$('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
			});
			$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
		} });
	});
}

function cargar_todo_signos_vitales(idP,idC){
	var datosCon = {idP:idP, idC:idC}
	$.post('enfermeria/files-serverside/datosSV.php',datosCon).done(function(data){var datos=data.split(';*-');
		$('#usuario_svi, #usuario_svi1').text(datos[23]); $('#fechaSignosC, #fechaHoraC').text(datos[13]); $('#oxiSV').val(datos[17]);
		if( !parseFloat(datos[18]) || !parseFloat(datos[19]) || !parseFloat(datos[20])){
			$('#ocular_val').text(''); $('#verbal_val').text(''); $('#motriz_val').text('');
			$('#respuesta_motriz').val(0); $('#abertura_ocular').val(0); $('#respuesta_verbal').val(0);
			$('#total_escala_g').text(''); $('#row_texto_puntuacion_g').addClass('hidden');
		}else{
			$('#ocular_val').text(datos[18]); $('#verbal_val').text(datos[19]); $('#motriz_val').text(datos[20]);
			$('#respuesta_motriz').val(datos[20]); $('#abertura_ocular').val(datos[18]); $('#respuesta_verbal').val(datos[19]);
			$('#total_escala_g').text(parseInt(datos[18])+parseInt(datos[19])+parseInt(datos[20]));
			$('#row_texto_puntuacion_g').removeClass('hidden');
		}
		
		$('#pesoSV').val(datos[3]);$('#tallaSV').val(datos[4]);$('#imcSV').val(datos[5]);
		$('#cinturaSV').val(datos[6]); $('#tSV').val(datos[7]);$('#aSV').val(datos[8]);
		$('#frSV').val(datos[9]);$('#fcSV').val(datos[10]);$('#tempSV').val(datos[11]);$('#notasSV').val(datos[12]);
		$('#miIMC').text(datos[5]); $('#miMedidaCintura').text(datos[6]); $('#dtxis').val(datos[25]);
		
		$('#fc0').text(datos[10]); $('#fr0').text(datos[9]); $('#t0').text(datos[7]); $('#ta0').text(datos[8]);
		$('#temp0').text(datos[11]); $('#peso0').text(datos[3]); $('#talla0').text(datos[4]); $('#imc0').text(datos[5]);
		
		//checamos los valores normales de los SV para poner u ocultar su *
		var datosFC = {idP:idP, idC:idC}
		$.post('consultas/files-serverside/datosChartsFC1.php',datosFC).done(function(data){ var datoFC = data.split(';*');
			  if($('#fc0').text()>=datoFC[5] & $('#fc0').text()<=datoFC[6]){ $('#aFC').hide(); }else{$('#aFC').show();}
			  if($('#fr0').text()>=datoFC[8] & $('#fr0').text()<=datoFC[9]){ $('#aFR').hide(); }else{$('#aFR').show();}
			  if($('#t0').text()>=datoFC[11] & $('#t0').text()<=datoFC[12]){ $('#aT').hide(); }else{$('#aT').show();}
			  if($('#ta0').val()>=datoFC[14] & $('#ta0').val()<=datoFC[15]){ $('#aTA').hide(); }else{$('#aTA').show();}
			  if($('#temp0').text()>=36.5 & $('#temp0').text()<=37.5){$('#aTEMP').hide();}else{$('#aTEMP').show();}
			  if($('#imc0').text()>=18.5 & $('#imc0').text()<=24.9){ $('#aIMC').hide(); } else{$('#aIMC').show();}
		});
		//Fin checamos los valores normales de los SV para poner u ocultar su *
		
		//Riesgos
		if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
			$('.normalIMC').addClass('bg-danger'); $('#miRiesgoP').text('no está en riesgo latente');
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('.imc_1_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('.imc_1_2').addClass('bg-danger'); }
				else{$('.imc_1_1, .imc_1_2').removeClass('bg-danger');}
			}else if(datos[2]=='MASCULINO')
			{
				if( $('#cinturaSV').val() < 90 ){ $('.imc_1_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('.imc_1_2').addClass('bg-danger'); }
				else{$('.imc_1_1, .imc_1_2').removeClass('bg-danger');}
			}
		} 
		else if( $('#imcSV').val() >= 25 & $('#imcSV').val() < 30 ){
			$('.sobrepesoIMC').addClass('bg-danger'); $('#miRiesgoP').text('tiene riesgo moderado');
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('.imc_2_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('.imc_2_2').addClass('bg-danger'); }
				else{$('.imc_2_1, .imc_2_2').removeClass('bg-danger');}
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('.imc_2_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('.imc_2_2').addClass('bg-danger'); }
				else{$('.imc_2_1, .imc_2_2').removeClass('bg-danger');}
			}
		} 
		else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
			$('.obesidad1IMC').addClass('bg-danger'); $('#miRiesgoP').text('tiene riesgo alto');
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('.imc_3_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('.imc_3_2').addClass('bg-danger'); }
				else{$('.imc_3_1, .imc_3_2').removeClass('bg-danger');}
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('.imc_3_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('.imc_3_2').addClass('bg-danger'); }
				else{$('.imc_3_1, .imc_3_2').removeClass('bg-danger');}
			}
		} 
		else if( $('#imcSV').val() >= 35 & $('#imcSV').val() < 40 ){
			$('.obesidad2IMC').addClass('bg-danger'); $('#miRiesgoP').text('tiene riesgo muy alto');
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('.imc_3_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('.imc_3_2').addClass('bg-danger'); }
				else{$('.imc_3_1, .imc_3_2').removeClass('bg-danger');}
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('.imc_3_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('.imc_3_2').addClass('bg-danger'); }
				else{$('.imc_3_1, .imc_3_2').removeClass('bg-danger');}
			}
		} 
		else if( $('#imcSV').val() >= 40 ){
			$('.obesidad3IMC').addClass('bg-danger'); $('#miRiesgoP').text('tiene riesgo extremadamente alto');
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('.imc_4_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('.imc_4_2').addClass('bg-danger'); }
				else{$('.imc_4_1, .imc_4_2').removeClass('bg-danger');}
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('.imc_4_1').addClass('bg-danger'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('.imc_4_2').addClass('bg-danger'); }
				else{$('.imc_4_1, .imc_4_2').removeClass('bg-danger');}
			}
		} else{$('.sobrepesoIMC').removeClass('bg-danger'); }

		if( $('#imcSV').val() >= 18.5 & $('#imcSV').val() < 25 ){
			$('#recomendacionRN').show(); $('#recomendacionSP, #recomendacionOB').hide();
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('sin riesgo'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('#miRiesgoE').text('con riesgo alto'); } 
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('sin riesgo'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('#miRiesgoE').text('con riesgo alto'); } 
			}
		} 
		else if( $('#imcSV').val() >= 25 & $('#imcSV').val() < 30 ){
			$('#recomendacionSP').show(); $('#recomendacionRN, #recomendacionOB').hide();
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con riesgo moderado'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('#miRiesgoE').text('con riesgo alto'); }
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con riesgo moderado'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('#miRiesgoE').text('con riesgo alto'); }
			}
		} 
		else if( $('#imcSV').val() >= 30 & $('#imcSV').val() < 35 ){
			$('#recomendacionOB').show(); $('#recomendacionRN, #recomendacionSP').hide();
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con alto a muy alto riesgo'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('#miRiesgoE').text('con muy alto riesgo'); }
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con alto a muy alto riesgo'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('#miRiesgoE').text('con muy alto riesgo'); }
			}
		} 
		else if( $('#imcSV').val() >= 35 & $('#imcSV').val() < 40 ){
			$('#recomendacionOB').show(); $('#recomendacionRN, #recomendacionSP').hide();
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con alto a muy alto riesgo'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('#miRiesgoE').text('con muy alto riesgo'); }
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con alto a muy alto riesgo'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('#miRiesgoE').text('con muy alto riesgo'); }
			}
		} 
		else if( $('#imcSV').val() >= 40 ){
			$('#recomendacionOB').show(); $('#recomendacionRN, #recomendacionSP').hide();
			if(datos[2]=='FEMENINO'){
				if( $('#cinturaSV').val() < 80 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); }
				else if( $('#cinturaSV').val() >= 80 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); } 
			}else if(datos[2]=='MASCULINO'){
				if( $('#cinturaSV').val() < 90 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); }
				else if( $('#cinturaSV').val() >= 90 ){ $('#miRiesgoE').text('con  riesgo extremadamente alto'); }
			}
		}
		//Riesgos
		
		//Historial sv
		var oTableSV;
		oTableSV = $('#dataTableSV').DataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  },
			ordering: false, scrollCollapse: false, "scrollX": true,
			"destroy": true, "bRetrieve": true, "sScrollY": $('#myModalx').height()*0.48, "bAutoWidth": true, 
			"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
			"aoColumns":[
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }
			],
			"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": true, serverSide: true,
			"sAjaxSource": "consultas/datatable-serverside/signos_vitales.php",
			"fnServerParams": function (aoData, fnCallback) { var idPa = idP; aoData.push(  {"name": "idP", "value": idPa } ); },
			"sDom": '<"filtroSV">l<"infoSV">r<"data_tSV"t>', "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage":{
				"sLengthMenu":"MONSTRANDO _MENU_ records per page","sZeroRecords":"EL PACIENTE NO CUENTA CON SIGNOS VITALES",
				"sInfo":"MOSTRADOS: _END_","sInfoEmpty":"MOSTRADOS: 0","sInfoFiltered":"<br/>REGISTROS: _MAX_","sSearch": "BUSCAR" 
			}
		});//fin datatable
		$('#clickmeSV').click(function(e) { oTableSV.draw(); }); $('#mi_tab_h_sv').click(function(e){ $('#clickmeSV').click(); });
		//Fin historial sv
		
		//Gráficas grandes
		var h_g = $('#referencia').height()*0.25; var w_g = $('#referencia').width()*0.35;
		var h_g1 = $('#referencia').height()*0.55; var w_g1 = $('#referencia').width()*0.65;
		var datosCHa = {idP:idP, idCo:idC}
		$.post('consultas/files-serverside/datosChartsFC1.php',datosCHa).done(function(data){ 
			var datosCH4=data.split(';*'); 
			var myvalues = JSON.parse(datosCH4[1]); //alert(myvalues);
			$('#graficaFC').sparkline(myvalues, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[5], normalRangeMax:datosCH4[6], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues_1 = JSON.parse(datosCH4[29]);
			var chart = c3.generate({ bindto: '#myChartFC',
				data: { columns: [ myvalues_1 ] , labels: true, }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[5], end: datosCH4[6], class: 'regionY'} ]
			});
			var chart1 = c3.generate({ bindto: '#myChart1',
				data: { columns: [ myvalues_1 ], lables: true, }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[5], end: datosCH4[6], class: 'regionY'} ]
			});
			
			var myvalues1 = JSON.parse(datosCH4[7]); //alert(myvalues);
			$('#graficaFR').sparkline(myvalues1, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[8], normalRangeMax:datosCH4[9], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues1_1 = JSON.parse(datosCH4[28]); //alert(datosCH4[8]+';'+datosCH4[9]);
			var chart = c3.generate({ bindto: '#myChartFR',
				data: { columns: [ myvalues1_1 ], lables: true, }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[8], end: datosCH4[9], class: 'regionY'} ]
			});
			var chart2 = c3.generate({ bindto: '#myChart2',
				data: { columns: [ myvalues1_1 ], labels: true, }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[8], end: datosCH4[9], class: 'regionY'} ]
			});
			
			var myvalues2 = JSON.parse(datosCH4[10]); var dcT = datosCH4[10].split('['); var dcTx = dcT[1].split(']');
			$('#graficaT').sparkline(myvalues2, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[11], normalRangeMax:datosCH4[12], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues2_1 = JSON.parse(datosCH4[26]); //alert(myvalues2_1);
			var chart = c3.generate({ bindto: '#myChartT1',
				data: { columns: [ myvalues2_1 ], labels: true }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[11], end: datosCH4[12], class: 'regionY'} ],
			});
			var chart3 = c3.generate({ bindto: '#myChart3',
				data: { columns: [ myvalues2_1 ], labels: true, }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[11], end: datosCH4[12], class: 'regionY'} ]
			});

			var myvalues3 = JSON.parse(datosCH4[13]);
			$('#graficaTA').sparkline(myvalues3, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[14], normalRangeMax:datosCH4[15], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues3_1 = JSON.parse(datosCH4[27]); //alert(myvalues2_1);
			var chart = c3.generate({ bindto: '#myChartTA',
				data: { columns: [ myvalues3_1 ], labels: true, }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[14], end: datosCH4[15], class: 'regionY'} ]
			});
			var chart4 = c3.generate({ bindto: '#myChart4',
				data: { columns: [ myvalues3_1 ], labels: true, }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[14], end: datosCH4[15], class: 'regionY'} ]
			});
		
			var myvalues4 = JSON.parse(datosCH4[16]);
			$('#graficaTemp').sparkline(myvalues4, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[17], normalRangeMax:datosCH4[18], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues4_1 = JSON.parse(datosCH4[31]);
			var chart = c3.generate({ bindto: '#myChartT',
				data: { columns: [ myvalues4_1 ], labels: true, }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			var chart5 = c3.generate({ bindto: '#myChart5',
				data: { columns: [ myvalues4_1 ], labels: true, }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			
			var myvalues5 = JSON.parse(datosCH4[19]);
			$('#graficaPESO').sparkline(myvalues5, {type: 'line', barColor: 'green', width:'3em', height:'2em', fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues5_1 = JSON.parse(datosCH4[32]);
			var chart6 = c3.generate({ bindto: '#myChart6',
				data: { columns: [ myvalues5_1 ], labels: true, }, size: { height: h_g1, width: w_g1 },
				//regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			
			var myvalues6 = JSON.parse(datosCH4[22]);
			$('#graficaTALLA').sparkline(myvalues6, {type: 'line', barColor: 'green', width:'3em', height:'2em', fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues6_1 = JSON.parse(datosCH4[33]);
			var chart7 = c3.generate({ bindto: '#myChart7',
				data: { columns: [ myvalues6_1 ], labels: true, }, size: { height: h_g1, width: w_g1 },
				//regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			
			var myvalues7 = JSON.parse(datosCH4[23]);
			$('#graficaIMC').sparkline(myvalues7, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[24], normalRangeMax:datosCH4[25], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues7_1 = JSON.parse(datosCH4[30]); 
			var chart = c3.generate({ bindto: '#myChartIMC',
				data: { columns: [ myvalues7_1 ], labels: true, }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: 18.50, end: 25, class: 'regionY'} ]
			});
			var chart8 = c3.generate({ bindto: '#myChart8',
				data: { columns: [ myvalues7_1 ], labels: true, }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: 18.50, end: 25, class: 'regionY'} ]
			});
		});
		//Gráficas grandes FIN
	});
}
function cargar_todo_historia_clinica(idP,idC,id_s){
	$('#tHC input, #tHC select, #tHC textarea').prop('disabled',true);
	$('#b_editarHC').click(function(e) { tomar_historia_clinica(idP, idC,id_s); });
	
	var datosAl = {idPac:idP, idConsul:idC}
	$.post('consultas/files-serverside/notaEvo.php',datosAl).done(function(data){
		var alergis = data.split(';*}-{'); $('#alergias0').text(alergis[14]);
	});
	
	var datosMiHC = { idP:idP }
	$.post('consultas/files-serverside/datosHC.php',datosMiHC).done(function(dataHC){ var datosHC = dataHC.split(';*-');
		$('#fecha_toma_hc').text(datosHC[94]); $('#usuario_toma_hc').text(datosHC[95]);
		
		$('.estatusVive').load("consultas/files-serverside/cargar_estatus_vive.php",function(response,status,xhr){
			$('#estatus_padre').val(datosHC[0]);$('#estatus_madre').val(datosHC[5]); $('#estatus_conyugue').val(datosHC[15]);
		});
		$('.enfermedad').load("consultas/files-serverside/cargar_enfermedades.php", function(response,status,xhr) {
			$('#ahf_padre_1').val(datosHC[1]);$('#ahf_padre_2').val(datosHC[2]);$('#ahf_padre_3').val(datosHC[3]);
			$('#ahf_padre_4').val(datosHC[4]);$('#ahf_madre_1').val(datosHC[6]);$('#ahf_madre_2').val(datosHC[7]);
			$('#ahf_madre_3').val(datosHC[8]);$('#ahf_madre_4').val(datosHC[9]);$('#noHnos').val(datosHC[10]);
			$('#ahf_hnos_1').val(datosHC[11]);$('#ahf_hnos_2').val(datosHC[12]);$('#ahf_hnos_3').val(datosHC[13]);
			$('#ahf_hnos_4').val(datosHC[14]);$('#ahf_conyugue_1').val(datosHC[16]);$('#ahf_conyugue_2').val(datosHC[17]);
			$('#ahf_conyugue_3').val(datosHC[18]);$('#ahf_conyugue_4').val(datosHC[19]);$('#noHijos').val(datosHC[20]);
			$('#ahf_hijos_1').val(datosHC[21]);$('#ahf_hijos_2').val(datosHC[22]);$('#ahf_hijos_3').val(datosHC[23]);
			$('#ahf_hijos_4').val(datosHC[24]);$('#ahf_notas').val(datosHC[25]);$('#enfermedad1').val(datosHC[63]);
			$('#enfermedad2').val(datosHC[64]);$('#enfermedad3').val(datosHC[65]); $('#enfermedad4').val(datosHC[66]);
			$('#enfermedad5').val(datosHC[96]);
		});
		$('#alergia1').val(datosHC[88]);$('#alergia2').val(datosHC[89]);$('#alergia3').val(datosHC[90]);
		$('#alergia4').val(datosHC[91]);$('#alergia5').val(datosHC[92]);$('#alergia6').val(datosHC[93]);
		$('#cirugia1').val(datosHC[67]); $('#cirugia2').val(datosHC[68]); $('#cirugia3').val(datosHC[69]);
		$('#transfusiones').val(datosHC[70]);$('#app_notas').val(datosHC[71]);$('#menarca').val(datosHC[72]);
		$('#ritmo').val(datosHC[73]);$('#duracionR').val(datosHC[74]);$('#fur').val(datosHC[75]);
		$('#ivsa').val(datosHC[76]);$('#gestas').val(datosHC[77]);$('#partos').val(datosHC[78]);
		$('#cesareas').val(datosHC[79]);$('#abortos').val(datosHC[80]);$('#anticonceptivo').val(datosHC[81]);
		$('#tiempo_uso').val(datosHC[83]);$('#doc').val(datosHC[84]);$('#colposcopiaHC').val(datosHC[85]);
		$('#mastografiaHC').val(datosHC[86]); $('#ago_notas').val(datosHC[87]);
		
		$('.adiccion').load("consultas/files-serverside/cargar_adicciones.php", function( response, status, xhr ) { 
			$('#adiccion1').val(datosHC[26]);$('#adiccion2').val(datosHC[27]); $('#adiccion3').val(datosHC[28]); 
		});
		$('.deporte').load("consultas/files-serverside/cargar_deportes.php", function( response, status, xhr ) { 
			$('#deporte1').val(datosHC[35]);$('#deporte2').val(datosHC[36]);$('#deporte3').val(datosHC[97]); 
		});
		$('.inicio').load("consultas/files-serverside/cargar_inicios.php", function( response, status, xhr ) { 
			$('#inicio_adiccion1').val(datosHC[29]);$('#inicio_adiccion2').val(datosHC[30]); $('#inicio_adiccion3').val(datosHC[31]); 
		});
		$('.frecuencia').load("consultas/files-serverside/cargar_frecuencias.php", function( response, status, xhr ){ 
			$('#frecuencia_deporte1').val(datosHC[37]);$('#frecuencia_deporte2').val(datosHC[38]);
			$('#frecuencia_deporte3').val(datosHC[98]); 
			$('#frecuencia_adiccion1').val(datosHC[32]);$('#frecuencia_adiccion2').val(datosHC[33]); 
			$('#frecuencia_adiccion3').val(datosHC[34]);$('#apnp_notas').val(datosHC[39]);
		});
		$('.recreacion').load("consultas/files-serverside/cargar_recreaciones.php", function(response, status, xhr ){ 
			$('#recreacion1').val(datosHC[40]);$('#recreacion2').val(datosHC[41]);
			$('#recreacion3').val(datosHC[42]); $('#recreacion4').val(datosHC[43]);
			$('#recreacion5').val(datosHC[44]);$('#recreacion6').val(datosHC[45]);
		});
		$('#vivienda_hc').load("consultas/files-serverside/cargar_viviendas.php", function( response, status, xhr ) {
			$('#vivienda_hc').val(datosHC[46]);$('#habitantes').val(datosHC[47]); 
		});
		$('.servicio_hc').load("consultas/files-serverside/cargar_servicios.php", function( response, status, xhr ) {
			$('#servicios1_hc').val(datosHC[50]);$('#servicios2_hc').val(datosHC[51]);
			$('#servicios3_hc').val(datosHC[52]);$('#servicios4_hc').val(datosHC[53]);$('#servicios5_hc').val(datosHC[99]);
		});
		$('.matV').load("consultas/files-serverside/cargar_mat_vivienda.php", function( response, status, xhr ) { 
			$('#mat_vivienda1').val(datosHC[48]);$('#mat_vivienda2').val(datosHC[49]);
		});
		$('#aseo_personal').load("consultas/files-serverside/cargar_aseo_personal.php",function(response,status,xhr){
			$('#aseo_personal').val(datosHC[54]);
		});
		$('.vacuna').load("consultas/files-serverside/cargar_vacunas.php", function( response, status, xhr ) { 
			$('#vacunas1').val(datosHC[55]);$('#vacunas2').val(datosHC[56]);$('#vacunas3').val(datosHC[57]);
			$('#vacunas4').val(datosHC[100]);$('#vacunas5').val(datosHC[101]);
		}); 
		$('#hrs_dormir').val(datosHC[59]);
		$('#alimentacion_hc').load("consultas/files-serverside/cargar_alimentaciones.php",function(response,status,xhr){
			$('#alimentacion_hc').val(datosHC[60]); 
		});
		$('.mascota').load("consultas/files-serverside/cargar_mascotas.php", function( response, status, xhr ) { 
			$('#mascota1').val(datosHC[61]);$('#mascota2').val(datosHC[62]);$('#mascota3').val(datosHC[102]);
			$('#mascota4').val(datosHC[103]);$('#mascota5').val(datosHC[104]); 
		});
		$('#tipo_anticon').load("consultas/files-serverside/cargar_anticonceptivos.php",function(response,status,xhr){
			$('#tipo_anticon').val(datosHC[82]);
		});
	});
}
function tomar_sv(idP,control,idC, id_s){//si control es 1 al cerrar la ventana abre VerSignos
	$('#idUsuario_sv').val($('#id_user').val()); $('#idUsuario_c').val($('#id_user').val()); $('#formSignosVitales').validator();
	$('#tabs_consulta .hide_nsv, #tabs_sv .hide_nsv').hide(); $('#titulo_toma_sv').html('TOMAR SIGNOS VITALES');
	$('#b_agregarSignosC, #salirSGconsulta').addClass('hidden'); $('#btn_cancelar_sv, #btn_guardar_sv').removeClass('hidden');
	$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro, #notasSV').prop('readonly',''); $('.escala_g').prop('disabled','');
	// $('#tablaSVT input, #tablaNotaSV textarea, .sv_ro, #notasSV, #imcSV').val('');
	$('.escala_g').val(0);
	$('#ocular_val, #verbal_val, #motriz_val').text(0); $('#row_texto_puntuacion_g').addClass('hidden');
	
	var datosIDP = {idP:idP,idC:1}
	$.post('consultas/files-serverside/datosSV.php',datosIDP).done(function(data){ var datos = data.split(';*-'); 
		$('#cancelNSV,#saveNSV').show();
		
		$('#pesoSV').keyup(function(e){
			if( !parseFloat($(this).val()) ){ $('#pesoSV').val(''); } if( parseFloat($(this).val())>650 ){ $('#pesoSV').val(''); }
			imc1($(this).val(),$('#tallaSV').val()); 
		});
		$('#tallaSV').keyup(function(e){ //if( !parseFloat($(this).val()) ){ $('#tallaSV').val(''); } 
			if( parseFloat($(this).val())>3 ){ $('#tallaSV').val(''); } imc1($('#pesoSV').val(),$(this).val());
		});
		$('#tSV').keyup(function(e){
			if( !parseFloat($(this).val()) ){ $('#tSV').val(''); } if( parseFloat($(this).val())>1000 ){ $('#tSV').val(''); }
		});
		$('#aSV').keyup(function(e){
			if( !parseFloat($(this).val()) ){ $('#aSV').val(''); } if( parseFloat($(this).val())>1000 ){ $('#aSV').val(''); }
		});
		$('#frSV').keyup(function(e){
			if( !parseInt($(this).val()) ){ $('#frSV').val(''); } if( parseInt($(this).val())>999 ){ $('#frSV').val(''); }
		});
		$('#fcSV').keyup(function(e){
			if( !parseInt($(this).val()) ){ $('#fcSV').val(''); } if( parseInt($(this).val())>999 ){ $('#fcSV').val(''); }
		});
		$('#oxiSV').keyup(function(e){
			if( !parseFloat($(this).val()) ){ $('#oxiSV').val(''); } if( parseFloat($(this).val())>100 ){ $('#oxiSV').val(''); }
		});
		$('#cinturaSV').keyup(function(e){
			if( !parseFloat($(this).val()) ){$('#cinturaSV').val('');} if( parseFloat($(this).val())>300 ){ $('#cinturaSV').val(''); }
		});
		$('#tempSV').keyup(function(e){
			if( !parseFloat($(this).val()) ){$('#tempSV').val('');} if( parseFloat($(this).val())>60 ){ $('#tempSV').val(''); }
		});
		
		$('#btn_cancelar_sv').click(function(event) {
			$('#tabs_consulta .hide_nsv, #tabs_sv .hide_nsv').show(); $('#titulo_toma_sv').html('ÚLTIMA TOMA');
			$('#b_agregarSignosC, #salirSGconsulta').removeClass('hidden'); $('#btn_cancelar_sv, #btn_guardar_sv').addClass('hidden');
			$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro, #notasSV').prop('readonly','readonly'); 
			$('.escala_g').prop('disabled','disabled');
			$('#titulo_toma_sv').html('SIGNOS VITALES | FECHA DE LA TOMA: <span id="fechaSignosC" name="fechaSignosC"></span>'); cargar_todo_signos_vitales(idP,idC); $('#b_agregarSignosC').click(function(e) { tomar_sv(idP,2,idC,id_s); });
		});

		$('#formSignosVitales').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta1").fadeTo(2000,500).slideUp(500,function(){ $("#alerta1").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); //var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
			var datos={
				idPx1:idP,idU:$('#idUsuario_sv').val(),peso:$('#pesoSV').val(),talla:$('#tallaSV').val(), idC:idC,
				cintura:$('#cinturaSV').val(), imc:$('#imcSV').val(), t:$('#tSV').val(),a:$('#aSV').val(),fr:$('#frSV').val(),
				fc:$('#fcSV').val(), temp:$('#tempSV').val(), notas:$('#notasSV').val(), oximetria:$('#oxiSV').val(), 
				aocular:$('#abertura_ocular').val(), rverbal:$('#respuesta_verbal').val(), rmotriz:$('#respuesta_motriz').val(),  dtxis:$('#dtxis').val()
			}
			$.post('enfermeria/files-serverside/guardarSV.php',datos).done(function(data){ 
				if(data==1){ $('#btn_cancelar_sv, #clickme').click();
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "Los signos vitales se han guardado satisfactoriamente.",
					  timer: 2500, showConfirmButton: false
					});$('#myModalx').modal('hide');
					verSignosV(idP,idC,2,0,id_s); window.setTimeout(function(){$('#tab_sv_1').click();},1500);
				} else{alert(data);}
			});
		  }
		});
		
	});
}
function tomar_historia_clinica(idP, idC,id_s){
	$('#formHistoriaClinica').validator(); $('#mi_tab_hc1').click(); $('#idPaciente_hc').val(idP);
	$('#tHC input, #tHC select, #tHC textarea').prop('disabled',false); $('#b_actualizarHC, #b_cancelHC').removeClass('hidden'); 
	$('#b_editarHC, #salirSGconsulta, .hide_nhc, #datos_toma_hc').addClass('hidden');
	
	$('#b_cancelHC').click(function(e) {
		$('#tHC input, #tHC select, #tHC textarea').prop('disabled',true); $('#mi_tab_hc1').click();
		$('#b_actualizarHC, #b_cancelHC').addClass('hidden'); 
		$('#b_editarHC, #salirSGconsulta, .hide_nhc, #datos_toma_hc').removeClass('hidden');
		cargar_todo_historia_clinica(idP,idC,id_s);
	});
	
	$('#formHistoriaClinica').validator().on('submit', function (e) {
	  if (e.isDefaultPrevented()) { // handle the invalid form...
	  } else { // everything looks good!
		e.preventDefault(); //var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
		var datos = $('#formHistoriaClinica').serialize();
		$.post('consultas/files-serverside/actualizarHC.php',datos).done(function(data){ if(data==1){ $('#b_cancelHC, #clickme').click();
			swal({
			  title: "¡CONFIRMACIÓN!", type: "success", text: "La historia clínica se ha guardado satisfactoriamente.",
			  timer: 2500, showConfirmButton: false
			});$('#myModalx').modal('hide');
			window.setTimeout(function(){
				verSignosV(idP,idC,2,0,id_s);
				window.setTimeout(function(){
					var datosAl = {idPac:idP, idConsul:idC}
					$.post('consultas/files-serverside/notaEvo.php',datosAl).done(function(data){
						var alergis = data.split(';*}-{'); $('#alergias0').text(alergis[14]);
					}); $('#tab_my_hc_x').click();
				},1500);
			},500);
		} else{alert(data);} });
	  }
	});
}
function imc1(a,b){ var imc = 0; $('#imcSV').val('');
	imc=redondear((parseFloat(a)/(parseFloat(b)*parseFloat(b))),2); 
	if(parseFloat(imc)){ $('#imcSV').val(imc); }else{$('#imcSV').val('');}
}
function checarEscala(id){//if($('#'+id).val()>0){ }else{}
	var x = 0; $('.escala_g').each(function(index, element) { x = parseInt(x) + parseInt($(this).val()); });
	$('#total_escala_g').text(x); $('.'+id).text($('#'+id).val());
	if(x<1){$('#row_texto_puntuacion_g').addClass('hidden');}else{$('#row_texto_puntuacion_g').removeClass('hidden');}
}
function imprimirSV(idP, idC) {
		var datosCon = {
			idP: idP,
			idC: idC
		}
		$.post('enfermeria/files-serverside/datosSV.php', datosCon).done(function(data) {
			var datos = data.split(';*-');
			window.open("hospital/genera/signos_vitales_reporte.php?idP=" + idP + "&edad=" + datos[1] + "&sexo=" + datos[2] + "&id_u=" + $('#id_user').val() + "&idC=" + idC, '_blank');
		});
	}
</script>
