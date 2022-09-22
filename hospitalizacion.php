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
    
    <title>SISTEMA - HOSPITALIZACIÓN</title>
    
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
	<script src="TableTools-2.1.5/media/js/TableTools.js"></script>
    <script src="TableTools-2.1.5/media/js/ZeroClipboard.js"></script>
    <script src="bootstrap-validator/js/validator.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
    <script src="funciones/js/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8"></script>
    <script src='tinymce/tinymce.min.js'></script>
    <script src='c3/c3.min.js'></script>
    <script src='c3/d3/d3.min.js'></script>
	<script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <!-- Input Mask-->
    <script src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script> 
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet"  >
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" media="all" >
    <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet" >
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet" >
	<link href="TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">
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
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px; font-size: 1.1em;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;" nowrap>PACIENTE</th>
    <th style="vertical-align:middle;">INGRESO</th>
    <th style="vertical-align:middle;">UBICACIÓN</th>
    <th style="vertical-align:middle;">TRATANTE</th>
	<th style="vertical-align:middle;">NOTAS_E</th>
    <th style="vertical-align:middle;">NOTAS_M</th>
    <th style="vertical-align:middle;" nowrap>ECE</th>
    <th style="vertical-align:middle;">MEDICAMENTOS</th>
	<th style="vertical-align:middle;">SV/HC</th>
	<th style="vertical-align:middle;">DXs</th>
	<th style="vertical-align:middle;">IMGs</th>
	<th style="vertical-align:middle;">ESTATUS</th>
	<th style="vertical-align:middle;">EGRESO</th>
	<th style="vertical-align:middle;">OV</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Paciente"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Fecha ingreso"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Ubicación" style="width: 90%;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Médico tratante" style="width: 100%;"/></th>
            <th></th>
			<th></th>
            <th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Estatus" style="width: 90%;"/></th>
			<th><input type="text" class="form-control input-sm" placeholder="Fecha egreso"/></th>
			<th></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
var oTableP = null;

$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>HOSPITAL</li><li class="active"><strong>HOSPITALIZACIÓN</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-169;
	oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "hospital/datatable-serverside/hospital.php",
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

function egresar (id, id_cama) {
	const DATOS = {
		id_u: $('#id_user').val(), //mandamos el Id del usuario que egreso al paciente
		id_h: id,
		id_cama_h: id_cama 
	}
	swal({
		title: "", text: "¿Desea egresar a éste paciente?", showCancelButton: true, confirmButtonColor: "#DD6B55", type:"warning",
		showConfirmButton: true, confirmButtonText: 'Egresar', cancelButtonText: "Cancelar", closeOnConfirm: false,
	},
	function(){
		$.post('hospital/files-serverside/egresar.php', DATOS).done(function(data){
			if(data==1){
				// Actualiza el datatable
				oTableP.draw();
				swal({title:"",type:"success",text:"El paciente ha sido egresado.", timer: 2000, showConfirmButton: false });
			}else{alert(data);}
		});
	});
}
	
function medicamentos(id_h, id_p, nombre_p, id_s, estatus){
	$("#myModal2").load('hospital/htmls/medicamentos.php', function( response, status, xhr ){ if(status=="success"){
		$('#titulo_modal').text('MEDICAMENTOS PARA EL PACIENTE '+nombre_p);
		
		window.setTimeout(function(){
			var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height() - $('#breadc').height() - 300;
			var oTable = $('#dataTableMedicamentos').DataTable({
				serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ){ }, scroller: false, responsive: true,
				"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true },{ "bVisible": true }, {"bVisible":true },{ "bVisible": true },{ "bVisible": true },{"bVisible": true } ],
				"sDom": '<"filtro1Principal"><"data_tPrincipal"t><"infoPrincipal"S><"proc">',
				deferRender: true, select: false, "processing": false, "sAjaxSource": "hospital/datatable-serverside/medicamentos.php?id_h="+id_h,
				"fnServerParams": function(aoData, fnCallback){ },
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "MEDICAMENTOS FILTRADOS: _END_","sInfoEmpty":"NINGÚN MEDICAMENTO FILTRADO.","sInfoFiltered":" TOTAL DE MEDICAMENTOS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 500, paging: true, "bDestroy" : true
			});

			$('#clickmeMdtos, #tap-asignados').click(function(e) { oTable.draw(); }); window.setTimeout(function(){$('#clickmeMdtos').click();},500);

			//para los fintros individuales por campo de texto
			oTable.columns().every( function () {
				var that = this; $('input',this.footer()).on('keyup change', function (){ if(that.search() !== this.value){ that .search( this.value ) .draw(); } } );
			}); //fin filtros individuales por campo de texto
			
			if(estatus =='EGRESADO'){
				$('#btn_add_medicamento').addClass('hide');
				$('#title_medicamento').html('MEDICAMENTO');
			}
			$('#btn_add_medicamento').click(function(e){ nuevo_medicamento(id_h, id_p, nombre_p, id_s); });
			
			var oTableA = $('#dataTableMedicamentosA').DataTable({
				serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
				scroller: false, responsive: true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ){
					var iTotal = 0;
						for(var i=iStart ; i<iEnd ; i++){ 
							iTotal += aaData[ aiDisplay[i] ][6]*1;
						}

						/* Modify the footer row to match what we want */
						var nCells = nRow.getElementsByTagName('th');
						console.log(iTotal);
						nCells[4].innerHTML = "Total: $" + redondear(parseFloat(iTotal * 100)/100,2);
						
				 },
				"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": false }, {"bVisible":false },{ "bVisible": true },{ "bVisible": true },{ "bVisible": true } ],
				"sDom": '<"filtro1Principal"><"data_tPrincipal"t><"infoPrincipal"S><"proc">',
				deferRender: true, select: false, "processing": false, "sAjaxSource": "hospital/datatable-serverside/medicamentosA.php?id_h="+id_h,
				"fnServerParams": function(aoData, fnCallback){ },
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "MEDICAMENTOS FILTRADOS: _END_","sInfoEmpty":"NINGÚN MEDICAMENTO FILTRADO.","sInfoFiltered":" TOTAL DE MEDICAMENTOS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 500, paging: true, "bDestroy" : true
			});

			$('#clickmeMdtosA, #tap-aplicados').click(function(e) { oTableA.draw(); }); window.setTimeout(function(){$('#clickmeMdtosA').click();},500);
			
				$('#btn_printMA').click(function(){ 
					window.open("hospital/genera/mi_pdf_reporteMA.php?id_h="+id_h+"&nombre="+nombre_p+"&id_u="+ $('#id_user').val(), '_blank');
				});
			//para los fintros individuales por campo de texto
			oTableA.columns().every( function () {
				var that = this; $('input',this.footer()).on('keyup change', function (){ if(that.search() !== this.value){ that .search( this.value ) .draw(); } } );
			}); //fin filtros individuales por campo de texto
		},200);
		
		$('#myModal2').modal('show'); $('#myModal2').on('shown.bs.modal', function (e){});
		$('#myModal2').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal2").empty(); });
	}});
}
var unaSolaVez = 0;
function poner_medi(id_mh,med,paciente){
	unaSolaVez = 0;
	swal({
	  title: "¿APLICAR " + med + " AL PACIENTE "+ paciente +"?", text: "", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Aplicar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
		$(".sa-confirm-button-container > button").html("Cargando...").attr("disabled", "disabled"); 
		unaSolaVez++;
		var datos = {id_mh:id_mh, id_u:$('#id_user').val()}
		if(unaSolaVez == 1){
			$.post('hospital/files-serverside/aplicar_medi.php',datos).done(function( data ) {
				if (data==1){
						$('#clickmeMdtos').click();
						swal({ title: "", type: "success", text: "El medicamento ha sido aplicado al paciente.", timer: 1800, showConfirmButton: false });
				}else if(data==2){
					swal({ title: "", type: "error", text: "El medicamento no cuenta con existencias.", timer: 1800, showConfirmButton: false });
				}else{
					alert(data);
				} 
			});
		}
	});
}
function suspender_medi(id_mh, medicamento, paciente){
	var dat = {id_mh:id_mh}
		$.post('hospital/files-serverside/verificar_medi.php',dat).done(function( data ) {
			if (data==1){  //el estatus es aplicar 
				$("#myModal1").load("hospital/htmls/suspender_medi.php", function(response,status,xhr){ 
					if(status == "success"){
						var str = 'SUSPENSIÓN DEL MEDICAMENTO ' + medicamento + 'AL PACIENTE '+ paciente ;
					$('#titulo_modal1').text(str);

					$('#form_cov').validator().on('submit', function (e) {
					if (e.isDefaultPrevented()) { // handle the invalid form...
					} else { // everything looks good!
						e.preventDefault(); 
						// $('#pacienteCancelOV').text(nombreP); $('#refCancelOV').text(refe);
						swal({
						title: "SUSPENDER "+ medicamento +" DEL PACIENTE "+paciente, text: "¿Estás seguro de SUSPENDER el medicamento?", type: "warning",
						showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Suspender", 
						cancelButtonText: "Cerrar", closeOnConfirm: false
						},
						function(){
						var datosCOV = {id_mh:id_mh, notaS: $("#m_cancelacion").val(), id_u:$('#id_user').val()}
							$.post('hospital/files-serverside/suspender_medi.php',datosCOV).done(function( data ) { 
								if (data==1){ window.setTimeout(function(){$('#clickmeMdtos').click(); $('#myModal1').modal('hide');},300);
									swal({
									title: "", type: "success", text: "El medicamento se ha suspendido", timer: 2000, showConfirmButton: false
									}); return;
								} else{alert(data);} 
							});
						});
					}
					});
							
					$('#myModal1').modal('show');
					$('#myModal1').on('shown.bs.modal', function (e){ });
					$('#myModal1').on('hidden.bs.modal', function (e) { $("#myModal1").empty(); });
				} });
			}else if(data==2){ //el estatus es suspender 
				$("#myModal1").load("hospital/htmls/medicamentos_suspendidos.php", function(response,status,xhr){ 
					if(status == "success"){
						var daTabla = {id_mh:id_mh, id_u:$('#id_user').val() }
						$.post('hospital/datatable-serverside/medicamentos_suspendidos.php',daTabla).done(function( data ) { 
							$('#tbodyContentMS').html(data);
							$('#titulo_modal2').text('Registro de suspensión del medicamento');
						});

						$('#btn_aplicar').click(function(e){
							swal({
							title: "REANUDAR APLICACION DEL MEDICAMENTO "+ medicamento +" AL PACIENTE "+paciente, text: "¿Estás seguro de esta acción?", type: "warning",
							showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "REANUDAR", 
							cancelButtonText: "Cerrar", closeOnConfirm: false
							},
							function(){
							var datReanu = {id_mh:id_mh}
								$.post('hospital/files-serverside/reanudar_medi.php',datReanu).done(function( data ) { 
									if (data==1){ window.setTimeout(function(){$('#clickmeMdtos').click(); $('#myModal1').modal('hide');},300);
										swal({
										title: "", type: "success", text: "El medicamento se ha reanudado correctamente", timer: 2000, showConfirmButton: false
										}); return;
									} else{alert(data);} 
								});
							});
						});
						
							
						$('#myModal1').modal('show');
						$('#myModal1').on('shown.bs.modal', function (e){ });
						$('#myModal1').on('hidden.bs.modal', function (e) { $("#myModal1").empty(); });
					} 
				});
			}else{
				alert(data);
			} 
		});
}
function nuevo_medicamento(id_h, id_p, nombre_p, id_s){ $('#myModal2').modal('hide');
	window.setTimeout(function(){
		$("#myModal3").load('hospital/htmls/add_medicamento.php', function( response, status, xhr ){ if(status=="success"){
			$('#titulo_modal').text('AGREGAR MEDICAMENTO PARA EL PACIENTE '+nombre_p);
			
			window.setTimeout(function(){
				var tam = ($('#referencia').height() - $('#navcit').height() - $('#my_footer').height() - $('#breadc').height() - 245)/2;
				var oTable = $('#dataTableMeds').DataTable({
					serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ){ }, scroller: false, responsive: true,
					"aoColumns": [ {"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true},{"bVisible":true} ],
					"sDom": '<"filtro1Principal"><"data_tPrincipal"t><"infoPrincipal"S><"proc">',
					deferRender: true, select: { style: 'single' }, "processing": false, "sAjaxSource": "hospital/datatable-serverside/buscar_medicamentos.php",
					"fnServerParams": function(aoData, fnCallback){ },
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
						"sInfo": "MEDICAMENTOS FILTRADOS: _END_", "sInfoEmpty": "NINGÚN MEDICAMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE MEDICAMENTOS: _MAX_",
						"sSearch": "", "oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
					},"iDisplayLength": 500, paging: true, "bDestroy" : true
				});

				$('#clickmeMeds').click(function(e) { oTable.draw(); }); window.setTimeout(function(){$('#clickmeMeds').click();},500);

				//para los fintros individuales por campo de texto 
				oTable.columns().every( function () {
					var that = this;
					$( 'input', this.footer() ).on( 'keyup change', function () { if ( that.search() !== this.value ) { that .search( this.value ) .draw(); } } );
				}); //fin filtros individuales por campo de texto 
				
				oTable.on('select', function(e, dt, type, indexes){
					$('#mis_indis').removeClass('hidden'); $('#btn_save_medi').removeClass('disabled');
					var rowData = oTable.rows( indexes ).data().toArray(); $('#id_medi').val(rowData[0][7]); //alert(rowData[0][7]);
					var datosN = {id_m:rowData[0][7]}
					$.post('hospital/files-serverside/indicacion_medic.php',datosN).done(function(data){ $('#indicacion_m').val(data); });
				}).on( 'deselect', function ( e, dt, type, indexes ){
					$('#mis_indis').addClass('hidden'); $('#btn_save_medi').addClass('disabled'); $('#indicacion_m').val(''); $('#id_medi').val('');
				});
				
				$('#btn_save_medi').click(function(e){
					$('#btn_save_medi').addClass('disabled');
					if($('#id_medi').val()!=''){ guardar_add_medi(id_h, id_p, $('#id_medi').val(), $('#indicacion_m').val()); }
				});
			},300);

			$('#myModal3').modal('show'); $('#myModal3').on('shown.bs.modal', function (e){});
			$('#myModal3').on('hidden.bs.modal', function (e){ 
				$(".modal-content").remove(); $("#myModal3").empty(); window.setTimeout(function(){ medicamentos(id_h, id_p, nombre_p, id_s); },300);
			});
		}});
	},300);
}
function guardar_add_medi(id_h, id_p, id_m, indicacion){
	var datos = {id_h:id_h, id_p:id_p, id_m:id_m, indicacion:indicacion, id_u:$('#id_user').val()}
	$.post('hospital/files-serverside/asignar_medi.php',datos).done(function(data){
		if(data==1){
			$('#myModal3').modal('hide');
			swal({ title: "", type: "success", text: "El medicamento ha sido asignado al paciente.", timer: 1800, showConfirmButton: false }); return;
		}else{alert(data);}
	});
}
function notasMedicasEnfermeria(id_h, id_p, nombre_p, id_s, estatus,tUser){
	$("#myModal").load('hospital/htmls/notas.php', function( response, status, xhr ){ if(status=="success"){
		$('#titulo_modal').text('NOTAS DE HOSPITAL PARA EL PACIENTE '+nombre_p);
		
		window.setTimeout(function(){
			var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height() - $('#breadc').height() - 245;
			var oTableN = $('#dataTableNotas').DataTable({
				serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ){ }, scroller: false, responsive: true,
				"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true },{ "bVisible": true },{ "bVisible": true } ],
				"sDom": '<"filtro1Principal"><"data_tPrincipal"t><"infoPrincipal"S><"proc">',
				deferRender: true, select: false, "processing": false, "sAjaxSource": "hospital/datatable-serverside/notasEnf.php?id_h="+id_h,
				"fnServerParams": function(aoData, fnCallback){
					var idU = $('#id_user').val();
					var estado = estatus;
					// var tUsert = tUser;
					aoData.push( {"name": "estatus", "value": estado } );
					aoData.push( {"name": "idU", "value": idU } );
					// aoData.push( {"name": "tUser", "value": tUsert } );
				 },
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "NOTAS FILTRADAS: _END_", "sInfoEmpty": "NINGUNA NOTA FILTRADA.", "sInfoFiltered": " TOTAL DE NOTAS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 500, paging: true, "bDestroy" : true
			});

			// $('#clickmeFmts').click(function(e) { oTable.draw(); });
			//  window.setTimeout(function(){$('#clickmeFmts').click();},500);

			//para los fintros individuales por campo de texto
			oTableN.columns().every( function () {
				var that = this;
				$( 'input', this.footer() ).on( 'keyup change', function () { if ( that.search() !== this.value ) { that .search( this.value ) .draw(); } } );
			}); //fin filtros individuales por campo de texto
			if(estatus == 'EGRESADO' || (tUser != 4 && tUser != "ENFERMERIA")){
				$('#btn_nueva_nota').addClass('hide');
			}
			var tUser1 = "ENFERMERIA";
			$('#btn_nueva_nota').click(function(e){ nueva_nota(id_h, id_p, nombre_p, id_s, tUser, tUser1); });			
		},200);
	
		$('#myModal').modal('show'); $('#myModal').on('shown.bs.modal', function (e){});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}
function notasMedicas(id_h, id_p, nombre_p, id_s, estatus,tUser){
	$("#myModal").load('hospital/htmls/notas.php', function( response, status, xhr ){ if(status=="success"){
		$('#titulo_modal').text('NOTAS DE HOSPITAL PARA EL PACIENTE '+nombre_p);
		
		window.setTimeout(function(){
			var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height() - $('#breadc').height() - 245;
			var oTable = $('#dataTableNotas').DataTable({
				serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ){ }, scroller: false, responsive: true,
				"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true },{ "bVisible": true },{ "bVisible": true } ],
				"sDom": '<"filtro1Principal"><"data_tPrincipal"t><"infoPrincipal"S><"proc">',
				deferRender: true, select: false, "processing": false, "sAjaxSource": "hospital/datatable-serverside/notas.php?id_h="+id_h,
				"fnServerParams": function(aoData, fnCallback){
					var idU = $('#id_user').val();
					var estado = estatus;
					// var tUsert = tUser;
					aoData.push( {"name": "estatus", "value": estado } );
					aoData.push( {"name": "idU", "value": idU } );
					// aoData.push( {"name": "tUser", "value": tUsert } );
				 },
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "NOTAS FILTRADAS: _END_", "sInfoEmpty": "NINGUNA NOTA FILTRADA.", "sInfoFiltered": " TOTAL DE NOTAS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 500, paging: true, "bDestroy" : true
			});

			// $('#clickmeFmts').click(function(e) { oTable.draw(); }); window.setTimeout(function(){$('#clickmeFmts').click();},500);

			//para los fintros individuales por campo de texto
			oTable.columns().every( function () {
				var that = this;
				$( 'input', this.footer() ).on( 'keyup change', function () { if ( that.search() !== this.value ) { that .search( this.value ) .draw(); } } );
			}); //fin filtros individuales por campo de texto
			if(estatus == 'EGRESADO' || (tUser == 4 || tUser == "ENFERMERIA")){
				$('#btn_nueva_nota').addClass('hide');
			}
			$('#btn_nueva_nota').click(function(e){ nueva_nota(id_h, id_p, nombre_p, id_s, tUser); });			
		},200);
	
		$('#myModal').modal('show'); $('#myModal').on('shown.bs.modal', function (e){});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}
	
function ver_nota(id_h, id_p, nombre_p, id_s, id_n, tUser, estatus){ $('#myModal').modal('hide');
	window.setTimeout(function(){
		$("#myModal1").load('hospital/htmls/notas.php', function( response, status, xhr ){ if(status=="success"){
			$('#titulo_modal').text('NOTA DE HOSPITAL PACIENTE '+nombre_p); $('#contenido_tabi').html(''); $('#btn_print').removeClass('hidden');
			
			var datosN = {id_n:id_n}
			$.post('hospital/files-serverside/datosNotaH.php',datosN).done(function(data){
				var res = data.replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); $("#contenido_tabi").html(res);//$('#contenido_tabi').html(data); 
				$('#btn_print').click(function(e){ $('#contenido_tabi').printElement(); });
			});
			
			$('#myModal1').modal('show'); $('#myModal1').on('shown.bs.modal', function (e){});
			$('#myModal1').on('hidden.bs.modal', function (e) {
				$(".modal-content").remove(); $("#myModal1").empty(); 
				window.setTimeout(function(){
					if(tUser == "ENFERMERIA"){
						notasMedicasEnfermeria(id_h, id_p, nombre_p, id_s, estatus, tUser);
					}else{
						notasMedicas(id_h, id_p, nombre_p, id_s, estatus, tUser);
					}
				},300);	
			});
		}});
	},300);
}
function editar_nota(id_h, id_p, nombre_p, id_s, id_n, tUser, estatus){ 
	$('#myModal').modal('hide');
	window.setTimeout(function(){
		$("#myModalx").load('consultas/htmls/ficha_consulta.php', function( response, status, xhr ){ 
			if(status=="success"){ 
				console.log("ya pase...");
				$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro').prop('readonly','readonly'); 
				$('.escala_g').prop('disabled','disabled');
				$('#hospitalizarP, #tabs_receta, #tabs_imagenes, #finalizarConsulta, #tab_my_hc_x, #tab_sv_1').remove();
				$('#tabRevisiones, #dictado, #verHistorialHcC, #verHistorialLabC, #verHistorialUsgC, #verHistorialImgC, #verHistorialEndC, #verHistorialColC, #verHistorialOtrosC, #verHistorialNotasC').hide(); $('#imprimirNotaE').hide(); $('#imprimirRecetaF').hide();

				$('#titulo_modal').text('NOTA DE HOSPITAL PACIENTE '+nombre_p);
				$('#contenido_tabi').html('');
				$('#btn_print').removeClass('hidden');
				tinymce.init({ 
					selector:'#notaMedicaC',resize:false,height:$('#myModalx').height()*0.45,theme: "modern",
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
							text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
							onclick:function(){
								var res = tinyMCE.get("notaMedicaC").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
								$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
								$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
							}
						});
					}
				});
				tinymce.remove("#notaMedicaC");
				tinymce.init({ 
					selector:'#notaMedicaC',resize:false,height:$('#myModalx').height()*0.45,theme: "modern",
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
							text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
							onclick:function(){
								var res = tinyMCE.get("notaMedicaC").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
								$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
								$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
							}
						});
					}
				});
			

				$("#tipoNotaMed").load("consultas/files-serverside/tNotaMedica.php?x="+$('#id_user').val(),function(response,status,xhr){ if(status=="success"){

					var datosT = {idP:id_p, idU:$('#id_user').val(), id_vc:id_h}
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
						var et_logoe_x = datosTe[44], et_logoee_x = datosTe[45], et_logogm_x = datosTe[46], et_historia_clinica_x = datosTe[52];
						var et_historia_clinica_AHF_x = datosTe[53], et_historia_clinica_APNP_x = datosTe[54], et_historia_clinica_APP_x = datosTe[55], et_historia_clinica_AGO_x = datosTe[56],et_destroxtis = datosTe[60];

						var datosN = {id_n:id_n}
						$.post('hospital/files-serverside/datosNotaH.php',datosN).done(function(data){
							data = data.replace(/{ET_ALERGIAS}/gi, alergiasx);
								data = data.replace(/{ET_EDAD}/gi, edadx1);
								data = data.replace(/{ET_NOMBRE_MEDICO_ATIENDE}/gi, nombre_medicox);
								data = data.replace(/{et_nombre_personal_atiende}/gi, nombre_medico_a);	
								data = data.replace(/{et_destroxtis}/gi, et_destroxtis);

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
								data = data.replace(/{et_historia_clinica}/gi, et_historia_clinica_x);
								data = data.replace(/{et_historia_clinica_AHF}/gi, et_historia_clinica_AHF_x);
								data = data.replace(/{et_historia_clinica_APNP}/gi, et_historia_clinica_APNP_x);
								data = data.replace(/{et_historia_clinica_APP}/gi, et_historia_clinica_APP_x);
								data = data.replace(/{et_historia_clinica_AGO}/gi, et_historia_clinica_AGO_x);
								tinymce.get('notaMedicaC').setContent(data);
						});

						$("#tipoNotaMed").change(function(e) {//alert('Cambia');
							var datos = {idNM:$("#tipoNotaMed").val(),idC:id_h}
							$.post('consultas/files-serverside/textoNotaM.php',datos).done(function(data){ //alert(data);
								data = data.replace(/{ET_ALERGIAS}/gi, alergiasx);
								data = data.replace(/{ET_EDAD}/gi, edadx1);
								data = data.replace(/{ET_NOMBRE_MEDICO_ATIENDE}/gi, nombre_medicox);
								data = data.replace(/{et_nombre_personal_atiende}/gi, nombre_medico_a);	
								data = data.replace(/{et_destroxtis}/gi, et_destroxtis);

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
								data = data.replace(/{et_historia_clinica}/gi, et_historia_clinica_x);
								data = data.replace(/{et_historia_clinica_AHF}/gi, et_historia_clinica_AHF_x);
								data = data.replace(/{et_historia_clinica_APNP}/gi, et_historia_clinica_APNP_x);
								data = data.replace(/{et_historia_clinica_APP}/gi, et_historia_clinica_APP_x);
								data = data.replace(/{et_historia_clinica_AGO}/gi, et_historia_clinica_AGO_x);
								tinymce.get('notaMedicaC').setContent(data);
								//$('#tabs_nnm #tabs-1n .jqte_editor').html(data);
							});
						});
					});
				}});

				$('#salvarConsulta').click(function(e) { 
					var str = tinyMCE.get('notaMedicaC').getContent(); 
					var datosGC = { id_n:id_n, nota:str } 
					$.post('hospital/files-serverside/guardarNotaH.php',datosGC).done(function(data){ 
						if(data == 1){
						swal({ title:"",type:"success",text:"LOS DATOS DE LA NOTA HAN SIDO GUARDADOS.", timer:2000,showConfirmButton:false }); $('#myModalx').modal('hide');
					}else{alert(data);} });
				});
				// $('#salirSGconsulta').click(function(e){ 
				// 	if(tUser == "ENFERMERIA"){
				// 		notasMedicasEnfermeria(id_h, id_p, nombre_p, id_s, estatus, tUser);
				// 	}else{
				// 		notasMedicas(id_h, id_p, nombre_p, id_s, estatus, tUser);
				// 	}
				// });
			$('#myModalx').modal('show'); 
			$('#myModalx').on('shown.bs.modal', function (e){});
			$('#myModalx').on('hidden.bs.modal', function (e) {
				tinymce.remove("#notaMedicaC");
				$(".modal-content").remove(); 
				$("#myModalx").empty();
				window.setTimeout(function(){
					if(tUser == "ENFERMERIA"){
						notasMedicasEnfermeria(id_h, id_p, nombre_p, id_s, estatus, tUser);
					}else{
						notasMedicas(id_h, id_p, nombre_p, id_s, estatus, tUser);
					}
				},300);
			});
		}});
	},300);
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

function tomar_sv(idP,control,idC, id_s, nombre_p){ //si control es 1 al cerrar la ventana abre VerSignos
	$('#idUsuario_sv').val($('#id_user').val()); $('#idUsuario_c').val($('#id_user').val()); $('#formSignosVitales').validator();
	$('#tabs_consulta .hide_nsv, #tabs_sv .hide_nsv').hide(); $('#titulo_toma_sv').html('TOMAR SIGNOS VITALES');
	$('#b_agregarSignosC, #salirSGconsulta, #salvarConsulta, #finalizarConsulta').addClass('hidden'); $('#btn_cancelar_sv, #btn_guardar_sv').removeClass('hidden');
	$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro, #notasSV').prop('readonly',''); 
	$('.escala_g').prop('disabled','');
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
		$('#tallaSV').keyup(function(e){//if( !parseFloat($(this).val()) ){ $('#tallaSV').val(''); }
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
			$('#b_agregarSignosC, #salirSGconsulta, #salvarConsulta, #finalizarConsulta').removeClass('hidden');
			$('#btn_cancelar_sv, #btn_guardar_sv').addClass('hidden');
			$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro, #notasSV').prop('readonly','readonly'); $('.escala_g').prop('disabled','disabled');
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
				if(data==1){ $('#btn_cancelar_sv').click();
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "Los signos vitales se han guardado satisfactoriamente.",
					  timer: 2500, showConfirmButton: false
					});$('#myModalx').modal('hide');
					if(!soloSV){
						nueva_nota(idC,idP,nombre_p,id_s); window.setTimeout(function(){$('#tab_sv_1').click();},1500);
					}
					soloSV = false;
				} else{alert(data);}
			});
		  }
		});
	});
}
	
function nueva_nota(id_h, id_p, nombre_p, id_s, tUser, tUser1){ $('#myModal').modal('hide'); window.setTimeout(function(){
	$("#myModalx").load('consultas/htmls/ficha_consulta.php', function( response, status, xhr ){ if(status=="success"){ tinymce.remove("#notaMedicaC");
		$('#titulo_modal').text('NOTA PARA EL PACIENTE '+nombre_p);
		$('#idUsuario_hc').val($('#id_user').val()); $('#id_cons').val(id_h); $('#idPaciente_c').val(id_p);
		//bloqueamos los campos que no son necesarios mantener abiertos para edición
		$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro').prop('readonly','readonly'); $('.escala_g').prop('disabled','disabled');
						
		$('#b_agregarSignosC').click(function(e) { tomar_sv(id_p,2,id_h, id_s, nombre_p); });
																													   
																													   
		$('#hospitalizarP, #tabs_receta, #tabs_imagenes, #finalizarConsulta').remove();
		$('#tabRevisiones').hide(); $('#imprimirNotaE').hide(); $('#imprimirRecetaF').hide();
		
		$("#tipoNotaMed").load("consultas/files-serverside/tNotaMedica.php?x="+$('#id_user').val(),function(response,status,xhr){ if(status=="success"){
			var datosT = {idP:id_p, idU:$('#id_user').val(), id_vc:id_h}
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
				var et_logoe_x = datosTe[44], et_logoee_x = datosTe[45], et_logogm_x = datosTe[46], et_historia_clinica_x = datosTe[52];
				var et_historia_clinica_AHF_x = datosTe[53], et_historia_clinica_APNP_x = datosTe[54], et_historia_clinica_APP_x = datosTe[55], et_historia_clinica_AGO_x = datosTe[56], et_Fnac = datosTe[57], et_dx = datosTe[58], et_Med = datosTe[59],et_destroxtis = datosTe[60], et_logo1 = datosTe[61],et_logo2 = datosTe[62],et_logo3 = datosTe[63],et_logo4 = datosTe[64],et_logo5 = datosTe[65],et_logo6 = datosTe[66],et_logo7 = datosTe[67],et_logo8 = datosTe[68],et_logo9 = datosTe[69],et_logo10 = datosTe[70],et_logo11 = datosTe[71],et_logo12 = datosTe[72],et_logo13 = datosTe[73],et_logo14 = datosTe[74],et_logo15 = datosTe[75];
				$("#tipoNotaMed").change(function(e) {//alert('Cambia');
					var datos = {idNM:$("#tipoNotaMed").val(),idC:id_h}
					$.post('consultas/files-serverside/textoNotaM.php',datos).done(function(data){ //alert(data);
						data = data.replace(/{ET_DIAGNOSTICO_PACIENTE}/gi, et_dx);
						data = data.replace(/{ET_MEDICAMENTOS_PACIENTE}/gi, et_Med);
						data = data.replace(/{ET_ALERGIAS}/gi, alergiasx);
						data = data.replace(/{et_destroxtis}/gi, et_destroxtis);
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
						data = data.replace(/{et_historia_clinica}/gi, et_historia_clinica_x);
						data = data.replace(/{et_historia_clinica_AHF}/gi, et_historia_clinica_AHF_x);
						data = data.replace(/{et_historia_clinica_APNP}/gi, et_historia_clinica_APNP_x);
						data = data.replace(/{et_historia_clinica_APP}/gi, et_historia_clinica_APP_x);
						data = data.replace(/{et_historia_clinica_AGO}/gi, et_historia_clinica_AGO_x);
						data = data.replace(/{et_logo1}/gi, et_logo1);
						data = data.replace(/{et_logo2}/gi, et_logo2);
						data = data.replace(/{et_logo3}/gi, et_logo3);
						data = data.replace(/{et_logo4}/gi, et_logo4);
						data = data.replace(/{et_logo5}/gi, et_logo5);
						data = data.replace(/{et_logo6}/gi, et_logo6);
						data = data.replace(/{et_logo7}/gi, et_logo7);
						data = data.replace(/{et_logo8}/gi, et_logo8);
						data = data.replace(/{et_logo9}/gi, et_logo9);
						data = data.replace(/{et_logo10}/gi, et_logo10);
						data = data.replace(/{et_logo11}/gi, et_logo11);
						data = data.replace(/{et_logo12}/gi, et_logo12);
						data = data.replace(/{et_logo13}/gi, et_logo13);
						data = data.replace(/{et_logo14}/gi, et_logo14);
						data = data.replace(/{et_logo15}/gi, et_logo15);
						tinymce.get('notaMedicaC').setContent(data);
						//$('#tabs_nnm #tabs-1n .jqte_editor').html(data);
					});
				});
			});
		}});
		var idCons = {idC:id_h} //Generamos la nota de evolución si nunca ha sido guardada la consulta
		$.post('consultas/files-serverside/notaInicial.php',idCons).done(function(data){ //alert(data);
			var datosNI=data.split(';*-');

			var datosT = {idP:id_p, idU:$('#id_user').val(), id_vc:id_h}
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
				var et_logoe_x = datosTe[44], et_logoee_x = datosTe[45], et_logogm_x = datosTe[46], et_historia_clinica_x = datosTe[52];
				var et_historia_clinica_AHF_x = datosTe[53], et_historia_clinica_APNP_x = datosTe[54], et_historia_clinica_APP_x = datosTe[55], et_historia_clinica_AGO_x = datosTe[56];
				var data = datosNI[1],et_Fnac = datosTe[57], et_dx = datosTe[58], et_Med = datosTe[59], et_destroxtis = datosTe[60], et_logo1 = datosTe[61],et_logo2 = datosTe[62],et_logo3 = datosTe[63],et_logo4 = datosTe[64],et_logo5 = datosTe[65],et_logo6 = datosTe[66],et_logo7 = datosTe[67],et_logo8 = datosTe[68],et_logo9 = datosTe[69],et_logo10 = datosTe[70],et_logo11 = datosTe[71],et_logo12 = datosTe[72],et_logo13 = datosTe[73],et_logo14 = datosTe[74],et_logo15 = datosTe[75]; 

				data = data.replace(/{ET_DIAGNOSTICO_PACIENTE}/gi, et_dx);
				data = data.replace(/{ET_MEDICAMENTOS_PACIENTE}/gi, et_Med);
				data = data.replace(/{ET_ALERGIAS}/gi, alergiasx);
				data = data.replace(/{et_destroxtis}/gi, et_destroxtis);
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
				data = data.replace(/{et_historia_clinica}/gi, et_historia_clinica_x);
				data = data.replace(/{et_historia_clinica_AHF}/gi, et_historia_clinica_AHF_x);
				data = data.replace(/{et_historia_clinica_APNP}/gi, et_historia_clinica_APNP_x);
				data = data.replace(/{et_historia_clinica_APP}/gi, et_historia_clinica_APP_x);
				data = data.replace(/{et_historia_clinica_AGO}/gi, et_historia_clinica_AGO_x);
				data = data.replace(/{et_logo1}/gi, et_logo1);
				data = data.replace(/{et_logo2}/gi, et_logo2);
				data = data.replace(/{et_logo3}/gi, et_logo3);
				data = data.replace(/{et_logo4}/gi, et_logo4);
				data = data.replace(/{et_logo5}/gi, et_logo5);
				data = data.replace(/{et_logo6}/gi, et_logo6);
				data = data.replace(/{et_logo7}/gi, et_logo7);
				data = data.replace(/{et_logo8}/gi, et_logo8);
				data = data.replace(/{et_logo9}/gi, et_logo9);
				data = data.replace(/{et_logo10}/gi, et_logo10);
				data = data.replace(/{et_logo11}/gi, et_logo11);
				data = data.replace(/{et_logo12}/gi, et_logo12);
				data = data.replace(/{et_logo13}/gi, et_logo13);
				data = data.replace(/{et_logo14}/gi, et_logo14);
				data = data.replace(/{et_logo15}/gi, et_logo15);

				$('#notaMedicaC').val(data);
			});
		});
																													   
		//Cargamos los datos de los Signos Vitales y Cargamos los datos de Historia Clínica
		cargar_todo_signos_vitales(id_p,id_h); cargar_todo_historia_clinica(id_p,id_h,id_s,nombre_p);
																													   
		//Para que nos ponga el número de cosas que hay en los historiales en los botones
		var idPx = {idP:id_p}
		$.post('consultas/files-serverside/datosBotonesHistoriales.php',idPx).done(function(data){
			var datosBP = data.split(';*-'); //alert(data); HC <span class="badge">4</span>
			$('#verHistorialLabC').html('LAB <span class="badge">'+datosBP[0]+'</span>');
			if(datosBP[0]<1){$('#verHistorialLabC').addClass('disabled');}
			$('#verHistorialUsgC').html('USG <span class="badge">'+datosBP[1]+'</span>');
			if(datosBP[1]<1){$('#verHistorialUsgC').addClass('disabled');}
			$('#verHistorialImgC').html('IMG <span class="badge">'+datosBP[2]+'</span>');
			if(datosBP[2]<1){$('#verHistorialImgC').addClass('disabled');}
			$('#verHistorialEndC').html('END <span class="badge">'+datosBP[3]+'</span>');
			if(datosBP[3]<1){$('#verHistorialEndC').addClass('disabled');}
			$('#verHistorialColC').html('COL <span class="badge">'+datosBP[4]+'</span>');
			if(datosBP[4]<1){$('#verHistorialColC').addClass('disabled');}
			$('#verHistorialOtrosC').html('OTROS <span class="badge">'+datosBP[5]+'</span>');
			if(datosBP[5]<1){$('#verHistorialOtrosC').addClass('disabled');}
			$('#verHistorialNotasC').html('CNTS <span class="badge">'+datosBP[6]+'</span>');
			if(datosBP[6]<1){$('#verHistorialNotasC').addClass('disabled');}
			cargar_historiales(id_p,id_h);
		});

		window.setTimeout(function(){
			tinymce.init({ 
				selector:'#notaMedicaC',resize:false,height:$('#myModalx').height()*0.45,theme: "modern",
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
						text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
						onclick:function(){
							var res = tinyMCE.get("notaMedicaC").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
							$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
							$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
						}
					});
				}
			});
		},400);
		$('#salirSGconsulta').click(function(e){ window.setTimeout(function(){
			if(tUser1 == "ENFERMERIA"){
				notasMedicasEnfermeria(id_h, id_p, nombre_p, id_s,'HOSPITALIZADO',tUser);
			}else{
				notasMedicas(id_h, id_p, nombre_p, id_s,'HOSPITALIZADO',tUser);
			}
		},400); });
		$('#salvarConsulta').click(function(e) { salvarConsulta(id_h, id_p, $("#tipoNotaMed").val(), nombre_p, id_s, tUser, tUser1); });
		$('#print_SignosV').click(function(e) { 
			imprimirSV(id_p,id_h);
		});
	
		$('#myModalx').modal('show'); $('#myModalx').on('shown.bs.modal', function (e) { });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); tinymce.remove("#notaMedicaC"); });
	}});		
},400); }
	
function salvarConsulta(idC, idP, idN, nombre_p, id_s, tUser,tUser1){
	var str = tinyMCE.get('notaMedicaC').getContent(); 
	var datosGC = { idC:idC, idU:$('#id_user').val(), notaDictamen:str, idP:idP, idN:idN } 
	$.post('hospital/files-serverside/salvarNota.php',datosGC).done(function(data){ if(data == 1){ $('#clickme, #clickmeFmts').click();
		swal({ title:"",type:"success",text:"LOS DATOS DE LA NOTA HAN SIDO GUARDADOS.", timer:2000,showConfirmButton:false }); $('#myModalx').modal('hide');
		window.setTimeout(function(){
			if(tUser1 == "ENFERMERIA"){
				notasMedicasEnfermeria(idC, idP, nombre_p, id_s,'HOSPITALIZADO',tUser);
			}else{
				notasMedicas(idC, idP, nombre_p, id_s,'HOSPITALIZADO',tUser);
			}
				
			},500);
	}else{alert(data);} });
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
		$('#temp0').text(datos[11]); $('#peso0').text(datos[3]); $('#talla0').text(datos[4]); $('#imc0').text(datos[5]);$('#dex0').text(datos[25]);
		
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
				data: { columns: [ myvalues_1 ] }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[5], end: datosCH4[6], class: 'regionY'} ]
			});
			var chart1 = c3.generate({ bindto: '#myChart1',
				data: { columns: [ myvalues_1 ] }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[5], end: datosCH4[6], class: 'regionY'} ]
			});
			
			var myvalues1 = JSON.parse(datosCH4[7]); //alert(myvalues);
			$('#graficaFR').sparkline(myvalues1, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[8], normalRangeMax:datosCH4[9], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues1_1 = JSON.parse(datosCH4[28]); //alert(datosCH4[8]+';'+datosCH4[9]);
			var chart = c3.generate({ bindto: '#myChartFR',
				data: { columns: [ myvalues1_1 ] }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[8], end: datosCH4[9], class: 'regionY'} ]
			});
			var chart2 = c3.generate({ bindto: '#myChart2',
				data: { columns: [ myvalues1_1 ] }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[8], end: datosCH4[9], class: 'regionY'} ]
			});
			
			var myvalues2 = JSON.parse(datosCH4[10]); var dcT = datosCH4[10].split('['); var dcTx = dcT[1].split(']');
			$('#graficaT').sparkline(myvalues2, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[11], normalRangeMax:datosCH4[12], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues2_1 = JSON.parse(datosCH4[26]); //alert(myvalues2_1);
			var chart = c3.generate({ bindto: '#myChartT1',
				data: { columns: [ myvalues2_1 ] }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[11], end: datosCH4[12], class: 'regionY'} ]
			});
			var chart3 = c3.generate({ bindto: '#myChart3',
				data: { columns: [ myvalues2_1 ] }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[11], end: datosCH4[12], class: 'regionY'} ]
			});

			var myvalues3 = JSON.parse(datosCH4[13]);
			$('#graficaTA').sparkline(myvalues3, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[14], normalRangeMax:datosCH4[15], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues3_1 = JSON.parse(datosCH4[27]); //alert(myvalues2_1);
			var chart = c3.generate({ bindto: '#myChartTA',
				data: { columns: [ myvalues3_1 ] }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: datosCH4[14], end: datosCH4[15], class: 'regionY'} ]
			});
			var chart4 = c3.generate({ bindto: '#myChart4',
				data: { columns: [ myvalues3_1 ] }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: datosCH4[14], end: datosCH4[15], class: 'regionY'} ]
			});
		
			var myvalues4 = JSON.parse(datosCH4[16]);
			$('#graficaTemp').sparkline(myvalues4, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[17], normalRangeMax:datosCH4[18], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues4_1 = JSON.parse(datosCH4[31]);
			var chart = c3.generate({ bindto: '#myChartT',
				data: { columns: [ myvalues4_1 ] }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			var chart5 = c3.generate({ bindto: '#myChart5',
				data: { columns: [ myvalues4_1 ] }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			
			var myvalues5 = JSON.parse(datosCH4[19]);
			$('#graficaPESO').sparkline(myvalues5, {type: 'line', barColor: 'green', width:'3em', height:'2em', fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues5_1 = JSON.parse(datosCH4[32]);
			var chart6 = c3.generate({ bindto: '#myChart6',
				data: { columns: [ myvalues5_1 ] }, size: { height: h_g1, width: w_g1 },
				//regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			
			var myvalues6 = JSON.parse(datosCH4[22]);
			$('#graficaTALLA').sparkline(myvalues6, {type: 'line', barColor: 'green', width:'3em', height:'2em', fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues6_1 = JSON.parse(datosCH4[33]);
			var chart7 = c3.generate({ bindto: '#myChart7',
				data: { columns: [ myvalues6_1 ] }, size: { height: h_g1, width: w_g1 },
				//regions: [ {axis: 'y', start: 36.5, end: 37.5, class: 'regionY'} ]
			});
			
			var myvalues7 = JSON.parse(datosCH4[23]);
			$('#graficaIMC').sparkline(myvalues7, {type: 'line', barColor: 'green', width:'3em', height:'2em', normalRangeMin:datosCH4[24], normalRangeMax:datosCH4[25], fillColor: false, maxSpotColor:'red', minSpotColor:'orange', highlightSpotColor:'gold'} );
			var myvalues7_1 = JSON.parse(datosCH4[30]); 
			var chart = c3.generate({ bindto: '#myChartIMC',
				data: { columns: [ myvalues7_1 ] }, size: { height: h_g, width: w_g },
				regions: [ {axis: 'y', start: 18.50, end: 25, class: 'regionY'} ]
			});
			var chart8 = c3.generate({ bindto: '#myChart8',
				data: { columns: [ myvalues7_1 ] }, size: { height: h_g1, width: w_g1 },
				regions: [ {axis: 'y', start: 18.50, end: 25, class: 'regionY'} ]
			});
		});
		//Gráficas grandes FIN
	});
}
function cargar_todo_historia_clinica(idP,idC,id_s,nombre_p){
	$('#tHC input, #tHC select, #tHC textarea').prop('disabled',true);
	$('#b_editarHC').click(function(e) { tomar_historia_clinica(idP, idC,id_s,nombre_p); });
	
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
function tomar_historia_clinica(idP, idC,id_s,nombre_p){
	$('#formHistoriaClinica').validator(); $('#mi_tab_hc1').click(); $('#idPaciente_hc').val(idP);
	$('#tHC input, #tHC select, #tHC textarea').prop('disabled',false); $('#b_actualizarHC, #b_cancelHC').removeClass('hidden'); 
	$('#b_editarHC, #salirSGconsulta, .hide_nhc, #datos_toma_hc, #salirSGconsulta, #salvarConsulta, #finalizarConsulta').addClass('hidden');
	
	$('#b_cancelHC').click(function(e) {
		$('#tHC input, #tHC select, #tHC textarea').prop('disabled',true); $('#mi_tab_hc1').click();
		$('#b_actualizarHC, #b_cancelHC').addClass('hidden'); 
		$('#b_editarHC, #salirSGconsulta, .hide_nhc, #datos_toma_hc, #salirSGconsulta, #salvarConsulta, #finalizarConsulta').removeClass('hidden');
		cargar_todo_historia_clinica(idP,idC,id_s);
	});
	
	$('#formHistoriaClinica').validator().on('submit', function (e) {
	  if (e.isDefaultPrevented()) { // handle the invalid form...
	  } else { // everything looks good!
		e.preventDefault(); //var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
		var datos = $('#formHistoriaClinica').serialize();
		$.post('consultas/files-serverside/actualizarHC.php',datos).done(function(data){ if(data==1){ $('#b_cancelHC').click();
			swal({
			  title: "¡CONFIRMACIÓN!", type: "success", text: "La historia clínica se ha guardado satisfactoriamente.", timer: 2500, showConfirmButton: false
			});$('#myModalx').modal('hide');
			window.setTimeout(function(){ nueva_nota(idC,idP,nombre_p,id_s);
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
function cargar_historiales(idP,idC){
	//para Laboratorio
	var oTableHLa;
	oTableHLa = $('#dataTableHLab').DataTable({
		"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay){ 
			$('#id_primer_vc').val(aaData[0][11]); $('#nombre_primer_vc').val(aaData[0][12]);
		}, 
		ordering: false, scrollCollapse: false,
		"destroy": true, "bRetrieve": true, "sScrollY": $('#myModalx').height()-350, "scrollX": true, 
		"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [ { "bSortable": false }, { "bSortable": false }, { "bSortable": false } ],
		"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": 'lrtS',
		 "sAjaxSource": "consultas/datatable-serverside/historial_laboratorio.php", deferRender: true, select:false,
		"fnServerParams":function(aoData,fnCallback){ 
			var aleatorio = idP; 
			aoData.push({"name": "aleatorio", "value": idP }); 
			aoData.push({"name": "idCo", "value": idC });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage":{
			"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO DE LABORATORIO",
			"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS DE LABORATORIO: _MAX_","sSearch": "BUSCAR" 
		}
	}); $('#clickmeHLab').click(function(e){ oTableHLa.draw(); });
	//Fin del expediente de Laboratorio
	//para USG
	var oTableUSG;
	oTableUSG = $('#dataTableHusg').DataTable({
		"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay){ 
			$('#id_primer_vc').val(aaData[0][11]); $('#nombre_primer_vc').val(aaData[0][12]); //alert(aaData[1][11]);
		}, 
		ordering: false, scrollCollapse: false,
		"destroy": true, "bRetrieve": true, "sScrollY": $('#myModalx').height()-350, "scrollX": true, 
		"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [ { "bSortable": false }, { "bSortable": false }, { "bSortable": false } ],
		"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": 'lrtS',
		 "sAjaxSource": "consultas/datatable-serverside/historial_ultrasonido.php", deferRender: true, select:false,
		"fnServerParams":function(aoData,fnCallback){ 
			var aleatorio = idP; 
			aoData.push({"name": "aleatorio", "value": idP }); aoData.push({"name": "idCo", "value": idC });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage":{
			"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO DE ULTRASONIDO",
			"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS DE ULTRASONIDO: _MAX_","sSearch": "BUSCAR" 
		}
	}); $('#clickmeHusg').click(function(e){ oTableUSG.draw(); });
	//Fin del expediente de USG
	//para IMG
	var oTableIMG;
	oTableIMG = $('#dataTableHimg').DataTable({
		"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay){ 
			$('#id_primer_vc').val(aaData[0][11]); $('#nombre_primer_vc').val(aaData[0][12]); //alert(aaData[1][11]);
		}, 
		ordering: false, scrollCollapse: false,
		"destroy": true, "bRetrieve": true, "sScrollY": $('#myModalx').height()-350, "scrollX": true, 
		"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [ { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false } ],
		"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": 'lrtS',
		 "sAjaxSource": "consultas/datatable-serverside/historial_imagenologia.php", deferRender: true, select:false,
		"fnServerParams":function(aoData,fnCallback){ 
			var aleatorio = idP; 
			aoData.push({"name": "aleatorio", "value": idP }); aoData.push({"name": "idCo", "value": idC });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage":{
			"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO DE ESTUDIOS DE IMAGEN",
			"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS DE IMAGEN: _MAX_","sSearch": "BUSCAR" 
		}
	}); $('#clickmeHimg').click(function(e){ oTableIMG.draw(); });
	//Fin del expediente de IMG
	//para END
	var oTableEnd;
	oTableEnd = $('#dataTableHend').DataTable({
		"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay){ 
			$('#id_primer_vc').val(aaData[0][11]); $('#nombre_primer_vc').val(aaData[0][12]); //alert(aaData[1][11]);
		}, 
		ordering: false, scrollCollapse: false,
		"destroy": true, "bRetrieve": true, "sScrollY": $('#myModalx').height()-350, "scrollX": true, 
		"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [ { "bSortable": false }, { "bSortable": false }, { "bSortable": false } ],
		"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": 'lrtS',
		"sAjaxSource": "consultas/datatable-serverside/historial_endoscopia_h.php", deferRender: true, select:false,
		"fnServerParams":function(aoData,fnCallback){ 
			var aleatorio = idP; 
			aoData.push({"name": "aleatorio", "value": idP }); aoData.push({"name": "idCo", "value": idC });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage":{
			"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO DE ESTUDIOS DE ENDOSCOPÍA",
			"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS DE ENDOSCOPÍA: _MAX_","sSearch": "BUSCAR" 
		}
	}); $('#clickmeHend').click(function(e){ oTableEnd.draw(); });
	//Fin del expediente de END
	//para COL
	var oTableCol;
	oTableCol = $('#dataTableHcol').DataTable({
		"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay){ 
			$('#id_primer_vc').val(aaData[0][11]); $('#nombre_primer_vc').val(aaData[0][12]); //alert(aaData[0][12]);
		}, 
		ordering: false, scrollCollapse: false,
		"destroy": true, "bRetrieve": true, "sScrollY": $('#myModalx').height()-350, "scrollX": true, 
		"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [ { "bSortable": false }, { "bSortable": false }, { "bSortable": false } ],
		"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": 'lrtS',
		"sAjaxSource": "consultas/datatable-serverside/historial_colposcopia.php", deferRender: true, select:false,
		"fnServerParams":function(aoData,fnCallback){ 
			var aleatorio = idP; 
			aoData.push({"name": "aleatorio", "value": idP }); aoData.push({"name": "idCo", "value": idC });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage":{
			"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO DE ESTUDIOS DE COLPOSCOPÍA",
			"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>ESTUDIOS DE COLPOSCOPÍA: _MAX_","sSearch": "BUSCAR" 
		}
	}); $('#clickmeHcol').click(function(e){ oTableCol.draw(); });
	//Fin del expediente de COL
	//para NOT
	var oTableNot;
	oTableNot = $('#dataTableHnot').DataTable({
		"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay){ 
			$('#id_primer_vc').val(aaData[0][11]); $('#nombre_primer_vc').val(aaData[0][12]); //alert(aaData[0][12]);
		}, 
		ordering: false, scrollCollapse: false,
		"destroy": true, "bRetrieve": true, "sScrollY": $('#myModalx').height()-350, "scrollX": true, 
		"bAutoWidth":true,"bStateSave": false, "bInfo":true,"bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [ { "bSortable": false }, { "bSortable": false }, { "bSortable": false } ],
		"iDisplayLength": 30000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": 'lrtS',
		"sAjaxSource": "consultas/datatable-serverside/historial_notasmedicas.php", deferRender: true, select:false,
		"fnServerParams":function(aoData,fnCallback){ 
			var aleatorio = idP; 
			aoData.push({"name": "aleatorio", "value": idP }); aoData.push({"name": "idCo", "value": idC });
		},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage":{
			"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"EL PACIENTE NO CUENTA CON UN HISTORIAL CLÍNICO DE CONSULTAS MÉDICAS",
			"sInfo":"MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>CONSULTAS MÉDICAS: _MAX_","sSearch": "BUSCAR" 
		}
	}); $('#clickmeHnot').click(function(e){ oTableNot.draw(); });
	//Fin del expediente de COL
	$('#tHLab,#tHusg,#tHusg1,#tHimg,#tHimg1,#tHimg2,#tHend,#tHend1,#tHcol,#tHcol1,#tHnot,#tHnot1,#tHnot2').height($('#myModalx').height()-350);
}

var recognition, recognizing = false;
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
		$('#dictado').html('<span class="ui-icon ui-icon-pencil"></span> INICIAR DICTADO');
		console.log("terminó de eschucar, llegó a su fin");
	}
}

function procesarV() {
	if(recognizing==false){ recognition.start();recognizing=true; $('#dictado').html('<span class="ui-icon ui-icon-pencil"></span> DETENER DICTADO'); }
	else{recognition.stop();recognizing=false;$('#dictado').html('<span class="ui-icon ui-icon-pencil"></span> INICIAR DICTADO');}
}

function insertAtCaret(text) { tinymce.get("notaMedicaC").execCommand('mceInsertContent', false, text); }
function insertAtCaret1(text) { tinymce.get("indiF").execCommand('mceInsertContent', false, text); }

function graficas(o){
	$('.no_graf, #salirSGconsulta').addClass('hidden'); $('.si_graf').removeClass('hidden');
	window.setTimeout(function(){$('#mi_tab_grafs').click();},200);
	switch(o){
		case 1: $('#tab_grafi_1').click(); break; case 2: $('#tab_grafi_2').click(); break; case 3: $('#tab_grafi_3').click(); break;
		case 4: $('#tab_grafi_4').click(); break; case 5: $('#tab_grafi_5').click(); break; case 6: $('#tab_grafi_6').click(); break;
		case 7: $('#tab_grafi_7').click(); break; case 8: $('#tab_grafi_8').click(); break;
	}
}
function no_graficas(){
	$('.no_graf, #salirSGconsulta').removeClass('hidden'); $('.si_graf').addClass('hidden');
	window.setTimeout(function(){$('#my_tb_nm').click();},200);
}
function historiales(o){
	$('.no_histo, #salirSGconsulta, #salvarConsulta').addClass('hidden'); $('.si_histo').removeClass('hidden');
	window.setTimeout(function(){$('#mi_tab_histo').click();},200);
	var datosH = {idP:$('#idPaciente_c').val(), idE:$('#id_cons').val()}
	$.post('consultas/files-serverside/datosHistorial.php',datosH).done(function(data){ var datosH = data.split('*;');
		$('#tHisto1').html(datosH[3]);
	});
					
	switch(o){
		case 1: 
			$('#tab_histo_1').click();
		break; 
		case 2: $('#tab_histo_2').click();
			window.setTimeout(function(){ $('#clickmeHLab, #tab_histo_lab').click();
				window.setTimeout(function(){ rhLab($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },100);
			},500);
		break;
		case 3: $('#tab_histo_3').click(); 
			window.setTimeout(function(){ $('#clickmeHusg, #tab_histo_usg').click();
				window.setTimeout(function(){ rhUsg($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },100);
			},500);
		break;
		case 4: $('#tab_histo_4').click();
			window.setTimeout(function(){ $('#clickmeHimg, #tab_histo_img').click();
				window.setTimeout(function(){ rhImg($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },100);
			},500);
		break; 
		case 5: $('#tab_histo_5').click(); 
			window.setTimeout(function(){ $('#clickmeHend, #tab_histo_end').click();
				window.setTimeout(function(){ rhEnd($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },100);
			},500);
		break;
		case 6: $('#tab_histo_6').click();
			window.setTimeout(function(){ $('#clickmeHcol, #tab_histo_col').click();
				window.setTimeout(function(){ rhCol($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },100);
			},500);
		break;
		case 7: $('#tab_histo_7').click();
			window.setTimeout(function(){ $('#clickmeHnot, #tab_histo_not').click();
				window.setTimeout(function(){ rhNot($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },100);
			},500);
		break;
	}
	$('#tab_histo_2').click(function(e){ $('#clickmeHLab').click();
		window.setTimeout(function(){ rhLab($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },300);
	});
	$('#tab_histo_3').click(function(e){ $('#clickmeHusg').click();
		window.setTimeout(function(){ rhUsg($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },300);
	});
	$('#tab_histo_4').click(function(e){ $('#clickmeHimg').click();
		window.setTimeout(function(){ rhImg($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },300);
	});
	$('#tab_histo_5').click(function(e){ $('#clickmeHend').click();
		window.setTimeout(function(){ rhEnd($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },300);
	});
	$('#tab_histo_6').click(function(e){ $('#clickmeHcol').click();
		window.setTimeout(function(){ rhCol($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },300);
	});
	$('#tab_histo_7').click(function(e){ $('#clickmeHnot').click();
		window.setTimeout(function(){ rhNot($('#id_cons').val(),$('#idPaciente_c').val(),$('#nombre_primer_vc').val(),$('#id_primer_vc').val()); },300);
	});
}
function no_historiales(){
	$('.no_histo, #salirSGconsulta, #salvarConsulta').removeClass('hidden'); $('.si_histo').addClass('hidden');
	window.setTimeout(function(){$('#my_tb_nm').click();},200);
}
function rhNot(idC,idP,n,idE){//alert(idC+' '+idP+' '+n+' '+idE); consultas/img_cslta
	$('.'+idE+'').parent().addClass('bg-success');
	
	var datoP = {idP:idP, idE:idE}
	$.post('consultas/files-serverside/datosInterpretarHn1.php', datoP).done(function( data ) { 
		var datosU = data.split(';*-');
		var str = datosU[6].replace('src="../../../usuarios/','src="usuarios/');
		var res = str;
		var res = res.replace(/..\/..\/..\/consultas\/img_cslta/g,'consultas/img_cslta');
		var res = res.replace(/[?]\d{14}/g,'');
		$('#dx_ehn').html(res); $('#doctor_ehn').html(datosU[9]); $('#dx_ehn1').html(datosU[16]);
		window.setTimeout(function(){cargarImagenesCanvas4(idE);},700);
	});
					
	$('#idControl').val(idE);
	$('.histol').each(function(index, element) {
		if($(this).hasClass(idE)){ $(this).parent().addClass('bg-success');}else{$(this).parent().removeClass('bg-success'); }
	});
}
function rhCol(idC,idP,n,idE){//alert(idC+' '+idP+' '+n+' '+idE);
	$('.'+idE+'').parent().addClass('bg-success');
	
	var datoP = {idP:idP, idE:idE}
	$.post('consultas/files-serverside/datosInterpretarHc1.php', datoP).done(function( data ) { 
		var datosU = data.split(';*-');
		var str = datosU[3].replace('src="../../../usuarios/','src="usuarios/');
		var res = str;
		var res = res.replace(/..\/..\/..\/imagen\/img_colpo/g,'imagen/img_colpo');
		var res = res.replace(/[?]\d{14}/g,'');
		$('#dx_ehc').html(res); $('#doctor_ehc').html(datosU[9]);
		window.setTimeout(function(){cargarImagenesCanvas3(idE);},700);
	});
					
	$('#idControl').val(idE);
	$('.histol').each(function(index, element) {
		if($(this).hasClass(idE)){ $(this).parent().addClass('bg-success');}else{$(this).parent().removeClass('bg-success'); }
	});
}
function rhEnd(idC,idP,n,idE){//alert(idC+' '+idP+' '+n+' '+idE);
	$('.'+idE+'').parent().addClass('bg-success');
	
	var datoP = {idP:idP, idE:idE}
	$.post('consultas/files-serverside/datosInterpretarHe1.php', datoP).done(function( data ) { 
		var datosU = data.split(';*-');
		var str = datosU[3].replace('src="../../../usuarios/','src="usuarios/');
		var res = str;
		var res = res.replace(/..\/..\/..\/imagen\/img_endo/g,'imagen/img_endo');
		var res = res.replace(/[?]\d{14}/g,'');
		$('#dx_ehe').html(res);
		window.setTimeout(function(){cargarImagenesCanvas2(idE);},700);
	});
	$('#idControl').val(idE);
	$('.histol').each(function(index, element) {
		if($(this).hasClass(idE)){ $(this).parent().addClass('bg-success');}else{$(this).parent().removeClass('bg-success'); }
	});
}
function rhImg(idC,idP,n,idE){//alert(idC+' '+idP+' '+n+' '+idE);
	var datosL = { idP:idP, idC:idE }
	$.post('consultas/files-serverside/datosIMG.php',datosL).done(function(dataL){ //alert(dataL);
		if(dataL == 8){// Es pdf
			var x='imagen/takeArchivos/pdf/'+idE+'.pdf';
			$("#tHimg").load('laboratorio/htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { 
				if ( status == "success" ) { $('a.media').media({width:$('#tHimg').width()*0.99, height:$('#tHimg').height()*0.99, src:x}); } 
			});
		}else{
			$("#tHimg").load('laboratorio/htmls/img_history.php', function(response,status,xhr){ if(status=="success"){
				$('.'+idE+'').parent().addClass('bg-success'); //alert(2);
			
				var datoP = {idP:idP, idE:idE}
				$.post('consultas/files-serverside/datosInterpretarHi1.php', datoP).done(function( data ) { 
					var datosU = data.split(';*-');
					var str = datosU[3].replace('src="../../../usuarios/','src="usuarios/');
					var res = str;
					$('#dx_ehi').html(res); $('#doctor_ehi').html(datosU[9]);
					window.setTimeout(function(){cargarImagenesCanvas1(idE);},700);
				});
								
				$('#idControl').val(idE);
				$('.histol').each(function(index, element) {
					if($(this).hasClass(idE)){ $(this).parent().addClass('bg-success');}else{$(this).parent().removeClass('bg-success'); }
				});
			}});
		}
	});
}
function rhUsg(idC,idP,n,idE){//alert(idC+' '+idP+' '+n+' '+idE);
	$('.'+idE+'').parent().addClass('bg-success');

	var datoP = {idP:idP, idE:idE}
	$.post('consultas/files-serverside/datosInterpretarHu1.php', datoP).done(function( data ) { 
		var datosU = data.split(';*-');
		var str = datosU[3].replace('src="../../../usuarios/','src="usuarios/');
		var res = str;
		var res = res.replace(/..\/..\/..\/imagen\/img_usg/g,'imagen/img_usg');
		var res = res.replace(/[?]\d{14}/g,'');
		$('#dx_ehu').html(res); $('#doctor_ehu').html(datosU[9]);
		window.setTimeout(function(){cargarImagenesCanvas(idE);},700);
	});
					
	$('#idControl').val(idE);
	$('.histol').each(function(index, element) {
		if($(this).hasClass(idE)){ $(this).parent().addClass('bg-success');}else{$(this).parent().removeClass('bg-success'); }
	});
}
function cargarImagenesCanvas(i){
	$("#deCanvas1").load("consultas/files-serverside/procesa.php?action=listFotos1&carpeta="+i,function(response,status,xhr){}); 
	window.setTimeout(function(){ $('#deCanvas1c').css('height',100).css('overflow','scroll');},500);
}
function cargarImagenesCanvas1(i){ $("#deCanvas2i").load("consultas/files-serverside/procesaI.php?action=listFotos1&carpeta="+i,function(response,status,xhr){});  }
function cargarImagenesCanvas2(i){ $("#deCanvas1e").load("consultas/files-serverside/procesaE.php?action=listFotos1&carpeta="+i,function(response,status,xhr){});  }
function cargarImagenesCanvas3(i){ $("#deCanvas1c").load("consultas/files-serverside/procesaCo.php?action=listFotos1&carpeta="+i,function(response,status,xhr){});  }
function cargarImagenesCanvas4(i){ $("#deCanvas1n").load("consultas/files-serverside/procesaC.php?action=listFotos1&carpeta="+i,function(response,status,xhr){});  }
	
function histo_pacs(mi_refer1){
	var url=window.location.href, myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888');
	var link_1 = koby[0]+koby[1];
	var mi_refer = mi_refer1.replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');
	window.open('http://'+koby[0]+':8080/oviyam2/viewer.html?patientID='+mi_refer);
}
function miImg(idM,opc){
	$('.si_img_h').removeClass('hidden'); $('.no_img_h').addClass('hidden'); //$('#tab_histo_8').click(); //alert(opc);
	$('#indicador_histo').val(opc); var he = $('#tHisto').width()*0.9;
	$('#mostrar_img_histor').html('<img width="" height="" style="border:1px solid black;max-width:'+he+'px;" src="'+idM+'">');
}
function no_img_h(){ $('.si_img_h').addClass('hidden'); $('.no_img_h').removeClass('hidden'); }

function rhLab(idC,idP,n,idE){//alert(idC+' '+idP+' '+n+' '+idE);
	var datosL = { idP:idP, idC:idC }
	$.post('consultas/files-serverside/datosLab.php',datosL).done(function(dataL){
		var datoL = dataL.split('{;}');
		if(datoL[1] == 8){// Es pdf
			var x='laboratorio/takeArchivos/pdf/'+idE+'.pdf';
			$("#tHLab").load('laboratorio/htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { 
				if ( status == "success" ) { $('a.media').media({width:$('#tHLab').width()*0.99, height:$('#tHLab').height()*0.99, src:x}); } 
			});
		}else{
			$("#tHLab").load('laboratorio/htmls/lab_history.php', function(response,status,xhr){ if(status=="success"){
				$('#idPacientePro').val(idP); $('#idEstudioPro').val(idC); $('.cargaPDF').hide();
				$('.'+idE+'').parent().addClass('bg-success');
				var datoP = {idP:idP, idE:idC}
				$.post('laboratorio/archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
					var datosP = data.split('*}'); 
					$('.tr_observaciones, .notas_tm').hide();
					$("#misResultados").load('laboratorio/files-serverside/resultados_h.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { $('.ocultarX').hide(); } });//alert(n);
					//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
					switch(n){
						case 'BIOMETRIA HEMATICA':
							$(".myDiagnosticoP").load('laboratorio/files-serverside/imprimirResultadosBH.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
							$("#misResultados").load('laboratorio/files-serverside/resultadosBH_h.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
						break;
						case 'EXAMEN GENERAL DE ORINA':
							$(".myDiagnosticoP").load('laboratorio/files-serverside/imprimirResultadosEGO.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
							$("#misResultados").load('laboratorio/files-serverside/resultadosEGO_h.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
						break;
						case 'COPROLOGICO':
							$(".myDiagnosticoP").load('laboratorio/files-serverside/imprimirResultadosCoprologico.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
							$("#misResultados").load('laboratorio/files-serverside/interpretarResultadosCoprologico_h.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
						break;
						case 'COPROPARASITOSCOPICO UNICO':
							$(".myDiagnosticoP").load('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio1.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
							$("#misResultados").load('laboratorio/files-serverside/resultadosCoproparasitoscopio1.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
						break;
						case 'COPROPARASITOSCOPICO (2M)':
							$(".myDiagnosticoP").load('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio2.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
							$("#misResultados").load('laboratorio/files-serverside/resultadosCoproparasitoscopio2.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
						break;
						case 'COPROPARASITOSCOPICO SERIADO':
							$(".myDiagnosticoP").load('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+idE, function(response,status,xhr){if ( status == "success" ){ } });
							$("#misResultados").load('laboratorio/files-serverside/resultadosCoproparasitoscopio3.php?idE='+idE, function(response,status,xhr){if ( status == "success" ){ } });
						break;
						case 'COPROPARASITOSCOPIO (3)':
							$(".myDiagnosticoP").load('laboratorio/files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
							$("#misResultados").load('laboratorio/files-serverside/resultadosCoproparasitoscopio3.php?idE='+idE, function(response,status,xhr){if ( status == "success" ) { } });
						break;
						default:
							$(".myDiagnosticoP").load('laboratorio/files-serverside/resultados_h.php?idE='+idE,function(response,status,xhr){if( status == "success" ) { 
							} });
					}
				});
			} });
		}
	});
	$('#idControl').val(idE);
	$('.histol').each(function(index, element) {
		if($(this).hasClass(idE)){ $(this).parent().addClass('bg-success');}else{$(this).parent().removeClass('bg-success'); }
	});
}
var soloSV = false;
function verSignosV(idP,idC,opc,concept,id_s,estat){
	var datosCon = {idP:idP, idC:idC}
	$.post('enfermeria/files-serverside/datosSV.php',datosCon).done(function(data){var datos=data.split(';*-');
		$("#myModalx").load('consultas/htmls/ficha_consulta.php',function(response,status,xhr){ if(status=="success"){
			$('#titulo_modal').text('PACIENTE: '+datos[22]+' - EDAD: '+datos[1]+' - SEXO: '+datos[2]+' | FECHA: '+datos[24]);
			$('#idUsuario_hc').val($('#id_user').val()); $('#id_cons').val(idC); $('#idPaciente_c').val(idP);
			$('.hsh, .btns-consulta').remove(); 
			window.setTimeout(function(){ if(opc==0){$('#tab_sv_1').click();} else if(opc==1){$('#tab_my_hc_x').click();} },500);
			
			//bloqueamos los campos que no son necesarios mantener abiertos para edición
			$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro').prop('readonly','readonly');
			$('.escala_g').prop('disabled','disabled');
			
			$('#b_agregarSignosC').click(function(e) { tomar_sv(idP,2,idC, id_s); });

			$('#print_SignosV').click(function(e) { 
				imprimirSV(idP,idC);
			});
			
			//Cargamos los datos de los Signos Vitales y Cargamos los datos de Historia Clínica
			cargar_todo_signos_vitales(idP,idC); cargar_todo_historia_clinica(idP,idC,id_s);
											
			$('#myModalx').modal('show');
			$('#myModalx').on('shown.bs.modal', function (e) { $('#form-ficha_us').validator(); 
				$('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
			});
			$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); soloSV = false; });
			soloSV = true;
		} });
	});
}

function verHC(id_h, id_p, nombre_p, id_s, tUser, tUser1){
		$("#myModalx").load('hospital/htmls/historial.php', function( response, status, xhr ){ 
			if(status=="success"){
				// tinymce.remove("#notaMedicaC");
				$('#titulo_modal').text('HISTORIAL CLÍNICO DEL PACIENTE:  '+nombre_p);
				$('#idUsuario_hc').val($('#id_user').val()); 
				$('#id_cons').val(id_h); 
				$('#idPaciente_c').val(id_p);
				//bloqueamos los campos que no son necesarios mantener abiertos para edición
				$('#tablaSVT input, #tablaNotaSV textarea, .sv_ro').prop('readonly','readonly'); 
				$('.escala_g').prop('disabled','disabled');
						
				$('#b_agregarSignosC').click(function(e) { tomar_sv(id_p,2,id_h, id_s, nombre_p); });

				historiales(1);
				//Cargamos los datos de los Signos Vitales y Cargamos los datos de Historia Clínica
				cargar_todo_signos_vitales(id_p,id_h); cargar_todo_historia_clinica(id_p,id_h,id_s,nombre_p);
																													   
			//Para que nos ponga el número de cosas que hay en los historiales en los botones
			var idPx = {idP:id_p}
			$.post('consultas/files-serverside/datosBotonesHistoriales.php',idPx).done(function(data){
				var datosBP = data.split(';*-'); //alert(data); HC <span class="badge">4</span>
				$('#verHistorialLabC').html('LAB <span class="badge">'+datosBP[0]+'</span>');
				if(datosBP[0]<1){$('#verHistorialLabC').addClass('disabled');}
				$('#verHistorialUsgC').html('USG <span class="badge">'+datosBP[1]+'</span>');
				if(datosBP[1]<1){$('#verHistorialUsgC').addClass('disabled');}
				$('#verHistorialImgC').html('IMG <span class="badge">'+datosBP[2]+'</span>');
				if(datosBP[2]<1){$('#verHistorialImgC').addClass('disabled');}
				$('#verHistorialEndC').html('END <span class="badge">'+datosBP[3]+'</span>');
				if(datosBP[3]<1){$('#verHistorialEndC').addClass('disabled');}
				$('#verHistorialColC').html('COL <span class="badge">'+datosBP[4]+'</span>');
				if(datosBP[4]<1){$('#verHistorialColC').addClass('disabled');}
				$('#verHistorialOtrosC').html('OTROS <span class="badge">'+datosBP[5]+'</span>');
				if(datosBP[5]<1){$('#verHistorialOtrosC').addClass('disabled');}
				$('#verHistorialNotasC').html('CNTS <span class="badge">'+datosBP[6]+'</span>');
				if(datosBP[6]<1){$('#verHistorialNotasC').addClass('disabled');}
				cargar_historiales(id_p,id_h);
			});																					   
									
			$('#salirSGconsulta').removeClass('hidden');
		
		$('#myModalx').modal('show'); 
		$('#myModalx').on('shown.bs.modal', function (e) { });
		$('#myModalx').on('hidden.bs.modal', function (e) { 
			
		});
	}});		
}
function imprimirSV(idP,idC){
	var datosCon = {idP:idP, idC:idC}
	$.post('enfermeria/files-serverside/datosSV.php',datosCon).done(function(data){
		var datos=data.split(';*-');
		window.open("hospital/genera/signos_vitales_reporte.php?idP="+idP+"&edad="+datos[1]+"&sexo="+datos[2]+"&id_u="+ $('#id_user').val(), '_blank');
	});
}
function diagnosticos(idC,idP,estatus){
	$("#myModalx").load('hospital/htmls/diagnosticos.php',function(response,status,xhr){ if(status=="success"){

		var oTableBDX;
		oTableBDX = $('#dataTableBDX').DataTable({ 
		ordering: false, scrollCollapse: false, "scrollX": true, "bRetrieve": true, "sScrollY": ($('#myModalx').height()-515)/2,
		"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]], deferRender: true, select: { style: 'single' },
		"aoColumns": [{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 50, "bLengthChange": false, "bProcessing": false,
		"bServerSide": true, ordering: false, "sDom": 'lrtS', "sAjaxSource": "hospital/datatable-serverside/buscar_diagnosticosH.php", 
			"oLanguage": { 
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
				"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_", "sSearch": "" 
			}
		});//fin datatable
		$('#clickmeDXD').click(function(e) { oTableBDX.draw(); }); window.setTimeout(function(){oTableBDX.draw();},300);
		//para los fintros individuales por campo de texto
		oTableBDX.columns().every( function () { var that = this;
			$('input',this.footer()).on('keyup change',function(){if(that.search() !== this.value){that .search(this.value).draw();} });
		} );
		//fin filtros individuales por campo de texto
		oTableBDX.on( 'select', function ( e, dt, type, indexes ) {
			var rowData = oTableBDX.rows( indexes ).data().toArray(); subirDX(rowData[0][5], idC, $('#id_user').val(), idP);
		});

		var oTableSDX;
		oTableSDX = $('#dataTableDXS').DataTable({ 
			ordering: false, scrollCollapse: false, "scrollX": true, "bRetrieve": true, "sScrollY": ($('#myModalx').height()-515)/2,
			"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]], deferRender: true, select:false,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  },
			"aoColumns": [ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false} ], 
			"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": 'lrtS', 
			"sAjaxSource": "hospital/datatable-serverside/diagnosticos_seleccionadosH.php", 
			"fnServerParams": function (aoData, fnCallback) {
				aoData.push(  {"name": "idC", "value": idC } ); 
				aoData.push(  {"name": "estatus", "value": estatus } ); 
			},
			"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_", "sSearch": "" }
		});/*fin datatable*/ 
		$('#clickmeDXS').click(function(e) { oTableSDX.draw(); }); window.setTimeout(function(){oTableSDX.draw();},300);
		
		$('#b_cancel_dxs').click(function(e) {
			$('.hide_dx,#salirSGconsulta').removeClass('hidden'); $('#tab_dx,#b_cancel_dxs').addClass('hidden');
			window.setTimeout(function(){ $('#my_tb_nm').click(); },300); //checarHayDX(idC);
		});

		if(estatus == 'EGRESADO'){
			$('#tablaD').addClass('hidden');
		}
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function (e) { });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
	}});
}
function subirDX(idDX, idC, idU, idP){ var datosSDX = {idC:idC, idU:idU, idDX:idDX, idP:idP}
	$.post('consultas/files-serverside/guardarDX.php',datosSDX).done(function( data ) { if (data==1){ 
		$('#clickmeDXD, #clickmeDXS').click(); } else{alert(data);} 
	});
}
function borrarDX(idDX, idC){ var datosBDX = {idDX:idDX, idC:idC}
	$.post('consultas/files-serverside/eliminarDX.php',datosBDX).done(function(data){ 
		if(data==1){ $('#clickmeDXS, #clickmeDXD').click(); }else{alert(data);} 
	});
}
function dxPrimario(idDX,idC){ var datosDXP = {idDX:idDX,idC:idC}
	$.post('consultas/files-serverside/primarioDX.php',datosDXP).done(function(data){ 
		if(data==1){$('#clickmeDXS,#clickmeDXD').click();}else{alert(data);} 
	});
}


</script>
