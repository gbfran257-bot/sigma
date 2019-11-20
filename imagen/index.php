<?php require_once('../Connections/horizonte.php'); ?>
<?php
//initialize the session
ini_set("session.cookie_lifetime","7200");
ini_set("session.gc_maxlifetime","7200");
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
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) { header("Location: $logoutGoTo"); exit;}
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

$MM_restrictGoTo = "../index.php";
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

mysql_select_db($database_horizonte, $horizonte);
$query_fechaRangoInicial = "SELECT fecha_venta_vc FROM venta_conceptos where tipo_concepto_vc = 3 ORDER BY fecha_venta_vc ASC limit 1";
$fechaRangoInicial = mysql_query($query_fechaRangoInicial, $horizonte) or die(mysql_error());
$row_fechaRangoInicial = mysql_fetch_assoc($fechaRangoInicial);
$totalRows_fechaRangoInicial = mysql_num_rows($fechaRangoInicial);

mysql_select_db($database_horizonte, $horizonte);
$query_fechaRangoFinal = "SELECT fecha_venta_vc FROM venta_conceptos where tipo_concepto_vc = 3 ORDER BY fecha_venta_vc DESC limit 1";
$fechaRangoFinal = mysql_query($query_fechaRangoFinal, $horizonte) or die(mysql_error());
$row_fechaRangoFinal = mysql_fetch_assoc($fechaRangoFinal);
$totalRows_fechaRangoFinal = mysql_num_rows($fechaRangoFinal);
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/favicon.ico">
<meta charset="utf-8">
<title>RESULTADOS IMAGENOLOGÍA</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../funciones/js/jquery.media.js"></script> 
<script src="../funciones/js/stdlib.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>
<script src='../tinymce/tinymce.min.js'></script>

<script>
$(document).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });

$(document).ready(function(e) {
	//Refrescamos la sesión para que no caduque
	setInterval(function(){$.post('../remote_files/refresh_session.php');},500000);
	
	$('#verMenu').click(function(e){window.location='../menu.php?menu=mi';}); 
	
	var i = 1;
	
	$('#dispara_menu').click(function(e) { i++;
		if(i%2==0){
			$('#header').after('<div id="div_menu" class="ver_menu" style="border:1px none red; z-index:1000000000000; position:fixed; width:240px;"><table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="left"><ul id="menu_u1" style="border-bottom-left-radius:4px;border-bottom-right-radius:4px;"><li><div id="mi_perfil"><span class="ui-icon ui-icon-person"></span> Mi perfil</div></li><li><div><span class="ui-icon ui-icon-gear"></span> Configuración</div></li><li><div><span class="ui-icon ui-icon-power"></span> <a href="<?php echo $logoutAction ?>">Cerrar sesión</a></div></li><li><div id="ayuda"><span class="ui-icon ui-icon-info"></span> Ayuda</div></li><li><div id="reportar_problema"><span class="ui-icon ui-icon-wrench"></span> Reportar problema</div></li><li><div id="politicas_condiciones"><span class="ui-icon ui-icon-script"></span> Políticas y condiciones</div></li><li><div id="aviso_privacidad"><span class="ui-icon ui-icon-alert"></span> Aviso de privacidad</div></li><li><div id="acerca_de"><span class="ui-icon ui-icon-star"></span> Acerca de</div></li><li><div id="mi_chat"><span class="ui-icon ui-icon-comment"></span> Chat</div></li></ul></td></tr></table></div>');
			$('#div_menu').css('top',$('#header').height()+0); $('#menu_u1').menu(); 
			$('#mi_perfil').click(function(e){ window.location="../usuarios/perfil.php"; });
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
	
});

//para fintro individual por campo de texto
var asInitVals = new Array();
//fin para filtro individual por campo de texto
$(document).ready(function() { var tam = $('#referencia').height() - 150;
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { myFunction(); },
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
		"bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[1, "asc"]], ordering: false,
		"aoColumns": [
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false}/*para covadonga ,{"bSortable":false} para covadonga*/
		],
		"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>', 
		"sAjaxSource": "datatable-serverside/estudios.php",
		"fnServerParams": function (aoData, fnCallback) {
			   var de = document.getElementById('fechaDe').value+' 00:00:00', a = $('#fechaA').val()+' 23:59:59';
			   var acceso = $('#accesoU').val();
			   var idU = $('#idUser').val(); var sucu = $('#idSuU').val();
               aoData.push(  {"name": "min", "value": de } ); 
			   aoData.push(  {"name": "max", "value": a } );
			   aoData.push(  {"name": "acceso", "value": acceso } ); 
			   aoData.push(  {"name": "idU", "value": idU } );
			   aoData.push(  {"name": "sucu", "value": sucu } ); 
        },
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
		"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "&nbsp;TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw(); myFunction(); });
	
	//para los fintros individuales por campo de texto
	$("tfoot input.pat").keyup( function () { oTable.fnFilter( this.value, $("tfoot input.pat").index(this) ); } );
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in * the footer */
    $("tfoot input.pat").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input.pat").focus(function(){if(this.className=="pat"){this.className = ""; this.value = "";myFunction(); } } );
     
    $("tfoot input.pat").blur( function (i) { if ( this.value == "" ) { this.className = "pat"; this.value = asInitVals[$("tfoot input.pat").index(this)];myFunction(); } } );
	//fin filtros individuales por campo de texto
		
	$('#radio1').click(function(e) {
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>');
		oTable.fnDraw();
    });
	$('#radio2').click(function(e) {
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>');
		oTable.fnDraw();
    });
	$( "#fechaDe" ).datepicker({
	  	defaultDate: "-1", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); },
		"onSelect": function(date) {
      		min = date+' 00:00:00';//new Date(date).getTime();
      		oTable.fnDraw();
    	}
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({
		defaultDate: "+0", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); },
		"onSelect": function(date) {
      		max = date+' 23:59:59';//new Date(date).getTime();
      		oTable.fnDraw();
    	}
	}).css('max-width','100px');
			
});
  </script>
<script>
jQuery(function($){
    $.datepicker.regional['es'] = {//dateFormat: 'mm/dd/yy',
        closeText: 'Cerrar', changeMonth: true, changeYear: true, numberOfMonths: 3, dateFormat: "yy-mm-dd", prevText: '&#x3c;Ant', nextText: 'Sig&#x3e;', currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun', 'Jul','Ago','Sep','Oct','Nov','Dic'], 
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'], dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'], weekHeader: 'Sm',
        firstDay: 1, isRTL: false, showMonthAfterYear: false,
    yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});
$(document).ready(function(e) {
	var divRangoFechas = $('#divRangoFechas');
	divRangoFechas.css('width','80%').css('float','left').css('border-width','1px').css('border-style','none').css('color','white'); 
	
	$( '#rangosFechas' ).buttonset().css('font-size','0.9em');
	$('.rad').css('font-size','0.8em');//$('#input').jqte();
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="nombreTempPdf" id="nombreTempPdf" type="hidden" value="">
<input name="id_vc_ini" id="id_vc_ini" type="hidden" value="">
<input name="usuario_ini" id="usuario_ini" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
<input name="campoUrl" id="campoUrl" type="hidden" value="">
<input name="idSuU" type="hidden" id="idSuU" value="<?php echo $row_usuario['idSucursal_u']; ?>">

<div id="header" class="header ver_menu">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoEstudios.png" height="40"></td>
        <td align="left" valign="middle" nowrap><span id="verMenu" style="cursor:pointer;">ESTUDIOS DE IMAGENOLOGÍA</span></td>
        <td width="1%" nowrap valign="middle">
        	<span id="dispara_menu">
            	<?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="21">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="21">
                <?php }?>
            	<?php echo $row_usuario['usuario_u']; ?> <span class="ui-icon ui-icon-triangle-1-s"></span>
            </span>
        </td>
        <td width="100" nowrap align="left"> </td>
      </tr>
    </table>
</div>

<div class="contenido" id="contenido" align="center" style="padding-top:3px;">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr class="titulos_dataceldas">
        <th id="clickme">#</th>
        <th>PACIENTE</th>
        <th width="100" nowrap>REFERENCIA</th>
        <th>ESTUDIO</th>
     	<th width="50" nowrap>ESTATUS</th>
        <th>ASIGNAR</th>
		<th>EDITAR</th>
        <th>ID-PACS</th>
        <th width="80" nowrap>ÁREA</th>
        <th width="50" nowrap>SUCURSAL</th>
        <th width="50" nowrap>FOTOS</th>
        <!--para covadonga <th width="80" nowrap>PROCEDENCIA</th> para covadonga-->
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr>
        <td><input name="sPaciente0" id="sPaciente0" type="hidden" class="search_init pat" /></td>
        <td>
        <input name="sPaciente" id="sPaciente" type="text" placeholder="-Paciente-" class="search_init pat" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente1" id="sPaciente1" type="text" placeholder="-Referencia-" class="search_init pat" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente2" id="sPaciente2" type="text" placeholder="-Estudio-" class="search_init pat" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente3" id="sPaciente3" type="text" placeholder="-Estatus-" class="search_init pat" style="width:90%;" />
        </td>
        <td><input name="sPaciente4" id="sPaciente4" type="hidden" class="search_init pat" style="width:90%;" /></td>
        <td><input name="sPaciente5" id="sPaciente5" type="hidden" class="search_init pat" style="width:90%;" /></td>
        <td>
        </td>
        <td>
        <input name="sPaciente9e" id="sPaciente9e" type="hidden" class="search_init pat" style="width:90%;" />
        <input name="sPaciente10" id="sPaciente10" type="text" placeholder="-Área-" class="search_init pat" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente11" id="sPaciente11" type="text" placeholder="-Sucursal-" class="search_init pat" style="width:90%;" />
        </td>
        <td><input name="sPaciente12" id="sPaciente12" type="hidden" class="search_init pat" /></td>
        <!--para covadonga <td>
        <input name="sPacie13" id="sPacie13" type="text" placeholder="-Procedencia-" class="search_init pat" style="width:90%;" />
        </td> para covadonga-->
        </tr>
    </tfoot>
  </table>
  
  <div id="divRangoFechas"><table height="1px" width="100%" border="0" cellpadding="3" cellspacing="0" style="color:black;">
  <tr>
    <td>De</td> 
    <td><input name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td>A</td> 
    <td><input name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td width="180" id="rangosFechas" nowrap style="white-space:nowrap;">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td width="99%"></td>
  </tr>
</table>
</div>
    
</div>

<div class="dialogos" id="dialog-upload" title="INTERPRETACIÓN"> <span id="spanDialog"></span>
  <iframe id="miFrame" allowtransparency="yes" frameborder="0" src="../editorTexto/Untitled-3.php" style="width:850px; height:440px;"></iframe>
</div>

<div id="dialog-captura" class="dialogos"> </div>

<div id="dialog-confirmCaptura" class="dialogos">
<input name="preImprimir" id="preImprimir" type="hidden">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td>¡El resultado del estudio se ha guardado satisfactoriamente!</td> </tr>
  <tr> <td style="color:red;">Recomendamos que confirme de inmediato el resultado interpretándolo... Se abrirá la ventana de interpretación.</td> </tr>
</table>
</div>

<div id="dialog-alertar" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoAlertar">¡Lo sentimos, usted no puede realizar esta acción!</td> </tr>
</table>
</div>

<div id="dialog-confirmacion" classs="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoConfirma">¡El estudio se ha transferido satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-confirmInterpretacion" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td align="center">¡El estudio se ha finalizado satisfactoriamente!</td> </tr>
  <tr> <td align="center">¿Desea imprimir el resultado del estudio de una vez?</td> </tr>
</table>
</div>

<div id="dialog-confirmaAsignaPacs" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td align="center">¡El estudio se ha asignado al PACS satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-transferir" class="dialogos"> </div>

<div id="dialog-editar" class="dialogos"></div>

<div id="dialog-impresion" class="dialogos"> </div>

<div id="dialog-est" class="dialogos"> </div>
<input name="titleEst" id="titleEst" value="" type="hidden">
<input name="fechaEst" id="fechaEst" value="" type="hidden">
<input name="idEstVC" id="idEstVC" value="" type="hidden">
<input name="idPacsVC" id="idPacsVC" value="" type="hidden">
<input name="pkPacs" id="pkPacs" value="" type="hidden">

<div id="dialog-procesar" class="dialogos"> </div>

<div id="dialog-medico" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td>Sólo un <strong>médico</strong> puede realizar esta acción.</td> </tr>
</table>
</div>

<div id="dialog-noest" class="dialogos"> </div>

<div id="dialog-confirmarAlgo" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td align="center" valign="middle"><span id="textoAlgo"></span></td> </tr> </table> </div>

<div id="dialog-cancelAlgo" class="dialogos">
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> 
    <tr> <td align="center" id="textoCancelaAlgo"> </td> </tr>
    <tr> <td align="center">
    	<span style="float:left;">Confirmar <input name="confirmaCOV" id="confirmaCOV" type="checkbox" value=""></span>
        <span id="debeConfirmarCOV" style="font-size:0.8em; color:red; display:none;">¡Debe confirmar!</span>
    </td> </tr> 
    </table>
</div>

<div id="dialog-nivel1" class="dialogos"></div> 
<div id="dialog-nivel2" class="dialogos"></div>
<div id="dialog-nivel3" class="dialogos"></div>
<div id="dialog-auxiliar" class="dialogos"></div>

</body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
mysql_free_result($fechaRangoInicial);
mysql_free_result($fechaRangoFinal);
?>
<script>
function All(){ $(document).ready(function(e) { $('#myCli').click(); }); }

$(document).ready(function(e) {
	var tamHX = $('#referencia').height() - 100, tamWX = $('#referencia').width() * 0.98;
	
	$('#dialog-procesar').dialog({ 
		autoOpen: false, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', 
		title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close' 
	});
		
});
function myFunction(){
 setTimeout(function(){
	$(document).ready(function(e) {
		var allBotonesIcono = $('.botonaso'); allBotonesIcono.css('width','25px').css('height','25px');
		
		$('.icono_proceso').button({ icons: { primary: "ui-icon-gear"}, text: false });
        $('.icono_realizado').button({ icons: { primary: "ui-icon-gear"}, text: false });
	    $('.icono_capturado').button({ icons: { primary: "ui-icon-document"}, text: false });
	    $('.icono_interpretado').button({ icons: { primary: "ui-icon-check"}, text: false });
		$('.icono_imprimir').button({ icons: { primary: "ui-icon-print"}, text: false });
		$('.icono_transfer').button({ icons: { primary: "ui-icon-transferthick-e-w"}, text: false });
		$('.icono_editar').button({ icons: { primary: "ui-icon-pencil"}, text: false });
		$('.miPDF').button({ icons: { primary: "ui-icon-document"}, text: false });
		$('.updatePDF').button({ icons: { primary: "ui-icon-refresh"}, text: false });
		
		$('.botonaso').click(function(event) { event.preventDefault(); });
	});
 },9);
}//fin myFunction
</script>
<script>
    $(function() {
		
	$('#dialog-alertar').dialog({
		autoOpen: false, modal: true, width: 600, height: 150, resizable: false, closeOnEscape: true, 
		closeText:'', title: "ACCESO DENEGADO", dialogClass: '',
		open: function( event, ui ) { window.setTimeout(function(){$('#dialog-alertar').dialog('close');},2000); }
	});
	
        $( "#dialog-upload" ).dialog({
            autoOpen:false, show:"blind", modal:true, width:900, height:650, hide:"explode", resizable:false, closeOnEscape:false,
			buttons: {
				"Guardar": function() {
					var datox ={estatus:'ENTREGADO', interpretacion:window.frames.miFrame.hola(), id_vc_ini:$('#id_vc_ini').val(), usuario_ini:$('#usuario_ini').val()}
					$.post('archivos_save_ajax/edoPendienteAentregado.php', datox, processData);
					function processData(data) { console.log(data);
						if (data == "ok"){$( this ).dialog( "close" );}else{alert(data);}
					}
				}, "Cancelar": function() { $( this ).dialog( "close" ); }
			},
        });
		$('#upload_button1').button({ icons: { primary: "ui-icon-folder-open" } });
    });//fin ready

function firstC(a){$(document).ready(function(e) {
	var idE = {idE1:a}
	$.post('files-serverside/datosInterpretarABC.php',idE).done(function( data ) {//alert(data);
		var dataE = data.split(';*-'); //alert(dataE[17]);
		var links = dataE[17].split('*');
		
		for(var i = 0; i<dataE[16]; i++){
			var ka = '<a href='+links[i]+' class="miApend" id="myOsirixL"><img src="../imagenes/osirix.png"></a>'
			$('#myOsirixL').append(ka);
			if(i+1 == dataE[16]){ $('.miApend img').each(function(index, element){ $(this).click(); }); }
		}
	});
});}
</script>
