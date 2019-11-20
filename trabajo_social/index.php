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

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.  // Parse the strings into arrays. 
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
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/favicon.ico">
<meta charset="utf-8">
<title>TRABAJO SOCIAL</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../css/tsocial.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../DataTables-1.10.5/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../chart_1.0.2/Chart.min.js"></script>
<script type="text/javascript" src="../funciones/js/jquery.media.js"></script> 
<script type="text/javascript" src="../funciones/js/jquery.fileDownload.js"></script>

<script>
$( document ).tooltip({ extraClass: "arrow",position: { my: "center bottom-10",	at: "center top" } });

$(document).ready(function(e) {
	$('#form-captura').validate({ rules:{ diagnostico:{ required:true } }, messages:{ diagnostico:{ required:'Debe ingresar el diagnóstico' } } });
	
	$('#misDatosUsuario').hide(); var dj = 1;
	 
	$('.miUsuario').click( function(e) { dj++; if(dj%2==0){ $('#misDatosUsuario').stop().show('explode','slow'); }else{ $('#misDatosUsuario').stop().hide('explode','slow'); } } );
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75); var cy = $('#header table').height() +0;

	$('#misDatosUsuario').css('right',cx).css('top',cy);
});

</script>

<script>
$(document).ready(function(e) { $('#miMenu').hide(); $('#verMenu').click(function(e) { verMenu(); }); });

function verMenu(){ $(document).ready(function(e) { $('#miMenu').show('fold','slow'); $('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">TRABAJO SOCIAL</span>'); }); }

function ocultarMenu(){ $(document).ready(function(e){ $('#miMenu').hide('fold','slow'); $('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">TRABAJO SOCIAL</span>'); }); }
</script>

<script type="text/javascript">
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
{ var r='<select><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ ) { r += '<option value="'+aData[i]+'">'+aData[i]+'</option>'; }
    return r+'</select>';
}
//fin para filtro individual por select
$(document).ready(function() {
	
	var tam = $('#referencia').height() - 135;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  
			myFunction(); $('span.DataTables_sort_icon').remove();
		},
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
		"bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bSortable": false },
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
		],
		"iDisplayLength": 1000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>',
		 "sAjaxSource": "datatable-serverside/consultas.php?idU="+$('#idUser').val(),
		"fnServerParams": function (aoData, fnCallback) { 
			var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59'; 
			aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } ); 
		},
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { 
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "MOSTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "&nbsp;TOTAL DE CONSULTAS: _MAX_", 
			"sSearch": "BUSCAR" 
		}
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw(); myFunction(); });
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); } );
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = "";myFunction(); } } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)];myFunction(); } } );
	
	//para los filtros individuales por select /* Add a select menu for each TH element in the table footer */
    $("tfoot td .miSelect").each( function ( i ) { this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) ); $('select', this).change( function () { oTable.fnFilter( $(this).val(), i ); } ); } );
	$('#s_urg').change( function () { oTable.fnFilter( $(this).val(), 3 ); myFunction(); } );
	$('#s_estatus').change( function () { oTable.fnFilter( $(this).val(), 5 ); myFunction(); } );
	//fin para filtros individuales por select
	
	$('#radio1').click(function(e) { $('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	
	$('#radio2').click(function(e) { $('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); });
	$( "#fechaDe" ).datepicker({ defaultDate: "-1", maxDate: +0, onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); }, "onSelect": function(date) { min = date+' 00:00:00'; oTable.fnDraw(); } }).css('max-width','100px');
	$( "#fechaA" ).datepicker({ defaultDate: "+0", maxDate: +0, onClose: function( selectedDate ) { $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); }, "onSelect": function(date) { max = date+' 23:59:59'; oTable.fnDraw(); } }).css('max-width','100px');
			
});
</script>

<script>
jQuery(function($){
    $.datepicker.regional['es'] = {//dateFormat: 'mm/dd/yy',
        closeText: 'Cerrar', changeMonth: true, changeYear: true, numberOfMonths: 3, dateFormat: "yy-mm-dd", prevText: '&#x3c;Ant', nextText: 'Sig&#x3e;', currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun', 'Jul','Ago','Sep','Oct','Nov','Dic'], dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'], dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'], weekHeader: 'Sm', firstDay: 1, isRTL: false, showMonthAfterYear: false, yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});
$(document).ready(function(e) {
	$('#divRangoFechas').css('width','80%').css('float','left').css('border-width','1px').css('border-style','none').css('color','white'); $( '#rangosFechas' ).buttonset().css('font-size','0.9em'); $('.rad').css('font-size','0.8em');
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="fechaHoy" type="hidden" id="fechaHoy" value="<?php echo date("d/m/Y"); ?>">

<input name="nombreTempPdf" id="nombreTempPdf" type="hidden" value="">

<input name="id_vc_ini" id="id_vc_ini" type="hidden" value="">
<input name="usuario_ini" id="usuario_ini" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
<input name="campoUrl" id="campoUrl" type="hidden" value="">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../imagenes/iconitos/_icono_trabajo_social.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">TRABAJO SOCIAL</span></td>
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
                <td nowrap valign="middle" class="usuarioPerfil"> <?php echo $row_usuario['usuario_u']; ?> </td>
              </tr>
            </table>
    <div id="misDatosUsuario">
    <table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr>
            <td>
            <?php if($row_usuario['foto_u'] == 1){?> <img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80"> <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
            <?php }?>
            </td>
            <td align="left" valign="top" class="nombreUsuario"><?php echo $row_usuario['nombre_u']." ".$row_usuario['apaterno_u']." ".$row_usuario['amaterno_u']; ?> </td>
        </tr>
    </table>
    
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0"> <tr> <td style="font-size:0.8em;" align="center"><span style="text-decoration:underline; cursor:pointer;"><a href="<?php echo $logoutAction ?>">CERRAR SESIÓN</a></span></td> </tr> </table>
    </div>
        </td>
      </tr>
    </table>
</div>

<div id="miMenu" class="miMenu">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
  <tr valign="middle" class="fondoMenu">
    <td class="eii"><img title="MENÚ ANTERIOR" src="../imagenes/submenu/_rehabilitacion.png" width="100" onClick="window.location='../menu_rehabilitacion.php'"></td>
    <td class="eid"><img title="INICIO" src="../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../menu.php'"></td>
  </tr>
</table>
</div>

<div class="contenido" id="contenido" align="center">
  <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr class="grisecito" style="font-size:1.2em;">
        <th id="clickme" width="120px" style="color:white;" nowrap>FECHA INGRESO</th>
        <th style="color:white;">PACIENTE</th>
        <th width="10px" style="color:white;" nowrap>ESTATUS</th>
     	<th width="80px" style="color:white;" nowrap>U INGRESO</th>
        <th nowrap width="80px" style="color:white;" nowrap>U REFIRIÓ</th>
		<th nowrap width="110px" style="color:white;" nowrap>FECHA REFIRIÓ</th>
        <th width="100px" style="color:white;" nowrap>FIN TERAPIA</th>
		<th width="100px" style="color:white;" nowrap>ESTUDIO SE</th>
        <th width="10px" style="color:white;" nowrap>NIVEL</th>
        <th width="10px" style="color:white;" nowrap>REFERIR</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr bgcolor="#FF6633">
        	<td><input name="sPaciente" id="sPaciente" type="hidden" value="" class="search_init"></td>
        	<td>
            <input name="sPaciente1" id="sPaciente1" type="text" placeholder="Paciente" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sEstatus" id="sEstatus" type="text" placeholder="Estatus" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sUingreso" id="sUingreso" type="text" placeholder="Ingresó" class="search_init" style="width:90%;" />
            </td>
     		<td>
            <input name="sUrefiere" id="sUrefiere" type="text" placeholder="Refirió" class="search_init" style="width:90%;" />
            </td>
			<td>
            <input name="sFrefiere" id="sFrefiere" type="text" placeholder="Fecha" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sFfin" id="sFfin" type="text" placeholder="Fecha" class="search_init" style="width:90%;" />
            </td>
            <td><input name="sPaciente" id="sPaciente" type="hidden" value="" class="search_init"></td>
            <td>
            <input name="sNivel" id="sNivel" type="text" placeholder="Nivel" class="search_init" style="width:90%;" />
            </td>
            <td> </td>
        </tr>
    </tfoot>
  </table>
  
<div id="divRangoFechas" style="border:2px none red; display:block; width:60%; float:left;">
  <table width="100%" border="0" cellpadding="4" cellspacing="0" style="color:black;">
  <tr>
    <td width="10px">De </td>
    <td width="1%">
    	<input style="height:80%; font-size:1.1em; border-radius:4px;" name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly >
    </td>
    <td width="10px">A </td>
    <td width="1%">
    	<input style="height:80%; font-size:1.1em; border-radius:4px;" name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly >
    </td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
  </tr>
</table>
</div>
  
</div>

<div class="footer" id="footer" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle"> &copy; GLOSS <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </td> </tr> </table> </div>

<div id="dialog" style="display:none;"> </div>
<div id="dialog1" style="display:none;"> </div>
<div id="dialog-buscar" style="display:none;"> </div>

<div id="dialog-preguntar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-preguntar" style="text-align:justify;"></span></td></tr></table></div>

<div id="dialog-informar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-informar"></span></td></tr></table></div>

<div id="dialog-receta" style="display:none;"> </div>
<div id="dialog-graficas" style="display:none;"> </div>
<div id="dialog-nuevo" style="display:none;"> </div>

<div id="dialog-hacer-es" style="display:none; overflow:hidden;">
<form action="" method="post" name="form-estudio-se" id="form-estudio-se" target="_self" style="border:1px none green;">
<div id="miTabsH" style="float:left; display:block; border:1px none red; width:100%; height:100%; margin-top:-12px">
<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="">
  <tr>
    <td id="">
    <ul id="pestanas1" style="float:left;">
        <li><a class="tabs" id="tabs-1-1h" href="#tabs-1h">INGRESOS</a></li>
        <li><a class="tabs" id="tabs-2-1h" href="#tabs-2h">EGRESOS</a></li>
        <li><a class="tabs" id="tabs-3-1h" href="#tabs-3h">VIVIENDA</a></li>
        <li><a class="tabs" id="tabs-4-1h" href="#tabs-4h">SALUD</a></li>
        <li><a class="tabs" id="tabs-5-1h" href="#tabs-5h">ALIMENTACIÓN</a></li>
        <li><a class="tabs" id="tabs-6-1h" href="#tabs-6h">RECREACIÓN</a></li>
        <li><a class="tabs" id="tabs-7-1h" href="#tabs-7h">DX SOCIAL</a></li>
    </ul>
    </td>
  </tr>
</table>

<div class="miTab" id="tabs-1h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tablaTS">
  <tr align="center" class="ui-widget-header cabecera2">
    <td width="">EGRESO MENSUAL</td>
    <td nowrap width="150px">MONTO $</td>
  </tr>
  <tr>
    <td align="center">
    <input class="concepto" name="conceptoI1" type="text" id="conceptoI1" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" placeholder="Concepto 1">
    </td>
    <td align="center">
    <input class="ingreso" name="ingreso1" type="text" id="ingreso1" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="center">
    <input class="concepto" name="conceptoI2" type="text" id="conceptoI2" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" placeholder="Concepto 2">
    </td>
    <td align="center"><input class="ingreso" name="ingreso2" type="text" id="ingreso2" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);"></td>
  </tr>
  <tr>
    <td align="center">
    <input class="concepto" name="conceptoI3" type="text" id="conceptoI3" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" placeholder="Concepto 3">
    </td>
    <td align="center"><input class="ingreso" name="ingreso3" type="text" id="ingreso3" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);"></td>
  </tr>
  <tr>
    <td align="center">
    <input class="concepto" name="conceptoI4" type="text" id="conceptoI4" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" placeholder="Concepto 4">
    </td>
    <td align="center"><input class="ingreso" name="ingreso4" type="text" id="ingreso4" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);"></td>
  </tr>
  <tr>
    <td align="center">
    <input class="concepto" name="conceptoI5" type="text" id="conceptoI5" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" placeholder="Concepto 5">
    </td>
    <td align="center"><input class="ingreso" name="ingreso5" type="text" id="ingreso5" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);"></td>
  </tr>
  <tr class="ui-widget-header cabecera2">
    <td align="right">TOTAL DE INGRESO MENSUAL</td>
    <td align="center"><span id="totalIngresos">$0.00</span></td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-2h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tablaTS">
  <tr align="center" class="ui-widget-header cabecera2">
    <td width="" align="right">EGRESO MENSUAL</td>
    <td width="150px">MONTO $</td>
    <td width="" align="right">EGRESO MENSUAL</td>
    <td width="150px">MONTO $</td>
  </tr>
  <tr>
    <td align="right">Alimentación</td>
    <td align="center">
    <input class="egreso" name="egreso1" type="text" id="egreso1" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Transporte</td>
    <td align="center">
    <input class="egreso" name="egreso2" type="text" id="egreso2" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right">Gas O Combustible</td>
    <td align="center">
    <input class="egreso" name="egreso3" type="text" id="egreso3" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Educación</td>
    <td align="center">
    <input class="egreso" name="egreso4" type="text" id="egreso4" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right">Renta</td>
    <td align="center">
    <input class="egreso" name="egreso5" type="text" id="egreso5" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Gastos médicos</td>
    <td align="center">
    <input class="egreso" name="egreso6" type="text" id="egreso6" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right">Agua</td>
    <td align="center">
    <input class="egreso" name="egreso7" type="text" id="egreso7" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Recreación</td>
    <td align="center">
    <input class="egreso" name="egreso8" type="text" id="egreso8" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right">Predial</td>
    <td align="center">
    <input class="egreso" name="egreso9" type="text" id="egreso9" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Abonos o créditos</td>
    <td align="center">
    <input class="egreso" name="egreso10" type="text" id="egreso10" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right">Electricidad (Luz)</td>
    <td align="center">
    <input class="egreso" name="egreso11" type="text" id="egreso11" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Ropa y calzado</td>
    <td align="center">
    <input class="egreso" name="egreso12" type="text" id="egreso12" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right">Teléfono</td>
    <td align="center">
    <input class="egreso" name="egreso13" type="text" id="egreso13" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Fondos de ahorro,tandas ,prestamos</td>
    <td align="center">
    <input class="egreso" name="egreso14" type="text" id="egreso14" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr>
    <td align="right">Teléfono celular</td>
    <td align="center">
    <input class="egreso" name="egreso15" type="text" id="egreso15" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
    <td align="right">Crédito para construcciónde vivienda</td>
    <td align="center">
    <input class="egreso" name="egreso16" type="text" id="egreso16" placeholder="0" onKeyUp="numeros_decimales(this.value, this.name);">
    </td>
  </tr>
  <tr class="ui-widget-header cabecera2">
    <td align="right" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td align="right">TOTAL DE EGRESOS MENSUALES</td>
            <td align="left"><span id="totalEgresos">$0.00</span></td>
            <td align="right">SUPERÁVIT</td>
            <td align="left"><span id="superavit">$0.00</span></td>
            <td align="right">DÉFICIT</td>
            <td align="left"><span id="deficit">$0.00</span></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-3h">
<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tablaTS">
  <tr class="cabecera2">
    <td align="center" colspan="4">DATOS GENERALES DE LA VIVIENDA</td>
  </tr>
  <tr>
    <td align="left" width="" nowrap>
    <select name="tenenciaVivienda" id="tenenciaVivienda" style="width:80;" class="selecciona">
      <option value="">-TENENCIA-</option>
      <option value="PROPIA">PROPIA</option>
      <option value="RENTADA">RENTADA</option>
      <option value="PRESTADA">PRESTADA</option>
      <option value="INVADIDA">INVADIDA</option>
    </select>
    </td>
    <td align="left" width="" nowrap>
    <select name="tipoVivienda" id="tipoVivienda" style="width:;" class="selecciona">
      <option value="">-TIPO-</option>
      <option value="CASA SOLA">CASA SOLA</option>
      <option value="VECINDAD">VECINDAD</option>
      <option value="CAMPAMENTO">CAMPAMENTO</option>
      <option value="ALBERGUE">ALBERGUE</option>
      <option value="ACCESORIA">ACCESORIA</option>
    </select>
    </td>
    <td align="left" width="" nowrap>
    <select name="noDormitorios" id="noDormitorios" style="width:;" class="selecciona">
      <option value="">-DORMITORIOS-</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
    </select>
    </td>
        <td align="left" width="" nowrap>
        <select name="hacinamiento" id="hacinamiento" style="width:;" class="selecciona">
          <option value="">-HACINAMIENTO-</option>
          <option value="SIN HACINAMIENTO">SIN HACINAMIENTO</option>
          <option value="HACINAMIENTO MEDIO">HACINAMIENTO MEDIO</option>
          <option value="HACINAMIENTO CRITICO">HACINAMIENTO CRITICO</option>
        </select>
        </td>
  </tr>
  <tr>
    <td align="left" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%" align="left">
            	<label for="vSala">Sala</label><input name="vSala" id="vSala" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%" align="left">
            	<label for="vComedor">Comedor</label><input name="vComedor" id="vComedor" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%" align="left">
            	<label for="vCocina">Cocina</label><input name="vCocina" id="vCocina" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%" align="left">
            	<label for="vBanoPrivado">Baño privado</label><input name="vBanoPrivado"id="vBanoPrivado"type="checkbox"class="bax">
            </td>
            <td nowrap valign="middle" width="" align="left">
            <label for="vBanoColectivo">Baño colectivo</label><input name="vBanoColectivo"id="vBanoColectivo"type="checkbox" class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr class="cabecera2">
    <td align="center" colspan="4">Materia predominante en la construcción de la vivienda</td>
  </tr>
  <tr>
  	<td align="" colspan="4">
    	<table border="0" width="100%" cellpadding="2" cellspacing="0">
        <tr>
        	<td align="left" width="1%">Paredes</td>
            <td align="center">
                <select name="mParedes" id="mParedes" class="selecciona">
                  <option value="">-SELECCIONAR-</option>
                  <option value="TABIQUE">TABIQUE</option>
                  <option value="MADERA">MADERA</option>
                  <option value="CARTON">CARTON</option>
                </select>
            </td>
            <td align="left" width="1%">Techos</td>
            <td align="center">
                <select name="mTechos" id="mTechos" class="selecciona">
                  <option value="">-SELECCIONAR-</option>
                  <option value="CONCRETO">CONCRETO</option>
                  <option value="LAMINA DE ASBESTO">LAMINA DE ASBESTO</option>
                  <option value="LAMINA DE CARTON">LAMINA DE CARTON</option>
                  <option value="LAMINA METALICA">LAMINA METALICA</option>
                </select>
            </td>
            <td align="left" width="1%">Pisos</td>
            <td align="center">
                <select name="mPisos" id="mPisos" class="selecciona">
                  <option value="">-SELECCIONAR-</option>
                  <option value="MOSAICOS">MOSAICOS</option>
                  <option value="LOSETA">LOSETA</option>
                  <option value="CEMENTO">CEMENTO</option>
                  <option value="TIERRA APISONADA">TIERRA APISONADA</option>
                  <option value="MADERA">MADERA</option>
                </select>
            </td>   
          </tr>
        </table>
    </td>
  </tr>
  <tr class="cabecera2">
    <td align="center" colspan="4">Mobiliario</td>
  </tr>
  <tr>
    <td align="left" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%">
            	<label for="vTelevisión">Televisión</label><input name="vTelevisión" id="vTelevisión" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="vEstéreo">Estéreo</label><input name="vEstéreo" id="vEstéreo" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="vVideo">Video juegos</label><input name="vVideo" id="vVideo" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="vDVD">BLURAY/DVD</label><input name="vDVD" id="vDVD" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="vEstufa">Estufa</label><input name="vEstufa"id="vEstufa"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="">
            	<label for="vHorno">Horno de microondas</label><input name="vHorno"id="vHorno"type="checkbox" class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="left" colspan="4">
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%">
            	<label for="vLavadora">Lavadora</label><input name="vLavadora" id="vLavadora" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="vCentroLav">Centro de lavado</label><input name="vCentroLav" id="vCentroLav" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="vRefri">Refrigerador</label><input name="vRefri"id="vRefri"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="" align="left">
            	<label for="vComputadora">Computadora</label><input name="vComputadora" id="vComputadora" type="checkbox" class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-4h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tablaTS">
  <tr class="ui-widget-header cabecera2">
    <td align="center">Servicios médicos con los que cuenta</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%">
            	<label for="sIMSS">IMSS</label><input name="sIMSS" id="sIMSS" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="sISSSTE">ISSSTE</label><input name="sISSSTE" id="sISSSTE" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="sCentroS">Centro de salud</label><input name="sCentroS"id="sCentroS"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%" align="">
            	<label for="sDispensario">Dispensario</label><input name="sDispensario" id="sDispensario" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="" align="left">
            	<label for="sMedicoP">Médico Privado</label><input name="sMedicoP" id="sMedicoP" type="checkbox" class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr class="ui-widget-header cabecera2">
    <td align="center">Frecuencia con la que asiste el usuario al médico</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%">
            	<label for="aFrMedica">Una vez por semana</label> <input type="radio" name="aFrMedica" id="aFrMedica" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="aFrMedica1">Mensualmente</label> <input type="radio" name="aFrMedica" id="aFrMedica1" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="aFrMedica2">Anualmente</label> <input type="radio" name="aFrMedica" id="aFrMedica2" class="bax">
            </td>
            <td nowrap valign="middle" width="" align="left">
            	<label for="aFrMedica3">Cuando se enferma</label> <input type="radio" name="aFrMedica" id="aFrMedica3"class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="left">Notas:</td>
  </tr>
  <tr>
    <td valign="top">
    	<textarea name="notasSalud" id="notasSalud" cols="" rows="" style="resize:none; width:98%; height:60px;"></textarea>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-5h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tablaTS">
  <tr class="ui-widget-header cabecera2">
    <td>alimento</td>
    <td align="left">Diario</td>
    <td align="left">Cada tercer día</td>
    <td align="left">Una vez a lasemana</td>
    <td align="left">Una vezal mes</td>
    <td align="left">Ocasionalmente</td>
  </tr>
  <tr>
    <td align="left">Carne de res</td>
    <td align="center"><label for="aRes"></label> <input type="radio" name="aRes" id="aRes" class="bax"></td>
    <td align="center"><label for="aRes1"></label> <input type="radio" name="aRes" id="aRes1" class="bax"></td>
    <td align="center"><label for="aRes2"></label> <input type="radio" name="aRes" id="aRes2" class="bax"></td>
    <td align="center"><label for="aRes3"></label> <input type="radio" name="aRes" id="aRes3" class="bax"></td>
    <td align="center"><label for="aRes4"></label> <input type="radio" name="aRes" id="aRes4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Carne de pollo</td>
    <td align="center"><label for="aPollo"></label> <input type="radio" name="aPollo" id="aPollo" class="bax"></td>
    <td align="center"><label for="aPollo1"></label> <input type="radio" name="aPollo" id="aPollo1" class="bax"></td>
    <td align="center"><label for="aPollo2"></label> <input type="radio" name="aPollo" id="aPollo2" class="bax"></td>
    <td align="center"><label for="aPollo3"></label> <input type="radio" name="aPollo" id="aPollo3" class="bax"></td>
    <td align="center"><label for="aPollo4"></label> <input type="radio" name="aPollo" id="aPollo4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Carne de cerdo</td>
    <td align="center"><label for="aCerdo"></label> <input type="radio" name="aCerdo" id="aCerdo" class="bax"></td>
    <td align="center"><label for="aCerdo1"></label> <input type="radio" name="aCerdo" id="aCerdo1" class="bax"></td>
    <td align="center"><label for="aCerdo2"></label> <input type="radio" name="aCerdo" id="aCerdo2" class="bax"></td>
    <td align="center"><label for="aCerdo3"></label> <input type="radio" name="aCerdo" id="aCerdo3" class="bax"></td>
    <td align="center"><label for="aCerdo4"></label> <input type="radio" name="aCerdo" id="aCerdo4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Carne depescado</td>
    <td align="center"><label for="aPescado"></label> <input type="radio" name="aPescado" id="aPescado" class="bax"></td>
    <td align="center"><label for="aPescado1"></label> <input type="radio" name="aPescado" id="aPescado1" class="bax"></td>
    <td align="center"><label for="aPescado2"></label> <input type="radio" name="aPescado" id="aPescado2" class="bax"></td>
    <td align="center"><label for="aPescado3"></label> <input type="radio" name="aPescado" id="aPescado3" class="bax"></td>
    <td align="center"><label for="aPescado4"></label> <input type="radio" name="aPescado" id="aPescado4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Leche</td>
    <td align="center"><label for="aLeche"></label> <input type="radio" name="aLeche" id="aLeche" class="bax"></td>
    <td align="center"><label for="aLeche1"></label> <input type="radio" name="aLeche" id="aLeche1" class="bax"></td>
    <td align="center"><label for="aLeche2"></label> <input type="radio" name="aLeche" id="aLeche2" class="bax"></td>
    <td align="center"><label for="aLeche3"></label> <input type="radio" name="aLeche" id="aLeche3" class="bax"></td>
    <td align="center"><label for="aLeche4"></label> <input type="radio" name="aLeche" id="aLeche4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Cereales</td>
    <td align="center"><label for="aCereal"></label> <input type="radio" name="aCereal" id="aCereal" class="bax"></td>
    <td align="center"><label for="aCereal1"></label> <input type="radio" name="aCereal" id="aCereal1" class="bax"></td>
    <td align="center"><label for="aCereal2"></label> <input type="radio" name="aCereal" id="aCereal2" class="bax"></td>
    <td align="center"><label for="aCereal3"></label> <input type="radio" name="aCereal" id="aCereal3" class="bax"></td>
    <td align="center"><label for="aCereal4"></label> <input type="radio" name="aCereal" id="aCereal4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Huevo</td>
    <td align="center"><label for="aHuevo"></label> <input type="radio" name="aHuevo" id="aHuevo" class="bax"></td>
    <td align="center"><label for="aHuevo1"></label> <input type="radio" name="aHuevo" id="aHuevo1" class="bax"></td>
    <td align="center"><label for="aHuevo2"></label> <input type="radio" name="aHuevo" id="aHuevo2" class="bax"></td>
    <td align="center"><label for="aHuevo3"></label> <input type="radio" name="aHuevo" id="aHuevo3" class="bax"></td>
    <td align="center"><label for="aHuevo4"></label> <input type="radio" name="aHuevo" id="aHuevo4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Frutas</td>
    <td align="center"><label for="aFruta"></label> <input type="radio" name="aFruta" id="aFruta" class="bax"></td>
    <td align="center"><label for="aFruta1"></label> <input type="radio" name="aFruta" id="aFruta1" class="bax"></td>
    <td align="center"><label for="aFruta2"></label> <input type="radio" name="aFruta" id="aFruta2" class="bax"></td>
    <td align="center"><label for="aFruta3"></label> <input type="radio" name="aFruta" id="aFruta3" class="bax"></td>
    <td align="center"><label for="aFruta4"></label> <input type="radio" name="aFruta" id="aFruta4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Verduras</td>
    <td align="center"><label for="aVerduras"></label> <input type="radio" name="aVerduras" id="aVerduras" class="bax"></td>
    <td align="center"><label for="aVerduras1"></label> <input type="radio" name="aVerduras" id="aVerduras1" class="bax"></td>
    <td align="center"><label for="aVerduras2"></label> <input type="radio" name="aVerduras" id="aVerduras2" class="bax"></td>
    <td align="center"><label for="aVerduras3"></label> <input type="radio" name="aVerduras" id="aVerduras3" class="bax"></td>
    <td align="center"><label for="aVerduras4"></label> <input type="radio" name="aVerduras" id="aVerduras4" class="bax"></td>
  </tr>
  <tr>
    <td align="left">Leguminosas</td>
    <td align="center"><label for="aLegumi"></label> <input type="radio" name="aLegumi" id="aLegumi" class="bax"></td>
    <td align="center"><label for="aLegumi1"></label> <input type="radio" name="aLegumi" id="aLegumi1" class="bax"></td>
    <td align="center"><label for="aLegumi2"></label> <input type="radio" name="aLegumi" id="aLegumi2" class="bax"></td>
    <td align="center"><label for="aLegumi3"></label> <input type="radio" name="aLegumi" id="aLegumi3" class="bax"></td>
    <td align="center"><label for="aLegumi4"></label> <input type="radio" name="aLegumi" id="aLegumi4" class="bax"></td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-6h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tablaTS">
  <tr class="ui-widget-header cabecera2">
    <td align="center">Actividades familiares el fin de semana</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%">
            	<label for="rPracticarD">Practicar deporte</label><input name="rPracticarD"id="rPracticarD"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rIrCine">Ir al cine</label><input name="rIrCine" id="rIrCine" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rVisitarF">Visitar familiares</label><input name="rVisitarF"id="rVisitarF"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rQuehacer">Realizar quehaceres del hogar</label><input name="rQuehacer" id="rQuehacer" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="" align="left">
            	<label for="rActAire_ibre">Actividades al aire libre</label><input name="rActAire_ibre" id="rActAire_ibre" type="checkbox" class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr class="ui-widget-header cabecera2">
    <td align="center">Actividades del paciente</td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%">
            	<label for="rEstudia">Estudia</label><input name="rEstudia"id="rEstudia"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rRealizaD">Realiza deporte</label><input name="rRealizaD" id="rRealizaD" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rVeTV">Ve televisión</label><input name="rVeTV"id="rVeTV"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rHaceTareas">Hace sus tareas</label><input name="rHaceTareas" id="rHaceTareas" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="" align="left">
            	<label for="rquehacerHogar">Realiza los quehaceres del hogar</label><input name="rquehacerHogar" id="rquehacerHogar" type="checkbox" class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td nowrap valign="middle" width="1%">
            	<label for="rVideojuegos">Videojuegos</label><input name="rVideojuegos"id="rVideojuegos"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rJuegaAm">Juega con amigos</label><input name="rJuegaAm" id="rJuegaAm" type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="1%">
            	<label for="rJuegaF">Juega con hermano o familiares</label><input name="rJuegaF"id="rJuegaF"type="checkbox" class="bax">
            </td>
            <td nowrap valign="middle" width="" align="left">
            	<label for="rTrabaja">Trabaja</label><input name="rTrabaja" id="rTrabaja" type="checkbox" class="bax">
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</div>

<div class="miTab" id="tabs-7h">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tablaTS">
  <tr>
    <td>DIAGNOSTICO SOCIAL</td>
  </tr>
  <tr>
    <td valign="top" align="center">
    <textarea name="dxSocial" id="dxSocial" cols="" rows="4" style="resize:none; height:100px; width:98%;"></textarea>
    </td>
  </tr>
  <tr>
    <td>OBSERVACIONES</td>
  </tr>
  <tr>
    <td valign="top" align="center">
    <textarea name="dxObservaciones" id="dxObservaciones" cols="" rows="4" style="resize:none; height:100px; width:98%;"></textarea>
    </td>
  </tr>
  <tr>
    <td valign="top">
    	<select name="dxNS" id="dxNS" class="required selecciona">
          <option value="">-NIVEL SOCIOECONOMICO-</option>
          <option value="A">NIVEL A</option>
          <option value="B">NIVEL B</option>
          <option value="C">NIVEL C</option>
          <option value="D">NIVEL D</option>
          <option value="E">NIVEL E</option>
        </select>
    </td>
  </tr>
</table>
</div>
</div>
<input class="required" name="idPESE" id="idPESE" type="hidden" value="">
<input class="required" name="idUESE" id="idUESE" type="hidden" value="">
<input class="required" name="idRESE" id="idRESE" type="hidden" value="">
</form>
</div>

<div id="dialog-referir" style="display:none;">
<form action="" method="post" name="form-referir" id="form-referir" target="_self" style="height:100%">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
	<tr>
    <td align="left" valign="middle" height="1%">
    ¿Está seguro que desea referir al paciente <span id="pacienteReferido"></span>?
    </td>
    </tr>
    <tr>
    <td align="left" valign="middle" height="1%">
    Indique el motivo:
    </td>
    <tr>
    <td align="center" height="98%" valign="top">
    <textarea class="required" name="motivo_referido" id="motivo_referido" cols="20" rows="3" style="resize:none; height:300; width:98%" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);"></textarea>
    </td>
    </tr>
    </tr>
</table>
<input class="required" name="idRESE1" id="idRESE1" type="hidden" value="">
<input class="required" name="idUESE1" id="idUESE1" type="hidden" value="">
</form>
</div>

</body>
</html>

<?php mysql_free_result($usuario); ?>

<script>
function myFunction(){ setTimeout(function(){ $(document).ready(function(e) {	
	$('.icono_proceso').button({ icons: { primary: "ui-icon-gear"}, text: false });
	$('.icono_realizado').button({ icons: { primary: "ui-icon-gear"}, text: false });
	$('.icono_capturado').button({ icons: { primary: "ui-icon-document"}, text: false });
	$('.icono_interpretado').button({ icons: { primary: "ui-icon-check"}, text: false });
	$('.icono_imprimir').button({ icons: { primary: "ui-icon-print"}, text: false });
	$('.miPDF').button({ icons: { primary: "ui-icon-document"}, text: false });
	$('.updatePDF').button({ icons: { primary: "ui-icon-refresh"}, text: false });
	$('.icono_vacio').button({ icons: { primary: "ui-icon-help"}, text: false });
	$('.icono_referir').button({ icons: { primary: "ui-icon-cancel"}, text: false });
	$('.icono_documento').button({ icons: { primary: "ui-icon-document"}, text: false });
	
	$('.botonaso').click(function(event) { event.preventDefault(); });
}); },9); }//fin myFunction

$('#dialog-referir').dialog({
	title: 'REFERIR PACIENTE',modal:true, autoOpen:false, closeText:'',width:600, height:280,closeOnEscape:false,dialogClass:'',
	buttons: { 
		"Referir": function() {
			if($('#form-referir').valid()){
				var datos = $('#form-referir').serialize();
				$.post('files-serverside/referir.php',datos).done(function(data){
					if(data == 1){
						$('#dialog-confirmar').dialog('open');
						$('#dialog-referir').dialog('close');
						$('#clickme').click();
					}else{alert(data); $('#dialog-referir').dialog('close'); }
				});
			}
		}, 
		"Cancelar": function() { $(this).dialog('close'); } 
	},
	open:function( event, ui ){ $('#form-referir').validate({ ignore:'hidden'} ); },
	close:function( event, ui ){ document.getElementById('form-referir').reset(); }
});

var heE = $('#referencia').height() - $('#header').height() - 50; var wiE = $('#referencia').width() * 0.98;

$('#dialog-hacer-es').dialog({
	title: 'ESTUDIO SOCIOECONÓMICO',modal:true, autoOpen:false, closeText:'',width:wiE, height:heE,closeOnEscape:false,
	dialogClass:'no-close',
	buttons: { 
		"Guardar": function() {
			if($('#form-estudio-se').valid()){
				var datos = $('#form-estudio-se').serialize();
				$.post('files-serverside/estudioSocioeconomico.php',datos).done(function(data){
					if(data == 1){
						$('#dialog-confirmar').dialog('open');
						$('#dialog-hacer-es').dialog('close');
						$('#clickme').click();
					}else{alert(data); $('#dialog-hacer-es').dialog('close'); }
				});
			}
		}, 
		"Cancelar": function() { $(this).dialog('close'); } 
	},
	open:function( event, ui ){
		$('#form-estudio-se').validate({ ignore:'hidden'} );
		$("#miTabsH").tabs({active: 0, heightStyle: "auto"});
		window.setTimeout(function(){$('.tablaTS').css('height',$('#dialog-hacer-es').height()-50);},100);
		window.setTimeout(function(){$('#miTabsH').css('height',$('#dialog-hacer-es').height()+20);},100);
		$('#pestanas1').removeClass('ui-widget-header'); $('.bax').checkboxradio(); $('.selecciona').selectmenu();
	},
	close:function( event, ui ){ document.getElementById('form-estudio-se').reset(); }
});

function estudio_se(a,b,c){ $(document).ready(function(e) { //a nombre paciente, b id de la terapia y c id paciente
	$('#dialog-hacer-es').dialog({title: 'ESTUDIO SOCIO-ECONÓMICO PACIENTE '+a});
	$('#dialog-hacer-es').dialog('open');
	$('#idPESE').val(c); $('#idUESE').val($('#idUser').val()); $('#idRESE').val(b);
}); }

function referir(a,b,c){ $(document).ready(function(e) { //a nombre paciente, b id de la terapia y c id paciente
	$('#pacienteReferido').text(a);$('#dialog-referir').dialog('open');$('#idRESE1').val(b);$('#idUESE1').val($('#idUser').val());
}); }
</script>
