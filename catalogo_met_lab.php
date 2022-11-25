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
    
    <title>SISTEMA - METODOS LABORATORIO</title>
    
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
    <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.select2-dropdown{
			z-index: 9999;
		}
	</style>
</head>
<?php include_once 'partes/header.php'; ?>
<!-- Contenido -->
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;" nowrap>
    	<button type="button" class="btn btn-sm btn-primary" onClick="nuevo_met();">
        METODO <i class="fa fa-plus"></i>
        </button>
    </th>
    <th style="vertical-align:middle;">USUARIO</th>
    <th style="vertical-align:middle;">ELIMINAR</th>
    <th style="vertical-align:middle;" nowrap>ASIGNACIONES</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-Metodo-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-Usuario-"/></th>
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
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li>CATÁLOGOS</li><li class="active"><strong>METODOS LABORATORIO</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-127-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,
		"sScrollY": tamP, 
		ordering: false, 
		searching: true, 
		scrollCollapse: false, 
		"scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
		 scroller: false, 
		 responsive: true,
		"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true} ],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, 
		select: false, 
		"processing": false, 
		"sAjaxSource": "catalogos/metodos_laboratorio/datatable-serverside/metodos.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val();
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } );
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SERVICIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE SERVICIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 20, paging: true,
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
});

function nuevo_met(){
	$("#myModal").load('catalogos/metodos_laboratorio/htmls/metodos.php', function( response, status, xhr ){ if(status=="success"){
		$('#idUser_met').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#titulo_modal').text('CREAR UN NUEVO METODO PARA LABORATORIO');
		
		$('#form-met').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#myModal #form-met').serialize();
			$.post('catalogos/metodos_laboratorio/files-serverside/addMetodo.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_new_u').show(); $('#myModal').modal('hide'); 
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "La unidad de medida se ha dado de alta.",
					  timer: 1900, showConfirmButton: false
					}); return;
				} else{alert(data);}
			});
		  }
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) {
			$('#form-ficha_us').validator(); $('#form-ficha_us input').keyup(function(e) { $('#alerta_new_user').hide(); });
		});
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}

function editar(id_m, metodo){0
	$("#myModal").load('catalogos/metodos_laboratorio/htmls/metodos.php', function( response, status, xhr ){ if(status=="success"){
		$('#idUser_met').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#titulo_modal').text('FICHA DEL METODO: '+metodo);
		$('#idMetodo').val(id_m);
		
		var datos ={id_m:id_m}
		$.post('catalogos/metodos_laboratorio/files-serverside/ficha_metodos.php',datos).done(function(data1){
			var datosI = data1.split('*}');
			 $('#nombre_metodo').val(datosI[1]);
			//  $('#nombre_carrera').val(datosI[2]);
			//  $('#idProfesion').val(id_um);
			$('#form-met').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
				$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
			  } else { // everything looks good!
				e.preventDefault(); 
				
				var datosP = $('#myModal #form-met').serialize();
				$.post('catalogos/metodos_laboratorio/files-serverside/update_met.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $('#myModal').modal('hide'); 
						swal({
						  title: "¡CONFIRMACIÓN!", type: "success", text: "El memtodo se ha actualizado.",
						  timer: 1900, showConfirmButton: false
						}); return;
					} else{alert(data);}
				});
			  }
			});
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}

function asignaciones(id_m, metodo){0
	$("#myModal").load('catalogos/metodos_laboratorio/htmls/asignaciones.php', function( response, status, xhr ){ if(status=="success"){
		$('#idUser_met').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#titulo_modal').text('FICHA DEL METODO: '+metodo);
		$('.idMetodo').attr('lang',id_m);
		
		var datosM = {id_m:id_m}
		$.post('catalogos/metodos_laboratorio/datatable-serverside/asignaciones1.php', datosM).done(function( dataT ) {
			// console.log(dataT);
			var dataSet = JSON.parse(dataT);

			var oTableP1=$('#dataTableAsignacion').DataTable( {
				serverSide: true,
				// "sScrollY": tamP, 
				ordering: false, 
				searching: true, 
				scrollCollapse: false, 
				"scrollX": true,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
				"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
				scroller: false, 
				responsive: true,
				deferRender: true, 
				select: false, 
				"processing": false, 
				"sAjaxSource": "catalogos/metodos_laboratorio/datatable-serverside/asignaciones1.php",
				"fnServerParams": function (aoData, fnCallback) { 
					var nombre = $('#top-search').val();
					var acceso = $('#acc_user').val(); 
					var idU = $('#id_user').val();
					
					aoData.push( {"name": "id_m", "value": id_m } );
					aoData.push( {"name": "nombre", "value": nombre } );
					aoData.push(  {"name": "accesoU", "value": acceso } );
					aoData.push(  {"name": "idU", "value": idU } );
				},
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ registros por pagina", 
					"sZeroRecords": "EL METODO NO ESTA ASIGNADO - LO SENTIMOS", 
					"sInfo": "ASIGNACIONES FILTRADAS: _END_",
					"sInfoEmpty": "NINGÚNA ASIGNACION FILTRADA.", 
					"sInfoFiltered": " TOTAL DE ASIGNACIONES: _MAX_", 
					"sSearch": "BUSCAR",
					"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
				},
				"iDisplayLength": 20, 
				paging: true,
			} );
			$('#clickmeAS').click(function(e) { oTableP1.draw(); }); window.setTimeout(function(){$('#clickmeAS').click();},500);
			

			//para los fintros individuales por campo de texto
			oTableP1.columns().every( function () {
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
		});

		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}

function nuevo_asig_est(id_m , estudio){
	$('#asignar_metodo').removeClass('hide');
	$('.asignar').removeClass('hide');

	
	// select2ini("#estudios_l", "laboratorio.php", "SELECCIONE EL ESTUDIO DE LABORATORIO AL QUE DESEA ASIGNAR ESTE METODO");
	// select2ini("#base_est", "base.php", "SELECCIONE LA BASE DE LABORATORIO AL QUE DESEA ASIGNAR ESTE METODO");

	if(estudio == 'LABORATORIO'){
		$('.laboratorio_est').removeClass('hide');
		$('.est_base').addClass('hide');
		// $('.base_est').val('INVALIDO');

		select2ini("#estudios_l", "laboratorio.php", "SELECCIONE EL ESTUDIO DE LABORATORIO AL QUE DESEA ASIGNAR ESTE METODO");
		$("#base_est").html("<option value='INVALIDO' selected>INVALIDO</option>");
			$("#base_est").select2("data", {
				id: 'INVALIDO',
				text: 'INVALIDO'
			});
			$("#base_est").trigger("change");
		


	}else if(estudio == 'BASE'){
		$('.est_base').removeClass('hide');
		$('.laboratorio_est').addClass('hide');
		// $('.estudios_l').val('INVALIDO');

		select2ini("#base_est", "base.php", "SELECCIONE LA BASE DE LABORATORIO AL QUE DESEA ASIGNAR ESTE METODO");
		$("#estudios_l").html("<option value='INVALIDO' selected>INVALIDO</option>");
		$("#estudios_l").select2("data", {
			id: 'INVALIDO',
			text: 'INVALIDO'
		});
		$("#estudios_l").trigger("change");
		

	}

	//guardar
	$('#form-asig').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#myModal #form-asig').serialize();
				datosP += "&id_m=" + id_m + "&idU=" + $('#id_user').val();


			if($('#estudios_l').val() != 'INVALIDO'){
				$.post('catalogos/metodos_laboratorio/files-serverside/asignar_metodo_laboratorio.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_new_u').show(); $('#myModal').modal('hide'); 
						swal({
						title: "¡CONFIRMACIÓN!", type: "success", text: "La unidad de medida se ha dado de alta.",
						timer: 1900, showConfirmButton: false
						}); return;
					} else{alert(data);}
				});


			}else if($('#est_base').val() != 'INVALIDO'){
				$.post('catalogos/metodos_laboratorio/files-serverside/asignar_metodo_imagen.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_new_u').show(); $('#myModal').modal('hide'); 
						swal({
						title: "¡CONFIRMACIÓN!", type: "success", text: "La unidad de medida se ha dado de alta.",
						timer: 1900, showConfirmButton: false
						}); return;
					} else{alert(data);}
				});
			}
			
		  }
		});

}
function delete_met(id_m, nombre_m){
        swal({
          title: "ELIMINAR METODO: "+nombre_m, text: "¿Estás seguro de eliminar este metodo?", type: "warning", showCancelButton: true,
          confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
        },
        function(){
            var datos = { id_m:id_m, nombre_m:nombre_m}
            $.post('catalogos/metodos_laboratorio/files-serverside/eliminar_met.php',datos).done(function( data ) { if (data==1){
                $('#myModalx').modal('hide'); $('#clickme,#clickmeMem,#clickmeFo,#clickmeDo').click();
                swal({ title: "", type: "success", text: "El metodo se ha eliminado.", timer: 1800, showConfirmButton: false }); return;
            } else{alert(data);} });
        });
}
function delete_asig(id_m){
        swal({
          title: "ELIMINAR ASIGNACION DEL METODO ", text: "¿Estás seguro de eliminar esta asignación?", type: "warning", showCancelButton: true,
          confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
        },
        function(){
            var datos = { id_m:id_m}
            $.post('catalogos/metodos_laboratorio/files-serverside/eliminar_asig.php',datos).done(function( data ) { if (data==1){
                $('#myModalx').modal('hide'); $('#clickme,#clickmeAS,#clickmeFo,#clickmeDo').click();
                swal({ title: "", type: "success", text: "La asignacion del metodo se ha eliminado.", timer: 1800, showConfirmButton: false }); return;
            } else{alert(data);} });
        });
}

function select2ini(donde, url, ph){
    $(donde).select2({
        language: "es",
        width: "off",
        allowClear: true,
        ajax: {
            url: 'select/'+url,
            type: "post",
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                };
                return query;
            }
        },
        placeholder: ph
    });
}
</script>