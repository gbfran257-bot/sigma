<?php require_once('../Connections/horizonte.php'); ?>
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

if (isset($_SESSION['MM_Username'])) { $colname_usuario = $_SESSION['MM_Username']; $_SESSION["RF"]["subfolder"] =$_POST['subfolder']; }
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
<title>ESTUDIOS DE ULTRASONIDO</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../DataTables-1.9.1/media/js/jquery.dataTables.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src='../tinymce/tinymce.min.js'></script>
<script src="../funciones/js/stdlib.js"></script>

<script>
$(document).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });
$(document).ready(function(e) {
	$('#form-captura').validate({
		rules:{ diagnostico:{ required:true } },
		messages:{ diagnostico:{ required:'Debe ingresar el diagnóstico' } }
	});
	
	//Refrescamos la sesión para que no caduque
	setInterval(function(){$.post('../remote_files/refresh_session.php');},500000);
	$('#verMenu').click(function(e){window.location='../menu.php?menu=mi';}); 
	
	var i = 1;
	
	$('#dispara_menu').click(function(e) { i++;
		if(i%2==0){
			$('#header').after('<div id="div_menu" class="ver_menu" style="border:1px none red; z-index:1000000000000; position:fixed; width:240px;"><table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="left"><ul id="menu_u1" style="border-bottom-left-radius:4px;border-bottom-right-radius:4px;"><li><div id="mi_perfil"><span class="ui-icon ui-icon-person"></span> Mi perfil</div></li><li><div><span class="ui-icon ui-icon-gear"></span> Configuración</div></li><li><div><span class="ui-icon ui-icon-power"></span> <a href="<?php echo $logoutAction ?>">Cerrar sesión</a></div></li><li><div id="ayuda"><span class="ui-icon ui-icon-info"></span> Ayuda</div></li><li><div id="reportar_problema"><span class="ui-icon ui-icon-wrench"></span> Reportar problema</div></li><li><div id="politicas_condiciones"><span class="ui-icon ui-icon-script"></span> Políticas y condiciones</div></li><li><div id="aviso_privacidad"><span class="ui-icon ui-icon-alert"></span> Aviso de privacidad</div></li><li><div id="acerca_de"><span class="ui-icon ui-icon-star"></span> Acerca de</div></li><li><div id="mi_chat"><span class="ui-icon ui-icon-comment"></span> Chat</div></li></ul></td></tr></table></div>');
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
<input name="idEstuVC" id="idEstuVC" type="hidden" value="">

<div style="display:none;" id="dialog-upload" title="INTERPRETACIÓN">
		<span id="spanDialog"></span>
  <iframe id="miFrame" allowtransparency="yes" frameborder="0" src="../editorTexto/Untitled-3.php" style="width:850px; height:440px;"></iframe>
</div>

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_ultrasonido.png" height="40"></td>
        <td align="left" valign="middle" nowrap><span id="verMenu" style="cursor:pointer;">ESTUDIOS DE ULTRASONIDO</span></td>
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

<script type="text/javascript">
//para fintro individual por campo de texto
var asInitVals = new Array();
//fin para filtro individual por campo de texto

$(document).ready(function() {
	
	var tam = $('#referencia').height() - 140;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  myFunction(); },
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, "bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bVisible": false }, { "bSortable": false }],
		"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>', "sAjaxSource": "datatable-serverside/ultrasonidos.php",
		"fnServerParams": function (aoData, fnCallback) {
			   var de = document.getElementById('fechaDe').value+' 00:00:00'; 
			   var a = $('#fechaA').val()+' 23:59:59';
			   var accesoU = $('#accesoU').val();
			   var idU = $('#idUser').val();
               aoData.push(  {"name": "min", "value": de } ); 
			   aoData.push(  {"name": "max", "value": a } );
			   aoData.push(  {"name": "accesoU", "value": accesoU } );
			   aoData.push(  {"name": "idU", "value": idU } );
        },
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "&nbsp;TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw(); myFunction(); });
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); } );
    /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
     * the footer
     */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = "";myFunction(); } } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)];myFunction(); } } );
	//fin filtros individuales por campo de texto
	
	$('#radio1').click(function(e) {
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>');
		$('#fechaA').val('<?php echo date("Y-m-d"); ?>');
		oTable.fnDraw();
    });
	$('#radio2').click(function(e) {
		$('#fechaDe').val('2000-01-01');
		$('#fechaA').val('<?php echo date("Y-m-d"); ?>');
		oTable.fnDraw();
    });
	$( "#fechaDe" ).datepicker({
	  	defaultDate: "-1",
		maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); },
		"onSelect": function(date) {
      		min = date+' 00:00:00';//new Date(date).getTime();
      		oTable.fnDraw();
    	}
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({
		defaultDate: "+0",
		maxDate: +0,
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
	$('.rad').css('font-size','0.8em');
	
});
</script>

<div class="contenido" id="contenido" align="center" style="padding-top:3px;">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr class="titulos_dataceldas">
        <th width="1px">#</th>
        <th id="clickme">PACIENTE</th>
        <th>REFERENCIA</th>
        <th>ESTUDIO</th>
     	<th>ESTATUS</th>
        <th>ÁREA</th>
        <th>EDITAR</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr>
        	<td><input name="alo" id="alo" type="hidden" value=""></td>
        	<td>
            <input name="sPaciente" id="sPaciente" type="text" placeholder="Paciente" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sPaciente1" id="sPaciente1" type="text" placeholder="Referencia" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sPaciente2" id="sPaciente2" type="text" placeholder="Estudio" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sPaciente3" id="sPaciente3" type="text" placeholder="Estatus" class="search_init" style="width:90%;" />
            </td>
            <td>
            <input name="sPaciente10" id="sPaciente10" type="text" placeholder="Área" class="search_init" style="width:90%;" />
            </td>
            <td><input name="alo1" id="alo1" type="hidden" value=""></td>
        </tr>
    </tfoot>
  </table>
  
  <div id="divRangoFechas"><table width="100%" border="0" style="color:black;" cellpadding="3" cellspacing="0">
  <tr>
    <td width="1px">De </td> 
    <td width="1%"><input name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td width="1px">A </td> 
    <td width="1%"><input name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label> 
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td align="right"></td>
  </tr>
</table>
</div>
  
</div>

<input name="titleEst" id="titleEst" value="" type="hidden">

<div id="dialog-procesar" style="display:none;"> </div>

<div id="dialog-preguntaX" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td align="left">PACIENTE: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="pacienteX1"></span></td>
  </tr>
  <tr>
    <td align="left">ESTUDIO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="estudioX1"></span></td>
  </tr>
  <tr>
    <td align="left">REFERENCIA: <span id="referenciaX1"></span></td>
  </tr>
  <tr>
    <td align="center">¿DESEA ATENDER EL ESTUDIO?</td>
  </tr>
</table>
<input name="idEstX" id="idEstX" value="" type="hidden">
</div>

<div id="dialog-medico" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td>Sólo un <strong>médico</strong> puede realizar esta acción.</td> </tr>
</table>
</div>

<div id="dialog-img" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td id="miImg" align="center" valign="middle"></td> </tr>
</table>
</div>

<div id="dialog-confirmCaptura" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td>¡La interpretación del estudio se ha guardado satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-confirmFinalizado" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td>¡El estudio se ha finalizado satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-preguntar" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td align="center" valign="middle">
  ¿Desea finalizar la captura del video definitivamente?
  </td> </tr>
  <tr> <td align="center" valign="middle">
  Tenga en cuenta que incluso ya no podrá eliminar las imágenes capturadas.
  </td> </tr>
</table>
</div>

<div id="dialog-preguntarF" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td align="center" valign="middle">
  ¿Desea finalizar el estudio de ultrasonido definitivamente?
  </td> </tr>
  <tr> <td align="center" valign="middle">
  Tenga en cuenta que ya no podrá realizar cambios.
  </td> </tr>
</table>
</div>

<div id="imagenes_usg" style="display:none; overflow:hidden">
	<table width="100%" height="1%" border="0" cellspacing="0" cellpadding="0" class="">
      <tr height="1%">
        <td id="encabezadoEndo" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="50%" align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="1%" nowrap>PACIENTE: </td>
                        <td class="myPacienteP" nowrap> </td>
                      </tr>
                    </table>
                    </td>
                    <td width="50%" align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td class="myEdadP" align="left" width="" nowrap></td> 
                        <td class="mySexoP" align="left" width=""></td> 
                      </tr>
                    </table>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
          <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%" align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="1%" nowrap align="left">REFERENCIA DEL ESTUDIO:</td> 
                        <td class="myReferenciaP" align="left" width=""></td> 
                      </tr>
                    </table>
                    </td>
                    <td width="50%" align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td class="myEstudioP" align="left" width="140px" style="font-weight:bold;"></td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
       </table>
       </td>
      </tr>
    </table>
	<table id="imgUsg1" width="100%" height="1%" border="0" cellspacing="0" cellpadding="2" align="center" style="vertical-align:middle; padding-top:0.3cm; overflow:hidden"> </table> 
</div>

<div id="dialog-editar" style="display:none;">
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

<div id="dialog-confirmacion" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoConfirma">¡El estudio se ha transferido satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-alertar" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoAlertar">¡Lo sentimos, usted no puede realizar esta acción!</td> </tr>
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
function preguntaX(n,r,e,i){//n es el nombre del paciente, r es la referencia e i es el id de la venta_conceptos
	$('#pacienteX1').text(n);
	$('#estudioX1').text(e);
	$('#referenciaX1').text(r);
	$('#idEstX').val(i);
	$('#dialog-preguntaX').dialog('open');
}

function All(){ $(document).ready(function(e) { $('#myCli').click(); }); }

$(document).ready(function(e) {
	$('#dialog-alertar').dialog({
		autoOpen: false, modal: true, width: 600, height: 150, resizable: false, closeOnEscape: true, 
		closeText:'', title: "ACCESO DENEGADO", dialogClass: '',
		open: function( event, ui ) {
			window.setTimeout(function(){$('#dialog-alertar').dialog('close');},2000);
		}
	});
	
	$('#dialog-confirmCaptura').dialog({
		autoOpen:false, modal:true, title:'CONFIRMACIÓN',width:600, height: 160, resizable: false, closeText:'', closeOnEscape: true,
		open: function( event, ui ) { setTimeout(function(){$('#dialog-confirmCaptura').dialog('close');},2000); },
		close: function( event, ui ) {  },buttons: {}
	});
	
	$('#dialog-confirmFinalizado').dialog({
		autoOpen:false, modal:true, title:'CONFIRMACIÓN',width:600, height: 160, resizable: false, closeText:'', closeOnEscape: true,
		open: function( event, ui ) { setTimeout(function(){$('#dialog-confirmFinalizado').dialog('close');},2000); },
		close: function( event, ui ) {  },buttons: {}
	});
	
	$('#dialog-preguntaX').dialog({ 
		autoOpen: false, modal: true, width: 600, height: 280, resizable: false, closeOnEscape: true, 
		closeText:'', title: "ATENDER ESTUDIO DE ULTRASONIDO", dialogClass: '',
		buttons: {
			'SI': function() {
				var datoI = {idC:$('#idEstX').val(), idU:$('#idUser').val()}
				$.post('archivos_save_ajax/procesarE.php', datoI).done(function( data ) { if (data == 1){ 
					$('#clickme').click(); 
					$('#dialog-preguntaX').dialog('close');
					fichaEstudio(2,$('#idEstX').val());
				}else{alert(data);} });
			},
			'NO': function() { $('#dialog-preguntaX').dialog('close'); }
		}
	});
	
	var tamHX = $('#referencia').height() - 90;
	var tamWX = $('#referencia').width() * 0.98;
	
	$('#dialog-procesar').dialog({ 
		autoOpen: false, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false,
		closeText:'', title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close',
		close: function(event, ui){
			$('#dialog-procesar').tabs('destroy'); //$('#dialog-procesar').empty();
			//alert(video);//if ( typeof video !== "undefined" && video) { video.pause();}// Stop the stream
			if ( typeof videoStream !== "undefined" && videoStream) { 
				/*videoStream.stop();*/ videoStream.getVideoTracks()[0].stop(); location.reload(); 
			}
		},
		open: function(event, ui){ //alert($('#idEstuVC').val());
			$.post("ultrasonido.php", {"subfolder": $('#idEstuVC').val()+'/seleccionadas/'});
			
			var he = $('#referencia').height() - 200; var wi = $('#referencia').width() * 0.98;
			$("#dialog-procesar").tabs({active: 0, disabled: [ 1, 2, 3 ]});
			$('#dialog-procesar ul').removeClass('ui-widget-header');
			$('.miTab').css('height',$("#dialog-procesar").height()-60);
			$('.botonE').click(function(event) { event.preventDefault(); });
			$('.botonE, #dictado').button({disabled: true});
			$('#salirE, #start').button({disabled: false});
			$('#tablaVideos').css('height',$('#tabs-1').height());
			$('#tamHcanvas').val($('#contenedorCanvas').height());
		}
	});//fin del dialog procesar
		
});

function preImprimir(x,idPa){$(document).ready(function(e) { //a =id paciente, b id estudio en vc
	var datoP = {idE:x}
	$.post('archivos_save_ajax/datosPrintMem.php', datoP).done(function(data){ //alert(data);
		if(data!=1){ imprimir(x,idPa,0); }
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
					'CON MEMBRETES': function(){imprimir(x,idPa,1); $('#dialog-nivel3').dialog('close');}, 
					'SIN MEMBRETES': function(){imprimir(x,idPa,0); $('#dialog-nivel3').dialog('close');},
					'CANCELAR': function(){ $('#dialog-nivel3').dialog('close'); }
				}
			});
		}
	});
});}

function imprimir(x,idPa,y){ $(document).ready(function(e) { //x=id del estudio, y es si se imprimen los encabe
	var tamHX = $('#referencia').height() - 95, tamWX = $('#referencia').width() * 0.98;
	$('#dialog-auxiliar').dialog({
		autoOpen: true, modal: true, width: tamWX*0.8, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', 
		title: "IMPRESIÓN DE LA INTERPRETACIÓN", dialogClass: 'no-close',
		buttons: { Cerrar: function() { $(this).dialog("close"); }
		}, close:function(event, ui){$('#dialog-auxiliar').dialog('destroy'); },
		open:function(event, ui){
			$.post('files-serverside/imprimirResulUltraPDF.php?idE='+x+'&idU='+$('#idUser').val()).done(function(data){
			  var pusha={iduL:escape($('#idUser').val()),idVC:x,mems:y}
			  $("#dialog-auxiliar").load('htmls/frame_pdf_usg.php',pusha,function(response,status,xhr){if(status=="success"){}});
			});
		}
	});
}); }//fin imprimir

function miImg(idImg){ //alert(idImg);
	var tamHX = $('#referencia').height() - 100;
	var tamWX = $('#referencia').width() * 0.98;
	
	$('#dialog-img').dialog({ 
		autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: true,
		closeText:'', title: "VISUALIZANDO IMAGEN", dialogClass: '',
		close: function(event, ui){ $('#miImg').html(''); },
		open: function(event, ui){ var miImg = '<img src='+'"'+idImg+'" />'; $('#miImg').html(miImg); }
	});//fin del dialog procesar
}

function cargarImagenesCanvas(i){
$("#deCanvas").load("img_usg/procesa.php?action=listFotos1&carpeta="+i,function(response,status,xhr){ if (status == "success" ){
		$('.eliminame1').click(function(event) { event.preventDefault(); });
		$('.eliminame1').button({ icons: { primary: "ui-icon-trash", }, text: false });
		$( ".en_reporte" ).button();
} }); 
window.setTimeout(function(){ $('#divCanvas').css('height',$('#tamHcanvas').val()).css('overflow','scroll');},500);
}

function cargarImagenesReporte(i){
	$("#imgUsg, #imgUsg1").load("img_usg/procesa.php?action=listFotos2&carpeta="+i,function(response,status,xhr){ 
		if (status == "success" ){ //miDivImgs
			switch ($('#imgUsg img').length){
				case 1:
					$('#miDivImgs').css('width','6.95cm').css('height','5.4cm').css('border','1px solid red').css('overflow','hidden');
					//.css('width','25cm').css('height','20cm').css('border','1px none red').css('overflow','hidden').show();
					$('#imgUsg #myImg1').css('height',$('#miDivImgs').height()-10);
					$('#imagenes_usg').show(); $('#imgUsg1 #myImg1').css('width','20cm');
				break;
				case 2:
					$('#miDivImgs').css('height','6.95cm').css('width','5.4cm').css('border','1px solid red').css('overflow','hidden');
					$('#imgUsg #myImg2, #imgUsg #myImg3').css('height',($('#miDivImgs').height()/2)-10);
					$('#imagenes_usg').show(); $('#imgUsg1 #myImg2, #imgUsg1 #myImg3').css('width','13.2cm');
				break;
				case 3:
					$('#miDivImgs').css('height','6.95cm').css('width','5.4cm').css('border','1px solid red').css('overflow','hidden');
					$('#imgUsg #myImg4, #imgUsg #myImg5, #imgUsg #myImg6').css('height',($('#miDivImgs').height()/3)-10);
					$('#imagenes_usg').show(); $('#imgUsg1 #myImg4, #imgUsg1 #myImg5, #imgUsg1 #myImg6').css('width','8.7cm');
				break;
				case 4:
					$('#miDivImgs').css('width','6.95cm').css('height','5.4cm').css('border','1px solid red').css('overflow','hidden');
					$('#imgUsg #myImg7, #imgUsg #myImg8, #imgUsg #myImg9, #imgUsg #myImg10').css('width',($('#miDivImgs').width()/2)-20);
					$('#imagenes_usg').show(); $('#imgUsg1 #myImg7, #imgUsg1 #myImg8, #imgUsg1 #myImg9, #imgUsg1 #myImg10').css('width','9.7cm');
				break;
				case 5:
					$('#miDivImgs').css('height','6.95cm').css('width','5.4cm').css('border','1px solid red').css('overflow','hidden');
					$('#imgUsg #myImg11, #imgUsg #myImg12, #imgUsg #myImg13, #imgUsg #myImg14, #imgUsg #myImg15').css('height',($('#miDivImgs').height()/3)-20);
					$('#imagenes_usg').show(); $('#imgUsg1 #myImg11, #imgUsg1 #myImg12, #imgUsg1 #myImg13, #imgUsg1 #myImg14, #imgUsg1 #myImg15').css('width','8.5cm');
				break;
				case 6:
					$('#miDivImgs').css('height','6.95cm').css('width','5.4cm').css('border','1px solid red').css('overflow','hidden');
					$('#imgUsg #myImg16, #imgUsg #myImg17, #imgUsg #myImg18, #imgUsg #myImg19, #imgUsg #myImg20, #imgUsg #myImg21').css('height',($('#miDivImgs').height()/3)-20);
					$('#imagenes_usg').show(); $('#imgUsg1 #myImg16, #imgUsg1 #myImg17, #imgUsg1 #myImg18, #imgUsg1 #myImg19, #imgUsg1 #myImg20, #imgUsg1 #myImg21').css('width','8.5cm');
				break;
			}
		}
	});
}

function eliminarFoto(idI, nombreI){
	var dato = {id:idI, nombre:nombreI}
	$.post("img_usg/procesa.php?action=eliminar", dato).done(function( data ) {
		cargarImagenesCanvas(data);
		cargarImagenesReporte(data);
	});
}

function reporteFoto(idI, nombreI){
	var datoC = {id:idI}
	$.post("img_usg/procesa.php?action=checar", datoC).done(function( dataA ) { 
		if(dataA==1){
			if($('#'+nombreI).prop('checked')==true){
				var dato = {id:idI, reportar:1}
				$.post("img_usg/procesa.php?action=reporte", dato).done(function( data ) { 
					var datoxC = data.split(';');
					if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">R</span>'); }
					cargarImagenesReporte(datoxC[1]);
				});
			}else{
				var dato = {id:idI, reportar:0}
				$.post("img_usg/procesa.php?action=reporte", dato).done(function( data ) {
					var datoxC = data.split(';');
					if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">NR</span>'); }
					cargarImagenesReporte(datoxC[1]);
				});
			}
		}else{//ya esta lleno
			if($('#'+nombreI).prop('checked')==false){
				var dato = {id:idI, reportar:0}
				$.post("img_usg/procesa.php?action=reporte", dato).done(function( data ) {
					var datoxC = data.split(';');
					if(datoxC[0]==1){ $('#'+nombreI).next().html('<span class="ui-button-text">NR</span>'); }
					cargarImagenesReporte(datoxC[1]);
				});
			}
		}
	});
}

function myFunction(){
 setTimeout(function(){
	$(document).ready(function(e) {
		var allBotonesIcono = $('.botonaso'); allBotonesIcono.css('width','25px').css('height','25px');
		
		$('.icono_proceso').button({ icons: { primary: "ui-icon-gear"}, text: false });
        $('.icono_realizado').button({ icons: { primary: "ui-icon-gear"}, text: false });
	    $('.icono_capturado').button({ icons: { primary: "ui-icon-document"}, text: false });
	    $('.icono_interpretado').button({ icons: { primary: "ui-icon-check"}, text: false });
		$('.icono_imprimir').button({ icons: { primary: "ui-icon-print"}, text: false });
		$('.icono_editar').button({ icons: { primary: "ui-icon-pencil"}, text: false });
		$('.miPDF').button({ icons: { primary: "ui-icon-document"}, text: false });
		$('.updatePDF').button({ icons: { primary: "ui-icon-refresh"}, text: false });
		$('.icono_editar').button({ icons: { primary: "ui-icon-pencil"}, text: false });
		
		$('.botonaso').click(function(event) { event.preventDefault(); });
	});
 },9);
}//fin myFunction

function editar(x, estudio, referencia, paciente){// x=id del estudio en vc
	$(document).ready(function(e) { 
		$('#dialog-editar').dialog({
			autoOpen: false, modal: true, width: 750, height: 270, resizable: false, closeOnEscape: true, closeText:'', 
			title: "EDITAR LA INTERPRETACIÓN",
			buttons: {
				Editar: function(){ 
					if($('#editarInterpretacionC').prop('checked')==false){
						$('#errorEditar').show('shake'); window.setTimeout(function(){$('#errorEditar').hide();},1000);
					}else{
						var dato = { idE:x, idU:$('#idUser').val() }
						$.post('files-serverside/editarInterpretacionUSG.php', dato).done(function( data ) {
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
									}, buttons: ''
								});
							}else{alert(data);}
						});
					}
				}, Cancelar: function() { $(this).dialog("close"); }
			},
			open: function( event, ui ) {
				$('.estudioEdit').text(estudio);$('.referenciaEdit').text(referencia);$('.pacienteEdit').text(paciente);
			},
		});//fin del dialog editar
		if($('#accesoU').val()==1){$('#dialog-editar').dialog('open');}else{$('#dialog-alertar').dialog('open');}
    });//fin ready
}//fin editar

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