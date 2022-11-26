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
    
    <title>SISTEMA - FORMATOS</title>
    
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
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
	
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">
		NOMBRE DEL FORMATO <button type="button" class="btn btn-xs btn-default" onClick="nuevo_formato();"><i class='fa fa-plus'></i></button>
	</th>
    <th style="vertical-align:middle;">USUARIO</th>
    <th style="vertical-align:middle;">FECHA</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input style="width: 99%" type="text" class="form-control input-sm" placeholder="-NOMBRE DEL FORMATO-"/></th>
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
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li class="active">FORMATOS</li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-159;
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>i', deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "formatos/datatable-serverside/formatos.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val();
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } );
			aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } );
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "FORMATOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN FORMATO FILTRADO.", "sInfoFiltered": " TOTAL DE FORMATOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 50000, paging: false,
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
function nuevo_formato(){
	$("#myModal1").load("formatos/htmls/ficha_formato.php",function(response,status,xhr){ if(status == "success"){ tinymce.remove("#input");
		tinymce.init({
			selector:'#myModal1 #input',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
			plugins: 
				"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
			relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
			toolbar:
				"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
			insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
			paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
			setup: function(editor){
				editor.addButton( 'mybuttonVP', {
					text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
					onclick:function(){
						var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
						$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
						$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
					}
				});
			}
		});
		
		$('#myModal1').modal('show'); $('#myModal1').on('shown.bs.modal', function(e){ });
		$('#myModal1').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
	}});
}
	
function guarda_formato(){
	if(tinyMCE.get("input").getContent() != '' & $('#nombreF').val() != ''){
		var datosP = {id_u:$('#id_user').val(), formato:tinyMCE.get("input").getContent(), nombre:$('#nombreF').val()}
		$.post('formatos/files-serverside/addFormato.php',datosP).done(function( data ) {
			if (data==1){//si el paciente se Actualizó 
				$('#clickme').click(); $('#myModal1').modal('hide');
				swal({ title: "", type: "success", text: "El formato se ha creado.", timer: 1800, showConfirmButton: false }); return;
			} else{alert(data);}
		});
	}else{}
}
function actualiza_formato(){
	if(tinyMCE.get("input").getContent() != '' & $('#nombreF').val() != ''){
		var datosP = {id_u:$('#id_user').val(), formato:tinyMCE.get("input").getContent(), nombre:$('#nombreF').val(), id_f:$('#id_formatof').val()}
		$.post('formatos/files-serverside/updateFormato.php',datosP).done(function( data ) {
			if (data==1){//si el paciente se Actualizó 
				$('#clickme').click(); $('#myModal1').modal('hide');
				swal({ title: "", type: "success", text: "El formato se ha actualizado.", timer: 1800, showConfirmButton: false }); return;
			} else{alert(data);}
		});
	}else{}
}
	
function ficha_formato(nf, idf){
	$("#myModal1").load("formatos/htmls/ficha_formato.php",function(response,status,xhr){ if(status == "success"){
		$('#titulo_modal').text(nf); $('#btn_actualizar').removeClass('hidden'); $('#btn_guardar').remove(); $('#id_formatof').val(idf); $('#nombreF').val(nf);
		
		var datosFts ={id_f:idf}
		$.post('formatos/files-serverside/ficha_formato.php',datosFts).done(function(data1x){ tinymce.remove("#input");
			tinymce.init({
				selector:'#myModal1 #input',resize:false,height:$('#referencia').height()*0.48,theme: "modern",
				plugins: 
					"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss",
				relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#referencia').width()*0.8,
				toolbar:
					"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP |",
				insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
				paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true,
				setup: function(editor){
					editor.addButton( 'mybuttonVP', {
						text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
						onclick:function(){
							var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
							$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
							$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
						}
					});
				}
			}); setTimeout(function(){ tinymce.get("input").execCommand('mceInsertContent', false, data1x); }, 500);
		});
		
		$('#myModal1').modal('show'); $('#myModal1').on('shown.bs.modal', function(e){ });
		$('#myModal1').on('hidden.bs.modal', function(e){ $(".modal-content").remove(); $("#myModal1").empty(); });
	}});
}

function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); $('#inserta_algo').val(''); }
</script>