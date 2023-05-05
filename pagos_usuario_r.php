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
    
    <title>SISTEMA - RECEPCIÓN - PAGOS POR USUARIO</title>
    
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
    <script src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
	<script src="TableTools-2.1.5/media/js/TableTools.js"></script>
    <script src="TableTools-2.1.5/media/js/ZeroClipboard.js"></script>
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="funciones/js/jquery.printElement.min.js" type="text/javascript"></script>
    <!-- Mis funciones -->
    <script src="funciones/js/inicio.js"></script>
    <script src="funciones/js/caracteres.js"></script>
    <script src="funciones/js/stdlib.js"></script>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="" style="border:1px none red; vertical-align:top; margin-top:0px; font-size: 1.2em;">
<table id="dataTable" width="90%" height="100%" class="table table-striped table-hover">
    <thead>
      <tr class="bg-primary">
		<th id="clickme" width="1px">#</th>
        <th>USUARIO</th>
        <th>REFERENCIA</th>
        <th>PACIENTE</th>
        <th>CONVENIO</th>
		<th>CAJA</th>
        <th>PAGO</th>
        <th nowrap style="white-space:nowrap">FECHA DE PAGO</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
		<tr class="bg-primary">
			<th><input type="hidden"></th>
			<th><input type="text" placeholder="Usuario" class="form-control input-sm"/></th>
			<th><input type="text" placeholder="Referencia" class="form-control input-sm" /></th>
            <th><input type="text" placeholder="Paciente" class="form-control input-sm" /></th>
			<th><input type="text" placeholder="Convenio" class="form-control input-sm"/></th>
			<th><input type="text" placeholder="Caja" class="form-control input-sm"/></th>
			<th><input type="hidden" class="sCalculo" /></th>
            <th><input type="hidden"><input type="text" placeholder="Fecha" class="form-control input-sm"/></th>
		</tr>
	</tfoot>
  </table>
  
  <div id="divRangoFechas" style="border:2px none red; display:block; width:100%; float:left;">
  <table width="100%" border="0" class="table-condensed">
  <tr>
    <td width="10px">De </td>
    <td width="1%">
        <input name="fechaDe" class="fechas form-control input-sm" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly >
    </td>
    <td width="10px">A </td>
    <td width="1%">
    	<input style="width:100px;" name="fechaA" type="text" class="fechas form-control input-sm" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly>
    </td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
  </tr>
</table>
</div>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>RECEPCIÓN</li><li>CORTE DE CAJA</li><li class="active"><strong>PAGOS POR USUARIO</strong></li>');
	
	$('.fechas').datepicker().on('changeDate', function(e){ $('#clickme').click(); });
		
	//para filtros con cuadro de textos individuales
	var asInitVals = new Array();
	//fin fintros con cuadro de texto indivicuales

	//$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	     	
	var tam = $('#referencia').height() - 242-$('#breadc').height(), wT = $('#referencia').width()*0.9;
	//$('#dataTable').css('width',100);
	var oTable = $('#dataTable').dataTable({
		//funciones para calcular los totales en los campos del pie de página
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			
			$("#miFiltroDeptos").change(function(e){ $('#clickme').click(); });
						
			$('.opcTable').css('float','left'); $('span.DataTables_sort_icon').remove();
			
            /* Calculate the market share for browsers on this page */
            var iAbonado = 0;
            for ( var i=iStart ; i<iEnd ; i++ ) { iAbonado += aaData[ aiDisplay[i] ][6]*1; }
             
            /* Modify the footer row to match what we want */
            var nCells = nRow.getElementsByTagName('th');
			nCells[6].innerHTML = '$'+redondear(parseFloat(iAbonado * 100)/100,2);
			
			window.setTimeout(function(){$('.erase1').each(function(index, element){ $(this).parent().parent().remove(); });},200);
        },
		//fin de funciones para calcular los totales en los campos del pie de página
		"bJQueryUI": false, "sScrollY": tam-27, "bAutoWidth": true, "bPaginate": true, "sPaginationType": "two_button", 
		"bStateSave": false, "bInfo": false, "bFilter": true, ordering: false,
		"aoColumnDefs": [ 
			{"bSortable":false, "aTargets":[0]}, {"bVisible": true,"aTargets": [ 1 ] }, {"bVisible": true,"aTargets": [ 2 ] },
			{"bVisible": true,"aTargets": [ 3 ] }, {"bVisible": true,"aTargets": [ 4 ] }, {"bVisible": true,"aTargets": [ 5 ] }, {"sClass":"right1","aTargets":[ 6 ] }
		],
		"aaSorting": [[1, "desc"]], "iDisplayLength": 500000000000000, "bLengthChange": false,
		"bProcessing": false, "bServerSide": true,
		"sDom": '<"opcTable"T><"filtro1"><"regis"l>r<"data_t"t><"infoPrincipal"i>',
		"oTableTools": {
			"sSwfPath": "TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{ "sExtends": "pdf", "sButtonText": "PDF", "sPdfOrientation": "landscape", "sPdfSize": "letter", "sPdfMessage": "Reporte de Ingresos." },
				{ "sExtends": "xls", "sButtonText": "EXCEL" },
				{ "sExtends": "copy", "sButtonText": "COPIAR" },
				{ "sExtends": "print", "sButtonText": "IMPRIMIR", "sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar." }
			]
		},
		"sAjaxSource": "corte_caja/reportes/datatable-serverside/reportes_pu_r.php",
 		"fnServerParams": function (aoData, fnCallback) {
			   var de = document.getElementById('fechaDe').value+' 00:00:00';
			   var a = $('#fechaA').val()+' 23:59:59';
			   var filtroDepto = $('#miFiltroDeptos').val();
			   var usuario = $('#id_user').val();

               aoData.push(  {"name": "min", "value": de /*'2013-02-01 00:00:00'*/ } );
               aoData.push(  {"name": "max", "value": a /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "depto", "value": filtroDepto /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "usuario", "value": usuario } );
        },
		"aLengthMenu": [[7, 15, 30, 100, -1], [7, 15, 30, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "_MENU_ REGISTROS",
			"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "MOSTRADOS: _END_",
			"sInfoEmpty": "MOSTRADOS: 0",
			"sInfoFiltered": "&nbsp;REGISTROS: _MAX_",
			"sSearch": "BUSCAR"
		}
	}); $('#clickme').click(function(e) { oTable.fnDraw(); });
	
	$('.regis').append('<div id="filtroDepto" style="border:1px none red; white-space:nowrap; width:60%; float:right;" align="right" class="hidden"><table width="100%" border="0" cellspacing="0" cellpadding="2"><tr style="display:;"><td align="right"><select style="max-width:300px;" name="miFiltroDeptos" id="miFiltroDeptos" class="form-control input-sm"><option value="x">-DEPARTAMENTOS-</option><?php do { ?> <option value="<?php echo $row_departamentosOV['id_d']?>"><?php echo $row_departamentosOV['nombre_d']?></option><?php } while ($row_departamentosOV = mysql_fetch_assoc($departamentosOV)); $rows = mysql_num_rows($departamentosOV); if($rows > 0) { mysql_data_seek($departamentosOV, 0); $row_departamentosOV = mysql_fetch_assoc($departamentosOV); }?></select></td></tr></table></div>');
	
	$('#nuevoVale').click(function(event) { event.preventDefault(); });
	
	$('#radio1').click(function(e) { $('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	
	$('#radio2').click(function(e) { $('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	
	$( "#fechaDe" ).datepicker({ 
		defaultDate: "-1", maxDate: +0, onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); }, 
		"onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); } 
	}).css('max-width','100px');
	
	$( "#fechaA" ).datepicker({ 
		defaultDate: "+0", maxDate: +0, onClose: function(selectedDate){ $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); }, 
		"onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); } 
	}).css('max-width','100px');
			
//para filtros con cuadro de textos individuales
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); });
	 /* Support functions to provide a little bit of 'user friendlyness' to the textboxes in the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; });
     
    $("tfoot input").focus(function (){ if(this.className == "search_init"){ this.className = ""; this.value = ""; } });
     
    $("tfoot input").blur(function(i){
        if(this.value == ""){ this.className = "search_init form-control input-sm"; this.value = asInitVals[$("tfoot input").index(this)]; }
    });
});

</script>
