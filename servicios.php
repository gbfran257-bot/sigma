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
    
    <title>SISTEMA - SERVICIOS MÉDICOS</title>
    
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
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;" nowrap>PACIENTE</th>
    <th style="vertical-align:middle;">REFERENCIA</th>
    <th style="vertical-align:middle;">PERSONAL</th>
    <th style="vertical-align:middle;">CONCEPTO</th>
    <th style="vertical-align:middle;">ESTATUS</th>
    <th style="vertical-align:middle;" nowrap>TIEMPO</th>
    <th style="vertical-align:middle;">SUCURSAL</th>
    <th style="vertical-align:middle;">EDITAR</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-PACIENTE-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-REFERENCIA-" style="max-width:100px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-PERSONAL-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-CONCEPTO-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTATUS-" style="max-width:90px;"/></th>
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-SUCURASL-"/></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>SERVICIOS</li><li class="active"><strong>SERVICIOS MÉDICOS</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-149-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "servicios/datatable-serverside/servicios.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val();
			var de = $('#fechaDe').val()+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
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

function ver_ov(ref){
	$("#myModal3").load("laboratorio/htmls/ficha_ov.php",function(response,status,xhr){ if(status == "success"){
		var dato = { ref:ref, idU:$('#id_user').val() }
		$.post('laboratorio/archivos_save_ajax/datos_ficha_ov.php', dato).done(function(data){ var datos = data.split('*}');
			$('#titulo_modal').text('ORDEN DE VENTA '+ref+' | '+datos[0]+' | '+datos[1]);
			$('#fecha_o').text(datos[2]); $('#usuario_o').text(datos[3]); $('#subtotal_o').text(datos[4]); $('#extras_o').text(datos[5]);
			$('#iva_o').text(datos[6]); $('#descuento_o').text(datos[7]); $('#total_o').text(datos[8]); $('#abonado_o').text(datos[9]);
			$('#saldo_o').text(datos[10]); $('#estatus_o').text(datos[11]); $('#o_items').html(datos[17]);
			
			$('#myModal3').modal('show');
			$('#myModal3').on('shown.bs.modal', function(e){ });
			$('#myModal3').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal3").empty(); });
		}); 
	}});
}

function atenderS(nameP, idS, nameC, id_pac, id_vc){
	swal({
	  title: "ATENDER EL SERVICIO", text: "¿ESTÁS SEGURO DE ATENDER EL SERVICIO "+ nameC+" DEL PACIENTE "+nameP+"?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Atender", closeOnConfirm: false, cancelButtonText: "Cancelar"
	},
	function(){
	  	var datos = {idS:idS, idU:$('#id_user').val()}
		$.post('servicios/archivos_save_ajax/procesar.php', datos).done(function(data){
			if(data==1){
				$('#clickme').click(); swal.close();
				//swal({title:"",type:"",text:"EL PROCESO SE REALIZÓ CORRECTAMENTE",timer:2500,showConfirmButton:false });
				window.setTimeout(function(){procesoS(nameP, idS, nameC, id_pac, id_vc);},300);
			}else{alert(data);}
		});
	});
}
function procesoS(nameP, idS, nameC, id_pac, id_vc){
	$("#myModal1").load('servicios/htmls/captura.php',function(response,status,xhr){ if(status=="success"){
		tinymce.remove("#input"); $('#imprimirInt').remove(); $('#titulo_modal').text('SERVICIO '+nameC+' PACIENTE '+nameP);
		
		window.setTimeout(function(){ //alert(1);
			tinymce.init({ 
				selector:'#input',resize:false,height:$('#myModal1').height()*0.67,theme: "modern",
				plugins: 
					"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
				table_default_styles: { width: '100%' },
				relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#myModal1').width()*0.8,
				toolbar: 
					"undo redo | insert | styleselect_ | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent_ indent_ | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
				insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
				paste_data_images: false, paste_as_text: true, browser_spellcheck: true,
				setup: function(editor){
					editor.addButton( 'mybuttonVP', {
						text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
						onclick:function(){
							var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
							$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
							$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
						}
					});
				}
			});
			
			var datosT = {idP:id_pac, idU:$('#id_user').val(), id_vc:id_vc}
			$.post('consultas/files-serverside/cat_texts.php',datosT).done(function(dataT){ var datosTe = dataT.split('-{]');
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
																						   
				var datos = {idS:idS, idU:$('#id_user').val()}
				$.post('servicios/archivos_save_ajax/salvado.php', datos).done(function(data){
					if(data<1){//Nunca ha sido guardado el resultado
						if(nameC=='CERTIFICADO MEDICO' || nameC=='CERTIFICADO MEDICO '){
							var datosCer = {idC:idS}
							$.post('servicios/files-serverside/datosCM.php',datosCer).done(function(datax){ 
								var datosCM=datax.split(';}{*');
								window.setTimeout(function(){
									tinymce.get('input').setContent('<table class="table-condensed table-bordered" width="100%" height="21cm" style="font-size: 13pt;"><tr><td align="right">'+datosCM[6]+'<br><br></td></tr><tr><td align="right">ASUNTO: <strong>CERTIFICADO  MÉDICO<br><br></strong></td></tr><tr><td align="left">A  QUIEN  CORRESPONDA:<br><br></td></tr><tr><td align="left"><blockquote style="margin-right: 0px; margin-bottom: 0px; margin-left: 40px; border: none; padding: 0px;"><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES">POR  MEDIO  DE  LA  PRESENTE  EL QUE   SUSCRIBE   <b> '+datosCM[0]+' </b>MÉDICO CON CED. PROF. '+datosCM[1]+'   HACE:</span></p></blockquote><br><br></td></tr><tr><td align="center"><p class="MsoNoSpacing" align="center" style="text-align: center;"><b><span lang="ES">C       E     R     T     I    F     I    C    A   R</span></b></p><br></td></tr><tr><td align="justify"><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES">QUE '+datosCM[2]+';  OROFARINGE SIN ALTERACIONES,  CON '+datosCM[3]+'. CARDIORESPIRATORIO SIN COMPROMISOS, ABDOMEN BLANDO Y DEPRESIBLE SIN MEGALIAS, BUENA PERISTALSIS, RESTO SIN COMPROMISO GRUPO SANGUINEO TIPO '+datosCM[4]+'.<o:p></o:p></span></p><p class="MsoNoSpacing" style="text-align: justify;"></p></td></tr><tr><td align="left"><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES"><b>ANTECEDENTES DE IMPORTANCIA</b></span></p><p class="MsoNoSpacing" style="text-align: justify;"></p></td></tr><tr><td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="2"> <tbody><tr> <td width="35%">DIABETES MELLITUS</td> <td width="15%">NO</td> <td width="35%">HIPERTENSIÓN ARTERIAL</td> <td width="15%">NO</td> </tr> <tr> <td>NEOPLASIAS</td> <td>NO</td> <td>QUÍMICOS</td> <td>NO</td> </tr> <tr> <td>NEUROLÓGICOS</td> <td>NO</td> <td>QUIRÚRGICOS</td> <td>NO</td> </tr> <tr> <td>TRANSFUSIONALES</td> <td>NO</td> <td>TRAUMÁTICOS</td> <td>NO</td> </tr> <tr> <td>ALERGIAS</td> <td>NO</td> <td>TOXICOMANIAS</td> <td>NO</td> </tr> <tr> <td>AGUDEZA VISUAL</td> <td>NO</td> <td>AGUDEZA AUDITIVA</td> <td>NO</td> </tr> </tbody></table><p class="MsoNoSpacing" style="text-align: justify;"></p></td></tr><tr><td align="justify"><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES">    SE EXTIENDE LA PRESENTE COMO <b><u>CERTIFICACIÓN  MÉDICA</u></b> '+datosCM[5]+', POR LO CUAL PUEDE REALIZAR CUALQUIER ACTIVIDAD TANTO FÍSICA COMO INTELECTUAL.</span></p><p class="MsoNoSpacing" style="text-align: justify;"><span lang="ES"><br></span></p><p class="MsoNoSpacing" style="text-align: justify;"></p></td></tr><tr><td align="center"><strong>ATENTAMENTE:</strong><p class="MsoNoSpacing" align="center" style="text-align: center;"><b><span lang="ES"><br></span></b></p><br><br></td></tr><tr><td align="center"><table width="100%" class="table-condensed" style="font-weight:bold;"><tr><td align="center">'+datosCM[0]+'</td></tr><tr><td align="center">CED. PROF. '+datosCM[1]+'</td></tr><tr><td align="center">MÉDICO SERVICIO DE URGENCIAS</td></tr></table></td></tr></table>');
								},400);
							});
						}else{//sacamos el machote del formato, primero individual por servicio y sino tiene entonces el de sucursal y sino el de configuración
							var dato = { idVC:id_vc, idP:id_pac, idU:$('#id_user').val() }
							$.post('servicios/files-serverside/datosCaptura.php',dato).done(function(datas){ var datos = datas.split('*}');
								var data = datos[8]; //alert(datos[8]);
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
								
								tinymce.get("input").execCommand('mceSetContent', false, data);
							});
						}
					}else{
						var datosX = {idC:idS}
						$.post('servicios/files-serverside/datos_s.php',datosX).done(function(datax){
							window.setTimeout(function(){ tinymce.get('input').setContent(datax); },400);
						});	
					}
				});
			});
			
		},100);
		
		$('#saveInterI').click(function(e) { guardar(nameP, idS, nameC); });
		
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal',function(e){ });
		$('#myModal1').on('hidden.bs.modal',function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
}
function guardar(nameP, idS, nameC){
	if(tinymce.get('input').getContent()!=''){
		swal({
		  title: "FINALIZAR EL SERVICIO", text: "¿ESTÁS SEGURO DE FINALIZAR EL SERVICIO "+ nameC+" DEL PACIENTE "+nameP+"?", type: "warning",
		  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Finalizar", closeOnConfirm: false, cancelButtonText: "Cancelar"
		},
		function(){
			$('#myModal1').modal('hide'); var datos = {idS:idS, idU:$('#id_user').val(),input:tinymce.get('input').getContent()}
			$.post('servicios/archivos_save_ajax/finalizar.php', datos).done(function(data){
				if(data==1){
					$('#clickme').click(); swal.close(); window.setTimeout(function(){finalizadoS(nameP, idS, nameC);},300);
				}else{alert(data);}
			});
		});
	}else{ swal({title: "ALERTA", type: "error", text: "Debe de escribir una interpretación.", timer: 1800, showConfirmButton: false}); }
}
function finalizadoS(nameP, idS, nameC){
	$("#myModal2").load('servicios/htmls/captura.php',function(response,status,xhr){ if(status=="success"){
		$('#saveInterI').remove(); $('#titulo_modal').text('SERVICIO '+nameC+' PACIENTE '+nameP);
		var datosX = {idC:idS}
		$.post('servicios/files-serverside/datos_s.php',datosX).done(function(datax){
			window.setTimeout(function(){ $('#interpretation').html(datax); },400);
		});
		
		$('#imprimirInt').click(function(e){ $('#interpretation').printElement(); });
		
		$('#myModal2').modal('show');
		$('#myModal2').on('shown.bs.modal',function(e){ });
		$('#myModal2').on('hidden.bs.modal',function(e){ $(".modal-content").remove(); $("#myModal2").empty(); });
	} });
}
function editarS(nameP, idS, nameC){
	swal({
	  title: "EDITAR EL SERVICIO", text: "¿ESTÁS SEGURO DE EDITAR EL SERVICIO "+ nameC+" DEL PACIENTE "+nameP+"?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Editar", closeOnConfirm: false, cancelButtonText: "Cancelar"
	},
	function(){
	  	var datos = {idS:idS, idU:$('#id_user').val()}
		$.post('servicios/archivos_save_ajax/editar.php', datos).done(function(data){
			if(data==1){
				$('#clickme').click(); swal({title:"",type:"",text:"EL SERVICIO ESTÁ LISTO PARA EDICIÓN",timer:1800,showConfirmButton:false });
			}else{alert(data);}
		});
	});
}
</script>
