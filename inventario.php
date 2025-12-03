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
    
    <title>FARMACIA - INVENTARIO</title>
    
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

	<script src="DataTables-1.12/DataTables-1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="DataTables-1.12/DataTables-1.12.1/js/dataTables.bootstrap.min.js"></script>
    <script src="DataTables-1.12/Select-1.4.0/js/dataTables.select.min.js"></script> 
    <script src="DataTables-1.12/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="DataTables-1.12/JSZip-2.5.0/jszip.min.js"></script>
    <script src="DataTables-1.12/Buttons-2.2.3/js/buttons.html5.min.js"></script> 
	<script src="DataTables-1.12/Buttons-2.2.3/js/buttons.print.min.js"></script> 
	<script src="DataTables-1.12/pdfmake-0.1.36/pdfmake.min.js"></script> 
	<script src="DataTables-1.12/pdfmake-0.1.36/vfs_fonts.js"></script> 

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
	<script src="funciones/js/ver_OV_prod.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

	<link href="DataTables-1.12/DataTables-1.12.1/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.12/Scroller-2.0.6/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.12/Select-1.4.0/css/select.bootstrap.min.css" rel="stylesheet"> 
    
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
    <link href="c3/c3.css" rel="stylesheet">
	
	<script type="text/javascript" src="js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" crossorigin="anonymous" />
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px; font-size: 1.2em;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
	<thead id="cabecera_tBusquedaPrincipal">
	  <tr role="row" class="bg-primary">
		<th id="clickme" style="vertical-align:middle;" width="1%">#</th>
		<th style="vertical-align:middle;">NOMBRE GENERICO</th>
		<th style="vertical-align:middle;" nowrap>PRODUCTO</th>
		<th style="vertical-align:middle;" nowrap>LOTE</th>
		<th style="vertical-align:middle;" nowrap>F. CADUCIDAD</th>
		<th style="vertical-align:middle;" nowrap>EXIST.</th>
	  </tr>
	</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
	<tfoot>
		<tr class="bg-primary">
			<th><input type="hidden"></th>
			<th><input type="text" class="form-control input-sm" placeholder ="Nombre generico"></th>
			<th><input type="text" class="form-control input-sm" placeholder ="Producto"></th>
			<th><input type="text" class="form-control input-sm" placeholder ="Lote"></th>
			<th><input type="hidden"/></th>
			<th><input type="hidden"/></th>
		</tr>
	</tfoot>
</table>
<div style='border:1px solid none; text-align:left;'>
    <table id='ocultarFP' width='' border='0' cellspacing='0' cellpadding='6'>
        <tr>
            <td>SUCURSAL:</td>
            <td><select name='miSucursal' id='miSucursal' class='form-control input-sm'></select></td>
        </tr>
    </table>
	<input type='hidden' name='name_user_pdf' id='name_user_pdf'/>
</div>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {

	var horaPDF = new Date().toLocaleTimeString('es-MX', { hour12: false });

	//breadcrumb
	$('#breadc').html('<li><a href="index.php">FARMACIA</a></li><li class="active"><strong>INVENTARIO</strong></li>');
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-210;
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,
		"sScrollY": tamP,
		ordering: false, 
		searching: true, 
		scrollCollapse: false, 
		"scrollX": true, 
		scroller: false, 
		responsive: true,
		"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay){

		},
		"aoColumns":[ {"bVisible":true}, {"bVisible":true }, {"bVisible":true },{"bVisible":true }, {"bVisible":true }, {"bVisible":true },],
		"sDom": '<"filtro1Principal"f>Bl<"data_tPrincipal"t><"infoPrincipal"S>',
		buttons: [ 
			{ extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            //{ extend: 'pdfHtml5', footer: true },
			{
				extend: 'pdfHtml5',
				footer: true,
				customize: function (doc) {

					doc.content.unshift({
						text: $("#name_user_pdf").val() + " " + new Date().toLocaleTimeString('es-MX', { hour12: false }),
						style: 'titulo',
						alignment: 'center',
						margin: [0, 0, 0, 20] // margen inferior
					});

					doc.styles.titulo = {
						fontSize: 14,
						bold: true
					};
				}
			}
		],
		deferRender: true, 
		select: false, 
		"processing": false,
		"sAjaxSource": "inventario/datatable-serverside/inventario.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val();
			var de = $('#fechaDe').val();
            var a = $('#fechaA').val();
			var acceso = $('#acc_user').val();
            var idU = $('#id_user').val();
            var id_su = $("#miSucursal").val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } );
            aoData.push(  { "name": "id_su", "value": id_su });
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
	
    $("#miSucursal").load('pacientes/genera/genera_sucursales_ov.php?idU=' + $('#id_user').val(), function(response, status, xhr) {
        if (status = "success") {
            var datosUS = {
                idU: $('#id_user').val()
            }
            $.post('servicios/servicios/files-serverside/datosSucursalU.php', datosUS).done(function(data) {
                $("#miSucursal").val(data);
                $('#clickme').click();
                $("#miSucursal").change(function(e) {
                    $('#clickme').click();
                });
            });
        }
    });

	var datosUS = { idU: $('#id_user').val() }
	$.post('farmacia/files-serverside/getNameUser.php', datosUS).done(function(dataNUP) {
        $("#name_user_pdf").val(dataNUP);
    });

});

</script>
