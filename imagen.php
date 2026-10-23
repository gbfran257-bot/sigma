<?php
	session_start();
	//include_once 'recursos/session.php';
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'recursos/datauser.php';//echo session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
    <meta name="author" content="ING JESUS DIAZ CONTRERAS">
    
    <title>SISTEMA - IMAGENOLOGÍA</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
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
    <script src="imagen/takeArchivos/ajaxupload.js" type="text/javascript"></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script> 
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    <script src="jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
	<script src="jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>
    
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
<input id="t_id_s" type="hidden" value=""> <input id="t_clave_s" type="hidden" value="">
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
<input id="multisu_s" type="hidden" value="<?php echo $multisucu_u; ?>">
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">PACIENTE</th>
    <th style="vertical-align:middle;">REFERENCIA</th>
    <th style="vertical-align:middle;">ESTUDIO</th>
    <th style="vertical-align:middle;">ESTATUS</th>
    <th style="vertical-align:middle;">ACCESO</th>
    <th style="vertical-align:middle;">EDITAR</th>
    <th style="vertical-align:middle; white-space:nowrap;">ID-PACS</th>
    <th style="vertical-align:middle;">ÁREA</th>
    <th style="vertical-align:middle;">SUCURSAL</th>
    <th style="vertical-align:middle;">FOTOS</th>
	<th style="vertical-align:middle;" style="max-width:10px;">MEDICO REFIERE</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-PACIENTE-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-REFERENCIA-" style="max-width:110px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTUDIO-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTATUS-" style="max-width:110px;"/></th>
            <th></th>
            <th></th>
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ÁREA-" style="width:80%;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-SUCURSAL-" style="width:90%;"/></th>
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
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>IMAGEN</li><li class="active"><strong>ESTUDIOS DE IMAGENOLOGÍA</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-145-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>B1<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "imagen/datatable-serverside/estudios.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val();
			var de = $('#fechaDe').val()+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
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
		},"iDisplayLength": 500000, paging: false,
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
	
	$('.infoPrincipal').append('<div id="divRangoFechas" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">De &nbsp;</td> <td width="1%"> <input name="fechaDe" class="fechas form-control input-sm" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA" type="text" class="fechas form-control input-sm" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly> </td> <td id="rangosFechas">&nbsp; <input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');
	
	$('#radio1').click(function(e){
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>');$('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#radio2').click(function(e){
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#fechaDe').on('changeDate', function(e) { oTableP.draw(); });
	$("#fechaA").on('changeDate', function(e) { oTableP.draw(); });
});

function procesar(a,b){//a es el id del paciente y b es el id del estudio en venta de conceptos
	$("#myModal").load('imagen/htmls/procesar.php', function( response, status, xhr ) { if ( status == "success" ) {
		//$('.cheki').checkboxradio(); 
		$('#idUserPro').val($('#id_user').val());
		//para los checkbox de la ventana de proceso
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
		
		$('#idPacientePro').val(a); $('#idEstudioPro').val(b); var datoP = {idP:a, idE:b}
		$.post('imagen/archivos_save_ajax/datosProcesar.php', datoP).done(function( data ) {
			var datosP = data.split('*}'); //alert(datosP[5]);
			$('#refPro').text(datosP[1]); $('#refPro1').val(datosP[1]); $('#ordenPro').text(datosP[1]); 
			$('#estPro').text(datosP[2]); $('#areaPro').text(datosP[3]);
			if(datosP[4]!=''){ $('#observacionPro').text(datosP[4]); $('.observacionPro').removeClass('hidden'); }
			else{ $('.observacionPro').addClass('hidden'); }
			$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(''); $('#checaPro').val(0); $('#notificacionPro').hide();
			
			if(datosP[7]!=55){ $('.variosEstu').hide();$('#checaPro').val(1); $('#titulo_modal').text('PROCESAR EL ESTUDIO DEL PACIENTE '+datosP[0]); }
			else{
				if(datosP[5]>1){ $('.variosEstu').show();$('#checaPro').val(0); $('#titulo_modal').text('PROCESAR ESTUDIO(S) DEL PACIENTE '+datosP[0]); }
				else{ $('.variosEstu').hide();$('#checaPro').val(1); $('#titulo_modal').text('PROCESAR ESTUDIO(s) DEL PACIENTE '+datosP[0]); }
			}
			
			$('#btn_procesar').click(function(e) {
                if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
				else{
					var datoP = $('#form-procesar').serialize();
					$.post('imagen/archivos_save_ajax/procesar.php', datoP).done(function( data ) { if (data == 1){ 
						$('#clickme').click(); $('#myModal').modal('hide');
						swal({title:"",type:"",text:"EL PROCESO SE REALIZÓ CORRECTAMENTE",timer:2500,showConfirmButton:false });
					}else{alert(data);} });
				}
            });
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { $('#form-ficha_us').validator();
			$('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	} });
}
function realizar(a,b,radExt,es_masto){//a es el id del paciente y b es el id del estudio en vc
	$("#myModal").load('imagen/htmls/realizar.php', function( response, status, xhr ) { if ( status == "success" ) { 
		//$('.cheki').checkboxradio(); 
		$('#idUserPro').val($('#id_user').val());
		//para los checkbox de la ventana de proceso
		$('#individualPro').click(function(e) { 
			if($(this).prop('checked')==true){
				$('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();
			}else{ $('#individualPro').prop('checked',true); }
		});
		
		$('#variosPro').click(function(e){
			if($(this).prop('checked')==true){ 
				$('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();
			}else{ $('#variosPro').prop('checked',true); }
		});
		
		$('.miProcesar').text('Realizar');$('.miprocesar').text('realizar');$('.miProcesados').text('realizados');
		$('#idPacientePro').val(a); $('#idEstudioPro').val(b); 
		
		var datoP = {idP:a, idE:b}
		$.post('imagen/archivos_save_ajax/datosRealizar.php', datoP).done(function( data ) {
			var datosP = data.split('*}');
			$('#refPro').text(datosP[1]); $('#ordenPro').text(datosP[1]); $('#refPro1').val(datosP[1]); $('#estPro').text(datosP[2]);
			$('#areaPro').text(datosP[3]); $('#estudiosPro').text(datosP[5]); 
			if(datosP[4]!=''){ $('#observacionPro').text(datosP[4]); $('.observacionPro').removeClass('hidden'); }
			else{ $('.observacionPro').addClass('hidden'); }
			$('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); $('#checaPro').val(0); $('#notificacionPro').hide();
			
			if(datosP[7]!=55){ $('.variosEstu').hide();$('#checaPro').val(1); $('#titulo_modal').text('REALIZAR EL ESTUDIO DEL PACIENTE '+datosP[0]); }
			else{
				if(datosP[5]>1){ $('.variosEstu').show();$('#checaPro').val(0); $('#titulo_modal').text('REALIZAR ESTUDIO(S) DEL PACIENTE '+datosP[0]); }
				else{ $('.variosEstu').hide();$('#checaPro').val(1); $('#titulo_modal').text('REALIZAR ESTUDIO(s) DEL PACIENTE '+datosP[0]); }
			}
			
			$('#btn_procesar').text('Realizar');
			
			$('#btn_procesar').click(function(e) {
                if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
				else{
					var datoP = $('#form-procesar').serialize();
					$.post('imagen/archivos_save_ajax/realizar.php', datoP).done(function( data ) { if (data == 1){ 
						$('#clickme').click(); $('#myModal').modal('hide');
						swal({title:"",type:"",text:"EL PROCESO SE REALIZÓ CORRECTAMENTE",timer:2500,showConfirmButton:false });
					}else{alert(data);} });
				}
            });
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { $('#form-ficha_us').validator(); 
			$('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	} });
}
function visualizar(x){ var x1=x; x='imagen/takeArchivos/pdf/'+x+'.pdf'; 
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
				$.post('imagen/takeArchivos/eliminarArchivo.php',idX).done(function( data ) {
					if(data==1){ $('#clickme').click(); $('#myModalx').modal('hide');
						swal({ title: "", type: "success", text: "El archivo ha sido eliminado.", timer: 2000, showConfirmButton: false });
					}
				});
			});
        });
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function (e){ });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
	} });
}
function capturar(a,b,radExt,es_masto,es,id_s){//alert(es);//es_masto = 0;//a es el id del paciente, b es el id del estudio en vc
	$("#myModal2").load('imagen/htmls/captura.php',function(response,status,xhr){ if(status=="success"){
		tinymce.remove("#tCaptura #input");
		if(es==1){ $('#saveInterI').html('<i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR'); }
		else{ $('#saveInterI').html('<i class="fa fa-floppy-o" aria-hidden="true"></i> FINALIZAR'); }
		
		if(es==3){ $('#myModal2').modal('hide'); window.setTimeout(function(){imprimir(b,es_masto,a,1,id_s);},300); }
		else{$('#imprimirInt').hide();}
		
		$('#myIDusuario').val($('#id_user').val()); $('#myIDestudio').val(b); //alert(es_masto);
		
		var dato = { idVC:b, idP:a, idU:$('#id_user').val() }
		$.post('imagen/files-serverside/datosCaptura.php', dato, processData);
		function processData(data){ console.log(data); var datos = data.split('*}{-');
			if(es_masto!=1){$('#mi_birad').html('&nbsp;');} else{
				$('#mi_birad').html('<select class="required form-control input-sm" name="birad_e" id="birad_e" style="width:100%;"> <option value="">-SELECCIONAR BIRAD-</option> <option value="0">BIRAD 0</option> <option value="1">BIRAD 1</option> <option value="2">BIRAD 2</option> <option value="3">BIRAD 3</option> <option value="4">BIRAD 4</option> <option value="5">BIRAD 5</option> </select> '); $('#birad_e').val(datos[8]);
			}
			$('.myPaciente').html(datos[0]); $('.myReferencia').html(datos[1]); $('#titleEst').val(datos[5]);
			$('.myEdad').html(datos[2]); $('.mySexo').html(datos[3]); $('.myFecha').html(datos[4]);
			if(datos[7]!=''){$('.myNotaTR').html('NOTA DEL TÉCNICO: <span class="text-danger">'+datos[7]+'</span>');}
			
			if(es==1){
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
					var et_logoe_x = datosTe[44], et_logoee_x = datosTe[45], et_logogm_x = datosTe[46];

							var data = datos[11];
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

							//tinymce.get('notaMedicaC').setContent(data);
							$('#tCaptura #input').val(data);
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
								});
							}else{$('#tr_machotes').hide();}
				});
				//$('#tCaptura #input').val(datos[11]); 
			} //es = 1 es realizado, 2 es capturado
			else{ $('#tCaptura #input').val(datos[9]); $('#tr_machotes').hide(); }
			
			var titulo=datos[0]+' DE '+datos[2]+' '+datos[3]+' | '+datos[12]+' | '+datos[4];
			$('#titulo_modal').text(titulo);
			
			if(es==3){ }
			else{
				window.setTimeout(function(){ //alert(1);
					tinymce.init({ 
						selector:'#contieneET #input',resize:false,height:$('#myModal2').height()*0.67-$('#tr_machotes').height()-35,theme: "modern",
						plugins: 
							"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
						table_default_styles: { width: '100%' },
						relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#myModal2').width()*0.8,
						toolbar: 
							"undo redo | insert | styleselect_ | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent_ indent_ | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP | mybutton1 |",
						insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1 ',
						paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
						setup: function(editor){
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
				},100);
			}
			
			//del pdf
			$('.mipdf').each(function(index, element) {//alert(index);
				var button = $(this), interval; var idP=b;
				new AjaxUpload(button,{
					action: 'imagen/takeArchivos/subirPdfPoliza.php?action=&key='+idP, name: 'image',
					onSubmit : function(file, ext){
						if(ext != 'PDF' & ext != 'pdf'){
							swal({title:"",type:"error",text:"DEBE SELECCIONAR UN ARCHIVO PDF",timer:1500,showConfirmButton:false}); return false;
						}else{swal({title:"",type:"success",text:"SUBIENDO ARCHIVO...",showConfirmButton:false});}
					},
					onComplete: function(file, response){//alert('x');
						swal.close();
						window.setTimeout(function(){swal({title:"",type:"success",text:"EL ARCHIVO SE HA CARGADO CORRECTAMENTE",timer:2000,showConfirmButton:false});},300);
						var URL='imagen/takeArchivos/pdf/'+idP+'.pdf';
						var datosCargar = {idE:idP, idU:$('#id_user').val()}
						$.post('laboratorio/archivos_save_ajax/cargar.php', datosCargar).done(function(data) { if (data == 1){ 
							$('#clickme').click(); $('#myModal2').modal('hide'); window.setTimeout(function(){ visualizar(b); },2000);
						}else{alert(data); } });
						window.clearInterval(interval); 
					}
				});//Fin del pdf 
			});
			
			$('#saveInterI').click(function(e){
				if(tinyMCE.get('input').getContent()!=''){
					if(es == 1){
						var datos = { input:tinyMCE.get('input').getContent(),myIDestudio:b,myIDusuario:$('#id_user').val(), birad_e:$('#birad_e').val() }
						$.post('imagen/files-serverside/capturar.php',datos,processData); 
						var tutilin='CONFIRMACIÓN ESTUDIO CAPTURADO';
					}
					else{
						var str = tinyMCE.get('input').getContent(); 
						var res = str;//alert(res);
						var datos={input:res,myIDestudio:b,myIDusuario:$('#id_user').val(),birad_e:$('#birad_e').val()}
						$.post('imagen/files-serverside/interpretar.php',datos,processData); 
						var tutilin = 'CONFIRMACIÓN ESTUDIO INTERPRETADO'; es = 3;
					}
					function processData(data) { console.log(data); if (data == 1){
						$('#myModal2').modal('hide'); $('#clickme').click();
						if (es != 3){
							swal({title:"",type:"",text:"LOS DATOS SE GUARDARON CORRECTAMENTE",timer:2500,showConfirmButton:false });
							if(es < 3){ window.setTimeout(function(){capturar(a,b,radExt,es_masto,2);},1500); } 
						}else{
							swal({
							  title: "Los datos se han guardado", text: "¿Deseas imprimir la interpretación?",
							  type: "success", showCancelButton: true, cancelButtonText: "Cerrar",
							  confirmButtonColor: "#DD6B55", confirmButtonText: "Imprimir", closeOnConfirm: false
							},
							function(){
							  if(es_masto!=1){$('#mi_birad').html('');} else{} swal.close(); 
							  window.setTimeout(function(){preImprimir(b,es_masto,a,id_s);},1000);
							});
						} document.getElementById('form-captura').reset();
					}else{ alert(data); } }
				}
			});
			$('#cancInterI').click(function(e){ document.getElementById('form-captura').reset(); });

			$('#tCaptura textarea, #tCaptura input').attr('disabled',false); $('#tablaUsuariosEstados').hide();
			//alert($('#acc_user').val());
			if(es==3){/*$('#myModalx').modal('hide');*/} 
			else{ //alert($('#acc_user').val());
				if($('#acc_user').val()==1 || $('#acc_user').val()==2 || $('#acc_user').val()==10 || $('#acc_user').val()==11){
					$('#myModal2').modal('show');
				}else{swal({title:"",type:"error",text:"ACCESO RESTRINGIDO",timer:2500,showConfirmButton:false });}
			}
		}
		$('#myModal2').on('shown.bs.modal', function (e) {
			$('#form-ficha_us').validator(); $('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal2').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal2").empty(); });
	} });
}
function preImprimir(x,es_masto,idPa,id_s){//a =id paciente, x id estudio en vc
	imprimir(x,es_masto,idPa,0,id_s);
}
function imprimir(x,es_masto,idPa,y,id_s){//x=id del estudio, y es si se imprimen los encabe
	 $("#myModal1").load('imagen/htmls/imprimir.php',function(response,status,xhr){ if(status=="success"){
		$("#myModal1").height($("#referencia").height()*0.85);
		var dato = { idE:x, idP:idPa, idU:$('#id_user').val() }
		$.post('imagen/files-serverside/datosInterpretar.php', dato).done(function(data){ var datos = data.split(';*}-{'); //alert(data);
			var res = datos[5].replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); $("#impresion_inter").html(res);
		});

		$('#btn_imprimir_i').click(function(e) { $('#impresion_inter').printElement(); });
		
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function (e) { });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	}});
}//fin imprimir

function acceso(x, estudio, referencia, paciente){//x=id del e en vc
	$("#myModal2").load('imagen/htmls/para_accesos.php',function(response,status,xhr){if(status=="success"){
		$('#titulo_modal').text("ESTUDIO DEL PACIENTE "+paciente+". REFERENCIA "+referencia); $('#estudioTr').text(estudio);
		
		$('#medico_c').load('imagen/genera/medicos_acceso.php',function(response,status,xhr){if(status=="success"){
			window.setTimeout(function(){$('#medico_c').chosen();},500);
		}});
		
		var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-350;
		var oTable = $('#dataTableAc').DataTable({
			serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true} ],
			"sDom": 'rtSp', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "imagen/datatable-serverside/accesos.php",
			"fnServerParams": function (aoData, fnCallback){ aoData.push({"name": "id_e", "value": x }); },
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "MÉDICOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN MÉDICO FILTRADO.", "sInfoFiltered": " TOTAL DE MÉDICOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		}); $('#clickmeAc').click(function(e) { oTable.draw(); });
		
		$('#btn_dar_a').click(function(e) {
            var datosTI = {idE:x, medico:$('#medico_c').val(), idU:$('#id_user').val()}
			$.post('imagen/files-serverside/dar_acceso.php',datosTI).done(function( data ) { 
				if(data==1){
					$('#clickmeAc').click(); $('#medico_c').val(''); $("#medico_c").trigger("chosen:updated");
					swal({title:"",type:"success",text:"¡La asignación se realizó correctamente!",timer:1800,showConfirmButton:false});
				}
				else if(data==2){ swal({title:"",type:"info",text:"Este médico ya tenía acceso al estudio",timer:1800,showConfirmButton:false}); }
				else{alert(data);}
			});
        });
		
		$('#myModal2').modal('show');
		$('#myModal2').on('shown.bs.modal', function (e) { });
		$('#myModal2').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal2").empty(); });
	} });
}

function delete_a(id_e){
	swal({
	  title: "¿ELIMINAR ACCESO?", text: "Confirmar para eliminar este acceso", type: "warning", showCancelButton: true,
	  confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
	  	var datosTI = {idE:id_e}
		$.post('imagen/files-serverside/quitar_acceso.php',datosTI).done(function( data ) { 
			if(data==1){
				$('#clickmeAc').click(); swal({title:"",type:"",text:"¡La acción se realizó correctamente!",timer:1800,showConfirmButton:false});
			}else{alert(data);}
		});
	});
}

function transferir(x, estudio, referencia, paciente,opc,uA,fA,mA){ //alert(x+' '+estudio+' '+referencia+' '+paciente+' '+opc+' '+uA+' '+fA+' '+mA);
switch(opc){//x=id del e en vc
case 0:
	$("#myModal1").load('imagen/htmls/para_transferir.php',function(response,status,xhr){if(status=="success"){
		$('#titulo_modal').text("TRANSFERIR PARA INTERPRETAR EL ESTUDIO DEL PACIENTE "+paciente+". REFERENCIA "+referencia);
		$('#estudioTr').text(estudio);
		
		var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-344;
		var oTable = $('#dataTableTransfer').DataTable({
			serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true} ], "sDom": 'rtSp', 
			deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "imagen/datatable-serverside/transferir.php",
			"fnServerParams": function (aoData, fnCallback) { },
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "RADIÓLOGOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN RADIÓLOGO FILTRADO.", "sInfoFiltered": " TOTAL DE RADIÓLOGOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		});
		//para los fintros individuales por campo de texto
		oTable.columns().every( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			} );
		} );
		//fin filtros individuales por campo de texto
		oTable.on( 'select', function(e, dt, type, indexes){
			$('#btn_transfer_e').removeClass('disabled');
			var rowData = oTable.rows( indexes ).data().toArray(); $('#idTmedicoR').val(rowData[0][4]);//alert(rowData[0][4]);
		})
		.on( 'deselect', function ( e, dt, type, indexes ){
			$('#btn_transfer_e').addClass('disabled'); $('#idTmedicoR').val('');
		});
		
		$('#btn_transfer_e').click(function(e) {
			if($('#idTmedicoR').val()!=''){
				var datosTI = {idE:x, radiologo:$('#idTmedicoR').val(), idU:$('#id_user').val()}
				$.post('imagen/files-serverside/transferirInterpretacion.php',datosTI).done(function( data ) { if(data==1){
					$('#myModal1').modal('hide'); $('#clickme').click();
					swal({title:"",type:"success",text:"¡La asignación se realizó correctamente!",timer:2500,showConfirmButton:false});
				} });
			}
        });
		
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function (e) { });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
break;
case 1:
	$("#myModal1").load('imagen/htmls/ya_transferido.php',function(response,status,xhr){if(status=="success"){
		$('#titulo_modal').text("INTERPRETACIÓN TRANSFERIDA DEL PACIENTE "+paciente);
		$('#estudioYa').text(estudio); $('#referenciaYa').text(referencia); $('#uAsignaT').text(uA);
		$('#fAsignaT').text(fA); $('#mAsignaT').text(mA);
		
		$('#btn_desasigna_e').click(function(e) {
            swal({
			  title: "DESASIGNAR LA INTERPRETACIÓN",
			  text: "¿ESTA SEGURO DE DESASIGNAR LA INTERPRETACIÓN DEL ESTUDIO "+estudio+" DEL PACIENTE"+paciente+" CON REFERENCIA "+referencia+" ASIGNADO AL MÉDICO "+mA+"?",
			  type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Desasignar", cancelButtonText: "Cancelar", closeOnConfirm: false
			},
			function(){
			  	var datosCOV = {idVC:x}
				$.post('imagen/files-serverside/desasignarI.php',datosCOV).done(function( data ) { if (data==1){ 
					$('#myModal1').modal('hide'); $('#clickme').click();
					swal({title:"",type:"success",text:"¡La acción se realizó correctamente!",timer:2500,showConfirmButton:false});
				} else{alert(data);} });
			});
        });
		
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function (e) { });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
break;
default:
	alert('Ha ocurrido un error!');
} }//fin transferir
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
			$.post('imagen/files-serverside/editarInterpretacion.php', dato).done(function( data ) {
				if(data==1){
					swal.close(); $('#clickme').click();
					window.setTimeout(function(){
						swal({title:"",type:"success",text:"¡La interpretación está lista para su edición!",timer:2500,showConfirmButton:false});
					},300);
				}else{alert(data);}
			});
		});
	}else{ swal({title:"",type:"error",text:"¡Acceso restringido!",timer:2500,showConfirmButton:false}); }
}//fin editar
function noest(idVC,nombreE,nombreP,ref,fecha, idPacs){
	$("#myModal1").load('imagen/htmls/asignar_pacs.php', function(response,status,xhr){if(status == "success"){
		$('#estudioEpacs').text(nombreE); $('#pacienteEpacs').text(nombreP); $('#referenciaEpacs').text(ref);
		$('#fechaEst').val(fecha); $('#idEstVC').val(idVC); $('#idPacsVC').val(idPacs);
		
		var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-400;
		var oTable = $('#dataTablePc').DataTable({
			serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true} ],
			"sDom": 'rtSp', 
			deferRender: true, select: { style: 'single' }, "processing": false, 
			"sAjaxSource": "imagen/datatable-serverside/nopacs.php",
			"fnServerParams": function (aoData, fnCallback) { },
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "ESTUDIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 100, paging: false,
		}); $('#clickmePc').click(function(e) { oTable.draw(); });
		//para los fintros individuales por campo de texto
		oTable.columns().every( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			} );
		} );
		//fin filtros individuales por campo de texto
		oTable.on( 'select', function(e, dt, type, indexes){
			$('#btn_asignar_ep').removeClass('disabled');
			var rowData = oTable.rows( indexes ).data().toArray(); $('#pkPacs').val(rowData[0][7]);//alert(rowData[0][4]);
		}).on( 'deselect', function ( e, dt, type, indexes ){ $('#btn_asignar_ep').addClass('disabled'); $('#pkPacs').val(''); });
		
		$('#btn_asignar_ep').click(function(e) {
			if($('#pkPacs').val()!=''){
				var datosAP = { pkPacs:$('#pkPacs').val(), idPacsVC:$('#idPacsVC').val()}
				$.post('imagen/files-serverside/asignarPacs.php',datosAP).done(function( data ) { 
					if (data==1){ //$('#dialog-noest').dialog('close');
						$('#myModal1').modal('hide'); $('#clickme').click();
						swal({title:"",type:"success",text:"¡La asignación se realizó correctamente!",timer:2500,showConfirmButton:false});
					} else{if (data!=''){ alert(data);} } 
				});
			}
        });
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function (e) { });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
}
function est(a,b,idPacs){/*a es id del estudio, b es el id del estudio ambos en venta de conceptos*/
	var url = window.location.href; 
	
	var sodb = url.split('://'); if(sodb[0]=='https' || sodb[0]=='HTTPS'){
		var myL = url.split('https://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888'); 
		var link_1 = koby[0]; //alert(link_1);
	}else{
		var myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888'); 
		var link_1 = koby[0]+koby[1]; //alert(link_1);//alert(myL[0]);
	}
	
	var idE = {idE:a,h:koby[0]}
	$.post('imagen/files-serverside/datosInterpretar.php',idE).done(function( data ) {//alert(data);
		var dataE = data.split(';*}-{');
		if(dataE[0]!=''){
			$("#myModal1").load('imagen/htmls/mi_estudio.php', function(response,status,xhr){if(status == "success"){
				console.log(dataE);
				$('#referencia_est').val(dataE[12]); $('#idEstudioPacs').val(dataE[19]);
				$('#referencia_est').attr("refe", dataE[34]);
				$('#paciente_est').val(dataE[0]); $('#folio_est').val(dataE[8]);
				var pu = 'http://csantonio.ddns.net:8887/dcm4chee-arc/aets/DCM4CHEE/wado/wado?requestType=PATIENT&studyUID='+dataE[16];
				var linkOsiL = 'osirix://?methodName=DownloadURL&Display=YES&URL='+encodeURI(pu);
				var ka = '<a href='+dataE[17]+' id="localhost"><img src="imagenes/osirix.png"></a>';
				$('#chosto').html(''); //
				var studyUID = dataE[35];
				$('#chosto').text(
					dataE[19] + 'viewer.html?StudyInstanceUIDs=' + studyUID
				);
				$('#chosto1').text(
					dataE[19] + 'weasis-pacs-connector/viewer?StudyInstanceUIDs=' + studyUID
				);
				var mi_referCh = $('#referencia_est').val().replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');
				$('#chosto').text(dataE[19]+'viewer.html?StudyInstanceUIDs='+mi_referCh);
				$('#chosto1').text(dataE[19]+'weasis-pacs-connector/viewer?StudyInstanceUIDs='+mi_referCh);
				$('#chosto').append(ka);
				var studyUID = dataE[35];
				$('#studyUID').val(studyUID);

				$('#btn_gen_enla').off('click').on('click', function(e) {

				e.preventDefault();

				$.ajax({
					url: 'http://localhost:4000/api/share',
					type: 'POST',
					contentType: 'application/json',
					data: JSON.stringify({
						studyUID: studyUID,
						patientName: $('#paciente_est').val(),
						patientID: $('#referencia_est').val(),
					}),
					success: function(response) {

						if (response.success) {

							$('#enlaceGenerado').val(response.url);

						} else {

							alert(response.message || 'No se pudo generar el enlace');

						}

					},
					error: function(xhr) {

						console.error(xhr.responseText);
						alert('Error al generar el enlace');

					}
				});

			});

				$('#btn_comp_enlace').off('click').on('click', function(e) {

					e.preventDefault();

					var telefono = $('#telefonoWhatsapp').val().replace(/\D/g, '');
					var enlace = $('#enlaceGenerado').val();

					if (!enlace) {
						alert('Primero genera el enlace.');
						return;
					}

					if (!telefono) {
						alert('Ingresa un número de WhatsApp.');
						return;
					}

					var mensaje = encodeURIComponent(
						'Hola. Puedes visualizar tu estudio DICOM en el siguiente enlace:\n\n' +
						enlace
					);

					window.open(
						'https://wa.me/' + telefono + '?text=' + mensaje,
						'_blank'
					);

				});
				$('#btn_v_avanzado').click(function(e) {
					window.open(
						'http://localhost:81/viewer?StudyInstanceUIDs='+studyUID
					);
				});
				if(($('#acc_user').val()==1 || $('#acc_user').val()==11 || $('#acc_user').val()==3) & $('#multisu_s').val()!=0){
					$('#btn_reasignar_id').click(function(e){ noest(a, dataE[8], dataE[0], dataE[1], dataE[33], idPacs); });
				}
				else{ $('#btn_reasignar_id').remove(); }
			
				$('#myModal1').modal('show');
				$('#myModal1').on('shown.bs.modal', function (e) { });
				$('#myModal1').on('hidden.bs.modal', function (e) { 
					$(".modal-content").remove(); $("#myModal1").empty(); 
					$('#paciente_est, #referencia_est, #folio_est, #idEstudioPacs').val('');
				});
			}});		
		}
	});
}
function fotos(id_su, clave_su){
	$("#myModal1").load("imagen/htmls/fotografias.php",function(response, status, xhr){ if(status == "success"){
		$('#t_id_s').val(id_su); $('#t_clave_s').val(clave_su);
		$('#b_subir_foto').click(function(e){
			$('#myModal1').modal('hide');window.setTimeout(function(){subir_foto(id_su,clave_su);},300);
		});
		
		var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-300;
		var oTableF = $('#dataTableFotos').DataTable({
			serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true} ],
			"sDom": 'rtSp', 
			deferRender: true, select: false, "processing": false, 
			"sAjaxSource": "imagen/datatable-serverside/fotos.php",
			"fnServerParams":function(aoData, fnCallback){ var id_s = id_su; aoData.push({"name": "id_s", "value": id_s });},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "IMÁGENES FILTRADAS: _END_",
				"sInfoEmpty": "NINGUNA IMAGEN FILTRADO.", "sInfoFiltered": " TOTAL DE IMÁGENES: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 5000, paging: false,
		}); $('#clickmeFo').click(function(e) { oTableF.draw(); });
				
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function (e) { });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
}
function subir_foto(idS, clave_su){
	$("#myModal2").load("imagen/htmls/subir_fotografia.php",function(response,status,xhr){ if(status == "success"){
		$('#titulo_foto').keyup(function(e){
			if($(this).val()!=''){$('#fileupload_foto').removeClass('disabled');} else{$('#fileupload_foto').addClass('disabled');}
		});
		
		//Para el upload
		'use strict';
		// Change this to the location of your server-side upload handler:
		var ko = $('#id_user').val();
		var url = window.location.hostname === 'blueimp.github.io' ?
					'//jquery-file-upload.appspot.com/' : 'imagen/fotografias/index.php?idU='+ko+'&idP='+idS+'&nombreD='+escape($('#titulo_foto').val());
		$('#fileupload_foto').fileupload({
			url: url, dataType: 'json',
			submit:function (e, data) {
				$.each(data.files, function (index, file) {
					var input = $('#titulo_foto'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
				});
			},
			progress: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);$('#progress .bar').css( 'width', progress + '%' );
			},
			done: function (e, data) {
				swal({title:"",type:"success",text:"La fotografía se ha cargado correctamente!",timer:2500,showConfirmButton:false});
				$('#myModal2').modal('hide');
			}
		}); //Para el upload
		
		$('#myModal2').modal('show');
		$('#myModal2').on('shown.bs.modal', function (e) { });
		$('#myModal2').on('hidden.bs.modal', function (e) { 
			$(".modal-content").remove(); $("#myModal2").empty(); window.setTimeout(function(){fotos(idS, clave_su);},300);
		});
	} });
}

function ver_logo(nombre_img, name_s, exte, time,titulo,carpeta,id_doc,que_es){
	$("#myModal1").load("pacientes/htmls/miPDFdocs.php",function(response,status,xhr){ if(status == "success"){
		$('#titulo_modal').text(titulo+' DEL ESTUDIO '+ name_s); var widi = $('#myModal1').width()*0.6;
		
		if(exte != 'pdf' & exte != 'PDF'){
			x='imagen/'+carpeta+'/files/'+id_doc+'.'+exte+'?'+time;
			$('#mi_documento').html('<img src='+x+' style="max-width:'+widi+'px; border:3px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
		}else{
			x='imagen/'+carpeta+'/files/'+id_doc+'.pdf';
			$('#mi_documento').html('<a class="media" href=""> </a>'); $('a.media').media({width:790, height:h-136, src:x});	
		}
		$('#btn_imprimir_img').click(function(e){ $('#myModal1 #tablaMiPDF').printElement(); });
		$('#btn_eliminar_img').click(function(e){ delete_documento(id_doc,titulo,exte,que_es,carpeta); });
					
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function(e){ });
		$('#myModal1').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
	}});
}

function delete_documento(id_doc, nombre_doc, tipo_doc, titulo,carpeta){//alert(tipo_doc);
	swal({
	  title: "Eliminar archivo", text: "¿ESTÁ SEGURO QUE DESEA ELIMINAR EL ARCHIVO "+nombre_doc+"?", type: "warning",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		var datos = {id:id_doc, tipo:tipo_doc, que_es:titulo,carpeta:carpeta}
		$.post('imagen/files-serverside/eliminarFoto.php',datos).done(function(data){
			if (data==1){
				$('#myModal1').modal('hide'); swal("Archivo eliminado", "El archivo ha sido eliminado.", "success");
				window.setTimeout(function(){swal.close(); fotos($('#t_id_s').val(),$('#t_clave_s').val());},1000);
			}else{alert(data);}
		});
	});
}

var recognition;
var recognizing = false;
if (!('webkitSpeechRecognition' in window)) { $('#dictado').hide(); /*alert("¡API no soportada!"); */} 
else {
	recognition = new webkitSpeechRecognition(); recognition.lang = "es-VE"; recognition.continuous = true;
	recognition.interimResults = true; //era true

	recognition.onstart = function() { recognizing = true; console.log("empezando a eschucar"); }
	recognition.onresult = function(event) {
	 for (var i = event.resultIndex; i < event.results.length; i++) { 
		if(event.results[i].isFinal){insertAtCaret(event.results[i][0].transcript.toUpperCase());}
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

function insertAtCaret(text){ 
	var re = / PUNTO Y COMA/g; text = text.replace(re, ";");
	var re4 = / DOS PUNTOS/g; text = text.replace(re4, ":");
	var re3 = / PUNTO Y APARTE/g; text = text.replace(re3, ".<br>");
	var re1 = / PUNTO/g; text = text.replace(re1, ".");
	var re2 = / COMA/g; text = text.replace(re2, ",");
	tinymce.get("input").execCommand('mceInsertContent', false, text); 
}
</script>