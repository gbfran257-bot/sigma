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
    
    <title>SISTEMA - CATÁLOGO LABORATORIO</title>
    
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
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
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
    <style>
		.nav-tabs > li > a{
			padding: 10px 10px 10px 10px;
		}
		#cabecera_tBusquedaPrincipal th:nth-child(9){
			border-left: 1px solid white;
		}
		#cabecera_tBusquedaPrincipal th:nth-child(10){
			border-right: 1px solid white;
		}
		#dataTablePrincipal td:nth-child(10){
			border-right: 1px solid #cecece;
		}
		#dataTablePrincipal td:nth-child(9){
			border-left: 1px solid #cecece;
		}
		.dt-buttons{
			float:right;
			padding-right: 15px;
		}
    </style>
</head>
<?php include_once 'partes/header.php';?>
<!-- Contenido -->
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
	
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle; white-space:nowrap;">ESTUDIO</th>
    <th style="vertical-align:middle;">ÁREA</th>
	<th style="vertical-align:middle;" nowrap>DÍAS</th>
    <th style="vertical-align:middle;">PRECIO</th>
    <th style="vertical-align:middle;" nowrap>PRECIO UR</th>
    <th style="vertical-align:middle;">MAQUILA</th>
    <th style="vertical-align:middle;" nowrap>COSTO TOTAL</th>
    <th style="vertical-align:middle;" nowrap><span class="tipo_tabulador">TAB</span></th>
    <th style="vertical-align:middle; width: 110px;" nowrap><span class="tipo_tabulador">TAB</span> UR</th>
    <th style="vertical-align:middle;" nowrap>ÚLTIMA A</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm filtrodataTablePrincipal" placeholder="Estudio"/></th>
            <th><input type="text" class="form-control input-sm filtrodataTablePrincipal" placeholder="Área" style="max-width:100px;"/></th>
            <th></th>
            <th class="text-center" colspan="2">
			</th>
            <th class="text-center" colspan="2">
			</th>
            <th class="text-right" colspan="3">
			</th>
        </tr>
    </tfoot>
</table>
<div style='border:1px solid none; text-align:left;'><table id='ocultarFP' width='' border='0' cellspacing='0' cellpadding='6'> <tr><td class="hidden">SUCURSAL</td><td><select name='miSucursal' id='miSucursal' class='form-control input-sm hidden'></select></td></tr> </table></div>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
	var oTableP, globalisima = 0;
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>LABORATORIO</li><li class="active"><strong>CATÁLOGO DE ESTUDIOS DE LABORATORIO</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-155-$('#breadc').height();
	oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":false},{ "bVisible": true }, {"bVisible":false},
			{"bVisible":true },{ "bVisible": true }, {"bVisible":false}, {"bVisible":false}, {"bVisible":false}
		],
		"sDom": '<"filtro1Principal"f>Blr<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Catalogo de laboratorio'
        } ],
        lengthMenu: [[100, 500, -1], [100, 500, "Todo"]],
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "laboratorio/estudios/datatable-serverside/estudios_l_costos.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val(); var de = $("#miSucursal").val();
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "enExcel", "value": globalisima } );
			aoData.push(  {"name": "idU", "value": idU } ); aoData.push({"name": "idSu", "value": de });
		},
		"oLanguage": {
			"sLengthMenu": "MOSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "ESTUDIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 100, paging: true,
	});
	oTableP.on( 'buttons-action', function ( e, buttonApi, dataTable, node, config ) {
	    //console.log( 'Button '+buttonApi.text()+' was activated' );
	    e.preventDefault();
	    globalisima = 1;
	    oTableP.draw();
	} );
	$('#clickme').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#clickme').click();},500);
	
	//para los fintros individuales por campo de texto
	oTableP.columns().every( function () {
		var that = this;
 
		$( '.filtrodataTablePrincipal', this.footer() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
		} );
	} );
	//fin filtros individuales por campo de texto
	$('#top-search').keyup(function(e) {
        $('#dataTablePrincipal_filter input').val($(this).val()); $('#dataTablePrincipal_filter input').keyup();
    }).focus();
	$('.filtro1Principal').addClass('hidden');
	
	$("#miSucursal").load('pacientes/genera/genera_sucursales_ov.php?idU='+$('#id_user').val(), function(response,status,xhr){
		if (status = "success"){
			var datosUS = {idU:$('#id_user').val()}
			$.post('servicios/servicios/files-serverside/datosSucursalU.php',datosUS).done(function(data){ 
				$("#miSucursal").val(data); $('#clickme').click();
				$("#miSucursal").change(function(e) {
					$('#clickme').click();
					var t = $("#miSucursal option:selected").attr("tipo");
					$(".tipo_tabulador").html( $("#miSucursal option:selected").attr("clave")+" ("+(t==1?'M':(t==2?'S':'NA'))+")");
				});
				$("#miSucursal").trigger("change");
			});
		}
	});
	//$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='100%' border='1' cellspacing='0' cellpadding='6'> <tr><td><select name='miSucursal' id='miSucursal' class='form-control input-sm'></select></td></tr> </table></div>" );
	
});

</script>
