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
    
    <title>SISTEMA - MEDICAMENTO GENERICO</title>
    
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
	<th style="vertical-align:middle;">CLAVE</th>
    <th style="vertical-align:middle;">
    	<button type="button" class="btn btn-sm btn-primary" onClick="nuevo_medicamento();">
        MEDICAMENTO <i class="fa fa-plus"></i>
        </button>
    </th>
    <th style="vertical-align:middle;">DESCRIPCIÓN</th>
	<th style="vertical-align:middle;">NIVEL</th>
	<th style="vertical-align:middle;">GRUPO</th>
	<th style="vertical-align:middle;">INDICACIONES</th>
	<th style="vertical-align:middle;">ELIMINAR</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-CLAVE-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-NOMBRE-"/></th>
			<th></th>
			<th><input type="text" class="form-control input-sm" placeholder="-NIVEL-"/></th>
			<th><input type="text" class="form-control input-sm" placeholder="-GRUPO-"/></th>
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
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li>CATÁLOGOS</li><li class="active"><strong>MEDICAMENTO GENERICO</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-127-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [ 
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true},{"bVisible":true}
			],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "catalogos/medicamento_generico/datatable-serverside/medicamento.php",
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
		},"iDisplayLength": 50, paging: true,
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

function nuevo_medicamento(){
	$("#myModal").load('catalogos/medicamento_generico/htmls/medicamento.php', function( response, status, xhr ){ if(status=="success"){
		$('#id_usr_reg').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#titulo_modal').text('CREAR UN NUEVO MEDICAMENTO');
		select2ini("#via_administracion_m", "via_administracion.php", "SELECCIONE VIA ADMINISTRACIÓN");
		
		$('#med_generico').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
			$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
		  } else { // everything looks good!
			e.preventDefault(); 
			var $btn = $('#btn_new_u').button('loading'); $('#btn_cancel_new_u').hide();
			var datosP = $('#myModal #med_generico').serialize();
			$.post('catalogos/medicamento_generico/files-serverside/addMedicamento.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $btn.button('reset'); $('#btn_cancel_new_u').show(); $('#myModal').modal('hide'); 
					swal({
					  title: "¡CONFIRMACIÓN!", type: "success", text: "El medicamento se guardo correctamente.",
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

function editar(id_um, unidad){0
	$("#myModal").load('catalogos/medicamento_generico/htmls/medicamento.php', function( response, status, xhr ){ if(status=="success"){
		$('#id_usr_reg').val($('#id_user').val()); $('#alerta_new_user').hide();
		$('#titulo_modal').text('FICHA DEL MEDICAMENTO: '+unidad);
		$('#id_unidad_m').val(id_um);
		$('#btn_save_mg').addClass('hidden');
		$('#btn_update_carrera').removeClass('hidden');
		
		var datos ={id_um:id_um}
		$.post('catalogos/medicamento_generico/files-serverside/ficha_medicamento.php',datos).done(function(data1){
			var datosI = data1.split('*}');
			 $('#clv_m').val(datosI[1]);
			 $('#cant_m').val(datosI[4]);
			 $('#present_m').val(datosI[5]);
			 $('#Rembarazo_m').val(datosI[9]);
			 $('#nombre_generico_m').val(datosI[2]);
			 $('#desc_m').val(datosI[3]);
			 $('#nivel_m').val(datosI[6]);
			 $('#grupoMedico_m').val(datosI[7]);
			 $('#via_administracion_m').val(datosI[15]);
			 $('#contenido_m').val(datosI[16]);
			 $('#generalidades_m').val(datosI[8]);
			 $('#efectos_m').val(datosI[10]);
			 $('#contradicciones_m').val(datosI[11]);
			 $('#interacciones_m').val(datosI[12]);
			 $('#indicaciones_m').val(datosI[13]);
			 $('#via_admin_dosis_m').val(datosI[14]);
			 $('#presentaciones_m').val(datosI[17]);

			 select2ini("#via_administracion_m", "via_administracion.php", "SELECCIONE VIA ADMINISTRACIÓN");
		     $("#via_administracion_m").html("<option value='"+datosI[15]+"' selected>"+datosI[15]+"</option>");

			$('#med_generico').validator().on('submit', function (e) {
			  if (e.isDefaultPrevented()) { // handle the invalid form...
				$("#alerta_new_user").fadeTo(2000,500).slideUp(500,function(){ $("#alerta_new_user").slideUp(600); });
			  } else { // everything looks good!
				e.preventDefault(); 
				
				var datosP = $('#myModal #med_generico').serialize();
					datosP +="&idm="+id_um;
				$.post('catalogos/medicamento_generico/files-serverside/update_medicamento.php',datosP).done(function( data ) {
					if (data==1){//si el paciente se Actualizó 
						$('#clickme').click(); $('#myModal').modal('hide'); 
						swal({
						  title: "¡CONFIRMACIÓN!", type: "success", text: "La unidad de medida se ha actualizado.",
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
function delete_medicamento(id_p, nombre_p){
        swal({
          title: "ELIMINAR PROFESION: "+nombre_p, text: "¿Estás seguro de eliminar esta profesion?", type: "warning", showCancelButton: true,
          confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
        },
        function(){
            var token = $('meta[name="csrf-token"]').attr('content');
            var datos = {_token:token, id_p:id_p, nombre_p:nombre_p}
            $.post('catalogos/medicamento_generico/files-serverside/eliminar_medicamento.php',datos).done(function( data ) { if (data==1){
                $('#myModalx').modal('hide'); $('#clickme,#clickmeMem,#clickmeFo,#clickmeDo').click();
                swal({ title: "", type: "success", text: "La Profesión se ha eliminado.", timer: 1800, showConfirmButton: false }); return;
            } else{alert(data);} });
        });
    }

	function select2ini(donde, url, ph){
    $(donde).select2({
        language: "es",
        width: "180px",
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