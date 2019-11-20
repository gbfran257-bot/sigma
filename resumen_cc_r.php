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
    <meta name="author" content="ING EMMANUEL ANZURES BAUTISTA">
    
    <title>SISTEMA - REPORTE GENERAL</title>
    
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
    <script src="sweetalert/dist/sweetalert.min.js"></script>
    <script src="funciones/js/jquery.media.js" type="text/javascript"></script>
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
    <link href="DataTables-1.10.13/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="DataTables-1.10.13/extensions/Select/css/select.bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
</head>
<?php include_once 'partes/header.php'; ?>

<div id="contenidoR" style="display:none; position:fixed; width:18.5cm; height:23cm; z-index:1;">
<table width="100%" height="" border="0" cellspacing="0" cellpadding="3">
  <tr> <td align="center" style="font-size:1.1em" height="10"> REPORTE DE CAJA GENERAL. FECHAS <span id="fechaRde"></span> <span id="fechaRa"></span></td> </tr>
  <tr>
    <td valign="top" height="" id="">
    	<table width="100%" height="" border="1" cellpadding="4" cellspacing="0" id="dataTableX">
            <thead id="cabecera_tBusquedaP"> <tr id="mymy"> 
            	<th id="clickmeX">DEPARTAMENTO</th> 
                <th nowrap>#VISITAS</th> 
                <th nowrap>#PACIENTES</th> 
                <th nowrap>#CONCEPTOS</th> 
                <th nowrap>TOTAL($)</th> 
            </tr> </thead>
            <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
            <tfoot>
                <tr>
                    <th><input type="hidden" value=""></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none; color:white;" value="0"/></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none; color:white;" value="0"/></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none; color:white;" value="0"/></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none; color:white;" value="0.00"/></th>
                </tr>
            </tfoot>
          </table>
    </td>
  </tr>
  <tr>
    <td height="">
    	<table width="100%" height="" border="1" cellpadding="4" cellspacing="0" id="dataTable1X">
            <thead id="cabecera_tBusquedaP1"> <tr id="mymy1"> <th id="clickme1X">USUARIO</th> <th nowrap>#PAGOS</th> <th nowrap>TOTAL($)</th> </tr> </thead>
            <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
            <tfoot>
                <tr>
                    <th><input type="hidden" value=""></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none; color:white;" value="0"></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none; color:white;" value="0.00"></th>
                </tr>
            </tfoot>
          </table>
    </td>
  </tr>
  <tr>
  <td> <table width="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td valign="top" height="180px;">Aclaraciones:</td> </tr> </table> </td>
  </tr>
</table>
</div>

<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:0px; font-size: 1.2em;">
<h3 align="center">REPORTE DE CAJA GENERAL <button type="button" class="btn btn-primary btn-sm" id="imprimirReporte">IMPRIMIR</button></h3>
<table width="100%" height="94.5%" class="" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" id="tabla1">
    	<table width="100%" id="dataTable" class="table" height="100%">
            <thead id="cabecera_tBusquedaP">
              <tr id="mymy" class="bg-primary">
                <th id="clickme">DEPARTAMENTO</th>
                <th nowrap>#VISITAS</th>
                <th nowrap>#PACIENTES</th>
                <th nowrap>#CONCEPTOS</th>
                <th nowrap>TOTAL($)</th>
              </tr>
            </thead>
            <tbody align=""> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
            <tfoot>
                <tr class="bg-primary">
                    <th><input type="hidden" value=""></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none;" value="0"/></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none;" value="0"/></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none;" value="0"/></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none;" value="0.00"/></th>
                </tr>
            </tfoot>
          </table>
    </td>
  </tr>
  <tr>
    <td height="" valign="top">
    	<table width="100%" id="dataTable1" class="table">
            <thead id="cabecera_tBusquedaP1">
              <tr id="mymy1" class="bg-primary">
                <th id="clickme1">USUARIO</th>
                <th nowrap>#PAGOS RECIBIDOS</th>
                <th nowrap>TOTAL($)</th>
              </tr>
            </thead>
            <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
            <tfoot>
                <tr class="bg-primary">
                    <th><input type="hidden" value=""></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none;" value="0"></th>
                    <th><input type="text" class="sCalculo" readonly style="background-color:transparent; border:none;" value="0.00"></th>
                </tr>
            </tfoot>
          </table>
    </td>
  </tr>
  <tr>
    <td height="1%" valign="bottom">
    	<div id="divRangoFechas" style="text-align:left;">
			<table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;">
				<tr>
					<td width="10px">&nbsp; De &nbsp;</td>
					<td width="1%">
						<input name="fechaDe" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly >
					</td>
					<td width="10px">&nbsp; A &nbsp;</td>
					<td width="1%">
						<input style="width:100px;" name="fechaA" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly>
					</td>
					<td id="rangosFechas">
						&nbsp;<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label>
						<input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label>
					</td>
				</tr>
			</table>
		</div>
    </td>
  </tr>
</table>

</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
//para fintro individual por campo de texto
var asInitVals = new Array();
//fin para filtro individual por campo de texto

$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li class="active"><strong>RESUMEN DEL CORTE DE CAJA</strong></li>');
	
	$('#div_tabla_pacientes').height($('#referencia').height()-$('#my_nav').height()-$('#my_footer').height()-30-$('#breadc').height());
	
	$('#imprimirReporte').click(function(e){
		if($('#fechaDe').val()=='2000-01-01'){ $('#fechaRde').html('TODAS LAS FECHAS'); $('#fechaRa').html('');
		}else{ $('#fechaRde').html('DE '+$('#fechaDe').val()); $('#fechaRa').html('A '+$('#fechaA').val()); }
		window.setTimeout(function(){$('#clickmeX').click();},200);
		$('#clickmeX').click(); $('#contenidoR').show().printElement().hide(); 
	});
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; $('#top-search').addClass('hidden');

	var tam = ($('#referencia').height())*0.42, tam1 = ($('#referencia').height())*0.35;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			var iTotal = 0, iComision=0, iIngreso = 0, iVisitas = 0;
            for ( var i=iStart ; i<iEnd ; i++ )
            {
				iVisitas  += aaData[ aiDisplay[i] ][1]*1;
                iTotal    += aaData[ aiDisplay[i] ][2]*1;
				iComision += aaData[ aiDisplay[i] ][3]*1;
				iIngreso  += aaData[ aiDisplay[i] ][4]*1;
            }
            var nCells = nRow.getElementsByTagName('th');
			nCells[1].innerHTML = parseInt(iVisitas  * 100)/100;
            nCells[2].innerHTML = parseInt(iTotal    * 100)/100;
			nCells[3].innerHTML = parseInt(iComision * 100)/100;
			nCells[4].innerHTML = '$'+parseInt(iIngreso  * 100)/100;
			
			window.setTimeout(function(){$('.erase1').each(function(index, element) { $(this).parent().parent().remove(); });},200);
		},
		"bJQueryUI":false, "bScrollCollapse":true, "sScrollY":tam1, "bAutoWidth":false, "bStateSave":false, "bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]],
		"aoColumns":[
			{"bSortable":false},{"bSortable":false, "sClass": "centrado"},{"bSortable": false, "sClass": "centrado"}, { "bSortable": false, "sClass": "centrado"},
			{ "bSortable": false, "sClass": "centrado"}
		],
		"iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info">',
		"sAjaxSource": "caja/datatable-serverside/reporte.php",
		"fnServerParams": function (aoData, fnCallback){
			var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
			aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } );
		},
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN MOVIMIENTOS REGISTRADOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw();});
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */ oTable.fnFilter( this.value, $("tfoot input").index(this) ); });
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = ""; } } );
     
    $("tfoot input").blur( function (i) { 
		if(this.value=="") { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)];myFunction(); } 
	} );
	//fin filtros individuales por campo de texto
	
	//para los filtros individuales por select
	/* Add a select menu for each TH element in the table footer */
    $("tfoot td .miSelect").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
        $('select', this).change( function () { oTable.fnFilter( $(this).val(), i ); });
    } );
	$('#s_urg').change( function () { oTable.fnFilter( $(this).val(), 3 ); });
	$('#s_estatus').change( function () {  oTable.fnFilter( $(this).val(), 5 ); });
	//fin para filtros individuales por select
	
	$('#radio1').click(function(e) { $('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw(); });
	$('#radio2').click(function(e) { $('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw(); });
	$( "#fechaDe" ).datepicker({
	  	defaultDate: "-1", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); },
		"onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw(); }
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({
		defaultDate: "+0", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); },
		"onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw(); }
	}).css('max-width','100px');
	
	oTable1 = $('#dataTable1').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			var iComision=0, iIngreso = 0;
            for ( var i=iStart ; i<iEnd ; i++ )
            {
				iComision += aaData[ aiDisplay[i] ][1]*1;
				iIngreso  += aaData[ aiDisplay[i] ][2]*1;
            }
            var nCells = nRow.getElementsByTagName('th');
			nCells[1].innerHTML = parseInt(iComision * 100)/100;
			nCells[2].innerHTML = '$'+parseInt(iIngreso  * 100)/100;
		},
		"bJQueryUI": false, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns":[{ "bSortable": false },{ "bSortable": false, "sClass": "centrado"},{ "bSortable": false, "sClass": "centrado"}],
		"iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info">', "sAjaxSource": "caja/datatable-serverside/reporte1_r.php",
		"fnServerParams": function (aoData, fnCallback) { var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59'; aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } ); },
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "NO HAY MOVIMIENTOS REGISTRADOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme1').click(function(e) { oTable1.fnDraw();});
	
	oTableX = $('#dataTableX').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
			var iTotal = 0, iComision=0, iIngreso = 0, iVisitas = 0;
            for ( var i=iStart ; i<iEnd ; i++ )
            {
				iVisitas  += aaData[ aiDisplay[i] ][1]*1;
                iTotal    += aaData[ aiDisplay[i] ][2]*1;
				iComision += aaData[ aiDisplay[i] ][3]*1;
				iIngreso  += aaData[ aiDisplay[i] ][4]*1;
            }
            var nCells = nRow.getElementsByTagName('th');
			nCells[1].innerHTML = parseInt(iVisitas    * 100)/100;
            nCells[2].innerHTML = parseInt(iTotal    * 100)/100;
			nCells[3].innerHTML = parseInt(iComision * 100)/100;
			nCells[4].innerHTML = '$'+parseInt(iIngreso  * 100)/100;
		},
		"bJQueryUI": false, "bScrollInfinite": true, "bScrollCollapse": true, "bAutoWidth": false, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns": [{ "bSortable": false }, { "bSortable": false, "sClass": "centrado"},{ "bSortable": false, "sClass": "centrado"}, { "bSortable": false, "sClass": "centrado"}, { "bSortable": false, "sClass": "centrado"}],
		"iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info">', "sAjaxSource": "caja/datatable-serverside/reporte_r.php",
		"fnServerParams": function (aoData, fnCallback) { var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59'; aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } ); },
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickmeX').click(function(e) { oTableX.fnDraw(); });
	
	oTable1X = $('#dataTable1X').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			var iComision=0, iIngreso = 0;
            for ( var i=iStart ; i<iEnd ; i++ )
            {
				iComision += aaData[ aiDisplay[i] ][1]*1;
				iIngreso  += aaData[ aiDisplay[i] ][2]*1;
            }
            var nCells = nRow.getElementsByTagName('th');
			nCells[1].innerHTML = parseInt(iComision * 100)/100;
			nCells[2].innerHTML = '$'+parseInt(iIngreso  * 100)/100;
		},
		"bJQueryUI": false, "bScrollInfinite": true, "bScrollCollapse": true, "bAutoWidth": false, "bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns":[{ "bSortable": false },{ "bSortable": false, "sClass": "centrado"},{ "bSortable": false, "sClass": "centrado"}],
		"iDisplayLength": 50, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info">', "sAjaxSource": "caja/datatable-serverside/reporte1.php",
		"fnServerParams": function (aoData, fnCallback) { var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59'; aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } ); },
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme1X').click(function(e) { oTable1X.fnDraw(); });
	
	$('#radio1').click(function(e){
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>');$('#fechaA').val('<?php echo date("Y-m-d"); ?>'); 
		oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw();
	});
	
	$('#radio2').click(function(e){
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); 
		oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw();
	});
	
	$('#fechaDe').on('changeDate', function(e) { oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw(); });
	$("#fechaA").on('changeDate', function(e) { oTable.fnDraw(); oTableX.fnDraw(); oTable1.fnDraw(); oTable1X.fnDraw(); });
});
</script>