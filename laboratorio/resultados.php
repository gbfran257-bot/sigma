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
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { $isValid = true; } 
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
<title>RESULTADOS LABORATORIO</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../css/resultadosL.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link href="../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">

<script src="../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../DataTables-1.9.1/media/js/jquery.dataTables.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script type="text/javascript" src="../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" charset="utf-8"></script>
<script type="text/javascript" src="takeArchivos/ajaxupload.js"></script>
<script type="text/javascript" src="../funciones/js/jquery.media.js"></script>

<script>
$(document).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });
$(document).ready(function(e) {
	$('#form-captura').validate({
		rules:{ diagnostico:{ required:true } },
		messages:{ diagnostico:{ required:'Debe ingresar el diagnóstico' } }
	});
	
    var miUsuario = $('.miUsuario'),
	misDatosUsuario = $('#misDatosUsuario');
	misDatosUsuario.hide();
	 var dj = 1;
	miUsuario.click(
		function(e) {
			dj++;
			if(dj%2==0){ misDatosUsuario.stop().show('explode','slow');
			}else{ misDatosUsuario.stop().hide('explode','slow'); }
    	}
	);
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75); 
	var cy = $('#header table').height() +0;

	misDatosUsuario.css('right',cx).css('top',cy);
});

</script>

<script>
$(document).ready(function(e) {
    var miMenu=$('#miMenu');
	miMenu.hide();
	$('#verMenu').click(function(e) { verMenu(); });
});
function verMenu(){
	$(document).ready(function(e) {
        $('#miMenu').show('fold','slow');
		$('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">RESULTADOS</span>');
    });
}
function ocultarMenu(){
	$(document).ready(function(e) {
        $('#miMenu').hide('fold','slow');
		$('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">RESULTADOS</span>');
    });
}
</script>
</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="idSuU" type="hidden" id="idSuU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">

<input name="nombreTempPdf" id="nombreTempPdf" type="hidden" value="">

<input name="id_vc_ini" id="id_vc_ini" type="hidden" value="">
<input name="usuario_ini" id="usuario_ini" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
<input name="campoUrl" id="campoUrl" type="hidden" value="">

<div style="display:none;" id="dialog-upload" title="INTERPRETACIÓN">
		<span id="spanDialog"></span>
  <iframe id="miFrame" allowtransparency="yes" frameborder="0" src="../editorTexto/Untitled-3.php" style="width:850px; height:440px;"></iframe>
</div>

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../imagenes/iconitos/_iconoEstudiosLab.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">RESULTADOS</span></td>
        <td id="celdaUsuario" width="50%" valign="top" align="center">
            <table class="miUsuario" width="1%" height="100%" border="0" cellspacing="0" cellpadding="4" style="border-radius:0px;">
              <tr>
                <td align="center" nowrap valign="middle">
                <?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="25">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="25">
                <?php }?>
                </td>
                <td nowrap valign="middle" class="usuarioPerfil">
                <?php echo $row_usuario['usuario_u']; ?>
                </td>
              </tr>
            </table>
    <div id="misDatosUsuario">
    <table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr>
            <td>
            <?php if($row_usuario['foto_u'] == 1){?>
                <img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80">
            <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
            <?php }?>
            </td>
            <td align="left" valign="top" class="nombreUsuario"><?php echo $row_usuario['nombre_u']." ".$row_usuario['apaterno_u']." ".$row_usuario['amaterno_u']; ?> </td>
        </tr>
    </table>
    
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr> <td style="font-weight:bold;" align="center"><?php echo $row_nombreSucursalUsuario['nombre_su']; ?></td> </tr>
        <tr> <td style="font-size:0.8em;" align="center"><?php echo $row_nombreDepartamentoUsuario['nombre_d']; ?></td> </tr>
        <tr> <td style="font-size:0.8em;" align="center"><span style="text-decoration:underline; cursor:pointer;"><a href="<?php echo $logoutAction ?>">CERRAR SESIÓN</a></span></td> </tr>
    </table>
    </div>
        </td>
      </tr>
    </table>
</div>

<div id="fondo" class="fondo">

<div id="miMenu" class="miMenu">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
  <tr valign="middle" class="fondoMenu">
    <td class="eii"><img title="MENÚ ANTERIOR" src="../imagenes/submenu/_laboratorio.png" width="100" onClick="window.location='../menu_laboratorio.php'"></td>
    <td class="eid"><img title="INICIO" src="../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../menu.php'"></td>
  </tr>
</table>
</div>

<div id="contenedor" class="contenedor">
  
<div class="contenido" id="contenido" align="center">
<script type="text/javascript">
$(document).ready(function(e) {
    $('#dialog-alertar').dialog({
		autoOpen: false, modal: true, width: 600, height: 150, resizable: false, closeOnEscape: true, 
		closeText:'', title: "ACCESO DENEGADO", dialogClass: '',
		open: function( event, ui ) {
			window.setTimeout(function(){$('#dialog-alertar').dialog('close');},2000);
		}
	});
});
//para fintro individual por campo de texto
var asInitVals = new Array();
//fin para filtro individual por campo de texto

//para filtro individual por select
(function($) {
$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
    // check that we have a column id
    if ( typeof iColumn == "undefined" ) return new Array();
    // by default we only want unique data
    if ( typeof bUnique == "undefined" ) bUnique = true;
    // by default we do want to only look at filtered data
    if ( typeof bFiltered == "undefined" ) bFiltered = true;
    // by default we do not want to include empty values
    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
    // list of rows which we're going to loop through
    var aiRows;
    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay;
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers
    // set up data array   
    var asResultData = new Array();
     
    for (var i=0,c=aiRows.length; i<c; i++) {
        iRow = aiRows[i];
        var aData = this.fnGetData(iRow);
        var sValue = aData[iColumn];
        // ignore empty values?
        if (bIgnoreEmpty == true && sValue.length == 0) continue;
        // ignore unique values?
        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
        // else push the value onto the result data array
        else asResultData.push(sValue);
    }
    return asResultData;
}}(jQuery));
 
 
function fnCreateSelect( aData )
{
    var r='<select><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ ) { r += '<option value="'+aData[i]+'">'+aData[i]+'</option>'; }
    return r+'</select>';
}
//fin para filtro individual por select
$(document).ready(function() {
	$( "#progressbar" ).progressbar({ value: false });
	  
	$('#dialog-subiendo').dialog({ autoOpen: false, modal: true, closeOnEscape: false, width: 620, height:150, title: 'CARGANDO ARCHIVO', closeText: '', dialogClass: 'no-close', open:function( event, ui ){ } });
	$('#dialog-alerta').dialog({ autoOpen: false, modal: true, width: 620, height:150, title: '¡ATENCIÓN!', closeText: '', open:function( event, ui ){ window.setTimeout(function(){$('#dialog-alerta').dialog('close');},2500); } });
	
	var tam = $('#referencia').height() - 150;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { myFunction();},
		"bJQueryUI": false, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, "bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[0, "asc"]], ordering: false,
		"aoColumns": [{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }],
		"iDisplayLength": 80, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>', "sAjaxSource": "datatable-serverside/estudios.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de = document.getElementById('fechaDe').value+' 00:00:00'; 
			var a = $('#fechaA').val()+' 23:59:59';
			var sucu = $('#idSuU').val();
			var acceso = $('#accesoU').val();
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } );
			aoData.push(  {"name": "sucu", "value": sucu } ); 
			aoData.push(  {"name": "acceso", "value": acceso } ); 
		},
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "&nbsp;TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw(); myFunction(); });
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */ oTable.fnFilter( this.value, $("tfoot input").index(this) ); });
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = "";myFunction(); } } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)];myFunction(); } } );
	//fin filtros individuales por campo de texto
	
	//para los filtros individuales por select
	/* Add a select menu for each TH element in the table footer */
    $("tfoot td .miSelect").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
        $('select', this).change( function () { oTable.fnFilter( $(this).val(), i ); });
    } );
	$('#s_urg').change( function () { oTable.fnFilter( $(this).val(), 3 ); myFunction(); });
	$('#s_estatus').change( function () {  oTable.fnFilter( $(this).val(), 5 ); myFunction(); });
	//fin para filtros individuales por select
	
	$('#radio1').click(function(e) { $('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	$('#radio2').click(function(e) { $('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	$( "#fechaDe" ).datepicker({
	  	defaultDate: "-1", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); },
		"onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); }
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({
		defaultDate: "+0", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); },
		"onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); }
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
	
	$('#input').jqte();
});
</script>

  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr id="mymy" bgcolor="#FF6633" style="font-size:1.2em;">
        <th id="clickme" style="color:white;">#</th>
        <th style="color:white;">PACIENTE</th>
        <th style="color:white;" width="120px;">REFERENCIA</th>
        <th style="color:white;">ESTUDIO</th>
     	<th style="color:white;" width="80px;">ESTATUS</th>
        <th style="color:white;" width="80px;">ÁREA</th>
        <th style="color:white;" width="80px;">SUCURSAL</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr bgcolor="#FF6633">
        	<td><input name="sPaciente0" id="sPaciente0" type="hidden" class="search_init" style="width:90%;" /></td>
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
            <input name="sPaciente4" id="sPaciente4" type="text" placeholder="Área" class="search_init" style="width:90%;" />
            </td>
			<td>
            <input name="sPaciente5" id="sPaciente5" type="text" placeholder="Sucursal" class="search_init" style="width:90%;" />
            </td>
        </tr>
    </tfoot>
  </table>
  
  <div id="divRangoFechas">
  <table width="" height="" border="0" cellpadding="3" cellspacing="0" width="" style="float:left; color:black">
  <tr>
    <td>De </td> <td><input name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td>A </td> <td><input name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label> 
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
  </tr>
</table>
</div>
  
  </div>
  
</div>

</div>

<div class="footer" id="footer" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle"> &copy; GLOSS <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </td> </tr> </table> </div>

<div id="dialog-captura" style="display:none; background-image:; text-align:left; background-size:cover; background-repeat:no-repeat; background-position:center;">
<form style="height:100%; width:100%;" action="" method="get" name="form-captura" id="form-captura" target="_self">
<input name="myIDestudio" id="myIDestudio" class="myIDestudio" type="hidden">
<input name="myIDusuario" type="hidden" class="myIDusuario" id="myIDusuario" value="<?php echo $row_usuario['id_u']; ?>">
<table id="tCaptura" width="100%" height="100%" border="0" cellspacing="5" cellpadding="0" style="color:white;" align="left">
  <tr>
    <td width="100px" height="1%" nowrap>Paciente</td>
    <td><span class="myPaciente"></span></td>
    <td><span class="myEdad"></span></td>
    <td><span class="mySexo"></span></td>
  </tr>
  <tr>
    <td nowrap height="1%">Referencia</td>
    <td colspan=""><span class="myReferencia"></span></td>
    <td nowrap>Fecha</td>
    <td colspan=""><span class="myFecha"></span></td>
  </tr>
  
  <tr><td colspan="" height="1%">Nota del radiólogo</td><td colspan="3"> <span class="myNotaTR"></span> </td></tr>
    
    <tr><td colspan="4" height="1%">Diagnóstico:</td></tr>
    <tr id="contieneET"><td colspan="4">
        <input style="height:90px; resize:none;" name="input" id="input" type="text" value="ESCRIBA AQUÍ EL DIAGNÓSTICO DEL ESTUDIO" class="jqte-test">
        <input name="miDiagnostico" id="miDiagnostico" type="hidden">
    </td></tr>
  
</table>

<table id="tablaUsuariosEstados" width="100%" border="0" cellspacing="0" cellpadding="2" style="color:black; font-size:0.8em;">
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td nowrap width="1%">USUARIO ASIGNÓ ESTUDIO</td>
        <td>
        <input class="campoCaptura" name="usuarioAsignaE" id="usuarioAsignaE" type="text" readonly>
        </td>
        <td nowrap width="1%">FECHA ASIGNÓ ESTUDIO</td>
        <td>
        <input class="campoCaptura" name="fechaAsignaE" id="fechaAsignaE" type="text" readonly>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td nowrap width="12.5%">USUARIO PROCESÓ</td>
        <td width="12.5%">
        <input class="campoCaptura" name="usuarioProcesoE" id="usuarioProcesoE" type="text" readonly>
        </td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%">
        <input class="campoCaptura" name="horaProcesoE" id="horaProcesoE" type="text" readonly>
        </td>
        <td nowrap width="12.5%">USUARIO REALIZA</td>
        <td width="12.5%">
        <input class="campoCaptura" name="usuarioRealizaE" id="usuarioRealizaE" type="text" readonly>
        </td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%">
        <input class="campoCaptura" name="horaRealizaE" id="horaRealizaE" type="text" readonly>
        </td>
      </tr>
      <tr>
        <td nowrap width="12.5%">USUARIO CAPTURA</td>
        <td width="12.5%">
        <input class="campoCaptura" name="usuarioCapturaE" id="usuarioCapturaE" type="text" readonly>
        </td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%">
        <input class="campoCaptura" name="horaCapturaE" id="horaCapturaE" type="text" readonly>
        </td>
        <td nowrap width="12.5%">USUARIO INTERPRETA</td>
        <td width="12.5%">
        <input class="campoCaptura" name="usuarioInterpretaE" id="usuarioInterpretaE" type="text" readonly>
        </td>
        <td nowrap width="1%">FECHA</td>
        <td width="12.5%">
        <input class="campoCaptura" name="horaInterpretaE" id="horaInterpretaE" type="text" readonly>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>

<div id="dialog-confirmCaptura" style="display:none;">
<input name="preImprimir" id="preImprimir" type="hidden">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td>¡El resultado del estudio se ha guardado satisfactoriamente!</td> </tr>
  <tr> <td style="color:red;">Recomendamos que autorice de inmediato el resultado... Se abrirá la ventana de autorización.</td> </tr>
</table>
</div>

<div id="dialog-confirmInterpretacion" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td align="center">¡El estudio se ha autorizado satisfactoriamente!</td> </tr>
  <tr> <td align="center">¿Desea imprimir el resultado del estudio?</td> </tr>
</table>
</div>

<div id="dialog-impresion" style="display:none;">
<table id="tablaImpresion" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:1px; font-family:Tahoma, Geneva, sans-serif;">
  <tr>
    <td height="3%" id="miEncabezado"><br><br><br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="50%" align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="1%" nowrap>PACIENTE: </td>
                    <td class="myPacienteP" nowrap style="font-weight:bold;"> </td>
                  </tr>
                </table>
                </td>
                <td width="50%" align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="myEdadP" align="left" width="1%" nowrap></td> 
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
                    <td nowrap width="1%" align="left">FECHA DEL ESTUDIO:</td> 
                    <td class="myFechaP" align="left" width="140px"></td> 
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
                    <td width="1%" nowrap>Dr(a). </td>
                    <td class="myMedicoP" nowrap> </td>
                  </tr>
                </table>
                </td>
                <td width="50%" align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                  	<td nowrap width="1%" align="left">UNIDAD MÉDICA:</td> 
                	<td class="myUnidadMedicaP" align="left" width="" nowrap></td>
                  </tr>
                </table>
                </td>
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td width="100%">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
              	<td width="50%" nowrap align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr> 
                    <td width="1%" nowrap align="left" style="display:none;">ESTUDIO:</td>
                    <td class="myEstudioP" align="left" width="" style="font-weight:bold;" nowrap></td> 
                  </tr>
                </table>
                </td>
                <td align="left" width="">
                	<td width="50%" align="right">
                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                          <tr> 
                            <td width="1%" nowrap align="left" style="display:;">ESTUDIO:</td>
                            <td class="myNoEstudio" align="left" width="" style="font-weight:;"></td> 
                          </tr>
                        </table>
                    </td>
                </td> 
              </tr>
            </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td style="border-top:1px dashed black; padding-top:5px; border-bottom:1px dashed black; padding-bottom:10px;" valign="top">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr height="1px">
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
              	<td width="1%" align="left" nowrap>
                <table width="100%" border="0" cellspacing="0" cellpadding="1">
                  <tr style="font-size:9px;" class="metod">
                    <td width="1%" nowrap valign="top">MUESTRA: </td>
                    <td class="myMuestraP" nowrap> </td>
                  </tr>
                </table>
                </td>
                <td width="" align="left" height="1px">
                <table width="100%" border="0" cellspacing="0" cellpadding="1">
                  <tr style="font-size:9px;" class="metod">
                    <td width="1%" nowrap align="left" valign="top">MÉTODO: </td>
                    <td class="myMetodoP" align="left" width=""></td> 
                  </tr>
                </table>
                </td>
              </tr>
            </table>
        </td>
      </tr>
      <tr style="height:99%;"> <td class="myDiagnosticoP" align="left" valign="top">a</td> </tr>
      <tr style="height:1%;"> <td class="myNotaToma" align="left" valign="top"> </td> </tr>
    </table>
    </td>
  </tr>
  <tr height="1%">
    <td class="myFirmaP">
    <table height="1%" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr height="50px"> <td width="50%">&nbsp;</td> <td class="firmaDR" align="center"> </td> </tr>
      <tr><td>&nbsp;</td> <td nowrap align="center"><span class="dr">QFB.</span>&nbsp;<span class="nombreDR">MALAN</span></td> </tr>
      <tr> <td>&nbsp;</td> <td nowrap align="center"><span class="puestoDR"></span>&nbsp;CEDULA PROFESIONAL&nbsp;<span class="cedula">1233213</span></td> </tr>
    </table>
    </td>
  </tr>
</table>
</div>

<div id="dialog-est" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="3" cellpadding="3" style="border-radius:4px;">
  <tr> <td width="1px" nowrap class="titulosTabla">PACIENTE</td> <td align="left"> <input class="campoDatosTabla" name="paciente_est" id="paciente_est" type="text" readonly style="text-align:left; width:90%;"> </td> </tr>
  <tr> <td class="titulosTabla">ESTUDIO</td> <td align="left"> <input class="campoDatosTabla" name="folio_est" id="folio_est" type="text" readonly style="text-align:left; width:90%;"> </td> </tr>
  <tr> <td class="titulosTabla">REFERENCIA</td> <td align="left"> <input class="campoDatosTabla" name="referencia_est" id="referencia_est"type="text" style="text-align:left; width:90%;" readonly> </td> </tr>
  
  <tr> <td class="titulosTabla">Osirix Local</td> <td align="left"> 
  <a href="osirix://?methodName=DownloadURL&Display=YES&URL='http://192.168.1.59:3333/wado?requestType=WADO&studyUID=1.3.51.0.7.14163771183.54367.43849.37406.22234.65265.49021'"><img src="../imagenes/osirix.png"></a> </td> <td class="titulosTabla">Osirix Internet</td> <td align="left"> 
  <a href="osirix://?methodName=DownloadURL&Display=YES&URL='http://sigma-csa.ddns.net:3333/wado?requestType=WADO&studyUID=1.3.51.0.7.14163771183.54367.43849.37406.22234.65265.49021'"><img src="../imagenes/osirix.png"></a> </td> </tr>
</table>
</div>
<input name="titleEst" id="titleEst" value="" type="hidden">

<div id="dialog-procesar" style="display:none;"> </div>

<div id="dialog-reiniciar" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td id="">¿Realmente desea reiniciar el estudio?</td> </tr> </table> </div>

<div id="dialog-alerta" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td id="miAlerta">&nbsp;</td> </tr> </table> </div>
<div id="dialog-subiendo" style="display:none;"> <div id="progressbar"></div> </div>
<div id="dialog-visualizador" style="display:none;"> </div>
<div id="dialog-pregunta" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td id="miPregunta">&nbsp;</td> </tr> </table> </div>
<div id="dialog-entregar" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%">Para entregar el estudio con referencia <span id="referenciaEntregar" style="font-weight:bold;"></span>, dé click en aceptar.</td></tr></table> </div>
<div id="dialog-informar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-informar"></span></td></tr></table></div>

<div id="dialog-editar" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#EEE">
  <tr> <td align="justify">Esta seguro de querer editar los resultados del estudio <span class="estudioEdit"></span> de la referencia <span class="referenciaEdit"></span> del paciente <span class="pacienteEdit"></span>?</td> </tr>
  <tr> <td align="left">
  	<form action="" method="post" name="formEdita" id="formEdita" target="_self">
    	Confirmar <input name="editarInterpretacionC" type="checkbox" value="" id="editarInterpretacionC">
    </form>
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

<input name="myIDestudioT" id="myIDestudioT" class="" type="hidden">
<input name="myIDpacienteT" id="myIDpacienteT" class="" type="hidden">
<input name="myNameEstudioT" id="myNameEstudioT" class="" type="hidden">

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
function entregaE(idVC){ $(document).ready(function(e) {var idVC1 = {idVC:idVC}
	$.post('files-serverside/datosEntregar.php',idVC1).done(function(data){ var datosEN = data.split(';*-'); 
		var title = 'ENTREGAR ESTUDIO. PACIENTE '+datosEN[0]; $('#referenciaEntregar').text(datosEN[1]);
		$('#dialog-entregar').dialog({ 
			autoOpen: true, modal: true, width: 700, height: 200, closeOnEscape: false, title: title, closeText: '',
			buttons: {
				'Aceptar': function() { var idVC2 = {idVC:idVC, idU:$('#idUser').val()}
					$.post('files-serverside/entregar.php',idVC2).done(function(data){ 
						if(data==1){ $('#clickme').click();
							$('#texto-informar').text('Se confirma que el estudio ha sido entregado.');
							$('#dialog-informar').dialog({ autoOpen: true, modal: true, width: 600, height:200, title: 'ESTUDIO ENTREGADO', closeText: '', 
							open:function( event, ui ){ $('#dialog-entregar').dialog('close'); $('#clickme').click(); window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000);}
							});
						}else{alert(data);}
					});
				}, 'Cerrar': function() {  $( this ).dialog( "close" ); }
			}
		});
	});
}); }

$(document).ready(function(e) {
	var tamHX = $('#referencia').height() - 100;
	var tamWX = $('#referencia').width() * 0.95;
	
	$('#dialog-pregunta').dialog({ autoOpen: false, modal: true, width: 600, height:220, title: '¡ATENCIÓN!', closeText: '', open:function( event, ui ){ } });
	
	$('#dialog-procesar').dialog({ autoOpen: false, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close' });//fin del dialog procesar
	
	$('#dialog-impresion').dialog({
		autoOpen: false, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: true, closeText:'', title: "IMPRESIÓN HOJA DE RESULTADO",
		buttons: { Imprimir: function(){ $('#tablaImpresion').printElement(); }, Cerrar: function() { $(this).dialog("close"); } }
	});//fin del dialog impresion
	
    $('#dialog-captura').dialog({
		autoOpen: false, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: true, closeText:'',
		close: function( event, ui ) { document.getElementById('form-captura').reset(); }
	});//fin del dialog rMasto
	
	$('#dialog-confirmInterpretacion').dialog({
		autoOpen:false,modal:true,title:'CONFIRMACIÓN ESTUDIO AUTORIZADO',width:550,height:230,resizable:false,closeText:'', closeOnEscape: true,
		buttons:{ 
			'Imprimir': function(){ 
				imprimir($('#myIDpacienteT').val(),$('#myIDestudioT').val(), $('#myNameEstudioT').val()); 
				$('#dialog-confirmInterpretacion').dialog('close');
			}, 
			'Cerrar': function(){ $('#dialog-confirmInterpretacion').dialog('close'); } }
	});
});
function myFunction(){
 setTimeout(function(){
	$(document).ready(function(e) {
		var allBotonesIcono = $('.botonaso'); allBotonesIcono.css('width','25px').css('height','25px');
		
		$('.icono_proceso').button({      icons: { primary: "ui-icon-gear"},     text: false });
        $('.icono_realizado').button({    icons: { primary: "ui-icon-comment"},     text: false });
	    $('.icono_capturado').button({    icons: { primary: "ui-icon-check"},     text: false });
	    $('.icono_interpretado').button({ icons: { primary: "ui-icon-search"},   text: false });
		$('.icono_imprimir').button({     icons: { primary: "ui-icon-print"},    text: false });
		$('.icono_entregar').button({     icons: { primary: "ui-icon-person"},    text: false });
		$('.icono_cargado').button({     icons: { primary: "ui-icon-document"},    text: false });
		$('.miPDF').button({              icons: { primary: "ui-icon-document"}, text: false });
		$('.updatePDF').button({          icons: { primary: "ui-icon-refresh"},  text: false });
		
		$('.botonaso').click(function(event) { event.preventDefault(); });
	});
 },9);
}//fin myFunction
function visualizar(x){ var x1=x; x='takeArchivos/pdf/'+x+'.pdf'; 
	$("#dialog-visualizador").load('htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { if ( status == "success" ) {
		$('#dialog-visualizador').dialog({
			title: 'ARCHIVO PDF DEL RESULTADO', modal: true, autoOpen: true,
			closeText: '', width: 800, height: 600, closeOnEscape: true, dialogClass: '',
			buttons: { 
				"ELIMINAR": function() {
					$('#miPregunta').text('¿Desea eliminar este archivo PDF?'); 
					$('#dialog-pregunta').dialog({
						title:'ELIMINAR PDF', closeOnEscape: false, dialogClass: "no-close",
						buttons: {
							"Eliminar": function() {
								var idX = {idPDF: x1+'.pdf', idU:$('#idUser').val(), idE:x1}
								$.post('takeArchivos/eliminarArchivo.php',idX).done(function( data ) {
									if(data==1){ $('#clickme').click();
										$('#miAlerta').text('EL ARCHIVO SE ELIMINÓ CORRECTAMENTE');
										$('#dialog-alerta').dialog({title:'CONFIRMACIÓN'});$('#dialog-alerta').dialog('open');
										$('#dialog-pregunta').dialog('close'); $('#dialog-visualizador').dialog('close');
									}
								});
							},
							Cancelar: function() { $('#dialog-pregunta').dialog( "close" ); }
						}
					});
					$('#dialog-pregunta').dialog('open');
				}, 
				"CERRAR": function() { $(this).dialog('close'); }
		  }, 
		  open:function( event, ui ){$('a.media').media({width:750, height:450, src:x});}, 
		  close:function( event, ui ){ $("#dialog-visualizador").empty();}
		}); 
	} });
}
</script>
<script>
    $(function() {
	$('#dialog-confirmCaptura').dialog({
		autoOpen:false, modal:true,title:'CONFIRMACIÓN CAPTURA DE RESULTADOS', width:600, height:200, resizable:false, closeText:'', 
		closeOnEscape: true,
		open: function( event, ui ) { setTimeout(function(){$('#dialog-confirmCaptura').dialog('close');},3500); }, 
		close: function( event, ui ) { interpretar($('#myIDpacienteT').val(),$('#myIDestudioT').val(),$('#myNameEstudioT').val()); }
	});
	
        $( "#dialog-upload" ).dialog({
            autoOpen:false, show:"blind", modal:true, width:900, height: 650, hide:"explode", resizable: false, closeOnEscape: false,
			buttons: {
				"Guardar": function() {
					var datox ={estatus:'ENTREGADO', interpretacion:window.frames.miFrame.hola(), id_vc_ini:$('#id_vc_ini').val(), usuario_ini:$('#usuario_ini').val()}
					$.post('archivos_save_ajax/edoPendienteAentregado.php', datox, processData);
					function processData(data){ console.log(data); if(data == "ok"){$( this ).dialog( "close" );}else{alert(data);} }
				},
				"Cancelar": function() { $( this ).dialog( "close" ); }
			},
        });
		$('#upload_button1').button({ icons: { primary: "ui-icon-folder-open" } });
    });//fin ready

function procesar(a,b){//a es el id del paciente y b es el id del estudio en venta de conceptos
	$(document).ready(function(e) {
			$("#dialog-procesar").load('htmls/procesar.php', function( response, status, xhr ) {
				if ( status == "success" ) {
					$('#observacionPro').prop('readonly',false);
					//para los checkbox de la ventana de proceso
					$('#individualPro').click(function(e) { 
						if($(this).prop('checked')==true){ 
							$('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();
						}else{ $('#individualPro').prop('checked',true); } 
					});
					$('#variosPro').click(function(e) { 
						if($(this).prop('checked')==true){ 
							$('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();
						}else{ $('#variosPro').prop('checked',true); } });
					
					$('#idPacientePro').val(a); $('#idEstudioPro').val(b); var datoP = {idP:a, idE:b}
					$.post('archivos_save_ajax/datosProcesar.php', datoP).done(function( data ) { 
						var datosP = data.split('*}'); 
						$('#pacientePro').val(datosP[0]); $('#refPro').val(datosP[1]); $('#ordenPro').text(datosP[1]); 
						$('#estPro').val(datosP[2]); $('#areaPro').val(datosP[3]); $('#observacionPro').val(datosP[4]);
						$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); 
						$('#checaPro').val(0); $('#notificacionPro').hide();
						
						if(datosP[5]>1){$('.variosEstu').show();$('#checaPro').val(0);}else{$('.variosEstu').hide();$('#checaPro').val(1); }
						
						var tamHX = $('#referencia').height() - 95; var tamWX = $('#referencia').width() * 0.98;
						$('#dialog-procesar').dialog({
							autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close',
							close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
							buttons: {
								Procesar: function(){
									var e = 0;
									if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
									else{
										if (e==0){
											e++;
											$('#idUserPro').val($('#idUser').val());
											var datoP = $('#form-procesar').serialize();
											$.post('archivos_save_ajax/procesar.php', datoP).done(function( data ) { 
											if (data == 1){ 
												$('#clickme').click(); $('#dialog-procesar').dialog('close');
											}else{alert(data);} });
										}
									}
								},
								Cancelar: function() { $(this).dialog("close"); }
							}
						});
					});
			  	}
			});
    });
}
function realizar(a,b,n){//a es el id del paciente y b es el id del estudio en venta de conceptos
$(document).ready(function(e) {
	$("#dialog-procesar").load('htmls/capturar.php #fichaProcesar', function( response, status, xhr ) {
		if ( status == "success" ) { 
			
			$('#idPacientePro').val(a); $('#idEstudioPro').val(b); 
			var datoP = {idP:a, idE:b}
			$.post('archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
				var datosP = data.split('*}');
				$('#pacientePro').text(datosP[0]); $('#ordenPro').text(datosP[1]); $('#observacionPro').text(datosP[4]);
				$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]);
				
				//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
				switch(n){
					case 'BIOMETRIA HEMATICA':
						$("#misResultados").load('files-serverside/capturarResultadosBH.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'EXAMEN GENERAL DE ORINA':
						$("#misResultados").load('files-serverside/capturarResultadosEGO.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROLOGICO':
						$("#misResultados").load('files-serverside/capturarResultadosCoprologico.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO UNICO':
						$("#misResultados").load('files-serverside/capturarResultadosCoproparasitoscopio1.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO (2M)':
						$("#misResultados").load('files-serverside/capturarResultadosCoproparasitoscopio2.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO SERIADO':
						$("#misResultados").load('files-serverside/capturarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPIO (3)':
						$("#misResultados").load('files-serverside/capturarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					default:
						$("#misResultados").load('files-serverside/capturarResultados.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
				}

				var miTitle = 'CAPTURAR RESULTADOS -'+datosP[2]+'- '+datosP[1];
				
				var tamHX = $('#referencia').height() - 95; var tamWX = $('#referencia').width() * 0.98;
				$('#dialog-procesar').dialog({
					autoOpen: true, modal: true, width: 880, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', 
					title: miTitle, dialogClass: 'no-close',
					close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
					open: function(event,ui){
						$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');
						$('#myIDestudioT').val(b);$('#myIDpacienteT').val(a); $('#myNameEstudioT').val(n);
						//del pdf
						$('.mipdf').each(function(index, element) {//alert(index);
							var button = $(this), interval; var idP=b;
							new AjaxUpload(button,{
								action: 'takeArchivos/subirPdfPoliza.php?action=&key='+idP, name: 'image',
								onSubmit : function(file, ext){
									if(ext != 'PDF' & ext != 'pdf'){ $('#miAlerta').text('DEBE SELECCIONAR UN ARCHIVO PDF');$('#dialog-alerta').dialog({title:'ALERTA', buttons: {}});$('#dialog-alerta').dialog('open');return false;
									}else{$('#dialog-subiendo').dialog('open');}
									//$(this).button('disable');// desabilitar el boton
								},
								onComplete: function(file, response){//alert('x');
									$('#dialog-subiendo').dialog('close');
									$('#miAlerta').text('EL ARCHIVO SE HA CARGADO SATISFACTORIAMENTE');
									$('#dialog-alerta').dialog({title:'CONFRMACIÓN'});$('#dialog-alerta').dialog('open');
									var URL='takeArchivos/pdf/'+idP+'.pdf';
									var datosCargar = {idE:idP, idU:$('#idUser').val()}
									$.post('archivos_save_ajax/cargar.php', datosCargar).done(function( data ) { if (data == 1){ 
										$('#clickme').click();
										$('#dialog-procesar').dialog('close');
									}else{alert(data);} });
									window.clearInterval(interval); 
								}
							});//Fin del pdf 
						});
					},
					buttons: {
						Guardar: function(){
							$('#form-procesar').validate();
							$('#idUserPro').val($('#idUser').val());
							if( $('#form-procesar').valid() ){
								var datoP = $('#form-procesar').serialize();
								$.post('archivos_save_ajax/realizar.php', datoP).done(function( data ) { 
									if (data == 1){ 
										$('#clickme').click(); $('#dialog-procesar').dialog('close');
										$('#dialog-confirmCaptura').dialog('open');
									}else{alert(data);}
								});
							}
							
						},
						Cancelar: function() { $(this).dialog("close"); },
						Reiniciar: function() { 
							$('#dialog-reiniciar').dialog({
								autoOpen: true, modal: true, width: 600, height: 200, resizable: false, closeOnEscape: false,
								closeText:'', title: "REINICIAR ESTUDIO", dialogClass: 'no-close',
								close: function( event, ui ) { $('#dialog-reiniciar').dialog('destroy');},
								buttons: {
									Reiniciar: function(){
										var dato = {idEvc : b}
										$.post('archivos_save_ajax/reiniciar.php', dato).done(function( data ) { 
										if (data == 1){
											$('#clickme').click(); $('#dialog-reiniciar').dialog('close');
											$('#dialog-procesar').dialog('close');
										}else{alert(data);} });
									},
									Cancelar: function() { $(this).dialog("close"); }
								}
							});
						}
					}
				});
			});
		}
	});
});
}
function interpretar(a,b,n){ $(document).ready(function(e) { //a es el id del paciente y b del estudio en vc en venta de conceptos
	$("#dialog-procesar").load('htmls/capturar.php #fichaProcesar', function( response, status, xhr ) {
		if ( status == "success" ) {
			$('#cargaPDF').hide();
			$('#idPacientePro').val(a); $('#idEstudioPro').val(b); 
			var datoP = {idP:a, idE:b}
			$.post('archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
				var datosP = data.split('*}');
				$('#pacientePro').text(datosP[0]); $('#ordenPro').text(datosP[1]); $('#observacionPro').text(datosP[4]);
				$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]);
				
				//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
				switch(n){
					case 'BIOMETRIA HEMATICA':
						$("#misResultados").load('files-serverside/interpretarResultadosBH.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'EXAMEN GENERAL DE ORINA':
						$("#misResultados").load('files-serverside/interpretarResultadosEGO.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROLOGICO':
						$("#misResultados").load('files-serverside/interpretarResultadosCoprologico.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO UNICO':
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio1.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO (2M)':
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio2.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPICO SERIADO':
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					case 'COPROPARASITOSCOPIO (3)':
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
					break;
					default:
						$("#misResultados").load('files-serverside/interpretarResultados.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
				}

				var miTitle = 'INTERPRETAR RESULTADOS -'+datosP[2]+'- '+datosP[1];
				
				var tamHX = $('#referencia').height() - 95; var tamWX = $('#referencia').width() * 0.98;
				$('#dialog-procesar').dialog({
					autoOpen: true, modal: true, width: 880, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', 
					title: miTitle, dialogClass: 'no-close',
					close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
					open: function(event,ui){
						$('#myIDestudioT').val(b);$('#myIDpacienteT').val(a); $('#myNameEstudioT').val(n);
						$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');
					},
					buttons: {
						AUTORIZAR: function(){
							$('#form-procesar').validate();
							$('#idUserPro').val($('#idUser').val());
							if( $('#form-procesar').valid() ){
								var datoP = $('#form-procesar').serialize();
								$.post('archivos_save_ajax/autorizado.php', datoP).done(function( data ) { 
									if (data == 1){ 
										$('#clickme').click(); $('#dialog-procesar').dialog('close');
										$('#dialog-confirmInterpretacion').dialog('open');
									}else{alert(data);}
								});
							}
							
						},
						Cancelar: function() { $(this).dialog("close"); }
					}
				});
			});
		}
	});
}); }

function imprimir(a,b,n){$(document).ready(function(e) { //a es el id del paciente y b del estudio en vc en venta de conceptos
	$("#dialog-procesar").load('htmls/capturar.php #fichaProcesar', function( response, status, xhr ) {
		if ( status == "success" ) {
			$('#cargaPDF').hide();
			$('#idPacientePro').val(a); $('#idEstudioPro').val(b); 
			var datoP = {idP:a, idE:b}
			$.post('archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { 
				var datosP = data.split('*}');
				$('#pacientePro,.myPacienteP').text(datosP[0]);$('#ordenPro, .myReferenciaP').text(datosP[1]); 
				$('#observacionPro').text(datosP[4]);
				$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); 
				$('.myNotaToma').html('<em>OBSERVACIONES</em>: '+datosP[8]);
				$('.myEstudioP').text(datosP[2]); $('.myFnacP').text(datosP[9]); $('.mySexoP').text(datosP[10]);
				$('.myEdadP').text('EDAD: '+datosP[11]+' - '); $('.myFechaP').text(datosP[12]); 
				$('.myMedicoP').text(datosP[13]); $('.dr').text(datosP[18]); $('.myUnidadMedicaP').text(datosP[19]);
				$('.nombreDR').text(datosP[14]); $('.cedula').text(datosP[15]); $('.myMuestraP').text(datosP[16]+'. '); 
				$('.myMetodoP').text(datosP[17]); $('.myNoEstudio').text(datosP[20]);
				$('.firmaDR').html('');
				if(datosP[21]!='.png' || datosP[21]!='.jpg'){
					$('.firmaDR').html('<img src="../usuarios/takePicture/firmas/'+datosP[21]+'" width="" height="75">');
				}
				$("#misResultados").load('files-serverside/interpretarResultados.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {} });
				//aquí hacer que cuando sea la bh cambie de archivo para imprimir los resultados
				switch(n){
					case 'BIOMETRIA HEMATICA':
						$(".myDiagnosticoP").load('files-serverside/imprimirResultadosBH.php?idE='+b, function(response,status,xhr){if ( status == "success" ) { $('#fichaProcesar, #tablaImpresion').css('font-size','0.75em'); } });
						$("#misResultados").load('files-serverside/pre_imprimirResultadosBH.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
					break;
					case 'EXAMEN GENERAL DE ORINA':
						$(".myDiagnosticoP").load('files-serverside/imprimirResultadosEGO.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
						$("#misResultados").load('files-serverside/interpretarResultadosEGO.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
					break;
					case 'COPROLOGICO':
						$(".myDiagnosticoP").load('files-serverside/imprimirResultadosCoprologico.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
						$("#misResultados").load('files-serverside/interpretarResultadosCoprologico.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
					break;
					case 'COPROPARASITOSCOPICO UNICO':
						$(".myDiagnosticoP").load('files-serverside/imprimirResultadosCoproparasitoscopio1.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio1.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
					break;
					case 'COPROPARASITOSCOPICO (2M)':
						$(".myDiagnosticoP").load('files-serverside/imprimirResultadosCoproparasitoscopio2.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio2.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
					break;
					case 'COPROPARASITOSCOPICO SERIADO':
						$(".myDiagnosticoP").load('files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
					break;
					case 'COPROPARASITOSCOPIO (3)':
						$(".myDiagnosticoP").load('files-serverside/imprimirResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
						$("#misResultados").load('files-serverside/interpretarResultadosCoproparasitoscopio3.php?idE='+b, function(response,status,xhr){if ( status == "success" ) {$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em');} });
					break;
					default:
						$(".myDiagnosticoP").load('files-serverside/imprimirResultados.php?idE='+b, function(response,status,xhr){if ( status == "success" ) { 
							$('#fichaProcesar, #tablaImpresion').css('font-size','0.75em'); 
						} });
				}

				var miTitle = 'IMPRIMIR - '+datosP[2]+'- '+datosP[1];
				
				var tamHX = $('#referencia').height() - 95; var tamWX = $('#referencia').width() * 0.98;
				$('#dialog-procesar').dialog({
					autoOpen: true, modal: true, width: 880, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', 
					title: miTitle, dialogClass: 'no-close',
					close: function( event, ui ) { $('#dialog-procesar').dialog('destroy'); },
					buttons: {
						Imprimir: function(){
							$('#dialog-impresion').show(); 
							$('#tablaImpresion *').not( document.getElementsByClassName('metod') ).css('font-size','1.01em');
							$('#notaF').css('font-size','0.8em'); 
							$('#dialog-impresion').printElement(); $('#dialog-impresion').hide();
						},
						Editar: function() { 
							$('#dialog-editar').dialog({
								autoOpen: false, modal: true, width: 750, height: 270, resizable: false, closeOnEscape: true,
								closeText:'', title: "EDITAR LA INTERPRETACIÓN",
								buttons: {
									Editar: function(){ 
										if($('#editarInterpretacionC').prop('checked')==false){
											$('#errorEditar').show('shake');
											window.setTimeout(function(){$('#errorEditar').hide();},1000);
										}else{
											var dato = { idE:b, idU:$('#idUser').val() }
											$.post('files-serverside/editarInterpretacion.php', dato).done(function( data ) {
												if(data==1){
													$('#dialog-editar').dialog('close');
													$('#clickme').click();
													//dialog-confirmacion
													$('#dialog-confirmacion').dialog({
														autoOpen: true, modal: true, width: 600, height: 150, resizable: false, 
														closeOnEscape: true, 
														closeText:'', title: "EDICIÓN LISTA", dialogClass: '',
														open: function( event, ui ) {
															$('#textoConfirma').text('!El estudio está listo para edición!');
															window.setTimeout(function(){
																$('#dialog-confirmacion').dialog('close');
																var a_1 = a, b_1 = b, n_1 = n;
																$('#dialog-procesar').dialog('close');
																interpretar(a_1,b_1,n_1);
															},2000);
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
									$('.estudioEdit').text(datosP[2]);$('.referenciaEdit').text(datosP[1]);
									$('.pacienteEdit').text(datosP[0]);
								},
								close: function( event, ui ) {document.getElementById('formEdita').reset();}
							});//fin del dialog editar
							//alert($('#accesoU').val());
							if($('#accesoU').val()==1 || $('#accesoU').val()==6){$('#dialog-editar').dialog('open');}
							else{$('#dialog-alertar').dialog('open');}
						},
						Cerrar: function() { $(this).dialog("close"); }
					}
				});
			});
		}
	});
}); }//Fin imprimir
function est(a,b){ //a es el id del estudio, b es el id del estudio ambos en venta de conceptos
	$(document).ready(function(e) {
		var idE = {idE:a}
		$.post('files-serverside/datosInterpretar.php',idE,respEST);
		function respEST(dato){//alert(dato);
			var dataE = dato.split(';*-');
			if(dataE[0]!=''){$('#referencia_est').val(dataE[12]); $('#paciente_est').val(dataE[0]); $('#folio_est').val(dataE[8]); }
		}
		$('#dialog-est').dialog('open');
	});
}
</script>