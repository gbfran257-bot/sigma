<?php require_once('../../Connections/horizonte.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) { session_start(); }

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){ $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']); }

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) { session_start(); }
$MM_authorizedUsers = "1,2,3,4,5,6,7,8,9,10,11,12,13";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { $isValid = true; } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { $isValid = true; } 
    if (($strUsers == "") && false) { $isValid = true; } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (isset($_SESSION['MM_Username'])) { $colname_usuario = $_SESSION['MM_Username']; }
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM sucursales WHERE clave_su = %s", GetSQLValueString($row_usuario['idSucursal_u'], "text"));
$nombreSucursalUsuario = mysql_query($query_nombreSucursalUsuario, $horizonte) or die(mysql_error());
$row_nombreSucursalUsuario = mysql_fetch_assoc($nombreSucursalUsuario);
$totalRows_nombreSucursalUsuario = mysql_num_rows($nombreSucursalUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreDepartamentoUsuario = sprintf("SELECT nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['idDepartamento_u'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error());
$row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario);
$totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);

?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../../imagenes/general/favicon.ico">
<meta charset="utf-8">
<title>BASES LABORATORIO</title>

<link href="../../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../../css/resultados.css" rel="stylesheet" type="text/css">
<link href="../../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../DataTables-1.10.5/media/css/jquery.dataTables.css">
<link href="../../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
<link href="../../Editor-PHP-1.4.0/css/dataTables.editor.css" rel="stylesheet">

<script src="../../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../../jquery-ui-1.12.0/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../../Editor-PHP-1.4.0/js/dataTables.editor.js"></script>
<script src="../../funciones/js/caracteres.js"></script>
<script src="../../funciones/js/calcula_edad.js"></script>
<script src="../../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../../funciones/js/jquery.printElement.min.js"></script>
<script src="../../funciones/js/stdlib.js"></script>
<script type="text/javascript" src="../../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8"></script>

<script language="javascript">
//para las tooltips
$( document ).tooltip({
	position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } },
	//tooltipClass: "toolTip"
});
</script>

<script>
$(document).ready(function(e) {
	$('#verMenu').click(function(e){window.location='../../menu.php?menu=ml';}); 
	$("#upload").button({ icons: { primary: "ui-icon-image" }, text: true });
	var i = 1;
	
	$('#dispara_menu').click(function(e) { i++;
		if(i%2==0){
			$('#header').after('<div id="div_menu" class="ver_menu" style="border:1px none red; z-index:1000000000000; position:fixed; width:240px;"><table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="left"><ul id="menu_u1" style="border-bottom-left-radius:4px;border-bottom-right-radius:4px;"><li><div id="mi_perfil"><span class="ui-icon ui-icon-person"></span> Mi perfil</div></li><li><div><span class="ui-icon ui-icon-gear"></span> Configuración</div></li><li><div><span class="ui-icon ui-icon-power"></span> <a href="<?php echo $logoutAction ?>">Cerrar sesión</a></div></li><li><div id="ayuda"><span class="ui-icon ui-icon-info"></span> Ayuda</div></li><li><div id="reportar_problema"><span class="ui-icon ui-icon-comment"></span> Reportar problema</div></li><li><div id="politicas_condiciones"><span class="ui-icon ui-icon-script"></span> Políticas y condiciones</div></li><li><div id="aviso_privacidad"><span class="ui-icon ui-icon-alert"></span> Aviso de privacidad</div></li><li><div id="acerca_de"><span class="ui-icon ui-icon-star"></span> Acerca de</div></li></ul></td></tr></table></div>');
			$('#div_menu').css('top',$('#header').height()+0); $('#menu_u1').menu(); 
			$('#mi_perfil').click(function(e){ window.location="usuarios/perfil.php"; });
			$('#div_menu').css('right',104);
			$('#dispara_menu span').removeClass('ui-icon-triangle-1-s'); $('#dispara_menu span').addClass('ui-icon-triangle-1-n');
			$('#contenido').click(function(e){ 
				$('#div_menu').remove(); i = 1;
				$('#dispara_menu span').removeClass('ui-icon-triangle-1-n');
				$('#dispara_menu span').addClass('ui-icon-triangle-1-s');
			});
		}else{ 
			$('#dispara_menu span').removeClass('ui-icon-triangle-1-n'); $('#dispara_menu span').addClass('ui-icon-triangle-1-s');
			$('#div_menu').remove(); 
		}
    });
	
	var he = $('#referencia').height() - $('#header').height() - $('.botones').height() - 160;
	var wi = $('#referencia').width() * 0.96;
	$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
	
	$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
	
	$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
				
	$( window ).resize(function(e) {		
		var he = $('#referencia').height() - $('#header').height() - $('.botones').height() - 160;
		var wi = $('#referencia').width() * 0.96;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-90);
		$('.tabs').css('width',wi/7.2);
    });
	
	var cuadrado = 35;
	$('button').css('width',cuadrado).css('height',cuadrado);
	$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
	
	$('form').submit(function(event) { event.preventDefault(); });
	
	$('#input').jqte();

	$('#input').jqteVal('');
	$('.jqte_editor').css('height',$('#dialog-confirmarNuevoPaciente').height()*0.7);
	
});
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: {
	  // seconds
	  step: 60 * 1000,
	  // hours
	  page: 60
	},
	_parse: function( value ) {
      if ( typeof value === "string" ) { // already a timestamp
        if ( Number( value ) == value ) { return Number( value ); }
        return +Globalize.parseDate( value );
      }
      return value;
    },
	_format: function( value ) { return Globalize.format( new Date(value), "t" ); }
  });
</script>

<script>
function editPrecio(id){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editPrecio', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditPrecio').validate({});
			$('#dialog-updates').dialog({ 
				title: 'EDITAR EL PRECIO TOTAL DEL CONSUMIBLE PARA LA BASE', modal: true, autoOpen: true, closeText: '', width: 590, height: 240, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditPrecio').valid()){
							var datosEC = $('#formEditPrecio').serialize();
							$.post('files-serverside/editPrecio.php',datosEC).done(function(data){
								if(data == 1){ 
									$('#clickmeCo').click(); $('#dialog-updates').dialog('close'); var idACo = {idC : id}
									$.post('files-serverside/calculaPrecioMB.php',idACo).done(function(data){
										$('#precioP').val(data);
									});
								}else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAC').val(id);
					$('#idUsuarioUC').val($('#idUser').val());
				}
			});
		}
	});
}); }
function editCantidad(id){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editCantidad', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditCantidad').validate({});
			$('#dialog-updates').dialog({ 
				title: 'EDITAR LA CANTIDAD DEL CONSUMIBLE PARA LA BASE', modal: true, autoOpen: true, closeText: '', width: 550, height: 240, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditCantidad').valid()){
							var datosEC = $('#formEditCantidad').serialize();
							$.post('files-serverside/editCantidad.php',datosEC).done(function(data){
								if(data == 1){ $('#clickmeCo').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAC').val(id);
					$('#idUsuarioUC').val($('#idUser').val());
				}
			});
		}
	});
}); }
function editPara(id, para){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editarPara', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditarPara').validate({});
			$('#dialog-updates').dialog({ 
				title: 'EDITAR EL SEXO PARA EL VALOR DE REFERENCIA', modal: true, autoOpen: true, closeText: '', width: 500, height: 230, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditarPara').valid()){
							var datosEP = $('#formEditarPara').serialize();
							$.post('files-serverside/editarPara.php',datosEP).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUP').val($('#idUser').val());
					if(para == 'Editar'){$('#sexoEP').val('');}else{$('#sexoEP').val(para);}
				}
			});
		}
	});
}); }
function editBooleano(id,valor){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editBooleano', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditBooleano').validate({});
			$('#dialog-updates').dialog({ 
				title: 'VALOR DE REFERENCIA POSITIVO-NEGATIVO', modal: true, autoOpen: true, closeText: '', width: 790, height: 230, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditBooleano').valid()){
							var datosEB = $('#formEditBooleano').serialize();
							$.post('files-serverside/editBooleano.php',datosEB).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUB').val($('#idUser').val());
					$('#valorBooleano').val(valor);
				}
			});
		}
	});
}); }
function editValorMaximo(id,valor){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editarValorMaximo', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditarValorMaximo').validate({});
			$('#dialog-updates').dialog({ 
				title: 'VALOR DE REFERENCIA -VALOR MÁXIMO-', modal: true, autoOpen: true, closeText: '', width: 600, height: 240, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditarValorMaximo').valid()){
							var datosEVM = $('#formEditarValorMaximo').serialize();
							$.post('files-serverside/editValorMax.php',datosEVM).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUR').val($('#idUser').val());
					$('#valorMax').val(valor);
				}
			});
		}
	});
}); }
function editValorMinimo(id,valor){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editarValorMinimo', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditarValorMinimo').validate({});
			$('#dialog-updates').dialog({ 
				title: 'VALOR DE REFERENCIA -VALOR MÍNIMO-', modal: true, autoOpen: true, closeText: '', width: 600, height: 240, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditarValorMinimo').valid()){
							var datosEVM = $('#formEditarValorMinimo').serialize();
							$.post('files-serverside/editValorMin.php',datosEVM).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUR').val($('#idUser').val());
					$('#valorMin').val(valor);
				}
			});
		}
	});
}); }

function editValorTexto(id,valor){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editarValorTexto', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditarValorTexto').validate({});
			$('#dialog-updates').dialog({ 
				title: 'VALOR DE REFERENCIA -VALOR DE TEXTO-', modal: true, autoOpen: true, closeText: '', width: 600, height: 240, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditarValorTexto').valid()){
							var datosEVM = $('#formEditarValorTexto').serialize();
							$.post('files-serverside/editValorText.php',datosEVM).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUR').val($('#idUser').val());
					$('#valorText').val(valor);
				}
			});
		}
	});
}); }

function editRangoMM(id,valor,valor1){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editarRangoMasMenos', function( response, status, xhr ){
		if ( status == "success" ) { $('#formERangoMasMenos').validate({});
			$('#dialog-updates').dialog({ 
				title: 'VALOR DE REFERENCIA RANGO(+-)', modal: true, autoOpen: true, closeText: '', width: 600, height: 270, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formERangoMasMenos').valid()){
							var datosEVM = $('#formERangoMasMenos').serialize();
							$.post('files-serverside/editRangoMM.php',datosEVM).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUR').val($('#idUser').val());
					$('#valor').val(valor);
					$('#variacion').val(valor1);
				}
			});
		}
	});
}); }

function editEdades(id,tipoE,eI,eF,tipoEdad){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editEdades', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditEdades').validate({});
			$('#dialog-updates').dialog({ 
				title: 'EDITAR EL TIPO DE EDAD DEL VALOR DE REFERENCIA', modal: true, autoOpen: true, closeText: '', width: 820, 
				height: 320, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditEdades').valid()){
							var datosEE = $('#formEditEdades').serialize();
							$.post('files-serverside/editEdades.php',datosEE).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$("#radiosB").buttonset();
					//tipoEdad
					$(".radio_r").click(function(e) {
						if($(this).hasClass('rad1')){ 
							$('.edadA').text('años'); 
							$('#tipo_edadR').val('a');
						}
						if($(this).hasClass('rad2')){ 
							$('.edadA').text('meses');
							$('#tipo_edadR').val('m');
						}
						if($(this).hasClass('rad3')){ 
							$('.edadA').text('días');
							$('#tipo_edadR').val('d');
						}
                    });
					
					$('#idAVR').val(id);
					$('#idUsuarioUE').val($('#idUser').val());
					
					if(tipoE == 'Editar'){ 
						$('#tipoEdad').val(''); $('.rangoEdad').hide();
					}else{
						$('#tipoEdad').val(tipoE); $('.rangoEdad').show();
					}
					
					if($('#tipoEdad').val()=='TODAS LAS EDADES' || $('#tipoEdad').val()==''){
						$('.rangoEdad input').val(''); $('.rangoEdad').hide();
						$(".radio_r").each(function(index, element) { $(".radio_r").next().removeClass('ui-state-active'); });
						$('#edadI,#edadF').val('');
					}
					else{
						if(tipoEdad=='a'){
							$('.radio_r').next().removeClass('ui-state-active'); $('.edadA').text('años');
							$('.rad1').next().addClass('ui-state-active'); $('#tipo_edadR').val('a');
						}else if(tipoEdad=='m'){
							$('.radio_r').next().removeClass('ui-state-active'); $('.edadA').text('meses'); 
							$('.rad2').next().addClass('ui-state-active'); $('#tipo_edadR').val('m');
						}else if(tipoEdad=='d'){
							$('.radio_r').next().removeClass('ui-state-active'); $('.edadA').text('días'); 
							$('.rad3').next().addClass('ui-state-active'); $('#tipo_edadR').val('d');
						}
						$('#edadI').focus();
					}
					
					$('#tipoEdad').change(function(e) {
                        if($('#tipoEdad').val()=='TODAS LAS EDADES' || $('#tipoEdad').val()==''){
							$('.rangoEdad input').val(''); $('.rangoEdad').hide();
							$(".radio_r").each(function(index, element) { $(".radio_r").next().removeClass('ui-state-active'); });
							$('#edadI,#edadF').val('');
						}
						else{
							$('.rangoEdad').show(); $('#edadI').focus(); $(".rad1").next().addClass('ui-state-active');
							$('#tipo_edadR').val('a');
						}
                    });
					
					$('#edadI').val(eI);
					$('#edadF').val(eF);
				}
			});
		}
	});
}); }
function editRangoNumerico(id,mini,maxi){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editarRangoNumerico', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditarRangoNumerico').validate({});
			$('#dialog-updates').dialog({ 
				title: 'EDITAR LOS VALORES DEL RANGO PARA EL VALOR DE REFERENCIA', modal: true, autoOpen: true, closeText: '', width: 650, height: 270, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditarRangoNumerico').valid()){
							var datosER = $('#formEditarRangoNumerico').serialize();
							$.post('files-serverside/editarRangoNumerico.php',datosER).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUR').val($('#idUser').val());
					$('#rangoI').val(mini);
					$('#rangoF').val(maxi);
				}
			});
		}
	});
}); }
function editValoresNMA(id,vn,vr1,vr2,vm){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editValoresNMA', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditarValoresNMA').validate({});
			$('#dialog-updates').dialog({ 
				title: 'EDITAR LOS VALORES NORMAL, MODERADO Y ALTO PARA EL VALOR DE REFERENCIA', modal: true, autoOpen: true, closeText: '', width: 750, height: 300, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditarValoresNMA').valid()){
							var datosER = $('#formEditarValoresNMA').serialize();
							$.post('files-serverside/editarRangoNumericoTriple.php',datosER).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUR').val($('#idUser').val());
					$('#valorN').val(vn);
					$('#rangoI').val(vr1);
					$('#rangoF').val(vr2);
					$('#valorA').val(vm);
				}
			});
		}
	});
}); }

function editValoresNMAi(id,vn,vr1,vr2,vm){ $(document).ready(function(e) {
	$("#dialog-updates").load('htmls/ficha_base.php #editValoresNMAi', function( response, status, xhr ){
		if ( status == "success" ) { $('#formEditarValoresNMA').validate({});
			$('#dialog-updates').dialog({ 
				title: 'EDITAR LOS VALORES NORMAL, MODERADO Y ALTO (INVERSO) PARA EL VALOR DE REFERENCIA', modal: true, autoOpen: true, closeText: '', width: 750, height: 300, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
					"Actualizar": function() { 
						if($('#formEditarValoresNMA').valid()){
							var datosER = $('#formEditarValoresNMA').serialize();
							$.post('files-serverside/editarRangoNumericoTripleI.php',datosER).done(function(data){
								if(data == 1){ $('#clickmeRe').click(); $('#dialog-updates').dialog('close'); }else{alert(data);}
							});
						}
					},
					"Cancelar": function() { $('#dialog-updates').dialog('close'); },
				}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-updates').empty(); },
				open:function( event, ui ){
					$('#idAVR').val(id);
					$('#idUsuarioUR').val($('#idUser').val());
					$('#valorN').val(vn);
					$('#rangoI').val(vr1);
					$('#rangoF').val(vr2);
					$('#valorA').val(vm);
				}
			});
		}
	});
}); }

function fichaUM(idUM, nombreUM){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaUnidadMedida',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioUM').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevaUnidadMedida').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DE LA UNIDAD DE MEDIDA '+nombreUM, modal: true, autoOpen: true, closeText: '', width: wi, height: 290,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevaUnidadMedida').valid()){
						var idNUM = $('#formNuevaUnidadMedida').serialize();
						$.post('files-serverside/actualizarUmedida.php?idUM='+idUM,idNUM).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bum').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('LA UNIDAD DE MEDIDA SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoUM').hide();
			  	var idU = {idUM : idUM}
				$.post('files-serverside/datosFichaUM.php',idU).done(function(data){
					var datos = data.split('{;]');
					$('#nombreUM').val(datos[0]);
					$('#abreviacionUM').val(datos[1]);
				});  
			  }
			});
		}
	});
}
function fichaEQ(idEQ, nombreEQ){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevoEquipo',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevoEquipo').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DEL EQUIPO '+nombreEQ, modal: true, autoOpen: true, closeText: '', width: wi, height: 380,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevoEquipo').valid()){
						var idNUM = $('#formNuevoEquipo').serialize();
						$.post('files-serverside/actualizarEquipo.php?idUM='+idEQ,idNUM).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bequi').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL EQUIPO SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoEquipo').hide();
			  	var idE = {idEqui : idEQ}
				$.post('files-serverside/datosFichaEQ.php',idE).done(function(data){
					var datos = data.split('{;]');
					$('#modeloE').val(datos[0]);
					$('#marcaE').val(datos[1]);
					$('#descripcionE').val(datos[2]);
				});  
			  }
			});
		}
	});
}
function fichaAr(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaArea',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNA').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevaArea').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DEL ÁREA '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 280,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevaArea').valid()){
						var idNAre = $('#formNuevaArea').serialize();
						$.post('files-serverside/actualizarArea.php?idAre='+id,idNAre).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_barea').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL ÁREA SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoArea').hide();
			  	var idA = {idArea1 : id}
				$.post('files-serverside/datosFichaArea.php',idA).done(function(data){
					var datos = data.split('{;]');
					$('#areaE1').val(datos[0]);
					$('#claveE1').val(datos[1]);
				});  
			  }
			});
		}
	});
}
function fichaMue(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaMuestra',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNMu').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevaMuestra').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DE LA MUESTRA '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 280,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevaMuestra').valid()){
						var idNUM = $('#formNuevaMuestra').serialize();
						$.post('files-serverside/actualizarMuestra.php?idMu='+id,idNUM).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bequi').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('LA MUESTRA SE ACTUALIZÓ SATISFACTORIAMENTE');
										$('#clickme_bmues').click();
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#addCondicion1').click(function(e) { addCondicion(); });
				
				$('#textoAddMuestra').hide();
				$('#addCondicion1').click(function(event) { event.preventDefault(); });
				$('#addCondicion1').button({icons:{primary:"ui-icon-plus"},text:false });
				$('#addCondicion1').css('width',35).css('height',35);
				$("#condicionM").load("files-serverside/generaCondicionesMuestras.php",function(response,status,xhr){ 
					if ( status == "success" ) { 
						var idMu1 = {idMu : id}
						$.post('files-serverside/datosFichaMu.php',idMu1).done(function(data){
							var datos = data.split('{;]');
							$('#nombreM').val(datos[0]);
							$('#condicionM').val(datos[1]);
						}); 
					} 
				}); 
			  }
			});
		}
	});
}
function fichaVrefe(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaReferencia',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevaReferencia').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DEL VALOR DE REFERENCIA '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 400,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevaReferencia').valid()){
						var idNvr = $('#formNuevaReferencia').serialize();
						$.post('files-serverside/actualizarValorR.php?idvr='+id,idNvr).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bvaref, #clickmeVRefe, #clickmeBReB').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL VALOR DE REFERENCIA SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){				
				$('#textoAddReferencia').hide();
				$("#tipoC").load("genera/tipo_referencias.php", function( response, status, xhr ) { if ( status == "success" ) { 
					var idVr1 = {idVr : id}
					$.post('files-serverside/datosFichaVR.php',idVr1).done(function(data){
						var datos = data.split('{;]');
						$('#nombreC').val(datos[0]);
						$('#tipoC').val(datos[1]);
						$('#descripcionC').val(datos[2]);
					});
				} }); 
			  }
			});
		}
	});
}

function addCondicion(){
	$("#dialog-nuevoItem1").load('htmls/ficha_base.php #nuevaCondicionMuestra',function(response,status,xhr){
		if ( status == "success" ) { 
			var wi = $('#referencia').width() * 0.98;
			$('#idUsuarioNI').val($('#idUser').val());
			$('#dialog-nuevoItem1 input, #dialog-nuevoItem1 select, #dialog-nuevoItem1 textarea').addClass('campoITtab'); 
			$('#formNuevoItem').validate();
			$('#dialog-nuevoItem1').dialog({ 
				title: 'AGREGAR UNA NUEVA CONDICIÓN PARA LAS MUESTRAS', modal: true, autoOpen: true, closeText: '', width: wi, height: 260, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Guardar": function() {
				   if($('#formNuevoItem').valid()){
						var idNCo = $('#formNuevoItem').serialize();
						$.post('files-serverside/agregarNcondicionMuestra.php',idNCo).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem1').dialog('close');
							$("#condicionM").load("files-serverside/generaCondicionesMuestras.php",function(response,status,xhr){});
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('LA NUEVA CONDICIÓN SE GUARDÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
								$('#clickme_bcon').click();
							}else{alert(data);}
						});
				   }
				},
				"Cancelar": function() { $('#dialog-nuevoItem1').dialog('close'); }
			  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-nuevoItem1').empty(); },
			  open:function( event, ui ){ }
			});
		}
	});
}
function addMetodo(){
	$("#dialog-nuevoItem1").load('htmls/ficha_base.php #nuevoMetodo',function(response,status,xhr){
		if ( status == "success" ) { 
			var wi = $('#referencia').width() * 0.98;
			$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem1 input, #dialog-nuevoItem1 select, #dialog-nuevoItem1 textarea').addClass('campoITtab'); 
			$('#formNuevoItem').validate();
			$('#dialog-nuevoItem1').dialog({ 
				title: 'AGREGAR UN NUEVO MÉTODO PARA LAS BASES', modal: true, autoOpen: true, closeText: '', width: wi, height: 260, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Guardar": function() {
				   if($('#formNuevoMetodo').valid()){
						var idNCo = $('#formNuevoMetodo').serialize();
						$.post('files-serverside/agregarNmetodo.php',idNCo).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem1').dialog('close');
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL NUEVO MÉTODO SE GUARDÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
								$('#clickme_bmet').click();
								$('#clickmeMeSB').click();
							}else{alert(data);}
						});
				   }
				},
				"Cancelar": function() { $('#dialog-nuevoItem1').dialog('close'); }
			  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-nuevoItem1').empty(); },
			  open:function( event, ui ){ }
			});
		}
	});
}
function addIndicacion(){
	$("#dialog-nuevoItem1").load('htmls/ficha_base.php #nuevaIndicacion',function(response,status,xhr){
		if ( status == "success" ) { 
			var wi = $('#referencia').width() * 0.98;
			$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem1 input, #dialog-nuevoItem1 select, #dialog-nuevoItem1 textarea').addClass('campoITtab'); 
			$('#formNuevaIndicacion').validate();
			$('#dialog-nuevoItem1').dialog({ 
				title: 'AGREGAR UNA NUEVA INDICACIÓN PARA LAS BASES', modal: true, autoOpen: true, closeText: '', width: wi, height: 310, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Guardar": function() {
				   if($('#formNuevaIndicacion').valid()){
						var idNin = $('#formNuevaIndicacion').serialize();
						$.post('files-serverside/agregarNindicacion.php',idNin).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem1').dialog('close');
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('LA NUEVA INDICACIÓN SE GUARDÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
								$('#clickme_bIndi').click();
								$('#clickmeImSB').click();
							}else{alert(data);}
						});
				   }
				},
				"Cancelar": function() { $('#dialog-nuevoItem1').dialog('close'); }
			  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-nuevoItem1').empty(); },
			  open:function( event, ui ){ }
			});
		}
	});
}

function addConsumible(){
	var cuad = 32, he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
	$("#dialog-nuevoItem1").load('htmls/ficha_base.php #nuevoConsumible',function(response,status,xhr){
		if ( status == "success" ) { 
			var wi = $('#referencia').width() * 0.98;
			$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem1 input, #dialog-nuevoItem1 select, #dialog-nuevoItem1 textarea').addClass('campoITtab'); 
			$('#formNuevoConsumible').validate();
			$('#dialog-nuevoItem1').dialog({ 
				title: 'AGREGAR UN NUEVO CONSUMIBLE PARA LAS BASES', modal: true, autoOpen: true, closeText: '', width: wi, height: 450, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Guardar": function() {
				   if($('#formNuevoConsumible').valid()){
						var idNcons = $('#formNuevoConsumible').serialize();
						$.post('files-serverside/agregarNconsumible.php',idNcons).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem1').dialog('close');
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL NUEVO CONSUMIBLE SE GUARDÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
								$('#clickme_bConsu').click();
								$('#clickmeCoSB').click();
							}else{alert(data);}
						});
				   }
				},
				"Cancelar": function() { $('#dialog-nuevoItem1').dialog('close'); }
			  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-nuevoItem1').empty(); },
			  open:function( event, ui ){ 
			  	juanchi();
			  }
			});
		}
	});
}
function addValorRef(){
	var cuad = 32, he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
	$("#dialog-nuevoItem1").load('htmls/ficha_base.php #nuevaReferencia',function(response,status,xhr){
		if ( status == "success" ) { 
			$("#tipoC").load("genera/tipo_referencias.php", function( response, status, xhr ) { if ( status == "success" ) { } });
			var wi = $('#referencia').width() * 0.98;
			$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem1 input, #dialog-nuevoItem1 select, #dialog-nuevoItem1 textarea').addClass('campoITtab'); 
			$('#formNuevaReferencia').validate();
			$('#dialog-nuevoItem1').dialog({ 
				title: 'AGREGAR UN NUEVO VALOR DE REFERENCIA', modal: true, autoOpen: true, closeText: '', width: wi, height: 420, closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Guardar": function() {
				   if($('#formNuevaReferencia').valid()){
						var idNvr = $('#formNuevaReferencia').serialize();
						$.post('files-serverside/agregarNreferencia.php',idNvr).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem1').dialog('close');
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL NUEVO VALOR DE REFERENCIA SE GUARDÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
								$('#clickmeVRefe, #clickmeBReB, #clickme_bvaref').click();
							}else{alert(data);}
						});
				   }
				},
				"Cancelar": function() { $('#dialog-nuevoItem1').dialog('close'); }
			  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-nuevoItem1').empty(); },
			  open:function( event, ui ){ }
			});
		}
	});
}
function juanchi(){ var cuad = 32;
	var wi = $('#referencia').width() * 0.98;
	var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
	$('#bTipoCo, #bUnidadCo, #bPresentacionCo').click(function(event) { event.preventDefault(); });
				$('#bTipoCo, #bUnidadCo, #bPresentacionCo').button({ icons: { primary: "ui-icon-search" }, text: false });
				$('#bTipoCo, #bUnidadCo, #bPresentacionCo').css('width',cuad).css('height',cuad);
				
				$('#bPresentacionCo').click(function(e) { //Botón para buscar la presentación del consumible
					$("#dialog-buscarAlgo1").load("htmls/buscarTipoPresentacionC.php #presentacionB",function(response,status,xhr ){
					if ( status == "success" ){
						window.setTimeout(function(){
							$('#addPresentacionC').click(function(event) { event.preventDefault(); });
							$('#addPresentacionC').button({ icons: { primary: "ui-icon-plus" }, text: false });
							$('#addPresentacionC').css('width',cuad).css('height',cuad);
						},200);
						
						window.setTimeout(function(){
						$('#addPresentacionC').click(function(e) {
							$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaPresentacionCons',function(response,status,xhr){
								if ( status == "success" ) { 
									$('#idUsuarioNI').val($('#idUser').val());
									$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
									$('#formNuevaPresentacionConsumible').validate();
									$('#dialog-nuevoItem').dialog({ 
										title: 'AGREGAR UNA NUEVA PRESENTACIÓN DEL CONSUMIBLE',modal:true,autoOpen:true,closeText:'',
										width: wi, height: 280, closeOnEscape: false, dialogClass: 'no-close',
										buttons: {
										"Guardar": function() {
										   if($('#formNuevaPresentacionConsumible').valid()){
												var idNp = $('#formNuevaPresentacionConsumible').serialize();
												$.post('files-serverside/agregarNpresentacionConsumible.php',idNp).done(function(data){
													if(data == 1){ 
														$('#dialog-nuevoItem').dialog('close');
														$('#clickme_bpcon').click();
														$('#dialog-confirmacion').dialog({
															title: 'CONFIRMACIÓN', modal: true, 
															autoOpen: true, closeText: '', width: 600, height: 200, 
															closeOnEscape: false, dialogClass: 'no-close',
															open:function( event, ui ){
																$('#textoConfirmacion').text('LA NUEVA PRESENTACIÓN SE GUARDÓ SATISFACTORIAMENTE');
																window.setTimeout(function(){
																	$('#dialog-confirmacion').dialog('close');
																},2000);
															}
														});
													}else{alert(data);}
												});
										   }
										},
										"Cancelar": function() { $('#dialog-nuevoItem').dialog('close'); }
									  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
									  open:function( event, ui ){ }
									});
								}
							});
						});
						},500);
						
						$('#dialog-buscarAlgo1').dialog({ 
							title: 'PRESENTACIÓN DEL CONSUMIBLE', modal: true, autoOpen: true, closeText: '', width: wi, height: he,
							closeOnEscape: true, dialogClass: '', buttons: { },
							buttons: {
								"Aceptar": function() {
								   if($('.selected2').length >0){$('#errorSeleccionPconsumible').hide();
									$('#id_presentacionCosumible').val($('#id_presentacionCosumibleT').val());
									$('#presentacionC1').val($('#presentacionC1T').val());
									$('#dialog-buscarAlgo1').dialog('close');
								   }else{ $('#errorSeleccionPconsumible').hide().show('shake'); }
								},
								"Cancelar": function() { $('#dialog-buscarAlgo1').dialog('close'); }
							},
							open:function( event, ui ){
								var oTableBpresentacionC;
								oTableBpresentacionC = $('#dataTableBpresentacionConsu').dataTable({
									"bJQueryUI": true, "bRetrieve": true, ordering: false,
									"sScrollY": $('#dialog-buscarAlgo').height()-100, "bStateSave": false, "bInfo": true, 
									"bFilter": true, "aaSorting": [[0, "asc"]],
									"aoColumns": [ { "bSortable": false } ], 
									"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
									"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
									"sAjaxSource": "datatable-serverside/buscar_presentacion_consumible.php", 
									"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
									"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
									"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
									"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>TIPOS: _MAX_", "sSearch": "" }
								});//fin datatable
								$('#clickme_bpcon').click(function(e) { oTableBpresentacionC.fnDraw(); });
								
								$('.filtroBMC input').attr("placeholder", "BUSQUE UNA PRESENTACIÓN DEL CONSUMIBLE AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
								$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
								$('.filtroBMC input').css('width',($('#dialog-buscarAlgo1').width() * 1) ); $('.filtroBMC').css('left',-16);
								$("div.toolbarBMC").css('white-space','nowrap').css('border','1px none red').css('padding','0px');
								var tableBTC = $('#dataTableBpresentacionConsu').DataTable();
								$('#dataTableBpresentacionConsu tbody').on('click','tr',function(){
									if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
									else{
										tableBTC.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
										$('#errorSeleccionPconsumible').hide();
									}
								});
								
								$('#dataTableBpresentacionConsu tbody').on( 'click', 'tr', function () {
									var nTdsBcon = $('td', this), idTcon = $(nTdsBcon[0]).html().split('"'); //alert(idBase[2]);
									$('#id_presentacionCosumibleT').val(idTcon[1]);$('#presentacionC1T').val($(nTdsBcon[0]).text());
								}); 
					
							},
							close:function( event, ui ){ $("#dialog-buscarAlgo1").empty();}
						});
					}
					});
				}); // Fin botón para buscar la presentación del consumible
				
				$('#bUnidadCo').click(function(e) { //Botón para buscar la unidad del consumible de la base
					$("#dialog-buscarAlgo1").load("htmls/buscarUmedida.php #unidadMedidaB", function( response, status, xhr ){
					if ( status == "success" ){
						window.setTimeout(function(){
							$('#addUM').click(function(event) { event.preventDefault(); });
							$('#addUM').button({ icons: { primary: "ui-icon-plus" }, text: false });
							$('#addUM').css('width',cuad).css('height',cuad);
						},200);
						
						window.setTimeout(function(){
						$('#addUM').click(function(e) {
							$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaUnidadMedida',function(response,status,xhr){
								if ( status == "success" ) { $('#idUsuarioUM').val($('#idUser').val());
									$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
									$('#formNuevaUnidadMedida').validate();
									$('#dialog-nuevoItem').dialog({ 
										title: 'AGREGAR UNA NUEVA UNIDAD DE MEDIDA', modal: true, autoOpen: true, closeText: '', width: wi, height: 320, closeOnEscape: false, dialogClass: 'no-close',
										buttons: {
										"Guardar": function() {
										   if($('#formNuevaUnidadMedida').valid()){
												var idNUM = $('#formNuevaUnidadMedida').serialize();
												$.post('files-serverside/agregarNunidadMedida.php',idNUM).done(function(data){
													if(data == 1){ 
														$('#dialog-nuevoItem').dialog('close');
														$('#clickme_bum').click();
														$('#dialog-confirmacion').dialog({
															title: 'CONFIRMACIÓN', modal: true, 
															autoOpen: true, closeText: '', width: 600, height: 200, 
															closeOnEscape: false, dialogClass: 'no-close',
															open:function( event, ui ){
																$('#textoConfirmacion').text('LA NUEVA UNIDAD DE MEDIDA SE GUARDÓ SATISFACTORIAMENTE');
																window.setTimeout(function(){
																	$('#dialog-confirmacion').dialog('close');
																},2000);
															}
														});
													}else{alert(data);}
												});
										   }
										},
										"Cancelar": function() { $('#dialog-nuevoItem').dialog('close'); }
									  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
									  open:function( event, ui ){ }
									});
								}
							});
						});
						},500);
						
						$('#dialog-buscarAlgo1').dialog({ 
							title: 'UNIDADES DEL TIPO DE CONSUMIBLE',modal:true,autoOpen:true,closeText: '', width: wi, height: he, 
							closeOnEscape: true, dialogClass: '', buttons: { },
							buttons: {
								"Aceptar": function() { 
								   if($('.selected2').length >0){$('#errorSeleccionUmedida').hide();
									$('#id_umBasex').val($('#idUMbaseTx').val());//alert($('#id_umBasex').val());
									$('#unidadC1').val($('#unidadMedidaRTx').val());
									$('#dialog-buscarAlgo1').dialog('close');
								   }else{ $('#errorSeleccionUmedida').hide().show('shake'); }
								},
								"Cancelar": function() { $('#dialog-buscarAlgo1').dialog('close'); }
							},
							open:function( event, ui ){
								var oTableBumedida;
								oTableBumedida = $('#dataTableBunidadMedida').dataTable({
									"bJQueryUI": true, "bRetrieve": true, ordering: false,
									"sScrollY": $('#dialog-buscarAlgo').height()-100, "bStateSave": false, "bInfo": true, 
									"bFilter": true, "aaSorting": [[0, "asc"]],
									"aoColumns": [ { "bSortable": false }, { "bSortable": false } ], 
									"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
									"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
									"sAjaxSource": "datatable-serverside/buscar_unidades_medida.php", 
									"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
									"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
									"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADAS: _END_", 
									"sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>UNIDADES: _MAX_", "sSearch": "" }
								});//fin datatable
								$('#clickme_bum').click(function(e) { oTableBumedida.fnDraw(); });
								
								$('.filtroBMC input').attr("placeholder", "BUSQUE UNA UNIDAD DE MEDIDA DEL CONSUMIBLE, Y DELE CLIC PARA SEECCIONARLA...").addClass('placeHolder');
								$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
								$('.filtroBMC input').css('width',($('#dialog-buscarAlgo1').width() * 1) ); $('.filtroBMC').css('left',-16);
								$("div.toolbarBMC").css('white-space','nowrap').css('border','1px none red').css('padding','0px');
								var tableBUM = $('#dataTableBunidadMedida').DataTable();
								$('#dataTableBunidadMedida tbody').on('click','tr',function(){
									if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
									else{
										tableBUM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
										$('#errorSeleccionUmedida').hide();
									}
								});
								
								$('#dataTableBunidadMedida tbody').on( 'click', 'tr', function () {
									var nTdsBUM = $('td', this), idBase = $(nTdsBUM[0]).html().split('"'); //alert(idBase[1]);
									$('#idUMbaseTx').val(idBase[1]); $('#unidadMedidaRTx').val($(nTdsBUM[0]).text());
									//$('#abreviacionUMT').val($(nTdsBUM[1]).text()); //
									//alert($(nTdsBUM[0]).text());
								}); //con la clave del médico sacamos su id
					
							},
							close:function( event, ui ){ $("#dialog-buscarAlgo1").empty();}
						});
					}
					});
				}); // Fin botón para buscar la unidad del consumible de la base
							
				$('#bTipoCo').click(function(e) { //Botón para buscar los consumibles de las bases
					$("#dialog-buscarAlgo1").load("htmls/buscarTipoConsumible.php #tipoConsumibleB",function(response,status,xhr ){
					if ( status == "success" ){
						window.setTimeout(function(){
							$('#addTCon').click(function(event) { event.preventDefault(); });
							$('#addTCon').button({ icons: { primary: "ui-icon-plus" }, text: false });
							$('#addTCon').css('width',cuad).css('height',cuad);
						},200);
						
						window.setTimeout(function(){
						$('#addTCon').click(function(e) {
							$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevoTipoConsumible',function(response,status,xhr){
								if ( status == "success" ) { 
									$('#idUsuarioNI').val($('#idUser').val());
									$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
									$('#formNuevoItem').validate();
									$('#dialog-nuevoItem').dialog({ 
										title: 'AGREGAR UN NUEVO TIPO DE CONSUMIBLE', modal: true, autoOpen: true, closeText: '',
										width: wi, height: 280, closeOnEscape: false, dialogClass: 'no-close',
										buttons: {
										"Guardar": function() {
										   if($('#formNuevoItem').valid()){
												var idNUM = $('#formNuevoItem').serialize();
												$.post('files-serverside/agregarNtipoConsumible.php',idNUM).done(function(data){
													if(data == 1){ 
														$('#dialog-nuevoItem').dialog('close');
														$('#clickme_bum').click();
														$('#dialog-confirmacion').dialog({
															title: 'CONFIRMACIÓN', modal: true, 
															autoOpen: true, closeText: '', width: 600, height: 200, 
															closeOnEscape: false, dialogClass: 'no-close',
															open:function( event, ui ){
																$('#textoConfirmacion').text('EL NUEVO TIPO DE CONSUMIBLE SE GUARDÓ SATISFACTORIAMENTE');
																window.setTimeout(function(){
																	$('#dialog-confirmacion').dialog('close');
																},2000);
															}
														});
													}else{alert(data);}
												});
										   }
										},
										"Cancelar": function() { $('#dialog-nuevoItem').dialog('close'); }
									  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
									  open:function( event, ui ){ }
									});
								}
							});
						});
						},500);
						
						$('#dialog-buscarAlgo1').dialog({ 
							title: 'TIPOS DE CONSUMIBLES', modal: true, autoOpen: true, closeText: '', width: wi, height: he, 
							closeOnEscape: true, dialogClass: '', buttons: { },
							buttons: {
								"Aceptar": function() {
								   if($('.selected2').length >0){$('#errorSeleccionTconsumible').hide();
									$('#id_tipoCosumible').val($('#id_tipoCosumibleT').val());
									$('#tipoC1').val($('#tipoC1T').val());
									$('#dialog-buscarAlgo1').dialog('close');
								   }else{ $('#errorSeleccionTconsumible').hide().show('shake'); }
								},
								"Cancelar": function() { $('#dialog-buscarAlgo1').dialog('close'); }
							},
							open:function( event, ui ){
								var oTableBtipoC;
								oTableBtipoC = $('#dataTableBtipoConsumible').dataTable({
									"bJQueryUI": true, "bRetrieve": true, ordering: false,
									"sScrollY": $('#dialog-buscarAlgo').height()-100, "bStateSave": false, "bInfo": true, 
									"bFilter": true, "aaSorting": [[0, "asc"]],
									"aoColumns": [ { "bSortable": false } ], 
									"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
									"sDom": '<"toolbarBMC"><"filtroBMC"f>lr<"data_tBMC"t><"infoBMC"i>S', 
									"sAjaxSource": "datatable-serverside/buscar_tipos_consumibles.php", 
									"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
									"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
									"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
									"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>TIPOS: _MAX_", "sSearch": "" }
								});//fin datatable
								$('#clickme_btco').click(function(e) { oTableBtipoC.fnDraw(); });
								
								$('.filtroBMC input').attr("placeholder", "BUSQUE UN UN TIPO DE CONSUMIBLE AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
								$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
								$('.filtroBMC input').css('width',($('#dialog-buscarAlgo1').width() * 1) ); $('.filtroBMC').css('left',-16);
								$("div.toolbarBMC").css('white-space','nowrap').css('border','1px none red').css('padding','0px');
								var tableBTC = $('#dataTableBtipoConsumible').DataTable();
								$('#dataTableBtipoConsumible tbody').on('click','tr',function(){
									if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
									else{
										tableBTC.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
										$('#errorSeleccionTconsumible').hide();
									}
								});
								
								$('#dataTableBtipoConsumible tbody').on( 'click', 'tr', function () {
									var nTdsBcon = $('td', this), idTcon = $(nTdsBcon[0]).html().split('"'); //alert(idBase[2]);
									$('#id_tipoCosumibleT').val(idTcon[1]); $('#tipoC1T').val($(nTdsBcon[0]).text());
								}); 
					
							},
							close:function( event, ui ){ $("#dialog-buscarAlgo1").empty();}
						});
					}
					});
				}); // Fin botón para buscar los consumibles de las bases
}
function fichaCondi(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaCondicionMuestra',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNI').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevoItem').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DE LA CONDICIÓN '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 290,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevoItem').valid()){
						var idNC = $('#formNuevoItem').serialize();
						$.post('files-serverside/actualizarCondicion.php?idCo='+id,idNC).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bcon').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('LA CONDICIÓN DE LA MUESTRA SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoAddCondicion').hide();
			  	var idCondic = {idCo : id}
				$.post('files-serverside/datosFichaCo.php',idCondic).done(function(data){
					var datos = data.split('{;]');
					$('#nombreCM').val(datos[0]);
				});  
			  }
			});
		}
	});
}

function fichaMeto(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevoMetodo',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevoMetodo').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DEL MÉTODO '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 210,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevoMetodo').valid()){
						var idMet = $('#formNuevoMetodo').serialize();
						$.post('files-serverside/actualizarMetodo.php?idMe='+id,idMet).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickmeMeSB').click();
								$('#clickme_bmet').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL MÉTODO SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoMetodo').hide();
			  	var idMetod = {idMe : id}
				$.post('files-serverside/datosFichaMet.php',idMetod).done(function(data){
					var datos = data.split('{;]');
					$('#nombreM').val(datos[0]);
				});  
			  }
			});
		}
	});
}
function fichaIndi(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaIndicacion',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevaIndicacion').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DE LA INDICACIÓN '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 280,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevaIndicacion').valid()){
						var idInd = $('#formNuevaIndicacion').serialize();
						$.post('files-serverside/actualizarIndicacion.php?idIn='+id,idInd).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bIndi').click();
								$('#clickmeImSB').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('LA INDICACIÓN SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoIndicacion').hide();
			  	var idIndic = {idIn : id}
				$.post('files-serverside/datosFichaInd.php',idIndic).done(function(data){
					var datos = data.split('{;]');
					$('#nombreM').val(datos[0]);
				});  
			  }
			});
		}
	});
}
function fichaTCon(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevoTipoConsumible',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNI').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevoItem').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DEL TIPO DE CONSUMIBLE '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 280,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevoItem').valid()){
						var idCons = $('#formNuevoItem').serialize();
						$.post('files-serverside/actualizarTipoConsumible.php?idCo='+id,idCons).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_btco').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL TIPO DE CONSUMIBLE SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoAddTipoConsumible').hide();
			  	var idTconsu = {idTco : id}
				$.post('files-serverside/datosFichaTconsu.php',idTconsu).done(function(data){
					var datos = data.split('{;]');
					$('#tipoC').val(datos[0]);
				});  
			  }
			});
		}
	});
}
function fichaPresentacionC(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevaPresentacionCons',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNI').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevaPresentacionConsumible').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DE LA PRESENTACIÓN  '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 280,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevaPresentacionConsumible').valid()){
						var idPreC = $('#formNuevaPresentacionConsumible').serialize();
						$.post('files-serverside/actualizarPresentacionC.php?idPr='+id,idPreC).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bpcon').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('LA PRESENTACIÓN SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				$('#textoAddPresentacionConsumible').hide();
			  	var idPconsu = {idPco : id}
				$.post('files-serverside/datosFichaPresentacionConsu.php',idPconsu).done(function(data){
					var datos = data.split('{;]');
					$('#presentacionC').val(datos[0]);
				});  
			  }
			});
		}
	});
}
function fichaConsu(id, nombre){
	$("#dialog-nuevoItem").load('htmls/ficha_base.php #nuevoConsumible',function(response,status,xhr){
		if(status == "success"){$('#idUsuarioNM').val($('#idUser').val());
			$('#dialog-nuevoItem input, #dialog-nuevoItem select, #dialog-nuevoItem textarea').addClass('campoITtab'); 
			$('#formNuevoConsumible').validate();
			var wi = $('#referencia').width() * 0.98;
			$('#dialog-nuevoItem').dialog({ 
				title: 'FICHA DEL CONSUMIBLE  '+nombre, modal: true, autoOpen: true, closeText: '', width: wi, height: 430,
				closeOnEscape: false, dialogClass: 'no-close',
				buttons: {
				"Actualizar": function() {
				   if($('#formNuevoConsumible').valid()){
						var idConsu = $('#formNuevoConsumible').serialize();
						$.post('files-serverside/actualizarConsumible.php?idCo='+id,idConsu).done(function(data){
							if(data == 1){ 
								$('#dialog-nuevoItem').dialog('close');
								$('#clickme_bConsu').click();
								$('#dialog-confirmacion').dialog({
									title: 'CONFIRMACIÓN', modal: true, 
									autoOpen: true, closeText: '', width: 600, height: 200, 
									closeOnEscape: false, dialogClass: 'no-close',
									open:function( event, ui ){
										$('#textoConfirmacion').text('EL CONSUMIBLE SE ACTUALIZÓ SATISFACTORIAMENTE');
										window.setTimeout(function(){
											$('#dialog-confirmacion').dialog('close');
										},2000);
									}
								});
							}else{alert(data);}
						});
				   }
				},
				"Cerrar": function() { $('#dialog-nuevoItem').dialog('close'); }
			  }, close:function( event, ui ){ $('#dialog-nuevoItem').empty(); },
			  open:function( event, ui ){
				  
				$('#textoConsumible').hide();
			  	var idconsum = {idConsimi : id}
				$.post('files-serverside/datosFichaConsumible.php',idconsum).done(function(data){
					juanchi();
					var datos = data.split('{;]');
					$('#nombreC').val(datos[0]);
					$('#descripcionC').val(datos[1]);
					$('#id_tipoCosumible').val(datos[2]);
					$('#tipoC1').val(datos[3]);
					$('#id_umBasex').val(datos[4]);
					$('#unidadC1').val(datos[5]);
					$('#id_presentacionCosumible').val(datos[6]);
					$('#presentacionC1').val(datos[7]);
				});  
			  }
			});
		}
	});
}



function checarHayReferencia(noAleatorio){ $(document).ready(function(e) { var datosChecaReferencia = {noAleatorio:noAleatorio}
  $.post('files-serverside/checarHayReferencias.php',datosChecaReferencia).done(function(data){if(data>0){$('#errorSeleccionReferencias').hide();$('#dialog-catalogos').dialog('close');$('#clickmeRe').click();}else{$('#errorSeleccionReferencias').hide().show('shake');}}); 
});}
function checarHayConsumible(noAleatorio){ $(document).ready(function(e) { var datosChecaConsumible = {noAleatorio:noAleatorio}
  $.post('files-serverside/checarHayConsumibles.php',datosChecaConsumible).done(function(data){if(data>0){$('#errorSeleccionConsumibles').hide();$('#dialog-catalogos').dialog('close');$('#clickmeCo').click();}else{$('#errorSeleccionConsumibles').hide().show('shake');}}); 
});}
function checarHayIndicacion(noAleatorio){ $(document).ready(function(e) { var datosChecaindicacion = {noAleatorio:noAleatorio}
  $.post('files-serverside/checarHayIndicaciones.php',datosChecaindicacion).done(function(data){if(data>0){$('#errorSeleccionIndicaciones').hide();$('#dialog-catalogos').dialog('close');$('#clickmeMet').click();}else{$('#errorSeleccionIndicaciones').hide().show('shake');}}); 
});}
function checarHayMetodo(noAleatorio){ $(document).ready(function(e) { var datosChecaMetodos = {noAleatorio:noAleatorio}
	$.post('files-serverside/checarHayMetodos.php',datosChecaMetodos).done(function( data ) { if(data >0){$('#errorSeleccionMetodos').hide();  $('#dialog-catalogos').dialog('close'); $('#clickmeMet').click(); }else{ $('#errorSeleccionMetodos').hide().show('shake'); } }); 
});}
function checarHayMuestras(noAleatorio){ $(document).ready(function(e) { var datosChecaMuestras = {noAleatorio:noAleatorio}
	$.post('files-serverside/checarHayMuestras.php',datosChecaMuestras).done(function( data ) { if(data >0){$('#errorSeleccionMuestras').hide();  $('#dialog-catalogos').dialog('close'); $('#clickmeMu').click(); }else{ $('#errorSeleccionMuestras').hide().show('shake'); } }); 
});}
</script>

<script>
$(document).ready(function(e) { $('#miMenu').hide(); $('#verMenu').click(function(e) { verMenu(); }); });
function verMenu(){ $(document).ready(function(e) { $('#miMenu').show('fold','slow'); $('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">BASES</span>'); }); }
function ocultarMenu(){ $(document).ready(function(e) { $('#miMenu').hide('fold','slow'); $('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">BASES</span>'); }); }
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>">
<input name="filtro" id="filtro" type="hidden" value="YO SOLO SE QUE NO SE NADA">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../../imagenes/iconitos/_bases.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">BASES DE LABORATORIO</span></td>
        <td width="1%" nowrap valign="middle">
        	<span id="dispara_menu">
            	<?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="21">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="21">
                <?php }?>
            	<?php echo $row_usuario['usuario_u']; ?> <span class="ui-icon ui-icon-triangle-1-s"></span>
            </span>
        </td>
        <td width="100" nowrap align="left"> </td>
      </tr>
    </table>
</div>

<div class="contenido" id="contenido" align="center">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr class="titulos_dataceldas">
        <th id="unoB">BASE</th>
        <th>AREA</th>
        <th >UNIDAD</th>
        <th nowrap width="150">$ PRODUCCIÓN</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr>
        <td>
        <input name="sBase" id="sBase" type="text" value="Nombre de la base" class="search_init" style="width:90%;" />
        </td>
        <td>
        <input name="sArea" id="sArea" type="text" value="Área" class="search_init" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente2" id="sPaciente2" type="hidden" class="search_init" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente3" id="sPaciente3" type="hidden" class="search_init" style="width:90%;" />
        </td>
        </tr>
    </tfoot>
  </table>
</div>

<div id="dialog-confirmarNuevoPaciente" style="display:none; overflow:hidden;"> </div>

<div id="dialog-catalogos" style="display:none; overflow:hidden;"> </div>

<div id="dialog-updates" style="display:none; overflow:hidden;"> </div>

<div id="dialog-nuevoItem" style="display:none; overflow:hidden; background-size:contain;"> </div>

<div id="dialog-nuevoItem1" style="display:none; overflow:hidden; background-size:contain;"> </div>

<div id="dialog-confirmaAltaPaciente" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle" height="100%">LOS DATOS DEL ESTUDIO SE HAN GUARDADO SATISFACTORIAMENTE</td> </tr> </table></div>

<div id="dialog-verPaciente" align="right" style="display:none;"> </div>

<div class="footer" id="footer" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle"> &copy; GLOSS <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </td> </tr> </table> </div>

<div id="dialog-buscarAlgo" style="display:none;"> </div>

<div id="dialog-buscarAlgo1" style="display:none;"> </div>

<div id="dialog-confirmacion" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle" height="100%" id="textoConfirmacion"> </td> </tr> </table></div>

</body>
</html>

<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
?>

<script type="text/javascript">

$(document).ready(function() {
	var asInitVals = new Array();
	//fin para filtro individual por campo de texto
	var oTableP;
	var tamP = $('#referencia').height() - $('#header').height() - 115;
	oTableP = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
		"bJQueryUI": true, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, "bStateSave": false, "bInfo": true,
		"bFilter": true, ordering: false, "iDisplayLength": 500, "aaSorting": [[0, "desc"]], 
		"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
		"bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": '<"toolbar"><"filtro1Principal">lr<"data_tPrincipal"t><"infoPrincipal"i>S',
		"sAjaxSource": "datatable-serverside/bases.php",
		"fnServerParams":function(aoData, fnCallback){ var de=$('#filtro').val();aoData.push({"name": "nombre", "value": de });},
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "ENCONTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>TOTAL DE BASES: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
      		}
		}
	}); $('#unoB').click(function(e) { oTableP.fnDraw(); });
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { oTableP.fnFilter( this.value, $("tfoot input").index(this) ); } );
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = "";} } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)]; } } );
	//fin filtros individuales por campo de texto

	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td><button id='addPacientePrincipal' onClick='nuevoPaciente()' class='ui-button ui-widget ui-corner-all' title='Agregar un nuevo estudio'><span class='ui-icon ui-icon-plus'></span></button></td> </tr> </table></div>" );
	//$('#addPacientePrincipal').css('height', $('.filtro1Principal input').height());
	$('.filtro1Principal input').attr("placeholder", "PARA EMPEZAR, BUSQUE UNA BASE AQUÍ...").addClass('placeHolder');
	
	//ponemos los botones de reset y de añadir un paciente de la tabla principal de busqueda de pacientes
	$("div.toolbar").css('white-space','nowrap').css('border','1px none red').css('padding','0px');
	
	if($('.filtro1Principal input').val() ==''){ $('#filtro').val('YO SOLO SE QUE NO SE NADA');
	}else{ $('#filtro').val('%%');oTableP.fnDraw(); }
	
	$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
	$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
		
	window.setTimeout(function(){
		$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
		$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
	},300);
	
	$( window ).resize(function() {
		$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
		$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
	});
	
	var search_boxP = $('.filtro1Principal input');
	var busquedaP = $('.filtro1Principal');
	var data_tP = $('#dataTable tbody');
	var div_botonesP = $('.botonesPrincipal');
	var paginacionesP = $('.paginacionPrincipal');
	var cabeceraP = $('#cabecera_tBusquedaPrincipal');
	
	$('#addPacientePrincipal').hide();
	
	if($('.filtro1Principal input').val() ==''){
		div_botonesP.hide(); $('#addPacientePrincipal').hide();
	}else{
		div_botonesP.show(); $('#addPacientePrincipal').show();
	}
	
	paginacionesP.hide();
	
	search_boxP.focus();
	
	search_boxP.keyup(function(e) {
    	if( $(this).val() == '' ){
			$('#filtro').val('YO SOLO SE QUE NO SE NADA');
			div_botonesP.hide();
			$('#addPacientePrincipal').hide();
			oTableP.fnDraw();
		}else {
			$('#filtro').val('%%');
			div_botonesP.show();
			$('#addPacientePrincipal').show();
			oTableP.fnDraw();
		}
    });
		
	$('#clickme').click(function(e) { oTableP.fnDraw(); });

});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
	var wi1 = $('#referencia').width() * 0.97;
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){
			$('#dialog-confirmarNuevoPaciente').dialog('close');
			window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500);
		}
	});
    $('#dialog-verPaciente').dialog({autoOpen:false,modal:true,width:wi1,height:he1, title: 'FICHA DEL ESTUDIO', closeText: '' });
});
</script>

<script>
function verPaciente(x){//x es el id del Estudio q seleccionamos
 $(document).ready(function(e) {
	$('#idPacienteN').val(x);//asignamos el id del estudio a la variable para saber cual paciente actualizar por su id
	 var datos ={idP:x}
	 $.post('files-serverside/fichaEstudio.php',datos).done(function( data1 ) {
		if (data1 != "ok"){
			var datosI = data1.split('*}');
			//
			var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - $('.botones').height() - 20;
			var wi = $('#referencia').width() * 0.96;
			var title = 'FICHA DEL ESTUDIO. '+datosI[1];
			$('#dialog-confirmarNuevoPaciente').dialog({
				title:title,modal: true, autoOpen: false, closeText: '', width: wi, height: he, closeOnEscape: true, dialogClass: '',
				buttons: {
				"ACTUALIZAR": function() {
					if($('#formGenerales').valid()){
						$('#miDiagnostico').val($('.jqte_editor').html());
						var datosP = $('#formGenerales').serialize();
						$.post('files-serverside/updateEstudio.php',datosP).done(function( data ) {
							if (data==1){//si el paciente se Actualizó 
								$('#dialog-confirmarNuevoPaciente').dialog('close');$('#clickme').click();
								$('#dialog-confirmaAltaPaciente').dialog('open');
							}
							else{alert(data);}
						});
					}
				},
				"CERRAR": function() { $(this).dialog('close'); }
			  },
			  open:function( event, ui ){
					$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
					$('#dialog-confirmarNuevoPaciente textarea').css('height','99%');
					$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
					
					//datos generales
					$('#nombreP').val(datosI[1]);$("#departamentoE").val(datosI[4]);$('#edadP').val(datosI[2]);
					$('#telmovilP').val(datosI[0]);$('#telparticularP').val(datosI[3]);
						//$('#areasE').val(datosI[5]);
					$('#input').jqte();
					$('#input').jqteVal(datosI[6]);
					window.setTimeout(function(){
						$('#input').jqte();
						$('#input').jqteVal(datosI[6]);
					},600);					
					
				},
				close:function( event, ui ){
					document.getElementById('formGenerales').reset();
					$('form label.error').hide();
					$('#input').jqteVal('');
					$('.jqte_editor').css('height',$('#dialog-confirmarNuevoPaciente').height()*0.7);
				}
			});
			window.setTimeout(function(){$('.jqte_editor').css('height',$('#dialog-confirmarNuevoPaciente').height()*0.7);},200);
			$('#dialog-confirmarNuevoPaciente').dialog('open');
		}else{alert(data);}
	});
 });
}//fin verPaciente

</script>
