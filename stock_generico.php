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
    
    <title>SISTEMA - STOCK GENERICO </title>
    
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.select2-dropdown{
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
	<th style="vertical-align:middle;">
		NOMBRE GENÉRICO
	</th>
	<th style="vertical-align:middle;" class="">MIN</th>
	<th style="vertical-align:middle;" class="">MAX</th>
	<th style="vertical-align:middle;" class="">TOTALES</th>
	</tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
<tfoot>
	<tr class="bg-primary">
		<th></th>
		<th><input type="text" class="form-control input-sm" placeholder="GENÉRICO"/></th>
		<th><!-- <input type="text" class="form-control input-sm" placeholder="CLAVE"/> --></th>
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
	
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>FARMACIA</li><li class="active"><strong>STOCK GENÉRICO</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-127-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns":[ {"bVisible":true}, 
					  {"bVisible":true }, 
					  {"bVisible":true }, 
					  {"bVisible":true }, 
					  { "bVisible": true }],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "farmacia/stock/datatable-serverside/stock_generico.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var sucursal = $("#select-sucursal").val();

			aoData.push( {"name": "id_sucursal", "value": sucursal } );
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SERVICIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 500, paging: true,
	});
	
	$('#clickme').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#clickme').click();},500);
	
	oTableP.columns().every( function () {
		var that = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
		} );
	} );
	$('#top-search').keyup(function(e) {
        $('#dataTablePrincipal_filter input').val($(this).val()); $('#dataTablePrincipal_filter input').keyup();
    }).focus();
	$('.filtro1Principal').addClass('hidden');
	$('.infoPrincipal').append('<div id="divSucursales" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td>Sucursal: <select id="select-sucursal" class="form-control form-control-sm"></td> </tr> </table> </div>');
	select2ini_s("#select-sucursal", "sucursales-stock.php?id_u="+$('#id_user').val(), "Selecciona una sucursal para ver su stock", 0, "400px");

	
	$("#select-sucursal").change((e) => {
		oTableP.draw();
    });
});

	function select2ini_s(donde, url, ph, id_su, width = "off"){
		$(donde).select2({
			language: "es",
			width: width,
			allowClear: true,
			ajax: {
				url: 'select/'+url,
				type: "post",
				data: function (params) {
					var query = {
						search: params.term,
						page: params.page || 1,
						idSu: id_su
					};
					return query;
				}
			},
			placeholder: ph
		});
	}

	function updateMinMax(id_sucursal, id_generico){
		
		if($("#minimo_"+id_generico).val() !== '' && $("#maximo_"+id_generico).val() !== ''){

			var datos = { min_stock:$("#minimo_"+id_generico).val(), max_stock:$("#maximo_"+id_generico).val(), id_sucursal:id_sucursal, idm:id_generico, id_usuario:$('#id_user').val() }

			$.post('catalogos/medicamento_generico/files-serverside/update_max_min_mmg.php', datos).done(function(data) {
				if (data == 1) { 
					swal({
						title: "¡CONFIRMACIÓN!",
						type: "success",
						text: "Datos guardados",
						timer: 1000,
						showConfirmButton: false
					});
					return;
				} else {
					alert(data);
				}
			});

		}
	}

	function verTotales(id_sucursal, id_generico) {
		$("#myModal4").load('farmacia/stock/htmls/ficha_totales.php', function(response, status, xhr) {

			if(status == "success"){

				var oTableTotales = $('#dataTableTotales').DataTable({
					serverSide: true,"sScrollY": 500, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
					"aoColumns":[ {"bVisible":true}, 
								{"bVisible":true }, 
								{"bVisible":true }, 
								{"bVisible":true }, 
								{ "bVisible": true }],
					"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
					deferRender: true, select: false, "processing": false, 
					"sAjaxSource": "farmacia/stock/datatable-serverside/stock_generico_totales.php",
					"fnServerParams": function (aoData, fnCallback) { 
						
						aoData.push( {"name": "id_sucursal", "value": id_sucursal } );
						aoData.push( {"name": "id_generico", "value": id_generico } );
					},
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
						"sInfo": "SERVICIOS FILTRADOS: _END_",
						"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
						"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
					},"iDisplayLength": 500, paging: true,
				});
				$('.filtro1Principal').addClass('hidden');

				$('#myModal4').modal('show');
					$('#myModal4').on('shown.bs.modal', function(e) {});
					$('#myModal4').on('hidden.bs.modal', function(e) {
						$("#myModal4 .modal-content").remove();
						$("#myModal4").empty();
				});
			}


		});
	}




</script>