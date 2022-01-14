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
    
    <title>SISTEMA - CATÁLOGO CONSULTAS</title>
    
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
    <th style="vertical-align:middle; white-space:nowrap;">NOMBRE DE LA CONSULTA</th>
    <th style="vertical-align:middle;">MÉDICO</th>
    <th style="vertical-align:middle;">PRECIO</th>
    <th style="vertical-align:middle;" nowrap>PRECIO URGENCIA</th>
    <th style="vertical-align:middle;" nowrap>PRECIO MEMBRESÍA</th>
    <th style="vertical-align:middle;" nowrap>PMEMBRESÍA URGENCIA</th>
    <th style="vertical-align:middle;" nowrap>PRECIO HOSPITAL</th>
    <th style="vertical-align:middle;" nowrap>PHOSPITAL URGENCIA</th>
	<th style="vertical-align:middle;" nowrap>LÍNEA</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Consulta"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Médico" style="max-width:100px;"/></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
			<th><input type="text" class="form-control input-sm" placeholder="línea" style="max-width:100px;"/></th>
        </tr>
    </tfoot>
</table>
<div style='border:1px solid none; text-align:left;'><table id='ocultarFP' width='' border='0' cellspacing='0' cellpadding='6'> <tr><td>CONVENIO</td><td><select name='miSucursal' id='miSucursal' class='form-control input-sm'></select></td></tr> </table></div>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>CONSULTAS</li><li class="active"><strong>CATÁLOGO DE CONSULTAS</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-145-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "consultas/consultas/datatable-serverside/consultas_c.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val(); var de = $("#miSucursal").val();
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } ); aoData.push({"name": "idSu", "value": de });
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
 
		$( 'input', this.footer() ).on( 'keyup change', function () { if ( that.search() !== this.value ) { that .search( this.value ) .draw(); } } );
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
				$("#miSucursal").val(data); $('#clickme').click(); $("#miSucursal").change(function(e) { $('#clickme').click(); });
			});
		}
	});
	//$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='100%' border='1' cellspacing='0' cellpadding='6'> <tr><td><select name='miSucursal' id='miSucursal' class='form-control input-sm'></select></td></tr> </table></div>" );
});

function nuevoEstudio(){
	$("#myModal").load("imagen/estudios/htmls/ficha_estudio.php",function(response,status,xhr){ if(status=="success"){
		$('.tabulacion').remove();
		$("#miSucursalNS").load('pacientes/genera/genera_sucursales_ov.php?idU='+$('#id_user').val(),function(response,status,xhr){
			if (status = "success"){
				var datosUS = {idU:$('#id_user').val()}
				$.post('servicios/servicios/files-serverside/datosSucursalU.php',datosUS).done(function(data){ $("#miSucursalNS").val(data); });
			}
		});
		$('#idUsuarioE').val($('#id_user').val());
		$('#areaE').load('imagen/estudios/genera/areasEstudios.php', function( response, status, xhr ){ });
		$('#input').jqte(); $('#input').jqteVal('');
		$('.jqte_editor').css('height',$('#myModal').height()*0.45);
		
		$('#formEstudio').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta1").fadeTo(2000,500).slideUp(500,function(){ $("#alerta1").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
			$('#miDiagnostico').val($('.jqte_editor').html());
			var datosP = $('#myModal #formEstudio').serialize();
			$.post('imagen/estudios/files-serverside/addEstudio.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel1').show(); $('#myModal').modal('hide');
					swal({
					  title: "", type: "success", text: "El estudio se ha creado.", timer: 2000, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { $('#formEstudio').validator(); });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	} });
}
function fichaEstudio(idE){
	$("#myModal1").load("imagen/estudios/htmls/ficha_estudio.php",function(response,status,xhr){ if(status=="success"){
		$('#btn_save1').text('Actualizar');
		var datos ={idE:idE, idSucursal:$('#miSucursal').val()}
		$.post('imagen/estudios/files-serverside/fichaEstudio.php',datos).done(function( data1 ) {
			var datosI = data1.split('*}');
			
			$("#miSucursalNS").load('pacientes/genera/genera_sucursales_ov.php?idU='+$('#id_user').val(),function(response,status,xhr){
				if (status = "success"){
					$("#miSucursalNS").val($('#miSucursal').val());
				}
			});
			$('#idUsuarioE').val($('#id_user').val()); $('#idEstudioE').val(idE);
			$('#areaE').load('imagen/estudios/genera/areasEstudios.php', function( response, status, xhr ){
				$(this).val(datosI[1]);
			});
			$('#input').jqte(); $('#input').jqteVal(datosI[4]);
			$('.jqte_editor').css('height',$('#myModal').height()*0.45);
			$('#nombreE').val(datosI[0]); $('#precioE').val(datosI[2]); $('#precioUrgenciaE').val(datosI[3]);
			$('#precioEM').val(datosI[5]); $('#precioUrgenciaM').val(datosI[6]); $('#precioES').val(datosI[7]);
			$('#precioUrgenciaS').val(datosI[8]);
		});
					
		$('#formEstudio').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_save1').button('loading'); $('#btn_cancel1').hide();
			$('#miDiagnostico').val($('.jqte_editor').html());
			var datosP = $('#myModal1 #formEstudio').serialize();
			$.post('imagen/estudios/files-serverside/updateEstudio.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel1').show(); $('#myModal1').modal('hide');
					swal({
					  title: "", type: "success", text: "El estudio se ha actualizado.", timer: 2000, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function (e) { $('#formEstudio').validator(); });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
}
</script>
