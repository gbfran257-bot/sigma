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
    
    <title>SISTEMA - MEDICAMENTOS</title>
    
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
    <th style="vertical-align:middle; white-space:nowrap;" nowrap>NOMBRE GENÉRICO</th>
    <th style="vertical-align:middle; white-space:nowrap;" nowrap>NOMBRE COMERCIAL</th>
    <th style="vertical-align:middle;">CANTIDAD</th>
    <th style="vertical-align:middle;">PRESENTACIÓN</th>
    <th style="vertical-align:middle;">VÍA</th>
    <th style="vertical-align:middle;">NIVEL</th>
    <th style="vertical-align:middle;" nowrap>GRUPO</th>
    <th style="vertical-align:middle;" nowrap>COSTO</th>
    <th style="vertical-align:middle; white-space:nowrap;" nowrap>PRECIO P</th>
    <th style="vertical-align:middle; white-space:nowrap;" nowrap>PRECIO H</th>
    <th style="vertical-align:middle; white-space:nowrap;" nowrap>PRECIO M</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input name="spac" id="spac" type="text" class="form-control input-sm" placeholder="Nombre genérico"/></th>
            <th><input name="sref" id="sref" type="text" class="form-control input-sm" placeholder="Nombre comercial"/></th>
            <th><input name="sper" id="sper" type="text" class="form-control input-sm" placeholder="Cantidad" style="max-width:100px;"/></th>
            <th><input name="spre" id="spre" type="text" class="form-control input-sm" placeholder="Presentación"/></th>
            <th><input name="ssuc" id="ssuc" type="text" class="form-control input-sm" placeholder="Vía" style="max-width:90px;"/></th>
            <th><input name="sest" id="sest" type="text" class="form-control input-sm" placeholder="Nivel" style="max-width:90px;"/></th>
            <th><input name="stat" id="stat" type="text" class="form-control input-sm" placeholder="Grupo" style="max-width:100px;"/></th>
            <th></th>
            <th></th>
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
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-144;
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true},
			{"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "farmacia/medicamentos/datatable-serverside/medicamentos.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val(); var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } );
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SERVICIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 500, paging: true,
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
	
	$('.infoPrincipal').append('<div style="text-align:left;"> <button class="btn btn-success btn-sm" onClick="nuevo_medicamento()" type="button"><i class="fa fa-medkit" aria-hidden="true"></i> Nuevo medicamento</button> </div>');
	
});

function verMedicamento(id_medi, nombre_m){
	$("#myModalx").load('farmacia/medicamentos/htmls/ficha_medicamento_c.php',function(response,status,xhr){if(status=="success"){
		$('#id_user_reg_m').val($('#id_user').val()); $('#id_med_up').val(id_medi);
		$('#titulo_modal').text('FICHA DEL MEDICAMENTO '+nombre_m); $('#guardarM').text('Actualizar');
		
		var tamM = $('#referencia').height() - $('#my_footer').height() - 144;
		var oTableM = $('#dataTableM').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [
				{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}
			],
			"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc">', 
			deferRender: true, select: {style:'single'}, "processing": false, 
			"sAjaxSource": "farmacia/medicamentos/datatable-serverside/medicamentos_genericos.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
				aoData.push( {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "MEDICAMENTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN MEDICAMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE MEDICAMENTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: true,
		});
		$('#clickmeM').click(function(e) { oTableM.draw(); }); window.setTimeout(function(){$('#clickmeM').click();},500);
		//para los fintros individuales por campo de texto
		oTableM.columns().every( function () {
			var that = this;
			$('input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			});
		} );
		//fin filtros individuales por campo de texto
		oTableM.on( 'select', function(e, dt, type, indexes){
			$('.ocul').removeClass('hidden');
			var rowData=oTableM.rows(indexes).data().toArray(); $('#cat_riesgo_e, #tex_cat_re').text(rowData[0][5]); //alert(rowData[0][4]);
			$('#tex_presentacion').text(rowData[0][6]); $('#tex_via').text(rowData[0][7]); $('#tex_dosis').val(rowData[0][8]);
			$('#tex_generalidades').text(rowData[0][9]); $('#tex_interacciones').text(rowData[0][10]);
			$('#tex_adversos').text(rowData[0][11]); $('#tex_contrain').text(rowData[0][12]); $('#tex_re').text(rowData[0][13]);
			$('#id_mg').val(rowData[0][14]); $('#form-medicamento').validator('update');
		})
		.on( 'deselect', function ( e, dt, type, indexes ){
			$('.ocul').addClass('hidden'); $('#tex_dosis,#precio_p_m').val(''); $('#form-medicamento').validator('update')
		});$('.ocul').removeClass('hidden');
		
		var datosM = {id_medi:id_medi}
		$.post('farmacia/medicamentos/files-serverside/infoMedicamentos.php',datosM).done(function(data){
			var datos = data.split('}{[_}');
			$('#cat_riesgo_e, #tex_cat_re').text(datos[5]); //alert(rowData[0][4]);
			$('#tex_presentacion').text(datos[6]); $('#tex_via').text(datos[7]); $('#tex_dosis').val(datos[8]);
			$('#tex_generalidades').text(datos[9]); $('#tex_interacciones').text(datos[10]);
			$('#tex_adversos').text(datos[11]); $('#tex_contrain').text(datos[12]); $('#tex_re').text(datos[13]);
			$('#id_mg').val(datos[14]); $('#nombre_c_m').val(datos[15]); $('#precio_p_m').val(datos[16]);
			$('#precio_h_m').val(datos[17]); $('#precio_m_m').val(datos[18]); $('#costo_m').val(datos[19]);
			$('#codigo_b_m').val(datos[20]); $('#form-medicamento').validator('update');
		});
		
		$('#form-medicamento').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			//var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#form-medicamento').serialize();
			$.post('farmacia/medicamentos/files-serverside/updateMedicamento.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $('#myModalx').modal('hide'); //$btn.button('reset'); $('#btn_cancel_new_u').show(); 
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "Los datos del medicamento se han actualizado.",
					  timer: 2000, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function (e) { $('#form-medicamento').validator(); });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
	}});
}
function nuevo_medicamento(){
	$("#myModalx").load('farmacia/medicamentos/htmls/ficha_medicamento_c.php',function(response,status,xhr){if(status=="success"){
		$('#id_user_reg_m').val($('#id_user').val());
		var tamM = $('#referencia').height() - $('#my_footer').height() - 144;
		var oTableM = $('#dataTableM').DataTable({
			serverSide: true,"sScrollY": 120, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [
				{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}
			],
			"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"S><"proc">', 
			deferRender: true, select: {style:'single'}, "processing": false, 
			"sAjaxSource": "farmacia/medicamentos/datatable-serverside/medicamentos_genericos.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
				aoData.push( {"name": "accesoU", "value": acceso } ); aoData.push( {"name": "idU", "value": idU } );
			},
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "MEDICAMENTOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN MEDICAMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE MEDICAMENTOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 500, paging: true,
		});
		$('#clickmeM').click(function(e) { oTableM.draw(); }); window.setTimeout(function(){$('#clickmeM').click();},500);
		//para los fintros individuales por campo de texto
		oTableM.columns().every( function () {
			var that = this;
			$('input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			});
		} );
		//fin filtros individuales por campo de texto
		oTableM.on( 'select', function(e, dt, type, indexes){
			$('.ocul').removeClass('hidden');
			var rowData=oTableM.rows(indexes).data().toArray(); $('#cat_riesgo_e, #tex_cat_re').text(rowData[0][5]); //alert(rowData[0][4]);
			$('#tex_presentacion').text(rowData[0][6]); $('#tex_via').text(rowData[0][7]); $('#tex_dosis').val(rowData[0][8]);
			$('#tex_generalidades').text(rowData[0][9]); $('#tex_interacciones').text(rowData[0][10]);
			$('#tex_adversos').text(rowData[0][11]); $('#tex_contrain').text(rowData[0][12]); $('#tex_re').text(rowData[0][13]);
			$('#id_mg').val(rowData[0][14]); $('#form-medicamento').validator('update')
		})
		.on( 'deselect', function ( e, dt, type, indexes ){
			$('.ocul').addClass('hidden'); $('#tex_dosis,#precio_p_m').val(''); $('#form-medicamento').validator('update')
		});
		
		$('#form-medicamento').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			//$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			//var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#form-medicamento').serialize();
			$.post('farmacia/medicamentos/files-serverside/addMedicamentos.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $('#myModalx').modal('hide'); //$btn.button('reset'); $('#btn_cancel_new_u').show(); 
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "El medicamento se ha creado satisfactoriamente.",
					  timer: 2000, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function (e) { $('#form-medicamento').validator(); });
		$('#myModalx').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModalx").empty(); });
	}});
}
</script>