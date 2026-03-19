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
    
    <title>SISTEMA - REPORTE DE PRODUCTIVIDAD MEDICOS</title>
    
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
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px; font-size: 1.2em;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
	<thead id="cabecera_tBusquedaPrincipal">
	  <tr role="row" class="bg-primary">
		<th id="clickme" style="vertical-align:middle;" width="1%">#</th>
		<th style="vertical-align:middle;">MÉDICO</th>
		<th style="vertical-align:middle;" nowrap>#VENTAS</th>
		<th style="vertical-align:middle;" nowrap>ASOCIACIÓN MÉDICA</th>
		<th style="vertical-align:middle;" nowrap>IMAGEN</th>
		<th style="vertical-align:middle;" nowrap>LABORATORIO</th>
		<th style="vertical-align:middle;" nowrap>TOTAL</th>
		<th style="vertical-align:middle;" nowrap>DESCUENTO</th>
	  </tr>
	</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
	<tfoot>
		<tr class="bg-primary">
			<th><input type="hidden"></th>
			<th><input type="text" class="form-control input-sm" placeholder="MÉDICO"/></th>
			<th><input type="hidden" class="sCalculo" /></th>
			<th><input type="hidden"></th>
			<th><input type="hidden" class="sCalculo" /></th>
			<th><input type="hidden" class="sCalculo" /></th>
			<th><input type="hidden" class="sCalculo" /></th>
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
	
	$('#breadc').html('<li>ADMINISTRACIÓN</li><li>CORTE DE CAJA</li><li class="active"><strong>REPORTE DE PRODUCTIVIDAD MEDICOS</strong></li>');
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-210;
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true, scroller: false, responsive: true,
		"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay){
			/* var iTotal = 0, iTotalV = 0, iTotalTotal=0, iTotalCosto=0, iTotalUtilidad=0, honorarios=0;
            for(var i=iStart ; i<iEnd ; i++){ 
				iTotalV += aaData[ aiDisplay[i] ][9]*1; 
				iTotalTotal += aaData[ aiDisplay[i] ][4]*1; 
				iTotalCosto += aaData[ aiDisplay[i] ][5]*1;
				iTotalUtilidad += aaData[ aiDisplay[i] ][6]*1;
			
			}

            var nCells = nRow.getElementsByTagName('th');
			nCells[2].innerHTML = redondear(parseFloat(iTotalV * 100)/100,2);
			nCells[4].innerHTML = redondear((parseFloat(iTotalTotal) * 100)/100,2);
            nCells[5].innerHTML = redondear((parseFloat(iTotalCosto) * 100)/100,2);
            nCells[6].innerHTML = redondear((parseFloat(iTotalUtilidad) * 100)/100,2); */

			var iTotal = 0;
			var iTotalAM = 0;
			var iTotalI = 0;
			var iTotalL = 0;
			var iTotalDesc = 0;

			for(var i=iStart ; i<iEnd ; i++){
				iTotal += aaData[ aiDisplay[i] ][6]*1;
				iTotalAM += aaData[ aiDisplay[i] ][3]*1;
				iTotalI += aaData[ aiDisplay[i] ][4]*1;
				iTotalL += aaData[ aiDisplay[i] ][5]*1;
				iTotalDesc += aaData[ aiDisplay[i] ][7]*1; 
			}

			var nCells = nRow.getElementsByTagName('th');
			nCells[6].innerHTML = redondear(parseFloat(iTotal * 100)/100,2);
			nCells[3].innerHTML = redondear(parseFloat(iTotalAM * 100)/100,2);
			nCells[4].innerHTML = redondear(parseFloat(iTotalI * 100)/100,2);
			nCells[5].innerHTML = redondear(parseFloat(iTotalL * 100)/100,2);
			nCells[7].innerHTML = redondear(parseFloat(iTotalDesc * 100)/100,2);

		},
		"aoColumns":[ {"bVisible":true}, {"bVisible":true },{ "bVisible": true },{"bVisible":true },{ "bVisible": true },{ "bVisible": true },{ "bVisible": true },{ "bVisible": true } ],
		"sDom": '<"filtro1Principal"f>Bl<"data_tPrincipal"t><"infoPrincipal"S>',
		buttons: [ 
			{ extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
		],
		deferRender: true, select: false, "processing": false,
		"oTableTools": {
			"sSwfPath": "TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{ "sExtends": "pdf", "sButtonText": "PDF", "sPdfOrientation": "landscape", "sPdfSize": "letter", "sPdfMessage": "Reporte de Ingresos." },
				{ "sExtends": "xls", "sButtonText": "EXCEL" },
				{ "sExtends": "copy", "sButtonText": "COPIAR" },
				{ "sExtends": "print", "sButtonText": "IMPRIMIR", "sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar." }
			]
		},
		"sAjaxSource": "corte_caja/reportes/datatable-serverside/prod_medicos.php",
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

function verConceptos(id_medico, nombre_medico){
	$("#myModal").load('corte_caja/reportes/htmls/verConceptos.php', function( response, status, xhr ){
		if(status=="success"){
			$("#titulo_modal_medico").text("CONCEPTOS DEL MEDICO " + nombre_medico + " DE LAS FECHAS " + $('#fechaDe').val() + " A " + $('#fechaA').val());

			//Este bloque tiene codigo necesario para mostrar informacion adicional
			function fnFormatDetails ( oTableP2, nTr, x) { 
				var tr = $(this).closest('tr');
				var aData = oTableP2.row(tr).data();
				var sOut = x; return sOut; 
			}

				var nCloneTh = document.createElement( 'th' );
				var nCloneTd = document.createElement( 'td' );
				nCloneTd.innerHTML = '<img src="imagenes/generales/details_open.png">';
				nCloneTd.className = "center";
				/* $('#dataTablePrincipal2 thead tr').each( function () { this.insertBefore( nCloneTh, this.childNodes[0] ); });
				$('#dataTablePrincipal2 tbody tr').each( function () { this.insertBefore( nCloneTd.cloneNode( true ), this.childNodes[0] ); }); */
			//

			var tamP2 = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-300-$('#breadc').height();
			var oTableP2 = $('#dataTablePrincipal2').DataTable({
				serverSide: true,"sScrollY": tamP2, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
					var iTotalPC = 0;
					var iTotalPago = 0;
					var iTotalDesc = 0;
					var iTotalExtra = 0;

					for(var i=iStart ; i<iEnd ; i++){
						iTotalPC += aaData[ aiDisplay[i] ][5]*1;
						iTotalPago += aaData[ aiDisplay[i] ][6]*1;
						iTotalDesc += aaData[ aiDisplay[i] ][7]*1;
						iTotalExtra += aaData[ aiDisplay[i] ][8]*1;
					}

					var nCells = nRow.getElementsByTagName('th');
					nCells[5].innerHTML = redondear(parseFloat(iTotalPC * 100)/100,2);
					nCells[6].innerHTML = redondear(parseFloat(iTotalPago * 100)/100,2);
					nCells[7].innerHTML = redondear(parseFloat(iTotalDesc * 100)/100,2);
					nCells[8].innerHTML = redondear(parseFloat(iTotalExtra * 100)/100,2);
				}, scroller: false, responsive: true,
				"aoColumns":[ {"bVisible":true}, {"bVisible":true }, {"bVisible":true }, { "bVisible": true },
						{ "bVisible": true }, { "bVisible": true }, { "bVisible": true }, { "bVisible": true }, { "bVisible": true }
				],
				"sDom": '<"filtro1Principal"f>Br<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
				deferRender: true, select: false, "processing": false,
				"oTableTools": {
					"sSwfPath": "TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
					"aButtons": [ 
						{ "sExtends": "pdf", "sButtonText": "PDF", "sPdfOrientation": "landscape", "sPdfSize": "letter", "sPdfMessage": "Reporte de Ingresos." },
						{ "sExtends": "xls", "sButtonText": "EXCEL" },
						{ "sExtends": "copy", "sButtonText": "COPIAR" },
						{ "sExtends": "print", "sButtonText": "IMPRIMIR", "sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar." }
					]
				}, 
				"sAjaxSource": "corte_caja/reportes/datatable-serverside/DoctorConceptos.php",
				"fnServerParams": function (aoData, fnCallback) { 
					var nombre = $('#top-search').val();
					var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
					var de = $('#fechaDe').val()+' 00:00:00';
					var a = $('#fechaA').val()+' 23:59:59';
					
					aoData.push( {"name": "nombre", "value": nombre } );
					aoData.push(  {"name": "accesoU", "value": acceso } );
					aoData.push(  {"name": "idU", "value": idU } );
					aoData.push(  {"name": "min", "value": de } ); 
					aoData.push(  {"name": "max", "value": a } );
					aoData.push(  {"name": "id_medico", "value": id_medico } );
				},
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "SERVICIOS FILTRADOS: _END_",
					"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},"iDisplayLength": 40, paging: true,
			});

			$('#clickme2').click(function(e) { oTableP2.draw(); }); window.setTimeout(function(){$('#clickme2').click();},500);
	
			oTableP2.columns().every( function () {
				var that = this;
		
				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
				} );
			} );
			$('#top-search').keyup(function(e) {
				$('#dataTablePrincipal_filter input').val($(this).val()); $('#dataTablePrincipal_filter input').keyup();
			}).focus();
			$('.filtro1Principal').addClass('hidden');

			/* $(document).delegate('#dataTablePrincipal2 tbody td img','click', function () {
				var tr = $(this).closest('tr');
var row = oTableP2.row(tr);

if (row.child.isShown()) {
    // Ya está abierto, lo cerramos
    this.src = "imagenes/generales/details_open.png";
    row.child.hide();
} else {
    // Está cerrado, lo abrimos
    var aData = row.data();
    this.src = "imagenes/generales/details_close.png";
	var ref = aData[1];
    var datoxOV = { ref: ref };

    $.post('corte_caja/reportes/datatable-serverside/datosAdicionales.php', datoxOV, function(dataOV){
        console.log(dataOV);
        row.child(fnFormatDetails(oTableP2, tr, dataOV)).show();
    });
}

			} ); */

			// En este bloque colocamos la logica de los datos que se agregaran a los registros de la datatable
			$(document).on('click', '#dataTablePrincipal2 tbody td img', function () {
				const tr = $(this).closest('tr');
				const row = oTableP2.row(tr);

				if (!row.data()) {
					console.warn("No se encontraron datos para esta fila");
					return;
				}

				if (row.child.isShown()) {
					this.src = "imagenes/generales/details_open.png";
					row.child.hide();
				} else {
					this.src = "imagenes/generales/details_close.png";

					const aData = row.data();
					const ref = aData[1];

					if (typeof ref === 'undefined') {
						console.error("ref no está definido en aData[1]", aData);
						return;
					}

					$.post('corte_caja/reportes/datatable-serverside/datosAdicionales.php', { ref: ref }, function (dataOV) {
						row.child(fnFormatDetails(oTableP2, tr, dataOV)).show();
					});
				}
			});
			//

			$('#myModal').modal('show');
			$('#myModal').on('shown.bs.modal', function (e) { });
			$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
		}
	});

}

</script>
