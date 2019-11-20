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
$(document).ready(function() { var tam = $('#referencia').height() - 140;
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { myFunction(); },
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
		"bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[1, "asc"]], ordering: false,
		"aoColumns": [
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false}/*para covadonga,{"bSortable":false} para covadonga*/
		],
		"iDisplayLength": 1000000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>', 
		"sAjaxSource": "datatable-serverside/estudiosx.php",
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
    <td width="160" id="rangosFechas" nowrap>
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

<div id="dialog-editar" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr> <td align="justify">Esta seguro de querer editar la interpretación del estudio <span class="estudioEdit"></span> de la referencia <span class="referenciaEdit"></span> del paciente <span class="pacienteEdit"></span>?</td> </tr>
  <tr> <td align="left">
  	Confirmar <input name="editarInterpretacionC" type="checkbox" value="" id="editarInterpretacionC">
  </td> </tr>
  <tr> <td align="center" style="font-size:0.7em; color:red;">
  	<span style="display:none;" id="errorEditar">Debe confirmar la instrucción.</span>
  </td> </tr>
</table>
</div>

<div id="dialog-impresion" class="dialogos"> </div>

<div id="dialog-est" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="3" style="border-radius:4px;">
  <tr> 
  	<td width="1px" nowrap class="titulosTabla">PACIENTE</td> 
    <td align="left" colspan="3"> 
     <input class="campoDatosTabla" name="paciente_est" id="paciente_est" type="text" readonly style="text-align:left; width:99%;"> 
    </td> 
  </tr>
  <tr> 
  	<td class="titulosTabla">ESTUDIO</td> 
    <td align="left" colspan="3"> 
    	<input class="campoDatosTabla" name="folio_est" id="folio_est" type="text" readonly style="text-align:left; width:99%;"> 
    </td> 
  </tr>
  <tr> 
  	<td class="titulosTabla">REFERENCIA</td> 
    <td align="left" colspan="3"> 
    <input class="campoDatosTabla" name="referencia_est"id="referencia_est"type="text" style="text-align:left; width:99%;" readonly>
    </td> 
  </tr>
  
  <tr> 
  	<td class="titulosTabla">Osirix</td> 
    <td align="left" id="chosto"> </td>
  
  	<td class="titulosTabla"><!--Osirix Internet --></td> 
    <td align="left">
            
    </td> 
  </tr>
</table>
<input name="idEstudioPacs" type="hidden" value="" id="idEstudioPacs">
</div>
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
	
	$('#dialog-est').dialog({
		autoOpen: false, modal: true, width: 880, height: 350, closeOnEscape: true, title: 'VISUALIZAR ESTUDIO', closeText: '',
		buttons: {
			'Visualizador html': function() {//alert($('#referencia_est').val());
				var url=window.location.href, myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888');
				
				var link_1 = koby[0]+koby[1]; //alert(myL1[0]);
				window.open('http://'+koby[0]+':8080/oviyam2/viewer.html?patientID='+$('#referencia_est').val()); 
			},
			'Visualizador avanzado': function() { 
				var url=window.location.href, myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888');
				var link_1 = koby[0]+koby[1];
			//window.open('http://192.168.1.59:8080/weasis-pacs-connector/viewer.jnlp?patientID='+$('#referencia_est').val());},
				window.open('http://'+koby[0]+':8080/weasis-pacs-connector/viewer?patientID='+$('#referencia_est').val()); 
			},
		}
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

function procesar(a,b){$(document).ready(function(e) {//a es el id del paciente y b es el id del estudio en venta de conceptos
	$("#dialog-procesar").load('htmls/procesar.php', function( response, status, xhr ) { if ( status == "success" ) {
		$('.cheki').checkboxradio(); $('#idUserPro').val($('#idUser').val());
		//para los checkbox de la ventana de proceso
		$('#individualPro').click(function(e) { if($(this).prop('checked')==true){ $('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();}else{ $('#individualPro').prop('checked',true); } });
		$('#variosPro').click(function(e) { if($(this).prop('checked')==true){ $('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();}else{ $('#variosPro').prop('checked',true); } });
		
		$('#idPacientePro').val(a); $('#idEstudioPro').val(b); var datoP = {idP:a, idE:b}
		$.post('archivos_save_ajax/datosProcesar.php', datoP).done(function( data ) { var datosP = data.split('*}'); //alert(datosP[5]);
			$('#pacientePro').val(datosP[0]); $('#refPro').val(datosP[1]); $('#ordenPro').text(datosP[1]); $('#estPro').val(datosP[2]); $('#areaPro').val(datosP[3]); $('#observacionPro').val(datosP[4]);
			$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(''); $('#checaPro').val(0); $('#notificacionPro').hide();
			
			if(datosP[7]!=55){$('.variosEstu').hide();$('#checaPro').val(1);}else{if(datosP[5]>1){$('.variosEstu').show();$('#checaPro').val(0);}else{$('.variosEstu').hide();$('#checaPro').val(1);}}
			
			var tamHX = $('#referencia').height() - 100; var tamWX = $('#referencia').width() * 0.98;
			$('#dialog-procesar').dialog({
				autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, 
				closeText:'', title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close',
				close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
				buttons: {
					Procesar: function(){
						if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
						else{
							var datoP = $('#form-procesar').serialize();
							$.post('archivos_save_ajax/procesar.php', datoP).done(function( data ) { if (data == 1){ 
								$('#clickme').click(); $('#dialog-procesar').dialog('close');
							}else{alert(data);} });
						}
					}, Cancelar: function() { $(this).dialog("close"); }
				}
			});
		});
	} });
}); }
	
function realizar(a,b,radExt,es_masto){$(document).ready(function(e) {//a es el id del paciente y b es el id del estudio en vc
	$("#dialog-procesar").load('htmls/procesar.php', function( response, status, xhr ) { if ( status == "success" ) { 
		$('.cheki').checkboxradio(); $('#idUserPro').val($('#idUser').val());
		//para los checkbox de la ventana de proceso
		$('#individualPro').click(function(e) { if($(this).prop('checked')==true){ $('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();}else{ $('#individualPro').prop('checked',true); } });
		$('#variosPro').click(function(e) { if($(this).prop('checked')==true){ $('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();}else{ $('#variosPro').prop('checked',true); } });
		
		$('.miProcesar').text('Realizar');$('.miprocesar').text('realizar');$('.miProcesados').text('realizados');
		$('#idPacientePro').val(a); $('#idEstudioPro').val(b); var datoP = {idP:a, idE:b}
		$.post('archivos_save_ajax/datosRealizar.php', datoP).done(function( data ) { var datosP = data.split('*}');
			$('#pacientePro').val(datosP[0]); $('#refPro').val(datosP[1]); $('#ordenPro').text(datosP[1]); $('#estPro').val(datosP[2]); $('#areaPro').val(datosP[3]); $('#observacionPro').val(datosP[4]);
			$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); $('#checaPro').val(0); $('#notificacionPro').hide();
			
			if(datosP[7]!=55){$('.variosEstu').hide();$('#checaPro').val(1);}else{if(datosP[5]>1){$('.variosEstu').show();$('#checaPro').val(0);}else{$('.variosEstu').hide();$('#checaPro').val(1);}}
			
			var tamHX = $('#referencia').height() - 100; var tamWX = $('#referencia').width() * 0.95;
			$('#dialog-procesar').dialog({
				autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "REALIZAR ESTUDIO(S)", dialogClass: 'no-close',
				close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
				buttons: {
					Realizar: function(){
						if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
						else{
							var datoP = $('#form-procesar').serialize();
							$.post('archivos_save_ajax/realizar.php', datoP).done(function( data ) { if (data == 1){ $('#clickme').click(); $('#dialog-procesar').dialog('close');}else{alert(data);} });
						}
					},
					Cancelar: function() { $(this).dialog("close"); }
				}
			});
		});
	}
}); }); }

function capturar(a,b,radExt,es_masto,es){ $(document).ready(function(e){ //a es el id del paciente, b es el id del estudio en vc
	tinymce.remove("#input");
	$("#dialog-captura").load('htmls/interpretacion.php #interpretation',function(response,status,xhr){ if(status=="success"){
		if(es==1){ $('#saveInterI').html('<span class="ui-icon ui-icon-disk"></span>GUARDAR'); }
		else{ $('#saveInterI').html('<span class="ui-icon ui-icon-disk"></span>FINALIZAR'); }
		
		$('#form-captura').validate({ ignore: 'hidden',
			rules:{ input:{ required:true } }, messages:{ input:{required:'Debe ingresar la técnica y los hallazgos'} }
		});
		
		$('#myIDusuario').val($('#idUser').val()); $('#myIDestudio').val(b); //alert(es_masto);
		
		var dato = { idVC:b, idP:a, idU:$('#idUser').val() }
		$.post('files-serverside/datosCaptura.php', dato, processData);
		function processData(data){ console.log(data); var datos = data.split('*}{-');
			if(es_masto!=1){$('#mi_birad').html('&nbsp;');} else{
				$('#mi_birad').html('BIRADS: <select class="required" name="birad_e" id="birad_e" style="width:150px;"> <option value="">-SELECCIONAR-</option> <option value="0">0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> </select> '); $('#birad_e').val(datos[8]);
			}
			$('.myPaciente').html(datos[0]); $('.myReferencia').html(datos[1]); $('#titleEst').val(datos[5]);
			$('.myEdad').html(datos[2]); $('.mySexo').html(datos[3]); $('.myFecha').html(datos[4]);
			$('.myNotaTR').html('<span style="color:white;">NOTA DEL TÉCNICO:</span> '+datos[7]).css('color','red');
			
			if(es==1){ $('#interpretation #input').val(datos[11]); } //es = 1 es realizado, 2 es capturado
			else{ $('#interpretation #input').val(datos[9].replace('src="../../../usuarios/','src="../usuarios/')); }
			
			var titulo=datos[0]+' DE '+datos[2]+' '+datos[3]+' | '+$('#titleEst').val()+' | '+datos[4];
			
			var h=$('#referencia').height()-100,w=$('#referencia').width()*0.98;
			$('#dialog-captura').dialog({
				autoOpen:false,modal:true,width:w,height:h,resizable:false,closeOnEscape:false,dialogClass:'no-close',
				draggable:false, title: titulo, buttons:{},
				close:function(event,ui){$('#dialog-captura').dialog('destroy');document.getElementById('form-captura').reset();},
				open:function(event,ui){
					tinymce.init({ 
						selector:'#interpretation #input',resize:false,height:$('#dialog-captura').height()*0.68,theme: "modern",
						plugins: 
							"table, charmap, emoticons, textcolor colorpicker, hr, image imagetools, image, insertdatetime, lists, noneditable, pagebreak, paste, preview, print, visualblocks, wordcount, responsivefilemanager, code, importcss",
						table_default_styles: { width: '100%' },
						relative_urls: true, filemanager_title:"Administrador de archivos", filemanager_crossdomain: true,
						external_filemanager_path:"../tinymce/plugins/responsivefilemanager/filemanager/",
					    external_plugins: { "filemanager" : "../tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js"},
						image_advtab: true, menubar: false, plugin_preview_width: $('#dialog-captura').width()*0.8,
						toolbar: 
							"undo redo | insert | styleselect_ | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist_ numlist_ outdent indent | link unlink anchor | forecolor backcolor  | print_ preview code_ | emoticons_ | table | responsivefilemanager_",
						insert_button_items: 'charmap | cut copy | hr | insertdatetime | pagebreak1',
						paste_data_images: true, paste_as_text: true, browser_spellcheck: true, image_advtab: true
					});
					
					$("#dialog-captura #interpretation").tabs({active: 0});
					$('#saveInterI').click(function(e) { if($('#form-captura').valid()){
						if(es == 1){
							var datos = {
								input:tinyMCE.get('input').getContent(),myIDestudio:b,myIDusuario:$('#idUser').val(), 
								birad_e:$('#birad_e').val()
							}
							$.post('files-serverside/capturar.php',datos,processData); 
							var tutilin='CONFIRMACIÓN ESTUDIO CAPTURADO';
						}
						else{
							var str = tinyMCE.get('input').getContent(); 
							var res = str.replace('src="../usuarios/firmas/','src="../../../usuarios/firmas/');//alert(res);
							var datos={input:res,myIDestudio:b,myIDusuario:$('#idUser').val(),birad_e:$('#birad_e').val()}
							$.post('files-serverside/interpretar.php',datos,processData); 
							var tutilin = 'CONFIRMACIÓN ESTUDIO INTERPRETADO'; es = 3;
						}
						function processData(data) { console.log(data); if (data == 1){
							$('#clickme').click();$('#dialog-captura').dialog('close');
							
							if (es != 3){
								$('#dialog-confirmCaptura').dialog({
									autoOpen:true, modal:true, title:tutilin, width: 600, height: 200, 
									resizable: false, closeText:'', closeOnEscape: true,
									open:function(event,ui){
										setTimeout(function(){$('#dialog-confirmCaptura').dialog('close');},2000); 
									}, close:function(event,ui){ if(es < 3){ capturar(a,b,radExt,es_masto,2); } }
								});
							}else{
								$('#dialog-confirmInterpretacion').dialog({
									autoOpen:true, modal:true, title:tutilin, width: 550, 
									height: 230, resizable: false, closeText:'', closeOnEscape: true,
									buttons:{
										'Imprimir': function(){  if(es_masto!=1){$('#mi_birad').html('');} else{}
											preImprimir(b,es_masto,a); 
											$('#dialog-confirmCaptura, #dialog-confirmInterpretacion').dialog('close'); 
										}, 'Cerrar': function(){ $('#dialog-confirmInterpretacion').dialog('close'); }
									}
								});
							}
				
							document.getElementById('form-captura').reset();
						}else{ alert(data); } }
					} });
					$('#cancInterI').click(function(e){
						document.getElementById('form-captura').reset();$('#dialog-captura').dialog("close");
					});
				}
			});
			$('#tCaptura textarea, #tCaptura input').attr('disabled',false); $('#tablaUsuariosEstados').hide();
			
			if(radExt==0){//radExt es el id del usuario al que se asignó el estudio, si es 0 no se asignó a nadie
				if($('#accesoU').val()==1 || $('#accesoU').val()==2 || $('#accesoU').val()==10 || $('#accesoU').val()==11){
					$('#dialog-captura').dialog('open');
				}else{$('#dialog-alertar').dialog('open');}
			}else{if($('#idUser').val()==radExt){$('#dialog-captura').dialog('open');}else{$('#dialog-alertar').dialog('open');}}
		}	
	} });
}); }

function preImprimir(x,es_masto,idPa){$(document).ready(function(e) { //a =id paciente, b id estudio en vc
	var datoP = {idE:x}
	$.post('../laboratorio/archivos_save_ajax/datosPrintMem.php', datoP).done(function(data){ //alert(data);
		if(data!=1){ imprimir(x,es_masto,idPa,0); }
		else{
			$('#dialog-nivel3').dialog({
				autoOpen: true, modal: true, width: 600, height: 200, resizable: false, closeOnEscape: false, closeText:'', 
				title: 'TIPO DE IMPRESIÓN', dialogClass: 'no-close', draggable:false,
				close: function( event, ui ){ $('#dialog-nivel3').html(''); },
				open: function(event,ui){
					$('#dialog-nivel3').html('<table border="0"width="100%"height="100%"><tr><td align="center" valign="middle">Escoja si desea imprimir con o sin membretes.</td></tr></table>');
					$('#dialog-confirmInterpretacion').dialog('close');
				},
				buttons: {
					'CON MEMBRETES': function(){imprimir(x,es_masto,idPa,1); $('#dialog-nivel3').dialog('close');}, 
					'SIN MEMBRETES': function(){imprimir(x,es_masto,idPa,0); $('#dialog-nivel3').dialog('close');},
					'CANCELAR': function(){ $('#dialog-nivel3').dialog('close'); }
				}
			});
		}
	});
});}

function imprimir(x,es_masto,idPa,y){ $(document).ready(function(e) { //x=id del estudio, y es si se imprimen los encabe
	if(es_masto!=1){$('#miEncabezado #mi_birad').hide();} else{} //alert(idPa);
	var tamHX = $('#referencia').height() - 95, tamWX = $('#referencia').width() * 0.98;
	$('#dialog-impresion').dialog({
		autoOpen: true, modal: true, width: tamWX*0.8, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', 
		title: "IMPRESIÓN DE LA INTERPRETACIÓN", dialogClass: 'no-close',
		buttons: { Cerrar: function() { $(this).dialog("close"); }
		}, close:function(event, ui){$('#dialog-impresion').dialog('destroy'); },
		open:function(event, ui){
			var dato = { idE:x, idP:idPa, idU:$('#idUser').val() }
			$.post('files-serverside/datosInterpretar.php', dato).done(function( data ){ //alert(data);
				var datos = data.split(';*}-{');
				$.post('files-serverside/imprimirResultadosPDF.php?idE='+x+'&idU='+$('#idUser').val()).done(function(data){
				  var pusha={iduL:escape($('#idUser').val()),idVC:x,mems:y}
				  $("#dialog-impresion").load('htmls/frame_pdf.php',pusha,function(response,status,xhr){if(status=="success"){}});
				});		
			});
		}
	});
}); }//fin imprimir

function transferir(x, estudio, referencia, paciente,opc,uA,fA,mA){$(document).ready(function(e) { switch(opc){//x=id del e en vc
case 0:
	$("#dialog-transferir").load('htmls/transferir.php #paraTransferir',function(response,status,xhr){if(status=="success"){
		var tamHX = $('#referencia').height() - 100, tamWX = $('#referencia').width() * 0.98;
		$('#dialog-transferir').dialog({
			autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: true, closeText:'', 
			title: "TRANSFERIR LA INTERPRETACIÓN DEL PACIENTE "+paciente,
			buttons: {
				Transferir: function(){ 
					if($('.selected2').length >0){ 
						$('#errorSeleccionMédicoT').hide();
						var datosTI = {idE:x, radiologo:$('#idTmedicoR').val(), idU:$('#idUser').val()}
						$.post('files-serverside/transferirInterpretacion.php',datosTI).done(function( data ) { if(data==1){
							$('#dialog-transferir').dialog("close"); $('#clickme').click();
							$('#dialog-confirmarAlgo').dialog({
								title:'INTERPRETACIÓN ASIGNADA',modal:true,autoOpen:true,closeText: '',
								width: 600, height: 160, closeOnEscape: false, dialogClass: 'no-close',
								buttons:{},
								open:function( event, ui ) {
									$('#textoAlgo').text('¡LA INTERPRETACIÓN SE HA ASIGNADO SATISFACTORIAMENTE!');
									window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
								}, //close:function( event, ui ) { $('.'+id).remove(); }
							});
						} });
					}else{ $('#errorSeleccionMédicoT').hide().show('shake'); }
				}, Cancelar: function() { $('#dialog-transferir').dialog("close"); }
			},
			open: function( event, ui ) {
				$('#estudioTr').text(estudio); $('#referenciaTr').text(referencia);
				//para fintro individual por campo de texto
				var asInitValsT = new Array();
	
				var tam = $('#dialog-transferir').height() - 110;
				
				var oTableTr = $('#dataTableTransfer').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
					"bStateSave": false, "bInfo": false, "bFilter": true, "bDestroy": true, ordering: false,
					"aoColumns": [ {"bSortable":false },{"bSortable":false},{"bSortable":false},{"bSortable":false} ],
					"iDisplayLength": 500, "bLengthChange": false, "bProcessing": false, "bServerSide": true, 
					"sDom": '<"data_t"t><"info"i>', 
					"sAjaxSource": "datatable-serverside/transferir.php",
					"fnServerParams": function (aoData, fnCallback) {
						   var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
						   var acceso = $('#accesoU').val(); var idU = $('#idUser').val(); var fechaEst = $('#fechaEst').val();
						   aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } );
						   aoData.push(  {"name": "acceso", "value": acceso } ); aoData.push(  {"name": "idU", "value": idU } );
						   aoData.push(  {"name": "fechaEst", "value": fechaEst } );
					},
					"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "&nbsp;TOTAL DE MÉDICOS RADIÓLOGOS: _MAX_", "sSearch": "BUSCAR" }
				});//fin data table
				
				//para los filtros individuales por campo de texto
				$("tfoot input.sea1").keyup( function () { oTableTr.fnFilter( this.value, $("tfoot input.sea1").index(this) );} );
				/* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in * the footer */
				$("tfoot input.sea1").each( function (i) { asInitValsT[i] = this.value; } );
				 
				$("tfoot input.sea1").focus(function(){
					if(this.className == "search_init" ){ this.className = ""; this.value = ""; } 
				});
				 
				$("tfoot input.sea1").blur( function (i) { 
					if( this.value=="" ){ this.className = "sea1"; this.value = asInitValsT[$("tfoot input.sea1").index(this)]; }
					$(this).addClass('campos_b_t');
				} );
				
				var tableBM = $('#dataTableTransfer').DataTable();
				$('#dataTableTransfer tbody').on('click','tr',function(){
					if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
					else{
						tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
						$('#errorSeleccionMédicoT').hide();
					}
				});
				
				$('#dataTableTransfer tbody').on( 'click', 'tr', function () {
					var nTdsBMC = $('td', this); var idConsulta = $(nTdsBMC[0]).html().split('"'); //alert(idConsulta[1]);
					$('#idTmedicoR').val(idConsulta[1]);
				}); //con la clave del médico sacamos su id
			},
			close: function( event, ui ){ $('#dialog-transferir').empty(); }
		});
	} });
break;
case 1:
	$("#dialog-transferir").load('htmls/transferir.php #yaTransferido',function(response,status,xhr){if(status=="success"){
		var tamHX = 250, tamWX = 720;
		$('#dialog-transferir').dialog({
			autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: true, closeText:'', 
			title: "INTERPRETACIÓN TRANSFERIDA DEL PACIENTE "+paciente,
			buttons: {
				Desasignar: function(){ 
					$('#dialog-cancelAlgo').dialog({title:'DESASIGNAR INTERPRETACIÓN. PACIENTE: '+paciente,modal:true, 
					autoOpen: true, closeText: '', width: 700, height: 210, closeOnEscape: false, dialogClass: 'no-close',
					buttons:{
						"Si":function(){ 
							if($('#confirmaCOV').prop('checked')==true){
								var datosCOV = {idVC:x}
								$.post('files-serverside/desasignarI.php',datosCOV).done(function( data ) { if (data==1){ 
									$('#dialog-transferir, #dialog-cancelAlgo').dialog('close'); $('#clickme').click(); 
								} else{alert(data);} });
							} else{ $('#debeConfirmarCOV').hide().show('shake');}
						}, "No":function(){$('#dialog-cancelAlgo').dialog('close');}
					},
					open:function( event, ui ) { 
						$('#textoCancelaAlgo').text('¿ESTA SEGURO DE DESASIGNAR LA INTERPRETACIÓN DEL ESTUDIO '+estudio+' CON REFERENCIA '+referencia+' DEL MÉDICO '+mA+'?');
						$('#confirmaCOV').click(function(e) { $('#debeConfirmarCOV').hide();});
					}, close:function( event, ui ) { $('#debeConfirmarCOV').hide(); $('#confirmaCOV').prop('checked',false); }
				});
				}, Cerrar: function() { $('#dialog-transferir').dialog("close"); }
			},
			open: function( event, ui ) {
				$('#estudioYa').text(estudio); $('#referenciaYa').text(referencia); $('#uAsignaT').text(uA);
				$('#fAsignaT').text(fA); $('#mAsignaT').text(mA);
			},
			close: function( event, ui ){ $('#dialog-transferir').empty(); }
		});
	} });
break;
default:
	alert('Ha ocurrido un error!');
} }); }//fin transferir

function editar(x, estudio, referencia, paciente){// x=id del estudio en vc
	$(document).ready(function(e) {
		$('#dialog-editar').dialog({
			autoOpen: false, modal: true, width: 750, height: 250, resizable: false, closeOnEscape: true, closeText:'', 
			title: "EDITAR LA INTERPRETACIÓN",
			buttons: {
				Editar: function(){ 
					if($('#editarInterpretacionC').prop('checked')==false){
						$('#errorEditar').show('shake');
						window.setTimeout(function(){$('#errorEditar').hide();},1000);
					}else{
						var dato = { idE:x, idU:$('#idUser').val() }
						$.post('files-serverside/editarInterpretacion.php', dato).done(function( data ) {
							if(data==1){
								$('#dialog-editar').dialog('close');
								$('#clickme').click();
								//dialog-confirmacion
								$('#dialog-confirmacion').dialog({
									autoOpen: true, modal: true, width: 600, height: 150, resizable: false, closeOnEscape: true, 
									closeText:'', title: "EDICIÓN LISTA", dialogClass: '',
									open: function( event, ui ) {
										$('#textoConfirma').text('!La interpretación del estudio está listo para edición!');
										window.setTimeout(function(){$('#dialog-confirmacion').dialog('close');},2000);
									},
									buttons: ''
								});
							}else{alert(data);}
						});
					}
				},
				Cancelar: function() { $(this).dialog("close"); }
			},
			open: function( event, ui ) {
				$('.estudioEdit').text(estudio);$('.referenciaEdit').text(referencia);$('.pacienteEdit').text(paciente);
			},
		});//fin del dialog editar
		if($('#accesoU').val()==1){$('#dialog-editar').dialog('open');}else{$('#dialog-alertar').dialog('open');}
    });//fin ready
}//fin editar

function noest(idVC,nombreE,nombreP,ref,fecha, idPacs){ $(document).ready(function(e) {
	$("#dialog-noest").load('htmls/asignar_pacs.php', function( response, status, xhr ) { if ( status == "success" ) {
		var tamH = $('#referencia').height() - 100; var tamW = $('#referencia').width() * 0.98;
		$('#dialog-noest').dialog({
			autoOpen: true, modal: true, width: tamW, height: tamH, resizable: false, closeOnEscape: true, 
			closeText:'', title: "ASIGNAR ID DE PACS A ESTUDIO DE SIGMA", dialogClass: '',
			open: function( event, ui ) { 
				$('#estudioEpacs').text(nombreE);
				$('#pacienteEpacs').text(nombreP);
				$('#referenciaEpacs').text(ref);
				$('#fechaEst').val(fecha);
				$('#idEstVC').val(idVC);
				$('#idPacsVC').val(idPacs);
				
				//para fintro individual por campo de texto
				var asInitVals1 = new Array();
	
				var tam = $('#referencia').height() - 380;
				
				var oTablePc = $('#dataTablePc').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
					"bStateSave": false, "bInfo": false, "bFilter": true, "bDestroy": true, ordering: false,
					"aoColumns": [ {"bSortable":false },{"bSortable":false},{"bSortable":false},{"bSortable":false} ],
					"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true, 
					"sDom": '<"data_t"t><"info"i>', 
					"sAjaxSource": "datatable-serverside/nopacs.php",
					"fnServerParams": function (aoData, fnCallback) {
						   var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
						   var acceso = $('#accesoU').val(); var idU = $('#idUser').val(); var fechaEst = $('#fechaEst').val();
						   aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } );
						   aoData.push(  {"name": "acceso", "value": acceso } ); aoData.push(  {"name": "idU", "value": idU } );
						   aoData.push(  {"name": "fechaEst", "value": fechaEst } );
					},
					"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
					"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "&nbsp;TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
				});//fin data table
				
				$('#clickmePc').click(function(e) { oTablePc.fnDraw(); });
				
				//para los fintros individuales por campo de texto
				$("tfoot input.sea").keyup( function () { oTablePc.fnFilter( this.value, $("tfoot input.sea").index(this) );} );
				/* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in * the footer */
				$("tfoot input.sea").each( function (i) { asInitVals1[i] = this.value; } );
				 
				$("tfoot input.sea").focus(function(){if(this.className == "sea" ) { this.className = ""; this.value = ""; } } );
				 
				$("tfoot input.sea").blur( function (i) { 
					if( this.value == "" ) { this.className = "sea"; this.value = asInitVals1[$("tfoot input.sea").index(this)]; }
				} );
				window.setTimeout(function(){ $('#sFecha').val(fecha); oTablePc.fnFilter( fecha, 0 ); },50);
				//fin filtros individuales por campo de texto
				
				var tableBM = $('#dataTablePc').DataTable();
				$('#dataTablePc tbody').on('click','tr',function(){
					if($(this).text()!='SIN COINCIDENCIAS - LO SENTIMOS'){
						if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
						else{
							tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
							$('#errorSeleccionConsulta').hide();
						}
					}
				});
				$('#dataTablePc tbody').on( 'click', 'tr', function () { 
					var nTdsBMC = $('td', this);
					var xl = $(nTdsBMC[0]).html().split('"'); //alert(xl[1]);
					$('#pkPacs').val(xl[1]);
				});
			}, close:function(event, ui){$('#dialog-noest').dialog('destroy'); },
			buttons: {
				Asignar: function() { 
					if($('.selected2').length >0 ){
						$('#errorSeleccionConsulta').hide();
						var datosAP = { pkPacs:$('#pkPacs').val(), idPacsVC:$('#idPacsVC').val()}
						$.post('files-serverside/asignarPacs.php',datosAP).done(function( data ) { 
							if (data==1){ 
								$('#dialog-confirmaAsignaPacs').dialog({
									autoOpen:true, modal:true, title:'CONFIRMACIÓN ASIGNA PACS', width: 550, height: 230, 
									resizable: false, closeText:'', closeOnEscape: true,
									buttons:{
										'Cerrar': function(){ $('#dialog-confirmaAsignaPacs').dialog('close'); }
									},
									open: function( event, ui ) {
										$('#dialog-noest').dialog("close");
										window.setTimeout(function(){$('#dialog-confirmaAsignaPacs').dialog('close');},1500);
									},
									close: function( event, ui ) { $('#clickme').click(); }
								});
							} else{if (data!=''){ alert(data);} } 
						});//guardamso al nuevo paciente 
					}else{
						$('#errorSeleccionConsulta').hide().show('shake');
					}
				},
				Cancelar: function() { $(this).dialog("close"); }
			}
		});
	} });
}); }

function est(a,b){ //a es el id del estudio, b es el id del estudio ambos en venta de conceptos
	$(document).ready(function(e) {
		var url = window.location.href, myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888'); 
		var link_1 = koby[0]+koby[1]; //alert(myL[0]);
		var idE = {idE:a,h:koby[0]}
		$.post('files-serverside/datosInterpretar.php',idE).done(function( data ) {//alert(data);
			var dataE = data.split(';*}-{');
			if(dataE[0]!=''){
				$('#referencia_est').val(dataE[12]); $('#idEstudioPacs').val(dataE[19]);
				$('#paciente_est').val(dataE[0]); $('#folio_est').val(dataE[8]);
				var pu = 'http://192.168.1.59:8080/wado?requestType=PATIENT&studyUID='+dataE[16];
				var linkOsiL = 'osirix://?methodName=DownloadURL&Display=YES&URL='+pu;
				var ka = '<a href='+dataE[17]+' id="myOsirixL"><img src="../imagenes/osirix.png"></a>'
				$('#chosto').html(''); $('#chosto').append(ka);
			}
		});
		$('#dialog-est').dialog('open');
	});
}
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

function fotos(id_su, clave_su){ $(document).ready(function(e) {
$("#dialog-nivel1").load("htmls/fotografias.php",function(response, status, xhr){ if ( status == "success" ) {
	$('#b_subir_foto').click(function(e) { subir_foto(id_su); });
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 60;
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true,width:w,height:h,title:'FOTOGRAFÍAS DEL ESTUDIO '+clave_su,closeText:'', dialogClass:'',
		closeOnEscape:true,
		open:function( event, ui ){
			var oTableF, tamF = $('#dialog-nivel1').height()-40;
			oTableF = $('#dataTableFotos').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
					$('span.DataTables_sort_icon').remove(); $('#dataTableMem_wrapper td').removeClass('sorting_1');
				},
				"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tamF, "bAutoWidth": false, 
				"bInfo": true, "bFilter": false, ordering: false,
				"aoColumns": [ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bVisible":false} ],
				"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": 't', "sAjaxSource": "datatable-serverside/fotos.php",
				"fnServerParams":function(aoData, fnCallback){ var id_s = id_su; aoData.push({"name": "id_s", "value": id_s });},
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "EL ESTUDIO NO CUENTA CON FOTOGRAFÍAS",
					"sInfo":"ENCONTRADAS: _END_","sInfoEmpty":"MOSTRADAS: 0","sInfoFiltered":"<br/>FOTOGRAFÍAS: _MAX_", "sSearch": "",
					"oPaginate": {
						"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
						"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
					}
				}
			}); $('#clickmeFo').click(function(e){oTableF.fnDraw();});
			
			$('.boton_mem').click(function(event){event.preventDefault();});
		}, close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); }, buttons:{ }
	});
} }); }); }

function subir_foto(idS){ $(document).ready(function(e) {
$("#dialog-nivel2").load("htmls/subir_fotografia.php #fotografia",function(response,status,xhr){ if(status == "success"){
	$('#dialog-nivel2').dialog({
		autoOpen:true,modal:true,width:800,height:300,title:'SUBIR UNA FOTOGRAFÍA',closeText:'',
		open:function( event, ui ){
			$('#form-fotografia').submit(function(event) { event.preventDefault(); });
			$('#form-fotografia').validate(); $('#fileupload_foto').addClass('ui-state-disabled');
			$('#titulo_foto').keyup(function(e) {//$('#fileupload').valid();
				if($(this).val()!=''){$('#fileupload_foto').removeClass('ui-state-disabled');}
				else{$('#fileupload_foto').addClass('ui-state-disabled');}
			});
			//Para el upload
			'use strict';
			// Change this to the location of your server-side upload handler:
			var ko = $('#idUser').val();
			var url = window.location.hostname === 'blueimp.github.io' ?
						'//jquery-file-upload.appspot.com/' : 'fotografias/index.php?idU='+ko+'&idP='+idS+'&nombreD='+escape($('#titulo_foto').val());
			$('#fileupload_foto').fileupload({
				url: url, dataType: 'json',
				submit:function (e, data) {
					$.each(data.files, function (index, file) {
						var input = $('#titulo_foto'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
					});
				},
				progress: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);
					$('#progress .bar').css( 'width', progress + '%' );
				},
				done: function (e, data) {
					$('#dialog-nivel3').dialog({
						autoOpen: true, modal: true, width: 500, height:120, title: 'FOTOGRAFÍA CARGADA', closeText: '',
						open:function( event, ui ){
							$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El archivo se guardó satisfactoriamente!</h3></td></tr></table>');
							$('#dialog-nivel2').dialog('close');
							window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
						},
						close:function( event, ui ){ 
							$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); $('#clickmeFo').click();
						}, buttons:{ }
					});
				},
			}); //Para el upload
		},
		close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{ "Cancelar":function(){$('#dialog-nivel2').dialog('close');} }
	});
} });
}); }
function ver_logo(nombre_img, name_s, exte, time,titulo,carpeta,id_doc,que_es){ $(document).ready(function(e) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel2').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: titulo+' DEL ESTUDIO '+ name_s, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel2").load('../pacientes/htmls/miPDFdocs.php #tablaMiPDF', function( response, status, xhr ) { 
				if ( status == "success" ) { //alert(exte);
					if(exte != 'pdf' & exte != 'PDF'){
						x=carpeta+'/files/'+id_doc+'.'+exte+'?'+time;
						$('#mi_documento').html('<img src='+x+' style="max-width:750px; border:5px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
					}else{
						x=carpeta+'/files/'+id_doc+'.pdf';
						$('#mi_documento').html('<a class="media" href=""> </a>');
						$('a.media').media({width:890, height:h-136, src:x});	
					}
				}
			});
		}, close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{
			"Imprimir":function(){$('#dialog-nivel2 #tablaMiPDF').printElement();},
			"Eliminar":function(){delete_documento(id_doc,titulo,exte,que_es,carpeta);},
			"Cerrar":function(){$('#dialog-nivel2').dialog('close');}
		}
	});
}); }

function delete_documento(id_doc, nombre_doc, tipo_doc, titulo,carpeta){ $(document).ready(function(e) {//alert(tipo_doc);
$("#dialog-nivel3").load("../pacientes/htmls/eliminacion.php", function( response, status, xhr ) { if ( status == "success" ) { 
	$('#dialog-nivel3').dialog({ title: 'ELIMINAR ARCHIVO', modal: true, autoOpen: true, closeText: '', width: 700, 
		height: 230, closeOnEscape: true, dialogClass: '',
		buttons:{
			"Aceptar":function(){
				if($('#confirmaEA').prop('checked')==true){
					var datos = {id:id_doc, tipo:tipo_doc, que_es:titulo,carpeta:carpeta}
					$.post('files-serverside/eliminarFoto.php',datos).done(function( data ) { if (data==1){
						$('#dialog-nivel2').dialog('close');
						$('#dialog-confirmarAlgo').dialog({ title:'ARCHIVO ELIMINADO',modal:true, autoOpen: true, closeText: '',
							width: 600, height: 200, closeOnEscape: true, dialogClass: '',
							buttons:{ "Cerrar":function(){ $('#dialog-confirmarAlgo').dialog('close'); } },
							open:function( event, ui ) {
								$('#textoAlgo').text('¡EL ARCHIVO SE HA ELIMINADO SATISFACTORIAMENTE!');
							    document.getElementById('form-eliminarAlgo').reset();$('#debeConfirmarCOEA').hide();
								window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
								$('#dialog-nivel3').dialog('close');$('#clickme,#clickmeMem,#clickmeFo').click();
							}, close:function( event, ui ) { $('#clickme,#clickmeMem,#clickmeDo').click(); }
						});
					} else{alert(data);} });
				}else{
					$('#debeConfirmarCOEA').hide().show('shake');
					window.setTimeout(function(){$('#debeConfirmarCOEA').hide()},1500);
				}
			}, "Cancelar":function(){ $('#dialog-nivel3').dialog('close'); }
		},
		open:function(event, ui){$('#texto_eliminar_algo').html('¿ESTÁ SEGURO QUE DESEA ELIMINAR EL ARCHIVO '+nombre_doc+'?');}, 
		close:function(event,ui){ $('#dialog-nivel3').empty();$('#tabla_eliminar_algo').remove(); }
	});
} });
}); }

var recognition;
var recognizing = false;
if (!('webkitSpeechRecognition' in window)) { $('#dictado').hide(); /*alert("¡API no soportada!"); */} 
else {
	recognition = new webkitSpeechRecognition();
	recognition.lang = "es-VE";
	recognition.continuous = true;
	recognition.interimResults = false; //era true

	recognition.onstart = function() { recognizing = true; console.log("empezando a eschucar"); }
	recognition.onresult = function(event) {
	 for (var i = event.resultIndex; i < event.results.length; i++) { 
		if(event.results[i].isFinal){insertAtCaret(event.results[i][0].transcript);}
	 } //texto
	}
	recognition.onerror = function(event) {  }
	recognition.onend = function() {
		recognizing = false;
		$('#dictado').html('<span class="ui-icon ui-icon-pencil"></span> INICIAR DICTADO');
		console.log("terminó de eschucar, llegó a su fin");
	}
}

function procesarV() {
	if(recognizing==false){
		recognition.start();recognizing=true; $('#dictado').html('<span class="ui-icon ui-icon-pencil"></span> DETENER DICTADO');
	}
	else{recognition.stop();recognizing=false;$('#dictado').html('<span class="ui-icon ui-icon-pencil"></span> INICIAR DICTADO');}
}

function insertAtCaret(text) { tinymce.get("input").execCommand('mceInsertContent', false, text); }
</script>
