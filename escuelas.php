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
    
    <title>SISTEMA - ESCUELAS</title>
    
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
    <script src="jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
	<script src="jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>
    
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
    <th style="vertical-align:middle;">
    	ESCUELA
        <button class="btn btn-default btn-xs" onClick="nueva_escuela();"><i class="fa fa-plus"></i></button>
    </th>
    <th style="vertical-align:middle;">NIVEL</th>
    <th style="vertical-align:middle;">SECTOR</th>
    <th style="vertical-align:middle;">ESTADO</th>
    <th style="vertical-align:middle;">LOGO</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="Escuela"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Nivel"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Sector"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="Estado"/></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
function nueva_escuela(){
	$("#myModal").load('escuelas/htmls/escuela.php', function(response, status, xhr){ if(status=="success"){
		$('#titulo_modal').text('CREAR UNA NUEVA ESCUELA'); $('#idUser_esc').val($('#id_user').val());
		
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
function verEscuela(id_e, nombre_e){
	$("#myModal1").load('escuelas/htmls/escuela.php', function(response, status, xhr){ if(status=="success"){
		$('#titulo_modal').text('FICHA DE LA ESCUELA '+nombre_e); $('#idEscuela').val(id_e);
		
		var dato = { id_e:id_e, idU:$('#id_user').val() }
		$.post('escuelas/files-serverside/datosEscuela.php', dato).done(function(data){
			var datos = data.split('}[-]{');
			$('#nombre_esc').val(datos[0]); $('#nivel_esc').val(datos[1]); $('#sector_esc').val(datos[2]); $('#estado_esc').val(datos[3]);
		});
				
		$('#form-escuela').validator().on('submit', function (e) {
		  if (e.isDefaultPrevented()) { // handle the invalid form...
		  } else { // everything looks good!
			e.preventDefault(); 
			var datosP = $('#myModal1 #form-escuela').serialize();
			$.post('escuelas/files-serverside/updateSchool.php',datosP).done(function( data ) {
				if (data==1){//si el paciente se Actualizó 
					$('#clickme').click(); $('#myModal1').modal('hide'); //$('#btn_cancel_registro').show(); //$btn.button('reset');
					swal({ title: "", type: "success", text: "Los datos se han actualizado.", timer: 1800, showConfirmButton: false }); return;
				} else{alert(data);}
			});
		  }
		});
				
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function(e){ $('#form-escuela').validator(); });
		$('#myModal1').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
	}});
}

$(document).ready(function(e) {
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>ADMINISTRACIÓN</li><li class="active"><strong>CATÁLOGO DE ESCUELAS</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-155-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns":[ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}, {"bVisible":true} ],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "escuelas/datatable-serverside/escuelas.php",
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
		},"iDisplayLength": 100, paging: true,
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

function subir_logo(id_s, name_s){ //alert(name_s);
	$("#myModal2").load('escuelas/htmls/subir_logo.php', function(response, status, xhr){ if(status=="success"){
		$('#titulo_modal').text('SUBIR EL LOGO DE LA ESCUELA '+name_s); $('#titulo_d').val(id_s);
		
		//Para el upload
		'use strict'; var userL = $('#id_user').val();
		var url = window.location.hostname === 'blueimp.github.io' ?
			'//jquery-file-upload.appspot.com/' : 'escuelas/logotipos/index.php?idU='+userL+'&idP='+id_s+'&nombreD='+escape($('#titulo_d').val());
		$('#fileupload_logo').fileupload({
			url: url, dataType: 'json',
			submit:function (e, data) {
				$.each(data.files, function (index, file) {
					var input = $('#titulo_d'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
				});
			},
			progress: function (e, data) {
				var progress=parseInt(data.loaded / data.total * 100,10);$('#progress .bar').css('width', progress + '%');
			},
			done: function(e, data){
				$('#clickme').click(); $('#myModal2').modal('hide');
				swal({ title: "", type: "success", text: "El logotipo se ha guardado.", timer: 1800, showConfirmButton: false }); return;
			},
		});
		//Para el upload
		
		$('#myModal2').modal('show');
		$('#myModal2').on('shown.bs.modal', function(e){  });
		$('#myModal2').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal2").empty(); });
	}});
}

function ver_logo(nombre_img, name_s, exte, time,titulo,carpeta,id_doc,que_es){
	$("#myModalx").load('pacientes/htmls/miPDFdocs.php', function(response, status, xhr){ if(status=="success"){
		$('#titulo_modal').text(titulo+' DE LA EMPRESA '+ name_s);
		if(exte != 'pdf' & exte != 'PDF'){
			x=carpeta+'/files/'+id_doc+'.'+exte+'?'+time;
			$('#mi_documento').html('<img src='+x+' style="max-width:750px; border:5px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
		}else{
			x=carpeta+'/files/'+id_doc+'.pdf';
			$('#mi_documento').html('<a class="media" href=""> </a>');
			$('a.media').media({width:890, height:h-136, src:x});	
		}
		
		$('#btn_eliminar_img').click(function(e){ delete_documento(id_doc,titulo,exte,que_es,carpeta); });
		
		$('#myModalx').modal('show');
		$('#myModalx').on('shown.bs.modal', function(e){  });
		$('#myModalx').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModalx").empty(); });
	}});	
}

function delete_documento(id_doc, nombre_doc, tipo_doc, titulo,carpeta){//alert(tipo_doc);
	swal({
	  title: "ELIMINAR EL LOGO", text: "¿Estás seguro de eliminar el archivo?", type: "warning", showCancelButton: true,
	  confirmButtonColor: "#DD6B55", confirmButtonText: "Eliminar", cancelButtonText: "Cancelar", closeOnConfirm: false
	},
	function(){
		var datos = {id:id_doc, tipo:tipo_doc, que_es:titulo,carpeta:carpeta}
		$.post('escuelas/files-serverside/eliminarLogo.php',datos).done(function( data ) { if (data==1){
			$('#myModalx').modal('hide'); $('#clickme,#clickmeMem,#clickmeFo,#clickmeDo').click();
			swal({ title: "", type: "success", text: "El logotipo se ha eliminado.", timer: 1800, showConfirmButton: false }); return;
		} else{alert(data);} });
	});
}
</script>