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
    
    <title>SISTEMA - UNIDADES DE MEDIDA</title>
    
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
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">
		REFERENCIA
    </th>
    <th style="vertical-align:middle;">PACIENTE</th>
    <th style="vertical-align:middle;">USUARIO</th>
    <th style="vertical-align:middle;">TOTAL</th>
    <th style="vertical-align:middle;">ABONADO</th>
    <th style="vertical-align:middle;">SALDO</th>
    <th style="vertical-align:middle;">ESTADO</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Referencia"/></th>
            <th><!-- <input type="text" class="form-control input-sm" placeholder="-Abreviación-"/> --></th>
            <th><!-- <input type="text" class="form-control input-sm" placeholder="-Usuario-"/> --></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>

<style>
	.modal-fullscreen  {
		max-width: 120%;
		width: 95%;
		margin: 25;
	}
	.tablasaldos{
		
	}
</style>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>RECEPCIÓN</li><li class="active"><strong>REFERENCIAS HOSPITAL</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-140-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
			var Total = 0;
			var abonado = 0;
			var saldo = 0;
			for ( var i=iStart ; i<iEnd ; i++ )
			{
				// console.log(aaData[ aiDisplay[i] ][3]);
				Total += aaData[ aiDisplay[i] ][4]*1;
				abonado += aaData[ aiDisplay[i] ][5]*1;
				saldo += aaData[ aiDisplay[i] ][6]*1;
			}
			var nCells = nRow.getElementsByTagName('th');
			nCells[4].innerHTML = '$'+redondear(parseFloat(Total * 100)/100,2);
			nCells[5].innerHTML = '$'+redondear(parseFloat(abonado * 100)/100,2);
			nCells[6].innerHTML = '$'+redondear(parseFloat(saldo * 100)/100,2);
			// nCells[3].innerHTML = Total;
		}, scroller: false, responsive: true,
		"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true} ],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "referencias_hospital/informacion_referencias.php",
		"fnServerParams": function (aoData, fnCallback) { 
			//
			var de1 = $('#top-search').val();
			var de = $('#fechaDe').val() + ' 00:00:00';
			var a = $('#fechaA').val() + ' 23:59:59';

			aoData.push({ "name": "nombre", "value": de1 });
			aoData.push({ "name": "min", "value": de });
			aoData.push({ "name": "max", "value": a });
			//
			var nombre = $('#top-search').val();
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
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


	//
	$('.infoPrincipal').append('<div id="divRangoFechas" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">De &nbsp;</td> <td width="1%"> <input name="fechaDe" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly> </td> <td id="rangosFechas">&nbsp; <input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');
	
	$('#radio1').click(function(e) {
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>');
		$('#fechaA').val('<?php echo date("Y-m-d"); ?>');
		oTableP.draw();
	});

	$('#radio2').click(function(e) {
		$('#fechaDe').val('2023-01-01');
		$('#fechaA').val('<?php echo date("Y-m-d"); ?>');
		oTableP.draw();
	});

	$('#fechaDe').on('changeDate', function(e) {
		oTableP.draw();
	});
	$("#fechaA").on('changeDate', function(e) {
		oTableP.draw();
	});
	//

});

function ver_datos_ref(id_paciente,fecha_rh,id_rh,referencia_h,nom_paciente){
	$("#myModal").load('referencias_hospital/htmls/ficha_referencia_hosp.php', function( response, status, xhr ){ if(status=="success"){
		// $('#id_usr_reg').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#titulo_modal').text('INFORMACIÓN DE LA REFERENCIA:  ' + referencia_h + '  DEL PACIENTE ' + nom_paciente);
		total_abono(id_rh);

				//REFERENCIAS 
				var oTableSer = $('#dataTableBserviciosM').DataTable({
					serverSide: true,
					"sScrollY": 170,
					ordering: false,
					searching: true,
					scrollCollapse: false,
					"scrollX": true,
					"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {},
					scroller: false,
					responsive: true,
					"aoColumns": [
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": false}, 
						{"bVisible": true},
						{"bVisible": true},
						{"bVisible": true}
					],
					"sDom": '<"">r<""t><""S><"">',
					deferRender: true,
					select: {
						style: 'single'
					},
					"processing": false,
					"sAjaxSource": "referencias_hospital/datatable_info_referencias.php",
					"fnServerParams": function(aoData, fnCallback) {
						aoData.push({ "name": "id_paciente", "value": id_paciente });
						aoData.push({ "name": "fecha_rh", "value": fecha_rh });
						aoData.push({ "name": "referencia_h", "value": referencia_h });
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
						"sInfo": "SERVICIOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGUN SERVICIO FILTRADO.",
						"sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_",
						"sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					},
					"iDisplayLength": 5000,
					paging: false,
				});
				$('#clickmeSe').click(function(e) {
					total_abono(id_rh);
					oTableSer.draw();
				});

				$('#t_ref').click(function(e) {//refrescamos la datatable
					setTimeout(() => {
						$('#clickmeSe,#clickmeSmS').click();
					}, 100);
				});

				oTableSer.on('select', function(e, dt, type, indexes) {
					var rowData = oTableSer.rows(indexes).data().toArray(); 
					
					var datos = { id:id_rh, referencia:rowData[0][7], id_ov:rowData[0][6] }
					$.post('referencias_hospital/insertar_ref_rrh.php', datos).done(function(data) {
						if(data==1){
							insertar_reg_historial(id_rh,rowData[0][6]);
							$('#clickmeSe,#clickmeSmS,#clickme,#clickmeRep').click();
							oTableSer.draw();
						}else{
							alert(data);
						}
					});

				});

			//SELECCIONADOS
			var oTableSerS = $('#dataTableSmS').DataTable({
					serverSide: true,
					"sScrollY": 170,
					ordering: false,
					searching: true,
					scrollCollapse: false,
					"scrollX": true,
					"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
						var Total = 0;
						for ( var i=iStart ; i<iEnd ; i++ )
						{
							// console.log(aaData[ aiDisplay[i] ][3]);
							Total += aaData[ aiDisplay[i] ][5]*1;
						}
						var nCells = nRow.getElementsByTagName('th');
						nCells[4].innerHTML = '$'+redondear(parseFloat(Total * 100)/100,2);
						// nCells[3].innerHTML = Total;
					},
					scroller: false,
					responsive: true,
					"aoColumns": [
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": false}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}
					],
					"sDom": '<"">r<""t><""S><"">',
					deferRender: true,
					select: false,
					"processing": false,
					"sAjaxSource": "referencias_hospital/datatable_seleccionadas_ref.php",
					"fnServerParams": function(aoData, fnCallback) {
						aoData.push({ "name": "id_rh", "value": id_rh });
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "NO SE HA SELECCIONADO NINGUNA REFERENCIA",
						"sInfo": "SERVICIOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGUN SERVICIO FILTRADO.",
						"sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_",
						"sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					},
					"iDisplayLength": 5000,
					paging: false,
				});
				$('#clickmeSmS').click(function(e) {
					oTableSerS.draw();
				});
				//HISTORIAL

				var oTableHis = $('#dataTableHis').DataTable({
					serverSide: true,
					"sScrollY": 450,
					ordering: false,
					searching: true,
					scrollCollapse: false,
					"scrollX": true,
					"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {},
					scroller: false,
					responsive: true,
					"aoColumns": [
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}
					],
					"sDom": '<"">r<""t><""S><"">',
					deferRender: true,
					select: false,
					"processing": false,
					"sAjaxSource": "referencias_hospital/datatable_historial_srh.php",
					"fnServerParams": function(aoData, fnCallback) {
						aoData.push({ "name": "id_rh", "value": id_rh });
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "NO SE HA SELECCIONADO NINGUNA REFERENCIA",
						"sInfo": "SERVICIOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGUN SERVICIO FILTRADO.",
						"sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_",
						"sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					},
					"iDisplayLength": 5000,
					paging: false,
				});

				$('#clickmeHis').click(function(e) {
					oTableHis.draw();
				});

				$('#t_his').click(function(e) {//refrescamos la datatable de historial
					setTimeout(() => {
						$('#clickmeHis').click();
					}, 100);
				});


		//pagos
		var oTablePag = $('#dataTablePag').DataTable({
					serverSide: true,
					"sScrollY": 270,
					ordering: false,
					searching: true,
					scrollCollapse: false,
					"scrollX": true,
					"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {},
					scroller: false,
					responsive: true,
					"aoColumns": [
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}, 
						{"bVisible": false}
					],
					"sDom": '<"">r<""t><""S><"">',
					deferRender: true,
					select: false,
					"processing": false,
					"sAjaxSource": "referencias_hospital/datatable_pagos_ov_rh.php",
					"fnServerParams": function(aoData, fnCallback) {
						aoData.push({ "name": "id_rh", "value": id_rh });
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "NO SE HA SELECCIONADO NINGUNA REFERENCIA",
						"sInfo": "SERVICIOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGUN SERVICIO FILTRADO.",
						"sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_",
						"sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					},
					"iDisplayLength": 5000,
					paging: false,
				});

				$('#clickmePag').click(function(e) {
					oTablePag.draw();
				});

				$('#t_pagos').click(function(e) {//refrescamos la datatable de historial
					setTimeout(() => {
						$('#clickmePag').click();
					}, 100);
				});

				//abonos
				var oTableAbo = $('#dataTableAbo').DataTable({
					serverSide: true,
					"sScrollY": 400,
					ordering: false,
					searching: true,
					scrollCollapse: false,
					"scrollX": true,
					"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
						var Total = 0;
						for ( var i=iStart ; i<iEnd ; i++ )
						{
							// console.log(aaData[ aiDisplay[i] ][3]);
							Total += aaData[ aiDisplay[i] ][4]*1;
						}
						var nCells = nRow.getElementsByTagName('th');
						nCells[4].innerHTML = '$'+redondear(parseFloat(Total * 100)/100,2);
					},
					scroller: false,
					responsive: true,
					"aoColumns": [
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}
					],
					"sDom": '<"">r<""t><""S><"">',
					deferRender: true,
					select: false,
					"processing": false,
					"sAjaxSource": "referencias_hospital/datatable_abonos_arh.php",
					"fnServerParams": function(aoData, fnCallback) {
						aoData.push({ "name": "id_rh", "value": id_rh });
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "NO SE HA SELECCIONADO NINGUNA REFERENCIA",
						"sInfo": "SERVICIOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGUN SERVICIO FILTRADO.",
						"sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_",
						"sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					},
					"iDisplayLength": 5000,
					paging: false,
				});

				$('#clickmeAbo').click(function(e) {
					oTableAbo.draw();
				});

				$('#t_abonos').click(function(e) {//refrescamos la datatable de historial
					setTimeout(() => {
						$('#clickmeAbo').click();
					}, 100);
				});

				$('#btn_abonar').click(function(e) {
					abonar(id_rh);
				});

					//REPORTE CONCEPTOS
					var oTableRep = $('#dataTableRep').DataTable({
					serverSide: true,
					"sScrollY": 400,
					ordering: false,
					searching: true,
					scrollCollapse: false,
					"scrollX": true,
					"fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
						/* var Total = 0;
						for ( var i=iStart ; i<iEnd ; i++ )
						{
							Total += aaData[ aiDisplay[i] ][4]*1;
						}
						var nCells = nRow.getElementsByTagName('th');
						nCells[4].innerHTML = '$'+redondear(parseFloat(Total * 100)/100,2); */
					},
					scroller: false,
					responsive: true,
					"aoColumns": [
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}, 
						{"bVisible": true}
					],
					"sDom": '<"">r<""t><"tabla_reporte_conceptos"S><"">',
					deferRender: true,
					select: false,
					"processing": false,
					"sAjaxSource": "referencias_hospital/datatable_rep_con_crh.php",
					"fnServerParams": function(aoData, fnCallback) {
						aoData.push({ "name": "id_rh", "value": id_rh });
						//
						var de_2 = $('#fechaDe_2').val() + ' 00:00:00';
						var a_2 = $('#fechaA_2').val() + ' 23:59:59';
						aoData.push({ "name": "min", "value": de_2 });
						aoData.push({ "name": "max", "value": a_2 });
						//
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page",
						"sZeroRecords": "NO SE HA SELECCIONADO NINGUNA REFERENCIA",
						"sInfo": "SERVICIOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGUN SERVICIO FILTRADO.",
						"sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_",
						"sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					},
					"iDisplayLength": 5000,
					paging: false,
				});

				$('#clickmeRep').click(function(e) {
					oTableRep.draw();
				});

				$('#t_rep_con').click(function(e) {//refrescamos la datatable de historial
					setTimeout(() => {
						$('#clickmeRep').click();
					}, 100);
				});
				//
				$('.tabla_reporte_conceptos').append('<div id="divRangoFechas_2" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">&nbsp; De &nbsp;</td> <td width="1%"> <input name="fechaDe_2" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe_2" value="<?php echo date("Y-m-d"); ?>" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA_2" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA_2" value="<?php echo date("Y-m-d"); ?>" readonly> </td> <td id="rangosFechas_2">&nbsp; <input type="radio" class="rad" id="radio1_2" name="radio" /><label for="radio1_2">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2_2" name="radio" /><label for="radio2_2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');

				$('#radio1_2').click(function(e) {
					$('#fechaDe_2').val('<?php echo date("Y-m-d"); ?>');
					$('#fechaA_2').val('<?php echo date("Y-m-d"); ?>');
					oTableRep.draw();
				});

				$('#radio2_2').click(function(e) {
					$('#fechaDe_2').val('2023-01-01');
					$('#fechaA_2').val('<?php echo date("Y-m-d"); ?>');
					oTableRep.draw();
				});

				$('#fechaDe_2').on('changeDate', function(e) {
					oTableRep.draw();
				});
				$("#fechaA_2").on('changeDate', function(e) {
					oTableRep.draw();
				});
				//


		//fin datatables
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) {
			// $('#form-ficha_us').validator(); $('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}

//modifica los totales, abonos y saldo de una RH.
function total_abono(id_rh){
	var labeltotal = $("label[for='lbltotal']");
	/* var labelsubtotal = $("label[for='lblsubtotal']"); */
	var labelabono_orden = $("label[for='lblabono_orden']");
	var labelabono = $("label[for='lblabono']");
	var labelsaldo = $("label[for='lblsaldo']");
	var dato = {id_rh:id_rh}
	$.post('referencias_hospital/ref_total_abono.php', dato).done(function(data){ 
		var datos = data.split('*}');

		/* if(datos[0]<=0||datos[0] == null){
			datos[0] = 0;
		}
		if(datos[1]<=0||datos[1] == null){
			datos[1] = 0;
		}
		if(datos[2]<=0||datos[2] == null){
			datos[2] = 0;
		}
		if(datos[3]<=0||datos[3] == null){
			datos[2] = 0;
		} */

		/* labelsubtotal.text("SUBTOTAL: $" + datos[3]); */
		labeltotal.text("TOTAL: $" + datos[0]);
		labelabono_orden.text("ABONOS POR ORDEN: $" + datos[3]);
		labelabono.text("ABONOS A HOSPITAL: $" + datos[1]);
		labelsaldo.text("SALDO A PAGAR: $" + datos[2]);
	});
}

function borrarRef(id,id_ov,id_rh){
	var datos = {id:id,id_ov:id_ov,idU:$('#id_user').val(),id_rh:id_rh}
	$.post('referencias_hospital/eliminar_referencia_rh.php', datos).done(function(data) {
		$('#clickmeSe,#clickmeSmS,#clickmeHis,#clickme').click();
	});
}

function insertar_reg_historial(id_rh,id_ov){
	var datos = { id_rh:id_rh, id_ov:id_ov, idU:$('#id_user').val() }
	$.post('referencias_hospital/insertar_reg_historial.php', datos).done(function(data) {
		$('#clickmeSe,#clickmeSmS,#clickmeHis').click();
	});

}

function abonar(id_rh){
	/* swal({
		title: "Ingrese la cantidad a abonar:",
		type: "input",
		showCancelButton: true,
		closeOnConfirm: false,
		inputPlaceholder: "Escribe una cantidad"
	}, function(inputValue) {
		if (inputValue === false) return false;
		var number = parseFloat(inputValue);
		if (!isNaN(number) && number>0) {
			var datos_abono = { id_rh:id_rh, abono:number, idU:$('#id_user').val() }
			$.post('referencias_hospital/insertar_abono_arh.php', datos_abono).done(function(data_abono) {
				if(data_abono=='1'){
					swal("Listo", "Se ha registrado el abono", "success");
				}
				$('#clickmeSe,#clickmeSmS,#clickmeHis,#clickmeAbo,#clickme').click();
			});
		} else {
			swal("Error", "Por favor, ingrese una cantidad valida.", "error");
		}
	}); */

	$("#myModal3").load("referencias_hospital/htmls/ficha_abonos_hosp.php",function(response,status,xhr){ if(status == "success"){
		
		$("#cat_form_pago").load('referencias_hospital/genera_formas_pago.php', function(data){
			$("#cat_form_pago").val(data); 
			$("#cat_form_pago").val(1);
			$('#clickmeSe,#clickmeSmS,#clickmeHis').click();
		});

		//establecemos maximo de abono permitido
		var dato = {id_rh:id_rh}
		$.post('referencias_hospital/ref_total_abono.php', dato).done(function(data){ 
			var datos = data.split('*}');
			// Seleccionar el elemento input por su ID
			var miInput = $("#cant_abonada");
			// Establecer el valor máximo
			miInput.attr("max", datos[2]);

			$("#rh").val(datos[2]);
		});

		$('#form-ficha_abonos').validator().on('submit', function (e) {
			if (e.isDefaultPrevented()) {

			}else{
				e.preventDefault();
				var dato_abono = { id_rh:id_rh, 
								   abono:$('#cant_abonada').val(), 
								   idU:$('#id_user').val(), 
								   persona_abona:$('#nom_p_abona').val(), 
								   forma_pago:$('#cat_form_pago').val() 
				}
				$.post('referencias_hospital/insertar_abono_arh.php', dato_abono).done(function(data){
					if(data=='1'){
						swal("Listo", "Se ha registrado el abono", "success");
					}
					$('#btn_cancel_abonos').click();
					$('#clickmeSe,#clickmeSmS,#clickmeHis,#clickmeAbo,#clickme').click();
				}); 
				
			}
		});

		$('#myModal3').modal('show');
		$('#myModal3').on('hidden.bs.modal', function(e){
			$("#myModal3").empty(); 
			$("#myModal").show();
		});

	}});



}

function liquidar(){
	$("#cant_abonada").val( $("#rh").val() );
}

function ver_ov(ref){
	$("#myModal3").load("referencias_hospital/htmls/ficha_ov_hospital.php",function(response,status,xhr){ if(status == "success"){
		var dato = { ref:ref, idU:$('#id_user').val() }
		$.post('laboratorio/archivos_save_ajax/datos_ficha_ov.php', dato).done(function(data){ var datos = data.split('*}');
			// $('#titulo_modal_h').text('ORDEN DE VENTA '+ref+' | '+datos[0]+' | '+datos[1]);
			$('#titulo_modal_h').text('ORDEN DE VENTA '+ ref );
			$('#fecha_o').text(datos[2]); $('#usuario_o').text(datos[3]); $('#subtotal_o').text(datos[4]); $('#extras_o').text(datos[5]);
			$('#iva_o').text(datos[6]); $('#descuento_o').text(datos[7]); $('#total_o').text(datos[8]); $('#abonado_o').text(datos[9]);
			$('#saldo_o').text(datos[10]); $('#estatus_o').text(datos[11]); $('#o_items').html(datos[17]);
			
			$('#myModal3').modal('show');
			// $('#myModal3').on('shown.bs.modal', function(e){ });
			$('#myModal3').on('hidden.bs.modal', function(e){
				// $(".modal-content").remove(); 
				$("#myModal3").empty(); 
				$("#myModal").show();
			});
		}); 
	}});
}


/* function pagar(ref, tot, sal, abo, pac, noTemp, indicador, tCo, tIm, tLab, tFar){
	$("#myModal2").load("corte_caja/reportes/htmls/dialogPagarOV.php",function(response,status,xhr){if (status == "success"){
		if(indicador == 2){
			$('#t').html('<i class="fa fa-info-circle"></i> Debido a los cambios realizados en la plataforma, es necesario que el monto anterior de los pagos realizados a esta Orden de Venta se incluyan junto que éste pago actual. Así que el monto mínimo a pagar es de $'+abo+' repartidos en la forma posible indicada. Esta acción es con el fin de repartir los pagos en los departamentos de la Orden. Por su comprensión GRACIAS!');
		}else{$('#texto_money').remove();}
		
		$('#alerta_new_pago').hide();
		$('#totalOVP').val(tot); $('#abonadoOVP').val(abo); $('#saldoP').val(redondear(sal,2)); $('#opcion_pa').val(indicador);
		
		var montoPagar = 0;
		
		$('.montoPagarP').keyup(function(e){
			montoPagar = parseFloat($('#pago_ov_c').val())+parseFloat($('#pago_ov_i').val())+parseFloat($('#pago_ov_l').val())+parseFloat($('#pago_ov_f').val());
			
			if(indicador != 2){ if( parseFloat(montoPagar) > parseFloat($('#saldoP').val()) ){ montoPagar = $('#saldoP').val(); } }
			
			$('#monto_t_p').text(parseFloat(montoPagar)); $('#pagaConP, #cambioP').val('');
		});
		
		$('#1total_c1').text(tCo); $('#1total_i').text(tIm); $('#1total_l').text(tLab); $('#1total_p').text(tFar);
		if(tCo==0){$('#pago_ov_c').val(0);} if(tIm==0){$('#pago_ov_i').val(0);} if(tLab==0){$('#pago_ov_l').val(0);} if(tFar==0){$('#pago_ov_f').val(0);}
		
		$('#btn_liquidar_ov').click(function(e){
			$('#pago_ov_c').val($('#1total_c1').text()); $('#pago_ov_i').val($('#1total_i').text()); $('#pagaConP, #cambioP').val('');
			$('#pago_ov_l').val($('#1total_l').text()); $('#pago_ov_f').val($('#1total_p').text()); $('#form-pagar').validator('update');
			montoPagar = parseFloat($('#pago_ov_c').val())+parseFloat($('#pago_ov_i').val())+parseFloat($('#pago_ov_l').val())+parseFloat($('#pago_ov_f').val());
			$('#monto_t_p').text(parseFloat(montoPagar));
		});
		
		$('#pagaConP').keyup(function(e) {
			if( $(this).val() > parseFloat(montoPagar) ){ $('#cambioP').val(redondear(parseFloat($('#pagaConP').val())-parseFloat(montoPagar),2) );}
			else{$('#cambioP').val('')}
		});
		
		$('#formaPagoP').load("corte_caja/reportes/genera/formas_pago.php",function(response,status,xhr){ if(status=="success"){
			$(this).val(1); 
			$('#formaPagoP').change(function(e) { 
				$('#pagaConP, #cambioP').val(''); $('#pago_ov_c, #pago_ov_i, #pago_ov_l, #pago_ov_f').val(0);
				
				if($(this).val()!=''){ $('.montoPagarP').prop('readonly',false); }
				else{ $('.montoPagarP').prop('readonly',true); $('#ivaP').val(0); }
				if($(this).val()==1){ $('#pagaConP').prop('readonly',false); }else{$('#pagaConP').prop('readonly',true);}
			});
		} }); var permite = 1;
		
		$('#form-pagar').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { 
			$("#alerta_new_pago").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_pago").slideUp(600); });
		  }else { 
			if(indicador == 2){e.preventDefault();
				if(montoPagar<abo){ $("#alerta_new_pago").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_pago").slideUp(600); }); permite = 0; }
			}else{permite = 1;}
			if(permite==1){
				e.preventDefault(); var $btn = $('#btn_pago_ov').button('loading'); $('#btn_cancel_pago_ov').hide();

				var datosP={
					ref:ref,user:$('#id_user').val(),pago_ov_c:$('#pago_ov_c').val(),noTemp:noTemp,formaPagoP:$('#formaPagoP').val(),
					pago_ov_i:$('#pago_ov_i').val(), pago_ov_l:$('#pago_ov_l').val(), pago_ov_f:$('#pago_ov_f').val(), opcion_pa:$('#opcion_pa').val()
				}
				$.post('corte_caja/reportes/files-serverside/savePago.php',datosP).done(function(data){
					if(data==1){
						$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_pago_ov').show(); $('#myModal2').modal('hide');

						swal({
						  title: "PAGO REALIZADO", text: "¿Deseas imprimir el ticket?", type: "success", showCancelButton: true,
						  confirmButtonText: "Imprimir", cancelButtonText: "Salir", closeOnConfirm: false
						},
						function(){
							swal.close();
							$("#myModal1").load('pacientes/htmls/ticket.php', function( response, status, xhr ){ if(status=="success"){
								var oTableT = $('#dataTableResumenT').DataTable({
									serverSide:true,"sScrollY":'100%',ordering:false,searching:false,scrollCollapse:false,"scrollX": true,
									"fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){ },scroller:false,responsive:false,
									"aoColumns": [
										{"bVisible":true}, {"bVisible":false}, {"bVisible":false}, { "bVisible": true }, { "bVisible": false }, { "bVisible": true }
									],
									"sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
									deferRender: true, select: false, "processing": false, 
									"sAjaxSource": "pacientes/js/datatable-serverside/totales_nvTi.php",
									"fnServerParams": function (aoData, fnCallback) { 
										var aleatorio = noTemp; aoData.push(  {"name": "aleatorio", "value": aleatorio } );
									},
									"oLanguage": {
										"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"LA ORDEN DE VENTA ESTA VACIA",
										"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", 
										"sSearch": "BUSCAR"
									},"iDisplayLength": 50000, paging: false,
								});

								var datosTi = {noAleatorio:ref}
								$.post('pacientes/files-serverside/datosTicket_a.php',datosTi).done(function(data){
									console.log("yesyes");
									var datosT = data.split(';}'); if(datosT[5]==''){datosT[5]=0;} 
									
									$('#fechaT').text(datosT[0]);
									$('#referenciaT').text(datosT[1]);
									$('#pacienteT').text(datosT[2]);
									$('#adicionalesT').text(datosT[10]);
									$('#totalT').text(datosT[4]);
									$('#pagoT').text(montoPagar);
									$('#saldoT').text(redondear(-1*(parseFloat(datosT[31])),2));
									$('#usuarioIT').text(datosT[7]);
									$('#fechaIT').text(datosT[8]);
									$('#horaIT').text(datosT[9]); 
									$('#formaPagoT').text(datosT[11]);
									$('#cantidadLetraT').text(nn(datosT[4])); 
									$('#municipioS').text(datosT[16]);
									$('#calleSucursal').text(datosT[19]); 
									$('#coloniaSucursal').text(datosT[18]);
									$('#cpSucursal').text(datosT[20]);
									$('#telefonoSucursal').text(datosT[21]);
									$('#municipioSucursal').text(datosT[17]);
									$('#estadoSucursal').text(datosT[15]);
									$('#sitioS').text(datosT[22]);$
									('#emailSucursal').text(datosT[23]);
									$('#descuentoT').text(datosT[24]);
									$('#subTotalT').text(datosT[29]);
									if(datosT[25]>0){
										x='sucursales/documentos/files/'+datosT[26]+'.'+datosT[27]+'?'+Math.round(Math.random()*1000);
										$('#myLogoS').html('<img src='+x+' width="150" style="border:5px none white; background-color:rgba(255, 255, 255, 1);">');
									}
									if(datosT[28]>0){ $('#myIva').removeClass('hidden'); }else{$('#myIva').addClass('hidden');}
									$('#ivaT').text(redondear(datosT[28],2)); $('#abonadoAT').text(redondear(parseFloat(datosT[30]),2));
									$('#abonosT').text(redondear(parseFloat(datosT[30]),2)); $('#saldosT').text(redondear(-1*(parseFloat(datosT[31])),2));
									$('#myAbonadoA').removeClass('hidden'); 

									$('#imprimirTic').click(function(e) { $('#tablaTicket').printElement(); });
								});

								$('#myModal1').modal('show');
								$('#myModal1').on('shown.bs.modal',function(e){ });
								$('#myModal1').on('hidden.bs.modal',function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
							}});					
						});
						//
					}else{alert(data);}
				});
			}
		  }
		});
		
		$('#myModal2').modal('show');
		$('#myModal2').on('hidden.bs.modal', function (e) { 
			$("#myModal2").empty(); 
			$("#myModal").show();
		});
	} }); 
} */



</script>