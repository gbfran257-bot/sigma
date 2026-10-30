<?php
	include_once 'recursos/session.php';

	/* ===== Endpoints AJAX de esta misma pantalla (PDF compartido e INTERPRETACIÓN EN IMAGEN) =====
	   Van dentro de ultrasonido.php para no depender de archivos adicionales en el servidor. */
	if(isset($_GET['usg_ajax'])){
		header('Content-Type: text/plain; charset=utf-8');
		$usg_acc = isset($_GET['accion']) ? $_GET['accion'] : (isset($_POST['accion']) ? $_POST['accion'] : '');
		
		if($usg_acc == 'pdf'){ // recibe el PDF generado en el navegador, lo guarda y devuelve su enlace
			if(!isset($_FILES['pdf'])){ echo 'ERROR: no llegó el PDF (revisa post_max_size y upload_max_filesize en php.ini)'; exit; }
			if($_FILES['pdf']['error'] !== UPLOAD_ERR_OK){ echo 'ERROR: falló la subida del PDF (código '.$_FILES['pdf']['error'].'; 1 y 2 = excede upload_max_filesize/post_max_size en php.ini)'; exit; }
			if($_FILES['pdf']['size'] > 25*1024*1024){ echo 'ERROR: el PDF pesa más de 25 MB'; exit; }
			$fh = fopen($_FILES['pdf']['tmp_name'], 'rb'); $cab = fread($fh, 5); fclose($fh);
			if($cab !== '%PDF-'){ echo 'ERROR: el archivo recibido no es un PDF'; exit; }
			$idVCp = isset($_POST['idVC']) ? intval($_POST['idVC']) : 0;
			$dirp = dirname(__FILE__).'/imagen/pdf_compartidos/';
			if(!is_dir($dirp)){ if(!@mkdir($dirp, 0755, true)){ echo 'ERROR: no se pudo crear la carpeta imagen/pdf_compartidos (revisa permisos)'; exit; } }
			if(!file_exists($dirp.'.htaccess')){ @file_put_contents($dirp.'.htaccess', "Options -Indexes\n"); }
			if(!file_exists($dirp.'index.html')){ @file_put_contents($dirp.'index.html', ''); }
			$viejos = glob($dirp.'usg_*.pdf'); // se borran los PDFs de más de 15 días
			if($viejos){ foreach($viejos as $f){ if(filemtime($f) < time() - 15*86400){ @unlink($f); } } }
			if(function_exists('openssl_random_pseudo_bytes')){ $rnd = bin2hex(openssl_random_pseudo_bytes(16)); }
			else{ $rnd = md5(uniqid(mt_rand(), true)).md5(microtime()); }
			$nombrep = 'usg_'.$idVCp.'_'.$rnd.'.pdf';
			if(!move_uploaded_file($_FILES['pdf']['tmp_name'], $dirp.$nombrep)){ echo 'ERROR: no se pudo guardar el PDF en el servidor (revisa permisos de imagen/pdf_compartidos)'; exit; }
			$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https');
			$basep = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
			echo 'OK|'.($https ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$basep.'/imagen/pdf_compartidos/'.$nombrep;
			exit;
		}
		
		if($usg_acc == 'membrete_leer'){ // datos editables del encabezado y pie del informe
			$fm = dirname(__FILE__).'/imagen/membrete_usg.json';
			echo 'OK|'.(file_exists($fm) ? file_get_contents($fm) : '');
			exit;
		}
		if($usg_acc == 'membrete_guardar'){
			$cfgj = isset($_POST['cfg']) ? $_POST['cfg'] : '';
			if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){ $cfgj = stripslashes($cfgj); }
			$arr = json_decode($cfgj, true);
			if(!is_array($arr)){ echo 'ERROR: datos no válidos'; exit; }
			$campos = array('titulo','medico','linea','certificacion','horario','gracias','direccion','telefono','correo','logo');
			$limpio = array();
			foreach($campos as $c){ $limpio[$c] = isset($arr[$c]) ? substr(strip_tags((string)$arr[$c]), 0, 300) : ''; }
			$limpio['auto'] = !empty($arr['auto']) ? 1 : 0;
			if(isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK){ // logo opcional
				$info = @getimagesize($_FILES['logo']['tmp_name']);
				$exts = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif');
				if(!$info || !isset($exts[$info[2]])){ echo 'ERROR: el logo debe ser PNG, JPG o GIF'; exit; }
				if($_FILES['logo']['size'] > 3*1024*1024){ echo 'ERROR: el logo pesa más de 3 MB'; exit; }
				foreach(array('png','jpg','gif') as $e2){ $viejo = dirname(__FILE__).'/imagen/logo_informe.'.$e2; if(file_exists($viejo)){ @unlink($viejo); } }
				$destl = 'imagen/logo_informe.'.$exts[$info[2]];
				if(!move_uploaded_file($_FILES['logo']['tmp_name'], dirname(__FILE__).'/'.$destl)){ echo 'ERROR: no se pudo guardar el logo (revisa permisos de la carpeta imagen)'; exit; }
				$limpio['logo'] = $destl;
			}
			if(@file_put_contents(dirname(__FILE__).'/imagen/membrete_usg.json', json_encode($limpio)) === false){ echo 'ERROR: no se pudo guardar (revisa permisos de la carpeta imagen)'; exit; }
			echo 'OK|'.json_encode($limpio);
			exit;
		}
		
		// guardar / leer la INTERPRETACIÓN EN IMAGEN (columna venta_conceptos.interpretacion_img_vc, se crea sola)
		require('Connections/horizonte.php');
		mysql_select_db($database_horizonte, $horizonte);
		$usg_id = isset($_POST['idE']) ? intval($_POST['idE']) : 0;
		if($usg_id <= 0){ echo 'ERROR: falta el id del estudio'; exit; }
		$rcol = mysql_query("SHOW COLUMNS FROM venta_conceptos LIKE 'interpretacion_img_vc'", $horizonte);
		if(!$rcol){ echo 'ERROR: '.mysql_error(); exit; }
		if(mysql_num_rows($rcol) == 0){
			if(!mysql_query("ALTER TABLE venta_conceptos ADD COLUMN interpretacion_img_vc LONGTEXT NULL", $horizonte)){
				echo 'ERROR: no se pudo crear la columna. Ejecuta en MySQL: ALTER TABLE venta_conceptos ADD COLUMN interpretacion_img_vc LONGTEXT NULL;  ('.mysql_error().')'; exit;
			}
		}
		if($usg_acc == 'guardar'){
			$dxi = isset($_POST['dx']) ? $_POST['dx'] : '';
			if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){ $dxi = stripslashes($dxi); }
			$dxi = mysql_real_escape_string($dxi, $horizonte);
			if(!mysql_query("UPDATE venta_conceptos SET interpretacion_img_vc = '$dxi' WHERE id_vc = $usg_id LIMIT 1", $horizonte)){ echo 'ERROR: '.mysql_error(); exit; }
			echo 'OK|';
		}elseif($usg_acc == 'leer'){
			$rl = mysql_query("SELECT interpretacion_img_vc FROM venta_conceptos WHERE id_vc = $usg_id LIMIT 1", $horizonte);
			if(!$rl){ echo 'ERROR: '.mysql_error(); exit; }
			$rwl = mysql_fetch_row($rl);
			echo 'OK|'.($rwl ? $rwl[0] : '');
		}else{ echo 'ERROR: acción no válida'; }
		exit;
	}
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
    
    <title>SISTEMA - ULTRASONIDO</title>
    
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

	<script src="DataTables-1.12/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="DataTables-1.12/JSZip-2.5.0/jszip.min.js"></script>
    <script src="DataTables-1.12/Buttons-2.2.3/js/buttons.html5.min.js"></script> 

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
    <!-- PDF en el navegador (para COMPARTIR). Local primero; si no existe, se baja del CDN -->
    <script src="funciones/js/html2pdf.bundle.min.js"></script>
    <script>if(typeof html2pdf==='undefined'){ document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"><\/script>'); }</script>
    
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
<style>
	/* Estructura de la tabla de ultrasonido */
	#dataTablePrincipal td, .dataTables_scrollBody td { vertical-align: middle !important; }
	#dataTablePrincipal th, .dataTables_scrollHead th { vertical-align: middle !important; }
	.dataTables_scrollFoot input, #dataTablePrincipal tfoot input { width: 100% !important; max-width: none !important; }
	.dataTables_scrollBody td h3 { margin: 0; }
	.col-centro { text-align: center; }
	/* encabezado, cuerpo y pie con el mismo ancho para que las columnas coincidan y MEDICO REFIERE se vea completo */
	#div_tabla_pacientes { overflow-x: hidden; }
	.dataTables_scroll, .dataTables_scrollHead, .dataTables_scrollBody, .dataTables_scrollFoot,
	.dataTables_scrollHeadInner, .dataTables_scrollFootInner { width: 100% !important; }
	.dataTables_scrollHeadInner table, .dataTables_scrollFootInner table, .dataTables_scrollBody table, #dataTablePrincipal {
		width: 100% !important; max-width: 100% !important; table-layout: fixed; margin-left: 0 !important;
	}
	#dataTablePrincipal th, #dataTablePrincipal td { overflow-wrap: break-word; }
	.dataTables_scrollBody { overflow-x: hidden !important; }
</style>
<input id="multisu_s" type="hidden" value="<?php echo $multisucu_u; ?>">
<div id="div_tabla_pacientes" class="table-responsive" style="border:1px none red; vertical-align:top; margin-top:-9px;">
	<div class="hidden" id="dpa_imprimir"></div><div class="hidden" id="dpa_imprimir1"></div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" id="dataTablePrincipal" class="table table-hover table-striped dataTables-example dataTable table-condensed" role="grid"> 
<thead id="cabecera_tBusquedaPrincipal">
  <tr role="row" class="bg-primary">
    <th id="clickme" style="vertical-align:middle;">#</th>
    <th style="vertical-align:middle;">PACIENTE</th>
    <th style="vertical-align:middle;">REFERENCIA</th>
    <th style="vertical-align:middle;">ESTUDIO</th>
    <th style="vertical-align:middle;">ESTATUS</th>
    <th style="vertical-align:middle; text-align:center;">EDITAR</th>
    <th style="vertical-align:middle; white-space:nowrap; text-align:center;">ID-PACS</th>
	<th style="vertical-align:middle; text-align:center;">IMÁGENES</th>
	<th style="vertical-align:middle;">MEDICO REFIERE</th>
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr class="bg-primary">
            <th></th>
            <th><input type="text" class="form-control input-sm" placeholder="-PACIENTE-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-REFERENCIA-" style="max-width:110px;"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTUDIO-"/></th>
            <th><input type="text" class="form-control input-sm" placeholder="-ESTATUS-"/></th>
            <th></th>
			<th></th>
			<th></th>
			<th><input type="text" class="form-control input-sm" placeholder="-MEDICO-" style="max-width:200px;"/></th>
        </tr>
    </tfoot>
</table>
</div>
<div id="auxiliar" class="hidden"></div> <div id="auxiliar1" class="hidden"></div>
<!-- FIN Contenido -->  
<?php include_once 'partes/footer.php'; ?>

<script>
$(document).ready(function(e) {
	//permite escribir en los diálogos de TinyMCE que se abren encima de los modales de Bootstrap
	$.fn.modal.Constructor.prototype.enforceFocus = function(){};
	//breadcrumb
	$('#breadc').html('<li><a href="index.php">HOME</a></li><li>IMAGEN</li><li class="active"><strong>ULTRASONIDO</strong></li>');
	
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true; 
	
	var tamP = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-215-$('#breadc').height();
	var oTableP = $('#dataTablePrincipal').DataTable({
		serverSide: true, autoWidth: false,
		columnDefs: [
			{ targets: 0, width: '45px' },
			{ targets: 1, width: '20%' },
			{ targets: 2, width: '135px' },
			{ targets: 3, width: '20%' },
			{ targets: 4, width: '170px' },
			{ targets: 5, width: '70px',  className: 'col-centro' },
			{ targets: 6, width: '140px', className: 'col-centro' },
			{ targets: 7, width: '85px',  className: 'col-centro' },
			{ targets: 8, width: '18%' }
		],
		// mantiene alineados encabezado, cuerpo y pie después de cada carga de datos
		drawCallback: function(){ var api = this.api(); window.setTimeout(function(){ ajustarAltoTabla(); api.columns.adjust(); }, 50); },
		"sScrollY": tamP, ordering: false, searching: true, scrollCollapse: false, "scrollX": false,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
		"aoColumns": [
			{"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}, {"bVisible":true}
		],
		"sDom": '<"filtro1Principal"f>B1<"data_tPrincipal"t><"infoPrincipal"iS><"proc"p>', 
		deferRender: true, select: false, "processing": false, 
		"sAjaxSource": "imagen/datatable-serverside/ultrasonidos.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var nombre = $('#top-search').val(); var de = $('#fechaDe').val()+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
			var acceso = $('#acc_user').val(); var idU = $('#id_user').val();
			
			aoData.push( {"name": "nombre", "value": nombre } ); aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } ); aoData.push(  {"name": "accesoU", "value": acceso } );
			aoData.push(  {"name": "idU", "value": idU } );
			aoData.push(  {"name": "conPacs", "value": 1 } ); // pide la columna ID-PACS al servidor
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "ESTUDIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},"iDisplayLength": 50000, paging: false,
	});
	
	$(window).on('resize', function(){ ajustarAltoTabla(); oTableP.columns.adjust(); });
	window.setTimeout(function(){ ajustarAltoTabla(); oTableP.columns.adjust(); }, 700);
	window.setTimeout(function(){ oTableP.columns.adjust(); ajustarAltoTabla(); }, 1500);
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
	
	$('.infoPrincipal').append('<div id="divRangoFechas" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">De &nbsp;</td> <td width="1%"> <input name="fechaDe" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly> </td> <td id="rangosFechas">&nbsp; <input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');
	
	$('#radio1').click(function(e){
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>');$('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#radio2').click(function(e){
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTableP.draw();
	});
	
	$('#fechaDe').on('changeDate', function(e) { oTableP.draw(); });
	$("#fechaA").on('changeDate', function(e) { oTableP.draw(); });
});
/* Calcula el alto del cuerpo de la tabla para que todo (filtros, fechas y pie "derechos reservados") quepa en pantalla */
function ajustarAltoTabla(){
	var $b = $('#dataTablePrincipal').closest('.dataTables_wrapper').find('.dataTables_scrollBody');
	if(!$b.length){ return; }
	var $scroll = $b.closest('.dataTables_scroll');
	var debajo = 0;
	$b.nextAll().each(function(){ debajo += $(this).outerHeight(true); });      // pie con los filtros de la tabla
	$scroll.nextAll().each(function(){ debajo += $(this).outerHeight(true); }); // fechas, info y paginación
	var pie = $('#my_footer').outerHeight(true) || 0;                            // pie "derechos reservados"
	if(pie < 45){ pie = 45; }                                                     // reserva mínima para "derechos reservados"
	var arriba = $b.offset().top - $(window).scrollTop();
	var h = $(window).height() - arriba - debajo - pie - 30;
	if(h < 120){ h = 120; }
	$b.css({'height': h+'px', 'max-height': h+'px'});

	// Corrección: mide hasta dónde llega realmente el último bloque (fechas) y quita lo que sobre
	var $ult = $('.infoPrincipal');
	if($ult.length){
		var limite = $(window).height() - pie - 10;
		var fondo = $ult[0].getBoundingClientRect().bottom;
		if(fondo > limite){
			h = Math.max(120, h - Math.ceil(fondo - limite));
			$b.css({'height': h+'px', 'max-height': h+'px'});
		}
	}
}
function preguntaX(n,r,e,i){//n es el nombre del paciente, r es la referencia e i es el id de la venta_conceptos
	swal({
	  title: "ATENDER ULTRASONIDO. REFERENCIA "+r, text: "¿DESEAS ATENDER EL ESTUDIO "+e+" DEL PACIENTE "+n+"?", type: "", showCancelButton: true,
	  confirmButtonColor: "#DD6B55", confirmButtonText: "Atender", closeOnConfirm: false, cancelButtonText: "Cancelar"
	},
	function(){
		var datoI = { idC:i,idU:$('#id_user').val() }
		$.post('imagen/archivos_save_ajax/procesarU.php', datoI).done(function( data ) { if (data == 1){ 
			$('#clickme').click(); $('#myModal1').modal('hide'); 
			swal({title:"",type:"success",text:"EL PROCESO SE HA REALIZADO CORRECTAMENTE",timer:2000,showConfirmButton:false});
			window.setTimeout(function(){fichaEstudio(2,i);},500);
		}else{alert(data);} });
	});
}

function fichaEstudio(e,i,idPx1a,id_s){ //e es el estatus del estudio e i es el id de vc
	$("#myModal").load('imagen/htmls/ficha_ultrasonido.php',function(response,status,xhr){if(status=="success"){
		tinymce.remove("#tInterpretacion #input");
		tinymce.remove("#tInterpretacionImg #input2"); cargarMembreteBase();
		if(e>2 & e<5){//Realizados 3 y capturados 4
			var dato = { idE:i, idU:$('#id_user').val(), nova:1 }
			$.post('imagen/files-serverside/datosInterpretarEn.php', dato).done(function( data ) { //alert(data);
				tinymce.init({
					selector:'#tInterpretacion #input',resize:false,height:$('#myModal').height()*0.63,theme: "modern",
					plugins: 
						"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss", table_default_styles: { width: '100%' },
					relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#myModal').width()*0.8,
					toolbar: 
						"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP | mybutton | mybutton1 | mybuttonPACS |",
					insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
					paste_data_images: true, paste_as_text: true, browser_spellcheck: true, 
					force_br_newlines : true, force_p_newlines : false, orced_root_block : '', 
					setup: function(editor){
						editor.addButton( 'mybutton', {
						  		text: 'INSERTAR IMGS', icon: false,
						  		onclick:function(){
									var datos = {idVC:i}
									$.post('imagen/files-serverside/insertarIMGsUSG.php',datos).done(function(data){editor.insertContent(data);});
						  		}
						});
						editor.addButton( 'mybutton1', { text: 'DICTAR', icon: false, onclick:function(){ procesarV(); } });
						editor.addButton( 'mybuttonPACS', {
							text: 'IMGS PACS', icon: false, tooltip: 'Insertar imágenes del estudio del PACS',
							onclick:function(){ insertarImgsPACS(editor, i, idPx1a); }
						});
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
				var datos = data.split(';*-');
				if(e==3){ //es = 3 es realizado, 4 es capturado
					var datosT = {idP:idPx1a, idU:$('#id_user').val(), id_vc:i}
					$.post('consultas/files-serverside/cat_texts.php',datosT).done(function(dataT){ var datosTe = dataT.split('-{]');
						var alergiasx = datosTe[0], edadx = datosTe[1], sexox = datosTe[2], nombre_pacientex = datosTe[3];
						var nombre_medicox = datosTe[4], svx = datosTe[5], abitusx = datosTe[6], adiccionesx = datosTe[7];
						var puntuacion_glax = datosTe[8], peso_tallax = datosTe[9], fecha_horax = datosTe[10]; //alert(et_firma_medico_atiende_x);
						var nombre_medico_a = datosTe[11], edadx1 = datosTe[12], cedula_p_ma = datosTe[13], nombre_conceptox = datosTe[28];
						var cedula_espe_x = datosTe[14], edad1_x = datosTe[15], especialidadm_x = datosTe[16], fecha_dia_x = datosTe[17];
						var fecha_mes_n_x = datosTe[18], fecha_anio_x = datosTe[19], fecha_hora_x = datosTe[20], nombre_establecimiento_x = datosTe[21];
						var nombre_universidad_x = datosTe[22], peso_x = datosTe[23], et_talla_g = datosTe[24], sex_x = datosTe[25];
						var tiposan_x = datosTe[26], titulom_x = datosTe[27], medico_refiere_x = datosTe[28], fecha_mes_l_x = datosTe[30];
						var firma_medico_atiende_x = datosTe[31], et_t_x = datosTe[34], et_a_x = datosTe[35], et_fc_x = datosTe[36];
						var et_fr_x = datosTe[37], et_temp_x = datosTe[38], et_dx_envio_x = datosTe[39], et_referencia_x = datosTe[40];
						var et_nombre_anestesiologo_x = datosTe[41], et_firma_medico_atiende_x = datosTe[42], et_logo_suc_x = datosTe[43];
						var et_logoe_x = datosTe[44], et_logoee_x = datosTe[45], et_logogm_x = datosTe[46];

								var data = datos[31];
								data = data.replace(/{ET_ALERGIAS}/gi, alergiasx);
								data = data.replace(/{ET_EDAD}/gi, edadx1);
								data = data.replace(/{ET_NOMBRE_MEDICO_ATIENDE}/gi, nombre_medicox);
								data = data.replace(/{et_nombre_personal_atiende}/gi, nombre_medico_a);																   
								data = data.replace(/{ET_NOMBRE_PACIENTE}/gi, nombre_pacientex);
								data = data.replace(/{ET_SEX}/gi, sexox);
								data = data.replace(/{ET_SV}/gi, svx);
								data = data.replace(/{ET_ABITUS}/gi, abitusx);
								data = data.replace(/{et_adicciones}/gi, adiccionesx);
								data = data.replace(/{et_puntuacion_g}/gi, puntuacion_glax);
								data = data.replace(/{et_pesotalla_g}/gi, peso_tallax);
								data = data.replace(/{et_fechahora}/gi, fecha_horax);
								data = data.replace(/{et_cedulap}/gi, cedula_p_ma);
								data = data.replace(/{et_nombre_procedimiento}/gi, nombre_conceptox);
								data = data.replace(/{et_cedulaesp}/gi, cedula_espe_x);
								data = data.replace(/{et_edad}/gi, edad1_x);
								data = data.replace(/{et_especialidadm}/gi, especialidadm_x);
								data = data.replace(/{et_fecha_dia}/gi, fecha_dia_x);
								data = data.replace(/{et_fecha_mes_numero}/gi, fecha_mes_n_x);
								data = data.replace(/{et_fecha_mes_letra}/gi, fecha_mes_l_x);
								data = data.replace(/{et_fecha_anio}/gi, fecha_anio_x);
								data = data.replace(/{et_fecha_hora}/gi, fecha_hora_x);
								data = data.replace(/{et_nombre_establecimiento}/gi, nombre_establecimiento_x);
								data = data.replace(/{et_nombre_medico_atiende}/gi, nombre_medico_a);
								data = data.replace(/{et_nombre_universidad}/gi, nombre_universidad_x);
								data = data.replace(/{et_nombre_paciente}/gi, nombre_pacientex);
								data = data.replace(/{et_peso_g}/gi, peso_x);
								data = data.replace(/{et_talla_g}/gi, et_talla_g);
								data = data.replace(/{et_sex}/gi, sex_x);
								data = data.replace(/{et_sv}/gi, svx);
								data = data.replace(/{et_tiposan}/gi, tiposan_x);
								data = data.replace(/{et_titulom}/gi, titulom_x);
								data = data.replace(/{et_nombre_medico_refiere}/gi, medico_refiere_x);
								data = data.replace(/{et_t}/gi, et_t_x);
								data = data.replace(/{et_a}/gi, et_a_x);
								data = data.replace(/{et_fc}/gi, et_fc_x);
								data = data.replace(/{et_fr}/gi, et_fr_x);
								data = data.replace(/{et_temp}/gi, et_temp_x);
								data = data.replace(/{et_dx_envio}/gi, et_dx_envio_x);
								data = data.replace(/{et_referencia}/gi, et_referencia_x);
								data = data.replace(/{et_nombre_anestesiologo}/gi, et_nombre_anestesiologo_x);
								data = data.replace(/{et_firma_medico_atiende}/gi, et_firma_medico_atiende_x);
								data = data.replace(/{et_logo_suc}/gi, et_logo_suc_x);
								data = data.replace(/{et_logoe}/gi, et_logoe_x);
								data = data.replace(/{et_logoee}/gi, et_logoee_x);
								data = data.replace(/{et_logogm}/gi, et_logogm_x);

								//tinymce.get('input').setContent(data);
								setTimeout(function(){tinymce.get('input').setContent(data);},1300);
								//$('#tCaptura #input').val(data);
								//Checamos si el estudio tiene formatos individuales de quién lo va a interpretar, si es así, entonces puede escoger su machote
								if(datosTe[32]>0){
									$('#tr_machotes').show();
									$("#formato_se").load('usuarios/files-serverside/genera_machotes_i.php?id_u='+$('#id_user').val()+'&id_es='+datosTe[33],function(response,status,xhr){if(status=="success"){
										//$(this).val(dato[22]);
									}});
									$('#formato_se').change(function(){
										var datosFts ={idE:this.value}
										$.post('imagen/estudios/files-serverside/check_formato_estudio.php',datosFts).done(function(data1){
											var data = data1;
											data = data.replace(/{ET_ALERGIAS}/gi, alergiasx);
											data = data.replace(/{ET_EDAD}/gi, edadx1);
											data = data.replace(/{ET_NOMBRE_MEDICO_ATIENDE}/gi, nombre_medicox);
											data = data.replace(/{et_nombre_personal_atiende}/gi, nombre_medico_a);														
											data = data.replace(/{ET_NOMBRE_PACIENTE}/gi, nombre_pacientex);
											data = data.replace(/{ET_SEX}/gi, sexox);
											data = data.replace(/{ET_SV}/gi, svx);
											data = data.replace(/{ET_ABITUS}/gi, abitusx);
											data = data.replace(/{et_adicciones}/gi, adiccionesx);
											data = data.replace(/{et_puntuacion_g}/gi, puntuacion_glax);
											data = data.replace(/{et_pesotalla_g}/gi, peso_tallax);
											data = data.replace(/{et_fechahora}/gi, fecha_horax);
											data = data.replace(/{et_cedulap}/gi, cedula_p_ma);
											data = data.replace(/{et_nombre_procedimiento}/gi, nombre_conceptox);
											data = data.replace(/{et_cedulaesp}/gi, cedula_espe_x);
											data = data.replace(/{et_edad}/gi, edad1_x);
											data = data.replace(/{et_especialidadm}/gi, especialidadm_x);
											data = data.replace(/{et_fecha_dia}/gi, fecha_dia_x);
											data = data.replace(/{et_fecha_mes_numero}/gi, fecha_mes_n_x);
											data = data.replace(/{et_fecha_mes_letra}/gi, fecha_mes_l_x);
											data = data.replace(/{et_fecha_anio}/gi, fecha_anio_x);
											data = data.replace(/{et_fecha_hora}/gi, fecha_hora_x);
											data = data.replace(/{et_nombre_establecimiento}/gi, nombre_establecimiento_x);
											data = data.replace(/{et_nombre_medico_atiende}/gi, nombre_medico_a);
											data = data.replace(/{et_nombre_universidad}/gi, nombre_universidad_x);
											data = data.replace(/{et_nombre_paciente}/gi, nombre_pacientex);
											data = data.replace(/{et_peso_g}/gi, peso_x);
											data = data.replace(/{et_talla_g}/gi, et_talla_g);
											data = data.replace(/{et_sex}/gi, sex_x);
											data = data.replace(/{et_sv}/gi, svx);
											data = data.replace(/{et_tiposan}/gi, tiposan_x);
											data = data.replace(/{et_titulom}/gi, titulom_x);
											data = data.replace(/{et_nombre_medico_refiere}/gi, medico_refiere_x);
											data = data.replace(/{et_t}/gi, et_t_x);
											data = data.replace(/{et_a}/gi, et_a_x);
											data = data.replace(/{et_fc}/gi, et_fc_x);
											data = data.replace(/{et_fr}/gi, et_fr_x);
											data = data.replace(/{et_temp}/gi, et_temp_x);
											data = data.replace(/{et_dx_envio}/gi, et_dx_envio_x);
											data = data.replace(/{et_referencia}/gi, et_referencia_x);
											data = data.replace(/{et_nombre_anestesiologo}/gi, et_nombre_anestesiologo_x);
											data = data.replace(/{et_firma_medico_atiende}/gi, et_firma_medico_atiende_x);
											data = data.replace(/{et_logo_suc}/gi, et_logo_suc_x);
											data = data.replace(/{et_logoe}/gi, et_logoe_x);
											data = data.replace(/{et_logoee}/gi, et_logoee_x);
											data = data.replace(/{et_logogm}/gi, et_logogm_x);

											tinymce.get("input").execCommand('mceSetContent', false, data);
										});
									});
								}else{$('#tr_machotes').hide();}
					});
					//$('#input').val(datos[31]);
				}else{$('#tr_machotes').hide(); setTimeout(function(){tinymce.get('input').setContent(datos[5]); },1300);}
				
				var miExtFU1 = datos[23];
				
				if(datos[24]>0){//Para el membrete encabezado
					xME='sucursales/membretes/files/'+datos[25]+'.'+datos[26]+'?'+Math.round(Math.random()*1000); var membretDME = 'url('+xME+')'; //alert(membretDME);
					$("#para_encabezado").css('background-image',membretDME).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
				}
				if(datos[27]>0){//Para el membrete encabezado
					xMP='sucursales/membretes/files/'+datos[28]+'.'+datos[29]+'?'+Math.round(Math.random()*1000); var membretDMP = 'url('+xMP+')'; //alert(membretDME);
					$("#para_pie").css('background-image',membretDMP).css('background-size','cover').css('margin',0).css('background-repeat','no-repeat').css('background-position','bottom center');
				}
				if(datos[21]==1){//Para la firma
					var datos = {aleatorio:datos[22]}
					$.post('usuarios/files-serverside/datosFirma.php',datos).done(function( data ){ 
						var t = "<img src='usuarios/documentos/files/"+data+"."+miExtFU1+"?"+Math.round(Math.random()*1000)+"' height='90%'>";
						$('#firmaDR').html(t);
					});
				}
			});//cargarImagenesReporte(i);
		}
		
		$('#idEstuVC').val(i); $('.margen_punteado_fonto').css('border-bottom-style','dashed').css('border-bottom-width','1px');
		
		var datoG = { idE:i }
		$.post('imagen/files-serverside/datosDXusg.php', datoG).done(function( dataDX ) {
			var datosDX = dataDX.split('*[+');
		
			var k = 0, videoStream;
		
			$('#titulo_modal').text(datosDX[0]);
			//$('#dialog-procesar').dialog( "option", "title", dTitle ); $('#dialog-procesar').dialog('open');
			navigator.getUserMedia = navigator.getUserMedia ||  
							 navigator.webkitGetUserMedia || 
							 navigator.mozGetUserMedia || 
							 navigator.msGetUserMedia;
							  
			window.URL = window.URL || 
						 window.webkitURL || 
						 window.mozURL || 
						 window.msURL;
			var j = datosDX[1];
		
			document.getElementById('start').addEventListener('click', function() {
				if(!$('#start').hasClass('disabled')){
					var hV=$('#contenedorVideo').height()*0.8,wV=$('#contenedorVideo').width()*0.8;$('#video').css('width',wV,'height',hV);
					navigator.getUserMedia({ video: true }, 
					function(stream) {
						videoStream = stream; // Stream the data
						video.src = window.URL.createObjectURL(stream); video = document.querySelector('video'); video.play();
						$('#start').addClass('disabled'); $('#capture, #stop').removeClass('disabled');
						$('#myModal').on('hidden.bs.modal', function(e){ video.pause(); });
					}, function(e) { console.log(e); });
				}else{}
			}, false);
		
		var button = document.getElementById('capture');
		button.addEventListener('click', function() {
			if(!$('#capture').hasClass('disabled')){
				j++; //alert(j);
				$('#deCanvas').append('<table style="float:left;" width="" border="0" cellspacing="0" cellpadding="3"> <tr> <td align=""><span style="display:block;">Eliminar</span></td> </tr> <tr> <td><canvas id="miFoto'+j+'" width="160" height="120"></canvas></td> </tr> </table>');
			
				var canvas = document.getElementById('miFoto'+j), ctx = canvas.getContext('2d');
				ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
				
				var canvasX = document.getElementById('miFotoX'), ctxX = canvasX.getContext('2d');
				ctxX.drawImage(video, 0, 0, canvasX.width, canvasX.height); //esta va culta en una pestaña que no es visible
				
				var canvas1 = document.getElementById('miFotoX1'), ctx1 = canvas1.getContext('2d');
				ctx1.drawImage(video, 0, 0, canvas1.width, canvas1.height);
				
				var image = new Image(); image.src = canvas1.toDataURL("image/png"); var dataURL1 = canvas1.toDataURL();
				//alert(image);
				$('#imagenesEndo').append('<table style="float:left;" width="" border="0" cellspacing="0" cellpadding="3"> <tr> <td align=""> </td> </tr> <tr> <td><img id="miFoto1'+j+'" alt="Right click to save me!"></td> </tr> </table>');
				document.getElementById('miFoto1'+j).src = dataURL1;
				
				var dataURL1 = canvas1.toDataURL();
				$.ajax({
					type:"POST",url:"imagen/files-serverside/guardarImgNormalU.php",data:{imgBase64:dataURL1,cont:j,id:i}
				}).done(function(o){
				  console.log('saved');
				});
				
				var dataURL = canvasX.toDataURL();
				$.ajax({type:"POST",url:"imagen/files-serverside/guardarImgU.php",data:{imgBase64:dataURL,cont:j,id:i}}).done(function(o){
				  console.log('saved'); cargarImagenesCanvas(i); //cargarImagenesReporte(i);
				});
			}else{}
		}, false);
		
		document.getElementById('stop').addEventListener('click', function() {
			if(!$('#stop').hasClass('disabled')){
				swal({
				  title: "FINALIZAR VIDEO", text: "¿Estás seguro de finalizar el video? Ten en cuenta que ya no podrás tomar imágenes",
				  type: "warning", showCancelButton: true, 
				  confirmButtonColor: "#DD6B55", confirmButtonText: "Finalizar", closeOnConfirm: false, cancelButtonText: "Cancelar"
				},
				function(){
					swal.close();
					var datoI = {idC:i, idU:$('#id_user').val()}
					$.post('imagen/archivos_save_ajax/capturarE.php', datoI).done(function( data ) { if (data == 1){ 
						$('#clickme').click(); $('#start, #capture, #stop').addClass('disabled');
						$('#guardarE,#finalizarE').removeClass('disabled');
						swal({title:"",type:"success",text:"EL VIDEO HA SIDO FINALIZADO",timer:2000,showConfirmButton:false});
						if(typeof videoStream !== "undefined" && videoStream){videoStream.getVideoTracks()[0].stop();}
						location.reload();
					}else{alert(data);} });
				});
			}else{}
		}, false);
				
		if(e>=2){ cargarImagenesCanvas(i); /*cargarImagenesReporte(i);*/ }
		if(e==3){ $('#guardarE, #finalizarE, #dictado').removeClass('hidden'); }
		if(e>=3){
			$('#start, #capture, #stop').remove(); $('#t-interpretacion').removeClass('hidden');
			$('#t-interpretacion-img, #compartirE').removeClass('hidden'); // pestaña INTERPRETACIÓN EN IMAGEN y botón Compartir
			window.setTimeout(function(){$('#st-interpretacion').click();},300);
		}
		if(e==4){
			$('#guardarE, #finalizarE, #dictado').removeClass('hidden');
			var dato = { idE:i, idU:$('#id_user').val() }
			$.post('imagen/files-serverside/datosInterpretarEn.php', dato).done(function( data ) { //alert(data);
				var datos = data.split(';*-');
				window.setTimeout(function(){
					tinymce.init({
						selector:'#tInterpretacion #input',resize:false,height:$('#myModal').height()*0.63,theme: "modern",
						plugins: 
							"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss", table_default_styles: { width: '100%' },
						relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#myModal').width()*0.8,
						toolbar: 
							"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent1 indent1 | link unlink anchor | forecolor backcolor  | print_ preview_ code_ | emoticons_ | table | responsivefilemanager_ | mybuttonVP | mybutton | mybutton1 | mybuttonPACS |",
						insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
						paste_data_images: true, paste_as_text: true, browser_spellcheck: true, 
						force_br_newlines : true, force_p_newlines : false, orced_root_block : '', 
						setup: function(editor){
							editor.addButton( 'mybutton', {
									text: 'INSERTAR IMGS', icon: false,
									onclick:function(){
										var datos = {idVC:i}
										$.post('imagen/files-serverside/insertarIMGsUSG.php',datos).done(function(data){editor.insertContent(data);});
									}
							});
							editor.addButton( 'mybutton1', { text: 'DICTAR', icon: false, onclick:function(){ procesarV(); } });
							editor.addButton( 'mybuttonPACS', {
								text: 'IMGS PACS', icon: false, tooltip: 'Insertar imágenes del estudio del PACS',
								onclick:function(){ insertarImgsPACS(editor, i, idPx1a); }
							});
							editor.addButton( 'mybuttonVP', {
								text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
								onclick:function(){
									var res = tinyMCE.get("input").getContent().replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); //alert(res);
									$('#dpa_imprimir1').html(res).css('background-image','url(imagenes/vista_previa.png)').css('background-size','65%');
									$('#dpa_imprimir1').html(res); $('#dpa_imprimir1').printElement();
								}
							});
						}
					}); tinymce.get("input").setContent(datos[5]);
				},500);
			});
		}
		if(e>=4){ }
		if(e>4){
			preImprimir(i,idPx1a,id_s);
			/*$('#start, #capture, #stop, #guardarE, #finalizarE, #dictado').remove();
			var dato = { idE:i, idU:$('#id_user').val() }
			$.post('imagen/files-serverside/datosInterpretarEn.php', dato).done(function( data ) { //alert(data);
				var datos = data.split(';*-');
				tinyMCE.init({ 
					selector:'#input',readonly:true,resize:false,height:$('#myModal').height()*0.8,
					theme: "modern", menubar: false, toolbar: false
				});
				$('#imprimirE').removeClass('hidden');
				$('#imprimirE').click(function(e){ 
					$('#myModal').modal('hide'); window.setTimeout(function(){preImprimir(i,idPx1a,id_s);},300);
				});
				
				var str = datos[5].replace('src="../../../usuarios/','src="usuarios/');
				var res = str;
				var res = res.replace(/..\/..\/..\/imagen\/img_usg/g,'imagen/img_usg');
				var res = res.replace(/[?]\d{14}/g,'');
				window.setTimeout(function(){ tinymce.get("input").setContent(res);},200);
			});*/
		}
		
		/* Pestaña INTERPRETACIÓN EN IMAGEN: segundo editor completo (INSERTAR IMGS, IMGS PACS, VPI...) con encabezado y pie visibles */
		var img2Iniciado = false;
		$('#st-interpretacion-img').on('shown.bs.tab', function(){
			if(img2Iniciado || tinymce.get('input2')){ return; }
			img2Iniciado = true;
			tinymce.init({
				selector:'#tInterpretacionImg #input2', resize:false, height:$('#myModal').height()*0.40, theme:"modern",
				plugins: 
					"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, code, importcss", table_default_styles: { width: '100%' },
				relative_urls: true, image_advtab: true, menubar: false, plugin_preview_width: $('#myModal').width()*0.8,
				toolbar: 
					"undo redo | insert | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink anchor | forecolor backcolor | table | mybuttonVP | mybutton | mybuttonPACS | mybuttonDatos | mybuttonMb |",
				insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
				paste_data_images: true, paste_as_text: true, browser_spellcheck: true, 
				force_br_newlines : true, force_p_newlines : false, orced_root_block : '', 
				setup: function(editor){
					editor.addButton( 'mybutton', {
						text: 'INSERTAR IMGS', icon: false,
						onclick:function(){
							var datos = {idVC:i}
							$.post('imagen/files-serverside/insertarIMGsUSG.php',datos).done(function(data){editor.insertContent(data);});
						}
					});
					editor.addButton( 'mybuttonDatos', {
						text: 'DATOS PACIENTE', icon: false, tooltip: 'Insertar el cuadro con los datos del paciente',
						onclick:function(){ var e1 = tinymce.get('input'); var b = bloqueDatosImagen(e1 ? e1.getContent() : ''); if(b){ editor.insertContent(b); } }
					});
					editor.addButton( 'mybuttonPACS', {
						text: 'IMGS PACS', icon: false, tooltip: 'Insertar imágenes del estudio del PACS',
						onclick:function(){ insertarImgsPACS(editor, i, idPx1a); }
					});
					editor.addButton( 'mybuttonMb', {
						text: 'ENCABEZADO', icon: false, tooltip: 'Editar encabezado y pie del informe',
						onclick:function(){ editarMembrete(function(){ pintarMembreteEditor(editor, i, idPx1a); }); }
					});
					editor.addButton( 'mybuttonVP', {
						text: 'VPI', icon: false, tooltip: 'Vista previa de impresión',
						onclick:function(){
							imprimirInforme(editor.getContent(), $.extend({}, usgMembreteBase || membreteDefault()));
						}
					});
				},
				// al estar listo: se dibujan encabezado y pie, y se copian los datos del paciente
				init_instance_callback: function(editor){
					pintarMembreteEditor(editor, i, idPx1a);
					var ed1 = tinymce.get('input'), cab = contenidoInicialImagen(ed1 ? ed1.getContent() : '');
					$.post('ultrasonido.php?usg_ajax=1', { accion:'leer', idE:i }).done(function(r){
						r = $.trim(r);
						if(r.indexOf('OK|') === 0 && r.length > 3){ editor.setContent(r.substring(3)); }
						else{
							editor.setContent(cab); cursorAlInicio(editor);
							// si el editor principal aún no cargaba su plantilla, se reintenta
							window.setTimeout(function(){ if(!$.trim(editor.getContent())){ var e1 = tinymce.get('input'); editor.setContent(contenidoInicialImagen(e1 ? e1.getContent() : '')); cursorAlInicio(editor); } }, 2200);
						}
					}).fail(function(){ editor.setContent(cab); cursorAlInicio(editor); });
				}
			});
		});
		/* Botón COMPARTIR de la ficha: manda por WhatsApp el PDF de la pestaña que esté abierta */
		$('#compartirE').click(function(e){
			var enImagen = $('#t-interpretacion-img').hasClass('active') && tinymce.get('input2');
			var ed = tinymce.get(enImagen ? 'input2' : 'input');
			compartirPDFWhatsApp(ed ? ed.getContent() : '', i, idPx1a);
		});
		
		$('#guardarE').click(function(e) {
			guardarImgUSG(i);
			var str = tinyMCE.get('input').getContent(); 
			//var res = str.replace('src="usuarios/documentos/','src="../../../usuarios/documentos/');
			//var res = res.replace(/[?]\d{14}/g,'');
			
			var datos = { idE:i, idU:$('#id_user').val(), dx:str }
			$.post('imagen/files-serverside/guardarEndo.php',datos).done(function( data ) {
				if (data == 1){ $('#clickme').click();
					swal({title:"",type:"success",text:"LOS DATOS SE HAN GUARDADO CORRECTAMENTE",timer:1500,showConfirmButton:false});
				}else{ alert(data); }
			});
        });
		$('#finalizarE').click(function(e){
			swal({
			  title: "FINALIZAR ESTUDIO",
			  text: "¿Estás seguro de finalizar el estudio? No se le podrán realizar más cambios",
			  type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Finalizar", cancelButtonText: "Cancelar", closeOnConfirm: false
			},
			function(){ 
			  guardarImgUSG(i); $('#myModal').modal('hide'); var str = tinyMCE.get('input').getContent(); 
			  //var res = str.replace('src="usuarios/documentos/','src="../../../usuarios/documentos/');
			  //var res = res.replace(/src="imagen/g,'src="../../../imagen'); var res = res.replace(/[?]\d{14}/g,'');

			  var datos = { idE:i, idU:$('#id_user').val(), dx:str }
			  $.post('imagen/files-serverside/finalizarEndo.php',datos).done(function( data ) {
				if (data == 1){
					$('#clickme').click(); $('#guardarE, #finalizarE').remove();
					swal({
					  title:"", text:"EL ESTUDIO SE HA FINALIZADO.",type:"success", showCancelButton:true,confirmButtonColor:"#DD6B55",
					  confirmButtonText: "Imprimir", cancelButtonText: "Cerrar", closeOnConfirm: false
					},
					function(){ swal.close(); window.setTimeout(function(){ window.setTimeout(function(){preImprimir(i,idPx1a,id_s);},300); },400); });
				}else{ alert(data); }
			  });
			});
        });
		
		});//Fin de lo del DX previo
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function(e){
			var he = $('#referencia').height() - 200, wi = $('#referencia').width() * 0.98;
			$('#tamHcanvas').val($('#contenedorCanvas').height());
			tinymce.init({selector:'#input',height:$('#myModal').height()*0.53});
		});
		$('#myModal').on('hidden.bs.modal', function(e){$(".modal-content").remove(); $("#myModal").empty(); });
	}});
}
function preImprimir(x,idPa,id_s){//a =id paciente, b id estudio en vc
	/*var datoP = {idE:x}
	$.post('imagen/archivos_save_ajax/datosPrintMemUSG.php', datoP).done(function(data){ //alert(data);
		if(data!=1){ imprimir(x,idPa,0,id_s); }
		else{
			swal({
			  title: "IMPRIMIR EL ESTUDIO",
			  text: '<table class="table table-condensed"><tr><td align="center" colspan="2">Selecciona el tipo de impresión</td></tr><tr><td align="center"><button id="btn_imp_cm" type="button" class="btn btn-info">Con membrete</button></td><td align="center"><button id="btn_imp_sm" type="button" class="btn btn-info">Sin membrete</button></td></tr></table>',
			  html: true, showCancelButton: true, showConfirmButton: false, cancelButtonText: "Cerrar"
			});
			$('#btn_imp_cm').click(function(e) { imprimir(x,idPa,1,id_s); swal.close(); });
			$('#btn_imp_sm').click(function(e) { imprimir(x,idPa,0,id_s); swal.close(); });
		}
	});*/
	imprimir(x,idPa,0,id_s);
}
function imprimir(x,idPa,y,id_s){//x=id del estudio, y es si se imprimen los encabe
	$("#myModal").load('imagen/htmls/imprimir.php',function(response,status,xhr){ if(status=="success"){
		/*var dato = { idE:x, idP:idPa, idU:$('#id_user').val() }
		$.post('imagen/files-serverside/datosInterpretar.php', dato).done(function( data ){ //alert(data);
			var datos = data.split(';*}-{');
			$.post('imagen/files-serverside/imprimirResulUltraPDF.php?idE='+x+'&idU='+$('#id_user').val()).done(function(data){
			  var pusha={iduL:escape($('#id_user').val()),idVC:x,mems:y,id_s:id_s}
			  $("#impresion_inter").load('imagen/htmls/frame_pdf_usg.php',pusha,function(response,status,xhr){if(status=="success"){}});
			});
		});*/
		$("#myModal").height($("#referencia").height()*0.85);
		var dato = { idE:x, idP:idPa, idU:$('#id_user').val() }
		$.post('imagen/files-serverside/datosInterpretar.php', dato).done(function(data){ var datos = data.split(';*}-{'); //alert(data);
			var res = datos[5].replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); $("#impresion_inter").html(res);
		});

		var cfgEst = null;
		obtenerMembrete(x, idPa).then(function(cfg){ cfgEst = cfg; pintarMembretePreview(cfg); });
		$('#btn_membrete_i').click(function(){ editarMembrete(function(){ obtenerMembrete(x, idPa).then(function(cfg){ cfgEst = cfg; pintarMembretePreview(cfg); }); }); });
		$('#btn_imprimir_i').click(function(e) {
			if($(selImpresionActiva()).data('vacio')){ swal({title:"",type:"error",text:"No hay interpretación para imprimir",timer:2500,showConfirmButton:false}); return; }
			imprimirInforme(htmlImpresionActiva(), cfgEst || membreteDefault());
		});
		$('#btn_compartir_i').click(function(e) { compartirPDFWhatsApp(htmlImpresionActiva(), x, idPa); });
		
		// pestaña INTERPRETACIÓN EN IMAGEN (lo guardado desde la ficha del estudio)
		$.post('ultrasonido.php?usg_ajax=1', { accion:'leer', idE:x }).done(function(r){
			r = $.trim(r);
			if(r.indexOf('OK|') === 0 && $.trim(r.substring(3)) != ''){
				$('#impresion_inter_img').html(r.substring(3).replace(/<p(?=[\s>])/g,'<div').replace(/<\/p>/g,'</div>'));
			}else{
				$('#impresion_inter_img').data('vacio',1).html('<p class="text-muted text-center" style="padding:30px;">Este estudio no tiene INTERPRETACIÓN EN IMAGEN guardada.<br>Se captura y se guarda desde la ficha del estudio (pestaña INTERPRETACIÓN EN IMAGEN, botón Guardar).</p>');
			}
		}).fail(function(xhr){
			$('#impresion_inter_img').data('vacio',1).html('<p class="text-danger" style="padding:30px;">No se pudo leer la interpretación en imagen (HTTP '+xhr.status+' en ultrasonido.php).</p>');
		});
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { if(cfgEst){ pintarMembretePreview(cfgEst); } });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}}); //alert(idPa);
}//fin imprimir
function p_imagenes(x,idPa,y,id_s){//x=id del estudio, y es si se imprimen los encabe
	$("#myModal").load('imagen/htmls/imprimir.php',function(response,status,xhr){ if(status=="success"){
		$('#tabs_imp_nav, #btn_membrete_i').addClass('hidden'); $("#myModal").height($("#referencia").height()*0.85);
		var dato = { idVC:x, idP:idPa, idU:$('#id_user').val(), id_s:id_s }
		$.post('imagen/files-serverside/datos_imprimir_imgs.php', dato).done(function(data){//alert(data);
			var res = data.replace(/<p/g, "<div"); res = res.replace(/<\/p>/g, "</div>"); $("#impresion_inter").html(res);
		});

		$('#btn_imprimir_i').click(function(e) { $('#impresion_inter').printElement(); });
		$('#btn_compartir_i').click(function(e) { compartirPDFWhatsApp($('#impresion_inter').html(), x, idPa, true); });
		
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function (e) { });
		$('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
	}});
}//fin imprimir imágenes
function cargarImagenesCanvas(i){
	$("#deCanvas").load("imagen/img_usg/procesa.php?action=listFotos1&carpeta="+i,function(response,status,xhr){ }); 
	window.setTimeout(function(){ $('#divCanvas').css('height',$('#tamHcanvas').val()).css('overflow','scroll');},500);
}
function cargarImagenesReporte(i){
	$("#imagenesEndo").load("imagen/img_usg/procesa.php?action=listFotos2&carpeta="+i,function(response,status,xhr){ });
}

/* ============================================================
   COMPARTIR POR WHATSAPP EN PDF
   1) genera el PDF en el navegador (html2pdf.js)
   2) lo sube a ultrasonido.php?usg_ajax=1&accion=pdf, que lo guarda y devuelve su enlace
   3) abre WhatsApp (wa.me) con el mensaje y el enlace del PDF
   Se usa en la ficha (botón Compartir) y en la ventana de impresión.
   ============================================================ */
/* ============================================================
   ENCABEZADO Y PIE DEL INFORME (impresión y PDF)
   - Los datos (título, médico, cédula, horario, dirección, teléfono, correo, logo) son editables
     con el botón ENCABEZADO / PIE y se guardan en imagen/membrete_usg.json.
   - Si se activa "tomar el médico del estudio", el nombre/cédula/especialidad se jalan del estudio
     (consultas/files-serverside/cat_texts.php, los mismos datos que usa la plantilla) cuando los trae.
   - El logo se sube desde el mismo cuadro (se guarda como imagen/logo_informe.png|jpg|gif).
   ============================================================ */
var usgMembreteBase = null;
function escH(v){ return String(v==null?'':v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
function membreteDefault(){
	return { titulo:'Informe Imagenología', medico:'Dra. Ma. Victoria Aguilera Navarro',
		linea:'Médico Radiólogo  Ced. de Esp. 3175254 BUAP', certificacion:'Certificado Consejo Mexicano Radiología e Imagen',
		horario:'Asiste de 10 a 15 hrs.', gracias:'Agradecemos su preferencia por nuestro servicio',
		direccion:'Manuel Mazarik No.8 Col. Progreso Axochiapan Mor.', telefono:'01 (769) 351 1945 al 46 Ó 735 183 02 12',
		correo:'imagencsa13@gmail.com', logo:'', auto:0, logoV:'' };
}
function cargarMembreteBase(){
	return new Promise(function(resolve){
		if(usgMembreteBase){ resolve(usgMembreteBase); return; }
		$.post('ultrasonido.php?usg_ajax=1&accion=membrete_leer').done(function(r){
			r = $.trim(r); var cfg = membreteDefault();
			if(r.indexOf('OK|') === 0 && r.length > 3){ try{ cfg = $.extend(cfg, JSON.parse(r.substring(3))); }catch(ex){} }
			cfg.logoV = new Date().getTime(); usgMembreteBase = cfg; resolve(cfg);
		}).fail(function(){ usgMembreteBase = membreteDefault(); resolve(usgMembreteBase); });
	});
}
function obtenerMembrete(idVC, idPa){ // datos guardados + (si está activado) el médico que trae el estudio
	return cargarMembreteBase().then(function(base){
		var cfg = $.extend({}, base);
		if(!base.auto || !idPa || !idVC){ return cfg; }
		return new Promise(function(resolve){
			$.post('consultas/files-serverside/cat_texts.php', { idP:idPa, idU:$('#id_user').val(), id_vc:idVC }).done(function(dataT){
				var d = String(dataT).split('-{]'), g = function(k){ return $.trim(d[k] || ''); };
				var nombre = g(11), titulo = g(27), esp = g(16), ced = g(14), uni = g(22);
				if(nombre){ cfg.medico = $.trim(titulo+' '+nombre); }
				if(esp && ced){ cfg.linea = 'Médico '+esp+'  Ced. de Esp. '+ced+(uni ? ' '+uni : ''); }
				resolve(cfg);
			}).fail(function(){ resolve(cfg); });
		});
	});
}
function membreteHTML(c){ // usa --m como 1 mm de la hoja (hoja carta: 215.9 mm de ancho)
	var f = 'font-family:Arial,Helvetica,sans-serif;-webkit-print-color-adjust:exact;print-color-adjust:exact;box-sizing:border-box;';
	var hdr = '<div style="position:relative;width:100%;height:calc(38 * var(--m));background:#f6f6f6;overflow:hidden;'+f+'">'
		+ (c.logo ? '<img src="'+escH(c.logo)+(c.logoV ? '?v='+c.logoV : '')+'" style="position:absolute;left:calc(8 * var(--m));top:calc(4 * var(--m));height:calc(30 * var(--m));max-width:calc(60 * var(--m));">' : '')
		+ '<div style="position:absolute;top:calc(3 * var(--m));left:calc(78 * var(--m));right:calc(-8 * var(--m));height:calc(3.6 * var(--m));background:#2e2a6e;border-radius:calc(3 * var(--m)) 0 0 calc(3 * var(--m));transform:skewX(-30deg);"></div>'
		+ '<div style="position:absolute;top:calc(8 * var(--m));left:calc(70 * var(--m));width:calc(9 * var(--m));height:calc(5 * var(--m));background:#7ab51d;border-radius:0 100% 0 100%;"></div>'
		+ '<div style="position:absolute;top:calc(8 * var(--m));left:calc(92 * var(--m));right:calc(-8 * var(--m));height:calc(3 * var(--m));background:#7ab51d;border-radius:calc(3 * var(--m)) 0 0 calc(3 * var(--m));transform:skewX(-30deg);"></div>'
		+ '<div style="position:absolute;right:calc(8 * var(--m));bottom:calc(3 * var(--m));width:calc(112 * var(--m));text-align:center;color:#2e2a6e;">'
		+ '<div style="font-size:calc(7.76 * var(--m));line-height:1.1;margin:0 0 calc(2 * var(--m));font-weight:500;">'+escH(c.titulo)+'</div>'
		+ $.map([c.medico, c.linea, c.certificacion, c.horario], function(t){ return t ? '<p style="margin:0;font-size:calc(3.18 * var(--m));line-height:1.35;">'+escH(t)+'</p>' : null; }).join('')
		+ '</div></div>';
	var ftr = '<div style="position:relative;width:100%;height:calc(30 * var(--m));background:#f6f6f6;padding:calc(4 * var(--m)) calc(8 * var(--m)) calc(3 * var(--m));display:flex;flex-direction:column;justify-content:space-between;color:#2e2a6e;'+f+'">'
		+ '<div style="display:flex;align-items:center;">'
		+ '<div style="display:flex;align-items:flex-end;margin-right:calc(4 * var(--m));"><div style="width:calc(9 * var(--m));height:calc(10 * var(--m));background:#7ab51d;border-radius:0 100% 0 100%;margin-right:calc(1 * var(--m));"></div><div style="width:calc(4.5 * var(--m));height:calc(7 * var(--m));background:#2e2a6e;border-radius:0 100% 0 100%;"></div></div>'
		+ '<div style="flex:1;text-align:center;font-size:calc(5.29 * var(--m));">'+escH(c.gracias)+'</div></div>'
		+ '<div style="height:calc(4 * var(--m));background:#2e2a6e;border-radius:calc(2 * var(--m));"></div>'
		+ '<div style="display:flex;justify-content:space-between;font-size:calc(2.65 * var(--m));"><span>&#8962; '+escH(c.direccion)+'</span><span>&#9990;&#xFE0E; '+escH(c.telefono)+'</span><span>&#9993;&#xFE0E; '+escH(c.correo)+'</span></div></div>';
	return { hdr:hdr, ftr:ftr };
}
function pintarMembretePreview(cfg){ // vista previa dentro de la ventana de impresión
	var mb = membreteHTML(cfg), w = $('#impPaneInter > .modal-body').width() || 800, m = (w/215.9).toFixed(3);
	$('.usg-mb-h').html('<div style="--m:'+m+'px;">'+mb.hdr+'</div>');
	$('.usg-mb-f').html('<div style="--m:'+m+'px;">'+mb.ftr+'</div>');
}
function pintarMembreteEditor(editor, idVC, idPa){ // encabezado arriba y pie abajo del editor (solo en pantalla, no se guardan)
	var cont = $(editor.getContainer());
	obtenerMembrete(idVC, idPa).then(function(cfg){
		var mb = membreteHTML(cfg);
		var poner = function(){
			if(!editor.getContainer()){ return; }
			var m = (cont.outerWidth() / 215.9).toFixed(3);   // 1 mm de la hoja, en px
			cont.prev('.usg-ed-h').remove(); cont.next('.usg-ed-f').remove();
			cont.before('<div class="usg-ed-h" style="--m:'+m+'px; overflow:hidden; border:1px solid #ddd; border-bottom:0;">'+mb.hdr+'</div>');
			cont.after('<div class="usg-ed-f" style="--m:'+m+'px; overflow:hidden; border:1px solid #ddd; border-top:0;">'+mb.ftr+'</div>');
		};
		poner();
		$(window).off('resize.usgEd').on('resize.usgEd', poner);
	});
}
function editarMembrete(alGuardar){
	cargarMembreteBase().then(function(cfg){
		$('#modalMembrete').remove();
		var campos = [['titulo','Título'],['medico','Médico (nombre)'],['linea','Especialidad y cédula'],['certificacion','Certificación'],['horario','Horario'],['gracias','Mensaje del pie'],['direccion','Dirección'],['telefono','Teléfono'],['correo','Correo']];
		var h = '<div class="modal fade" id="modalMembrete" tabindex="-1" role="dialog" data-backdrop="false" style="z-index:1090;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title"><strong>ENCABEZADO Y PIE DEL INFORME</strong></h4></div><div class="modal-body" style="max-height:70vh; overflow:auto;">';
		$.each(campos, function(k,c){ h += '<div class="form-group"><label>'+c[1]+'</label><input type="text" class="form-control input-sm" id="mb_'+c[0]+'" value="'+escH(cfg[c[0]])+'"></div>'; });
		h += '<div class="form-group"><label>Logo (PNG, JPG o GIF)</label><input type="file" id="mb_logo_file" accept="image/*"><p class="help-block">'+(cfg.logo ? 'Logo actual: '+escH(cfg.logo) : 'Todavía no hay logo cargado.')+'</p></div>';
		h += '<div class="checkbox"><label><input type="checkbox" id="mb_auto"'+(cfg.auto ? ' checked' : '')+'> Tomar nombre, cédula y especialidad del médico del estudio cuando el estudio los traiga (si no los trae se usan los de arriba)</label></div>';
		h += '</div><div class="modal-footer"><button type="button" class="btn btn-primary btn-sm" id="mb_guardar">GUARDAR</button> <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">CANCELAR</button></div></div></div></div>';
		$('body').append(h);
		$('#mb_guardar').click(function(){
			var o = {}; $.each(campos, function(k,c){ o[c[0]] = $.trim($('#mb_'+c[0]).val()); });
			o.auto = $('#mb_auto').is(':checked') ? 1 : 0; o.logo = cfg.logo || '';
			var fd = new FormData(); fd.append('cfg', JSON.stringify(o));
			var f = $('#mb_logo_file')[0].files[0]; if(f){ fd.append('logo', f); }
			$.ajax({ url:'ultrasonido.php?usg_ajax=1&accion=membrete_guardar', type:'POST', data:fd, processData:false, contentType:false }).done(function(r){
				r = $.trim(r);
				if(r.indexOf('OK|') !== 0){ swal({title:"No se guardó el encabezado y pie", type:"error", text:r.replace(/^ERROR:\s*/,'')}); return; }
				try{ usgMembreteBase = $.extend(membreteDefault(), JSON.parse(r.substring(3))); usgMembreteBase.logoV = new Date().getTime(); }catch(ex){ usgMembreteBase = null; }
				$('#modalMembrete').modal('hide');
				if(alGuardar){ alGuardar(); }
			}).fail(function(xhr){ swal({title:"No se guardó el encabezado y pie", type:"error", text:'Error HTTP '+xhr.status+' en ultrasonido.php'}); });
		});
		$('#modalMembrete').on('hidden.bs.modal', function(){ $(this).remove(); }).modal('show');
	});
}
function limpiarCuerpoInforme(html){ // rutas relativas, <p> a <div> y quita el espacio en blanco del inicio (lo reemplaza el encabezado)
	html = (html||'').replace(/src="(?:\.\.\/)+/g,'src="').replace(/<p(?=[\s>])/g,'<div').replace(/<\/p>/g,'</div>');
	return html.replace(/^(?:\s|&nbsp;|<br\s*\/?>|<(?:div|p)[^>]*>(?:\s|&nbsp;|<br\s*\/?>)*<\/(?:div|p)>)+/i,'');
}
function imprimirInforme(bodyHtml, cfg){ // ventana de impresión con encabezado y pie fijos en cada hoja
	var mb = membreteHTML(cfg), base = location.href.replace(/[?#].*$/,'').replace(/[^\/]*$/,'');
	var w = window.open('', '_blank');
	if(!w){ swal({title:"",type:"error",text:"El navegador bloqueó la ventana de impresión. Permite las ventanas emergentes para este sitio."}); return; }
	var css = '@page{margin:0}*{box-sizing:border-box;-webkit-print-color-adjust:exact;print-color-adjust:exact}'
		+ 'html,body{margin:0;background:#fff;font-family:Arial,Helvetica,sans-serif}'
		+ ':root{--m:calc(100vw / 215.9)}@media (orientation:landscape){:root{--m:calc(100vw / 279.4)}}'
		+ '.hdr{position:fixed;top:0;left:0;right:0}.ftr{position:fixed;bottom:0;left:0;right:0}'
		+ 'table.pg{width:100%;border-collapse:collapse}.sp-h{height:calc(38 * var(--m))}.sp-f{height:calc(30 * var(--m))}'
		+ '.cuerpo{padding:calc(3 * var(--m)) calc(8 * var(--m));font-size:calc(3.44 * var(--m));line-height:1.35;color:#000}.cuerpo img{max-width:100%}';
	w.document.open();
	w.document.write('<html><head><meta charset="utf-8"><title>Informe de ultrasonido</title><base href="'+base+'"><style>'+css+'</style></head><body>'
		+ '<div class="hdr">'+mb.hdr+'</div><div class="ftr">'+mb.ftr+'</div>'
		+ '<table class="pg"><thead><tr><td><div class="sp-h"></div></td></tr></thead><tfoot><tr><td><div class="sp-f"></div></td></tr></tfoot>'
		+ '<tbody><tr><td><div class="cuerpo">'+limpiarCuerpoInforme(bodyHtml)+'</div></td></tr></tbody></table></body></html>');
	w.document.close();
	var imprimirYa = function(){ try{ w.focus(); w.print(); }catch(ex){} };
	var imgs = w.document.images, pend = 0;
	for(var k=0; k<imgs.length; k++){ if(!imgs[k].complete){ pend++; imgs[k].onload = imgs[k].onerror = function(){ pend--; if(pend == 0){ imprimirYa(); } }; } }
	if(pend == 0){ w.setTimeout(imprimirYa, 300); }
}
function canvasDeBloque(htmlBloque){ // dibuja el encabezado o el pie en un canvas (1 mm = --m)
	var el = document.createElement('div');
	el.style.cssText = '--m:1mm; width:215.9mm; background:#f6f6f6;';
	el.innerHTML = htmlBloque;
	return new Promise(function(res, rej){
		html2pdf().set({ margin:0, html2canvas:{ scale:2, useCORS:true, backgroundColor:'#ffffff', logging:false }, jsPDF:{ unit:'mm', format:'letter', orientation:'portrait' } })
			.from(el).toCanvas().get('canvas').then(res, rej);
	});
}
function pdfConMembrete(html, cfg){ // PDF carta con encabezado y pie en cada hoja
	var mb = membreteHTML(cfg), W = 215.9, H = 279.4, HH = 38, FF = 30, LR = 8;
	var body = document.createElement('div');
	body.style.cssText = 'width:'+(W-2*LR)+'mm; background:#fff; color:#000; font-family:Arial,Helvetica,sans-serif; font-size:13px; line-height:1.35;';
	body.innerHTML = limpiarCuerpoInforme(html);
	$(body).find('img').css('max-width','100%');
	return Promise.all([canvasDeBloque(mb.hdr), canvasDeBloque(mb.ftr)]).then(function(cv){
		var hC = cv[0], fC = cv[1];
		return new Promise(function(resolve, reject){
			html2pdf().set({
				margin: [HH+3, LR, FF+3, LR], image:{ type:'jpeg', quality:0.92 },
				html2canvas:{ scale:1.6, useCORS:true, backgroundColor:'#ffffff', logging:false },
				jsPDF:{ unit:'mm', format:'letter', orientation:'portrait' },
				pagebreak:{ mode:['css','legacy'], avoid:['img','table','tr'] }
			}).from(body).toPdf().get('pdf').then(function(pdf){
				var n = pdf.internal.getNumberOfPages(), hi = hC.toDataURL('image/jpeg', 0.92), fi = fC.toDataURL('image/jpeg', 0.92);
				var hh = W*hC.height/hC.width, fh = W*fC.height/fC.width;
				for(var pg=1; pg<=n; pg++){ pdf.setPage(pg); pdf.addImage(hi,'JPEG',0,0,W,hh); pdf.addImage(fi,'JPEG',0,H-fh,W,fh); }
			}).outputPdf('blob').then(resolve, reject);
		});
	});
}
function selImpresionActiva(){ return $('#impPaneImg').hasClass('active') ? '#impresion_inter_img' : '#impresion_inter'; }
function htmlImpresionActiva(){ var $e = $(selImpresionActiva()); return $e.data('vacio') ? '' : $e.html(); }
function guardarImgUSG(idVC, cb){
	var ed = tinymce.get('input2');
	if(!ed){ if(cb){ cb(true); } return; }   // la pestaña nunca se abrió: no se toca lo guardado
	$.post('ultrasonido.php?usg_ajax=1', { accion:'guardar', idE:idVC, idU:$('#id_user').val(), dx:ed.getContent() }).done(function(r){
		r = $.trim(r); var ok = (r.indexOf('OK|') === 0);
		if(!ok){ swal({title:"No se guardó la INTERPRETACIÓN EN IMAGEN", type:"error", text:r.replace(/^ERROR:\s*/,'')}); }
		if(cb){ cb(ok); }
	}).fail(function(xhr){ swal({title:"No se guardó la INTERPRETACIÓN EN IMAGEN", type:"error", text:'Error HTTP '+xhr.status+' en ultrasonido.php'}); });
}
function bloqueDatosImagen(html){ // cuadro "Nombre del paciente / Fecha / Fecha de nacimiento / Sexo / Médico" con los datos que trae la interpretación
	if(!$.trim(html||'')){ return ''; }
	var txt = $('<div>').html((html||'').replace(/<br\s*\/?>|<\/(?:p|div|tr|h[1-6]|li)>/gi,'$&\n')).text().replace(/\u00a0/g,' ');
	var val = function(re){ var m = re.exec(txt); return m ? $.trim(m[1]).replace(/[\s.]+$/,'') : ''; };
	var nombre = val(/PACIENTE\s*:\s*(.+?)\s+EDAD\s*:/i) || val(/PACIENTE\s*:\s*(.+)/i);
	var fnac   = val(/FECHA\s+DE\s+NACIMIENTO\s*:\s*(.+)/i);
	var medico = val(/M[ÉE]DICO\s*:\s*(.+)/i);
	var fecha  = val(/F\s*E\s*C\s*H\s*A\s*:\s*([0-9]{1,2}[\/\-][0-9]{1,2}[\/\-][0-9]{2,4})/i);
	var sm = /SEXO\s*:\s*([A-ZÁÉÍÓÚÑ]+)/i.exec($('#titulo_modal').text()), sexo = sm ? sm[1] : '';
	if(!nombre && !fnac && !medico && !fecha){ return ''; }
	var fila = function(et, v){ return '<tr><td style="text-align:right; white-space:nowrap; padding:2px 8px 2px 0;">'+et+':</td><td style="border-bottom:1px solid #777; padding:2px 4px; min-width:200px;">'+escH(v)+'</td></tr>'; };
	return '<table style="width:55%; margin-left:auto; border-collapse:collapse; font-family:\'Courier New\',monospace; font-size:13px;"><tbody>'
		+ fila('Nombre del paciente', nombre) + fila('Fecha', fecha) + fila('Fecha de nacimiento', fnac) + fila('Sexo', sexo) + fila('Médico', medico)
		+ '</tbody></table>';
}
function contenidoInicialImagen(html){ // zona vacía arriba (para las imágenes) y los datos del paciente abajo
	var b = bloqueDatosImagen(html);
	return b ? '<div><br></div><div><br></div>'+b : '';
}
function cursorAlInicio(editor){ try{ var b = editor.getBody(); if(b.firstChild){ editor.selection.setCursorLocation(b.firstChild, 0); } }catch(ex){} }
function encabezadoInterpretacion(html){
	// Devuelve solo los datos del paciente: desde el inicio hasta la línea "F E C H A: dd/mm/aaaa"
	html = html || '';
	var m = /F(?:\s|&nbsp;)*E(?:\s|&nbsp;)*C(?:\s|&nbsp;)*H(?:\s|&nbsp;)*A(?:\s|&nbsp;)*:/i.exec(html);
	if(m){
		var ini = m.index + m[0].length, resto = html.substring(ini);
		var fin = /<br\s*\/?>|<\/p>|<\/div>/i.exec(resto);
		return html.substring(0, ini + (fin ? fin.index + fin[0].length : resto.length));
	}
	return html.split(/<br\s*\/?>/i).slice(0,6).join('<br>'); // sin línea de fecha: primeras líneas
}
function htmlAPdfBlob(html){
	var h = (html||'').replace(/src="(?:\.\.\/)+/g,'src="').replace(/<p(?=[\s>])/g,'<div').replace(/<\/p>/g,'</div>');
	var el = document.createElement('div');
	el.style.cssText = 'width:700px; background:#fff; color:#000; font-family:Arial,Helvetica,sans-serif; font-size:13px; line-height:1.35;';
	el.innerHTML = h;
	$(el).find('img').css('max-width','100%');
	return new Promise(function(resolve, reject){
		html2pdf().set({
			margin: [10,10,12,10], image: { type:'jpeg', quality:0.92 },
			html2canvas: { scale:1.6, useCORS:true, backgroundColor:'#ffffff', logging:false },
			jsPDF: { unit:'mm', format:'a4', orientation:'portrait' },
			pagebreak: { mode:['css','legacy'], avoid:['img','table','tr'] }
		}).from(el).outputPdf('blob').then(resolve, reject);
	});
}
function compartirPDFWhatsApp(html, idVC, idPa, sinMembrete){
	if(!$.trim($('<div>').html(html||'').text()) && !/<img/i.test(html||'')){
		swal({title:"",type:"error",text:"No hay interpretación para compartir",timer:2500,showConfirmButton:false}); return;
	}
	if(typeof html2pdf === 'undefined'){
		swal({title:"",type:"error",text:"No se cargó la librería html2pdf (revisa funciones/js/html2pdf.bundle.min.js)"}); return;
	}
	var ultimo = ''; try{ ultimo = localStorage.getItem('usgWaTel') || ''; }catch(ex){}
	swal({
		title: "COMPARTIR PDF POR WHATSAPP", text: "Número de WhatsApp (10 dígitos o con lada):",
		type: "input", inputValue: ultimo, showCancelButton: true,
		confirmButtonText: "Enviar", cancelButtonText: "Cancelar", closeOnConfirm: false
	}, function(tel){
		if(tel === false){ return; }
		tel = (tel||'').replace(/\D/g,'');
		if(tel.length == 10){ tel = '52' + tel; }   // México por defecto
		if(tel.length < 11){ swal.showInputError("Ingresa un número de WhatsApp válido"); return false; }
		try{ localStorage.setItem('usgWaTel', tel.replace(/^52/,'')); }catch(ex){}
		
		// se abre la pestaña ahora (con el clic) para que el navegador no la bloquee; se llena cuando el PDF esté listo
		var w = window.open('about:blank','_blank');
		if(w){ try{ w.document.write('<p style="font-family:Arial">Generando PDF del estudio...</p>'); }catch(ex){} }
		window.setTimeout(function(){ swal({title:"GENERANDO PDF", text:"Un momento por favor...", showConfirmButton:false}); }, 100);
		
		var pdfBlob = null;
		(sinMembrete ? htmlAPdfBlob(html) : obtenerMembrete(idVC, idPa).then(function(cfgM){ return pdfConMembrete(html, cfgM); })).then(function(blob){
			pdfBlob = blob; var fd = new FormData();
			fd.append('pdf', blob, 'estudio.pdf'); fd.append('idVC', idVC); fd.append('idU', $('#id_user').val());
			return $.ajax({ url:'ultrasonido.php?usg_ajax=1&accion=pdf', type:'POST', data:fd, processData:false, contentType:false });
		}).then(function(resp){
			resp = $.trim(resp);
			if(resp.indexOf('OK|') !== 0){ throw new Error(resp.replace(/^ERROR:\s*/,'')); }
			var enlace = resp.substring(3);
			var msg = 'Hola. Te comparto el resultado de tu ultrasonido en PDF:\n\n' + enlace;
			var wa = 'https://wa.me/' + tel + '?text=' + encodeURIComponent(msg);
			swal.close();
			if(w){ w.location.href = wa; } else { window.open(wa, '_blank'); }
		}).catch(function(err){
			if(w){ try{ w.close(); }catch(ex){} }
			var m;
			if(err && err.status === 404){ m = 'No se encontró ultrasonido.php en el servidor (error 404). Revisa que la versión nueva esté en la carpeta de la aplicación.'; }
			else if(err && err.status){ m = 'Error HTTP '+err.status+' al subir el PDF. '+$('<div>').html(err.responseText||'').text().substring(0,200)+' (revisa upload_max_filesize y post_max_size en php.ini)'; }
			else{ m = (err && err.message) ? err.message : String(err); }
			if(pdfBlob){ // el PDF sí se generó: se descarga para poder adjuntarlo a mano en WhatsApp
				try{ var aD = document.createElement('a'); aD.href = URL.createObjectURL(pdfBlob); aD.download = 'Ultrasonido_'+idVC+'.pdf'; document.body.appendChild(aD); aD.click(); document.body.removeChild(aD); m += '\n\nEl PDF se descargó en tu equipo; puedes adjuntarlo manualmente en WhatsApp.'; }catch(ex){}
			}
			window.setTimeout(function(){ swal({title:"No se pudo compartir el PDF", type:"error", text:m}); }, 200);
		});
	});
}

/* ============================================================
   IMÁGENES DEL PACS -> DOCUMENTO DE INTERPRETACIÓN
   Botón "IMGS PACS" del editor. Abre un diálogo para elegir
   cuántas imágenes por fila, formato, número de serie y máximo;
   recuerda la última selección (localStorage).
   Endpoint: imagen/files-serverside/imagenesPacsUSG.php
   ============================================================ */
function insertarImgsPACS(editor, idVC, idPx){
	var pref = { cols:3, fmt:'jpg', serie:1, max:12, alto:'', solo:'' };
	try{ var g = JSON.parse(localStorage.getItem('usgPacsOpc')); if(g){ pref = $.extend(pref, g); } }catch(ex){}
	var nums = $.map([1,2,3,4,5,6], function(v){ return { text:String(v), value:String(v) }; });
	
	editor.windowManager.open({
		title: 'Imágenes del PACS', minWidth: 480,
		body: [
			{ type:'listbox', name:'cols', label:'Imágenes por fila', values:nums, value:String(pref.cols) },
			{ type:'listbox', name:'fmt', label:'Formato', values:[{text:'JPG',value:'jpg'},{text:'PNG',value:'png'}], value:pref.fmt },
			{ type:'textbox', name:'max', label:'Máximo de imágenes (1-100)', value:String(pref.max) },
			{ type:'textbox', name:'alto', label:'Alto máx. por imagen en px (vacío = automático)', value:String(pref.alto) },
			{ type:'textbox', name:'solo', label:'Solo la serie número (vacío = todas)', value:String(pref.solo) },
			{ type:'checkbox', name:'serie', label:'Mostrar número de serie e imagen', checked:(pref.serie==1) }
		],
		onsubmit: function(e){
			var d = e.data;
			var opc = {
				cols:  Math.max(1, Math.min(6, parseInt(d.cols) || 3)),
				fmt:   (d.fmt == 'png') ? 'png' : 'jpg',
				max:   Math.max(1, Math.min(100, parseInt(d.max) || 12)),
				alto:  parseInt(d.alto) || '',
				solo:  parseInt(d.solo) || '',
				serie: d.serie ? 1 : 0
			};
			try{ localStorage.setItem('usgPacsOpc', JSON.stringify(opc)); }catch(ex){}
			window.setTimeout(function(){ traerImgsPACS(editor, idVC, idPx, opc); }, 200);
		}
	});
}
function traerImgsPACS(editor, idVC, idPx, opc){
	editor.setProgressState(true);
	$.post('imagen/files-serverside/datosInterpretar.php',
		{ idE:idVC, idP:idPx, idU:$('#id_user').val(), h:location.hostname }
	).done(function(d){
		var dataE = d.split(';*}-{');
		console.log('datosInterpretar:', dataE);
		// UIDs posibles (como en est() de imagen.php) y referencias posibles; el servidor prueba cada una
		var uids = $.grep([dataE[35], dataE[16], dataE[34]], function(v){ return $.trim(v||'') != ''; }).join('|');
		var refs = $.grep([dataE[12], dataE[34], dataE[1]],  function(v){ return $.trim(v||'') != ''; }).join('|');
		if(uids == '' && refs == ''){
			editor.setProgressState(false);
			swal({title:"",type:"error",text:"El estudio no tiene ID de PACS ni referencia",timer:2500,showConfirmButton:false});
			return;
		}
		$.post('imagen/files-serverside/imagenesPacsUSG.php',
			{ idVC:idVC, uids:uids, refs:refs, fmt:opc.fmt, cols:opc.cols, serie:opc.serie, max:opc.max, alto:opc.alto, solo:opc.solo }
		).done(function(html){
			editor.setProgressState(false);
			console.log('imagenesPacsUSG:', html);
			html = $.trim(html);
			if(html.indexOf('ERROR') === 0){
				swal({title:"No se pudieron traer las imágenes",type:"error",text:html.replace(/^ERROR:\s*/,'')});
			}else if(html == ''){
				swal({title:"",type:"error",text:"El servidor no devolvió contenido (revisa el log de PHP)",timer:3000,showConfirmButton:false});
			}else{ editor.insertContent(html); }
		}).fail(function(xhr){ editor.setProgressState(false); alert('Error HTTP '+xhr.status+' en imagenesPacsUSG.php\n'+$('<div>').html(xhr.responseText||'').text().substring(0,400)); });
	}).fail(function(){ editor.setProgressState(false); alert('Error al obtener los datos del estudio'); });
}

/* ============================================================
   COLUMNA ID-PACS (misma funcionalidad que imagen.php)
   noest(): asignar/reasignar el estudio del PACS a este estudio
   est():   ficha del estudio en el PACS (visores, enlace, WhatsApp)
   ============================================================ */
/* Garantiza que exista el contenedor del modal (por si el footer de esta pantalla no lo trae) */
function asegurarModal(id){
	if(!$('#'+id).length){
		$('body').append('<div class="modal inmodal fade" id="'+id+'" tabindex="-1" role="dialog" aria-hidden="true"></div>');
	}
}
function noest(idVC,nombreE,nombreP,ref,fecha, idPacs){
	asegurarModal('myModal1');
	$("#myModal1").load('imagen/htmls/asignar_pacs.php', function(response,status,xhr){if(status == "success"){
		$('#estudioEpacs').text(nombreE); $('#pacienteEpacs').text(nombreP); $('#referenciaEpacs').text(ref);
		$('#fechaEst').val(fecha); $('#idEstVC').val(idVC); $('#idPacsVC').val(idPacs);
		
		var tam = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height()-400;
		var oTable = $('#dataTablePc').DataTable({
			serverSide: true,"sScrollY": tam, ordering: false, searching: true, scrollCollapse: false, "scrollX": true,
			"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, scroller: false, responsive: true,
			"aoColumns": [ {"bVisible":true}, {"bVisible":true },{ "bVisible": true }, {"bVisible":true} ],
			"sDom": 'rtSp', 
			deferRender: true, select: { style: 'single' }, "processing": false, 
			"sAjaxSource": "imagen/datatable-serverside/nopacs.php",
			"fnServerParams": function (aoData, fnCallback) { },
			"oLanguage": {
				"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
				"sInfo": "ESTUDIOS FILTRADOS: _END_",
				"sInfoEmpty": "NINGÚN ESTUDIO FILTRADO.", "sInfoFiltered": " TOTAL DE ESTUDIOS: _MAX_", "sSearch": "",
				"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
			},"iDisplayLength": 100, paging: false,
		}); $('#clickmePc').click(function(e) { oTable.draw(); });
		//para los fintros individuales por campo de texto
		oTable.columns().every( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) { that .search( this.value ) .draw(); }
			} );
		} );
		//fin filtros individuales por campo de texto
		oTable.on( 'select', function(e, dt, type, indexes){
			$('#btn_asignar_ep').removeClass('disabled');
			var rowData = oTable.rows( indexes ).data().toArray(); $('#pkPacs').val(rowData[0][7]);
		}).on( 'deselect', function ( e, dt, type, indexes ){ $('#btn_asignar_ep').addClass('disabled'); $('#pkPacs').val(''); });
		
		$('#btn_asignar_ep').click(function(e) {
			if($('#pkPacs').val()!=''){
				var datosAP = { pkPacs:$('#pkPacs').val(), idPacsVC:$('#idPacsVC').val()}
				$.post('imagen/files-serverside/asignarPacs.php',datosAP).done(function( data ) { 
					if (data==1){
						$('#myModal1').modal('hide'); $('#clickme').click();
						swal({title:"",type:"success",text:"¡La asignación se realizó correctamente!",timer:2500,showConfirmButton:false});
					} else{if (data!=''){ alert(data);} } 
				});
			}
        });
		$('#myModal1').modal('show');
		$('#myModal1').on('shown.bs.modal', function (e) { });
		$('#myModal1').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal1").empty(); });
	} });
}
function est(a,b,idPacs){/*a es id del estudio, b es el id del estudio ambos en venta de conceptos*/
	var url = window.location.href; 
	
	var sodb = url.split('://'); if(sodb[0]=='https' || sodb[0]=='HTTPS'){
		var myL = url.split('https://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888'); 
		var link_1 = koby[0];
	}else{
		var myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888'); 
		var link_1 = koby[0]+koby[1];
	}
	
	asegurarModal('myModal1');
	var idE = {idE:a,h:koby[0]}
	$.post('imagen/files-serverside/datosInterpretar.php',idE).done(function( data ) {
		var dataE = data.split(';*}-{');
		console.log('est() idVC='+a+' idPacs='+idPacs, dataE);
		if(dataE[0]!=''){
			$("#myModal1").load('imagen/htmls/mi_estudio.php', function(response,status,xhr){if(status == "success"){
				console.log(dataE);
				$('#referencia_est').val(dataE[12]); $('#idEstudioPacs').val(dataE[19]);
				$('#referencia_est').attr("refe", dataE[34]);
				$('#paciente_est').val(dataE[0]); $('#folio_est').val(dataE[8]);
				var pu = 'http://csantonio.ddns.net:8887/dcm4chee-arc/aets/DCM4CHEE/wado/wado?requestType=PATIENT&studyUID='+dataE[16];
				var linkOsiL = 'osirix://?methodName=DownloadURL&Display=YES&URL='+encodeURI(pu);
				var ka = '<a href='+dataE[17]+' id="localhost"><img src="imagenes/osirix.png"></a>';
				$('#chosto').html('');
				var studyUID = dataE[35];
				$('#chosto').text(dataE[19] + 'viewer.html?StudyInstanceUIDs=' + studyUID);
				$('#chosto1').text(dataE[19] + 'weasis-pacs-connector/viewer?StudyInstanceUIDs=' + studyUID);
				var mi_referCh = $('#referencia_est').val().replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');
				$('#chosto').text(dataE[19]+'viewer.html?StudyInstanceUIDs='+mi_referCh);
				$('#chosto1').text(dataE[19]+'weasis-pacs-connector/viewer?StudyInstanceUIDs='+mi_referCh);
				$('#chosto').append(ka);
				var studyUID = dataE[35];
				$('#studyUID').val(studyUID);

				$('#btn_gen_enla').off('click').on('click', function(e) {
					e.preventDefault();
					$.ajax({
						url: 'http://localhost:4000/api/share',
						type: 'POST',
						contentType: 'application/json',
						data: JSON.stringify({
							studyUID: studyUID,
							patientName: $('#paciente_est').val(),
							patientID: $('#referencia_est').val(),
						}),
						success: function(response) {
							if (response.success) { $('#enlaceGenerado').val(response.url); }
							else { alert(response.message || 'No se pudo generar el enlace'); }
						},
						error: function(xhr) { console.error(xhr.responseText); alert('Error al generar el enlace'); }
					});
				});

				$('#btn_comp_enlace').off('click').on('click', function(e) {
					e.preventDefault();
					var telefono = $('#telefonoWhatsapp').val().replace(/\D/g, '');
					var enlace = $('#enlaceGenerado').val();
					if (!enlace) { alert('Primero genera el enlace.'); return; }
					if (!telefono) { alert('Ingresa un número de WhatsApp.'); return; }
					var mensaje = encodeURIComponent('Hola. Puedes visualizar tu estudio DICOM en el siguiente enlace:\n\n' + enlace);
					window.open('https://wa.me/' + telefono + '?text=' + mensaje, '_blank');
				});
				$('#btn_v_avanzado').click(function(e) {
					window.open('http://localhost:81/viewer?StudyInstanceUIDs='+studyUID);
				});
				if(($('#acc_user').val()==1 || $('#acc_user').val()==11 || $('#acc_user').val()==3) & $('#multisu_s').val()!=0){
					$('#btn_reasignar_id').click(function(e){ noest(a, dataE[8], dataE[0], dataE[1], dataE[33], idPacs); });
				}
				else{ $('#btn_reasignar_id').remove(); }
			
				$('#myModal1').modal('show');
				$('#myModal1').on('shown.bs.modal', function (e) { });
				$('#myModal1').on('hidden.bs.modal', function (e) { 
					$(".modal-content").remove(); $("#myModal1").empty(); 
					$('#paciente_est, #referencia_est, #folio_est, #idEstudioPacs').val('');
				});
			}});		
		}else{
			swal({title:"",type:"error",text:"No se pudieron obtener los datos del estudio (revisa la consola y el log de PHP)",timer:3000,showConfirmButton:false});
		}
	}).fail(function(xhr){
		alert('Error HTTP '+xhr.status+' en datosInterpretar.php\n'+$('<div>').html(xhr.responseText||'').text().substring(0,400));
	});
}

function miImg(idImg){ //alert(idImg);
	$('#mi_video_ver').addClass('hidden'); $('#mi_foto_ver').removeClass('hidden');
	var d = new Date(); var xo = d.format('YmdHisu').substring(0,22); $('#foto_ver').html('<img src="'+idImg+'?'+xo+'">');
	$('#close_img_ver').click(function(e) {
        $('#mi_video_ver').removeClass('hidden'); $('#mi_foto_ver').addClass('hidden'); $('#foto_ver').html('');
    });
}
function reporteFoto(idI, nombreI){ //alert($('#'+nombreI).html());
	//if ($('#'+nombreI).is(':checked')){alert(1);}else{alert(0);}
	var datoC = {id:idI}
	$.post("imagen/img_usg/procesa.php?action=checar", datoC).done(function( dataA ) { //alert(dataA);
		if(dataA==1){//Aun hay menos de 6
			if($('#'+nombreI).is(":checked")){
				var dato = {id:idI, reportar:1}
				$.post("imagen/img_usg/procesa.php?action=reporte", dato).done(function( data ) { 
					var datoxC = data.split(';');
					if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">R</span>'); }
					cargarImagenesCanvas(datoxC[1]);//cargarImagenesReporte(datoxC[1]);
				});
			}else{
				var dato = {id:idI, reportar:0}
				$.post("imagen/img_usg/procesa.php?action=reporte", dato).done(function( data ) {
					var datoxC = data.split(';');
					if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">NR</span>'); }
					cargarImagenesCanvas(datoxC[1]);//cargarImagenesReporte(datoxC[1]);
				});
			}
		}else{//ya esta lleno
			if($('#'+nombreI).is(":checked")){
				
			}else{
				
			}
			var dato = {id:idI, reportar:0}
			$.post("imagen/img_usg/procesa.php?action=reporte", dato).done(function( data ) {
				var datoxC = data.split(';');
				if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">NR</span>'); }
				cargarImagenesCanvas(datoxC[1]);//cargarImagenesReporte(datoxC[1]);
			});
		}
	});
}

function editar(x, estudio, referencia, paciente){//alert($('#acc_user').val());// x=id del estudio en vc
	if($('#acc_user').val()==1){
		swal({
		  title: "EDITAR LA INTERPRETACIÓN",
		  text: "¿Estás seguro de querer editar la interpretación del estudio "+estudio+" del paciente "+paciente+" con referencia "+referencia+"?",
		  type: "warning", showCancelButton: true,
		  confirmButtonColor: "#DD6B55", confirmButtonText: "Editar", cancelButtonText: "Cancelar", closeOnConfirm: false
		},
		function(){
		  	var dato = { idE:x, idU:$('#id_user').val() }
			$.post('imagen/files-serverside/editarEndoscopia.php', dato).done(function( data ) {
				if(data==1){
					swal.close(); $('#clickme').click();
					window.setTimeout(function(){
						swal({title:"",type:"success",text:"¡La interpretación esta lista para su edición!",timer:2500,showConfirmButton:false});
					},300);
				}else{alert(data);}
			});
		});
	}else{ swal({title:"",type:"error",text:"¡Acceso restringido!",timer:2500,showConfirmButton:false}); }
}//fin editar

var recognition; var recognizing = false;
if (!('webkitSpeechRecognition' in window)) { $('#dictado').hide(); /*alert("¡API no soportada!"); */} 
else {
	recognition = new webkitSpeechRecognition(); recognition.lang = "es-VE";
	recognition.continuous = true; recognition.interimResults = false; //era true

	recognition.onstart = function() { recognizing = true; console.log("empezando a eschucar"); }
	recognition.onresult = function(event) {
	 for (var i = event.resultIndex; i < event.results.length; i++) { 
		if(event.results[i].isFinal){insertAtCaret(event.results[i][0].transcript);}
	 } //texto
	}
	recognition.onerror = function(event) {  }
	recognition.onend = function() {
		recognizing = false;
		$('#dictado').html('<i class="fa fa-pencil" aria-hidden="true"></i> INICIAR DICTADO');
		console.log("terminó de eschucar, llegó a su fin");
	}
}

function procesarV() {
	if(recognizing==false){
		recognition.start();recognizing=true; $('#mceu_17').html('<button role="presentation" type="button" tabindex="-1"><span class="mce-txt">DETENER DICTADO</span></button>');
	}
	else{recognition.stop();recognizing=false;$('#mceu_17').html('<button role="presentation" type="button" tabindex="-1"><span class="mce-txt">DICTAR</span></button>');}
}

function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); }
</script>