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
    
    <title>SISTEMA - ADMINISTRACIÓN - REPORTE PRODUCTIVIDAD</title>
    
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
	<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Mainly scripts -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="jquery-ui-1.12.0/jquery-ui.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <!-- <script src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
	<script src="TableTools-2.1.5/media/js/TableTools.js"></script>
    <script src="TableTools-2.1.5/media/js/ZeroClipboard.js"></script> -->
	<script src="DataTables-1.12/DataTables-1.12.1/js/jquery.dataTables.min.js"></script>
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
    <script src="funciones/js/cantidad_a_letra.js"></script>
    <script src="funciones/js/calcula_edad.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    <script src="funciones/js/bs-modal-fullscreen.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- <link href="DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet"> -->
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
<div id="div_tabla_pacientes" class="" style="border:1px none red; vertical-align:top; margin-top:5px; margin-botom:10px font-size: 1.2em;">
<table id="dataTable" width="90%" height="100%" class="table table-striped table-hover">
    <thead>
      <tr class="bg-primary">
        <th width="100px" id="clickme" style="white-space:nowrap;">REFERENCIA</th>
        <th style="white-space:nowrap;">
			PACIENTE
            <button class="btn btn-info btn-xs" id="btn-buscar" name="btn-buscar" type="button">BUSQUEDA <i class="fa fa-search" aria-hidden="true"></i></button>
		</th>
        <th width="">SUCURSAL</th>
        <th width="">USUARIO</th>
		<th width="">F. PAGO</th>
        <th width="10px">SUBTOTAL</th>
        <th width="10px" nowrap style="white-space:nowrap">EXTRAS</th>
        <th width="10px">DESCUENTO</th>
        <th width="10px">TOTAL</th>
        <th width="10px">ABONADO</th>
        <th width="10px">SALDO</th>
        <th width="">C. PROD.</th>
        <th width="">HONORARIOS</th>
        <th width="20px">UTILIDAD</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
		<tr class="bg-primary">
			<th><input type="hidden"></th>
            <th><input type="text" id="input-referencia" name="input-referencia" placeholder="Referencia" class="form-control input-sm entrada-texto"/></th>
            <th><input type="text" id="input-paciente" name="input-paciente" placeholder="Paciente" class="form-control input-sm entrada-texto" /></th>
            <th> <input type="hidden" class=""> <select class='form-control input-sm select_filtro_sucursal' id='select_filtro_sucursal' style='width:100%;' onChange='filtro_sucursal_ov(this.value)'></select> </th>
            <th><input type="text" id="input-usuario" name="input-usuario" placeholder="Usuario" class="form-control input-sm entrada-texto" /></th>
            <th><select class='form-control input-sm select_forma_pago' id='select_forma_pago' style='width:100%;' onChange='filtro_forma_pago(this.value)'></select></th>
            <th><input type="hidden" class="sCalculo" /></th>
            <th><input type="hidden" class="sCalculo" /></th>
            <th><input type="hidden" class="sCalculo" /></th>
            <th><input type="hidden" class="sCalculo" /></th>
            <th><input type="hidden" class="sCalculo" /></th>
            <th><input type="hidden" class="sCalculo" /></th>
            <th><input type="hidden" class="" /></th>
            <th><input type="hidden" placeholder="" class="" /></th>
            <th><input type="hidden" class="" /></th>
		</tr>
	</tfoot>
  </table>

  <div id="divRangoFechas" style="border:2px none red; display:block; width:100%; float:left;">
  <table width="100%" border="0" class="table-condensed">
  <tr>
    <td width="10px">De </td>
    <td width="1%">
	<input name="fechaDe" class="fechass form-control datetimepicker-input" style="width:140px;" type="text" id="fechaDe" data-toggle="datetimepicker" data-target="#fechaDe" value="<?php echo date("Y-m-d ")."00:00"; ?>"/>
    </td>
    <td width="10px">A </td>
    <td width="1%">
	<input style="width:140px;" name="fechaA" type="text" class="fechass form-control" data-toggle="datetimepicker" id="fechaA" value="<?php echo date("Y-m-d ")."23:59"; ?>"/>
    </td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td>
        <label style="color: #0003adff; font-size:20px;">UTILIDAD REAL: </label> <span id="utilidadReal" name="utilidadReal" style="font-size:20px;"></span>
    </td>
  </tr>
</table>
</div>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
	var oTable;
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li>CORTE DE CAJA</li><li class="active"><strong>PRODUCTIVIDAD ORDENES</strong></li>');
	
	$('.fechas').datepicker().on('changeDate', function(e){ $('#clickme').click(); });
	
	//función para la info de detalle de cada registro
	function fnFormatDetails ( oTable, nTr, x) { var aData = oTable.fnGetData( nTr ); var sOut = x; return sOut; }
	//función para la info de detalle de cada registro
	
	//para filtros con cuadro de textos individuales
	var asInitVals = new Array();
	//fin fintros con cuadro de texto indivicuales

	//$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	/* * Insert a 'details' column to the table */
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    nCloneTd.innerHTML = '<img src="imagenes/generales/details_open.png">';
    nCloneTd.className = "center";
    $('#dataTable thead tr').each( function () { this.insertBefore( nCloneTh, this.childNodes[0] ); });
     
    $('#dataTable tbody tr').each( function () { this.insertBefore( nCloneTd.cloneNode( true ), this.childNodes[0] ); });
	
	var tam = $('#referencia').height() - 242-$('#breadc').height();
	var wT = $('#referencia').width()*0.9;
	//$('#dataTable').css('width',100);
	oTable = $('#dataTable').dataTable({
		//funciones para calcular los totales en los campos del pie de página
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$( '#rangosFechas' ).buttonset();
			
			$("#miFiltroDeptos").change(function(e){ $('#clickme').click(); });
						
			$('.opcTable').css('float','left');
			$('span.DataTables_sort_icon').remove();
            /* Calculate the market share for browsers on this page */
			//window.setTimeout(function(){$('.erase1').each(function(index, element){ $(this).parent().parent().remove(); });},200);*/

            var subtotal = 0;
            var extras = 0;
            var descuento = 0;
            var total = 0;
            var abonado = 0;
            var saldo = 0;
            var costo_produccion = 0;
            var utilidad = 0;
            var honorarios = 0;
            
            for (var i=iStart ; i<iEnd ; i++ )
            {
                subtotal += aaData[ aiDisplay[i] ][6]*1;
                extras += aaData[ aiDisplay[i] ][7]*1;
                descuento += aaData[ aiDisplay[i] ][8]*1;
                total += aaData[ aiDisplay[i] ][9]*1;
                abonado += aaData[ aiDisplay[i] ][10]*1;
                saldo += aaData[ aiDisplay[i] ][11]*1;
                costo_produccion += aaData[ aiDisplay[i] ][12]*1;
                honorarios += aaData[ aiDisplay[i] ][13]*1;
                utilidad += aaData[ aiDisplay[i] ][14]*1;
            }

            var nCells = nRow.getElementsByTagName('th');
            nCells[6].innerHTML = '$'+redondear(parseFloat(subtotal * 100)/100,2);
            nCells[7].innerHTML = '$'+redondear(parseFloat(extras * 100)/100,2);
            nCells[8].innerHTML = '$'+redondear(parseFloat(descuento * 100)/100,2);
            nCells[9].innerHTML = '$'+redondear(parseFloat(total * 100)/100,2);
            nCells[10].innerHTML = '$'+redondear(parseFloat(abonado * 100)/100,2);
            nCells[11].innerHTML = '$'+redondear(parseFloat(saldo * 100)/100,2);
            nCells[12].innerHTML = '$'+redondear(parseFloat(costo_produccion * 100)/100,2);
            nCells[13].innerHTML = '$'+redondear(parseFloat(honorarios * 100)/100,2);
            nCells[14].innerHTML = '$'+redondear(parseFloat(utilidad * 100)/100,2);

            utilidadRed = redondear(parseFloat(utilidad * 100)/100,2);
            saldoRed = redondear(parseFloat(saldo * 100)/100,2);
            utilidad_real = redondear(utilidadRed - saldoRed,2);

            $("#utilidadReal").text("$" + utilidad_real);
        },
		//fin de funciones para calcular los totales en los campos del pie de página
		"bJQueryUI": false, "sScrollY": tam-60, "bAutoWidth": true, "bPaginate": true, "sPaginationType": "two_button", 
		"bStateSave": false, "bInfo": true, "bFilter": true, ordering: false,
		"aoColumnDefs": [ 
			{"bSortable":false, "aTargets":[0]}
		],
		"aaSorting": [[3, "desc"]], "iDisplayLength": 6000, "bLengthChange": false,
		"bProcessing": false, "bServerSide": true,
		"sDom": '<"opcTable"T><"filtro1"><"regis"l>B1<"data_t"t><"infoPrincipal"i>',
		buttons: [ 
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],
		"sAjaxSource": "corte_caja/reportes/datatable-serverside/reportes_productividad_ordenes.php",
 		"fnServerParams": function (aoData, fnCallback) {
			   var de = $('#fechaDe').val();
			   var a = $('#fechaA').val();
			   var usuario = $('#id_user').val();
               var filtro_pago = $('#select_forma_pago').val();
			   var filtro_sucursal = $('#select_filtro_sucursal').val();

               aoData.push(  {"name": "min", "value": de } );
               aoData.push(  {"name": "max", "value": a } );
			   aoData.push(  {"name": "usuario", "value": usuario } );
               aoData.push(  {"name": "filtro_pago", "value": filtro_pago } );
			   aoData.push(  {"name": "filtro_sucursal", "value": filtro_sucursal } );
        },
		"aLengthMenu": [[7, 15, 30, 100, -1], [7, 15, 30, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "_MENU_ REGISTROS", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0",
			"sInfoFiltered": "&nbsp;REGISTROS: _MAX_", "sSearch": "BUSCAR"
		}
	}); 
	
	$(".entrada-texto").on("keypress", function(event) {
		// Verificar si la tecla presionada es "Enter" (código 13)
		if (event.keyCode === 13) {
			// Hacer clic en el botón
			$("#btn-buscar").click();
		}
    });

	$('#clickme').click(function(e) { oTable.fnDraw(); });
	
	$('#nuevoVale').button({ icons: { primary: "ui-icon-plusthick" }, text: true });
	$('#nuevoVale').click(function(event) { event.preventDefault(); });
	
	$('#radio1').click(function(e) { 
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?> 00:00'); $('#fechaA').val('<?php echo date("Y-m-d"); ?> 23:59'); oTable.fnDraw(); 
	});
	$('#radio2').click(function(e) { 
		$('#fechaDe').val('2000-01-01 00:00'); $('#fechaA').val('<?php echo date("Y-m-d "); ?> 23:59'); oTable.fnDraw(); 
	});
	$("#fechaDe, #fechaA").datetimepicker({
		locale: 'es-MX',
		format: 'YYYY-MM-DD HH:mm',
		useCurrent: false
	});
	/*$('#fechaA').data("DateTimePicker").minDate($('#fechaDe').val());
	$('#fechaDe').data("DateTimePicker").maxDate($('#fechaA').val());
	$('#fechaDe').on('dp.change', function(e) { 
        $('#fechaA').data("DateTimePicker").minDate(e.date);
		oTable.fnDraw();
	});
	$('#fechaA').on('dp.change', function(e) { 
        $('#fechaDe').data("DateTimePicker").maxDate(e.date);
		oTable.fnDraw();
	});*/ //Este bloque se comenta para evitar que realize la busqueda en automatico al cambiar las fechas, sin embargo el codigo si funciona
	
	$(document).delegate('#dataTable tbody td img','click', function () {
        var nTr = $(this).parents('tr')[0];
        if (oTable.fnIsOpen(nTr)){ /* This row is already open - close it */
            this.src = "imagenes/generales/details_open.png"; oTable.fnClose( nTr );
        }
        else
        { /* Open this row */
			var aData = oTable.fnGetData( nTr );
			this.src = "imagenes/generales/details_close.png";
			var so = aData[5], so1=aData[8],ref=aData[1], depto = aData[6], area = aData[7], total = aData[9];
			var datoxOV ={ ref:ref }
			$.post('corte_caja/reportes/datatable-serverside/datosAdicionalesRepOrdenes.php',datoxOV,processDataOV);//salva la OV
			function processDataOV(dataOV) {
		  		console.log(dataOV); var text = dataOV.split('/');
	            oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr, dataOV/*text[0], text[1], text[2]*/), 'details' );
       		} // end processDataOV
        }
    } );
	// fin  Add event listener for opening and closing details

	$("#btn-buscar").click(function e() {
		var that = this;
		oTable.fnFilter($("#input-referencia").val(), 1);
		oTable.fnFilter($("#input-paciente").val(), 2);
		oTable.fnFilter($("#input-sucursal").val(), 3);
		oTable.fnFilter($("#input-usuario").val(), 4);
		oTable.fnFilter($("#input-pago").val(), 5);
		oTable.fnFilter($("#input-motivo-d").val(), 7);
		oTable.fnDraw();
    });
	 /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
     * the footer
     */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; });
     
    $("tfoot input").focus(function (){
        if(this.className == "search_init"){ this.className = ""; this.value = ""; }
    } );
     
    /*$("tfoot input").blur( function (i) {
        if ( this.value == "" ) { this.className = "search_init form-control input-sm"; this.value = asInitVals[$("tfoot input").index(this)]; }
    } );*/

    $('#select_forma_pago').load('corte_caja/reportes/files-serverside/getFormaPago.php');
	$('#select_filtro_sucursal').load('corte_caja/reportes/files-serverside/getSucursales.php');
});

function filtro_forma_pago(id){
	$('#clickme').click();
}

function filtro_sucursal_ov(id){
	$('#clickme').click();
}



</script>
