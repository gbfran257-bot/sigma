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
    
    <title>SISTEMA - PACIENTES</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="jquery-ui-1.12.0/jquery-ui.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

	<script src="DataTables-1.12/DataTables-1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.12/DataTables-1.12.1/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.12/Select-1.4.0/js/dataTables.select.min.js"></script> 
	
    <script src="DataTables-1.12/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="DataTables-1.12/JSZip-2.5.0/jszip.min.js"></script>
    <script src="DataTables-1.12/Buttons-2.2.3/js/buttons.html5.min.js"></script> 
	<script src="DataTables-1.12/Buttons-2.2.3/js/buttons.print.min.js"></script> 

    <!-- <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script> -->

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

	<link href="DataTables-1.12/DataTables-1.12.1/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.12/Scroller-2.0.6/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.12/Select-1.4.0/css/select.bootstrap.min.css" rel="stylesheet"> 
<!-- <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet"> -->


	<link href="TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
    <style>

		/* Inicio estilos generales del texto */
		.font-size-14 {
			font-size: 14px !important;
		}

		#detalles_conceptos_adquiridos {
			font-size: 12px !important;
		}

		.total_a_pagar {
			color: #000;
		}
		/* Fin estilos generales del texto */

		/* Inicio estilos de los resúmenes individuales */
		#resumen_individual {
			margin: 10px auto;
		}

		#resumen_individual_titulo {
			font-size: 16px;
			font-weight: 600;
		}

		#resumen_individual_titulo:hover {
			cursor: pointer;
		}

		#resumen_flecha_icono {
			font-size: 18px;
			font-weight: bold;
		}
		/* Fin estilos de los resúmenes individuales */

    td.details-control { background: url('DataTables-1.10.5/examples/resources/details_open.png') no-repeat center center; cursor: pointer; }
	tr.details td.details-control { background: url('DataTables-1.10.5/examples/resources/details_close.png') no-repeat center center; }
	.modal {
	  overflow-x: hidden;
	  overflow-y: auto;
	}
	.dt-buttons{
			float:right;
			padding-right: 15px;
		}
    </style>
</head>
<?php include_once 'partes/header.php'; 

?>

<!-- Contenido -->
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
<input name="aleatorio_ov_a" type="hidden" value="" id="aleatorio_ov_a" required>
<input name="tempi" type="hidden" value="" id="tempi"> <input name="mi_histo" type="hidden" value="" id="mi_histo">
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid" style="font-size: 1.2em;"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">VISITAS</th>
    <th style="vertical-align:middle;">FÓLIO</th>
    <th style="vertical-align:middle;"><button class="btn btn-info btn-sm" type="button" onClick="nuevo_paciente();">PACIENTE <i class="fa fa-user-plus" aria-hidden="true"></i></button></th>
    <th style="vertical-align:middle;">EDAD</th>
    <th style="vertical-align:middle;">SEXO</th>
    <th style="vertical-align:middle;">TELÉFONO</th>
    <th style="vertical-align:middle;">CONVENIO</th>
    <th style="vertical-align:middle;">CONVENIOS</th>
    <th style="vertical-align:middle;">OV</th>
    <th style="vertical-align:middle;">FMTS</th>
    <th style="vertical-align:middle;">DOCS</th>
    <th style="vertical-align:middle;">EVTS</th>
    <th style="vertical-align:middle;">UBI</th>
    <th style="vertical-align:middle;"><span title="EXPEDIENTE CLÍNICO ELECTRÓNICO">ECE</span></th>
    <th style="vertical-align:middle;">MEMBRESÍA</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-FOLIO-" style="width:150px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-PACIENTE-"/></th>
            <th></th>
            <th><!--<input style="width:65px" type="text" class="form-control input-sm" placeholder="-SEXO-"/>--></th>
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-CONVENIO-"style="width:90px"/></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>
<div class="modal fade" id="modal-precios-descuentos-consulta" style="z-index: 2951!important">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modificación de precio de la consulta</h4>
			</div>
			<form action="" method="POST" role="form">
				<input type="hidden" name="id_vc" id="inputId_vc" class="form-control" value="">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<span class="label">Precio de la consulta</span>
								<input type="number" name="precio_original" id="inputPrecio_original" class="form-control" value="" step="0.01" required="required">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<span class="label">Honorarios para el médico</span>
								<input type="number" name="honorarios" id="inputHonorarios" class="form-control" value="" step="0.01" required="required">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<span class="label">Descuento</span>
								<input type="number" name="descuento" id="inputDescuento" class="form-control" value="" step="0.01">
							</div>
						</div>
						<div class="col-md-12">
							<span class="label">Motivo de esta modificación*</span>
							<input type="text" name="motivo_alteracion" id="inputMotivo_alteracion" class="form-control" value="" required="required">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar cambios</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- incluimos el modal de modificacion precio  estudio->imagen->lab -->
<?php include_once 'pacientes/htmls/ficha_modificacion_precios_d.php'; ?>
<?php include_once 'pacientes/htmls/ficha_modificacion_precios_lab.php'; ?>

<div class="modal fade" id="modal-precios-servicios" style="z-index: 2951!important">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modificación de precio de la consulta</h4>
			</div>
			<form action="" method="POST" role="form">
				<input type="hidden" name="id_vc" id="inputId_vc" class="form-control" value="">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<span class="label">Precio de la consulta</span>
								<input type="number" name="precio_original" id="inputPrecio_original_s" class="form-control" value="" step="0.01" required="required">
							</div>
						</div>
						<div class="col-md-6">
							<span class="label">Motivo de esta modificación*</span>
							<input type="text" name="motivo_alteracion" id="inputMotivo_alteracion_s" class="form-control" value="" required="required">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar cambios</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-etiquetas" style="z-index: 2951!important">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Impresión de etiquetas</h4>
			</div>
			<!-- <form action="" method="POST" role="form"> -->
				<input type="hidden" name="id_vc" id="inputId_vc" class="form-control" value="">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<span class="label">Paciente</span>
								<input type="text" name="datPaciente" id="datPaciente" class="form-control" value="" step="0.01"  required="required">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<span class="label">Medicamento</span>
								<input type="text" name="medicamento" id="medicamento_name" class="form-control" value="" step="0.01" disabled = "true" required="required">
							</div>
						</div>
						<div class="col-md-6">
							<span class="label">Indicaciones</span>
							<input type="text" name="indicaciones" id="indicaciones_m" class="form-control" value="" required="required">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="imprimirEtiqueta" class="btn btn-primary">Imprimir</button>
				</div>
				<div id="divEtiqueta" style="display:none">
					<table>
						<tr>
							<td  style="font-size:8px" id="dataPaciente"></td>
						</tr>
						<tr>
							<td style="font-size:8px"><span  id="name_med"></span> <?php  echo date('d/m/y H:m:i'); ?></td>
						</tr>
						<tr>
							<td style="font-size:8px" id="indicaciones_med"></td>
						</tr>
					</table>
				</div>
			<!-- </form> -->
		</div>
	</div>
</div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
function regresar(){
	$('.si_impre').addClass('hidden'); $('.no_impre').removeClass('hidden'); $('#mi_formato').html('');
}
function alertF(txt){
	alert(txt);
}
function crear_formato(nombre_f, id_f, id_p){
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
			
			tinymce.remove('#mi_formato');
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
		$('#myModal1').on('hidden.bs.modal', function (e) { $("#myModal1 .modal-content").remove(); $("#myModal1").empty(); });
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
function modifica_precio(id){
	$("#modal-precios-descuentos-consulta #inputId_vc").val(id);
	$.post("pacientes/files-serverside/dameVC.php", {id_vc: id}, function(res){
		$("#modal-precios-descuentos-consulta #inputPrecio_original").val(res[2]);
		$("#modal-precios-descuentos-consulta #inputDescuento").val(res[3]);
		$("#modal-precios-descuentos-consulta #inputPrecio_original").attr("min", res[0]);
		$("#modal-precios-descuentos-consulta #inputHonorarios").val(res[1]);
		$("#modal-precios-descuentos-consulta #inputMotivo_alteracion").val(res[4]);
		$("#modal-precios-descuentos-consulta").modal("show");
	}, "json");
}
function modifica_precio_servicios(id){
	$("#modal-precios-servicios #inputId_vc").val(id);
	$.post("pacientes/files-serverside/dameVC.php", {id_vc: id}, function(res){
		$("#modal-precios-servicios #inputPrecio_original_s").val(res[2]);
		$("#modal-precios-servicios #inputPrecio_original").attr("min", res[0]);
		$("#modal-precios-servicios").modal("show");
	}, "json");
}

function imprimirEtiquetas(id){
	$("#modal-etiquetas #inputId_vc").val(id);
	var  datosP = $('#titulo_modal').text();
	datosP = datosP.substring(15,datosP.length);
	$.post("pacientes/files-serverside/dameMD.php", {id_to: id}, function(res){
		$("#modal-etiquetas #medicamento_name").val(res[0]);  
		$("#modal-etiquetas #datPaciente").val(datosP);
		$("#modal-etiquetas #indicaciones_m").val(res[1]);

		
		$("#name_med").text(res[0]);
		$("#modal-etiquetas").modal("show");
	}, "json");

	$('#imprimirEtiqueta').click(function(e){
		$('#divEtiqueta').css('display', 'block');
		$("#dataPaciente").text($('#datPaciente').val().toUpperCase());
		$("#indicaciones_med").text($('#indicaciones_m').val().toUpperCase());
		$('#divEtiqueta').printElement();
		$("#modal-etiquetas").modal("hide");
	});
}

//funcion que abre modal con los valores de su registro(concepto_ventas)
function modifica_precio_e_imagen(id){
	$("#modal-precios-descuentos-imagen #inputId_vc").val(id);
	$.post("pacientes/files-serverside/dameVC.php", {id_vc: id}, function(res){
		$("#modal-precios-descuentos-imagen #inputPrecio_original").val(res[2]);
		$("#modal-precios-descuentos-imagen #inputDescuento").val(res[3]);
		$("#modal-precios-descuentos-imagen #inputPrecio_original").attr("min", res[0]);
		$("#modal-precios-descuentos-imagen #inputHonorarios").val(res[1]);
		$("#modal-precios-descuentos-imagen #inputMotivo_alteracion").val(res[4]);
		$("#modal-precios-descuentos-imagen").modal("show");

	}, "json");

}

function modifica_precio_e_lab(id){
	$("#modal-precios-descuentos-lab #inputId_vc").val(id);
	$.post("pacientes/files-serverside/dameVC.php", {id_vc: id}, function(res){
		$("#modal-precios-descuentos-lab #inputPrecio_original").val(res[0]);
		$("#modal-precios-descuentos-lab #inputDescuento").val(res[3]);
		$("#modal-precios-descuentos-lab #inputPrecio_original").attr("min", res[0]);
		$("#modal-precios-descuentos-lab #inputHonorarios").val(res[1]);
		$("#modal-precios-descuentos-lab #inputMotivo_alteracion").val(res[4]);
		$("#modal-precios-descuentos-lab").modal("show");

	}, "json");

}

function alertaEliminarDescuentoI(opc_elegida){

	swal({
		title: "Esta acción borrará los descuentos individuales de cada estudio",
		text: "",
		type: "warning",
		showCancelButton: true,
		cancelButtonText: "Cancelar",
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Aceptar",
		closeOnConfirm: true
		}, function(isConfirm) {
		if (!isConfirm) {
			if(opc_elegida==1){ //imagen
				$("#po_descuento_i").prop("readonly", true);

				$('#sin_descuentos_imagen').hide();

				let totalAcumulado = 0.00;

				if ($('#monto_imagen_porcentaje').length > 0) {
					totalAcumulado += parseFloat($('#monto_imagen_porcentaje').text().slice(1, $('#monto_imagen_porcentaje').text().length));
				}

				if ($('.monto_desc_acum_img').length > 0) {
					$('.monto_desc_acum_img').each((index, element) => {
						totalAcumulado += parseFloat(element.textContent.slice(1, element.textContent.length));
					});
				}

				if ($('#monto_imagen_directo').length > 0) {
					totalAcumulado += parseFloat($('#monto_imagen_directo').text().slice(1, $('#monto_imagen_directo').text().length));	
				}

				if (totalAcumulado > 0.00) {
					$('#montoTotalDescuentosImg').text(`$${totalAcumulado}`);
				} else {
					$('#sin_descuentos_imagen').show();
				}
			}else if(opc_elegida==2){//laboratorio
				$("#po_descuento_l").prop("readonly", true);
			}
		} else {
			// Código a ejecutar cuando se hace clic en "Aceptar"
			if(opc_elegida==1){//imagen
				$("#po_descuento_i").prop("readonly", false); 
				$('#da_descuento_i_secreto').val(0);
				$('#da_descuento_i').val(0); 
				//se llama el archivo que elimina todos los descuentos de la bd asociados a la ov imagen
				$.post("pacientes/files-serverside/modificarDescuentoCero.php", {
					id_vc: $('#aleatorio_ov').val()
				}, function(res){
					
				}, "json");
				//--inicio-- Refrescamos el input de total descuento con la nueva suma de descuentos 
				var datosi={aleatorio:$('#aleatorio_ov').val()}
				$.post('pacientes/files-serverside/sumar_descuentos_imagen.php',datosi).done(function(data){
					$('#da_descuento_i_secreto').val(parseFloat(data));
					$('#to_descuento_i').val(parseFloat(0+$('#da_descuento_i').val()) + parseFloat($('#da_descuento_i_secreto').val()));
				});
				totales_imagen();
				$('#row_descuento_imagen_directo').remove();
				$('#row_descuento_imagen_porcentaje').remove();
				actualizarTablaDescuentos('imagen');
			}else if(opc_elegida==2){//laboratorio
				$("#po_descuento_l").prop("readonly", false); 
				$('#da_descuento_l_secreto').val(0); 
				$('#da_descuento_l').val(0); 
				$.post("pacientes/files-serverside/modificarDescuentoCeroLab.php", {
					id_vc: $('#aleatorio_ov').val()
				}, function(res){
					
				}, "json");
				var datosi={aleatorio:$('#aleatorio_ov').val()}
				$.post('pacientes/files-serverside/sumar_descuentos_lab.php',datosi).done(function(data){
					$('#da_descuento_l_secreto').val(parseFloat(data));
					$('#to_descuento_l').val(parseFloat(0+$('#da_descuento_l').val()) + parseFloat($('#da_descuento_l_secreto').val()));
				});
				totales_laboratorio();

				// Actualizamos la tabla de resumen del apartado de laboratorio
				$('#row_descuento_lab_directo').remove();
				actualizarTablaDescuentos('lab');
			}
			//--fin--
			calcular_totales();
			
		}
	});
	
}

$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>RECEPCIÓN</li><li class="active"><strong>PACIENTES</strong></li>');
	
	$('body').popover({selector: '[data-toggle="popover"]', 'trigger': 'hover', 'placement': 'left'});
	
	$(document).on('focus', ':not(.popover)', function(){ $('.popover').popover('hide'); }); //$('[data-toggle="popover"]').popover({ });
	$("#modal-precios-descuentos-consulta form").submit(function(e){
		e.preventDefault();
		$.post("pacientes/files-serverside/modificaPrecioConsulta.php",
			$("#modal-precios-descuentos-consulta form").serialize(),
			function(res){
				if(res == "1"){
					$("#modal-precios-descuentos-consulta form")[0].reset();
					$("#modal-precios-descuentos-consulta").modal("hide");
					$('#clickmeCoS1').click();
					totales_consultas();

					// Actualizamos la tabla resumen del apartado de consultas
					actualizarTablaDescuentos('consultas');
				}else{
					alert("Error: "+res);
				}
			}
		);
	});
	//Modal de modificacion precio estudio->imagen
	$("#modal-precios-descuentos-imagen form").submit(function(e){
		e.preventDefault();
		$.post("pacientes/files-serverside/modificaPrecioImagen.php",
			$("#modal-precios-descuentos-imagen form").serialize(),
			function(res){
				if(res == "1"){
					$('#clickmeEiS,#clickmeIm').click();
					$('#po_descuento_i').val(0);
					//En caso de guardar un descuento, poner porcentaje en ceros
					if(parseFloat(0+$("#modal-precios-descuentos-imagen #inputDescuento").val())>0){
						
						//--inicio-- borramos de la tabla conceptos_carg_desc
						var datoscg={temp:$('#aleatorio_ov').val(), area:'imagen'}
						$.post('pacientes/files-serverside/borrar_cargo_descuento.php',datoscg).done(function(data){
							calcular_totales();
						});
					}
					//--inicio-- cada vez que se guardan cambios hace nuevamente la suma de descuentos y los guarda en un campo oculto.
					var datosi={aleatorio:$('#aleatorio_ov').val()}
					$.post('pacientes/files-serverside/sumar_descuentos_imagen.php',datosi).done(function(data){
						$('#da_descuento_i_secreto').val(parseFloat(data));
						$('#to_descuento_i').val(parseFloat(0+$('#da_descuento_i').val()) + parseFloat($('#da_descuento_i_secreto').val()));
						calcular_totales();
					});
					//--inicio--una vez modificado un precio, sumamos los precios totales de imagen y mostramos en Precio estudios
					var datospi={aleatorio:$('#aleatorio_ov').val()}
					$.post('pacientes/files-serverside/sumar_precios_imagen.php',datospi).done(function(data){
						if(!parseFloat(data)){data=0;}else{data=data;}
						$('#precio_i').val(data);
						calcular_totales();
					});
					//--fin--
					$("#modal-precios-descuentos-imagen form")[0].reset();
					$("#modal-precios-descuentos-imagen").modal("hide");
					totales_consultas();

					// Actualizamos la tabla resumen del apartado de imagen
					$('#row_descuento_imagen_porcentaje').remove();
					actualizarTablaDescuentos('imagen');
				}else{
					alert("Error: "+res);
				}
			}
		);
	});
	//Modal de modificacion precio estudio->laboratorio
	$("#modal-precios-descuentos-lab form").submit(function(e){
		e.preventDefault();
		$.post("pacientes/files-serverside/modificaPrecioLab.php",
			$("#modal-precios-descuentos-lab form").serialize(),
			function(res){
				if(res == "1"){
					$('#clickmeElS,#clickmeLa').click();
					$('#po_descuento_l').val(0);
					//En caso de guardar un descuento, poner porcentaje en ceros
					if(parseFloat(0+$("#modal-precios-descuentos-lab #inputDescuento").val())>0){
						
						//--inicio-- borramos de la tabla conceptos_carg_desc
						var datoscg={temp:$('#aleatorio_ov').val(), area:'laboratorio'}
						$.post('pacientes/files-serverside/borrar_cargo_descuento.php',datoscg).done(function(data){
							calcular_totales();
						});
					}
					//--inicio-- cada vez que se guardan cambios hace nuevamente la suma de descuentos y los guarda en un campo oculto.
					var datosi={aleatorio:$('#aleatorio_ov').val()}
					$.post('pacientes/files-serverside/sumar_descuentos_lab.php',datosi).done(function(data){
						$('#da_descuento_l_secreto').val(parseFloat(data));
						$('#to_descuento_l').val(parseFloat(0+$('#da_descuento_l').val()) + parseFloat($('#da_descuento_l_secreto').val()));
						calcular_totales();
					});
					//--inicio--una vez modificado un precio, sumamos los precios totales de laboratorio y mostramos en Precio estudios
					var datospi={aleatorio:$('#aleatorio_ov').val()}
					$.post('pacientes/files-serverside/sumar_precios_laboratorio.php',datospi).done(function(data){
						if(!parseFloat(data)){data=0;}else{data=data;}
						$('#precio_l').val(data);
						calcular_totales();
					});
					//--fin--
					$("#modal-precios-descuentos-lab form")[0].reset();
					$("#modal-precios-descuentos-lab").modal("hide");
					totales_consultas();

					// Actualizamos la tabla de resumen para el apartado de lab
					actualizarTablaDescuentos('lab');
				}else{
					alert("Error: "+res);
				}
			}
		);
	});

	$("#modal-precios-servicios form").submit(function(e){
		e.preventDefault();
		$.post("pacientes/files-serverside/modificaPrecioServicios.php",
			$("#modal-precios-servicios form").serialize(),
			function(res){
				if(res == "1"){
					$("#modal-precios-servicios form")[0].reset();
					$("#modal-precios-servicios").modal("hide");
					$('#clickmeSmS').click();
					totales_servicios();
				}else{
					alert("Error: "+res);
				}
			}
		);
	});
	$('#my_search').removeClass('hidden'); 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-$('#breadc').height()-204;
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,
		"sScrollY": tamP,
		ordering: false, 
		searching: true, 
		scrollCollapse: false, 
		"scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {

		 }, 
		croller: false, 
		responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, { "bVisible": true }, { "bVisible": true },
			{"bVisible":true}, {"bVisible":true },{ "bVisible": false }, { "bVisible": true }, { "bVisible": true },
			{"bVisible":false}, {"bVisible":false },{ "bVisible": false }, { "bVisible": false }, { "bVisible": true }
		],
		"sDom": '<"filtro1Principal"f>Bl<"data_tPrincipal"t><"infoPrincipal"iS><"proc"p>',
        buttons: [ 
			// 'excel','pdf','print'
	 ],
        lengthMenu: [[25, 100, -1], [25, 100, "Todo"]],
		deferRender: true, 
		select: false, 
		"processing": false, 
		"sAjaxSource": "datatable-serverside/pacientes.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de = $('#top-search').val(), cv = $('#convenioP1').val(); 
			aoData.push( {"name": "nombre", "value": de } );
			aoData.push( {"name": "convenio", "value": cv } ); 
		},
		"oLanguage": {
			"sLengthMenu": "MOSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "PACIENTES FILTRADOS: _END_", "sInfoEmpty": "NINGÚN PACIENTE FILTRADO.", "sInfoFiltered": " TOTAL DE PACIENTES: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},
		"iDisplayLength": 25, 
		paging: true,
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
});
function padLeft(n){
    return ("00" + n).slice(-2);
}
function nuevo_paciente(){ //Para poder crear un usuario nuevo, el usuario actual debe tener por lo menos una empresa asignada
	$("#myModal").load('pacientes/htmls/ficha_paciente.php', function( response, status, xhr ){ if(status=="success"){
		$.fn.datepicker.defaults.autoclose = true; $('#id_usr_reg').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#id_sucu').val(<?PHP echo $id_sucursal_u; ?>);
		$("#fecha_nacimiento_p1_poredad").removeClass("hidden");
		$('#fecha_nacimiento_p1').on('changeDate', function(e) {
			$('#edad_p').text(calcular_edad(e.format()));
			$("#fecha_nacimiento_p1_poredad").addClass("hidden");
		});
		$("#fecha_nacimiento_p_poredad").change(function(){
			var a = new Date();
			$("#fecha_nacimiento_p").val(padLeft(a.getDay())+"/"+padLeft(a.getMonth())+"/"+(a.getFullYear()-$(this).val()));
		});
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

		//IMAGENES EN MODAL PACIENTES
		$('#tImagen').click(function(e) { window.setTimeout(function(){$('#tableImg').click()},200); });
			$("#tableImg").load('pacientes/datatable-serverside/imagenes_paciente.php',function(response,status,xhr){if(status=="success"){ 
				$("#tableImg").html(response);
			}});
		
		$('#titulo_foto').keyup(function(e) {
            if($(this).val()!=''){ 
				$('#btn_add_doc').removeClass('disabled'); 
				$('#btn_send_doc').removeClass('disabled'); 
			}else{ 
				$('#btn_add_doc').addClass('disabled'); 
				$('#btn_send_doc').addClass('disabled'); 
			}
        });
	
		$('#btn_add_doc').click(function(e) { if($('#titulo_foto').val()!=''){ $('#fileupload_foto').click(); }else{ } });

		const btnEnviar = document.querySelector("#btn_send_doc");
		const inputFile = document.querySelector("#fileupload_foto");

		btnEnviar.addEventListener("click", () => {
			if (inputFile.files.length > 0) {
				let formData = new FormData();
				// formData.append("idP", );
				formData.append("idU", $('#id_user').val());
				// formData.append("fecha", inputFile.files[0]);
				formData.append("NombreArchivo", $('#titulo_foto').val());
				formData.append("archivo", inputFile.files[0]); // En la posición 0; es decir, el primer elemento
				fetch("pacientes/documentos/fotos/guardar.php", {
					method: 'POST',
					body: formData,
				})
					.then(respuesta => respuesta.text())
					.then(decodificado => {
						if(decodificado == 'Subido con éxito'){
							swal({
								title: "¡Bien!",
								text: decodificado,
								type: "success"
								}, function() {
									$("#tableImg").load('pacientes/datatable-serverside/imagenes_paciente.php',function(response,status,xhr){if(status=="success"){ 
										$("#tableImg").html(response);
									}});
								});							
						}else{
							swal("¡Uppss!", decodificado, "error");
						}
					});
			} else {
				// El usuario no ha seleccionado archivos
				alert("Selecciona un archivo");
			}		
		});	
		
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
					}, function(){
						nuevaVisita(data2[1], data2[2]);
						swal.close();
					});
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) {
			var i=0; $('#t_tDireccion').click(function(e) { if(i%2==0){i++; ubicacion('tren escenico cuautla morelos'); } });
			$('#form-ficha_us').validator(); $('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $("#myModal .modal-content").remove(); $("#myModal").empty(); });
	} });
}

function eliminarImg(id,nombre,idP){
	swal({
	  title: "Eliminar Imagen", text:"¿ESTÁ SEGURO QUE DESEA ELIMINAR LA IMAGEN "+nombre+" ?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "ELIMINAR", cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		var datos = {id:id}
		$.post('pacientes/files-serverside/eliminarImagen.php',datos).done(function(data){
			if (data==1){ $('#clickmeCo').click();
				swal({title:"",type:"",text:"La imagen se elimino correctamente!",timer:1800,showConfirmButton:true},
				function(){
					if(idP != 'NO'){
						$("#tableImg").load('pacientes/datatable-serverside/imagenes_paciente.php?idP='+idP,function(response,status,xhr){if(status=="success"){ 
							$("#tableImg").html(response);
						}});
					}else{
						$("#tableImg").load('pacientes/datatable-serverside/imagenes_paciente.php',function(response,status,xhr){if(status=="success"){ 
							$("#tableImg").html(response);
						}});
					}
				});
			}else{alert(data);}
		});
	});
}

function ver_docu(id_doc,exte){
	$('.no_document').addClass('hidden'); 
	$('.si_document').removeClass('hidden');
	if(!$('#btn_new_u').hasClass('hidden') && !$('#btn_cancel_new_u').hasClass('hidden')){
		$('#btn_new_u').addClass('hidden');
		$('#btn_cancel_new_u').addClass('hidden');
	}
	var widi = $('#myModal').width()*0.6;
	if(exte != 'pdf' & exte != 'PDF'){
		x='pacientes/documentos/fotos/'+id_doc+'.'+exte;
		$('#mi_documento').html('<img src='+x+' style="max-width:100%; border:3px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
	}else{
		x='pacientes/documentos/files/'+id_doc+'.pdf'; 
		var h=$('#referencia').height()-$('#nav-header').height()-$('#my_footer').height();
		$('#mi_documento').html('<a class="media" href=""> </a>'); $('a.media').media({width:790, height:h-136, src:x});	
	}
}

function cerrar_ver_doc(){
	$('.no_document').removeClass('hidden'); 
	$('.si_document').addClass('hidden');
	$('#btn_new_u').removeClass('hidden');
	$('#btn_cancel_new_u').removeClass('hidden');
}

function verPaciente(idP){
	$("#myModal").load('pacientes/htmls/ficha_paciente.php', function( response, status, xhr ){ if(status=="success"){
		$.fn.datepicker.defaults.autoclose = true; 
		$('#id_usr_reg').val($('#id_user').val()); $('#alerta_new_user').hide(); $('#id_sucu').val(<?PHP echo $id_sucursal_u; ?>);
		$('#id_paciente_v').val(idP); var nowY = new Date().getTime(), dY = new Date();
	 
		 var datos ={idP:idP, tempN:dY.format('Y-m-d-H-i-s-u').substring(0,22)}
		 $.post('pacientes/files-serverside/fichaPaciente.php',datos).done(function(data1){ //alert(data1);
			var datosI = data1.split('*}');
			
			$('#lat_us').text(redondear(datosI[56],4)); $('#lati_ud').val(datosI[56]); 
			$('#lon_us').text(redondear(datosI[57],4)); $('#long_ud').val(datosI[57]);
			var i=0; $('#t_tDireccion').click(function(e) { if(i%2==0){ i++; siempre(datosI[56],datosI[57]); } });
			
			$('#titulo_modal').text('FICHA DEL PACIENTE'+datosI[1]+' '+datosI[2]+' '+datosI[3]+'. REGISTRADO POR '+datosI[40]+' '+datosI[41]);
			
			var fechaN1 = datosI[20].split('/'); var fxD = fechaN1[0], fxM = fechaN1[1], fxY = fechaN1[2];
			if(fxD.length == 1){fxD = '0'+fxD;} if(fxM.length == 1){fxM = '0'+fxM;}
			//$('#bancoPF').val(datosI[52]);$('#digitos4B').val(datosI[53]);$('#notasP').val(datosI[21]);
			//if($('#bancoPF').val()!=''){$('.4d').show();}else{$('.4d').hide();}
			$("#fecha_nacimiento_p").val(fxD+'/'+fxM+'/'+fxY);
			$('#nombre_p').val(datosI[1]);$('#apaterno_p').val(datosI[2]);$('#amaterno_p').val(datosI[3]);
			$("#sexo_us").val(datosI[19]);$('#edad_p').text(calcular_edad(datosI[20]));
			$('#rfc_p').val(datosI[14]); $('#tel_personal_p').val(datosI[10]);$('#tel_particular_p').val(datosI[11]);
			$('#tel_trabajo_p').val(datosI[12]);$('#tel_trabajo_ext_p').val(datosI[13]);
			$('#id_sucu').val(datosI[17]); $('#curp_p').val(datosI[0]); $('#rfc_fp').val(datosI[51]);
			$('#email_p').val(datosI[18]); $('#contacto_emergencia_p').val(datosI[15]); $('#tel_emergencia_p').val(datosI[16]);
			$('#email_pf').val(datosI[61]); $('#ciudad_df').val(datosI[62]); $('#colonia_df').val(datosI[49]);
			$('#calle_df').val(datosI[44]); $('#cp_df').val(datosI[45]);
			$('#facebook_p').val(datosI[63]); $('#instagram_p').val(datosI[64]);
			$('#puesto_p').val(datosI[65]); $('#clave_p').val(datosI[66]);
			//$('#centroSaludP').val(datosI[54]); $('#derechohabienciaP').val(datosI[55]);
			
			$('#fecha_nacimiento_p1').on('changeDate', function(e) { $('#edad_p').text(calcular_edad(e.format())); });
			$("#pais_p").load('genera/paises.php',function(response,status,xhr){if(status=="success"){ 
				$(this).val(datosI[24]);
				$(this).change(function(e) {
					if($(this).val()!=146){ $('.de_mex').addClass('hidden'); }else{ $('.de_mex').removeClass('hidden');}
					$('#form-ficha_us').validator('update');
				});
			}});
			$('#edo_nacimiento').load('pacientes/files-serverside/genera_estados.php',function(response,status,xhr){
				$(this).val(datosI[42]);
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
			$('#sangre_p').load('pacientes/files-serverside/genera_tsangre.php',function(response,status,xhr){
				$(this).val(datosI[6]);
			});
			$("#estado_dir_p").load('pacientes/files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){
				$(this).val(datosI[28]);
				$("#estado_dir_p").change(function(event){
					$('#municipio_p').val(''); var id = $("#estado_dir_p").find(':selected').text();
					$("#municipio_p").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){if(status=="success"){}});
				});
				if(datosI[28]!=''){
					var id = $("#estado_dir_p").find(':selected').text();
					$("#municipio_p").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){if(status=="success"){
						$(this).val(datosI[29]);
					}});
				}
			}});
			
			$('#estado_dir_p').change(function(e) {
				var address = $('#estado_dir_p').find(':selected').text()+' MÉXICO'; ubicacion(address); $('.mi_dir, #cp_us').val('');
			});
			$('.mi_dir').keyup(function(e){
				var address = $('#estado_dir_p').find(':selected').text()+' '+document.getElementById('ciudad_us').value+' '+document.getElementById('colonia_us').value+' '+document.getElementById('calle_us').value; ubicacion(address);
			});
			$("#estado_df").load('pacientes/files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){
				$(this).val(datosI[47]);
				$("#estado_df").change(function(event){
					$('#municipio_df').val(''); var id = $("#estado_df").find(':selected').text();
					$("#municipio_df").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){if(status=="success"){}});
				});
				if(datosI[47]!=''){
					var id = $("#estado_df").find(':selected').text();
					$("#municipio_df").load('pacientes/files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){if(status=="success"){
						$(this).val(datosI[48]);
					}});
				}
			}});
			$('#estado_df').change(function(e) { $('#municipio_df').val(''); }); $('#razon_social').val(datosI[43]);
			
			$('#ciudad_us').val(datosI[60]);$('#colonia_us').val(datosI[30]);$('#calle_us').val(datosI[25]);
			$('#cp_us').val(datosI[31]);
		});



		$('#tImagen').click(function(e) { window.setTimeout(function(){$('#tableImg').click()},200); });
			$("#tableImg").load('pacientes/datatable-serverside/imagenes_paciente.php?idP='+idP,function(response,status,xhr){if(status=="success"){ 
				$("#tableImg").html(response);
			}});
		
		$('#titulo_foto').keyup(function(e) {
            if($(this).val()!=''){ 
				$('#btn_add_doc').removeClass('disabled'); 
				$('#btn_send_doc').removeClass('disabled'); 
			}else{ 
				$('#btn_add_doc').addClass('disabled'); 
				$('#btn_send_doc').addClass('disabled'); 
			}
        });
	
		$('#btn_add_doc').click(function(e) { if($('#titulo_foto').val()!=''){ $('#fileupload_foto').click(); }else{ } });

		const btnEnviar = document.querySelector("#btn_send_doc");
		const inputFile = document.querySelector("#fileupload_foto");

		btnEnviar.addEventListener("click", () => {
			if (inputFile.files.length > 0) {
				let formData = new FormData();
				formData.append("idP", idP);
				formData.append("idU", $('#id_user').val());
				// formData.append("fecha", inputFile.files[0]);
				formData.append("NombreArchivo", $('#titulo_foto').val());
				formData.append("archivo", inputFile.files[0]); // En la posición 0; es decir, el primer elemento
				fetch("pacientes/documentos/fotos/guardar.php", {
					method: 'POST',
					body: formData,
				})
					.then(respuesta => respuesta.text())
					.then(decodificado => {
						if(decodificado == 'Subido con éxito'){
							swal({
								title: "¡Bien!",
								text: decodificado,
								type: "success"
								}, function() {
									$("#tableImg").load('pacientes/datatable-serverside/imagenes_paciente.php?idP='+idP,function(response,status,xhr){if(status=="success"){ 
										$("#tableImg").html(response);
									}});
								});							
						}else{
							swal("¡Uppss!", decodificado, "error");
						}
					});
			} else {
				// El usuario no ha seleccionado archivos
				alert("Selecciona un archivo");
			}		
		});	
		
		$('#form-ficha_us').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#myModal #form-ficha_us').serialize();
			$.post('pacientes/files-serverside/updatePaciente.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_new_u').show(); $('#myModal').modal('hide'); 
					swal({ title: "", type: "success", text: "Los datos del paciente se han actualizado.", timer: 2000, showConfirmButton: false }); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function(e){
			$('#form-ficha_us').validator(); $('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $("#myModal .modal-content").remove(); $("#myModal").empty(); });
	} });
}
function siempre(la,lo){
	ubicaDobleX = la;
	ubicaDobleY = lo;
	if(bloqueo_ubica)
		return;
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

function ver_ov(id_p, name_p, ref, temp){
	$('#myModal2').modal('hide'); //alert(ref);
	window.setTimeout(function(){
		$("#myModal4").load('pacientes/htmls/ficha_ov.php', function( response, status, xhr ){ if(status=="success"){
			
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
			
			$.fn.datepicker.defaults.autoclose = true; var nv = new Date(); var k = 0; $('#alerta1, #alerta_me, #alerta_me1').hide();
			$('#aleatorio_ov, #aleatorio_ov_a').val(temp); $('#id_paciente_ov').val(id_p); $('#titulo_modal').text('NUEVA VISITA - '+name_p);
			
			$('#medico_c').load('pacientes/genera/medicos_consulta.php',function(response,status,xhr){if(status=="success"){
				window.setTimeout(function(){$('#medico_c').chosen();},500);
				$('#medico_c').change(function(e) { 
					$('#beneficio_c, #mi_id_convenio').val(0); $('.depende_consulta').addClass('hidden');
					if($(this).val()!=''){ $('.depende_medico_c').removeClass('hidden'); }
					else{ $('.depende_medico_c, .depende_consulta').addClass('hidden'); }
					$('#clickmeCo').click(); reset_totales_consulta(); calcular_totales();
				});
			}});
			
			var dato = {ref:ref} 
			$.post('pacientes/files-serverside/datos_orden_venta.php',dato).done(function(data){
				var datos = data.split(';-{');
				$('#sucursal_fi_p, #id_sucu').val(datos[13]); $('#id_usr_reg').val($('#id_user').val());
				
				$("#beneficio_c, #beneficio_i, #beneficio_l, #beneficio_s, #beneficio_p").load("pacientes/genera/beneficiosP.php?idP="+id_p, function(response,status,xhr){ });
				
				if(datos[0]){//Si hay consulta
					$('#medico_c').val(datos[0]), $('#mi_id_convenio').val(datos[4]);
					window.setTimeout(function(){
						$('#medico_c').val(datos[0]); $('#medico_c').change(); $('#beneficio_c').val(datos[4]);
						$('.depende_consulta').removeClass('hidden'); $('#motivo_c').val(datos[5]); $('#po_descuento_c').val(datos[6]);
						$('#da_descuento_c').val(datos[7]); $('#cargo_extra_c').val(datos[8]); $('#motivo_descuento_c').val(datos[9]);
						if(datos[6]>0 || datos[7]>0 || datos[8]>0){$('.depende_descuento_c').removeClass('hidden');}
						$('#precio_c').val(datos[10]); $('#to_descuento_c').val(datos[11]); $('#total_c').val(datos[12]);
						calcular_totales();
						$('#medico_c').change(function(e) { $('.depende_descuento_c').addClass('hidden'); });
					},200);
					
					//$('#clickmeCo').click();
				}else{//alert('No hay consulta');
					$('#medico_c').val(0), $('#mi_id_convenio').val(0);
				}
				
				var oTableCo = $('#dataTableCo').DataTable({
					serverSide: true,"sScrollY": 120, ordering: false, searching: false, scrollCollapse: false,
					"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
					"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
					"sDom": '<""f>r<""t><""S><"">', 
					deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/buscar_consulta.php",
					"fnServerParams": function (aoData, fnCallback) {
						var de = $('#medico_c').val(), idConvenio = $('#mi_id_convenio').val();
						//if(idConvenio==null){idConvenio=0;}
						aoData.push( {"name": "idMedico", "value": de } ); aoData.push( {"name": "idConvenio", "value": idConvenio } );
						aoData.push( {"name": "idP", "value": id_p } ); 
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
						"sInfo": "CONSULTAS FILTRADAS: _END_",
						"sInfoEmpty": "NINGUNA CONSULTA FILTRADA.", "sInfoFiltered": " TOTAL DE CONSULTAS: _MAX_", "sSearch": "",
						"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
					},"iDisplayLength": 5000, paging: false,
				});
				
				$('#clickmeCo').click(function(e){ oTableCo.draw(); reset_totales_consulta(); calcular_totales(); });
				
				$("#beneficio_c").change(function(e){ $('#clickmeCo').click(); $('#mi_id_convenio').val($(this).val())});
				
			});
			
			/*
			
			$('#btn_liquidar_ov').click(function(e) {
				$('#pago_ov').val($('#total_ov_h').val()).focus(); $('#form-2').validator('update');
			});
			var dato = {id_p:idP} 
			$.post('pacientes/files-serverside/datos_paciente_orden_venta.php',dato).done(function(data){
				var mis_datos = data.split(';-{');
						$('#sucursal_fi_p').load('pacientes/genera/genera_sucursales_ov.php?idU='+$('#id_user').val(),function(response,status,xhr){if(status=="success"){
					$(this).val(<?PHP echo $id_sucursal_u; ?>);
				}});
				$('#procedencia_fi_p').load('pacientes/genera/procedencia.php',function(response,status,xhr){if(status=="success"){
					$(this).val(1);
				}});
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
			
			$('#beneficio_c').change(function(e){
				reset_totales_consulta(); $('#clickmeCo').click(); calcular_totales();
			});
			
			$('#cb_facturada_ov').click(function(e) {
				if(k%2==0){
					$('#hay_iva_ov').val(1); $('#iva_ov_h').val(redondear(parseFloat($('#total_ov_h').val())*0.16,2)); calcular_totales();
				}else{ $('#hay_iva_ov').val(0); $('#iva_ov_h').val(0); calcular_totales(); } k++;
			});
			
			$('#form-2').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
				$("#alerta1").fadeTo(2000,500).slideUp(500,function(){ $("#alerta1").slideUp(600); });
			  } else { // everything looks good!
				e.preventDefault(); 
				var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
				var datosP = $('#myModal4 #form-2').serialize();
				$.post('pacientes/files-serverside/guardar_ov.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $btn.button('reset'); $('#btn_cancel1').show(); $('#myModal4').modal('hide');
						swal({
						  title: "VENTA REALIZADA", text: "¿Deseas imprimir el ticket de venta?", type: "success", showCancelButton: true,
						  confirmButtonText: "Imprimir", cancelButtonText: "Salir", closeOnConfirm: false
						},
						function(){
							swal.close();
							$("#myModal1").load('pacientes/htmls/ticket.php', function( response, status, xhr ){ if(status=="success"){
								//var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-144;
								$('#contenedorAnteriores, #myAbonadoA').hide();
								var oTableT = $('#dataTableResumenT').DataTable({
									serverSide:true,"sScrollY":'100%',ordering:false,searching:false,scrollCollapse:false,"scrollX": true,
									"fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){ },scroller:false,responsive:false,
									"aoColumns": [
										{ "bVisible": true }, { "bVisible": false }, { "bVisible": false }, { "bVisible": true }, 
										{ "bVisible": false }, { "bVisible": true }
									],
									"sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
									deferRender: true, select: false, "processing": false, 
									"sAjaxSource": "pacientes/js/datatable-serverside/totales_nvTi.php",
									"fnServerParams": function (aoData, fnCallback) { 
										var aleatorio = $('#aleatorio_ov_a').val(); 
										aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									},
									"oLanguage": {
										"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"LA ORDEN DE VENTA ESTA VACIA",
										"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", 
										"sSearch": "BUSCAR"
									},"iDisplayLength": 50000, paging: false,
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
								$('#myModal1').on('hidden.bs.modal',function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
							}});					
						});
						return;
					} else{alert(data);}
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
			
			var oTableEim = $('#dataTableBestudiosI').DataTable({
				serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
				"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
				"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
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
				subirEstudio(rowData[0][4], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(), $('#medico_i').val(),
					$('#mi_id_convenioI').val(),$('#sucursal_fi_p').val(),$('#observacionesI_NV').val(), 2, rowData[0][2], 4, coveni, ocu
				); 
				$('.desc_cargo_i').change(function(e){nota_desc_cargo_i();}); $('.desc_cargo_i').keyup(function(e){nota_desc_cargo_i();});
			} );
			
			var oTableEimS = $('#dataTableEiS').DataTable({
				serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
				"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
				"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
				"sDom": '<"">r<""t><""S><"">', 
				deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/estudios_seleccionados_imagen.php",
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
			$('#clickmeEiS').click(function(e){ oTableEimS.draw(); });
			
			$("#beneficio_i").change(function(e){ $('#clickmeIm').click();});
			$("#sucursal_fi_p").change(function(e){ $('#clickmeIm').click();});
			
			var oTableEla = $('#dataTableBestudiosL').DataTable({
				serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
				"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){
					$('body').popover({
						selector: '[data-toggle="popover"]', 'trigger': 'hover',
						'placement': 'auto'
					});
					//$('[data-toggle="popover"]').popover({ }); 
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
				serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
				"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
				"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
				"sDom": '<"">r<""t><""S><"">', 
				deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/estudios_seleccionados_laboratorio.php",
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
			$('#clickmeElS').click(function(e){ oTableElaS.draw(); });
			
			$("#beneficio_l").change(function(e){ $('#clickmeLa').click();});
			$("#sucursal_fi_p").change(function(e){ $('#clickmeLa').click();});
	
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
				serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
				"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
				"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
				"sDom": '<"">r<""t><""S><"">', 
				deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/servicios_medicos_seleccionados.php",
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
			$('#clickmeSmS').click(function(e){ oTableSerS.draw(); });
			
			$("#beneficio_s").change(function(e){ $('#clickmeSe').click();});
			$("#sucursal_fi_p").change(function(e){ $('#clickmeSe').click();});
			
			//FARMACIA
			var oTablePro = $('#dataTableBproductos').DataTable({
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
			});
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
				serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
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
			//FIN FARMACIA*/
					
			$('#myModal4').modal('show');
			$('#myModal4').on('shown.bs.modal', function (e) {
				$('#form-2').validator(); $('#form-2 input').keyup(function(e) { $('#alerta1').hide(); });
			});
			$('#myModal4').on('hidden.bs.modal', function (e) { 
				if(ref){ window.setTimeout(function(){historialPaciente($('#mi_histo').val());},300); }else{ }
				$("#myModal4 .modal-content").remove(); $("#myModal4").empty();
			});
		} });
	},300);
}

function forzarImpresion(id){
	console.warn("imprimiendo: ", id);
	$("#myModal1").load('pacientes/htmls/ticket.php', function( response, status, xhr ){ if(status=="success"){
		//var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-144;
		$('#contenedorAnteriores, #myAbonadoA').hide();
		$("#myModal2").modal("hide");
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
				var aleatorio = id; aoData.push(  {"name": "aleatorio", "value": aleatorio } );
			},
			"oLanguage": {
				"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"LA ORDEN DE VENTA ESTA VACIA",
				"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", "sSearch": "BUSCAR"
			},"iDisplayLength": 50000, paging: false
		});

		var datosTi = {noAleatorio:id};
		$.post('pacientes/files-serverside/datosTicketNV.php',datosTi).done(function(data){
			var datosT = data.split(';}'); if(datosT[5]==''){datosT[5]=0;} //alert(data);
			//para el ticket
			$('#fechaT').text(datosT[0]);$('#referenciaT').text(datosT[1]);$('#pacienteT').text(datosT[2]);
			$('#adicionalesT').text(datosT[10]);$('#totalT').text(datosT[4]);$('#pagoT').text(datosT[5]);
			$('#saldoT').text(datosT[6]);$('#usuarioIT').text(datosT[33]);$('#fechaIT').text(datosT[8]);
			$('#medicoAtendioIT').text(datosT[32]);
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
			$('#fechaOv').text(datosT[34]);
			
			$('#imprimirTic').click(function(e){ $('#tablaTicket').css('font-size','8px').printElement();});
		});
		
		$('#myModal1').modal('show');
		$('#myModal1').on('hidden.bs.modal',function(e){ $("#myModal1 .modal-content").remove(); $("#myModal1").empty(); });
	}});	
}

function nuevaVisita(idP, nombreP){
	$("#myModal4").load('pacientes/htmls/ficha_ov.php', function( response, status, xhr ){ if(status=="success"){
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
		
		$.fn.datepicker.defaults.autoclose = true; var nv = new Date(); var k = 0;
		
		$('#aleatorio_ov, #aleatorio_ov_a').val(nv.format('Y-m-d-H-i-s-u').substring(0,22)); 	
		
		$('#id_paciente_ov').val(idP);
		
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
				var datosP = $('#myModal4 #form-2').serialize();
				var con_ov = {noTemp: $('#aleatorio_ov').val()}
				$.post('pacientes/files-serverside/conceptos_ov.php',con_ov).done(function( data ) {
					if(data != 1){
						swal({
						title: "ERROR", text: "LA ORDEN DE VENTA ESTA VACÍA", type: "error", showCancelButton: false, cancelButtonText: "Salir", closeOnConfirm: false
						});
					}else{
						var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
						$.post('pacientes/files-serverside/guardar_ov.php',datosP).done(function( data ) { var datil = data.split(';]');
							if (datil[0]==1){//si el paciente se Actualizó 
								$('#clickme').click(); $btn.button('reset'); $('#btn_cancel1').show(); $('#myModal4').modal('hide');
								swal({
								title: "VENTA REALIZADA", text: "¿Deseas imprimir el ticket de venta "+datil[1]+"?", type: "success", showCancelButton: true,
								confirmButtonText: "Imprimir", cancelButtonText: "Salir", closeOnConfirm: false
								},
								function(){
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
											$('#saldoT').text(datosT[6]);$('#usuarioIT').text(datosT[33]);$('#fechaIT').text(datosT[8]);
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
											$('#fechaOv').text(datosT[34]);
											$('#imprimirTic').click(function(e){ $('#tablaTicket').css('font-size','8px').printElement();});
										});
										
										$('#myModal1').modal('show');
										$('#myModal1').on('shown.bs.modal',function(e){ });
										$('#myModal1').on('hidden.bs.modal',function(e){ $("#myModal1 .modal-content").remove(); $("#myModal1").empty(); });
									}});
									swal.close();
								});
							} else{alert(datil[0]);}
						});
					}
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
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
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
			"aoColumns":[
				{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}
			],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/estudios_seleccionados_imagen.php",
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
		$('#clickmeEiS').click(function(e){ oTableEimS.draw();});
		$("#beneficio_i").change(function(e){ $('#clickmeIm').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmeIm').click();});
		
		var oTableEla = $('#dataTableBestudiosL').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){
				$('body').popover({ selector: '[data-toggle="popover"]', 'trigger': 'hover', 'placement': 'auto' }); //$('[data-toggle="popover"]').popover({ }); 
			}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
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
			/*if(rowData[0][8]==undefined){*/var coveni = 0, ocu = 0;/*}else{var coveni = rowData[0][8], ocu = rowData[0][9];}*/
			subirEstudioL(rowData[0][7], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(), $('#medico_l').val(),
				$('#mi_id_convenioL').val(),$('#sucursal_fi_p').val(),$('#observacionesL_NV').val(), 2, rowData[0][2], 3, coveni, ocu, rowData[0][8]
			); 
			$('.desc_cargo_l').change(function(e){nota_desc_cargo_l();}); $('.desc_cargo_l').keyup(function(e){nota_desc_cargo_l();});
		} );

		$('#forma_pago_ov').load('pacientes/files-serverside/formas_pago.php',function(response,status,xhr){
            if(status=="success"){
                
            }
        });
			
		var oTableElaS = $('#dataTableElS').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/estudios_seleccionados_laboratorio.php",
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
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/servicios_medicos_seleccionados.php",
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
				$('#mi_id_convenioC1').val(),$('#sucursal_fi_p').val(),$('#observacionesC1_NV').val(),2,rowData[0][2], 2, coveni, ocu, rowData[0][6]
			); 
			$('.desc_cargo_c1').change(function(e){nota_desc_cargo_c1();}); $('.desc_cargo_c1').keyup(function(e){nota_desc_cargo_c1();});
		} );
		
		var oTableCoS1 = $('#dataTableCmS1').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true, width:"3%"},{"bVisible":true, width:"50%"},{"bVisible":true, width:"20%"},{"bVisible":true, width:"4%"},{"bVisible":true, width:"4%"},{"bVisible":true, width:"4%"},{"bVisible":true, width:"10%"},{"bVisible":true, width:"5%"}],
			"sDom": '<"">r<""t><""S><"">', 
			deferRender: true, select: false, "processing": false, "sAjaxSource": "pacientes/js/datatable-serverside/consultas_seleccionadas.php",
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
		$('#clickmeCoS1').click(function(e){ oTableCoS1.draw(); }); $('#t_con').click(function(e){ $('#clickmeCo1,#clickmeCoS1').click(); });
		
		$("#beneficio_c1").change(function(e){ $('#clickmeCo1').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmeCo1').click();});
		//FIN CONSULTAS
		
		//FARMACIA
		var oTablePro = $('#dataTableBproductos').DataTable({
			serverSide: true,"sScrollY": 100, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
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
		});
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
			if(rowData[0][9]==undefined){var coveni = 0, ocu = 0;}else{var coveni = rowData[0][9], ocu = rowData[0][10];}
			subirProductoS(rowData[0][5], $('#aleatorio_ov').val(), idP, $('#id_usr_reg').val(),
				$('#mi_id_convenioP').val(),$('#sucursal_fi_p').val(),$('#observacionesS_NV').val(),3,rowData[0][3], 5, coveni, ocu
			); 
			$('.desc_cargo_p').change(function(e){nota_desc_cargo_p();}); $('.desc_cargo_p').keyup(function(e){nota_desc_cargo_p();});
		} );
		
		var oTableProS = $('#dataTablePS').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false,
			"scrollX":true, "fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){}, scroller:false, responsive:true,
			"aoColumns":[{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true}],
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
		$('#clickmePS').click(function(e){ 
			oTableProS.draw();
		}); 
		$('#t_farm').click(function(e){ 
			$('#clickmePS,#clickmePr').click();
		});
		
		$("#beneficio_p").change(function(e){ $('#clickmePr').click();});
		$("#sucursal_fi_p").change(function(e){ $('#clickmePr').click();});
		//FIN FARMACIA
				
		$('#myModal4').modal('show');
		$('#myModal4').on('shown.bs.modal', function (e) {
			$('#form-2').validator(); $('#form-2 input').keyup(function(e) { $('#alerta1').hide(); });
			window.setTimeout(function(){$('#clickmeCo1, #clickmeCoS1').click()},200)
		});
		$('#myModal4').on('hidden.bs.modal', function (e) { 
			//if(ref){ window.setTimeout(function(){historialPaciente($('#mi_histo').val());},300); }else{ }
			$("#myModal4 .modal-content").remove(); $("#myModal4").empty();
		});
	} });
}

function borrarItemNV(idConcepto){//Imagen
	var datosBINV = {idConcepto:idConcepto}
	$.post('pacientes/files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ $('#clickmeEiS,#clickmeIm').click();
		//--inicio-- Despues de eliminar un item, procedemos a sumar el descuento y mostrarlo en el input
		var datosi={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_descuentos_imagen.php',datosi).done(function(data2){
			// $('#da_descuento_i').val(data2);
				$('#da_descuento_i_secreto').val(parseFloat(data2));
				$('#to_descuento_i').val(parseFloat(0+$('#da_descuento_i').val()) + parseFloat(0+$('#da_descuento_i_secreto').val()));
				calcular_totales();
		});
		//--fin--
		var datos={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_precios_imagen.php',datos).done(function(data){
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_i').val(), ce = $('#cargo_extra_i').val(), dd = $('#da_descuento_i').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_i').val(data);
			if(parseFloat(pd)){ $('#to_descuento_i').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){
				// $('#to_descuento_i').val(dd);
				$('#to_descuento_i').val(parseFloat(0+$('#da_descuento_i').val()) + parseFloat(0+$('#da_descuento_i_secreto').val()));
			}else{
				// $('#to_descuento_i').val(0);
				$('#to_descuento_i').val(parseFloat(0+$('#da_descuento_i').val()) + parseFloat(0+$('#da_descuento_i_secreto').val()));
			}
			if(parseFloat($('#precio_i').val())<=0){
				$('#da_descuento_i').val(0);
				$('#cargo_extra_i').val(0);
				$('#po_descuento_i').val(0);
				$('#to_descuento_i').val(0);
			}
			if( parseFloat($('#precio_i').val()) < parseFloat($('#da_descuento_i').val()) ){
				$('#da_descuento_i').val($('#precio_i').val());
				$('#to_descuento_i').val($('#precio_i').val());
			}
			calcular_totales();

			// Actualizamos la tabla resumen del apartado de imagen
			if ($('#precio_i').val() == 0) {
				$('#row_descuento_imagen_directo').remove();
				$('#row_descuento_imagen_porcentaje').remove();
				$('#motivo_descuento_i').val('');
			}
			actualizarTablaDescuentos('imagen');
		});
	} else{alert(data);} });
}
function borrarItemNVL(idConcepto){
	var datosBINV = {idConcepto:idConcepto}
	$.post('pacientes/files-serverside/eliminarItem.php',datosBINV).done(function( data ) { 
	if (data==1){ $('#clickmeElS,#clickmeLa').click();
		//--inicio-- Despues de eliminar un item, procedemos a sumar el descuento y mostrarlo en el input
		var datosi={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_descuentos_lab.php',datosi).done(function(data2){
			$('#da_descuento_l_secreto').val(parseFloat(data2));
			$('#to_descuento_l').val(parseFloat(0+$('#da_descuento_l').val()) + parseFloat(0+$('#da_descuento_l_secreto').val()));
			calcular_totales();
		});
		//--fin--
		var datos={aleatorio:$('#aleatorio_ov').val()}
		$.post('pacientes/files-serverside/sumar_precios_laboratorio.php',datos).done(function(data){
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_l').val(), ce = $('#cargo_extra_l').val(), dd = $('#da_descuento_l').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_l').val(data);
			if(parseFloat(pd)){ $('#to_descuento_l').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){
				// $('#to_descuento_l').val(dd);
				$('#to_descuento_l').val(parseFloat(0+$('#da_descuento_l').val()) + parseFloat(0+$('#da_descuento_l_secreto').val()));
			}else{
				// $('#to_descuento_l').val(0);
				$('#to_descuento_l').val(parseFloat(0+$('#da_descuento_l').val()) + parseFloat(0+$('#da_descuento_l_secreto').val()));
			}
			if(parseFloat($('#precio_l').val())<=0){
				$('#da_descuento_l').val(0);
				$('#cargo_extra_l').val(0);
				$('#po_descuento_l').val(0);
				$('#to_descuento_l').val(0);
			}
			if( parseFloat($('#precio_l').val()) < parseFloat($('#da_descuento_l').val()) ){
				$('#da_descuento_l').val($('#precio_l').val());
				$('#to_descuento_l').val($('#precio_l').val());
			}
			calcular_totales();

			// Antes de actualizar la tabla verificamos que haya estudios seleccionados
			if ($('#precio_l').val() == 0) {
				$('#sin_descuentos_lab').show();
				$('#row_descuento_lab_directo').remove();
				$('#row_descuento_lab_porcentaje').remove();
				$('#row_total_lab').remove();
			} else {
				actualizarTablaDescuentos('lab');
			}
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
		$.post('pacientes/files-serverside/sumar_precios_consultas.php',datos, function(dataT){
			var data = dataT[0];
			$("#da_descuento_c1").val(dataT[1]);
			if(!parseFloat(data)){data=0;}else{data=data;}
			if($('#hay_iva_ov').val()==1){$('#cb_facturada_ov').click();}
			var pd = $('#po_descuento_c1').val(), ce = $('#cargo_extra_c1').val(), dd = $('#da_descuento_c1').val();
			if(!parseFloat(pd)){var porcentaje_d = 0;}else{var porcentaje_d = pd;}
			if(parseFloat(ce)){var cargo_extra = ce;}else{var cargo_extra = 0;}
	
			$('#precio_c1').val(data);
			if(parseFloat(pd)){ $('#to_descuento_c1').val( (parseFloat(data)*parseFloat(pd))/100 ); }
			else if(parseFloat(dd)){$('#to_descuento_c1').val(dd);}else{$('#to_descuento_c1').val(0);}
			calcular_totales();
		}, "json");

		// Actualizamos la tabla resumen del apartado de consultas
		actualizarTablaDescuentos('consultas');
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
function subirEstudioL(idE,noAleatorio, idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene,ocup,po){
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), ocupado:ocup, precio_original:po
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
function subirEstudioC1(idE,noAleatorio,idP, idU, idMedico, idConvenio, idSucursal, observaciones, departamento,p,t,id_con_bene,ocup, honor){
	var datosSENV = {noAleatorio:noAleatorio, idP:idP, idU:idU, idMedico:idMedico, idE:idE, agendar:$('#agendarOV').val(),
		idConvenio:idConvenio, idSucursal:idSucursal, observaciones:observaciones, departamento:departamento,
		precioTo:p,tipoConcepto:t,id_con_bene:id_con_bene,fechaC:$('#fichaNV').val()+' '+$('#horaNV').val(), ocupado:ocup, honor: honor
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
		}else if(data==2){
			swal({ title: "", type: "error", text: "El medicamento no cuenta con existencias.", timer: 1800, showConfirmButton: false });
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
		// if(this.id==id){} else{ if(parseFloat(v)){$('#'+this.id).val(0);} }
		//se le agrega condicional extra para que no resetee los campos de descuento directo y cargo extra
		if(this.id==id){} else{ if(parseFloat(v)&&id=='po_descuento_i'){$('#da_descuento_i').val(0);}else if(id=='da_descuento_i'){$('#po_descuento_i').val(0);} }
		//guardamos en tabla conceptos_carg_desc
		if(parseFloat($('#po_descuento_i').val())>=0||$('#po_descuento_i').val()==''){
			guardar_cargo_desc($('#id_usr_reg').val(),1,$('#aleatorio_ov').val(),$('#po_descuento_i').val(),$('#motivo_descuento_i').val(),'imagen');
		}
		if(parseFloat($('#da_descuento_i').val())>=0||$('#da_descuento_i').val()==''){
			guardar_cargo_desc($('#id_usr_reg').val(),0,$('#aleatorio_ov').val(),$('#da_descuento_i').val(),$('#motivo_descuento_i').val(),'imagen');
		}
		if(parseFloat($('#cargo_extra_i').val())>=0||$('#cargo_extra_i').val()==''){
			guardar_cargo_desc($('#id_usr_reg').val(),2,$('#aleatorio_ov').val(),$('#cargo_extra_i').val(),$('#motivo_cargo_i').val(),'imagen');
		}

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
		// if(this.id==id){} else{ if(parseFloat(v)){$('#'+this.id).val(0);} }
		if(this.id==id){} else{ if(parseFloat(v)&&id=='po_descuento_l'){$('#da_descuento_l').val(0);}else if(id=='da_descuento_l'){$('#po_descuento_l').val(0);} }
		//guardamos en tabla conceptos_carg_desc
		if(parseFloat($('#po_descuento_l').val())>=0||$('#po_descuento_l').val()==''){
		guardar_cargo_desc($('#id_usr_reg').val(),1,$('#aleatorio_ov').val(),$('#po_descuento_l').val(),$('#motivo_descuento_l').val(),'laboratorio');
		}
		if(parseFloat($('#da_descuento_l').val())>=0||$('#da_descuento_l').val()==''){
			guardar_cargo_desc($('#id_usr_reg').val(),0,$('#aleatorio_ov').val(),$('#da_descuento_l').val(),$('#motivo_descuento_l').val(),'laboratorio');
		}
		if(parseFloat($('#cargo_extra_l').val())>=0||$('#cargo_extra_l').val()==''){
			guardar_cargo_desc($('#id_usr_reg').val(),2,$('#aleatorio_ov').val(),$('#cargo_extra_l').val(),$('#motivo_cargo_l').val(),'laboratorio');
		}

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
	//revisa la BD en busca de descuentos y los coloca en el resumen de orden de venta
	var datos = { no_temp_vc:$('#aleatorio_ov').val() }
	$.post('pacientes/files-serverside/getConceptoDescuento.php',datos).done(function(data1){ //alert(data1);
		var datosI = data1.split(',');
		var cadena = "";
		for (var i = 0; i < datosI.length; i++) {
			var concepto = datosI[i];
			concepto = concepto.replace(/[\[\]"]/g, '');
			if(concepto !== 'null' ){
				cadena = cadena + concepto + "<br/>";
			}
		}
		$('#descuento_concepto').html(cadena);
	});
	
	window.setTimeout(function(){
		if($('#precio_c1').val()>=0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_consulta.php',datos).done(function(data){
				var dato = data.split('{:;]}');
				$('#aqui_consulta').html(data);
			});
		}else{ $('#aqui_consulta').html(''); }
		if($('#precio_i').val()>=0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_imagen.php',datos).done(function(data){ $('#aqui_imagen').html(data); });
		}else{ $('#aqui_imagen').html(''); }
		if($('#precio_l').val()>=0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_laboratorio.php',datos).done(function(data){
				$('#aqui_laboratorio').html(data);
			});
		}else{ $('#aqui_laboratorio').html(''); }
		if($('#precio_s').val()>=0){
			var datos={aleatorio:$('#aleatorio_ov').val()}
			$.post('pacientes/files-serverside/detalle_servicios.php',datos).done(function(data){ $('#aqui_servicios').html(data); });
		}else{ $('#aqui_servicios').html(''); }
		if($('#precio_p').val()>=0){
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
	$.post('pacientes/files-serverside/sumar_precios_consultas.php',datos, function(dataT){
		var data = dataT[0];
		$("#da_descuento_c1").val(dataT[1]);
		dd = dataT[1];
		if(!parseFloat(data)){data=0;}else{data=data;}
		$('#precio_c1').val(data);
		if(parseFloat(pd)){ $('#to_descuento_c1').val( (parseFloat(data)*parseFloat(pd))/100 ); }
		else if(parseFloat(dd)){$('#to_descuento_c1').val(dd);}else{$('#to_descuento_c1').val(0);}
		calcular_totales();
	}, "json");
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
		else if(parseFloat(dd)){
			/* $('#to_descuento_i').val(dd); */
			$('#to_descuento_i').val(parseFloat(0+$('#da_descuento_i').val()) + parseFloat(0+$('#da_descuento_i_secreto').val()));
		}else{
			/* $('#to_descuento_i').val(0); */
			$('#to_descuento_i').val(parseFloat(0+$('#da_descuento_i').val()) + parseFloat(0+$('#da_descuento_i_secreto').val()));
		}
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
		else if(parseFloat(dd)){
			// $('#to_descuento_l').val(dd);
			$('#to_descuento_l').val(parseFloat(0+$('#da_descuento_l').val()) + parseFloat(0+$('#da_descuento_l_secreto').val()));
		}else{
			// $('#to_descuento_l').val(0);
			$('#to_descuento_l').val(parseFloat(0+$('#da_descuento_l').val()) + parseFloat(0+$('#da_descuento_l_secreto').val()));
		}
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
	// if(i>0){$('.depende_descuento_i').removeClass('hidden');}else{$('.depende_descuento_i').addClass('hidden');}
	if(parseFloat($('#da_descuento_i').val())>0 || parseFloat($('#po_descuento_i').val())>0){
		$('.depende_descuento_i').removeClass('hidden');
	}else{
		$('.depende_descuento_i').addClass('hidden');
	}
	if(parseFloat($('#cargo_extra_i').val())>0){
		$('.depende_descuento_i2').removeClass('hidden');
	}else{
		$('.depende_descuento_i2').addClass('hidden');
	}
}
function nota_desc_cargo_l(){ var i = 0;
	$('.desc_cargo_l').each(function(index, element) { if($(this).val()>0){i++;} });
	// if(i>0){$('.depende_descuento_l').removeClass('hidden');}else{$('.depende_descuento_l').addClass('hidden');}
	if(parseFloat($('#da_descuento_l').val())>0 || parseFloat($('#po_descuento_l').val())>0){
		$('.depende_descuento_l').removeClass('hidden');
	}else{
		$('.depende_descuento_l').addClass('hidden');
	}
	if(parseFloat($('#cargo_extra_l').val())>0){
		$('.depende_descuento_l2').removeClass('hidden');
	}else{
		$('.depende_descuento_l2').addClass('hidden');
	}
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
		$('#myModal2').on('hidden.bs.modal', function (e) { $("#myModal2").empty(); });
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
var ultima_ubica = null;
var bloqueo_ubica = true;
var ubicaDobleX = null;
var ubicaDobleY = null;
function calculaUbica(){
	bloqueo_ubica = false;
	if(ubicaDobleX != null){
		ultima_ubica = null;
		siempre(ubicaDobleX, ubicaDobleY);
		ubicaDobleX = null;
		ubicaDobleY = null;
	}else{
		if(ultima_ubica != null)
			ubicacion(ultima_ubica);
	}
	bloqueo_ubica = true;
}
function ubicacion(ubi){
	ultima_ubica = ubi;	
	if(bloqueo_ubica)
		return;
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
	$("#myModal2").load("pacientes/htmls/cancelar_OV.php", function(response,status,xhr){ if(status == "success"){
		$('#titulo_modal').text('CANCELACIÓN DE LA ORDEN DE VENTA ' + refe);

		$('#form_cov').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
		  } else { // everything looks good!
			e.preventDefault(); 
			$('#pacienteCancelOV').text(nombreP); $('#refCancelOV').text(refe);
			swal({
			title: "CANCELAR LA ORDEN DE VENTA "+refe +" DEL PACIENTE "+nombreP, text: "¿Estás seguro de cancelar la orden?", type: "warning",
			showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Cancelarla", 
			cancelButtonText: "Cerrar", closeOnConfirm: false
			},
			function(){
			var datosCOV = {refe:refe, motivo: $("#m_cancelacion").val()}
				$.post('pacientes/files-serverside/pre_cancelarOV.php',datosCOV).done(function( data ) { 
					if (data==1){ window.setTimeout(function(){$('#clickme_hv, #clickme').click(); $('#myModal2').modal('hide');},300);
						swal({
						title: "", type: "success", text: "La orden de venta se ha cancelado", timer: 2000, showConfirmButton: false
						}); return;
					} else{alert(data);} 
				});
			});
		  }
		});
				
		$('#myModal2').modal('show');
		$('#myModal2').on('shown.bs.modal', function (e){ });
		$('#myModal2').on('hidden.bs.modal', function (e) { $("#myModal2").empty(); });
	} });
}

function guardar_cargo_desc(personal,tipo,temp,monto,motivo,area){
	var datos = {personal:personal,tipo:tipo,temp:temp,monto:monto,motivo:motivo,area:area}
	$.post('pacientes/files-serverside/guardar_cargo_descuento.php',datos).done(function( data ) { 
		/* if (data==1){ window.setTimeout(function(){$('#clickme_hv, #clickme').click(); $('#myModal2').modal('hide');},300);
			swal({
			title: "", type: "success", text: "La orden de venta se ha cancelado", timer: 2000, showConfirmButton: false
			}); return;
		} else{alert(data);}  */
	});
}

function initMap() { }

// Inicio tablas individuales de descuentos

// Inicio definición de variables y funciones que permiten actualizar la información de las tablas de resumen de los descuentos
const urlConsultas = 'pacientes/js/datatable-serverside/getDescConsultasSeleccionadas.php';
const urlImagen = 'pacientes/js/datatable-serverside/getDescImagenSeleccionadas.php';
const urlLab = 'pacientes/js/datatable-serverside/getDescLabSeleccionadas.php';
let resumenDescuentos = {
	descuentos: [],
	body: '',
	rowDescuento: '',
	rowTotal: '',
	rowSinDescuentos: '',
	total: 0.00,

};
let resumenTitulo = '';
let resumenFlecha = '';
let resumenTabla = '';

/**
 * Función que define los campos del resumen que se va a actualizar.
 * @param { any[] } descuentos arreglo en el que se guardan los descuentos obtenidos
 * @param { String } body id del <tbody> de la <table> en el que se pintarán los descuentos
 * @param { String } rowDesc clase del <tr> en el que se pintarán cada uno de los descuentos
 * @param { String } rowTotal id del <tr> en el que se pintará el total de los descuentos
 * @param { String } rowSinDesc id del <tr> que se pinta cuando no hay ningún descuento aplicado
 * @param { String } total suma de todos los montos de los descuentos
 */
const setResumenData = (descuentos, body, rowDesc, rowTotal, rowSinDesc, total) => {
	resumenDescuentos.descuentos = descuentos;
	resumenDescuentos.body = body;
	resumenDescuentos.rowDescuento = rowDesc;
	resumenDescuentos.rowTotal = rowTotal;
	resumenDescuentos.rowSinDescuentos = rowSinDesc;
	resumenDescuentos.total = total;
};

const setShowTablaCategoria = (titulo, flecha, tabla) => {
	resumenTitulo = titulo;
	resumenFlecha =flecha;
	resumenTabla = tabla;
};

const definirCategoria = async (categoria) => {
	if (categoria === 'imagen') {
		return setResumenData(await getDescuentos(urlImagen).then(data => data), '#resumen_imagen_body', 'row_descuento_imagen', 'row_total_imagen', '#sin_descuentos_imagen', 0.00);
	}
	if(categoria === 'lab') {
		return setResumenData(await getDescuentos(urlLab).then(data => data), '#resumen_lab_body', 'row_descuento_lab', 'row_total_lab', '#sin_descuentos_lab', 0.00);
	}
	if(categoria === 'servicios') {
		return ;
	}
	if (categoria === 'farmacia') {
		return ;
	}
	if (categoria === 'consultas') {
		return setResumenData(await getDescuentos(urlConsultas).then(data => data), '#resumen_consultas_body', 'row_descuento_consultas', 'row_total_consultas', '#sin_descuentos_consultas', 0.00);
	}
};

const definirTabla = async (tabla) => {
	if (tabla === 'imagen') {
		return setShowTablaCategoria('.resumen_imagen_titulo', '.flecha_icono_imagen', '#resumen_imagen');
	}
	if(tabla === 'lab') {
		return setShowTablaCategoria('.resumen_lab_titulo', '.flecha_icono_lab', '#resumen_lab');;
	}
	if(tabla === 'servicios') {
		return ;
	}
	if (tabla === 'farmacia') {
		return ;
	}
	if (tabla === 'consultas') {
		return setShowTablaCategoria('.resumen_consultas_titulo', '.flecha_icono_consultas', '#resumen_consultas');
	}
};
// Fin definición de variables y funciones que permiten actualizar la información de las tablas de resumen de los descuentos

// Inicio de la función que consulta los descuentos de una categoría
const getDescuentos = (url) => {
	return fetch(`${url}?aleatorio=${$('#aleatorio_ov').val()}`,{method: 'get'})
	.then(response => response.json())
	.catch(error => alert(error));
}
// Fin de la función que consulta los descuentos de una categoría

// Inicio de la función que actualiza y pinta las tablas de descuentos
const actualizarTablaDescuentos = async (categoria) => {
	await definirCategoria(categoria);

	let idMontoTotal = '';
	let classMontoDesc = '';
	if (categoria === 'imagen') {
		idMontoTotal = 'montoTotalDescuentosImg'
		classMontoDesc = 'monto_desc_acum_img';
	};

	if (categoria === 'lab') {
		idMontoTotal = 'montoTotalDescuentosLab';
		classMontoDesc = 'monto_desc_acum_lab';
	}

	$(`.${resumenDescuentos.rowDescuento}`).remove();
	$(`#${resumenDescuentos.rowTotal}`).remove();
	resumenDescuentos.total = 0.00;

	if (resumenDescuentos.descuentos.length === 0) {
		if ($('#row_descuento_imagen_directo').length === 1) {
			let montoDescDirec = parseFloat($('#monto_imagen_directo').text().slice(1, $('#monto_imagen_directo').text().length));
			$('#row_descuento_imagen_directo').remove();
			return setDescuentoDirectoImagen($('#motivo_descuento_i').val(), montoDescDirec, montoDescDirec, 1);
		}

		// Verificamos que solo queden los descuentos por porcentaje o directo de laboratorio
		if ($('#row_descuento_lab_directo').length === 1) {
			$('#row_descuento_lab_directo').remove();
			return insertarUnicoDescuentoDirectoLab($('#motivo_descuento_l').val(), parseFloat($('#to_descuento_l').val()));
		}

		if ($('#row_descuento_lab_porcentaje').length === 1) {
			$('#num_desc_lab_porc').text('1');
			$('#resumen_lab_body').append(`
				<tr id='row_total_lab'>
					<th colspan='3'>Total</th>
					<td><strong id='montoTotalDescuentosLab'>${$('#monto_lab_porcentaje').text()}</strong></td>
				</tr>
			`);
			return ;
		}
		return $(resumenDescuentos.rowSinDescuentos).show();
	}

	$(resumenDescuentos.rowSinDescuentos).hide();

	if ($('#row_descuento_imagen_directo').length === 1) {
		resumenDescuentos.total += parseFloat($('#monto_imagen_directo').text().slice(1, $('#monto_imagen_directo').text().length));
		$('#desc_direc_num').text('1');
	}

	// Verificamos si hay descuento directo o por porcentaje en laboratorio
	if ($('#row_descuento_lab_porcentaje').length > 0) {
		$('#row_descuento_lab_porcentaje').remove();
	}

	if ($('#row_descuento_lab_directo').length === 1) {
		resumenDescuentos.total += parseFloat($('#monto_lab_directo').text().slice(1, $('#monto_lab_directo').text().length));
		$('#num_desc_lab_direc').text('0');
	}

	for (let i = 0; i < resumenDescuentos.descuentos.length; i++) {
		resumenDescuentos.total += parseFloat(resumenDescuentos.descuentos[i].monto);

		if ($('#row_descuento_imagen_directo').length === 1) { resumenDescuentos.descuentos[i].num++; }

		$(resumenDescuentos.body).append(`
			<tr class='${resumenDescuentos.rowDescuento}'>
				<td style='text-align: center;'><strong class='imagen_normal_num'>${resumenDescuentos.descuentos[i].num}</strong></td>
				<td>${resumenDescuentos.descuentos[i].nombre}</td>
				<td>${resumenDescuentos.descuentos[i].concepto}</td>
				<td class='${classMontoDesc}'>$${resumenDescuentos.descuentos[i].monto}</td>
			</tr>
		`);
	}
	$(resumenDescuentos.body).append(`
		<tr id='${resumenDescuentos.rowTotal}'>
			<th colspan='3'>Total</th>
			<td><strong id='${idMontoTotal}'>$${resumenDescuentos.total}</strong></td>
		</tr>
	`);
};
// Fin de la función que actualiza y pinta las tablas de descuentos

// Inicio de la función que muestra u oculta la tablas de descuentos
const showTablaDescuentos = (categoria) => {
	definirTabla(categoria);

	if ($(resumenTitulo).attr('estado') === 'hidden') {
		$(resumenTitulo).attr('estado', 'shown');
		$(resumenFlecha).text('↑');
		$(resumenTabla).show();
	} else {
		$(resumenTitulo).attr('estado', 'hidden');
		$(resumenFlecha).text('↓');
		$(resumenTabla).hide();
	}
};

const mostrarDescuentoDirecto = () => {
	if ($('#da_descuento_i').val() == 0 || $('#motivo_descuento_i').val() === '') {
		let montoTotalDescuentosImg = parseFloat(
			$('#montoTotalDescuentosImg').text().slice(1, $('#montoTotalDescuentosImg').text().length)
		);
		let monto_imagen_directo = parseFloat(
			$('#monto_imagen_directo').text().slice(1, $('#monto_imagen_directo').text().length)
		);
		if (Number.isNaN(monto_imagen_directo)) monto_imagen_directo = 0;
		montoTotalDescuentosImg -= monto_imagen_directo;
		$('#montoTotalDescuentosImg').text(`$${montoTotalDescuentosImg}`);
		$('#row_descuento_imagen_directo').remove();

		if ($('.row_descuento_imagen').length === 0) {
			$('#sin_descuentos_imagen').show();
			$('#row_total_imagen').remove();
			return ;
		}

		$('.imagen_normal_num').each((index, element) => {
			element.textContent = ++index;
		})
		return ;
	}

	if ($('#row_descuento_imagen_directo').length === 0 && $('.row_descuento_imagen').length > 0) {
		let descuentosCont = $('.row_descuento_imagen').length + 1;
		let descuentoDirecto = parseFloat($('#da_descuento_i').val());
		let descuentoTotalActual = parseFloat($('#montoTotalDescuentosImg').text().slice(1, $('#montoTotalDescuentosImg').text().length));
		let nuevoTotalDescuentoImg = parseFloat(descuentoTotalActual + descuentoDirecto);
		$('#row_total_imagen').remove();
		return setDescuentoDirectoImagen($('#motivo_descuento_i').val(), parseFloat($('#da_descuento_i').val()), nuevoTotalDescuentoImg, descuentosCont);
	}

	// Verificamos el estado de la tabla
	if ($('#row_descuento_imagen_directo').length > 0) {
		if ($('.row_descuento_imagen').length > 0) {
			let totalActual = parseFloat($('#montoTotalDescuentosImg').text().slice(1, $('#montoTotalDescuentosImg').text().length));
			let descuentoDirectoActual = parseFloat($('#monto_imagen_directo').text().slice(1, $('#monto_imagen_directo').text().length));
			let nuevoTotal = parseFloat(totalActual - descuentoDirectoActual + parseFloat($('#da_descuento_i').val()));
			$('#concepto_imagen_directo').text($('#motivo_descuento_i').val());
			$('#monto_imagen_directo').text(`$${parseFloat($('#da_descuento_i').val())}`);
			$('#montoTotalDescuentosImg').text(`$${nuevoTotal}`);
			return ;
		}

		if ($('#row_descuento_imagen').length === 0) {
			$('#concepto_imagen_directo').text($('#motivo_descuento_i').val());
			$('#monto_imagen_directo').text(`$${parseFloat($('#da_descuento_i').val())}`);
			$('#montoTotalDescuentosImg').text(`$${parseFloat($('#da_descuento_i').val())}`);
			return ;
		}
	}

	// Verificamos si existe un registro de descuento directo
	if ($('#row_descuento_imagen_porcentaje').length === 1) {
		$('#row_descuento_imagen_porcentaje').remove();
		$('#row_total_imagen').remove();
		return setDescuentoDirectoImagen($('#motivo_descuento_i').val(), $('#da_descuento_i').val(), $('#da_descuento_i').val());
	}

	return setDescuentoDirectoImagen($('#motivo_descuento_i').val(), $('#da_descuento_i').val(), $('#da_descuento_i').val());
};

const mostrarDescuentoPorcentaje = () => {
	if ($('#po_descuento_i').val() == 0 || $('#motivo_descuento_i').val() === '' || parseFloat($('#precio_i').val()) === 0 && ($('#row_descuento_imagen_porcentaje').length === 0 && $('#row_descuento_imagen_directo').length === 0)) {
		if ($('#row_descuento_imagen_porcentaje').length > 0) {
			$('#row_descuento_imagen_porcentaje').remove();
		}
		$('#row_total_imagen').remove();
		$('#sin_descuentos_imagen').show();
		return ;
	}

	if ($('#row_descuento_imagen_porcentaje').length > 0) {
		$('#monto_imagen_porcentaje').text(`$${(parseFloat($('#po_descuento_i').val()) / 100) * parseFloat($('#precio_i').val())}`);
		$('#concepto_imagen_porcentaje').text(`${$('#motivo_descuento_i').val()}`);
		$('#montoTotalDescuentosImg').text(`$${parseFloat($('#monto_imagen_porcentaje').text().slice(1, $('#monto_imagen_porcentaje').text().length))}`);
		return ;
	}

	if ($('#row_descuento_imagen_directo').length > 0) $('#row_descuento_imagen_directo').remove();
	if ($('.row_descuento_imagen').length > 0) $('.row_descuento_imagen').remove();
	$('#row_total_imagen').remove();

	return setDescuentoPorcentajeImagen($('#motivo_descuento_i').val(), parseFloat($('#po_descuento_i').val()) / 100);
};

// Inicio funciones para manejar los descuentos directos y por porcentaje del apartado de imagen
const setDescuentoDirectoImagen = (concepto, monto, montoTotal, index = 1) => {
	$('#sin_descuentos_imagen').hide();
	$('#resumen_imagen_body').append(`
		<tr id='row_descuento_imagen_directo'>
			<td style='text-align: center;'><strong id='desc_direc_num'>${index}</strong></td>
			<td>Descuento general</td>
			<td id='concepto_imagen_directo'>${concepto}</td>
			<td id='monto_imagen_directo'>$${monto}</td>
		</tr>
	`, `
		<tr id='row_total_imagen'>
			<th colspan='3'>Total</th>
			<td><strong id='montoTotalDescuentosImg'>$${montoTotal}</strong></td>
		</tr>
	`);
	return ;
};

const setDescuentoPorcentajeImagen = (concepto, monto) => {
	$('#sin_descuentos_imagen').hide();
	$('#resumen_imagen_body').append(`
		<tr id='row_descuento_imagen_porcentaje'>
			<td style='text-align: center;'><strong>1</strong></td>
			<td>Descuento general</td>
			<td id='concepto_imagen_porcentaje'>${concepto}</td>
			<td id='monto_imagen_porcentaje'>$${monto * parseFloat($('#precio_i').val())}</td>
		</tr>
	`, `
		<tr id='row_total_imagen'>
			<th colspan='3'>Total</th>
			<td><strong id='montoTotalDescuentosImg'>$${monto * parseFloat($('#precio_i').val())}</strong></td>
		</tr>
	`);
	return ;

	
};

const seleccionarCampoDescuento = () => {
	if ($('#po_descuento_i').val() != 0) {
		return mostrarDescuentoPorcentaje();
	}
	return mostrarDescuentoDirecto();
};
// Fin funciones para manejar los descuentos directos y por porcentaje del apartado de imagen

// Inicio funciones para manejar los descuentos directos y por porcentaje del apartado de laboratorio
const handlerLabDescDirecto = (inputDescDirecto) => {
	// Verificamos que el precio de los estudios no sea 0
	if ($('#precio_l').val() == 0) {
		$('#da_descuento_l').val('0');
		return ;
	}

	// Verificamos que sea un descuento directo válido, es decir, mayor que 0
	if (inputDescDirecto.value == 0) {
		$('#motivo_descuento_l').val('');

		// Caso 1: La tabla tiene únicamente un descuento directo
		if ($('#row_descuento_lab_directo').length === 1 && $('.row_descuento_lab').length === 0) {
			return eliminarUnicoDescuentoDirectoLab();
		}

		// Caso 2: La tabla tiene registros de descuentos normales y un descuento directo
		if ($('#row_descuento_lab_directo').length === 1 && $('.row_descuento_lab').length > 0) {
			return eliminarDescuentoDirectoLab();
		}

		return ;
	}

	// Caso 1: La tabla de descuentos está vacía
	if ($('#row_total_lab').length === 0) {
		return insertarUnicoDescuentoDirectoLab($('#motivo_descuento_l').val(), parseFloat($('#da_descuento_l').val()));
	}

	// Caso 2: La tabla de descuentos tiene únicamente un descuento directo
	if ($('#row_descuento_lab_directo').length === 1 && $('.row_descuento_lab').length === 0) {
		return actualizarUnicoDescuentoDirectoLab($('#motivo_descuento_l').val(), parseFloat($('#da_descuento_l').val()));
	}

	// Caso 3: La tabla de descuentos contiene únicamente descuentos normales
	if ($('#row_descuento_lab_directo').length === 0 && $('.row_descuento_lab').length > 0) {
		return insertarDescuentoDirectoLab($('#motivo_descuento_l').val(), parseFloat($('#da_descuento_l').val()));
	}

	// Caso 4: La tabla de descuentos contiene descuentos normales y un descuento directo
	if ($('#row_descuento_lab_directo').length === 1 && $('.row_descuento_lab').length > 0) {
		return actualizarDescuentoDirectoLab($('#motivo_descuento_l').val(), parseFloat($('#da_descuento_l').val()));
	}

	// Caso 5: La tabla tiene un descuento por porcentaje
	$('#row_descuento_lab_porcentaje').remove();
	$('#row_total_lab').remove();
	return insertarUnicoDescuentoDirectoLab($('#motivo_descuento_l').val(), parseFloat($('#da_descuento_l').val()));
};

const handlerLabDescPorcentaje = (inputDescPorcentaje) => {
	// Verificamos que el precio de los estudios no sea 0
	if ($('#precio_l').val() == 0) {
		$('#po_descuento_l').val('0');
		return ;
	}

	// Verificamos que sea un descuento por porcentaje válido, es decir, mayor que 0
	if (inputDescPorcentaje.value == 0) {
		$('#motivo_descuento_l').val('');

		// Caso 1: La tabla tiene únicamente un descuento por porcentaje
		if ($('#row_descuento_lab_porcentaje').length === 1) {
			return eliminarUnicoDescuentoPorcentajeLab();
		}

		return ;
	}

	// Caso 1: La tabla de descuentos está vacía
	if ($('#row_total_lab').length === 0) {
		return insertarUnicoDescuentoPorcentajeLab($('#motivo_descuento_l').val(), parseFloat((parseFloat(inputDescPorcentaje.value) / 100) * parseFloat($('#precio_l').val())));
	}

	// Caso 2: La tabla de descuentos tiene únicamente un descuento por porcentaje
	if ($('#row_descuento_lab_porcentaje').length === 1) {
		return actualizarUnicoDescuentoPorcentajeLab($('#motivo_descuento_l').val(), parseFloat((parseFloat(inputDescPorcentaje.value) / 100) * parseFloat($('#precio_l').val())));
	}
};

const eliminarDescuentoDirectoLab = () => {
	// Sumamos los montos de los descuentos normales
	let nuevoTotalAcumulado = 0.00;
	$('.monto_desc_acum_lab').each((index, elemento) => {
		nuevoTotalAcumulado += parseFloat(elemento.textContent.slice(1, elemento.textContent.length));
	});

	// Actualizamos el total con la suma de los montos anteriores y eliminamos la fila del descuento directo
	$('#montoTotalDescuentosLab').text(`$${nuevoTotalAcumulado}`);
	$('#row_descuento_lab_directo').remove();
	return ;
};

const eliminarUnicoDescuentoDirectoLab = () => {
	$('#row_descuento_lab_directo').remove();
	$('#row_total_lab').remove();
	$('#sin_descuentos_lab').show();
	return ;
};

const eliminarUnicoDescuentoPorcentajeLab = () => {
	$('#row_descuento_lab_porcentaje').remove();
	$('#row_total_lab').remove();
	$('#sin_descuentos_lab').show();
	return ;
};

const insertarUnicoDescuentoDirectoLab = (concepto, monto) => {
	$('#sin_descuentos_lab').hide();
	$('#resumen_lab_body').append(`
		<tr id='row_descuento_lab_directo'>
			<td style='text-align: center;'><strong id='num_desc_lab_direc'>1</strong></td>
			<td>Descuento directo</td>
			<td id='concepto_lab_directo'>${concepto}</td>
			<td id='monto_lab_directo'>$${monto}</td>
		</tr>
	`, `
		<tr id='row_total_lab'>
			<th colspan='3'>Total</th>
			<td><strong id='montoTotalDescuentosLab'>$${monto}</strong></td>
		</tr>
	`);
	return ;
};

const insertarUnicoDescuentoPorcentajeLab = (concepto, monto) => {
	$('#sin_descuentos_lab').hide();
	$('#resumen_lab_body').append(`
		<tr id='row_descuento_lab_porcentaje'>
			<td style='text-align: center;'><strong id='num_desc_lab_porc'>1</strong></td>
			<td>Descuento por porcentaje</td>
			<td id='concepto_lab_porcentaje'>${concepto}</td>
			<td id='monto_lab_porcentaje'>$${monto}</td>
		</tr>
	`, `
		<tr id='row_total_lab'>
			<th colspan='3'>Total</th>
			<td><strong id='montoTotalDescuentosLab'>$${monto}</strong></td>
		</tr>
	`);
	return ;
};

const insertarDescuentoDirectoLab = (concepto, monto) => {
	// Obtenemos el número de desuentos que hay en la tabla y el total actual del descuento
	let contDescuentos = $('.row_descuento_lab').length;
	let totalActual = parseFloat($('#montoTotalDescuentosLab').text().slice(1, $('#montoTotalDescuentosLab').text().length));
	
	// Eliminamos la fila de total para poder insertar la nueva fila de descuento directo y la de total actualizada
	$('#row_total_lab').remove();
	$('#resumen_lab_body').append(`
		<tr id='row_descuento_lab_directo'>
			<td style='text-align: center;'><strong>${++contDescuentos}</strong></td>
			<td>Descuento directo</td>
			<td id='concepto_lab_directo'>${concepto}</td>
			<td id='monto_lab_directo'>$${monto}</td>
		</tr>
	`, `
		<tr id='row_total_lab'>
			<th colspan='3'>Total</th>
			<td><strong id='montoTotalDescuentosLab'>$${totalActual + monto}</strong></td>
		</tr>
	`);
	return ;
};

const actualizarUnicoDescuentoDirectoLab = (concepto, monto) => {
	$('#concepto_lab_directo').text(concepto);

	// Verificamos que el valor no rebase el precio de los estudios
	if (monto > parseFloat($('#precio_l').val())) {
		monto = $('#precio_l').val();
	}

	$('#monto_lab_directo').text(`$${monto}`);
	$('#montoTotalDescuentosLab').text(`$${monto}`);
	return ;
};

const actualizarUnicoDescuentoPorcentajeLab = (concepto, monto) => {
	$('#concepto_lab_porcentaje').text(concepto);

	// Verificamos que el valor no rebase el precio de los estudios
	if (monto > parseFloat($('#precio_l').val())) {
		monto = $('#precio_l').val();
	}

	$('#monto_lab_porcentaje').text(`$${monto}`);
	$('#montoTotalDescuentosLab').text(`$${monto}`);
	return ;
};

const actualizarDescuentoDirectoLab = (concepto, monto) => {
	// Verificamos que el monto no sea mayor al total restante del precio
	let precioMaxlab = parseFloat($('#precio_l').val());
	let totalActual = parseFloat($('#montoTotalDescuentosLab').text().slice(1, $('#montoTotalDescuentosLab').text().length));
	if (precioMaxlab - monto - totalActual <= 0) {
		monto = precioMaxlab - totalActual
		$('#da_descuento_l').val(precioMaxlab - totalActual);
	}

	$('#concepto_lab_directo').text(concepto);

	// Al total actual le restamos el monto del descuento directo anterior
	let montoActualDescuentoDirecto = parseFloat($('#monto_lab_directo').text().slice(1, $('#monto_lab_directo').text().length));
	let totalActualizado = totalActual - montoActualDescuentoDirecto;

	// Actualizamos el total y las filas de la tabla
	totalActualizado += monto;
	$('#monto_lab_directo').text(`$${monto}`);
	$('#montoTotalDescuentosLab').text(`$${totalActualizado}`);
	return ;
};

const handlerMotivoDescLab = (inputMotivo) => {
	if ($('#po_descuento_l').val() == 0 && $('#da_descuento_l').val() == 0) {
		$('#motivo_descuento_l').val('');
		return ;
	} ;

	// Caso 1: El motivo del descuento es aplicado a un descuento por porcentaje
	if ($('#po_descuento_l').val() != 0 && $('#da_descuento_l').val() == 0) {
		return $('#concepto_lab_porcentaje').text(inputMotivo.value);
	}

	// Caso 2: El motivo del descuento es aplicado a un descuento directo
	if ($('#po_descuento_l').val() == 0 && $('#da_descuento_l').val() != 0) {
		return $('#concepto_lab_directo').text(inputMotivo.value);
	}
};
// Fin funciones para manejar los descuentos directos y por porcentaje del apartado de laboratorio

// Fin de la función que muestra u oculta la tablas de descuentos

// Fin tablas individuales de descuentos

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4cHSkoaQwTQjx31Y3xFf3kkSkD28X_Rs&callback=initMap"
	async defer>
</script>

<?php include_once 'partes/header.php'; 

if(isset($_GET['to_h'])){
	echo 	'<script type="text/JavaScript"> 
				$("#myModal4").addClass("modal-fullscreen");
				setTimeout(function(e){
					nuevaVisita('.htmlspecialchars($_GET['p']).',"'.htmlspecialchars_decode($_GET['n']).'");
				},300);
			</script>';
}
?>


