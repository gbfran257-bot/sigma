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
    
    <title>SISTEMA - BITÁCORA DE LABORATORIO</title>
    
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
    <link href="DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">
    <link href="bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="sweetalert/dist/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="chosen/chosen.css">
    <link rel="stylesheet" href="chosen/chosen-bootstrap.css">
    <link href="jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
    <link href="c3/c3.css" rel="stylesheet">
</head>
<style>
	.formatoresultados{
		font-size: 10px;
	}
</style>
<?php include_once 'partes/header.php'; ?>
<input name="c_total" type="hidden" value="" id="c_total">
<input name="" type="hidden" value="" id="comi_total">
<input name="" type="hidden" value="" id="toting_total">
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:0px;">
<button type="button" class="btn btn-default" onClick="imprimir();">Imprimir <i class="fa fa-print"></i></button>
<button type="button" class="btn btn-info" onClick="filtro_pago();">Ocultar Pagados <i class="fa fa-search"></i></button><br>
<table border="0" cellspacing="0" id="dataTable" width="90%" height="100%" class="table-condensed table-striped table-hover">
    <thead>
      <tr class="bg-primary">
        <th width="8px" id="clickme">#</th>
        <th width="95px" style="white-space:nowrap;" id="t_refe">REFERENCIA</th>
        <th id="t_paci">PACIENTE</th>
        <th width="80px" id="t_fecha">FECHA</th>
        <th width="100px" id="t_sucu">SUCURSAL</th>
        <th width="100px" id="t_user">USUARIO</th>
        <th id="t_estu">ESTUDIOS</th>
        <th id="t_mues">MUESTRAS</th>
        <th id="t_tota">TOTAL ING</th>
        <th>COMISION</th>
		<th>A PAGAR</th>
        <th>SALDO</th>
        <th><input type="checkbox" name="seleccionartodos" id="check_pago" onclick="filtro_pago();"></th>
		<th>FECHA PAGO</th>
        <th>USUARIO PAGO</th>
		<th>VER</th>
      </tr>
    </thead>
    <tbody id="t_tbody"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
		<tr class="bg-primary">
			<th><input type="hidden"></th>
			<th><input type="text" placeholder="Referencia" class="form-control input-sm"/></th>
			<th><input type="text" style="width:200px;" placeholder="Paciente" class="form-control input-sm" /></th>
            <th><input type="hidden" class=""></th>
			<th>
            	<input type="hidden" class="">
                <input type="text" style="width:100px;" placeholder="Sucursal" class="form-control input-sm"/>
            </th>
			<th><input type="text" style="width:100px;" placeholder="Usuario" class="form-control input-sm" /></th>
            <th><input type="text" style="width:100px;" placeholder="Estudios" class="form-control input-sm" /></th>
            <th></th>
            <th></th>
			<th id="10"></th>
			<th id="t_total_comi"></th>
            <th id="t_total"></th>
            <th><button class='btn btn-icon btn-success' onclick="preparaPago();">P</button></th>
			<th></th>
            <th></th>
			<th></th>
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
function preparaPago(){
	var iCargosEAP=0;
	var data = [];
	$("input[name='apagarbitacora']").each(function(i, e){
		if($(this).prop("checked")){
			iCargosEAP += $(this).attr("amount")*1;
			data.push($(this).attr("idov"));
		}
	});
	iCargosEAP = redondear(parseFloat(iCargosEAP * 100)/100,2);
	swal({
	    title: "Realizar pago por "+iCargosEAP, text: "¿Deseas marcar como pagado?", type: "info", showCancelButton: true,
	    confirmButtonText: "Ok", cancelButtonText: "Salir", closeOnConfirm: false
	},
	function(){
		$.post("corte_caja/reportes/files-serverside/marcaPagado.php", {datos: data, monto: iCargosEAP}, function(r){
			swal({title: "Marcado como pagado", type:"success"});
			// location.reload();
		});
	});
}
function ver_depto(referencia,sucursal,nombre){
	$("#myModal").load('corte_caja/reportes/htmls/deptos.php', function(response, status, xhr){ if(status=="success"){
		$('#titulo_modal').text('REPORTE POR DEPARTAMENTO'); 
		$('#idUser_esc').val($('#id_user').val());

		var datosP={ref:referencia,sucu:sucursal}
		$.post('corte_caja/reportes/files-serverside/datos_deptos.php',datosP).done(function(data){
			var datos = data.split('_;}{');
			$('#nombre_paciente').text(nombre);
			$('#num_ref_t').text(referencia);
			$('#con_table').html(datos[0]);
			$('#total_ref').text(datos[1]);
		});
			
		
		$('#form-escuela').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
		  } else { // everything looks good!
			e.preventDefault(); 
			var datosP = $('#myModal #form-escuela').serialize();
			$.post('escuelas/files-serverside/addSchool.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $('#myModal').modal('hide'); //$('#btn_cancel_registro').show(); //$btn.button('reset');
					swal({ title: "", type: "success", text: "La escuela ha sido creada.", timer: 1800, showConfirmButton: false }); return;
				} else{alert(data);}
			});
		  }
		});
				
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function(e){ $('#form-escuela').validator(); });
		$('#myModal').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}
function imprimir(){
	var datosP={idU:$('#id_user').val()}
	$.post('corte_caja/reportes/files-serverside/datos_impre.php',datosP).done(function(data){
		var datos = data.split('_;}{');
		$('#t_tbody').prepend('<tr><td align="center" colspan="8"><strong>LISTA DE PACIENTES ENVIADOS. SUCURSAL: '+datos[1]+'. FECHA '+datos[2]+' '+datos[3]+'. USUARIO: '+datos[0]+'</strong></td></tr><tr><td><strong>#</strong></td><td><strong>REFERENCIA</strong></td><td><strong>PACIENTE</strong></td><td><strong>SUCURSAL</strong></td><td><strong>USUARIO</strong></td><td><strong>ESTUDIOS</strong></td><td><strong>MUESTRAS</strong></td><td align="center"><strong>TOTAL ING</strong></td><td align="center"><strong>COMI</strong></td><td align="center"><strong>A PAGAR</strong></td></tr>');
		$('#t_tbody').append('<tr><td></td><td></td><td></td><td></td><td></td><td></td><td align="center">TOTAL ING</td><td>'+$('#toting_total').val()+'</td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td align="center">COMISION</td><td>'+$('#comi_total').val()+'</td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td align="center">A PAGAR</td><td>'+$('#c_total').val()+'</td></tr><tr><td align="center" colspan="4" width="50%"><br><br><br><br><span style="text-decoration:overline">NOMBRE Y FIRMA DE QUIÉN ENTREGA</span></td><td align="center" colspan="4"><br><br><br><br><span style="text-decoration:overline">NOMBRE Y FIRMA DE QUIÉN RECIBE</span></td></tr>');
		$('#dataTable td:nth-child(4)').hide();
		$('#dataTable td:nth-child(5)').hide();
		$('#dataTable').printElement();
		setTimeout(function(){ $('#clickme').click(); }, 2000);
	});
}
function muestras(ref,id){
	var datosP={id:id}
	$.post('corte_caja/reportes/files-serverside/muestra_ov.php',datosP).done(function(data){
		$('#'+id).replaceWith('<textarea id="'+id+'" lang="'+ref+'" rows="4" style="resize:none;" placeholder="Para guardar los cambios, dé click fuera de este campo" onBlur="guardar_muestra(this.lang,'+id+',this.value)">'+data+'</textarea>');
	});
}

function guardar_muestra(ref,id,val){
	var datosP={id:id,user:$('#id_user').val(),val:val}
	$.post('corte_caja/reportes/files-serverside/guardar_muestra.php',datosP).done(function(data){
		if(data==1){
			if(val == ''){
			 $('#'+id).replaceWith('<span lang='+ref+' id="'+id+'" onDblClick="muestras('+ref+', '+id+');">Doble click para editar</span>');
			}
			else{$('#'+id).replaceWith('<span lang='+ref+' id="'+id+'" onDblClick="muestras('+ref+', '+id+');">'+val+'</span>');}
		}else{alert(data);}
	});
}
var oTable;
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>LABORATORIO</li><li class="active"><strong>BITÁCORA DE ESTUDIOS DE LABORATORIO</strong></li>');
	
	$('.fechas').datepicker().on('changeDate', function(e){ $('#clickme').click(); });
		
	//para filtros con cuadro de textos individuales
	var asInitVals = new Array();
	//fin fintros con cuadro de texto indivicuales
	
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
            var iCargosE=0;
            var iCargosEComi=0;
            var iCargosEAP=0;
			var total_a_Pagar = 0;
            for ( var i=iStart ; i<iEnd ; i++ ){
            	iCargosE += aaData[ aiDisplay[i] ][8]*1;
            	iCargosEComi += aaData[ aiDisplay[i] ][9]*1;
				total_a_Pagar += aaData[ aiDisplay[i] ][10]*1;
				total_a_Pagar -= aaData[ aiDisplay[i] ][11]*1
            	if(aaData[ aiDisplay[i] ][12] != 'P')
            		iCargosEAP += aaData[aiDisplay[i]][11]*1;
            }
             
            /* Modify the footer row to match what we want */
            var nCells = nRow.getElementsByTagName('th');
			nCells[7].innerHTML = '$'+redondear(parseFloat(iCargosE * 100)/100,2);
			nCells[8].innerHTML = '$'+redondear(parseFloat(iCargosEComi * 100)/100,2);
			nCells[9].innerHTML = '$'+redondear(parseFloat(total_a_Pagar * 100)/100,2);
			nCells[10].innerHTML = '$'+redondear(parseFloat(iCargosEAP * 100)/100,2);
			$('#c_total').val('$'+redondear(parseFloat(iCargosEAP * 100)/100,2));
			$('#toting_total').val('$'+redondear(parseFloat(iCargosE * 100)/100,2));
			$('#comi_total').val('$'+redondear(parseFloat(iCargosEComi * 100)/100,2));
			
			window.setTimeout(function(){$('.erase1').each(function(index, element){ $(this).parent().parent().remove(); });},200);
        },
		//fin de funciones para calcular los totales en los campos del pie de página
		"bJQueryUI": false, "sScrollY": tam-10, "bAutoWidth": false, "bPaginate": true, "sPaginationType": "two_button", 
		"bStateSave": false, "bInfo": false, "bFilter": true, ordering: false,
		"aoColumnDefs": [ 
			{"bSortable":false, "aTargets":[0]},{"bVisible": false,"aTargets": [3] },
			{"sClass":"right1","aTargets":[6] }, {"bVisible":true, "aTargets":[5]}
		],
		"aaSorting": [[3, "desc"]], "iDisplayLength": 500000000000000, "bLengthChange": false,
		"bProcessing": false, "bServerSide": true,
		"sDom": '<"opcTable"><"filtro1"><"regis"l>r<"data_t"t><"infoPrincipal"i>',
		"oTableTools": {
			"sSwfPath": "TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{
					"sExtends": "pdf", "sButtonText": "PDF",
					"sPdfOrientation": "landscape", "sPdfSize": "letter",
					"sPdfMessage": "Reporte de Ingresos."
				},
				{ "sExtends": "xls", "sButtonText": "EXCEL" },
				{ "sExtends": "copy", "sButtonText": "COPIAR" },
				{
					"sExtends": "print", "sButtonText": "IMPRIMIR",
					"sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar."
				}
			]
		},
		"sAjaxSource": "corte_caja/reportes/datatable-serverside/reportes_bitacora_lab.php",
 		"fnServerParams": function (aoData, fnCallback) {
			   var de = document.getElementById('fechaDe').value+' 00:00:00';
			   var a = $('#fechaA').val()+' 23:59:59';
			   var saldos = $('#saldos').val();
			   var filtroDepto = $('#miFiltroDeptos').val();
			   var usuario = $('#id_user').val();

               aoData.push(  {"name": "min", "value": de /*'2013-02-01 00:00:00'*/ } );
               aoData.push(  {"name": "max", "value": a /*'2013-02-15 23:59:59'*/ } );
			   aoData.push(  {"name": "saldos", "value": saldos /*'2013-02-15 23:59:59'*/ } );
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
	
	$('#nuevoVale').button({ icons: { primary: "ui-icon-plusthick" }, text: true });
	$('#nuevoVale').click(function(event) { event.preventDefault(); });
	
	$('#radio1').click(function(e) { 
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$('#radio2').click(function(e) { 
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$( "#fechaDe" ).datepicker({ 
		defaultDate: "-1", maxDate: +0, 
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); }, 
		"onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); } 
	}).css('max-width','100px');
	
	$( "#fechaA" ).datepicker({ 
		defaultDate: "+0", maxDate: +0, 
		onClose: function(selectedDate){ $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); }, 
		"onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); } 
	}).css('max-width','100px');
	
	$('#saldos').click(function(e) {
        if($(this).prop('checked')==true){ $(this).val('SI'); }else{$(this).val('NO');}
		oTable.fnDraw();
    });
		
//para filtros con cuadro de textos individuales
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); });
	 /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
     * the footer
     */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; });
     
    $("tfoot input").focus(function (){
        if(this.className == "search_init"){ this.className = ""; this.value = ""; }
    } );
     
    $("tfoot input").blur( function (i) {
        if ( this.value == "" ) { this.className = "search_init form-control input-sm"; this.value = asInitVals[$("tfoot input").index(this)]; }
    } );

    $("input[name='seleccionartodos']").click(function(e){
    	$("input[name='apagarbitacora]").prop("checked", true);
    	$(this).prop("checked", false);
    });
    $(document).on("click", "input[name='apagarbitacora']", function(){
    	var iCargosEAP=0;
    	$("input[name='apagarbitacora']").each(function(i, e){
    		if($(this).prop("checked")){
    			iCargosEAP += $(this).attr("amount")*1;
    		}
    	});
		$('#c_total').val('$'+redondear(parseFloat(iCargosEAP * 100)/100,2));
    	$(".dataTables_scrollFoot #t_total_comi").html($('#c_total').val());
    });
});

function filtro_pago(){
	console.log("estoy dentro");
	$("#dataTable tbody tr ").filter(function() {
		var td = $(this).prop('cells')[11].firstChild.tagName;
		if(td == "SPAN"){
			$(this).toggle();			
		}
	});
}

function pagar(ref, tot, sal, abo, pac, noTemp){
	$("#myModal").load("corte_caja/reportes/htmls/dialogPagarOV.php",function(response,status,xhr){if (status == "success"){
		$('#titulo_modal').text('PAGO A LA ORDEN DE VENTA '+ref+' DEL PACIENTE '+pac); $('#alerta_new_pago').hide();
		$('#totalOVP').val(tot); $('#abonadoOVP').val(abo); $('#saldoP').val(redondear(sal,2));
		$('#montoPagarP').keyup(function(e) {
			if( parseFloat($('#montoPagarP').val()) > parseFloat($('#saldoP').val()) ){ $('#montoPagarP').val($('#saldoP').val()); }
		});

		$('#montoPagarP').keyup(function(e) { $('#pagaConP, #cambioP').val(''); });
		
		$('#pagaConP').keyup(function(e) {
		 if( $(this).val() > parseFloat($('#montoPagarP').val()) ){
		  $('#cambioP').val(redondear(parseFloat($('#pagaConP').val())-parseFloat($('#montoPagarP').val()),2) );
		 }else{$('#cambioP').val('')}
		});
		$('#formaPagoP').load("corte_caja/reportes/genera/formas_pago.php",function(response,status,xhr){ if(status=="success"){
			$(this).val(1); window.setTimeout(function(){$('#montoPagarP').focus();},400);
			$('#formaPagoP').change(function(e) { 
				$('#montoPagarP, #pagaConP, #cambioP').val('');
				if($(this).val()!=''){ $('#montoPagarP').prop('readonly',false); $('#montoPagarP').focus(); }
				else{ $('#montoPagarP').prop('readonly',true); $('#ivaP').val(0); }
				//if($(this).val()==4){$('#numeroCheque').show();$('#noChequeP').focus();} else{$('#numeroCheque').hide();}
				if($(this).val()==1){ $('#pagaConP').prop('readonly',false); }else{$('#pagaConP').prop('readonly',true);}
			});
		} });
		
		$('#form-pagar').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta_new_pago").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_pago").slideUp(600); });
		  }else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_pago_ov').button('loading'); $('#btn_cancel_pago_ov').hide();
			
			var datosP={ref:ref,user:$('#id_user').val(),pago:$('#montoPagarP').val(),noTemp:noTemp,formaPagoP:$('#formaPagoP').val()}
			$.post('corte_caja/reportes/files-serverside/savePago.php',datosP).done(function(data){
				if(data==1){
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_pago_ov').show(); $('#myModal').modal('hide');
					//
					swal({
					  title: "PAGO REALIZADO", text: "¿Deseas imprimir el ticket?", type: "success", showCancelButton: true,
					  confirmButtonText: "Imprimir", cancelButtonText: "Salir", closeOnConfirm: false
					},
					function(){
						swal.close();
						$("#myModal1").load('pacientes/htmls/ticket.php', function( response, status, xhr ){ if(status=="success"){
							//var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-144;
							var oTableT = $('#dataTableResumenT').DataTable({
								serverSide:true,"sScrollY":'100%',ordering:false,searching:false,scrollCollapse:false,"scrollX": true,
								"fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){ },scroller:false,responsive:false,
								"aoColumns": [
									{ "bVisible": true }, { "bVisible": false }, { "bVisible": false }, { "bVisible": true }, 
									{ "bVisible": false }, { "bVisible": true }
								],
								"sDom": '<"filtroCt"><"infoCt"><"data_tCt"t>', 
								deferRender: true, select: false, "processing": false, 
								"sAjaxSource": "pacientes/js/datatable-serverside/totales_nvTi.php",
								"fnServerParams": function (aoData, fnCallback) { 
									var aleatorio = noTemp; 
									aoData.push(  {"name": "aleatorio", "value": aleatorio } );
								},
								"oLanguage": {
									"sLengthMenu":"MONSTRANDO _MENU_ records per page", "sZeroRecords":"LA ORDEN DE VENTA ESTA VACIA",
									"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": " CONCEPTOS: _MAX_", 
									"sSearch": "BUSCAR"
								},"iDisplayLength": 50000, paging: false,
							});
	
							var datosTi = {noAleatorio:ref}
							$.post('pacientes/files-serverside/datosTicket_a.php',datosTi).done(function(data){
								var datosT = data.split(';}'); if(datosT[5]==''){datosT[5]=0;} //alert(data);
								//para el ticket
								$('#fechaT').text(datosT[0]);$('#referenciaT').text(datosT[1]);$('#pacienteT').text(datosT[2]);
								$('#adicionalesT').text(datosT[10]);$('#totalT').text(datosT[4]);$('#pagoT').text(datosP.pago);
								$('#saldoT').text(redondear(-1*(parseFloat(datosT[31])),2));
								$('#usuarioIT').text(datosT[7]);$('#fechaIT').text(datosT[8]);
								$('#horaIT').text(datosT[9]); $('#formaPagoT').text(datosT[11]);
								$('#cantidadLetraT').text(nn(datosT[4])); $('#municipioS').text(datosT[16]);
								$('#calleSucursal').text(datosT[19]); $('#coloniaSucursal').text(datosT[18]);
								$('#cpSucursal').text(datosT[20]);$('#telefonoSucursal').text(datosT[21]);
								$('#municipioSucursal').text(datosT[17]);$('#estadoSucursal').text(datosT[15]);
								$('#sitioS').text(datosT[22]);$('#emailSucursal').text(datosT[23]);$('#descuentoT').text(datosT[24]);
								$('#subTotalT').text(datosT[29]);
								if(datosT[25]>0){
									x='sucursales/documentos/files/'+datosT[26]+'.'+datosT[27]+'?'+Math.round(Math.random()*1000);
									$('#myLogoS').html('<img src='+x+' width="150" style="border:5px none white; background-color:rgba(255, 255, 255, 1);">');
								}
								if(datosT[28]>0){ $('#myIva').removeClass('hidden'); }else{$('#myIva').addClass('hidden');}
								$('#ivaT').text(redondear(datosT[28],2)); $('#abonadoAT').text(redondear(parseFloat(datosT[30]),2));
								$('#abonosT').text(redondear(parseFloat(datosT[30])-parseFloat(datosP.pago),2));
								$('#saldosT').text(redondear(-1*(parseFloat(datosT[31])+parseFloat(datosP.pago)),2));
								$('#contenedorAnteriores, #myAbonadoA').removeClass('hidden');
								
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
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { $('#form-pagar').validator(); });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	} }); //fin de load
}

function imprimirFormatoR(sucursal, id){
	window.open("corte_caja/reportes/htmls/reporte_formato_resultados.php?sucursal="+sucursal+"&id="+id+"&atendio="+$('#id_user').val(), "_blank");
}

function imprimirSobre(id_p, referencia, ov){
	window.open("corte_caja/reportes/files-serverside/impresionSobre.php?id_p="+id_p+"&referencia="+referencia+"&ov="+ov, "_blank");
}
</script>
