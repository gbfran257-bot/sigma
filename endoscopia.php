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
    
    <title>SISTEMA - ENDOSCOPÍA</title>
    
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
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">PACIENTE</th>
    <th style="vertical-align:middle;">REFERENCIA</th>
    <th style="vertical-align:middle;">ESTUDIO</th>
    <th style="vertical-align:middle;">ESTATUS</th>
    <th style="vertical-align:middle;">EDITAR</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-PACIENTE-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-REFERENCIA-" style="max-width:110px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTUDIO-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTATUS-"/></th>
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
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>IMAGEN</li><li class="active"><strong>ENDOSCOPÍA</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-175-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"iS><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "imagen/datatable-serverside/endoscopias.php",
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
			"sInfo": "ESTUDIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
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

function preguntaX(n,r,e,i,dx){//n es el nombre del paciente, r es la referencia e i es el id de la venta_conceptos
	$("#myModal1").load("imagen/htmls/atender.php",function(response,status,xhr){ if(status == "success"){
		$('#titulo_modal').text("ATENDER ESTUDIO DE ENDOSCOPÍA. REFERENCIA "+r);
		$("#anestesiologoE").load('imagen/genera/genera_anestesiologos.php',function(response,status,xhr){if(status=="success"){ }});
		$('#pacienteX1').text(n); $('#estudioX1').text(e); $('#referenciaX1').text(r); $('#idEstX').val(i); $('#dxEnvio').val(dx);
		
		$('#btn_atender_e').click(function(e) {
            $('#form-endo').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
			  } else { // everything looks good!
				e.preventDefault(); 
				var datoI = {
					idC:$('#idEstX').val(),idU:$('#id_user').val(),dxEnvio:$('#dxEnvio').val(),anestesiologo:$('#anestesiologoE').val()
				}
				$.post('imagen/archivos_save_ajax/procesarE.php', datoI).done(function( data ) { if (data == 1){ 
					$('#clickme').click(); $('#myModal1').modal('hide'); 
					swal({title:"",type:"success",text:"EL PROCESO SE HA REALIZADO CORRECTAMENTE",timer:2000,showConfirmButton:false});
					window.setTimeout(function(){fichaEstudio(2,i);},500);
				}else{alert(data);} });
			  }
			});
        });
		$('#myModal1').modal('show'); $('#myModal1').on('shown.bs.modal', function(e){ $('#form-endo').validator(); });
		$('#myModal1').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
	}});
}
function fichaEstudio(e,i,id_pa,id_s){ //e es el estatus del estudio e i es el id de vc
	$("#myModal").load('imagen/htmls/ficha_endoscopia.php',function(response,status,xhr){if(status=="success"){
		tinymce.remove("#tInterpretacion #input"); //alert(e);
		if(e>2 & e<5){//Realizados 3 y capturados 4 //window.setTimeout(function(){$('#st-interpretacion').click();},200);
			var dato = { idE:i, idP:id_pa, idU:$('#id_user').val() }
			$.post('imagen/files-serverside/datosInterpretarEn.php', dato).done(function( data ) { //alert(data);
				tinymce.init({ 
					selector:'#tInterpretacion #input',resize:false,height:$('#myModal').height()*0.63,theme: "modern",
					plugins: 
						"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss", table_default_styles: { width: '100%' },
					relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#myModal').width()*0.8,
					toolbar: 
						"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP | mybutton1 | mybutton |",
					insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
					paste_data_images: true, paste_as_text: true, browser_spellcheck: true, 
					force_br_newlines : true, force_p_newlines : false, forced_root_block : '', 
					setup: function(editor){
						editor.addButton( 'mybutton', { text: 'INSERTAR IMÁGENES', icon: false,
							onclick:function(){
								var datos = {idVC:i}
								$.post('imagen/files-serverside/insertarIMGs.php',datos).done(function(data){editor.insertContent(data);});
							}
						});
						editor.addButton( 'mybutton1', { text: 'DICTAR', icon: false, onclick:function(){ procesarV(); } });
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
				var datos = data.split(';*-');
				if(e==3){ //es = 3 es realizado, 4 es capturado
					var datosT = {idP:id_pa, idU:$('#id_user').val(), id_vc:i}
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

								var data = datos[31];
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

								//tinymce.get('input').setContent(data);
								setTimeout(function(){tinymce.get('input').setContent(data);},1300);
								//$('#tCaptura #input').val(data);
								//Checamos si el estudio tiene formatos individuales de quién lo va a interpretar, si es así, entonces puede escoger su machote
								if(datosTe[32]>0){
									$('#tr_machotes').show();
									$("#formato_se").load('usuarios/files-serverside/genera_machotes_i.php?id_u='+$('#id_user').val()+'&id_es='+datosTe[33],function(response,status,xhr){if(status=="success"){
										//$(this).val(dato[22]);
									}});
									$('#formato_se').change(function(){
										var datosFts ={idE:this.value}
										$.post('imagen/estudios/files-serverside/check_formato_estudio.php',datosFts).done(function(data1){
											var data = data1;
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
											data = data.replace(/{et_firma_medico_atiende}/gi, firma_medico_atiende_x);
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

											tinymce.get("input").execCommand('mceSetContent', false, data);
										});
									});
								}else{$('#tr_machotes').hide();}
					});
					//$('#input').val(datos[31]);
				}else{ $('#tr_machotes').hide(); setTimeout(function(){tinymce.get('input').setContent(datos[5]); },1300); }
				
				var miExtFU1 = datos[23];
				
				if(datos[24]>0){//Para el membrete encabezado
					xME='sucursales/membretes/files/'+datos[25]+'.'+datos[26]+'?'+Math.round(Math.random()*1000); var membretDME = 'url('+xME+')'; //alert(membretDME);
					$("#para_encabezado").css('background-image',membretDME).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
				}
				if(datos[27]>0){//Para el membrete encabezado
					xMP='sucursales/membretes/files/'+datos[28]+'.'+datos[29]+'?'+Math.round(Math.random()*1000); var membretDMP = 'url('+xMP+')'; //alert(membretDME);
					$("#para_pie").css('background-image',membretDMP).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
				}
				if(datos[21]==1){//Para la firma
					var datos = {aleatorio:datos[22]}
					$.post('usuarios/files-serverside/datosFirma.php',datos).done(function( data ){ 
						var t = "<img src='usuarios/documentos/files/"+data+"."+miExtFU1+"?"+Math.round(Math.random()*1000)+"' height='90%'>";
						$('#firmaDR').html(t);
					});
				}
			});//cargarImagenesReporte(i);
		}
		
		$('#idEstuVC').val(i); $('.margen_punteado_fonto').css('border-bottom-style','dashed').css('border-bottom-width','1px');
			
		var datoG = { idE:i }
		$.post('imagen/files-serverside/datosDXEn.php', datoG).done(function( dataDX ) {
			var datosDX = dataDX.split('*[+');
		
		var k = 0, videoStream;
		
		$('#titulo_modal').text(datosDX[0]);
		//$('#dialog-procesar').dialog( "option", "title", dTitle ); $('#dialog-procesar').dialog('open');
		navigator.getUserMedia = navigator.getUserMedia ||  
                         navigator.webkitGetUserMedia || 
                         navigator.mozGetUserMedia || 
                         navigator.msGetUserMedia;
                          
		window.URL = window.URL || 
					 window.webkitURL || 
					 window.mozURL || 
					 window.msURL;
		var j = datosDX[1];
		
		document.getElementById('start').addEventListener('click', function() {
			if(!$('#start').hasClass('disabled')){
				var hV=$('#contenedorVideo').height()*0.8,wV=$('#contenedorVideo').width()*0.8;$('#video').css('width',wV,'height',hV);
				navigator.getUserMedia({ video: true }, 
				function(stream) {
					videoStream = stream; // Stream the data
					video.src = window.URL.createObjectURL(stream); video = document.querySelector('video'); video.play();
					$('#start').addClass('disabled'); $('#capture, #stop').removeClass('disabled');
					$('#myModal').on('hidden.bs.modal', function(e){ video.pause(); });
				}, function(e) { console.log(e); });
			}else{}
		}, false);
		
		var button = document.getElementById('capture');
		button.addEventListener('click', function() {
			if(!$('#capture').hasClass('disabled')){
				j++; //alert(j);
				$('#deCanvas').append('<table style="float:left;" width="" border="0" cellspacing="0" cellpadding="3"> <tr> <td align=""><span style="display:block;">Eliminar</span></td> </tr> <tr> <td><canvas id="miFoto'+j+'" width="160" height="120"></canvas></td> </tr> </table>');
			
				var canvas = document.getElementById('miFoto'+j), ctx = canvas.getContext('2d');
				ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
				
				var canvasX = document.getElementById('miFotoX'), ctxX = canvasX.getContext('2d');
				ctxX.drawImage(video, 0, 0, canvasX.width, canvasX.height); //esta va culta en una pestaña que no es visible
				
				var canvas1 = document.getElementById('miFotoX1'), ctx1 = canvas1.getContext('2d');
				ctx1.drawImage(video, 0, 0, canvas1.width, canvas1.height);
				
				var image = new Image(); image.src = canvas1.toDataURL("image/png"); var dataURL1 = canvas1.toDataURL();
				//alert(image);
				$('#imagenesEndo').append('<table style="float:left;" width="" border="0" cellspacing="0" cellpadding="3"> <tr> <td align=""> </td> </tr> <tr> <td><img id="miFoto1'+j+'" alt="Right click to save me!"></td> </tr> </table>');
				document.getElementById('miFoto1'+j).src = dataURL1;
				
				var dataURL1 = canvas1.toDataURL();
				$.ajax({
					type:"POST",url:"imagen/files-serverside/guardarImgNormal.php",data:{imgBase64:dataURL1,cont:j,id:i}
				}).done(function(o){
				  console.log('saved'); //cargarImagenesCanvas(i); cargarImagenesReporte(i);
				});
				
				var dataURL = canvasX.toDataURL();
				$.ajax({type:"POST",url:"imagen/files-serverside/guardarImg.php",data:{imgBase64:dataURL,cont:j,id:i} }).done(function(o){
				  console.log('saved'); cargarImagenesCanvas(i); cargarImagenesReporte(i);
				});
			}else{}
		}, false);
		
		document.getElementById('stop').addEventListener('click', function() {
			if(!$('#stop').hasClass('disabled')){
				swal({
				  title: "FINALIZAR VIDEO", text: "¿Estás seguro de finalizar el video? Ten en cuenta que ya no podrás tomar imágenes",
				  type: "warning", showCancelButton: true, 
				  confirmButtonColor: "#DD6B55", confirmButtonText: "Finalizar", closeOnConfirm: false, cancelButtonText: "Cancelar"
				},
				function(){
					swal.close();
					var datoI = {idC:i, idU:$('#id_user').val()}
					$.post('imagen/archivos_save_ajax/capturarE.php', datoI).done(function( data ) { if (data == 1){ 
						$('#clickme').click(); $('#start, #capture, #stop').addClass('disabled');
						$('#guardarE,#finalizarE').removeClass('disabled');
						swal({title:"",type:"success",text:"EL VIDEO HA SIDO FINALIZADO",timer:2000,showConfirmButton:false});
						if(typeof videoStream !== "undefined" && videoStream){videoStream.getVideoTracks()[0].stop();}
						location.reload();
					}else{alert(data);} });
				});
			}else{}
		}, false);
				
		if(e>=2){ cargarImagenesCanvas(i); cargarImagenesReporte(i); }
		if(e==3){ $('#guardarE, #finalizarE, #dictado').removeClass('hidden'); }
		if(e>=3){
			$('#start, #capture, #stop').remove(); $('#t-interpretacion').removeClass('hidden');
			window.setTimeout(function(){$('#st-interpretacion').click();},300);
		}
		if(e==4){ 
			$('#guardarE, #finalizarE, #dictado').removeClass('hidden');
			var dato = { idE:i, idU:$('#id_user').val() }
			$.post('imagen/files-serverside/datosInterpretarEn.php', dato).done(function( data ) { //alert(data);
				var datos = data.split(';*-'); window.setTimeout(function(){ tinymce.get("input").setContent(datos[5]);},500);
			});
		}
		if(e>=4){ }
		if(e>4){
			preImprimir(i,id_pa,id_s);
			/*$('#start, #capture, #stop, #guardarE, #finalizarE, #dictado').remove(); $('#tr_machotes').hide();
			var dato = { idE:i, idU:$('#id_user').val() }
			$.post('imagen/files-serverside/datosInterpretarEn.php', dato).done(function( data ) { //alert(data);
				var datos = data.split(';*-');
				tinyMCE.init({ 
					selector:'#input',readonly:true,resize:false,height:$('#myModal').height()*0.8,
					theme: "modern", menubar: false, toolbar: false
				});
				$('#imprimirE').removeClass('hidden');
				$('#imprimirE').click(function(e){ $('#myModal').modal('hide'); window.setTimeout(function(){preImprimir(i,id_pa,id_s);},300); });
				
				//var str = datos[5].replace('src="../../../usuarios/','src="usuarios/');
				//var res = str;//.replace('src="../usuarios/firmas/','src="../../../usuarios/firmas/');
				//var res = res.replace(/src="img_endo/g,'src="../../../imagen/img_endo');
				//alert(res);
				//var res = res.replace(/..\/..\/..\/imagen\/img_endo/g,'imagen/img_endo');
				//var res = res.replace(/[?]\d{14}/g,'');
				window.setTimeout(function(){ tinymce.get("input").setContent(datos[5]);},200); $('#t-captura').remove();
			});*/
		}
		
		$('#guardarE').click(function(e) {
			var str = tinyMCE.get('input').getContent(); 
			//var res = str.replace('src="usuarios/documentos/','src="../../../usuarios/documentos/');
			//var res = res.replace(/src="img_endo/g,'src="../imagen/img_endo'); console.log(res); 
			//var res = res.replace(/[?]\d{14}/g,'');
						
			var datos = { idE:i, idU:$('#id_user').val(), dx:str }
			$.post('imagen/files-serverside/guardarEndo.php',datos).done(function( data ) {
				if (data == 1){ $('#clickme').click();
					swal({title:"",type:"success",text:"LOS DATOS SE HAN GUARDADO CORRECTAMENTE",timer:1500,showConfirmButton:false});
				}else{ alert(data); }
			});
        });
		$('#finalizarE').click(function(e){
			swal({
			  title: "FINALIZAR ESTUDIO",
			  text: "¿Estás seguro de finalizar el estudio? No se le podrán realizar más cambios",
			  type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Finalizar", cancelButtonText: "Cancelar", closeOnConfirm: false
			},
			function(){ 
			  $('#myModal').modal('hide'); var str = tinyMCE.get('input').getContent(); 
			  //var res = str.replace('src="usuarios/documentos/','src="../../../usuarios/documentos/');
			  //var res = res.replace(/src="imagen/g,'src="../../../imagen'); var res = res.replace(/[?]\d{14}/g,'');

			  var datos = { idE:i, idU:$('#id_user').val(), dx:str }
			  $.post('imagen/files-serverside/finalizarEndo.php',datos).done(function( data ) {
				if (data == 1){
					$('#clickme').click(); $('#guardarE, #finalizarE').remove();
					swal({
					  title:"", text:"EL ESTUDIO SE HA FINALIZADO.",type:"success", showCancelButton:true,confirmButtonColor:"#DD6B55",
					  confirmButtonText: "Imprimir", cancelButtonText: "Cerrar", closeOnConfirm: false
					},
					function(){ swal.close(); window.setTimeout(function(){ window.setTimeout(function(){preImprimir(i,id_pa,id_s);},300); },400); });
				}else{ alert(data); }
			  });
			});
        });
		
		});//Fin de lo del DX previo
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function(e){
			var he = $('#referencia').height() - 200, wi = $('#referencia').width() * 0.98;
			$('#tamHcanvas').val($('#contenedorCanvas').height());
			tinymce.init({selector:'#input',height:$('#myModal').height()*0.53});
		});
		$('#myModal').on('hidden.bs.modal', function(e){$(".modal-content").remove(); $("#myModal").empty(); });
	} });
}
function preImprimir(x,idPa,id_s){//a =id paciente, b id estudio en vc
	/*var datoP = {idE:x}
	$.post('imagen/archivos_save_ajax/datosPrintMemEn.php', datoP).done(function(data){ //alert(data);
		if(data!=1){ imprimir(x,idPa,0,id_s); }
		else{
			swal({
			  title: "IMPRIMIR EL ESTUDIO",
			  text: '<table class="table table-condensed"><tr><td align="center" colspan="2">Selecciona el tipo de impresión</td></tr><tr><td align="center"><button id="btn_imp_cm" type="button" class="btn btn-info">Con membrete</button></td><td align="center"><button id="btn_imp_sm" type="button" class="btn btn-info">Sin membrete</button></td></tr></table>',
			  html: true, showCancelButton: true, showConfirmButton: false, cancelButtonText: "Cerrar"
			});
			$('#btn_imp_cm').click(function(e) { imprimir(x,idPa,1,id_s); swal.close(); });
			$('#btn_imp_sm').click(function(e) { imprimir(x,idPa,0,id_s); swal.close(); });
		}
	});*/
	imprimir(x,idPa,0,id_s);
}
function imprimir(x,idPa,y,id_s){//x=id del estudio, y es si se imprimen los encabe
	$("#myModal").load('imagen/htmls/imprimir.php',function(response,status,xhr){ if(status=="success"){//alert(id_s);
		/*var dato = { idE:x, idP:idPa, idU:$('#id_user').val() }
		$.post('imagen/files-serverside/datosInterpretar.php', dato).done(function( data ){ //alert(data);
			var datos = data.split(';*}-{');
			$.post('imagen/files-serverside/imprimirResultadosPDF.php?idE='+x+'&idU='+$('#id_user').val()).done(function(data){
			  var pusha={iduL:escape($('#id_user').val()),idVC:x,mems:y,id_s:id_s}
			  $("#impresion_inter").load('imagen/htmls/frame_pdf_en.php',pusha,function(response,status,xhr){if(status=="success"){}});
			});		
		});*/
		$("#myModal").height($("#referencia").height()*0.85);
		var dato = { idE:x, idP:idPa, idU:$('#id_user').val() }
		$.post('imagen/files-serverside/datosInterpretar.php', dato).done(function(data){ var datos = data.split(';*}-{'); //alert(data);
			var res = datos[5].replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); $("#impresion_inter").html(res);
		});

		$('#btn_imprimir_i').click(function(e) { $('#impresion_inter').printElement(); });
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
	 //alert(idPa);
}//fin imprimir
function cargarImagenesCanvas(i){
	$("#deCanvas").load("imagen/img_endo/procesa.php?action=listFotos1&carpeta="+i,function(response,status,xhr){ }); 
	window.setTimeout(function(){ $('#divCanvas').css('height',$('#tamHcanvas').val()).css('overflow','scroll');},500);
}
function cargarImagenesReporte(i){
	$("#imagenesEndo").load("imagen/img_endo/procesa.php?action=listFotos2&carpeta="+i,function(response,status,xhr){ });
}
function miImg(idImg){ //alert(idImg);
	$('#mi_video_ver').addClass('hidden'); $('#mi_foto_ver').removeClass('hidden');
	var d = new Date(); var xo = d.format('YmdHisu').substring(0,22); $('#foto_ver').html('<img src="'+idImg+'?'+xo+'">');
	$('#close_img_ver').click(function(e) {
        $('#mi_video_ver').removeClass('hidden'); $('#mi_foto_ver').addClass('hidden'); $('#foto_ver').html('');
    });
}
function reporteFoto(idI, nombreI){
	if($('#'+nombreI).prop('checked')==true){
		var dato = {id:idI, reportar:1}
		$.post("imagen/img_endo/procesa.php?action=reporte", dato).done(function( data ) { //alert(data);
			var datoxC = data.split(';'); if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">R</span>');}
			cargarImagenesReporte(datoxC[1]);
		});
	}else{
		var dato = {id:idI, reportar:0}
		$.post("imagen/img_endo/procesa.php?action=reporte", dato).done(function( data ) {
			var datoxC = data.split(';'); if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">NR</span>');}
			cargarImagenesReporte(datoxC[1]);
		});
	}
}

function editar(x, estudio, referencia, paciente){//alert($('#acc_user').val());// x=id del estudio en vc
	if($('#acc_user').val()==1){
		swal({
		  title: "EDITAR LA INTERPRETACIÓN",
		  text: "¿Estás seguro de querer editar la interpretación del estudio "+estudio+" del paciente "+paciente+" con referencia "+referencia+"?",
		  type: "warning", showCancelButton: true,
		  confirmButtonColor: "#DD6B55", confirmButtonText: "Editar", cancelButtonText: "Cancelar", closeOnConfirm: false
		},
		function(){
		  	var dato = { idE:x, idU:$('#id_user').val() }
			$.post('imagen/files-serverside/editarEndoscopia.php', dato).done(function( data ) {
				if(data==1){
					swal.close(); $('#clickme').click();
					window.setTimeout(function(){
						swal({title:"",type:"success",text:"¡La interpretación esta lista para su edición!",timer:2500,showConfirmButton:false});
					},300);
				}else{alert(data);}
			});
		});
	}else{ swal({title:"",type:"error",text:"¡Acceso restringido!",timer:2500,showConfirmButton:false}); }
}//fin editar

var recognition; var recognizing = false;
if (!('webkitSpeechRecognition' in window)) { $('#dictado').hide(); /*alert("¡API no soportada!"); */} 
else {
	recognition = new webkitSpeechRecognition(); recognition.lang = "es-VE";
	recognition.continuous = true; recognition.interimResults = false; //era true

	recognition.onstart = function() { recognizing = true; console.log("empezando a eschucar"); }
	recognition.onresult = function(event) {
	 for (var i = event.resultIndex; i < event.results.length; i++) { 
		if(event.results[i].isFinal){insertAtCaret(event.results[i][0].transcript);}
	 } //texto
	}
	recognition.onerror = function(event) {  }
	recognition.onend = function() {
		recognizing = false;
		$('#dictado').html('<i class="fa fa-pencil" aria-hidden="true"></i> INICIAR DICTADO');
		console.log("terminó de eschucar, llegó a su fin");
	}
}

function procesarV() {
	if(recognizing==false){
		recognition.start();recognizing=true; $('#mceu_16').html('<button role="presentation" type="button" tabindex="-1"><span class="mce-txt">DETENER DICTADO</span></button>');
	}
	else{recognition.stop();recognizing=false;$('#mceu_16').html('<button role="presentation" type="button" tabindex="-1"><span class="mce-txt">DICTAR</span></button>');}
}

function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); }
</script>