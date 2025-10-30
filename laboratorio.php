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
    
    <title>SISTEMA - LABORATORIO</title>
    
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

	<script src="DataTables-1.12/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="DataTables-1.12/JSZip-2.5.0/jszip.min.js"></script>
    <script src="DataTables-1.12/Buttons-2.2.3/js/buttons.html5.min.js"></script> 

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
    <script src="laboratorio/takeArchivos/ajaxupload.js" type="text/javascript"></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script> 
    <!-- Mis funciones -->
    <script src="funciones/js/redondea.js"></script>
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
<input id="mi_id_paciente1" type="hidden" value=""> <input id="mi_id_estudio1" type="hidden" value="">
<input id="mi_nombre_estudio1" type="hidden" value="">
<input id="sucursal_ocu1" type="hidden" value=""> <input id="name_area" type="hidden" value="">
	
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>

<div id="div_tabla_pacientes" class="" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table-hover table-striped table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">PACIENTE</th>
    <th style="vertical-align:middle;">REFERENCIA</th>
    <th style="vertical-align:middle;">ESTUDIO</th>
    <th style="vertical-align:middle;">ESTATUS</th>
    <th style="vertical-align:middle;">ÁREA</th>
    <th style="vertical-align:middle;">SUCURSAL</th>
    <th style="vertical-align:middle;" style="max-width:10px;">EDITAR</th>
    <th style="vertical-align:middle;" style="max-width:10px;">MEDICO REFIERE</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-PACIENTE-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-REFERENCIA-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTUDIO-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTATUS-" style="max-width:90px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ÁREA-" style="max-width:100px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-SUCURSAL-" style="max-width:100px;"/></th>
            <th></th>
			<th><input type="text" class="form-control input-sm" placeholder="-MEDICO-" style="max-width:200px;"/></th>
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
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>LABORATORIO</li><li class="active"><strong>ESTUDIOS DE LABORATORIO</strong></li>');
	
	var bootstrapButton = $.fn.button.noConflict();  $.fn.bootstrapBtn = bootstrapButton; 

	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-161-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>B1<"data_tPrincipal"t><"infoPrincipal"iS><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "laboratorio/datatable-serverside/estudios.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val();
			var de = $('#fechaDe').val()+' 00:00:00';
			var a = $('#fechaA').val()+' 23:59:59';
			var acceso = $('#acc_user').val(); 
			var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } ); 
			aoData.push(  {"name": "acceso", "value": acceso } );
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

function editar(x, estudio, referencia, paciente){//alert($('#acc_user').val());// x=id del estudio en vc
	if($('#acc_user').val()==1){
		swal({
		  title: "EDITAR LOS RESULTADOS",
		  text: "¿Estás seguro de querer editar los resultados del estudio "+estudio+" del paciente "+paciente+" con referencia "+referencia+"?",
		  type: "warning", showCancelButton: true,
		  confirmButtonColor: "#DD6B55", confirmButtonText: "Editar", cancelButtonText: "Cancelar", closeOnConfirm: false
		},
		function(){
		  	var dato = { idE:x, idU:$('#id_user').val() }
			$.post('laboratorio/files-serverside/editarResultados.php', dato).done(function( data ) {
				if(data==1){
					swal.close(); $('#clickme').click();
					window.setTimeout(function(){
						swal({title:"",type:"success",text:"¡Los resultados están listos para su edición!",timer:2500,showConfirmButton:false});
					},300);
				}else{alert(data);}
			});
		});
	}else{ swal({title:"",type:"error",text:"¡Acceso restringido!",timer:2500,showConfirmButton:false}); }
}//fin editar

function procesar(a,b){//a es el id del paciente y b es el id del estudio en venta de conceptos
	$("#myModal1").load("laboratorio/htmls/procesar.php",function(response,status,xhr){ if(status == "success"){
		$('#individualPro').click(function(e) { 
			if($(this).prop('checked')==true){ 
				$('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();
			}else{ $('#individualPro').prop('checked',true); } 
		});
		$('#variosPro').click(function(e) { 
			if($(this).prop('checked')==true){ 
				$('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();
			}else{ $('#variosPro').prop('checked',true); }
		});
		
		$('#idPacientePro').val(a); $('#idEstudioPro').val(b);
		
		var datoP = {idP:a, idE:b}
		$.post('laboratorio/archivos_save_ajax/datosProcesar.php', datoP).done(function( data ) { 
			var datosP = data.split('*}'); 
			$('#pacientePro').text(datosP[0]); $('#refPro').text(datosP[1]); $('#ordenPro').text(datosP[1]); 
			$('#estPro').text(datosP[2]); $('#areaPro').text(datosP[3]); $('#observacionPro').text(datosP[4]);
			$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); 
			$('#checaPro').val(0); $('#notificacionPro').hide(); $('#refPro1').val(datosP[1]);
			$("#fecha_hora_creacion").text(datosP[9]);
			
			if(datosP[5]>1){$('.variosEstu').show();$('#checaPro').val(0);}else{$('.variosEstu').hide();$('#checaPro').val(1); }
			
			$('#btn_procesar_e').click(function(e) {
                var e = 0;
				if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
				else{
					if (e==0){
						e++; $('#idUserPro').val($('#id_user').val());
						var datoP = $('#form-procesar').serialize();
						$.post('laboratorio/archivos_save_ajax/procesar.php', datoP).done(function(data) {
							if(data==1){
								//guardamos quien procesa
								var datoProceso = {id_usuario:$('#id_user').val(), id_estudio:b, referencia:datosP[1],checaPro:$('#checaPro').val()}
								$.post('laboratorio/archivos_save_ajax/guardarProcesoLab.php', datoProceso).done(function(dataProceso) {

								});
								//
								$('#clickme').click(); $('#myModal1').modal('hide');
								swal({title:"",type:"success",text:"¡El proceso se realizó correctamente!",timer:2500,showConfirmButton:false});
							}else{alert(data);}
						});
					}
				}
            });
		});
			
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function(e){ });
		$('#myModal1').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
	}});
}
function cantidad_moa(id_rl, valor){
	var datos = {id_rl:id_rl, valor:valor}
	$.post('laboratorio/archivos_save_ajax/cantidad_microorg.php', datos).done(function(data){if (data == 1){ $('#clickmeMOA').click(); }});
}
function quitar_moa(id_rl){
	var datos = {id_rl:id_rl}
	$.post('laboratorio/archivos_save_ajax/quit_microorg.php', datos).done(function(data){if (data == 1){ $('#clickmeMOA').click(); }});
}
function cantidad_anti(id_rl, valor){
	var datos = {id_rl:id_rl, valor:valor}
	$.post('laboratorio/archivos_save_ajax/cantidad_antibio.php', datos).done(function(data){if (data == 1){ }});
}

function salto(opc){//alert('"#'+id+'"');
	switch(opc){
		case 2:
			$('.tripas').focus();
		break;
		case 5:
			$('.siete').focus();
		break;
		case 6:
			$('.siete').focus();
		break;
		case 15:
			$('.diezyseis').focus();
		break;
	}
}
function hemato(){
	var h = parseFloat(redondear((parseFloat($('.tripas').val())*parseFloat($('.cuatro').val()))/10,2));
	if(!parseFloat(h)){h='CÁLCULO AUTOMÁTICO';}else{} $('.donas').val(h);
}
function hgm(){
	var h = redondear((parseFloat($('.uno').val()))/(parseFloat($('.tripas').val()))*10,2);
	if(!parseFloat(h)){h='CÁLCULO AUTOMÁTICO';}else{} $('.cinco').val(h);
}
function cmhg(){
	var h = redondear((parseFloat($('.uno').val()))/(parseFloat($('.donas').val()))*100,2);
	if(!parseFloat(h)){h='CÁLCULO AUTOMÁTICO';}else{} $('.seis').val(h);
}
function neutrofilos(){
	var h = redondear(parseFloat($('.trece').val())+parseFloat($('.catorce').val()),2);
	if(!parseFloat(h)){h='CÁLCULO AUTOMÁTICO';}else{} $('.quince').val(h);
}
function sumatoria(){
	var nueve = 0, diez = 0, once = 0, doce = 0, trece = 0, catorce = 0;
	if(!parseInt($('.nueve').val())){nueve=0;}else{nueve=$('.nueve').val();} if(!parseInt($('.diez').val())){diez=0;}else{diez=$('.diez').val();}
	if(!parseInt($('.once').val())){once=0;}else{once=$('.once').val();} if(!parseInt($('.doce').val())){doce=0;}else{doce=$('.doce').val();}
	if(!parseInt($('.trece').val())){trece=0;}else{trece=$('.trece').val();}
	if(!parseInt($('.catorce').val())){catorce=0;}else{catorce=$('.catorce').val();}
	
	var h = parseInt(nueve)+parseInt(diez)+parseInt(once)+parseInt(doce)+parseInt(trece)+parseInt(catorce);
	if(h>0 & h<100){$('#sumatoria').addClass('text-warning');}else if(h>100){$('#sumatoria').addClass('text-danger');}
	else{$('#sumatoria').addClass('text-success');}
	$('#sumatoria').text(h);
}

function realizar(a,b,n,id_s){//a es el id del paciente y b es el id del estudio en venta de conceptos
	$("#myModal3").load('laboratorio/htmls/capturar.php', function(response, status, xhr){ if(status == "success"){ 
		$('#idPacientePro').val(a); $('#idEstudioPro').val(b);
		
		var datoP = {idP:a, idE:b}
		$.post('laboratorio/archivos_save_ajax/datosCapturar.php', datoP).done(function(data){
			var datosP = data.split('*}'); $('#name_area').val(datosP[36]);
			$('#pacientePro').text(datosP[0]); $('#ordenPro').text(datosP[1]); /* $('#observacionPro').text(datosP[4]); */
			$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); //alert(datosP[37]);
			//obtenemos fecha y hora del estudio y su nota de toma de muestra
			var datosFechaToma = {idE:b}
			$.post('laboratorio/archivos_save_ajax/datos_fecha_toma.php', datosFechaToma).done(function(dataFT){
				var datosFT = dataFT.split('*}');
				$("#fecha_hora").text(datosFT[0])
				$("#observacionPro").text(datosFT[1]);
			});
			
			//Checamos si no tiene ninguna base el estudio poner formato libre
			if(datosP[37]>0){
				if(datosP[36]!='BACTERIOLOGIA'){
				//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
				switch(n){
					case 'BIOMETRIA HEMATICA':
						$("#misResultados").load('laboratorio/files-serverside/capturarResultadosBH.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'EXAMEN GENERAL DE ORINA':
						$("#misResultados").load('laboratorio/files-serverside/capturarResultadosEGO.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROLOGICO':
						$("#misResultados").load('laboratorio/files-serverside/capturarResultadosCoprologico.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO UNICO':
						$("#misResultados").load('laboratorio/files-serverside/capturarResultadosCoproparasitoscopio1.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO (2M)':
						$("#misResultados").load('laboratorio/files-serverside/capturarResultadosCoproparasitoscopio2.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO SERIADO':
						$("#misResultados").load('laboratorio/files-serverside/capturarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPIO (3)':
						$("#misResultados").load('laboratorio/files-serverside/capturarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					default:
						$("#misResultados").load('laboratorio/files-serverside/capturarResultados.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
				}}
				else{
					$("#misResultados").load('laboratorio/files-serverside/capturarResultadosBacter.php?idE='+b,function(response,status,xhr){if(status == "success") {
						$('#s_micro_a').load('laboratorio/genera/microorganismos.php?idE='+b,function(response,status,xhr){if(status == "success"){
							$('#btn-addmoa').click(function(e) {
								if($('#s_micro_a').val()!=''){
									var datos = {idE:b, idU:$('#id_user').val(), id_b:$('#s_micro_a').val()}
									$.post('laboratorio/archivos_save_ajax/put_microorg.php', datos).done(function(data){if (data == 1){
										$('#clickmeMOA').click(); $('#s_micro_a').val('');
									}});
								} //agregar_moa($('#id_user').val(),b,$('#s_micro_a').val());
							});
						}});
						//var tamMA = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-130; 
						var oTableMA = $('#datatableMOA').DataTable({
							serverSide: true, "sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
							"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true} ],
							"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
							deferRender: true, select: false, "processing": false, 
							"sAjaxSource": "laboratorio/datatable-serverside/microorganismos.php",
							"fnServerParams": function (aoData, fnCallback) { 
								var id_vc = b, acceso = $('#acc_user').val(), idU = $('#id_user').val();
								aoData.push(  {"name": "id_vc", "value": id_vc } ); aoData.push(  {"name": "acceso", "value": acceso } );
								aoData.push(  {"name": "idU", "value": idU } );
							},
							"oLanguage": {
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN MICROORGANISMOS AISLADOS", 
								"sInfo": "MICROORGANISMO FILTRADOS: _END_",
								"sInfoEmpty": "NINGÚN MICROORGANISMO FILTRADO.", "sInfoFiltered": " TOTAL DE MICROORGANISMO: _MAX_", "sSearch": "",
								"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", 
								"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
							},"iDisplayLength": 500, paging: false,
						});
						$('#clickmeMOA').click(function(e) { oTableMA.draw(); }); window.setTimeout(function(){$('#clickmeMOA').click();},500);
					} });
				}
			}else{//El estudio no tiene bases, poner formato de captura libre
				if(datosP[36]!='BACTERIOLOGIA'){
					$('#misResultados').html('<input style="resize:none; text-align:left" name="notaLibre" id="notaLibre" type="text" value="" class="jqte-test">');
					window.setTimeout(function(){
						tinymce.init({
							selector:'#notaLibre',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
							plugins: 
								"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss", table_default_styles: { width: '100%' },
							relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
							toolbar: 
								"undo redo | insert_ | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
							insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
							paste_data_images: true, paste_as_text: true, browser_spellcheck: true,
							setup: function (editor) {
								editor.addButton( 'mybuttonVP', {
									text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
									onclick:function(){
										var res = tinyMCE.get("notaLibre").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
										$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
										$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
									}
								});
							}
						});
						///////////
						var datosT = {idP:a, idU:$('#id_user').val(), id_vc:b}
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
							var et_logoe_x = datosTe[44], et_logoee_x = datosTe[45], et_logogm_x = datosTe[46], et_nombre_a_sucu_x = datosTe[47];
							var et_numero_est_ov_x = datosTe[48], et_total_cntos_ov_x = datosTe[49], et_muestra_x = datosTe[50], et_metodo_x = datosTe[51];

							var dato = { idVC:b, idP:a, idU:$('#id_user').val() }
							$.post('laboratorio/files-serverside/datosCaptura_fm.php',dato).done(function(datas){ var datos = datas.split('*}');
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
								data = data.replace(/{et_nombre_a_establecimiento}/gi, et_nombre_a_sucu_x);
								data = data.replace(/{et_numero_est_ov}/gi, et_numero_est_ov_x);
								data = data.replace(/{et_total_cntos_ov}/gi, et_total_cntos_ov_x);
								data = data.replace(/{et_muestra}/gi, et_muestra_x);
								data = data.replace(/{et_metodo}/gi, et_metodo_x);

								tinymce.get("notaLibre").execCommand('mceSetContent', false, data);
							});
						});
						//////////
					},400);
				}else{
					$("#misResultados").load('laboratorio/files-serverside/capturarResultadosBacter.php?idE='+b,function(response,status,xhr){if(status == "success") {
						$('#s_micro_a').load('laboratorio/genera/microorganismos.php?idE='+b,function(response,status,xhr){if(status == "success"){
							$('#btn-addmoa').click(function(e) {
								if($('#s_micro_a').val()!=''){
									var datos = {idE:b, idU:$('#id_user').val(), id_b:$('#s_micro_a').val()}
									$.post('laboratorio/archivos_save_ajax/put_microorg.php', datos).done(function(data){if (data == 1){
										$('#clickmeMOA').click(); $('#s_micro_a').val('');
									}});
								} //agregar_moa($('#id_user').val(),b,$('#s_micro_a').val());
							});
						}});
						//var tamMA = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-130; 
						var oTableMA = $('#datatableMOA').DataTable({
							serverSide: true, "sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
							"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true} ],
							"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
							deferRender: true, select: false, "processing": false, 
							"sAjaxSource": "laboratorio/datatable-serverside/microorganismos.php",
							"fnServerParams": function (aoData, fnCallback) { 
								var id_vc = b, acceso = $('#acc_user').val(), idU = $('#id_user').val();
								
								aoData.push(  {"name": "id_vc", "value": id_vc } ); aoData.push(  {"name": "acceso", "value": acceso } );
								aoData.push(  {"name": "idU", "value": idU } );
							},
							"oLanguage": {
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN MICROORGANISMOS AISLADOS", 
								"sInfo": "MICROORGANISMO FILTRADOS: _END_",
								"sInfoEmpty": "NINGÚN MICROORGANISMO FILTRADO.", "sInfoFiltered": " TOTAL DE MICROORGANISMO: _MAX_", "sSearch": "",
								"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", 
								"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
							},"iDisplayLength": 500, paging: false,
						});
						$('#clickmeMOA').click(function(e) { oTableMA.draw(); }); window.setTimeout(function(){$('#clickmeMOA').click();},500);
					} });
				}
			}
			
			$('#titulo_modal').text('CAPTURAR RESULTADOS | '+datosP[2]+' | '+datosP[1]+' | '+datosP[19]+' | '+datosP[13]);
			$('#myIDestudioT').val(b);$('#myIDpacienteT').val(a); $('#myNameEstudioT').val(n);
			
			//del pdf
			$('.mipdf').each(function(index, element) {//alert(index);
				var button = $(this), interval; var idP=b;
				new AjaxUpload(button,{
					action: 'laboratorio/takeArchivos/subirPdfPoliza.php?action=&key='+idP, name: 'image',
					onSubmit : function(file, ext){
						if(ext != 'PDF' & ext != 'pdf'){
							swal({title:"",type:"error",text:"DEBE SELECCIONAR UN ARCHIVO PDF",timer:1500,showConfirmButton:false}); return false;
						}else{swal({title:"",type:"success",text:"SUBIENDO ARCHIVO...",showConfirmButton:false});}
					},
					onComplete: function(file, response){//alert('x');
						swal.close();
						window.setTimeout(function(){swal({title:"",type:"success",text:"EL ARCHIVO SE HA CARGADO CORRECTAMENTE",timer:2000,showConfirmButton:false});},300);
						var URL='laboratorio/takeArchivos/pdf/'+idP+'.pdf';
						var datosCargar = {idE:idP, idU:$('#id_user').val()}
						$.post('laboratorio/archivos_save_ajax/cargar.php', datosCargar).done(function(data) { if (data == 1){ 
							$('#clickme').click(); $('#myModal3').modal('hide'); window.setTimeout(function(){ visualizar(b); },1000);
						}else{alert(data); } });
						window.clearInterval(interval); 
					}
				});//Fin del pdf 
			});
			
			$('#idUserPro').val($('#id_user').val());
			$('#form-procesar').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
			  } else { // everything looks good!
				e.preventDefault();
				if(datosP[37]>0 || $('#name_area').val() == 'BACTERIOLOGIA'){
					var datoP = $('#form-procesar').serialize();
					if($('#name_area').val() != 'BACTERIOLOGIA'){
						$.post('laboratorio/archivos_save_ajax/realizar.php', datoP).done(function( data ) { 
							if (data == 1){ 
								$('#clickme').click(); $('#myModal3').modal('hide');
								swal({title:"",type:"success",text:"EL PROCESO SE HA REALIZADO CORRECTAMENTE",timer:2000,showConfirmButton:false});
								window.setTimeout(function(){ interpretar(a,b,n,id_s); },1000);
							}else{alert(data);}
						});
					}else{
						//Hacemos 2 foreach para guardar las cantidades y unidades de los microorganismos
						$(".mi_cantidad").each(function(index){
							var mi_id = $(this).prop('id').split('-'), mi_id1 = mi_id[1]; var valor = $(this).val();
							var datos = {id_rl:mi_id1, valor:valor}
							$.post('laboratorio/archivos_save_ajax/cantidad_microorg.php', datos).done(function(data){if (data == 1){ }});
						});
						$(".mi_unidad").each(function(index){
							var mi_id = $(this).prop('id').split('-'), mi_id1 = mi_id[1]; var valor = $(this).val();
							var datos = {id_rl:mi_id1, valor:valor}
							$.post('laboratorio/archivos_save_ajax/unidad_microorg.php', datos).done(function(data){if (data == 1){ }});
						});
						
						$.post('laboratorio/archivos_save_ajax/realizar_bacter.php', datoP).done(function( data ) { 
							if (data == 1){ 
								$('#clickme').click(); $('#myModal3').modal('hide');
								swal({title:"",type:"success",text:"EL PROCESO SE HA REALIZADO CORRECTAMENTE",timer:2000,showConfirmButton:false});
								window.setTimeout(function(){ interpretar(a,b,n,id_s); },1000);
							}else{alert(data);}
						});
					}
				}else{
					var str = tinyMCE.get('notaLibre').getContent(); 
					var datoP = { idE:$('#idEstudioPro').val(),idU:$('#id_user').val(),notaLibre:str, idP:$('#idPacientePro').val(), notaPro:$('#notaPro').val() }
	
					$.post('laboratorio/archivos_save_ajax/realizar_notaLibre.php', datoP).done(function( data ) { 
						if (data == 1){ 
							$('#clickme').click(); $('#myModal3').modal('hide');
							swal({title:"",type:"success",text:"EL PROCESO SE HA REALIZADO CORRECTAMENTE",timer:2000,showConfirmButton:false});
							window.setTimeout(function(){ interpretar(a,b,n,id_s); },1000);
						}else{alert(data);}
					});
				}
			  }
			});
				
			$('#btn_reiniciar_e').click(function(e) {
                swal({
				  title: "REINICIAR ESTUDIO", text: "¿Estás seguro de querer reiniciar el estudio?",
				  type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
				  confirmButtonText: "Reiniciar", cancelButtonText: "Cancelar", closeOnConfirm: false
				},
				function(){
				  	var dato = {idEvc:b}
					$.post('laboratorio/archivos_save_ajax/reiniciar.php', dato).done(function( data ) { 
					if (data == 1){
						$('#clickme').click(); swal.close(); $('#myModal3').modal('hide');
						window.setTimeout(function(){swal({title:"",type:"success",text:"EL REINICIO SE REALIZÓ CORRECTAMENTE",timer:2500,showConfirmButton:false});},300);
					}else{alert(data);} });
				});
            });
			
		});
		$('#myModal3').modal('show');
		$('#myModal3').on('shown.bs.modal', function(e){ $('#form-procesar').validator(); });
		$('#myModal3').on('hidden.bs.modal', function(e){ tinymce.remove("#notaLibre"); $(".modal-content").remove(); $("#myModal3").empty(); });
	}
}); }
function interpretar(a,b,n,id_s){//a es el id del paciente y b del estudio en vc en venta de conceptos
	$("#myModal2").load('laboratorio/htmls/capturar.php', function(response, status, xhr){ if(status=="success"){
		$('#cargaPDF').hide(); $('#idPacientePro').val(a); $('#idEstudioPro').val(b); 
		$('#btn_capturar_e, #btn_reiniciar_e').remove(); $('#btn_autorizar_e').removeClass('hidden');
		
		var datoP = {idP:a, idE:b}
		$.post('laboratorio/archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
			var datosP = data.split('*}'); $('#name_area').val(datosP[36]);
			$('#titulo_modal').text('INTERPRETAR RESULTADOS | '+datosP[2]+' | '+datosP[1]+' | '+datosP[19]+' | '+datosP[13]);
			
			$('#pacientePro').text(datosP[0]); $('#ordenPro').text(datosP[1]); /* $('#observacionPro').text(datosP[4]); */
			$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]);

			//obtenemos fecha y hora del estudio y su nota de toma de muestra
			var datosFechaToma = {idE:b}
			$.post('laboratorio/archivos_save_ajax/datos_fecha_toma.php', datosFechaToma).done(function(dataFT){
				var datosFT = dataFT.split('*}');
				$("#fecha_hora").text(datosFT[0])
				$("#observacionPro").text(datosFT[1]);
			});
			
			//Checamos si no tiene ninguna base el estudio poner formato libre
			//alert(datosP[37]);
			if(datosP[37]>0){
				if(datosP[36]!='BACTERIOLOGIA'){
					//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
					switch(n){
						case 'BIOMETRIA HEMATICA':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosBH.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
						break;
						case 'EXAMEN GENERAL DE ORINA':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosEGO.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
						break;
						case 'COPROLOGICO':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoprologico.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
						break;
						case 'COPROPARASITOSCOPICO UNICO':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio1.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
						break;
						case 'COPROPARASITOSCOPICO (2M)':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio2.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
						break;
						case 'COPROPARASITOSCOPICO SERIADO':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
						break;
						case 'COPROPARASITOSCOPIO (3)':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
						break;
						default:
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultados.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					}
				}else{
					$("#misResultados").load('laboratorio/files-serverside/capturarResultadosBacter.php?idE='+b,function(response,status,xhr){if(status == "success") {
						$('#s_micro_a').load('laboratorio/genera/microorganismos.php?idE='+b,function(response,status,xhr){if(status == "success"){
							$('#btn-addmoa').click(function(e) {
								if($('#s_micro_a').val()!=''){
									var datos = {idE:b, idU:$('#id_user').val(), id_b:$('#s_micro_a').val()}
									$.post('laboratorio/archivos_save_ajax/put_microorg.php', datos).done(function(data){if (data == 1){
										$('#clickmeMOA').click(); $('#s_micro_a').val('');
									}});
								} //agregar_moa($('#id_user').val(),b,$('#s_micro_a').val());
							});
						}});
						
						//var tamMA = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-130; 
						var oTableMA = $('#datatableMOA').DataTable({
							serverSide: true, "sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
							"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true} ],
							"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
							deferRender: true, select: false, "processing": false, 
							"sAjaxSource": "laboratorio/datatable-serverside/microorganismos.php",
							"fnServerParams": function (aoData, fnCallback) { 
								var id_vc = b, acceso = $('#acc_user').val(), idU = $('#id_user').val();
								
								aoData.push(  {"name": "id_vc", "value": id_vc } ); aoData.push(  {"name": "acceso", "value": acceso } );
								aoData.push(  {"name": "idU", "value": idU } );
							},
							"oLanguage": {
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN MICROORGANISMOS AISLADOS", 
								"sInfo": "MICROORGANISMO FILTRADOS: _END_",
								"sInfoEmpty": "NINGÚN MICROORGANISMO FILTRADO.", "sInfoFiltered": " TOTAL DE MICROORGANISMO: _MAX_", "sSearch": "",
								"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", 
								"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
							},"iDisplayLength": 500, paging: false,
						});
						$('#clickmeMOA').click(function(e) { oTableMA.draw(); }); window.setTimeout(function(){$('#clickmeMOA').click();},500);
					
					} });
				}
			}else{//El estudio no tiene bases, poner formato de captura libre
				if(datosP[36]!='BACTERIOLOGIA'){
					$('#misResultados').html('<input style="resize:none; text-align:left" name="notaLibre" id="notaLibre" type="text" value="" class="jqte-test">');
					window.setTimeout(function(){ $('#notaLibre').val(datosP[38]);
						tinymce.init({
							selector:'#notaLibre',resize:false,height:$('#referencia').height()*0.45,theme: "modern",
							plugins: 
								"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss", table_default_styles: { width: '100%' },
							relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
							toolbar: 
								"undo redo | insert_ | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
							insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
							paste_data_images: true, paste_as_text: true, browser_spellcheck: true, 
							setup: function (editor) {
								editor.addButton( 'mybuttonVP', {
									text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
									onclick:function(){
										var res = tinyMCE.get("notaLibre").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
										$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
										$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
									}
								});
							}
						});
						
					},400);
				}else{
					$("#misResultados").load('laboratorio/files-serverside/capturarResultadosBacter.php?idE='+b,function(response,status,xhr){if(status == "success") {
						$('#s_micro_a').load('laboratorio/genera/microorganismos.php?idE='+b,function(response,status,xhr){if(status == "success"){
							$('#btn-addmoa').click(function(e) {
								if($('#s_micro_a').val()!=''){
									var datos = {idE:b, idU:$('#id_user').val(), id_b:$('#s_micro_a').val()}
									$.post('laboratorio/archivos_save_ajax/put_microorg.php', datos).done(function(data){if (data == 1){
										$('#clickmeMOA').click(); $('#s_micro_a').val('');
									}});
								} //agregar_moa($('#id_user').val(),b,$('#s_micro_a').val());
							});
						}});
						
						//var tamMA = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-130; 
						var oTableMA = $('#datatableMOA').DataTable({
							serverSide: true, "sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
							"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true} ],
							"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
							deferRender: true, select: false, "processing": false, 
							"sAjaxSource": "laboratorio/datatable-serverside/microorganismos.php",
							"fnServerParams": function (aoData, fnCallback) { 
								var id_vc = b, acceso = $('#acc_user').val(), idU = $('#id_user').val();
								
								aoData.push(  {"name": "id_vc", "value": id_vc } ); aoData.push(  {"name": "acceso", "value": acceso } );
								aoData.push(  {"name": "idU", "value": idU } );
							},
							"oLanguage": {
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN MICROORGANISMOS AISLADOS", 
								"sInfo": "MICROORGANISMO FILTRADOS: _END_",
								"sInfoEmpty": "NINGÚN MICROORGANISMO FILTRADO.", "sInfoFiltered": " TOTAL DE MICROORGANISMO: _MAX_", "sSearch": "",
								"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", 
								"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
							},"iDisplayLength": 500, paging: false,
						});
						$('#clickmeMOA').click(function(e) { oTableMA.draw(); }); window.setTimeout(function(){$('#clickmeMOA').click();},500);
					
					} });
				}
			}
			
			$('#myIDestudioT').val(b); $('#myIDpacienteT').val(a); $('#myNameEstudioT').val(n);
			
			$('#idUserPro').val($('#id_user').val());
			$('#form-procesar').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
			  } else { // everything looks good!
				e.preventDefault(); 
				if(datosP[37]>0 || $('#name_area').val() == 'BACTERIOLOGIA'){
					var datoP = $('#form-procesar').serialize();
					if($('#name_area').val() != 'BACTERIOLOGIA'){
						$.post('laboratorio/archivos_save_ajax/autorizado.php', datoP).done(function( data ) { 
							if (data == 1){ 
								guardarAutorizado(b,$('#id_user').val());
								$('#clickme').click(); $('#myModal2').modal('hide');
								swal({
								  title: "", text: "EL ESTUDIO SE HA AUTORIZADO CORRECTAMENTE",
								  type: "success", showCancelButton: true, confirmButtonColor: "#DD6B55",
								  confirmButtonText: "Imprimir", cancelButtonText: "Cerrar", closeOnConfirm: false
								},
								function(){ swal.close(); window.setTimeout(function(){preImprimir(a,b,n,id_s);},300); });
							}else{alert(data);}
						});
					}else{
						//Hacemos 2 foreach para guardar las cantidades y unidades de los microorganismos
						$(".mi_cantidad").each(function(index){
							var mi_id = $(this).prop('id').split('-'), mi_id1 = mi_id[1]; var valor = $(this).val();
							var datos = {id_rl:mi_id1, valor:valor}
							$.post('laboratorio/archivos_save_ajax/cantidad_microorg.php', datos).done(function(data){if (data == 1){ }});
						});
						$(".mi_unidad").each(function(index){
							var mi_id = $(this).prop('id').split('-'), mi_id1 = mi_id[1]; var valor = $(this).val();
							var datos = {id_rl:mi_id1, valor:valor}
							$.post('laboratorio/archivos_save_ajax/unidad_microorg.php', datos).done(function(data){if (data == 1){ }});
						});
						
						$.post('laboratorio/archivos_save_ajax/autorizado_bacter.php', datoP).done(function( data ) { 
							if (data == 1){ 
								guardarAutorizado(b,$('#id_user').val());
								$('#clickme').click(); $('#myModal2').modal('hide');
								swal({
								  title: "", text: "EL ESTUDIO SE HA AUTORIZADO CORRECTAMENTE",
								  type: "success", showCancelButton: true, confirmButtonColor: "#DD6B55",
								  confirmButtonText: "Imprimir", cancelButtonText: "Cerrar", closeOnConfirm: false
								},
								function(){ swal.close(); window.setTimeout(function(){preImprimir(a,b,n,id_s);},300); });
							}else{alert(data);}
						});
					}
				}else{
					//var str = tinyMCE.get('notaMedicaC').getContent(); 
					//var res = str.replace('src="usuarios/firmas/','src="../../usuarios/firmas/');
					//var res = res.replace(/src="img_cslta/g,'src="../../../consultas/img_cslta');
					//var res = res.replace(/[?]\d{14}/g,'');
					var str = tinyMCE.get('notaLibre').getContent(); //alert(str);
					//var res = str.replace(/[?]\d{14}/g,'');//alert(res);
					//var res = str.replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); alert(res);
					var res = str.replace(/<p/g, "<span"); res = res.replace(/<\/p>/g, "</span><br>"); //alert(res);
					var datoP = { 
						idE:$('#idEstudioPro').val(),idU:$('#id_user').val(), notaLibre:res, idP:$('#idPacientePro').val(), notaPro:$('#notaPro').val()
					}
	
					$.post('laboratorio/archivos_save_ajax/autorizado_notaLibre.php', datoP).done(function( data ) { 
						if (data == 1){ 
							guardarAutorizado(b,$('#id_user').val());
							$('#clickme').click(); $('#myModal2').modal('hide');
							swal({
							  title: "", text: "EL ESTUDIO SE HA AUTORIZADO CORRECTAMENTE",
							  type: "success", showCancelButton: true, confirmButtonColor: "#DD6B55",
							  confirmButtonText: "Imprimir", cancelButtonText: "Cerrar", closeOnConfirm: false
							},
							function(){ swal.close(); preImprimir(a,b,n,id_s); });
						}else{alert(data);}
					});
				}
			  }
			});
		});

		$('#myModal2').modal('show');
		$('#myModal2').on('shown.bs.modal', function(e){ $('#form-procesar').validator(); });
		$('#myModal2').on('hidden.bs.modal', function(e){ tinymce.remove("#notaLibre"); $(".modal-content").remove(); $("#myModal2").empty(); });
	} });
}

function guardarAutorizado(id_estudio, id_usuario){
	var datosAutorizar = { id_estudio:id_estudio, id_usuario:id_usuario }

	$.post('laboratorio/archivos_save_ajax/guardarAutorizadoLab.php', datosAutorizar).done(function(dataAutorizar) {

	});

}

function autorizado(a,b,n,id_s){//alert(id_s);//a es el id del paciente y b del estudio en vc en venta de conceptos
	$("#myModal1").load('laboratorio/htmls/capturar.php', function(response, status, xhr){ if(status == "success"){
		$('#cargaPDF').hide(); $('#idPacientePro').val(a); $('#idEstudioPro').val(b); $('#tr_sucursalex').removeClass('hidden');
		$('#btn_capturar_e, #btn_reiniciar_e').remove(); $('#btn_imprimir_e').removeClass('hidden'); $('#tr_status_a_i').removeClass('hidden');

		//evitamos que el usuario pueda escribir sobre los inputs de los resultaados
		window.setTimeout(function(){
			$("#p_contenido :input").on('keydown', function(e){
				e.preventDefault();
			});
			if($('#acc_user').val()==14){
				$('#tr_status_a_i').addClass('hidden');
			}
		},600);
		
		var datoP = {idP:a, idE:b}
		$.post('laboratorio/archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
			var datosP = data.split('*}'); $('#name_area').val(datosP[36]);
			$('#pacientePro').text(datosP[0]); $('#ordenPro').text(datosP[1]); $('#observacionPro').text(datosP[4]);
			$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]);
			$("#sucursal_ocu").load('usuarios/files-serverside/genera_sucursales.php',function(response,status,xhr){if(status=="success"){
				$("#sucursal_ocu, #sucursal_ocu1").val(id_s);
			}});
			$('#sucursal_ocu').change(function(e) { $('#sucursal_ocu1').val($(this).val()); });
			
			//obtenemos fecha y hora del estudio y su nota de toma de muestra
			var datosFechaToma = {idE:b}
			$.post('laboratorio/archivos_save_ajax/datos_fecha_toma.php', datosFechaToma).done(function(dataFT){
				var datosFT = dataFT.split('*}');
				$("#fecha_hora").text(datosFT[0])
				$("#observacionPro").text(datosFT[1]);
				$('#status_a_i').val(datosFT[2]);
				$('#estatus_label').html('ESTATUS A/I:<br>'+datosFT[3]+'<br>'+datosFT[4]);
			});
			
			//Checamos si no tiene ninguna base el estudio poner formato libre
			//alert(datosP[37]);
			if(datosP[37]>0 || datosP[36]=='BACTERIOLOGIA'){
				if(datosP[36]!='BACTERIOLOGIA'){
					//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
					//comentamos el codigo que deshabilita los inputs de resultados debido a que interferia con la clase bg-danger y se mostraba el input en gris
					switch(n){
						case 'BIOMETRIA HEMATICA':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosBH.php?idE='+b, function(response,status,xhr){/* if ( status == "success" ) {$("#p_contenido :input").attr("disabled", true);} */ });
						break;
						case 'EXAMEN GENERAL DE ORINA':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosEGO.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$("#p_contenido :input").attr("disabled", true);} });
						break;
						case 'COPROLOGICO':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoprologico.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$("#p_contenido select").attr("disabled", true);} });
						break;
						case 'COPROPARASITOSCOPICO UNICO':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio1.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$("#p_contenido select").attr("disabled", true);} });
						break;
						case 'COPROPARASITOSCOPICO (2M)':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio2.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$("#p_contenido select").attr("disabled", true);} });
						break;
						case 'COPROPARASITOSCOPICO SERIADO':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$("#p_contenido select").attr("disabled", true);} });
						break;
						case 'COPROPARASITOSCOPIO (3)':
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$("#p_contenido select").attr("disabled", true);} });
						break;
						default:
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultados.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$("#p_contenido select").attr("disabled", true);} });
					}
				}else{
					$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosBacter.php?idE='+b,function(response,status,xhr){if(status == "success") {
						$('#s_micro_a').load('laboratorio/genera/microorganismos.php?idE='+b,function(response,status,xhr){if(status == "success"){
							$('#btn-addmoa').click(function(e){ });
						}});
						
						//var tamMA = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-130; 
						var oTableMA = $('#datatableMOA').DataTable({
							serverSide: true, "sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
							"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true } ],
							"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
							deferRender: true, select: false, "processing": false, 
							"sAjaxSource": "laboratorio/datatable-serverside/microorganismos_interpretar.php",
							"fnServerParams": function (aoData, fnCallback) { 
								var id_vc = b, acceso = $('#acc_user').val(), idU = $('#id_user').val();
								
								aoData.push(  {"name": "id_vc", "value": id_vc } ); aoData.push(  {"name": "acceso", "value": acceso } );
								aoData.push(  {"name": "idU", "value": idU } );
							},
							"oLanguage": {
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN MICROORGANISMOS AISLADOS", 
								"sInfo": "MICROORGANISMO FILTRADOS: _END_",
								"sInfoEmpty": "NINGÚN MICROORGANISMO FILTRADO.", "sInfoFiltered": " TOTAL DE MICROORGANISMO: _MAX_", "sSearch": "",
								"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", 
								"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
							},"iDisplayLength": 500, paging: false,
						});
						$('#clickmeMOA').click(function(e) { oTableMA.draw(); }); window.setTimeout(function(){$('#clickmeMOA').click();},500);
					
					} });
				}
			}else{
				if(datosP[36]!='BACTERIOLOGIA'){
					$('#misResultados').html('<input style="resize:none; text-align:left" name="notaLibre" id="notaLibre" type="text" value="" class="jqte-test">');
					window.setTimeout(function(){
						$('#notaLibre').val(datosP[38]);
						tinymce.init({ 
							selector:'#notaLibre', readonly : true, resize:false,height:$('#referencia').height()*0.4, theme: "modern", menubar: false, toolbar: false
						});
					},400);
				}else{
					$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosBacter.php?idE='+b,function(response,status,xhr){if(status == "success") {
						$('#s_micro_a').load('laboratorio/genera/microorganismos.php?idE='+b,function(response,status,xhr){if(status == "success"){
							$('#btn-addmoa').click(function(e){ });
						}});
						
						//var tamMA = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-130; 
						var oTableMA = $('#datatableMOA').DataTable({
							serverSide: true, "sScrollY": 100, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
							"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
							"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true } ],
							"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
							deferRender: true, select: false, "processing": false, 
							"sAjaxSource": "laboratorio/datatable-serverside/microorganismos_interpretar.php",
							"fnServerParams": function (aoData, fnCallback) { 
								var id_vc = b, acceso = $('#acc_user').val(), idU = $('#id_user').val();
								
								aoData.push(  {"name": "id_vc", "value": id_vc } ); aoData.push(  {"name": "acceso", "value": acceso } );
								aoData.push(  {"name": "idU", "value": idU } );
							},
							"oLanguage": {
								"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN MICROORGANISMOS AISLADOS", 
								"sInfo": "MICROORGANISMO FILTRADOS: _END_",
								"sInfoEmpty": "NINGÚN MICROORGANISMO FILTRADO.", "sInfoFiltered": " TOTAL DE MICROORGANISMO: _MAX_", "sSearch": "",
								"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", 
								"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
							},"iDisplayLength": 500, paging: false,
						});
						$('#clickmeMOA').click(function(e) { oTableMA.draw(); }); window.setTimeout(function(){$('#clickmeMOA').click();},500);
					
					} });
				}
			}
			
			$('#titulo_modal').text('RESULTADOS | '+datosP[2]+' | '+datosP[1]+' | '+datosP[19]+' | '+datosP[13]);
			$('#myIDestudioT').val(b);$('#myIDpacienteT').val(a); $('#myNameEstudioT').val(n);
			
			$('#btn_imprimir_e').click(function(e) {
                $('#myModal1').modal('hide'); window.setTimeout(function(){preImprimir(a,b,n,$("#sucursal_ocu1").val());},1000);
            });
		});

		$('#status_a_i').on('change', function() {
			var valor_a_i = $(this).val();
			var datoAI = {valor_a_i:valor_a_i, id_e:b, usuario:$('#id_user').val()}
			$.post('laboratorio/archivos_save_ajax/actualizar_activo_inactivo.php', datoAI).done(function( data ) {
				
			})
		});
		
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function(e){ $('#form-procesar').validator(); });
		$('#myModal1').on('hidden.bs.modal', function(e){ tinymce.remove("#notaLibre"); $(".modal-content").remove(); $("#myModal1").empty(); });
	}
}); }

function preImprimir(a,b,n,id_s){//alert('id del paciente: '+a+'id vc: '+b+'nombre del estudio: '+n+'id de sucursal: '+id_s);//a =id paciente, b id estudio en vc
	//na = n; //n = '"'+n+'"';
	var datoP = {idE:b,id_s:id_s}
	$.post('laboratorio/archivos_save_ajax/datosPrintMem.php', datoP).done(function(data){
		if(data!=1){ imprimir(a,b,n,0,id_s); }
		else{
			swal({
			  title: "IMPRIMIR EL ESTUDIO",
			  text: '<table class="table table-condensed"><tr><td align="center" colspan="2">Selecciona el tipo de impresión</td></tr><tr><td align="center"><button id="btn_imp_cm" type="button" class="btn btn-info">Con membrete</button></td><td align="center"><button id="btn_imp_sm" type="button" class="btn btn-info">Sin membrete</button></td></tr></table>',
			  html: true, showCancelButton: true, showConfirmButton: false, cancelButtonText: "Cerrar"
			});
			$('#btn_imp_cm').click(function(e) { imprimir(a,b,n,1,id_s); swal.close(); });
			$('#btn_imp_sm').click(function(e) { imprimir(a,b,n,0,id_s); swal.close(); });
		}
	});
}

function imprimir(a,b,n,x,id_s){//a =id paciente, b id estudio en vc, x es si se imprimen los encabe
	$('#idPacientePro').val(a); $('#idEstudioPro').val(b);
	var datoP = {idP:a, idE:b, idU:$('#id_user').val(), _:$.now()}
	$.post('laboratorio/archivos_save_ajax/datosCapturar.php', datoP).done(function(data){
		var datosP = data.split('*}'); $('#name_area').val(datosP[36]); //alert(datosP[36]);
		
		$('#pacientePro,.myPacienteP').text(datosP[0]);$('#ordenPro, .myReferenciaP').text(datosP[1]); 
		$('#observacionPro').text(datosP[4]);
		$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); 
		$('.myNotaToma').html('<em>OBSERVACIONES</em>: '+datosP[8]);
		$('.myEstudioP').text(datosP[2]); $('.myFnacP').text(datosP[9]); $('.mySexoP').text(datosP[10]);
		$('.myEdadP').text('EDAD: '+datosP[11]+' - '); $('.myFechaP').text(datosP[12]); 
		$('.myMedicoP').text(datosP[13]); $('.dr').text(datosP[18]); $('.myUnidadMedicaP').text(datosP[19]);
		$('.nombreDR').text(datosP[14]); $('.cedula').text(datosP[15]); $('.myNoEstudio').text(datosP[20]);
		
		var meto = datosP[17].split(','); 
		if(meto.length>5){ $('.myMetodoP').text('DIVERSOS'); }else{ $('.myMetodoP').text(datosP[17]); }
		
		var mues = datosP[16].split(','); 
		if(mues.length>5){ $('.myMuestraP').text('DIVERSAS'); }else{ $('.myMuestraP').text(datosP[16]+'. '); }
		
		var miExtFi = datosP[26];
	
		if(x==1){//Para el membrete encabezado
			xME='../../../sucursales/membretes/files/'+datosP[28]+'.'+datosP[29];
			xMP='../../../sucursales/membretes/files/'+datosP[31]+'.'+datosP[32];
			var membretDME='<img src='+xME+' width="770">', membretDMP = '<img src='+xMP+' width="760">'; 
		}else{var membretDME='', membretDMP=''; }//alert(membretDME);

		if(datosP[24]==1){ var datosG = {aleatorio:datosP[25]} //Para la firma
			$.post('usuarios/files-serverside/datosFirma.php',datosG).done(function( data ){ 
				var t="<img src='../usuarios/firmas/files/"+data+"."+miExtFi+"' height='90%'>"; $('#firmaDR').html(t); //alert(t);
			});
		}else{var t='';}//alert(membretDME);

		//obtenemor firma de quien capturo o proceso
		var miExtFi2 = datosP[40];
		if(datosP[38]==1){ var datosG = {aleatorio:datosP[39]} //Para la firma
			$.post('usuarios/files-serverside/datosFirma.php',datosG).done(function( data2 ){ 
				var t="<img src='../usuarios/firmas/files/"+data2+"."+miExtFi2+"' height='90%'>"; $('#firmaDR2').html(t); //alert(t);
			});
		}else{var t='';}
		//
		
		//Checamos si no tiene ninguna base el estudio poner formato libre
		//alert(datosP[37]);
		if(datosP[37]>0 || datosP[36]=='BACTERIOLOGIA'){
			if(datosP[36]!='BACTERIOLOGIA'){
				//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
				switch(n){
					case "BIOMETRIA HEMATICA":
						$.post('laboratorio/files-serverside/imprimirResultadosBH.php?idE='+b+'&idU='+$('#id_user').val()+'&firmaU='+t, {_:$.now()} ).done(function(data){ 
							var pus = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, _:$.now(), id_vc:b}
							
							$("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pus,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
					break;
					case "EXAMEN GENERAL DE ORINA":
						$.post('laboratorio/files-serverside/imprimirResultadosEGO.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){
							var pus = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
							
							$("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pus,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
					break;
					case 'COPROLOGICO':
						$.post('laboratorio/files-serverside/imprimirResultadosCoprologico.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){ 
							var pus = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
							
							$("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pus,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
					break;
					case 'COPROPARASITOSCOPICO UNICO':
						$.post('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio1.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){ 
							var pus = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
							
							$("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pus,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
					break;
					case 'COPROPARASITOSCOPICO (2M)':				
						$.post('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio2.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){ 
							var pus = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
							
							$("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pus,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
					break;
					case 'COPROPARASITOSCOPICO SERIADO':
						$.post('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){ 
							var pus = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
							
							$("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pus,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
					break;
					case 'COPROPARASITOSCOPIO (3)':
						$.post('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){ 
							var pus = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
							
							 $("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pus,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
					break;
					default:
						$.post('laboratorio/files-serverside/imprimirResultadosPDF.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){
						   var pusha = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
						   $("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
						   window.setTimeout(function(){
							$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pusha,function(response,status,xhr){if(status=="success"){
								$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
								$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
							} });
						   },100);
						});
				}
			}else{
				$.post('laboratorio/files-serverside/imprimirResultadosBacter.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){
				   var pusha = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
				   $("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
				   window.setTimeout(function(){
					$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pusha,function(response,status,xhr){if(status=="success"){
						$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
						$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
					} });
				   },100);
				});		
			}
		}else{
			$.post('laboratorio/files-serverside/imprimirResultadosPDFlibre.php?idE='+b+'&idU='+$('#id_user').val()).done(function(data){
			   var pusha = {encL:escape(membretDME),pieL:escape(membretDMP),iduL:escape($('#id_user').val()),firmaL:t,id_s:id_s, id_vc:b}
			   $("#myModalx").html('<div class="modal-dialog modal-lg" role="document"><div class="modal-content animated flipInY"><div class="modal-header"> <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h4 class="modal-title"><strong><span id="titulo_modal"></span> </strong></h4> </div> <div class="modal-body"> <div id="body_modal4"></div> </div><div class="modal-footer"> <div class="form-group"> <div class="col-sm-offset-0 col-sm-12"> <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Salir</button> </div> </div> </div> </div></div>');
			   window.setTimeout(function(){
				$("#body_modal4").load('laboratorio/htmls/frame_pdf.php',pusha,function(response,status,xhr){if(status=="success"){
					$('#titulo_modal').text('IMPRIMIR - '+datosP[2]+'- '+datosP[1]); 
					$("#body_modal4").height($("#myModalx").height()-180); $('#myModalx').modal('show');		
				} });
			   },100);
			});
		}
		
		$('#myModalx').on('shown.bs.modal', function(e){ });
		$('#myModalx').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModalx").empty(); });	
	});
}//Fin imprimir
function visualizar(x){ 
	var x1=x;
	if(x.length <= 10){ //el numero 10 es tentativo, si la longitud de x(id_vc) es larga, lo toma como un enlace externo.
		x='laboratorio/takeArchivos/pdf/'+x+'.pdf'; 
	} 
	$("#myModalx").load('laboratorio/htmls/visualizar_pdf.php', function( response, status, xhr ) { if ( status == "success" ) {
		$('#registroModalLabel').text('ARCHIVO PDF DEL RESULTADO');
		$('a.media').media({width:$("#myModalx").width()*0.9, height:$("#myModalx").height()*0.75, src:x});
		
		$('#btn_eliminar_pdf').click(function(e) {
            swal({
			  title: "¿ELIMINAR PDF?", text: "Esta opción no puede deshacerse", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Eliminar", cancelButtonText: "Salir", closeOnConfirm: false
			},
			function(){
				var idX = {idPDF: x1+'.pdf', idU:$('#id_user').val(), idE:x1}
				$.post('laboratorio/takeArchivos/eliminarArchivo.php',idX).done(function( data ) {
					if(data==1){ $('#clickme').click(); $('#myModalx').modal('hide');
						swal({ title: "", type: "success", text: "El archivo ha sido eliminado.", timer: 2000, showConfirmButton: false });
					}
				});
			});
        });
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function (e){ });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
		
		/*$('#dialog-visualizador').dialog({
			title: 'ARCHIVO PDF DEL RESULTADO', modal: true, autoOpen: true,
			closeText: '', width: 800, height: 600, closeOnEscape: true, dialogClass: '',
			buttons: { 
				"ELIMINAR": function() {
					$('#miPregunta').text('¿Desea eliminar este archivo PDF?'); 
					$('#dialog-pregunta').dialog({
						title:'ELIMINAR PDF', closeOnEscape: false, dialogClass: "no-close",
						buttons: {
							"Eliminar": function() { }, Cancelar: function() { $('#dialog-pregunta').dialog( "close" ); }
						}
					});
					$('#dialog-pregunta').dialog('open');
				}, 
				"CERRAR": function() { $(this).dialog('close'); }
		  }, 
		  open:function( event, ui ){}, 
		  close:function( event, ui ){ $("#dialog-visualizador").empty();}
		});*/
	} });
}
</script>
