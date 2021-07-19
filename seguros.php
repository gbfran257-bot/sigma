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
    <meta name="author" content="ING EMMANUEL ANZURES BAUTISTA">
    
    <title>SISTEMA - SEGUROS</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Clock picker -->
    <script src="js/plugins/clockpicker/bootstrap-clockpicker.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="DataTables-1.10.13/media/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.10.13/media/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.10.13/extensions/Select/js/dataTables.select.min.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <script src='c3/c3.min.js'></script>
    <script src='c3/d3/d3.min.js'></script>
    <script src="jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
	<script src="jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>
    <script src='tinymce/tinymce.min.js'></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <!-- IonRangeSlider -->
    <script src="ionrangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
    
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
    <link href="c3/c3.css" rel="stylesheet">
    <link href="css/plugins/clockpicker/bootstrap-clockpicker.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="ionrangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
    <link href="ionrangeSlider/css/ion.rangeSlider.skinHTML5.css" rel="stylesheet">
    <style>
	/*input[type=number]::-webkit-outer-spin-button,input[type=number]::-webkit-inner-spin-button{
		-webkit-appearance:none;margin:0;
	}
	input[type=number] { -moz-appearance:textfield; }*/
	</style>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
<div class="hidden" id="dpa_imprimir2"></div><div class="hidden" id="dpa_imprimir3"></div>
<div class="hidden" id="dpa_imprimir4"></div><div class="hidden" id="dpa_imprimir5"></div>
<div class="hidden" id="dpa_imprimir6"></div><div class="hidden" id="dpa_imprimir7"></div>

<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">CLAVE</th>
    <th style="vertical-align:middle;">
	<?php if($_SESSION['MM_UserGroup']==1){ ?>
        <button type="button" class="btn btn-default btn-xs" onClick="nuevaSucursal();"><i class="fa fa-plus" aria-hidden="true"></i> SEGUROS</button>
    <?php }else{echo "SUCURSAL";} ?>
    </th>
    <th style="vertical-align:middle;">LOCALIDAD</th>
    <th style="vertical-align:middle;">#USUARIOS</th>
    <th style="vertical-align:middle;">#PACIENTES</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Clave"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Sucursal"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Localidad"/></th>
            <th></th>
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
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li class="active"><strong>SEGUROS</strong></li>');
	
	$('#my_search').removeClass('hidden'); //$.fn.datepicker.defaults.autoclose = true;
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-143-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"Si><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "seguros/datatable-serverside/seguros.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val(); var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } );
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SUCURSALES FILTRADAS: _END_",
			"sInfoEmpty": "NINGUNA SUCURSAL FILTRADA.", "sInfoFiltered": " TOTAL DE SUCURSALES: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 5000, paging: false,
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
	
});
function verSucursal(id_s, nombre_s){ 
	$("#myModal").load('seguros/htmls/fichaSucursal.php',function(response,status,xhr){if(status=="success"){
		$(".insers").load('genera/inserciones.php', function( response, status, xhr ) { if ( status == "success" ) { } }); var datosF = {id:1}
		$.post('seguros/files-serverside/formatos_base.php',datosF).done(function(data){ var formato_x = data.split('{*]-[}');
			tinymce.remove("#input"); tinymce.remove("#input1"); tinymce.remove("#input2"); tinymce.remove("#input3"); tinymce.remove("#input4");
			tinymce.remove("#input5"); tinymce.remove("#input6"); tinymce.remove("#input7");
			
			$('#btn_registro_u').text('Actualizar'); $('#registroModalLabel').text('FICHA DE DATOS DE LA SUCURSAL '+nombre_s);
			
			$('#idUsuarioP').val($('#id_user').val()); $('#idSucursal').val(id_s); $('#btn_cancel_registro').text('Cerrar');
			$('.clockpicker').clockpicker().find('input').change(function(){ console.log(this.value); });
			var input = $('#single-input').clockpicker({placement: 'bottom',align: 'left',autoclose: true});
			$('.popover').css('z-index','3000'); //$.fn.datepicker.defaults.autoclose = true;
	
			$('#alerta_form').hide(); var d = new Date(); $('#temporal_s').val(d.format('Y-m-d-H-i-s-u').substring(0,22));
			var tempo = $('#temporal_s').val();
			
			var dato_p = {id_s:id_s, tempo:tempo}
			$.post('seguros/files-serverside/fichaSucursal.php',dato_p).done(function(data){ var dato = data.split(';-}{');
				if(dato[65]==''){ //Formato Nota Médica
					$('#input').val(formato_x[0]);
				}else{$('#input').val(dato[65]);}
				if(dato[66]==''){ //Formato Receta Médica
					$('#input1').val(formato_x[1]);
				}else{$('#input1').val(dato[66]);}
				if(dato[67]==''){ //Formato Estudios Laboratorio
					$('#input2').val(formato_x[2]);
				}else{$('#input2').val(dato[67]);}
				if(dato[68]==''){ //Formato Estudios Imagen
					$('#input3').val(formato_x[3]);
				}else{$('#input3').val(dato[68]);}
				if(dato[69]==''){ //Formato Estudios Endoscopía
					$('#input4').val(formato_x[4]);
				}else{$('#input4').val(dato[69]);}
				if(dato[70]==''){ //Formato Estudios Ultrasonido
					$('#input5').val(formato_x[5]);
				}else{$('#input5').val(dato[70]);}
				if(dato[71]==''){ //Formato Estudios Colposcopía
					$('#input6').val(formato_x[6]);
				}else{$('#input6').val(dato[71]);}
				if(dato[72]==''){ //Formato Servicios Médicos
					$('#input7').val(formato_x[7]);
				}else{$('#input7').val(dato[72]);}
				
				cargar_editores();
				
				$('#nombreS').val(dato[2]); $('#claveS').val(dato[1]); $('#cluesS').val(dato[35]); siempre(dato[12], dato[13]);
				$("#p_tabu_img").ionRangeSlider({
					min:0, max: 200, from: dato[3], prefix: "%", grid: true, onChange: function (data) { $('#p_tabu_img').val(dato[3]); }
				});
				$("#p_tabu_lab").ionRangeSlider({
					min: 0, max: 200, from: dato[4], prefix: "%", grid: true, onChange: function (data) { $('#p_tabu_lab').val(dato[4]); }
				});
				$("#p_tabu_serv").ionRangeSlider({
					min: 0, max: 200, from: dato[5], prefix: "%", grid: true, onChange: function (data) { }
				});
				
				if(dato[33]=='' || dato[33]==0){$('#t_base_img').val(2);}else{$('#t_base_img').val(dato[33]);}
				if(dato[32]=='' || dato[32]==0){$('#t_base_lab').val(2);}else{$('#t_base_lab').val(dato[32]);}
				
				$('#link_pacs_s').val(dato[17]); $('#telefonos_s').val(dato[14]); $('#email_s').val(dato[15]); $('#dominio_s').val(dato[16]);
				$('#estadoP').val(dato[6]); $('#municipioP').val(dato[7]); $('#ciudadP').val(dato[8]);
				$('#coloniaP').val(dato[9]); $('#calleS').val(dato[10]); $('#cpP').val(dato[11]);
				$('#p_latitud').text(redondear(dato[12],4)); $('#p_longitud').text(redondear(dato[13],4)); 
				$('#p_latitud_s').val(dato[12]); $('#p_longitud_s').val(dato[13]);
				$('#lunes_de1').val(dato[18]); $('#lunes_a1').val(dato[19]); 
				$('#martes_de1').val(dato[20]); $('#martes_a1').val(dato[21]);
				$('#miercoles_de1').val(dato[22]); $('#miercoles_a1').val(dato[23]);
				$('#jueves_de1').val(dato[24]); $('#jueves_a1').val(dato[25]);
				$('#viernes_de1').val(dato[26]); $('#viernes_a1').val(dato[27]);
				$('#sabado_de1').val(dato[28]); $('#sabado_a1').val(dato[29]);
				$('#domingo_de1').val(dato[30]); $('#domingo_a1').val(dato[31]); tempo = dato[40];
				
				$('#margen_en1').val(dato[41]); $('#tam_mem1').val(dato[42]); $('#margen_pi1').val(dato[43]);
				$('#margen_en2').val(dato[44]); $('#tam_mem2').val(dato[45]); $('#margen_pi2').val(dato[46]);
				$('#margen_en3').val(dato[47]); $('#tam_mem3').val(dato[48]); $('#margen_pi3').val(dato[49]);
				$('#margen_en4').val(dato[50]); $('#tam_mem4').val(dato[51]); $('#margen_pi4').val(dato[52]);
				$('#margen_en5').val(dato[53]); $('#tam_mem5').val(dato[54]); $('#margen_pi5').val(dato[55]);
				$('#margen_en6').val(dato[56]); $('#tam_mem6').val(dato[57]); $('#margen_pi6').val(dato[58]);
				$('#margen_en7').val(dato[59]); $('#tam_mem7').val(dato[60]); $('#margen_pi7').val(dato[61]);
				$('#margen_en8').val(dato[62]); $('#tam_mem8').val(dato[63]); $('#margen_pi8').val(dato[64]);
				
				if(dato[42]==1){$('#hoja_membret').height(297); $('#hoja_membret').width(210);}
				else{$('#hoja_membret').height(148); $('#hoja_membret').width(210);}
				if(dato[45]==1){$('#hoja_membret2').height(297); $('#hoja_membret2').width(210);}
				else{$('#hoja_membret2').height(148); $('#hoja_membret2').width(210);}
				if(dato[48]==1){$('#hoja_membret3').height(297); $('#hoja_membret3').width(210);}
				else{$('#hoja_membret3').height(148); $('#hoja_membret3').width(210);}
				if(dato[51]==1){$('#hoja_membret4').height(297); $('#hoja_membret4').width(210);}
				else{$('#hoja_membret4').height(148); $('#hoja_membret4').width(210);}
				if(dato[54]==1){$('#hoja_membret5').height(297); $('#hoja_membret5').width(210);}
				else{$('#hoja_membret5').height(148); $('#hoja_membret5').width(210);}
				if(dato[57]==1){$('#hoja_membret6').height(297); $('#hoja_membret6').width(210);}
				else{$('#hoja_membret6').height(148); $('#hoja_membret6').width(210);}
				if(dato[60]==1){$('#hoja_membret7').height(297); $('#hoja_membret7').width(210);}
				else{$('#hoja_membret7').height(148); $('#hoja_membret7').width(210);}
				if(dato[63]==1){$('#hoja_membret8').height(297); $('#hoja_membret8').width(210);}
				else{$('#hoja_membret8').height(148); $('#hoja_membret8').width(210);}
							
				var datos1 = {id_s:tempo,nombre:'MEMBRETE NOTA MEDICA'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos1).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				var datos2 = {id_s:tempo,nombre:'MEMBRETE RECETA MEDICA'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos2).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en2").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi2").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				var datos3 = {id_s:tempo,nombre:'MEMBRETE RESULTADOS LABORATORIO'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos3).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en3").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi3").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				var datos4 = {id_s:tempo,nombre:'MEMBRETE RESULTADOS IMAGENOLOGIA'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos4).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en4").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi4").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				var datos5 = {id_s:tempo,nombre:'MEMBRETE RESULTADOS ENDOSCOPIA'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos5).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en5").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi5").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				var datos6 = {id_s:tempo,nombre:'MEMBRETE RESULTADOS ULTRASONIDO'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos6).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en6").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi6").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				var datos7 = {id_s:tempo,nombre:'MEMBRETE RESULTADOS COLPOSCOPIA'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos7).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en7").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi7").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
				var datos8 = {id_s:tempo,nombre:'MEMBRETE SERVICIOS MEDICOS'}
				$.post('seguros/files-serverside/datosMembrete1.php',datos8).done(function( data ){
					var datosM = data.split('*{');
					if(datosM[2]==2){
						x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						var membretD = 'url('+x+')';
						$("#membrete_en8").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
						y='seguros/membretes/files/'+datosM[3]+'.'+datosM[4]+'?'+$('#aleat_membrete').val();
						var membretD1 = 'url('+y+')';
						$("#membrete_pi8").css('background-image',membretD1).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
					}
				});
							
				var oTableDoc = $('#dataTableDocs').DataTable({
					serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
					"aoColumns":[
						{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},
						{"bVisible":false},{"bVisible":true}
					],
					"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
					"sAjaxSource": "seguros/datatable-serverside/documentos.php",
					"fnServerParams": function (aoData, fnCallback) { 
						var aleatorio = $('#temporal_s').val(); aoData.push( {"name": "aleatorio", "value": dato[40] } );
						var acc_user = $('#acc_user').val(); aoData.push( {"name": "acc_user", "value": acc_user } );
					},
					"oLanguage": {
						"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"ESTA SUCURSAL NO CUENTA CON DOCUMENTOS O IMÁGENES",
						"sInfo": "DOCUMENTOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGÚN DOCUMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE DOCUMENTOS: _MAX_", "sSearch": "",
						"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
					},"iDisplayLength": 100, paging: false,
				}); $('#clickmeDocs').click(function(e) { oTableDoc.draw(); });
				$('#tab_mi_arc').click(function(e) { window.setTimeout(function(){oTableDoc.draw();},200); });
				
				$('#titulo_foto').keyup(function(e) {
					if($(this).val()!=''){ $('#btn_add_doc').removeClass('disabled'); }else{ $('#btn_add_doc').addClass('disabled'); }
				});
				$('#btn_add_doc').click(function(e) {
					if($('#titulo_foto').val()!=''){ $('#fileupload_foto').click(); }else{ }
				});
				//Para el upload
				'use strict';
				// Change this to the location of your server-side upload handler:
				var ko = $('#id_user').val();
				var url = window.location.hostname === 'blueimp.github.io' ?
							'//jquery-file-upload.appspot.com/' : 'seguros/documentos/index.php?idU='+ko+'&idP='+tempo+'&nombreD='+escape($('#titulo_foto').val());
				$('#fileupload_foto').fileupload({
					url: url, dataType: 'json',
					submit:function (e, data) {
						if($('#titulo_foto').val()!=''){
							$.each(data.files, function (index, file) {
								var input = $('#titulo_foto'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
							});
						}else{return false;}
					},
					progress: function (e, data) {
						var progress = parseInt(data.loaded / data.total * 100, 10);$('#progress .bar').css( 'width', progress + '%' );
					},
					done: function (e, data) {
						swal({title:"",type:"",text:"El documento se ha cargado correctamente!",timer:1800,showConfirmButton:false});
						$('#clickmeDocs').click(); $('#titulo_foto').val(''); $('#btn_add_doc').addClass('disabled');
					}
				}); //Para el upload
				$('#checkbox-lu').click(function(e){
					if($(this).is(':checked')){ $('#lunes_de1').val('08:00');$('#lunes_a1').val('18:00');$('#t_lunes').val(1); }
					else{ $('#lunes_de1').val('00:00');$('#lunes_a1').val('00:00');$('#t_lunes').val(0); } 
				});
				$('#checkbox-ma').click(function(e){
					if($(this).is(':checked')){ $('#martes_de1').val('08:00');$('#martes_a1').val('18:00');$('#t_martes').val(1); }
					else{ $('#martes_de1').val('00:00');$('#martes_a1').val('00:00');$('#t_martes').val(0); } 
				});
				$('#checkbox-mi').click(function(e){
					if($(this).is(':checked')){$('#miercoles_de1').val('08:00');$('#miercoles_a1').val('18:00');$('#t_miercoles').val(1); }
					else{$('#miercoles_de1').val('00:00');$('#miercoles_a1').val('00:00');$('#t_miercoles').val(0); } 
				});
				$('#checkbox-ju').click(function(e){
					if($(this).is(':checked')){$('#jueves_de1').val('08:00');$('#jueves_a1').val('18:00');$('#t_jueves').val(1); }
					else{$('#jueves_de1').val('00:00');$('#jueves_a1').val('00:00');$('#t_jueves').val(0); } 
				});
				$('#checkbox-vi').click(function(e){
					if($(this).is(':checked')){$('#viernes_de1').val('08:00');$('#viernes_a1').val('18:00');$('#t_viernes').val(1); }
					else{$('#viernes_de1').val('00:00');$('#viernes_a1').val('00:00');$('#t_viernes').val(0); } 
				});
				$('#checkbox-sa').click(function(e){
					if($(this).is(':checked')){$('#sabado_de1').val('08:00');$('#sabado_a1').val('14:00');$('#t_sabado').val(1); }
					else{$('#sabado_de1').val('00:00');$('#sabado_a1').val('00:00');$('#t_sabado').val(0); } 
				});
				$('#checkbox-do').click(function(e){
					if($(this).is(':checked')){$('#domingo_de1').val('08:00');$('#domingo_a1').val('14:00');$('#t_domingo').val(1); }
					else{$('#domingo_de1').val('00:00');$('#domingo_a1').val('00:00');$('#t_domingo').val(0); } 
				});
				$('.chekito').click(function(e) { //alert($(this).attr('lang'));
					if($(this).is(':checked')){ $('#'+$(this).attr('lang')).val(1); } else{ $('#'+$(this).attr('lang')).val(0); }
				});
				//$(".membre").load('seguros/htmls/subir_membretes.php',function(response,status,xhr){if(status=="success"){ }});
	
				$('#tam_mem1').change(function(e) {
					if($(this).val()==1){$('#hoja_membret').height(297); $('#hoja_membret').width(210);}
					else{$('#hoja_membret').height(148); $('#hoja_membret').width(210);}
				});
				$('#margen_en1').change(function(e){ $('#membrete_en1').height(parseFloat($(this).val())*10); });
				$('#margen_en1').keyup(function(e) { $('#membrete_en1').height(parseFloat($(this).val())*10); });
				$('#margen_pi1').change(function(e){ $('#membrete_pi1').height(parseFloat($(this).val())*10); });
				$('#margen_pi1').keyup(function(e) { $('#membrete_pi1').height(parseFloat($(this).val())*10); });
				
				$('#membrete_en1').height(parseFloat(dato[41])*10); $('#membrete_pi1').height(parseFloat(dato[43])*10);
				
				$('#btn_encabezado1').click(function(e) { $('#fileupload_membreteE1').click(); });
				$('#btn_pie1').click(function(e) { $('#fileupload_membreteP1').click(); });
				
				$('#btn_encabezado1').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE NOTA MEDICA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie1').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE NOTA MEDICA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				$('#membrete_en2').height(parseFloat(dato[44])*10); $('#membrete_pi2').height(parseFloat(dato[46])*10);
				$('#tam_mem2').change(function(e) {
					if($(this).val()==1){$('#hoja_membret2').height(297); $('#hoja_membret2').width(210);}
					else{$('#hoja_membret2').height(148); $('#hoja_membret2').width(210);}
				});
				$('#margen_en2').change(function(e){ $('#membrete_en2').height(parseFloat($(this).val())*10); });
				$('#margen_en2').keyup(function(e) { $('#membrete_en2').height(parseFloat($(this).val())*10); });
				$('#margen_pi2').change(function(e){ $('#membrete_pi2').height(parseFloat($(this).val())*10); });
				$('#margen_pi2').keyup(function(e) { $('#membrete_pi2').height(parseFloat($(this).val())*10); });
				
				$('#btn_encabezado2').click(function(e) { $('#fileupload_membreteE2').click(); });
				$('#btn_pie2').click(function(e) { $('#fileupload_membreteP2').click(); });
				
				$('#btn_encabezado2').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RECETA MEDICA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie2').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RECETA MEDICA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				$('#membrete_en3').height(parseFloat(dato[47])*10); $('#membrete_pi3').height(parseFloat(dato[49])*10);
				$('#tam_mem3').change(function(e) {
					if($(this).val()==1){$('#hoja_membret3').height(297); $('#hoja_membret3').width(210);}
					else{$('#hoja_membret3').height(148); $('#hoja_membret3').width(210);}
				});
				$('#margen_en3').change(function(e){ $('#membrete_en3').height(parseFloat($(this).val())*10); });
				$('#margen_en3').keyup(function(e) { $('#membrete_en3').height(parseFloat($(this).val())*10); });
				$('#margen_pi3').change(function(e){ $('#membrete_pi3').height(parseFloat($(this).val())*10); });
				$('#margen_pi3').keyup(function(e) { $('#membrete_pi3').height(parseFloat($(this).val())*10); });
				
				$('#btn_encabezado3').click(function(e) { $('#fileupload_membreteE3').click(); });
				$('#btn_pie3').click(function(e) { $('#fileupload_membreteP3').click(); });
				
				$('#btn_encabezado3').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS LABORATORIO');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie3').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS LABORATORIO');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				$('#membrete_en4').height(parseFloat(dato[50])*10); $('#membrete_pi4').height(parseFloat(dato[52])*10);
				$('#tam_mem4').change(function(e) {
					if($(this).val()==1){$('#hoja_membret4').height(297); $('#hoja_membret4').width(210);}
					else{$('#hoja_membret4').height(148); $('#hoja_membret4').width(210);}
				});
				$('#margen_en4').change(function(e){ $('#membrete_en4').height(parseFloat($(this).val())*10); });
				$('#margen_en4').keyup(function(e) { $('#membrete_en4').height(parseFloat($(this).val())*10); });
				$('#margen_pi4').change(function(e){ $('#membrete_pi4').height(parseFloat($(this).val())*10); });
				$('#margen_pi4').keyup(function(e) { $('#membrete_pi4').height(parseFloat($(this).val())*10); });
				
				$('#btn_encabezado4').click(function(e) { $('#fileupload_membreteE4').click(); });
				$('#btn_pie4').click(function(e) { $('#fileupload_membreteP4').click(); });
				
				$('#btn_encabezado4').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS IMAGENOLOGIA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie4').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS IMAGENOLOGIA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				$('#membrete_en5').height(parseFloat(dato[53])*10); $('#membrete_pi5').height(parseFloat(dato[55])*10);
				$('#tam_mem5').change(function(e) {
					if($(this).val()==1){$('#hoja_membret5').height(297); $('#hoja_membret5').width(210);}
					else{$('#hoja_membret5').height(148); $('#hoja_membret5').width(210);}
				});
				$('#margen_en5').change(function(e){ $('#membrete_en5').height(parseFloat($(this).val())*10); });
				$('#margen_en5').keyup(function(e) { $('#membrete_en5').height(parseFloat($(this).val())*10); });
				$('#margen_pi5').change(function(e){ $('#membrete_pi5').height(parseFloat($(this).val())*10); });
				$('#margen_pi5').keyup(function(e) { $('#membrete_pi5').height(parseFloat($(this).val())*10); });
				
				$('#btn_encabezado5').click(function(e) { $('#fileupload_membreteE5').click(); });
				$('#btn_pie5').click(function(e) { $('#fileupload_membreteP5').click(); });
				
				$('#btn_encabezado5').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS ENDOSCOPIA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie5').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS ENDOSCOPIA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				$('#membrete_en6').height(parseFloat(dato[56])*10); $('#membrete_pi6').height(parseFloat(dato[58])*10);
				$('#tam_mem6').change(function(e) {
					if($(this).val()==1){$('#hoja_membret6').height(297); $('#hoja_membret6').width(210);}
					else{$('#hoja_membret6').height(148); $('#hoja_membret6').width(210);}
				});
				$('#margen_en6').change(function(e){ $('#membrete_en6').height(parseFloat($(this).val())*10); });
				$('#margen_en6').keyup(function(e) { $('#membrete_en6').height(parseFloat($(this).val())*10); });
				$('#margen_pi6').change(function(e){ $('#membrete_pi6').height(parseFloat($(this).val())*10); });
				$('#margen_pi6').keyup(function(e) { $('#membrete_pi6').height(parseFloat($(this).val())*10); });
				
				$('#btn_encabezado6').click(function(e) { $('#fileupload_membreteE6').click(); });
				$('#btn_pie6').click(function(e) { $('#fileupload_membreteP6').click(); });
				
				$('#btn_encabezado6').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS ULTRASONIDO');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie6').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS ULTRASONIDO');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				$('#membrete_en7').height(parseFloat(dato[59])*10); $('#membrete_pi7').height(parseFloat(dato[61])*10);
				$('#tam_mem7').change(function(e) {
					if($(this).val()==1){$('#hoja_membret7').height(297); $('#hoja_membret7').width(210);}
					else{$('#hoja_membret7').height(148); $('#hoja_membret7').width(210);}
				});
				$('#margen_en7').change(function(e){ $('#membrete_en7').height(parseFloat($(this).val())*10); });
				$('#margen_en7').keyup(function(e) { $('#membrete_en7').height(parseFloat($(this).val())*10); });
				$('#margen_pi7').change(function(e){ $('#membrete_pi7').height(parseFloat($(this).val())*10); });
				$('#margen_pi7').keyup(function(e) { $('#membrete_pi7').height(parseFloat($(this).val())*10); });
				
				$('#btn_encabezado7').click(function(e) { $('#fileupload_membreteE7').click(); });
				$('#btn_pie7').click(function(e) { $('#fileupload_membreteP7').click(); });
				
				$('#btn_encabezado7').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS COLPOSCOPIA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie7').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS COLPOSCOPIA');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				$('#membrete_en8').height(parseFloat(dato[62])*10); $('#membrete_pi8').height(parseFloat(dato[64])*10);
				$('#tam_mem8').change(function(e) {
					if($(this).val()==1){$('#hoja_membret8').height(297); $('#hoja_membret8').width(210);}
					else{$('#hoja_membret8').height(148); $('#hoja_membret8').width(210);}
				});
				$('#margen_en8').change(function(e){ $('#membrete_en8').height(parseFloat($(this).val())*10); });
				$('#margen_en8').keyup(function(e) { $('#membrete_en8').height(parseFloat($(this).val())*10); });
				$('#margen_pi8').change(function(e){ $('#membrete_pi8').height(parseFloat($(this).val())*10); });
				$('#margen_pi8').keyup(function(e) { $('#membrete_pi8').height(parseFloat($(this).val())*10); });
				
				$('#btn_encabezado8').click(function(e) { $('#fileupload_membreteE8').click(); });
				$('#btn_pie8').click(function(e) { $('#fileupload_membreteP8').click(); });
				
				$('#btn_encabezado8').click(function(e){
					$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE SERVICIOS MEDICOS');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				$('#btn_pie8').click(function(e){
					$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE SERVICIOS MEDICOS');
					d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
				});
				
				//Para subir el membrete encabezado
				'use strict'; var userL = $('#id_user').val();
				var url = window.location.hostname === 'blueimp.github.io' ?
					'//jquery-file-upload.appspot.com/' : 'seguros/membretes/index.php?idU='+userL+'&idP='+tempo+'&nombreD='+tempo;
				$('.fileupload_membrete').fileupload({
					url: url, dataType: 'json',
					submit:function (e, data) {
						$.each(data.files, function (index, file) {
							var input = tempo; //alert($('#tit_mem').val());
							data.formData = {
								titulo_d: input, ext_d:file.name.split('.')[1], que_es:$('#tipo_membrete').val(), id_doc:'koby',
								nombre_doc:$('#nombre_membrete').val()
							};
						});
					},
					progress: function (e, data) {
						var progress=parseInt(data.loaded / data.total * 100,10);$('#progressM .bar').css('width',progress + '%');
					},
					done: function (e, data) {
						swal({title:"",type:"",text:"El membrete se ha cargado correctamente!",timer:1800,showConfirmButton:false});
						if($('#nombre_membrete').val()=='ENCABEZADO'){
							var datos = {id_s:tempo,nombre:'ENCABEZADO'}
							$.post('seguros/files-serverside/datosMembrete.php',datos).done(function( data ){
								var datosM = data.split('*{');
								x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
							
								var membretD = 'url('+x+')';
								if( $('#tipo_membrete').val() == 'MEMBRETE NOTA MEDICA' ){
									$("#membrete_en").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RECETA MEDICA'){
									$("#membrete_en2").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS LABORATORIO'){
									$("#membrete_en3").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS IMAGENOLOGIA'){
									$("#membrete_en4").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ENDOSCOPIA'){
									$("#membrete_en5").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ULTRASONIDO'){
									$("#membrete_en6").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS COLPOSCOPIA'){
									$("#membrete_en7").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE SERVICIOS MEDICOS'){
									$("#membrete_en8").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
								}
							});
						}else{
							var datos = {id_s:tempo,nombre:'PIE'}
							$.post('seguros/files-serverside/datosMembrete.php',datos).done(function( data ){
								var datosM = data.split('*{');
								x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
							
								var membretD = 'url('+x+')';
								if( $('#tipo_membrete').val() == 'MEMBRETE NOTA MEDICA' ){
									$("#membrete_pi").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RECETA MEDICA'){
									$("#membrete_pi2").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS LABORATORIO'){
									$("#membrete_pi3").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS IMAGENOLOGIA'){
									$("#membrete_pi4").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ENDOSCOPIA'){
									$("#membrete_pi5").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ULTRASONIDO'){
									$("#membrete_pi6").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS COLPOSCOPIA'){
									$("#membrete_pi7").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}else if($('#tipo_membrete').val() == 'MEMBRETE SERVICIOS MEDICOS'){
									$("#membrete_pi8").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
								}
							});
						}			
					},
				}); //Para el upload
				
				$('#btn_imprimir_mem1').click(function(e) {
					$('#table_membre1').prop('border',0); $('#table_membre1').printElement(); $('#table_membre1').prop('border',1);
				});
				$('#btn_imprimir_mem2').click(function(e) {
					$('#table_membre2').prop('border',0); $('#table_membre2').printElement(); $('#table_membre2').prop('border',1);
				});
				$('#btn_imprimir_mem3').click(function(e) {
					$('#table_membre3').prop('border',0); $('#table_membre3').printElement(); $('#table_membre3').prop('border',1);
				});
				$('#btn_imprimir_mem4').click(function(e) {
					$('#table_membre4').prop('border',0); $('#table_membre4').printElement(); $('#table_membre4').prop('border',1);
				});
				$('#btn_imprimir_mem5').click(function(e) {
					$('#table_membre5').prop('border',0); $('#table_membre5').printElement(); $('#table_membre5').prop('border',1);
				});
				$('#btn_imprimir_mem6').click(function(e) {
					$('#table_membre6').prop('border',0); $('#table_membre6').printElement(); $('#table_membre6').prop('border',1);
				});
				$('#btn_imprimir_mem7').click(function(e) {
					$('#table_membre7').prop('border',0); $('#table_membre7').printElement(); $('#table_membre7').prop('border',1);
				});
				$('#btn_imprimir_mem8').click(function(e) {
					$('#table_membre8').prop('border',0); $('#table_membre8').printElement(); $('#table_membre8').prop('border',1);
				});
			});
			
			$('#form-registro').validator().on('submit', function (e) {
			  $('#input_a').val(tinyMCE.get("input").getContent()); $('#input_b').val(tinyMCE.get("input1").getContent());
			  $('#input_c').val(tinyMCE.get("input2").getContent()); $('#input_d').val(tinyMCE.get("input3").getContent());
			  $('#input_e').val(tinyMCE.get("input4").getContent()); $('#input_f').val(tinyMCE.get("input5").getContent());
			  $('#input_g').val(tinyMCE.get("input6").getContent()); $('#input_h').val(tinyMCE.get("input7").getContent());
			  
			  if (e.isDefaultPrevented()) { // handle the invalid form...
				$("#alerta_form").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_form").slideUp(600); });
			  } else { // everything looks good!
				e.preventDefault(); 
				var datosP = $('#myModal #form-registro').serialize();
				$.post('seguros/files-serverside/updateSucursal.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $('#myModal').modal('hide');
						swal({title:"",type:"success",text:"Los datos de la sucursal se han actualizado.",timer:1800,showConfirmButton:false});return;
					} else{alert(data);}
				});
			  }
			});
			
			$('#myModal').modal('show');
			$('#myModal').on('shown.bs.modal',function(e){ $('#form-registro').validator(); });
			$('#myModal').on('hidden.bs.modal',function(e){ $(".modal-content").remove(); $("#myModal").empty(); });
		});
	}});
}
function nuevaSucursal(){
	$("#myModal").load('seguros/htmls/fichaSucursal.php', function( response, status, xhr ){ if(status=="success"){ var datosF = {id:1}
		$(".insers").load('genera/inserciones.php', function( response, status, xhr ) { if ( status == "success" ) { } });
		$.post('seguros/files-serverside/formatos_base.php',datosF).done(function(data){ var formato_x = data.split('{*]-[}');
			tinymce.remove("#input"); tinymce.remove("#input1"); tinymce.remove("#input2"); tinymce.remove("#input3"); tinymce.remove("#input4");
			tinymce.remove("#input5"); tinymce.remove("#input6"); tinymce.remove("#input7");
			
			//Formato Nota Médica
			$('#input').val(formato_x[0]);			
			//Formato Receta Médica
			$('#input1').val(formato_x[1]);
			//Formato Estudios Laboratorio
			$('#input2').val(formato_x[2]);
			//Formato Estudios Imagen
			$('#input3').val(formato_x[3]);
			//Formato Estudios Endoscopía
			$('#input4').val(formato_x[4]);
			//Formato Estudios Ultrasonido
			$('#input5').val(formato_x[5]);
			//Formato Estudios Colposcopía
			$('#input6').val(formato_x[6]);
			//Formato Servicios Médicos
			$('#input7').val(formato_x[7]);
			
			cargar_editores();
					
			$("#p_tabu_img").ionRangeSlider({
				min:0,max:200,from:100,prefix:"%",grid:true,onChange:function(data){$('#p_tabu_img').val(data.from);}
			});
			$("#p_tabu_lab").ionRangeSlider({
				min: 0, max: 200, from: 100, prefix: "%", grid: true, onChange: function (data) { $('#p_tabu_lab').val(data.from); }
			});
			$("#p_tabu_serv").ionRangeSlider({
				min: 0, max: 200, from: 100, prefix: "%", grid: true, onChange: function (data) { $('#p_tabu_serv').val(data.from); }
			});
			$('#alerta_form').hide(); var d = new Date(); $('#temporal_s').val(d.format('Y-m-d-H-i-s-u').substring(0,22));
			siempre(18.8135, -98.9535); $('#idUsuarioP').val($('#id_user').val());
			$('.clockpicker').clockpicker().find('input').change(function(){ console.log(this.value); });
			var input = $('#single-input').clockpicker({
				placement: 'bottom',align: 'left',autoclose: true, //'default': 'now'
			}); $('.popover').css('z-index','3000');
			var tempo = $('#temporal_s').val();
			var oTableDoc = $('#dataTableDocs').DataTable({
				serverSide: true,ordering: false, searching: false, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
				"aoColumns":[
					{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},
					{"bVisible":false},{"bVisible":true}
				],
				"sDom": '<""f>r<""t><""S><""p>',  deferRender: true, select: false, "processing": false, 
				"sAjaxSource": "seguros/datatable-serverside/documentos.php",
				"fnServerParams": function (aoData, fnCallback) { 
					var aleatorio = $('#temporal_s').val(); aoData.push( {"name": "aleatorio", "value": aleatorio } );
					var acc_user = $('#acc_user').val(); aoData.push( {"name": "acc_user", "value": acc_user } );
				},
				"oLanguage": {
					"sLengthMenu":"MONSTRANDO _MENU_ records per page","sZeroRecords":"ESTA SUCURSAL NO CUENTA CON DOCUMENTOS O IMÁGENES",
					"sInfo": "DOCUMENTOS FILTRADOS: _END_",
					"sInfoEmpty": "NINGÚN DOCUMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE DOCUMENTOS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 100, paging: false,
			}); $('#clickmeDocs').click(function(e) { oTableDoc.draw(); });
			$('#tab_mi_arc').click(function(e) { window.setTimeout(function(){oTableDoc.draw();},200); });
			
			$('#titulo_foto').keyup(function(e) {
				if($(this).val()!=''){ $('#btn_add_doc').removeClass('disabled'); }else{ $('#btn_add_doc').addClass('disabled'); }
			});
			$('#btn_add_doc').click(function(e) {
				if($('#titulo_foto').val()!=''){ $('#fileupload_foto').click(); }else{ }
			});
			//Para el upload
			'use strict';
			// Change this to the location of your server-side upload handler:
			var ko = $('#id_user').val();
			var url = window.location.hostname === 'blueimp.github.io' ?
						'//jquery-file-upload.appspot.com/' : 'seguros/documentos/index.php?idU='+ko+'&idP='+tempo+'&nombreD='+escape($('#titulo_foto').val());
			$('#fileupload_foto').fileupload({
				url: url, dataType: 'json',
				submit:function (e, data) {
					if($('#titulo_foto').val()!=''){
						$.each(data.files, function (index, file) {
							var input = $('#titulo_foto'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
						});
					}else{return false;}
				},
				progress: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);$('#progress .bar').css( 'width', progress + '%' );
				},
				done: function (e, data) {
					swal({title:"",type:"",text:"El documento se ha cargado correctamente!",timer:1800,showConfirmButton:false});
					$('#clickmeDocs').click(); $('#titulo_foto').val(''); $('#btn_add_doc').addClass('disabled');
				}
			}); //Para el upload
			$('#checkbox-lu').click(function(e){
				if($(this).is(':checked')){ $('#lunes_de1').val('08:00');$('#lunes_a1').val('18:00');$('#t_lunes').val(1); }
				else{ $('#lunes_de1').val('00:00');$('#lunes_a1').val('00:00');$('#t_lunes').val(0); } 
			});
			$('#checkbox-ma').click(function(e){
				if($(this).is(':checked')){ $('#martes_de1').val('08:00');$('#martes_a1').val('18:00');$('#t_martes').val(1); }
				else{ $('#martes_de1').val('00:00');$('#martes_a1').val('00:00');$('#t_martes').val(0); } 
			});
			$('#checkbox-mi').click(function(e){
				if($(this).is(':checked')){$('#miercoles_de1').val('08:00');$('#miercoles_a1').val('18:00');$('#t_miercoles').val(1); }
				else{$('#miercoles_de1').val('00:00');$('#miercoles_a1').val('00:00');$('#t_miercoles').val(0); } 
			});
			$('#checkbox-ju').click(function(e){
				if($(this).is(':checked')){$('#jueves_de1').val('08:00');$('#jueves_a1').val('18:00');$('#t_jueves').val(1); }
				else{$('#jueves_de1').val('00:00');$('#jueves_a1').val('00:00');$('#t_jueves').val(0); } 
			});
			$('#checkbox-vi').click(function(e){
				if($(this).is(':checked')){$('#viernes_de1').val('08:00');$('#viernes_a1').val('18:00');$('#t_viernes').val(1); }
				else{$('#viernes_de1').val('00:00');$('#viernes_a1').val('00:00');$('#t_viernes').val(0); } 
			});
			$('#checkbox-sa').click(function(e){
				if($(this).is(':checked')){$('#sabado_de1').val('08:00');$('#sabado_a1').val('14:00');$('#t_sabado').val(1); }
				else{$('#sabado_de1').val('00:00');$('#sabado_a1').val('00:00');$('#t_sabado').val(0); } 
			});
			$('#checkbox-do').click(function(e){
				if($(this).is(':checked')){$('#domingo_de1').val('08:00');$('#domingo_a1').val('14:00');$('#t_domingo').val(1); }
				else{$('#domingo_de1').val('00:00');$('#domingo_a1').val('00:00');$('#t_domingo').val(0); } 
			});
			$('.chekito').click(function(e) { //alert($(this).attr('lang'));
				if($(this).is(':checked')){ $('#'+$(this).attr('lang')).val(1); } else{ $('#'+$(this).attr('lang')).val(0); }
			});
			//$(".membre").load('seguros/htmls/subir_membretes.php',function(response,status,xhr){if(status=="success"){ }});
			$('#membrete_en1').height(28); $('#membrete_pi1').height(23);
			$('#tam_mem1').change(function(e) {
				if($(this).val()==1){$('#hoja_membret').height(297); $('#hoja_membret').width(210);}
				else{$('#hoja_membret').height(148); $('#hoja_membret').width(210);}
			});
			$('#margen_en1').change(function(e){ $('#membrete_en1').height(parseFloat($(this).val())*10); });
			$('#margen_en1').keyup(function(e) { $('#membrete_en1').height(parseFloat($(this).val())*10); });
			$('#margen_pi1').change(function(e){ $('#membrete_pi1').height(parseFloat($(this).val())*10); });
			$('#margen_pi1').keyup(function(e) { $('#membrete_pi1').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado1').click(function(e) { $('#fileupload_membreteE1').click(); });
			$('#btn_pie1').click(function(e) { $('#fileupload_membreteP1').click(); });
			
			$('#btn_encabezado1').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE NOTA MEDICA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie1').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE NOTA MEDICA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			$('#membrete_en2').height(28); $('#membrete_pi2').height(23);
			$('#tam_mem2').change(function(e) {
				if($(this).val()==1){$('#hoja_membret2').height(297); $('#hoja_membret2').width(210);}
				else{$('#hoja_membret2').height(148); $('#hoja_membret2').width(210);}
			});
			$('#margen_en2').change(function(e){ $('#membrete_en2').height(parseFloat($(this).val())*10); });
			$('#margen_en2').keyup(function(e) { $('#membrete_en2').height(parseFloat($(this).val())*10); });
			$('#margen_pi2').change(function(e){ $('#membrete_pi2').height(parseFloat($(this).val())*10); });
			$('#margen_pi2').keyup(function(e) { $('#membrete_pi2').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado2').click(function(e) { $('#fileupload_membreteE2').click(); });
			$('#btn_pie2').click(function(e) { $('#fileupload_membreteP2').click(); });
			
			$('#btn_encabezado2').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RECETA MEDICA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie2').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RECETA MEDICA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			$('#membrete_en3').height(28); $('#membrete_pi3').height(23);
			$('#tam_mem3').change(function(e) {
				if($(this).val()==1){$('#hoja_membret3').height(297); $('#hoja_membret3').width(210);}
				else{$('#hoja_membret3').height(148); $('#hoja_membret3').width(210);}
			});
			$('#margen_en3').change(function(e){ $('#membrete_en3').height(parseFloat($(this).val())*10); });
			$('#margen_en3').keyup(function(e) { $('#membrete_en3').height(parseFloat($(this).val())*10); });
			$('#margen_pi3').change(function(e){ $('#membrete_pi3').height(parseFloat($(this).val())*10); });
			$('#margen_pi3').keyup(function(e) { $('#membrete_pi3').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado3').click(function(e) { $('#fileupload_membreteE3').click(); });
			$('#btn_pie3').click(function(e) { $('#fileupload_membreteP3').click(); });
			
			$('#btn_encabezado3').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS LABORATORIO');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie3').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS LABORATORIO');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			$('#membrete_en4').height(28); $('#membrete_pi4').height(23);
			$('#tam_mem4').change(function(e) {
				if($(this).val()==1){$('#hoja_membret4').height(297); $('#hoja_membret4').width(210);}
				else{$('#hoja_membret4').height(148); $('#hoja_membret4').width(210);}
			});
			$('#margen_en4').change(function(e){ $('#membrete_en4').height(parseFloat($(this).val())*10); });
			$('#margen_en4').keyup(function(e) { $('#membrete_en4').height(parseFloat($(this).val())*10); });
			$('#margen_pi4').change(function(e){ $('#membrete_pi4').height(parseFloat($(this).val())*10); });
			$('#margen_pi4').keyup(function(e) { $('#membrete_pi4').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado4').click(function(e) { $('#fileupload_membreteE4').click(); });
			$('#btn_pie4').click(function(e) { $('#fileupload_membreteP4').click(); });
			
			$('#btn_encabezado4').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS IMAGENOLOGIA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie4').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS IMAGENOLOGIA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			$('#membrete_en5').height(28); $('#membrete_pi5').height(23);
			$('#tam_mem5').change(function(e) {
				if($(this).val()==1){$('#hoja_membret5').height(297); $('#hoja_membret5').width(210);}
				else{$('#hoja_membret5').height(148); $('#hoja_membret5').width(210);}
			});
			$('#margen_en5').change(function(e){ $('#membrete_en5').height(parseFloat($(this).val())*10); });
			$('#margen_en5').keyup(function(e) { $('#membrete_en5').height(parseFloat($(this).val())*10); });
			$('#margen_pi5').change(function(e){ $('#membrete_pi5').height(parseFloat($(this).val())*10); });
			$('#margen_pi5').keyup(function(e) { $('#membrete_pi5').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado5').click(function(e) { $('#fileupload_membreteE5').click(); });
			$('#btn_pie5').click(function(e) { $('#fileupload_membreteP5').click(); });
			
			$('#btn_encabezado5').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS ENDOSCOPIA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie5').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS ENDOSCOPIA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			$('#membrete_en6').height(28); $('#membrete_pi6').height(23);
			$('#tam_mem6').change(function(e) {
				if($(this).val()==1){$('#hoja_membret6').height(297); $('#hoja_membret6').width(210);}
				else{$('#hoja_membret6').height(148); $('#hoja_membret6').width(210);}
			});
			$('#margen_en6').change(function(e){ $('#membrete_en6').height(parseFloat($(this).val())*10); });
			$('#margen_en6').keyup(function(e) { $('#membrete_en6').height(parseFloat($(this).val())*10); });
			$('#margen_pi6').change(function(e){ $('#membrete_pi6').height(parseFloat($(this).val())*10); });
			$('#margen_pi6').keyup(function(e) { $('#membrete_pi6').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado6').click(function(e) { $('#fileupload_membreteE6').click(); });
			$('#btn_pie6').click(function(e) { $('#fileupload_membreteP6').click(); });
			
			$('#btn_encabezado6').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS ULTRASONIDO');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie6').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS ULTRASONIDO');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			$('#membrete_en7').height(28); $('#membrete_pi7').height(23);
			$('#tam_mem7').change(function(e) {
				if($(this).val()==1){$('#hoja_membret7').height(297); $('#hoja_membret7').width(210);}
				else{$('#hoja_membret7').height(148); $('#hoja_membret7').width(210);}
			});
			$('#margen_en7').change(function(e){ $('#membrete_en7').height(parseFloat($(this).val())*10); });
			$('#margen_en7').keyup(function(e) { $('#membrete_en7').height(parseFloat($(this).val())*10); });
			$('#margen_pi7').change(function(e){ $('#membrete_pi7').height(parseFloat($(this).val())*10); });
			$('#margen_pi7').keyup(function(e) { $('#membrete_pi7').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado7').click(function(e) { $('#fileupload_membreteE7').click(); });
			$('#btn_pie7').click(function(e) { $('#fileupload_membreteP7').click(); });
			
			$('#btn_encabezado7').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE RESULTADOS COLPOSCOPIA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie7').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE RESULTADOS COLPOSCOPIA');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			$('#membrete_en8').height(28); $('#membrete_pi8').height(23);
			$('#tam_mem8').change(function(e) {
				if($(this).val()==1){$('#hoja_membret8').height(297); $('#hoja_membret8').width(210);}
				else{$('#hoja_membret8').height(148); $('#hoja_membret8').width(210);}
			});
			$('#margen_en8').change(function(e){ $('#membrete_en8').height(parseFloat($(this).val())*10); });
			$('#margen_en8').keyup(function(e) { $('#membrete_en8').height(parseFloat($(this).val())*10); });
			$('#margen_pi8').change(function(e){ $('#membrete_pi8').height(parseFloat($(this).val())*10); });
			$('#margen_pi8').keyup(function(e) { $('#membrete_pi8').height(parseFloat($(this).val())*10); });
			
			$('#btn_encabezado8').click(function(e) { $('#fileupload_membreteE8').click(); });
			$('#btn_pie8').click(function(e) { $('#fileupload_membreteP8').click(); });
			
			$('#btn_encabezado8').click(function(e){
				$('#nombre_membrete').val('ENCABEZADO');$('#tipo_membrete').val('MEMBRETE SERVICIOS MEDICOS');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			$('#btn_pie8').click(function(e){
				$('#nombre_membrete').val('PIE');$('#tipo_membrete').val('MEMBRETE SERVICIOS MEDICOS');
				d1 = new Date(); $('#aleat_membrete').val(d1.format('Y-m-d-H-i-s-u').substring(0,22));
			});
			
			//Para subir el membrete encabezado
			'use strict'; var userL = $('#id_user').val();
			var url = window.location.hostname === 'blueimp.github.io' ?
				'//jquery-file-upload.appspot.com/' : 'seguros/membretes/index.php?idU='+userL+'&idP='+tempo+'&nombreD='+tempo;
			$('.fileupload_membrete').fileupload({
				url: url, dataType: 'json',
				submit:function (e, data) {
					$.each(data.files, function (index, file) {
						var input = tempo; //alert($('#tit_mem').val());
						data.formData = {
							titulo_d: input, ext_d:file.name.split('.')[1], que_es:$('#tipo_membrete').val(), id_doc:'koby',
							nombre_doc:$('#nombre_membrete').val()
						};
					});
				},
				progress: function (e, data) {
					var progress=parseInt(data.loaded / data.total * 100,10);$('#progressM .bar').css('width',progress + '%');
				},
				done: function (e, data) {
					swal({title:"",type:"",text:"El membrete se ha cargado correctamente!",timer:1800,showConfirmButton:false});
					if($('#nombre_membrete').val()=='ENCABEZADO'){
						var datos = {id_s:tempo,nombre:'ENCABEZADO'}
						$.post('seguros/files-serverside/datosMembrete.php',datos).done(function( data ){
							var datosM = data.split('*{');
							x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						
							var membretD = 'url('+x+')';
							if( $('#tipo_membrete').val() == 'MEMBRETE NOTA MEDICA' ){
								$("#membrete_en").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RECETA MEDICA'){
								$("#membrete_en2").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS LABORATORIO'){
								$("#membrete_en3").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS IMAGENOLOGIA'){
								$("#membrete_en4").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ENDOSCOPIA'){
								$("#membrete_en5").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ULTRASONIDO'){
								$("#membrete_en6").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS COLPOSCOPIA'){
								$("#membrete_en7").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE SERVICIOS MEDICOS'){
								$("#membrete_en8").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','center');
							}
						});
					}else{
						var datos = {id_s:tempo,nombre:'PIE'}
						$.post('seguros/files-serverside/datosMembrete.php',datos).done(function( data ){
							var datosM = data.split('*{');
							x='seguros/membretes/files/'+datosM[0]+'.'+datosM[1]+'?'+$('#aleat_membrete').val();
						
							var membretD = 'url('+x+')';
							if( $('#tipo_membrete').val() == 'MEMBRETE NOTA MEDICA' ){
								$("#membrete_pi").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RECETA MEDICA'){
								$("#membrete_pi2").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS LABORATORIO'){
								$("#membrete_pi3").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS IMAGENOLOGIA'){
								$("#membrete_pi4").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ENDOSCOPIA'){
								$("#membrete_pi5").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS ULTRASONIDO'){
								$("#membrete_pi6").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE RESULTADOS COLPOSCOPIA'){
								$("#membrete_pi7").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}else if($('#tipo_membrete').val() == 'MEMBRETE SERVICIOS MEDICOS'){
								$("#membrete_pi8").css('background-image',membretD).css('background-size','contain').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
							}
						});
					}			
				},
			}); //Para el upload
			
			$('#btn_imprimir_mem1').click(function(e) {
				$('#table_membre1').prop('border',0); $('#table_membre1').printElement(); $('#table_membre1').prop('border',1);
			});
			$('#btn_imprimir_mem2').click(function(e) {
				$('#table_membre2').prop('border',0); $('#table_membre2').printElement(); $('#table_membre2').prop('border',1);
			});
			$('#btn_imprimir_mem3').click(function(e) {
				$('#table_membre3').prop('border',0); $('#table_membre3').printElement(); $('#table_membre3').prop('border',1);
			});
			$('#btn_imprimir_mem4').click(function(e) {
				$('#table_membre4').prop('border',0); $('#table_membre4').printElement(); $('#table_membre4').prop('border',1);
			});
			$('#btn_imprimir_mem5').click(function(e) {
				$('#table_membre5').prop('border',0); $('#table_membre5').printElement(); $('#table_membre5').prop('border',1);
			});
			$('#btn_imprimir_mem6').click(function(e) {
				$('#table_membre6').prop('border',0); $('#table_membre6').printElement(); $('#table_membre6').prop('border',1);
			});
			$('#btn_imprimir_mem7').click(function(e) {
				$('#table_membre7').prop('border',0); $('#table_membre7').printElement(); $('#table_membre7').prop('border',1);
			});
			$('#btn_imprimir_mem8').click(function(e) {
				$('#table_membre8').prop('border',0); $('#table_membre8').printElement(); $('#table_membre8').prop('border',1);
			});
			
			$('#form-registro').validator().on('submit', function (e) {
			  $('#input_a').val(tinyMCE.get("input").getContent()); $('#input_b').val(tinyMCE.get("input1").getContent());
			  $('#input_c').val(tinyMCE.get("input2").getContent()); $('#input_d').val(tinyMCE.get("input3").getContent());
			  $('#input_e').val(tinyMCE.get("input4").getContent()); $('#input_f').val(tinyMCE.get("input5").getContent());
			  $('#input_g').val(tinyMCE.get("input6").getContent()); $('#input_h').val(tinyMCE.get("input7").getContent());
			  
			  if (e.isDefaultPrevented()) { // handle the invalid form...
				$("#alerta_form").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_form").slideUp(600); });
			  } else { // everything looks good!
				e.preventDefault(); 
				var datosP = $('#myModal #form-registro').serialize();
				$.post('seguros/files-serverside/addSucursal.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $('#myModal').modal('hide');
						swal({title:"",type:"success",text:"La sucursal ha sido creada.",timer:1800,showConfirmButton:false});return;
					} else{alert(data);}
				});
			  }
			});
			
			$('#myModal').modal('show');
			$('#myModal').on('shown.bs.modal',function(e){ $('#form-registro').validator(); });
			$('#myModal').on('hidden.bs.modal',function(e){ $(".modal-content").remove(); $("#myModal").empty(); });
		});
	}});
}
function ver_docu(id_doc,exte,time){
	$('.no_document').addClass('hidden'); $('.si_document').removeClass('hidden');
	if(!$('#btn_update_u').hasClass('hidden')){$('#btn_update_u').addClass('hidden');}
	var widi = $('#myModal').width()*0.6;
	if(exte != 'pdf' & exte != 'PDF'){
		x='seguros/documentos/files/'+id_doc+'.'+exte+'?'+time;
		$('#mi_documento').html('<img src='+x+' style="max-width:'+widi+'px; border:3px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
	}else{
		x='seguros/documentos/files/'+id_doc+'.pdf'; 
		var h=$('#referencia').height()-$('#nav-header').height()-$('#my_footer').height();
		$('#mi_documento').html('<a class="media" href=""> </a>'); $('a.media').media({width:790, height:h-136, src:x});	
	}
}
function eliminar_docu(id_doc, ext_doc, nombre_doc){//alert(tipo_doc);
	swal({
	  title: "Eliminar documento", text: "¿ESTÁ SEGURO QUE DESEA ELIMINAR EL DOCUMENTO "+nombre_doc+"?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		var datos = {id:id_doc, tipo:ext_doc}
		$.post('seguros/files-serverside/eliminarDocumento.php',datos).done(function(data){
			if (data==1){ $('#clickmeDocs').click();
				swal({title:"",type:"",text:"El documento se ha eliminado!",timer:1800,showConfirmButton:false});
			}else{alert(data);}
		});
	});
}
function cerrar_ver_doc(){ $('.no_document').removeClass('hidden'); $('.si_document').addClass('hidden'); }
function foto_perfil(idD,aleat){
	swal({
	  title:"",text:"¿Quieres actualizar el logotipo a esta imagen?",type:"warning",showCancelButton:true,
	  confirmButtonColor:"#DD6B55",confirmButtonText:"Actualizar",closeOnConfirm:false,cancelButtonText:"Cancelar"
	},
	function(){
		var datos = {id:idD, tempo:aleat}
		$.post('usuarios/files-serverside/foto_perfil.php',datos).done(function(data){ $('#clickmeDocs').click();
			if(data==1){swal({title:"",type:"",text:"El logotipo de la sucursal se ha actualizado",timer:1800,showConfirmButton:false});}
			else{alert(data);}
		});
	});
}
function siempre(la,lo){
	var i=0;
	$('#tab_mi_dir').click(function(e) {
	  if(i%2==0){i++;
	  var map = new google.maps.Map(document.getElementById('map'), {
		center: new google.maps.LatLng(la, lo), zoom: 16, scrollwheel: false //Cuautla :3
	  });
	  marker = new google.maps.Marker({
		map: map, draggable: true, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la, lo)
	  });

	  $('#p_latitud').text(redondear(la,4));$('#p_latitud_s').val(la);
	  $('#p_longitud').text(redondear(lo,4));$('#p_longitud_s').val(lo);
	  marker.addListener('dragend', function(){
		  map.panTo(marker.getPosition());
		  var markerLatLng = marker.getPosition();
		  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
		  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
	  });
	  google.maps.event.addListener(marker, 'click', function(){ });

	  var geocoder = new google.maps.Geocoder();
	  $('.mi_dir').keyup(function(e) { 
		  var address = document.getElementById('estadoP').value+' '+document.getElementById('ciudadP').value+' '+document.getElementById('coloniaP').value+' '+document.getElementById('calleS').value;

		  geocoder.geocode({'address': address}, function(results, status) { 
			if (status === google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			  var markerLatLng = results[0].geometry.location;
			  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
			  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
			  
			  marker.setPosition(results[0].geometry.location);
			} //else { alert('Geocode was not successful for the following reason: ' + status); }
		  });
	  });
	  $('.mi_dir').change(function(e) { 
		  var address = document.getElementById('estadoP').value+' '+document.getElementById('ciudadP').value+' '+document.getElementById('coloniaP').value+' '+document.getElementById('calleS').value;

		  geocoder.geocode({'address': address}, function(results, status) { 
			if (status === google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			  var markerLatLng = results[0].geometry.location;
			  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
			  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
			  
			  marker.setPosition(results[0].geometry.location);
			} //else { alert('Geocode was not successful for the following reason: ' + status); }
		  });
	  });
	  }
	});
}
function initMap() { }

function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); $('#inserta_algo').val(''); }
function insertAtCaret1(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); $('#inserta_algo1').val(''); }
function insertAtCaret2(text) { tinymce.get("input1").execCommand('mceInsertContent', false, text); $('#inserta_algo2').val(''); }
function insertAtCaret3(text) { tinymce.get("input1").execCommand('mceInsertContent', false, text); $('#inserta_algo3').val(''); }
function insertAtCaret4(text) { tinymce.get("input2").execCommand('mceInsertContent', false, text); $('#inserta_algo4').val(''); }
function insertAtCaret5(text) { tinymce.get("input2").execCommand('mceInsertContent', false, text); $('#inserta_algo5').val(''); }
function insertAtCaret6(text) { tinymce.get("input3").execCommand('mceInsertContent', false, text); $('#inserta_algo6').val(''); }
function insertAtCaret7(text) { tinymce.get("input3").execCommand('mceInsertContent', false, text); $('#inserta_algo7').val(''); }
function insertAtCaret8(text) { tinymce.get("input4").execCommand('mceInsertContent', false, text); $('#inserta_algo8').val(''); }
function insertAtCaret9(text) { tinymce.get("input4").execCommand('mceInsertContent', false, text); $('#inserta_algo9').val(''); }
function insertAtCaret10(text) { tinymce.get("input5").execCommand('mceInsertContent', false, text); $('#inserta_algo10').val(''); }
function insertAtCaret11(text) { tinymce.get("input5").execCommand('mceInsertContent', false, text); $('#inserta_algo11').val(''); }
function insertAtCaret12(text) { tinymce.get("input6").execCommand('mceInsertContent', false, text); $('#inserta_algo12').val(''); }
function insertAtCaret13(text) { tinymce.get("input6").execCommand('mceInsertContent', false, text); $('#inserta_algo13').val(''); }
function insertAtCaret14(text) { tinymce.get("input7").execCommand('mceInsertContent', false, text); $('#inserta_algo14').val(''); }
function insertAtCaret15(text) { tinymce.get("input7").execCommand('mceInsertContent', false, text); $('#inserta_algo15').val(''); }

function cargar_editores(){
	tinymce.init({ 
		selector:'#myModal #input',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir').html(res); $('#dpa_imprimir').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#myModal #input1',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input1").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#myModal #input2',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input2").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir2').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir2').html(res); $('#dpa_imprimir2').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#myModal #input3',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input3").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir3').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir3').html(res); $('#dpa_imprimir3').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#myModal #input4',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input4").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir4').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir4').html(res); $('#dpa_imprimir4').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#myModal #input5',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input5").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir5').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir5').html(res); $('#dpa_imprimir5').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#myModal #input6',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input6").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir6').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir6').html(res); $('#dpa_imprimir6').printElement();
				}
			});
		}
	});
	
	tinymce.init({ 
		selector:'#myModal #input7',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
		plugins: 
			"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
		relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
		toolbar: 
			"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
		insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
		paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
		setup: function(editor){
			editor.addButton( 'mybuttonVP', {
				text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
				onclick:function(){
					var res = tinyMCE.get("input7").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
					$('#dpa_imprimir7').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
					$('#dpa_imprimir7').html(res); $('#dpa_imprimir7').printElement();
				}
			});
		}
	});
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4cHSkoaQwTQjx31Y3xFf3kkSkD28X_Rs&callback=initMap"
	async defer>
</script>
