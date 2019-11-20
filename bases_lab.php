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
    
    <title>SISTEMA - BASES DE ESTUDIOS DE LABORATORIO</title>
    
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
    
    <style>
    td.details-control { background: url('DataTables-1.10.5/examples/resources/details_open.png') no-repeat center center; cursor: pointer; }
	tr.details td.details-control { background: url('DataTables-1.10.5/examples/resources/details_close.png') no-repeat center center; }
    </style>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<input name="idUsuarioUR" id="idUsuarioUR" type="hidden">
<input name="idAVR" id="idAVR" type="hidden">
<input name="tipo_edadR" id="tipo_edadR" type="hidden" value="a">
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTable" class="table table-hover table-striped dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="unoB">#</th>
    <th>BASE</th>
    <th>ÁREA</th>
    <th>UNIDAD</th>
    <th nowrap width="150">$ PRODUCCIÓN</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Base"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Área"/></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<div id="dialog-updates" style="display:none; overflow:hidden;"> </div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>LABORATORIO</li><li class="active"><strong>BASES DE ESTUDIOS DE LABORATORIO</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-137-$('#breadc').height();
	var oTableP = $('#dataTable').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "laboratorio/bases/datatable-serverside/bases.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de=$('#top-search').val();aoData.push({"name": "nombre", "value": de });
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SERVICIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 50000, paging: false,
	});
	
	$('#unoB').click(function(e) { oTableP.draw(); }); window.setTimeout(function(){$('#unoB').click();},500);
	
	//para los fintros individuales por campo de texto
	oTableP.columns().every( function () {
		var that = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
		} );
	} );
	//fin filtros individuales por campo de texto
	$('#top-search').keyup(function(e) {
        $('#dataTable_filter input').val($(this).val()); $('#dataTable_filter input').keyup();
    }).focus();
	$('.filtro1Principal').addClass('hidden');
	
	$('.infoPrincipal').append('<div style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td><button type="button" onClick="nuevaBase()" class="btn btn-xs btn-primary" title="Agregar una nueva base"><i class="fa fa-plus-circle"></i> Nueva base</button></td> </tr> </table> </div>');
});

function subirMuestra(muestra, noAleatorio, idU){ //alert(muestra);
	var datosSMNB = {muestra:muestra, noAleatorio:noAleatorio, idU:idU}
	$.post('laboratorio/bases/files-serverside/guardarMuestraNB.php',datosSMNB).done(function(data){ 
		if (data==1){$('#clickmeMu').click();$('#s_add_muestra').val('');$("#s_add_muestra").trigger("chosen:updated");}
		else{alert(data);}
	});
}
function borrarMuestraNB(idMuestra){
	swal({
	  title: "ELIMINAR LA MUESTRA", text: "¿Estás seguro de eliminar la muestra de la base?", type: "",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		var datosMuestraNB = {idMuestra:idMuestra}
		$.post('laboratorio/bases/files-serverside/eliminarMuestraNB.php',datosMuestraNB).done(function(data){ 
			if(data==1){ $('#clickmeMu').click();} else{alert(data);} 
		});
		swal({
		  title:"MUESTRA ELIMINADA",type: "",text:"La muestra se ha eliminado de la base.",timer:1800,showConfirmButton:false
		});
	});
}
function subirMetodo(metodo, noAleatorio, idU){
	var datosSMNB = {metodo:metodo, noAleatorio:noAleatorio, idU:idU}
	$.post('laboratorio/bases/files-serverside/guardarMetodoNB.php',datosSMNB).done(function(data){ 
		if (data==1){ $('#clickmeMet').click();$('#s_add_metodo').val('');$("#s_add_metodo").trigger("chosen:updated");}
		else{alert(data);} 
	});
}
function borrarMetodoNB(idMetodo){
	swal({
	  title: "ELIMINAR MÉTODO", text: "¿Estás seguro de eliminar el método de la base?", type: "",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		var datosMetodoNB = {idMetodo:idMetodo}
		$.post('laboratorio/bases/files-serverside/eliminarMetodoNB.php',datosMetodoNB).done(function(data){ 
			if (data==1){ $('#clickmeMet').click(); } else{alert(data);} 
		});
		swal({
		  title:"MÉTODO ELIMINADO",type: "",text:"El método se ha eliminado de la base.",timer:1800,showConfirmButton:false
		});
	});
}
function subirIndicacion(indicacion, noAleatorio, idU){ 
	var datosSINB = {indicacion:indicacion, noAleatorio:noAleatorio, idU:idU}
	$.post('laboratorio/bases/files-serverside/guardarIndicacionNB.php',datosSINB).done(function(data){ 
		if (data==1){ $('#clickmeIn').click();$('#s_add_indicacion').val('');$("#s_add_indicacion").trigger("chosen:updated");}
		else{alert(data);}
	});
}
function borrarIndicacionNB(idIndicacion){
	swal({
	  title: "ELIMINAR LA INDICACIÓN", text: "¿Estás seguro de eliminar la indicación de la base?", type: "",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
		var datosIndicacionNB = {idIndicacion:idIndicacion}
		$.post('laboratorio/bases/files-serverside/eliminarIndicacionNB.php',datosIndicacionNB).done(function(data){
			if (data==1){ $('#clickmeIn').click(); } else{alert(data);}
		});
		swal({ title:"INDICACIÓN ELIMINADA",type: "",text:"La indicación se ha eliminado de la base.",timer:1800,showConfirmButton:false });
	});
}
function subirReferencia(referencia, noAleatorio, idU){
	var datosSReB = {referencia:referencia, noAleatorio:noAleatorio, idU:idU}
	$.post('laboratorio/bases/files-serverside/guardarReferenciaNB.php',datosSReB).done(function(data){
		if (data==1){ $('#clickmeRe').click();$('#s_add_vr').val('');$("#s_add_vr").trigger("chosen:updated");} else{alert(data);}
	});
}
function borrarReferenciaNB(idReferencia){
	swal({
	  title: "ELIMINAR VALOR DE REFERENCIA", text: "¿Estás seguro de eliminar el valor de referencia de la base?", type: "",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
		var datosReferenciaNB = {idReferencia:idReferencia}
		$.post('laboratorio/bases/files-serverside/eliminarReferenciaNB.php',datosReferenciaNB).done(function(data){
			if (data==1){ $('#clickmeRe').click(); } else{alert(data);} });
		swal({ title:"VALOR DE REFERENCIA ELIMINADO",type: "",text:"El valor de referencia se ha eliminado de la base.",timer:1800,showConfirmButton:false });
	});
}
function subirConsumible(consumible, noAleatorio, idU){
	var datosSCoB = {consumible:consumible, noAleatorio:noAleatorio, idU:idU}
	$.post('laboratorio/bases/files-serverside/guardarConsumibleNB.php',datosSCoB).done(function(data){
		if (data==1){ $('#clickmeCo').click();$('#s_add_consumible').val('');$("#s_add_consumible").trigger("chosen:updated");
	} else{alert(data);} });
}
function borrarConsumibleNB(idConsumible){
	swal({
	  title: "ELIMINAR CONSUMIBLE", text: "¿Estás seguro de eliminar el consumible de la base?", type: "",
	  showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
		var datosConsumibleNB = {idConsumible:idConsumible}
		$.post('laboratorio/bases/files-serverside/eliminarConsumibleNB.php',datosConsumibleNB).done(function(data){
			if (data==1){ $('#clickmeCo').click();} else{alert(data);}
		});
		swal({
		  title:"CONSUMIBLE ELIMINADO",type: "",text:"El consumible se ha eliminado de la base.",timer:1800,showConfirmButton:false
		});
	});
}
function agregar_na(nombre,clave){
	var datos = {nombre:nombre, clave:clave, id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNarea.php',datos).done(function(data){
		if(data==1){
			$('#areaB').load('laboratorio/bases/files-serverside/genera_areas.php',function(response,status,xhr){if(status=="success"){ }});
			$('#cancelArea').click();
			swal({title:"ÁREA AGREGADA",type:"success",text:"El área se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_num(nombre,abreviacion){
	var datos = {nombre:nombre, abreviacion:abreviacion, id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNunidadMedida.php',datos).done(function(data){
		if(data==1){
			$('#id_umBase').load('laboratorio/bases/files-serverside/genera_unidades_medida.php',function(response,status,xhr){if(status=="success"){
				$("#id_umBase").trigger("chosen:updated");
			}}); $('#cancelUnidad, #cancelUmedC').click();
			swal({title:"UNIDAD DE MEDIDA AGREGADA",type:"success",text:"La unidad de medida se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_neq(nombre,marca){
	var datos = {nombre:nombre, marca:marca, id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNequipo.php',datos).done(function(data){
		if(data==1){
			$('#equipoMu1').load('laboratorio/bases/genera/equipos.php',function(response,status,xhr){if(status=="success"){
				$("#equipoMu1").trigger("chosen:updated");
			}}); $('#cancelEquipo').click();
			swal({title:"EQUIPO AGREGADO",type:"success",text:"El equipo se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_ncom(nombre){
	var datos = {nombre:nombre, id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNcondicionMuestra.php',datos).done(function(data){
		if(data==1){
			$('#condicion_n_mue').load('laboratorio/bases/files-serverside/generaCondicionesMuestras.php',function(response,status,xhr){});
			$('#cancelCondicion').click();
			swal({title:"CONDICIÓN AGREGADA",type:"success",text:"La condición se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_nmue(nombre, id_con){
	var datos = {nombre:nombre, id_con:id_con, id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNmuestra.php',datos).done(function(data){
		if(data==1){
			$('#s_add_muestra').load('laboratorio/bases/genera/muestras.php',function(response,status,xhr){if(status=="success"){
				$("#s_add_muestra").trigger("chosen:updated");
			}}); $('#cancelMuestra').click();
			swal({title:"MUESTRA AGREGADA",type:"success",text:"La muestra se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_nmet(nombre){
	var datos = {nombre:nombre, id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNmetodo.php',datos).done(function(data){
		if(data==1){
			$('#s_add_metodo').load('laboratorio/bases/genera/metodos.php',function(response,status,xhr){if(status=="success"){
				$("#s_add_metodo").trigger("chosen:updated");
			}}); $('#cancelMetodo').click();
			swal({title:"MÉTODO AGREGADO",type:"success",text:"El método se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_nind(nombre){
	var datos = {nombre:nombre, id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNindicacion.php',datos).done(function(data){
		if(data==1){
			$('#s_add_indicacion').load('laboratorio/bases/genera/indicaciones.php',function(response,status,xhr){if(status=="success"){
				$("#s_add_indicacion").trigger("chosen:updated");
			}}); $('#cancelIndicacion').click();
			swal({title:"INDICACIÓN AGREGADA",type:"success",text:"La indicación se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_ncons(nombre,descripcion,tipo,unidad,presentacion){
	var datos = {nombre:nombre,descripcion:descripcion,tipo:tipo,unidad:unidad,presentacion:presentacion,id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNconsumible.php',datos).done(function(data){
		if(data==1){
			$('#s_add_consumible').load('laboratorio/bases/genera/consumibles.php',function(response,status,xhr){if(status=="success"){
				$("#s_add_consumible").trigger("chosen:updated");
			}}); $('#cancelConsumible').click();
			swal({title:"CONSUMIBLE AGREGADO",type:"success",text:"El consumible se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_ntcon(nombre){
	var datos = {nombre:nombre,id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNtipoConsumible.php',datos).done(function(data){
		if(data==1){
			$('#tipo_n_cons').load('laboratorio/genera/tiposConsumibles.php',function(response,status,xhr){if(status=="success"){}});
			$('#cancelTipo').click();
			swal({title:"TIPO DE CONSUMIBLE AGREGADO",type:"success",text:"El nuevo tipo de consumible se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function agregar_presentacion(nombre){
	var datos = {nombre:nombre,id_u:$('#id_user').val()}
	$.post('laboratorio/bases/files-serverside/agregarNpresentacionConsumible.php',datos).done(function(data){
		if(data==1){
			$('#presentacion_n_cons').load('laboratorio/genera/presentacionesConsumibles.php',function(response,status,xhr){if(status=="success"){}});
			$('#cancelPresentacion').click();
			swal({title:"PRESENTACIÓN PARA CONSUMIBLE AGREGADA",type:"success",text:"La nueva presentación para consumible se dió de alta correctamente.",timer:1800,showConfirmButton:false});
		}
		else{alert(data);}
	});
}
function nuevaBase(na){ //if(na==undefined){alert('undefined');}else{alert('defined');}
	$("#myModal").load('laboratorio/bases/htmls/base.php', function( response, status, xhr ){ if(status=="success"){
		$('#idUsuarioP').val($('#id_user').val()); $('#idPacienteN').val('');
		$('#alerta_muestra, #alerta_consumible, #alerta_vr, #alerta_indicacion, #alerta_metodo, .alerta_altas, .alerta_altas1').hide();
		$('#condicion_n_mue').load('laboratorio/bases/files-serverside/generaCondicionesMuestras.php',function(response,status,xhr){});
		$('#tipo_n_cons').load('laboratorio/genera/tiposConsumibles.php',function(response,status,xhr){});
		$('#unidad_n_cons').load('laboratorio/genera/unidadConsumibles.php',function(response,status,xhr){});
		$('#presentacion_n_cons').load('laboratorio/genera/presentacionesConsumibles.php',function(response,status,xhr){});
		
		$('#btn-new_presentacion_con').click(function(e) { $('#new_presentacion').removeClass('hidden'); });
		$('#cancelPresentacion').click(function(e){ $('.campos_upresentacion').val(''); $('#new_presentacion').addClass('hidden'); });
		$('#addPresentacion').click(function(e) {
			if($('#nombre_n_presentacion').val()!=''){
				agregar_presentacion($('#nombre_n_presentacion').val());
			}else{$(".alerta_altas1").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas1").slideUp(600); });}
        });
		
		$('#btn-new_unidad_con').click(function(e) { $('#new_unidadC').removeClass('hidden'); });
		$('#cancelUmedC').click(function(e){ $('.campos_umedc').val(''); $('#new_unidadC').addClass('hidden'); });
		$('#addUmedC').click(function(e) {
			if($('#nombre_n_umedc').val()!='' & $('#abreviacion_n_umc').val()!=''){
				agregar_num($('#nombre_n_umedc').val(), $('#abreviacion_n_umc').val());
			}else{$(".alerta_altas1").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas1").slideUp(600); });}
        });
		
		$('#btn-new_tipo_con').click(function(e) { $('#new_tipo').removeClass('hidden'); });
		$('#cancelTipo').click(function(e){ $('.campos_tcon').val(''); $('#new_tipo').addClass('hidden'); });
		$('#addTipo').click(function(e) {
			if($('#nombre_n_tcon').val()!=''){
				agregar_ntcon($('#nombre_n_tcon').val());
			}else{$(".alerta_altas1").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas1").slideUp(600); });}
        });
		
		$('#btn-new_consumible').click(function(e) { $('#new_consumible').removeClass('hidden'); });
		$('#cancelConsumible').click(function(e){ $('.campos_cons').val(''); $('#new_consumible').addClass('hidden'); });
		$('#addConsumible').click(function(e) {
			if($('#nombre_n_cons').val()!='' & $('#tipo_n_cons').val()!='' & $('#unidad_n_cons').val()!='' & $('#presentacion_n_cons').val()!=''){
			  agregar_ncons($('#nombre_n_cons').val(),$('#descripcion_n_cons').val(),$('#tipo_n_cons').val(),$('#unidad_n_cons').val(),$('#presentacion_n_cons').val());
			}else{$(".alerta_altas").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas").slideUp(600); });}
        });
		
		$('#btn-new_indicacion').click(function(e) { $('#new_indicacion').removeClass('hidden'); });
		$('#cancelIndicacion').click(function(e){ $('.campos_ind').val(''); $('#new_indicacion').addClass('hidden'); });
		$('#addIndicacion').click(function(e) {
			if($('#nombre_n_ind').val()!=''){
				agregar_nind($('#nombre_n_ind').val());
			}else{$(".alerta_altas").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas").slideUp(600); });}
        });
		
		$('#btn-new_metodo').click(function(e) { $('#new_metodo').removeClass('hidden'); });
		$('#cancelMetodo').click(function(e){ $('.campos_met').val(''); $('#new_metodo').addClass('hidden'); });
		$('#addMetodo').click(function(e) {
			if($('#nombre_n_met').val()!=''){
				agregar_nmet($('#nombre_n_met').val());
			}else{$(".alerta_altas").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas").slideUp(600); });}
        });
		
		$('#btn-addCondicion').click(function(e) { $('#new_condicion').removeClass('hidden'); });
		$('#cancelCondicion').click(function(e){ $('.campos_ncm').val(''); $('#new_condicion').addClass('hidden'); });
		$('#addCondicion').click(function(e) {
			if($('#nombre_n_cm').val()!=''){
				agregar_ncom($('#nombre_n_cm').val());
			}else{$(".alerta_altas1").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas1").slideUp(600); });}
        });
		
		$('#btn-new_muestra').click(function(e) { $('#new_muestra').removeClass('hidden'); });
		$('#cancelMuestra').click(function(e){ $('.campos_nmue').val(''); $('#new_muestra').addClass('hidden'); });
		$('#addMuestra').click(function(e) {
			if($('#nombre_n_mue').val()!='' & $('#condicion_n_mue').val()!=''){
				agregar_nmue($('#nombre_n_mue').val(),$('#condicion_n_mue').val());
			}else{$(".alerta_altas").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas").slideUp(600); });}
        });
		
		$('#bEquipoB').click(function(e) { $('#new_equipo').removeClass('hidden'); });
		$('#cancelEquipo').click(function(e){ $('.campos_neq').val(''); $('#new_equipo').addClass('hidden'); });
		$('#addEquipo').click(function(e) {
			if($('#nombre_n_eq').val()!='' & $('#marca_n_eq').val()!=''){
				agregar_neq($('#nombre_n_eq').val(),$('#marca_n_eq').val());
			}else{$(".alerta_altas").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas").slideUp(600); });}
        });
		
		$('#bUnidadM').click(function(e) { $('#new_unidad_medida').removeClass('hidden'); });
		$('#cancelUnidad').click(function(e){ $('.campos_num').val(''); $('#new_unidad_medida').addClass('hidden'); });
		$('#addUnidad').click(function(e) {
			if($('#nombre_n_um').val()!='' & $('#abreviacion_n_um').val()!=''){
				agregar_num($('#nombre_n_um').val(),$('#abreviacion_n_um').val());
			}else{$(".alerta_altas").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas").slideUp(600); });}
        });
		
		$('#bAreaB').click(function(e) { $('#new_area').removeClass('hidden'); });
		$('#cancelArea').click(function(e){ $('.campos_na').val(''); $('#new_area').addClass('hidden'); });
		$('#addArea').click(function(e) {
			if($('#nombre_n_a').val()!='' & $('#clave_n_a').val()!=''){
				agregar_na($('#nombre_n_a').val(),$('#clave_n_a').val());
			}else{$(".alerta_altas").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_altas").slideUp(600); });}
        });
		
		if(na==undefined){
			$('#btn_new').text('Guardar'); $("#areaB").load('laboratorio/bases/files-serverside/genera_areas.php');
			$("#id_umBase").load('laboratorio/bases/files-serverside/genera_unidades_medida.php',function(response,status,xhr){
				if(status=="success"){window.setTimeout(function(){$('#id_umBase').chosen();},500);}
			});
			$("#equipoMu1").load('laboratorio/bases/genera/equipos.php',function(response,status,xhr){
				if(status=="success"){window.setTimeout(function(){$('#equipoMu1').chosen();},500);}
			});
			
			$('#form-registro').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
			  } else { // everything looks good!
				e.preventDefault(); 
				var $btn = $('#btn_new').button('loading'); $('#btn_cancel_new').hide();
				var datosP = $('#myModal #form-registro').serialize();
				$.post('laboratorio/bases/files-serverside/addEstudio.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
					$('#idPacienteN').val(data);$('#clickme, #unoB').click();
						$('#idPacienteN').val(data);$('#clickme, #unoB').click();
						$btn.button('reset'); $('#btn_cancel_new').show(); $('#myModal').modal('hide'); 
						swal({
						  title: "¡CONFIRMACIÓN!", type: "success", text: "La base se ha creado satisfactoriamente.",
						  timer: 1800, showConfirmButton: false
						}); return;
					} else{alert(data);}
				});
			  }
			});
		}
		else{
			$('#btn_new').text('Actualizar');
			var aleatorioBase = {aleatorio : na}
			$.post('laboratorio/bases/files-serverside/datosFichaBase.php',aleatorioBase).done(function(data){
				var datos = data.split('{;]');
				$('#idPacienteN').val(datos[6]); $('#nombreP').val(datos[0]); $('#precioP').val(datos[1]);
				$('#areaB').load('laboratorio/bases/files-serverside/genera_areas.php',function(response,status,xhr){if(status=="success"){
					$('#id_areaB').val(datos[2]); $('#areaB').val(datos[2]);
				}});
				$("#id_umBase").load('laboratorio/bases/files-serverside/genera_unidades_medida.php',function(response,status,xhr){
					if(status=="success"){$('#id_umBase').val(datos[3]);window.setTimeout(function(){$('#id_umBase').chosen();},500);}
				});
				$("#equipoMu1").load('laboratorio/bases/genera/equipos.php',function(response,status,xhr){
					if(status=="success"){$('#equipoMu1').val(datos[11]);window.setTimeout(function(){$('#equipoMu1').chosen();},500);}
				});
				
				$('#unidadMedidaR1').val(datos[5]); $('#abreviacionUMT1').val(datos[7]); $('#id_equipoMu').val(datos[9]);
			});
			$('#form-registro').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
			  } else { // everything looks good!
				e.preventDefault(); 
				var $btn = $('#btn_new').button('loading'); $('#btn_cancel_new').hide();
				var datosP = $('#myModal #form-registro').serialize();
				$.post('laboratorio/bases/files-serverside/updateEstudio.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
					$('#idPacienteN').val(data);$('#clickme, #unoB').click();
						$('#clickme, #unoB').click();
						$btn.button('reset'); $('#btn_cancel_new').show(); $('#myModal').modal('hide'); 
						swal({
						  title: "¡CONFIRMACIÓN!", type: "success", text: "La base se ha actualizado satisfactoriamente.", timer: 1800, showConfirmButton: false
						}); return;
					} else{alert(data);}
				});
			  }
			});
		}
		
		$("#s_add_muestra").load('laboratorio/bases/genera/muestras.php',function(response,status,xhr){ if(status=="success"){
			window.setTimeout(function(){
				$('#s_add_muestra').chosen(); window.setTimeout(function(){$('#s_add_muestra_chosen').width(100+'%'); },100);
			},500);
		} });
		$("#s_add_metodo").load('laboratorio/bases/genera/metodos.php',function(response,status,xhr){ if(status=="success"){
			window.setTimeout(function(){ $('#s_add_metodo').chosen(); window.setTimeout(function(){$('#s_add_metodo_chosen').width(100+'%'); },100); },500);
		} });
		$("#s_add_indicacion").load('laboratorio/bases/genera/indicaciones.php',function(response,status,xhr){ if(status=="success"){
			window.setTimeout(function(){ $('#s_add_indicacion').chosen(); window.setTimeout(function(){$('#s_add_indicacion_chosen').width(100+'%'); },100); },500);
		} });
		$("#s_add_vr").load('laboratorio/bases/genera/valores_referencia.php',function(response,status,xhr){ if(status=="success"){
			window.setTimeout(function(){ $('#s_add_vr').chosen(); window.setTimeout(function(){$('#s_add_vr_chosen').width(100+'%'); },100); },500);
		} });
		$("#s_add_consumible").load('laboratorio/bases/genera/consumibles.php',function(response,status,xhr){ if(status=="success"){
			window.setTimeout(function(){ $('#s_add_consumible').chosen(); window.setTimeout(function(){$('#s_add_consumible_chosen').width(100+'%'); },100); },500);
		} });
	
		var now = new Date().getTime(); var d = new Date();
		if(na==undefined){ $('#aleatorioB').val(d.format('Y-m-d-H-i-s-u').substring(0,22)); }else{ $('#aleatorioB').val(na); }
		
		$('#btn-add_muestra').click(function(e){
			if($('#s_add_muestra').val()!==''){subirMuestra($('#s_add_muestra').val(), $('#aleatorioB').val(), $('#id_user').val());}
            else{$("#alerta_muestra").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_muestra").slideUp(600); });}
        });
		$('#btn-add_metodo').click(function(e){
			if($('#s_add_metodo').val()!==''){subirMetodo($('#s_add_metodo').val(), $('#aleatorioB').val(), $('#id_user').val());}
            else{$("#alerta_metodo").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_metodo").slideUp(600); });}
        });
		$('#btn-add_indicacion').click(function(e){
			if($('#s_add_indicacion').val()!==''){ subirIndicacion($('#s_add_indicacion').val(),$('#aleatorioB').val(),$('#id_user').val()); }
            else{$("#alerta_indicacion").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_indicacion").slideUp(600); });}
        });
		$('#btn-add_vr').click(function(e){
			if($('#s_add_vr').val()!==''){subirReferencia($('#s_add_vr').val(), $('#aleatorioB').val(), $('#id_user').val());}
            else{$("#alerta_vr").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_vr").slideUp(600); });}
        });
		$('#btn-add_consumible').click(function(e){
			if($('#s_add_consumible').val()!==''){ subirConsumible($('#s_add_consumible').val(),$('#aleatorioB').val(),$('#id_user').val()); }
            else{$("#alerta_consumible").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_consumible").slideUp(600); });}
        });
		
		var heB = $('#myModal').height(); //alert($('#aleatorioB').val());
		var oTableMB;
		oTableMB = $('#dataTableMuestras').DataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
			"bJQueryUI": false,  "bRetrieve": true, "sScrollY": heB*0.4, "bAutoWidth": true, "bStateSave": false, 
			"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
			"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
			"iDisplayLength": 50, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
			"sAjaxSource": "laboratorio/bases/datatable-serverside/muestras_seleccionadas_base.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = $('#aleatorioB').val(); aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
			},
			"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage": { 
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA BASE NO CUENTA CON MUESTRAS",
				"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered":"<br/>CONVENIOS: _MAX_","sSearch": "BUSCAR"
			}
		});
		$('#clickmeMu').click(function(e){oTableMB.draw();}); $('#t_tMuestras').click(function(e) { oTableMB.draw(); });
		
		var oTableMeB;
		oTableMeB = $('#dataTableMetodos').DataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
			"bJQueryUI": false,  "bRetrieve": true, "sScrollY": heB*0.4, "bAutoWidth": true, "bStateSave": false, 
			"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
			"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
			"iDisplayLength": 50, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
			"sAjaxSource": "laboratorio/bases/datatable-serverside/metodos_seleccionados_base.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = $('#aleatorioB').val(); aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
			},
			"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage": { 
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA BASE NO CUENTA CON MÉTODOS", 
				"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>CONVENIOS: _MAX_",
				"sSearch": "BUSCAR" 
			}
		});
		$('#clickmeMet').click(function(e){oTableMeB.draw();}); $('#t_tMetodos').click(function(e) { oTableMeB.draw(); });
		
		var oTableInB;
		oTableInB = $('#dataTableIndicaciones').DataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
			"bJQueryUI": false,  "bRetrieve": true, "sScrollY": heB*0.4, "bAutoWidth": true, "bStateSave": false, 
			"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
			"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
			"iDisplayLength": 50, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
			"sAjaxSource": "laboratorio/bases/datatable-serverside/indicaciones_seleccionadas_base.php",
			"fnServerParams": function (aoData, fnCallback) { var aleatorio = $('#aleatorioB').val(); aoData.push(  {"name": "aleatorio", "value": aleatorio } ); },
			"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "LA BASE NO CUENTA CON INDICACIONES", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>INDICACIONES: _MAX_", "sSearch": "BUSCAR" }
		});$('#clickmeIn').click(function(e) { oTableInB.draw(); }); $('#t_tIndicaciones').click(function(e) { oTableInB.draw(); });
		
		var oTableReB;
		oTableReB = $('#dataTableReferencias').DataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
			"bJQueryUI": false,  "bRetrieve": true, "sScrollY": heB*0.4, "bAutoWidth": true, "bStateSave": false, 
			"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
			"aoColumns": [
				{ "class": "details-control","bSortable": false }, { "bVisible": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }
			],
			"iDisplayLength": 50, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
			"sAjaxSource": "laboratorio/bases/datatable-serverside/referencias_seleccionadas_base1.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = $('#aleatorioB').val(); aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
			},
			"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
			"oLanguage": { 
				"sLengthMenu": "MONSTRANDO _MENU_ records per page",
				"sZeroRecords": "LA BASE NO CUENTA CON VALORES DE REFERENCIA","sInfo": "MOSTRADOS: _END_", 
				"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>VALORES: _MAX_", "sSearch": "BUSCAR" 
			}
		});
		$('#clickmeRe').click(function(e){oTableReB.draw();}); $('#t_tReferencias').click(function(e){oTableReB.draw();});
		
		// Array to track the ids of the details displayed rows
		var detailRows = [];
	 
		$('#dataTableReferencias tbody').on( 'click', 'tr td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = oTableReB.row( tr );
			var idx = $.inArray( tr.attr('id'), detailRows );
	 
			if ( row.child.isShown() ) {
				tr.removeClass( 'details' );
				row.child.hide();
				// Remove from the 'open' array
				detailRows.splice( idx, 1 );
			}
			else {
				tr.addClass( 'details' );
				row.child( format( row.data() ) ).show();
				// Add to the 'open' array
				if ( idx === -1 ) { detailRows.push( tr.attr('id') ); }
			}
		} );
	 
		// On each draw, loop over the `detailRows` array and show any child rows
		oTableReB.on( 'draw', function () { $.each( detailRows, function ( i, id ) { $('#'+id+' td.details-control').trigger( 'click' ); } ); } );
		
		var oTableCoB;
		oTableCoB = $('#dataTableConsumibles').DataTable({
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
			"bJQueryUI": false,  "bRetrieve": true, "sScrollY": heB*0.4, "bAutoWidth": true, "bStateSave": false, 
			"bInfo": true, "bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
			"aoColumns": [
				{ "class": "details-control","bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
				{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
			],
			"iDisplayLength": 50, "bLengthChange": false, "bProcessing": true, "bServerSide": true, 
			"sAjaxSource": "laboratorio/bases/datatable-serverside/consumibles_seleccionados_base1.php",
			"fnServerParams": function (aoData, fnCallback) { 
				var aleatorio = $('#aleatorioB').val(); aoData.push(  {"name": "aleatorio", "value": aleatorio } ); 
			},
			"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', "aLengthMenu":[[10,25,50,100,-1], [10, 25, 50, 100, "Todos"]],
			"oLanguage": { 
				"sLengthMenu": "MONSTRANDO _MENU_ records per page",
				"sZeroRecords": "LA BASE NO CUENTA CON CONSUMIBLES", "sInfo": "MOSTRADOS: _END_", 
				"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>CONSUMIBLES: _MAX_", "sSearch": "BUSCAR" 
			}
		});
		$('#clickmeCo').click(function(e){oTableCoB.draw();}); $('#t_tConsumibles').click(function(e){oTableCoB.draw();});
		
		// Array to track the ids of the details displayed rows
		var detailRows = [];
	 
		$('#dataTableConsumibles tbody').on( 'click', 'tr td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = oTableCoB.row( tr );
			var idx = $.inArray( tr.attr('id'), detailRows );
	 
			if ( row.child.isShown() ) {
				tr.removeClass( 'details' );
				row.child.hide();
				// Remove from the 'open' array
				detailRows.splice( idx, 1 );
			}
			else {
				tr.addClass( 'details' );
				row.child( format1( row.data() ) ).show();
				// Add to the 'open' array
				if ( idx === -1 ) { detailRows.push( tr.attr('id') ); }
			}
		} );
	 
		// On each draw, loop over the `detailRows` array and show any child rows
		oTableCoB.on( 'draw', function () {
			$.each( detailRows, function ( i, id ) { $('#'+id+' td.details-control').trigger( 'click' ); } );
		} );
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { $('#form-registro').validator(); });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	} });
}
function format1(d){ //alert(d[1]); alert(d[8]);
	$('#idAVR').val(d[8]); $('#idUsuarioUR').val($('#id_user').val());
	return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6"><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="80px" valign="bottom" nowrap>* CANTIDAD</td><td valign="top" align="left"><input name="cantidadC" type="text" class="form-control input-sm" id="cantidadC" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" maxlength="10"></td></tr></table></td></tr></table></td><td><table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td width="80px" valign="bottom" nowrap>* PRECIO</td><td valign="top" align="left"><input name="precioC" type="text" class="form-control input-sm" id="precioC" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" maxlength="10"></td></tr></table></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_acon('+d[8]+');"> Guardar</button></td></tr></table>';
}

function format(d){ //alert(d[1]); alert(d[26]);
	$('#idAVR').val(d[26]); $('#idUsuarioUR').val($('#id_user').val()); $('#tipo_edadR').val('a');
	if(d[1]=='TEXTO'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6"><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="80px" valign="bottom" nowrap>* TEXTO</td><td valign="top" align="left"><input name="valorText" type="text" class="form-control input-sm" id="valorText"></td></tr></table></td></tr></table></td><td><table width="100%" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan="2"><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vtxt();"> Guardar</button></td></tr></table>';
	}
	else if(d[1]=='POSITIVO-NEGATIVO'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" class="table-condensed"><tr><td colspan="2" align="left">Ingrese el valor normal para el resultado del valor de referencia NEGATIVO-POSITIVO.</td></tr><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" class="" height="100%"><tr align="left"><td width="1%" valign="top" nowrap>* Valor normal</td><td valign="top" align="left"><select name="valorBooleano" id="valorBooleano" class="form-control input-sm"><option value="" selected="selected">SELECCIONAR</option><option value="1">POSITIVO</option><option value="0">NEGATIVO</option></select></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vpn();"> Guardar</button></td></tr><tr><td colspan="0"><table width="" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan=""><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table>';
	}
	else if(d[1]=='RANGO'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" class="table-condensed"><tr><td colspan="2" align="left">Ingrese el valor mínimo y el valor máximo para el valor de referencia</td></tr><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="50%" valign="bottom" nowrap align="center">* Valor mínimo</td><td width="" valign="bottom" nowrap align="center">* Valor máximo</td></tr><tr><td valign="top" align="center"><input name="rangoI" type="text" class="form-control input-sm" id="rangoI" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td><td valign="top" align="center"><input name="rangoF" type="text" class="form-control input-sm" id="rangoF" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vran();"> Guardar</button></td></tr><tr><td colspan="0"><table width="" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan=""><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table>';
	}
	else if(d[1]=='VALOR MAXIMO'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" class="table-condensed"><tr><td colspan="2" align="left">Ingrese el valor máximo para el valor de referencia</td></tr><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="140px" valign="top" nowrap>* Valor máximo</td><td valign="top" align="left"><input name="valorMax" type="text" class="form-control input-sm" id="valorMax" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7" style="width:"></td></tr></table></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vmax();"> Guardar</button></td></tr><tr><td colspan="0"><table width="" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan=""><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table>';
	}
	else if(d[1]=='VALOR MINIMO'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" class="table-condensed"><tr><td colspan="2" align="left">Ingrese el valor mínimo para el valor de referencia</td></tr><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="140px" valign="top" nowrap>* Valor mínimo</td><td valign="top" align="left"><input name="valorMin" type="text" class="form-control input-sm" id="valorMin" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vmim();"> Guardar</button></td></tr><tr><td colspan="0"><table width="" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan=""><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table>';
	}
	else if(d[1]=='RANGO +-'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" class="table-condensed"><tr><td colspan="2" align="left">Ingrese los valores para el valor de referencia</td></tr><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="50%" valign="bottom" nowrap>* Valor base</td><td width="50%" valign="bottom" nowrap>* Variación (+-)</td></tr><tr><td valign="top" align="left"><input name="valor" type="text" class="form-control input-sm" id="valor" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td><td valign="top" align="left"><input name="variacion" type="text" class="form-control input-sm" id="variacion" onKeyUp="numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td></tr></table></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vranmm();"> Guardar</button></td></tr><tr><td colspan="0"><table width="" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan=""><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table>';
	}
	else if(d[1]=='NORMAL,MODERADO,ALTO'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" class="table-condensed"><tr><td colspan="2" align="left">Ingrese los valores de riesgo normal, moderado y alto para el valor de referencia</td></tr><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%" class="table-bordered"><tr align="left"><td width="150px" valign="bottom" nowrap align="center">* Normal</td><td width="" valign="bottom" nowrap align="center">* Rango riesgo moderado</td><td width="150px" valign="bottom" nowrap align="center">* Riesgo alto</td></tr><tr><td valign="top" align="center">< <input name="valorN" type="text" class="form-control input-sm" id="valorN" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td><td valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="2"><tr><td align="right">DE </td><td><input name="rangoI" type="text" class="form-control input-sm" id="rangoI" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td><td align="right">A </td><td><input name="rangoF" type="text" class="form-control input-sm" id="rangoF" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td></tr></table></td><td valign="top" align="center">> <input name="valorA" type="text" class="form-control input-sm" id="valorA" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td></tr></table></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vnma();"> Guardar</button></td></tr><tr><td colspan="0"><table width="" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan=""><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table>';
	}
	else if(d[1]=='NORMAL,MODERADO,ALTO (INVERSO)'){
		return '<table class="table-condensed" width="100%" id="formEditarValorTexto"><tr><td><table width="100%" height="100%" border="0" cellspacing="6" class="table-condensed"><tr><td colspan="2" align="left">Ingrese los valores de riesgo normal, moderado y alto para el valor de referencia</td></tr><tr><td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%" class="table-bordered"><tr align="left"><td width="150px" valign="bottom" nowrap align="center">* Normal</td><td width="" valign="bottom" nowrap align="center">* Rango riesgo moderado</td><td width="150px" valign="bottom" nowrap align="center">* Riesgo alto</td></tr><tr><td valign="top" align="center">> <input name="valorN" type="text" class="form-control input-sm" id="valorN" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td><td valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="2"><tr><td align="right">DE </td><td><input name="rangoI" type="text" class="form-control input-sm" id="rangoI" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td><td align="right">A </td><td><input name="rangoF" type="text" class="form-control input-sm" id="rangoF" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td></tr></table></td><td valign="top" align="center">< <input name="valorA" type="text" class="form-control input-sm" id="valorA" onKeyUp="conMayusculas(this); numeros_decimales(this.value, this.name);" value="" size="8" maxlength="7"></td></tr></table></td></tr></table></td><td><button type="button" class="btn btn-xs btn-primary" id="btn_save-txt" onClick="guardar_vnmai();"> Guardar</button></td></tr><tr><td colspan="0"><table width="" height="100%" border="0" cellspacing="6" cellpadding="6"><tr align="left"><td valign="bottom" nowrap colspan=""><select name="sexoEP" id="sexoEP" class="form-control input-sm"><option value="" selected>-SELECCIONAR SEXO-</option><option value="HOMBRES Y MUJERES">HOMBRES Y MUJERES</option><option value="MUJERES">MUJERES</option><option value="HOMBRES">HOMBRES</option></select></td></tr></table></td><td><table width="" height="100%" border="0" cellspacing="0" cellpadding="6"><tr align="left"><td valign="top" nowrap align="left" colspan="2"><select name="tipoEdad" id="tipoEdad" class="form-control input-sm" onChange="edades(this.value,'+d[26]+')"><option selected="selected" value="">-SELECCIONAR TIPO DE EDAD-</option><option value="TODAS LAS EDADES">TODAS LAS EDADES</option><option value="RANGO DE EDAD">RANGO DE EDAD</option></select></td></tr><tr class="rangoEdad hidden"><td width="1%" nowrap valign="middle" align="left"><div id="radiosB"><input class="radio_r rad1" type="radio" id="rAnos" name="radio" checked onClick="r_amd(this.id)"><label for="rAnos">Años</label>&nbsp;<input class="radio_r rad2" type="radio" id="rMeses" name="radio" onClick="r_amd(this.id)"><label for="rMeses">Meses</label>&nbsp;<input class="radio_r rad3" type="radio" id="rDias" name="radio" onClick="r_amd(this.id)"><label for="rDias">Días</label></div></td></tr><tr class="rangoEdad hidden"><td><table width="100%" border="0" cellspacing="0" cellpadding="4" height="100%"><tr align="left"><td width="49%" valign="middle" nowrap align="center">* Edad inicial(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadI" type="text" class="form-control input-sm" id="edadI" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr><tr><td width="49%" valign="middle" nowrap align="center">* Edad final(<span class="edadA">años</span>)</td><td valign="middle" align="center"><input name="edadF" type="text" class="form-control input-sm" id="edadF" onKeyUp="conMayusculas(this); solo_numeros(this.value, this.name);" size="5" maxlength="3"></td></tr></table></td></tr></table>';
	}
    
}
function edades(opc,id_vr){//alert(opc);
	if(opc ==''){$('.rangoEdad').addClass('hidden');$('#edadI, #edadF').val('');}
	else if(opc =='TODAS LAS EDADES'){$('.rangoEdad').addClass('hidden');$('#edadI, #edadF').val('');}
	else if(opc =='RANGO DE EDAD'){$('.rangoEdad').removeClass('hidden');}
}
function r_amd(id){
	if(id=='rAnos'){ $('.edadA').text('años'); $('#tipo_edadR').val('a');
	}else if(id=='rMeses'){ $('.edadA').text('meses'); $('#tipo_edadR').val('m');
	}else if(id=='rDias'){ $('.edadA').text('días'); $('#tipo_edadR').val('d');}
}
function guardar_vtxt(){
	if($('#valorText').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),valorText:$('#valorText').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/guardar_v_texto.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),valorText:$('#valorText').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/guardar_v_texto.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_vnma(){
	if($('#valorN').val()!='' & $('#rangoI').val()!='' & $('#rangoF').val()!='' & $('#valorA').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),valorN:$('#valorN').val(),rangoI:$('#rangoI').val(),rangoF:$('#rangoF').val(),valorA:$('#valorA').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/editarRangoNumericoTriple.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),valorN:$('#valorN').val(),rangoI:$('#rangoI').val(),rangoF:$('#rangoF').val(),valorA:$('#valorA').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/editarRangoNumericoTriple.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_vnmai(){
	if($('#valorN').val()!='' & $('#rangoI').val()!='' & $('#rangoF').val()!='' & $('#valorA').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),valorN:$('#valorN').val(),rangoI:$('#rangoI').val(),rangoF:$('#rangoF').val(),valorA:$('#valorA').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/editarRangoNumericoTripleI.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),valorN:$('#valorN').val(),rangoI:$('#rangoI').val(),rangoF:$('#rangoF').val(),valorA:$('#valorA').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/editarRangoNumericoTripleI.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_vpn(){
	if($('#valorBooleano').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),valorBooleano:$('#valorBooleano').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/editBooleano.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),valorBooleano:$('#valorBooleano').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/editBooleano.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_vran(){
	if($('#rangoI').val()!='' & $('#rangoF').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),rangoI:$('#rangoI').val(),rangoF:$('#rangoF').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/editarRangoNumerico.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),rangoI:$('#rangoI').val(),rangoF:$('#rangoF').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/editarRangoNumerico.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_vranmm(){
	if($('#valor').val()!='' & $('#variacion').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),valor:$('#valor').val(),variacion:$('#variacion').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/editRangoMM.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),valor:$('#valor').val(),variacion:$('#variacion').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/editRangoMM.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_vmax(){
	if($('#valorMax').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),valorMax:$('#valorMax').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/editValorMax.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),valorMax:$('#valorMax').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/editValorMax.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_vmim(){
	if($('#valorMin').val()!='' & $('#sexoEP').val()!='' & $('#tipoEdad').val()!=''){
		if($('#tipoEdad').val()=='RANGO DE EDAD'){
			if($('#edadI').val()!='' & $('#edadF').val()!=''){
				var data = {id_u:$('#id_user').val(),valorMin:$('#valorMin').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
				$.post('laboratorio/bases/files-serverside/editValorMin.php',data).done(function(data){
					if(data == 1){ $('#clickmeRe').click(); }
				});
			}else{
				$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
				$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
			}
		}else if($('#tipoEdad').val()=='TODAS LAS EDADES'){
			var data = {id_u:$('#id_user').val(),valorMin:$('#valorMin').val(),sexo:$('#sexoEP').val(),tipoEdad:$('#tipoEdad').val(),tipo_edadR:$('#tipo_edadR').val(),edadI:$('#edadI').val(),edadF:$('#edadF').val(),idAVR:$('#idAVR').val()}
			$.post('laboratorio/bases/files-serverside/editValorMin.php',data).done(function(data){
				if(data == 1){ $('#clickmeRe').click(); }
			});
		}
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
function guardar_acon(id){
	if($('#cantidadC').val()!='' & $('#precioC').val()!=''){
		var data = {id_u:$('#id_user').val(),cantidad:$('#cantidadC').val(),precio:$('#precioC').val(),idAC:$('#idAVR').val()}
		$.post('laboratorio/bases/files-serverside/editPrecioCantidad.php',data).done(function(data){
			if(data == 1){ 
				$('#clickmeCo').click(); var idACo = {idC : id}
				$.post('laboratorio/bases/files-serverside/calculaPrecioMB.php',idACo).done(function(data){ $('#precioP').val(data); });
			}
		});
	}
	else{
		$('#formEditarValorTexto').append('<div id="" class="alert alert-danger alerta_12"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Favor de ingresar todos los campos.</div>');
		$(".alerta_12").fadeTo(2000,500).slideUp(500,function(){ $(".alerta_12").slideUp(600); $('.alerta_12').remove(); });
	}
}
</script>