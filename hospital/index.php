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
    if (in_array($UserName, $arrUsers)) { $isValid = true;  } 
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
$query_fechaRangoInicial = "SELECT v.fecha_venta_vc FROM venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where c.id_tipo_concepto_to = 3 ORDER BY v.fecha_venta_vc ASC limit 1";
$fechaRangoInicial = mysql_query($query_fechaRangoInicial, $horizonte) or die(mysql_error());
$row_fechaRangoInicial = mysql_fetch_assoc($fechaRangoInicial);
$totalRows_fechaRangoInicial = mysql_num_rows($fechaRangoInicial);

mysql_select_db($database_horizonte, $horizonte);
$query_fechaRangoFinal = "SELECT v.fecha_venta_vc FROM venta_conceptos v left join conceptos c on c.id_to = v.id_concepto_es where c.id_tipo_concepto_to = 3 ORDER BY v.fecha_venta_vc DESC limit 1";
$fechaRangoFinal = mysql_query($query_fechaRangoFinal, $horizonte) or die(mysql_error());
$row_fechaRangoFinal = mysql_fetch_assoc($fechaRangoFinal);
$totalRows_fechaRangoFinal = mysql_num_rows($fechaRangoFinal);
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/favicon.ico">
<meta charset="utf-8">
<title>HOSPITALIZADOS</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
<link href="../DataTables-1.10.5/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet">
<link href="../Editor-PHP-1.4.0/css/dataTables.editor.css" rel="stylesheet">

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
<script src="../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" type="text/javascript" charset="utf-8"></script>
<script src="../funciones/js/jquery.media.js" type="text/javascript"></script>
<script src="../funciones/js/stdlib.js"></script>

<script>
$( document ).tooltip({ extraClass: "arrow", position: { my: "center bottom-10", at: "center top" } });
$(document).ready(function(e) {
	$('#form-captura').validate({
		rules:{ diagnostico:{ required:true } }, messages:{ diagnostico:{ required:'Debe ingresar el diagnóstico' } }
	});
});

$(document).ready(function(e) {
	$('#verMenu').click(function(e){window.location='../menu.php?menu=mh';});
	
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
	
	setInterval(function(){$.post('../remote_files/refresh_session.php'); },500000);
});
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
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, "bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[0, "asc"]], ordering: false,
		"aoColumns": [
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false},{"bSortable":false}
		],
		"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>', "sAjaxSource": "datatable-serverside/hospitalizacion.php",
		"fnServerParams": function (aoData, fnCallback) { var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59'; aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } ); },
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
// EndOAWidget_Instance_2586523
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

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="nombreTempPdf" id="nombreTempPdf" type="hidden" value="">
<input name="id_vc_ini" id="id_vc_ini" type="hidden" value="">
<input name="usuario_ini" id="usuario_ini" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
<input name="campoUrl" id="campoUrl" type="hidden" value="">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_hospital.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">HOSPITAL</span></td>
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

<div class="contenido" id="contenido" align="center" style="margin-top:39px;">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr class="titulos_dataceldas">
        <th id="clickme" width="1px" nowrap>#</th>
        <th>PACIENTE</th>
        <th width="110px">FECHA INGRESO</th>
        <th width="10px">ESTATUS</th>
     	<th>CAMA</th>
        <th width="80px"><span title="Médico tratante">MEDICO T</span></th>
        <th width="100px"><span title="Notas médicas">NOTAS M</span></th>
        <th width="100px"><span title="Notas de enfermería">NOTAS E</span></th>
        <th width="10px">ESTUDIOS</th>
        <th width="10px">MEDICAMENTOS</th>
        <th width="10px">SV</th>
        <th width="10px">HC</th>
        <th width="110px">FECHA ALTA</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr>
        	<td><input name="sPaciente0" id="sPaciente0" type="hidden" class="search_init" style="width:90%;" /></td>
        	<td>
            <input name="sPaciente" id="sPaciente" type="text" placeholder="-PACIENTE-" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sPa1" id="sPa1" type="text" placeholder="-FECHA DE INGRESO-" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sPaciente2" id="sPaciente2" type="text" placeholder="-ESTATUS-" class="search_init" style="width:90%;" />
            </td>
        	<td>
            <input name="sPaciente3" id="sPaciente3" type="text" placeholder="-CAMA-" class="search_init" style="width:90%;" />
            </td>
     		<td>
            <input name="sPaciente4" id="sPaciente4" type="text" placeholder="-TRATANTE-" class="search_init" style="width:90%;" />
            </td>
			<td>
            <input name="sPaciente5" id="sPaciente5" type="hidden" placeholder="Sucursal" class="search_init" style="width:90%;" />
            </td>
            <td>
            <input name="sPaciente5r" id="sPaciente5r" type="hidden" placeholder="Sucursal" class="search_init" style="width:90%;" />
            </td>
            <td>
            <input name="sPaciente5r" id="sPaciente5" type="hidden" placeholder="Sucursal" class="search_init" style="width:90%;" />
            </td>
            <td>
            <input name="sPaciente5r" id="sPaciente5rr" type="hidden" placeholder="Sucursal" class="search_init" style="width:90%;" />
            </td>
            <td>
            <input name="sPaciente5r" id="sPaciente5r" type="hidden" placeholder="Sucursal" class="search_init" style="width:90%;" />
            </td>
            <td><input name="sPac" id="sPac" type="hidden" placeholder="Sucursal" class="search_init" style="width:90%;" /></td>
            <td>
            <input name="sPa2" id="sPa2" type="text" placeholder="-FECHA DE ALTA-" class="search_init" style="width:90%;" />
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

<div style="display:none;" id="dialog-upload" title="INTERPRETACIÓN">
		<span id="spanDialog"></span>
  <iframe id="miFrame" allowtransparency="yes" frameborder="0" src="../editorTexto/Untitled-3.php" style="width:850px; height:440px;"></iframe>
</div>

<div id="dialog-captura" style="display:none; background-image:; text-align:left; background-size:cover; background-repeat:no-repeat; background-position:center;">
<form style="height:100%; width:100%;" action="" method="get" name="form-captura" id="form-captura" target="_self">
<input name="myIDestudio" id="myIDestudio" class="myIDestudio" type="hidden">
<input name="myIDusuario" type="hidden" class="myIDusuario" id="myIDusuario" value="<?php echo $row_usuario['id_u']; ?>">
<table id="tCaptura" width="100%" height="100%" border="0" cellspacing="5" cellpadding="0" align="left">
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

<div id="dialog-nivel1" class="dialogos"> </div>
<div id="dialog-nivel2" class="dialogos"> </div>
<div id="dialog-nivel3" class="dialogos"> </div>

<input name="myIDestudioT" id="myIDestudioT" class="" type="hidden">
<input name="myIDpacienteT" id="myIDpacienteT" class="" type="hidden">
<input name="myNameEstudioT" id="myNameEstudioT" class="" type="hidden">
<input name="aleatorioN1" id="aleatorioN1" type="hidden">

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
function aplicarMed(idMedH){ $(document).ready(function(e){
	var datos = {idMedH:idMedH, idU:$('#idUser').val()}
	$.post('files-serverside/aplicar_medicamento.php',datos).done(function(data){
	  if(data==1){
		  $('#dialog-nivel3').dialog({
			autoOpen:true,modal:true,width:500,height:120,title:'MEDICAMENTO APLICADO',closeText:'',closeOnEscape:false,
			dialogClass:'no-close',
			open:function( event, ui ){
				$('#fotoU').val(1);
				$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El medicamento se aplicó satisfactoriamente!</h3></td></tr></table>');
				window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
			}, close:function( event, ui ){ $("#dialog-nivel3").empty();$('#dialog-nivel3').dialog('destroy'); }, buttons:{ }
		  });
	  }else{alert(data);}
	});
});}
	
function medicamentos_hospi(idH,nameP){ $(document).ready(function(e) {
	$("#dialog-nivel1").load("htmls/medicamentos_hospital.php",function(response,status,xhr){ if (status == "success" ){
		var tamH = $('#referencia').height() - 100, tamW = $('#referencia').width() * 0.98;
		$('#dialog-nivel1').dialog({
			autoOpen:true, modal:true, width:tamW, height:tamH, title: 'MEDICAMENTOS ASIGNADOS AL PACIENTE '+nameP, closeText: '',
			closeOnEscape:true, dialogClass:'', 
			open:function( event, ui ){
				$("#tabs_meh").tabs({active:0});$('#tabs_meh ul').removeClass('ui-widget-header');
								
				var asInitValsMH = new Array(), oTableMH, tamMH = $('#dialog-nivel1').height() - 120;
				oTableMH = $('#dataTableMHA').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bJQueryUI": true, "bRetrieve": true, "sScrollY": tamMH, "bAutoWidth": true, "bStateSave": false, 
					"bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]], ordering: false,
					"aoColumns":[
						{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
						{"bSortable":false},{"bSortable":false}
					],
					"iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true, 
					"sAjaxSource": "datatable-serverside/medicamentos_asignados.php",
					"fnServerParams":function(aoData,fnCallback){
						var idHospitalizacion = idH; aoData.push({"name": "idHo", "value": idHospitalizacion }); 
					}, 
					"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page",
					"sZeroRecords": "-SIN CONCIDENCIAS-", 
					"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", 
					"sSearch": "BUSCAR" }
				}); $('#clickmeMHA').click(function(e) { oTableMH.fnDraw(); });
				//para los fintros individuales por campo de texto
				$("tfoot input.hipo").keyup(function(){ oTableMH.fnFilter(this.value,$("tfoot input.hipo").index(this)); });
				$("tfoot input.hipo").each(function(i){asInitValsMH[i]=this.value;});
				$("tfoot input.hipo").focus(function(){if(this.className=="search_init"){this.className="";this.value="";} });
				$("tfoot input").blur(function(i){ if ( this.value == "" ) { 
						this.className="search_init hipo campos_b_t"; this.value=asInitValsMH[$("tfoot input.hipo").index(this)];
				} } ); 
				//fin filtros individuales por campo de texto
				
				var asInitValsMH1 = new Array(), oTableMH1;
				oTableMH1 = $('#dataTableMHA1').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
					"bJQueryUI": true, "bRetrieve": true, "sScrollY": tamMH, "bAutoWidth": true, "bStateSave": false, 
					"bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]], ordering: false,
					"aoColumns":[
						{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
						{"bSortable":false}
					],
					"iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true, 
					"sAjaxSource": "datatable-serverside/medicamentos_aplicados.php",
					"fnServerParams":function(aoData,fnCallback){
						var idHospitalizacion = idH; aoData.push({"name": "idHo", "value": idHospitalizacion }); 
					}, 
					"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page",
					"sZeroRecords": "-SIN CONCIDENCIAS-", 
					"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MÉDICOS: _MAX_", 
					"sSearch": "BUSCAR" }
				}); $('#clickmeMHA1').click(function(e){oTableMH1.fnDraw();});
				$('#tabs-2mh-1').click(function(e){oTableMH1.fnDraw();});
				
				//para los fintros individuales por campo de texto
				$("tfoot input.hipo1").keyup(function(){ oTableMH1.fnFilter(this.value,$("tfoot input.hipo1").index(this)); });
				$("tfoot input.hipo1").each(function(i){asInitValsMH1[i]=this.value;});
				$("tfoot input.hipo1").focus(function(){if(this.className=="search_init"){this.className="";this.value="";} });
				$("tfoot input").blur(function(i){ if ( this.value == "" ) { 
					this.className="search_init hipo1 campos_b_t";this.value=asInitValsMH1[$("tfoot input.hipo1").index(this)];
				} } ); 
				//fin filtros individuales por campo de texto
				
			}, close:function( event, ui ){ $('#dialog-nivel1').empty(); }, buttons: { }
		});
	} });
});}

function checarHayDX(idH,aleatorio){ $(document).ready(function(e) { var datosChecaDX = {idH:idH,aleatorio:aleatorio}
	$.post('files-serverside/checarHayDX.php',datosChecaDX).done(function( data ) { 
		if(data >0){ $('#errorSeleccionDX').hide(); $('#dialog-nivel2').dialog('close'); $('#clickmeDX').click(); }
		else{ $('#errorSeleccionDX').hide().show('shake'); } 
	}); 
});}
function actualizarDX(idH,idP,aleatorio){ $(document).ready(function(e) { //alert(2);
	$("#dialog-nivel2").load("htmls/buscarDX.php #buscarDiagnosticos",function(response,status,xhr){if(status=="success"){
		$('#altaDX').hide();
		var he3 = $('#referencia').height()-$('.botones').height() - 100, wi3=$('#referencia').width() * 0.98;
		$('#dialog-nivel2').dialog({ 
			title: 'BUSCAR DIAGNÓSTICOS', modal: true, autoOpen: true, closeText: '', width: wi3, height: he3,
			closeOnEscape: false, dialogClass: 'no-close',
			buttons:{ 
				"Aceptar":function(){ checarHayDX(idH,aleatorio); }, "Cerrar": function() { $('#dialog-nivel2').dialog('close'); }
		  	}, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-nivel2').empty(); },
		  open:function( event, ui ){ 
			var oTableBDX;
			oTableBDX = $('#dataTableBDX').dataTable({ 
			"bJQueryUI": true, "bRetrieve": true, "sScrollY": ($('#dialog-nivel2').height()-155)/2,
			"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]],
			"aoColumns": [{ "bSortable": false }, { "bSortable": false }], "iDisplayLength": 30, 
			"bLengthChange": false, "bProcessing": false, "bServerSide": true, ordering: false,
				"sDom": '<"toolbarBDX"><"filtroBDX"f>lr<"data_tBDX"t><"infoBDX"i>S', 
				"sAjaxSource": "../consultas/datatable-serverside/buscar_diagnosticos.php", 
				"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { 
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
					"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
					"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_", "sSearch": "" 
				}
			});//fin datatable
			$(".pieTablaBDX input").keyup( function(){ oTableBDX.fnFilter( this.value, $(".pieTablaBDX input").index(this) ); } );
			$('.infoBDX').hide(); $('.filtroBDX input').focus(); 
			$('.filtroBDX input').css('width', ($('#dialog-nivel2').width() -16) ).hide(); $('.filtroBDX').css('left',-32);
			
			var tableBDX = $('#dataTableBDX').DataTable();
			$('#dataTableBDX tbody').on('click','tr',function(){
				if($(this).hasClass('selected2')){ $(this).removeClass('selected2');}
				else{
					tableBDX.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
					$('#errorSeleccionDX').hide();
				}
			});
			
			$('#dataTableBDX tbody').on('click','tr',function(){ 
				var nTdsDXS = $('td', this); subirDX($(nTdsDXS[0]).text(),idH,idP,$('#idUser').val(),aleatorio); 
			}); //con la clave del médico sacamos su id
			
			var oTableSDX;
			oTableSDX = $('#dataTableDXS').dataTable({ "bJQueryUI": true, "bRetrieve": true, 
				"sScrollY": ($('#dialog-nivel2').height()-150)/2, "bStateSave": false, "bInfo": false, 
				"bFilter": false, "aaSorting": [[0, "asc"]], ordering: false,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  },
				"aoColumns": [
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
				], 
				"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": '<"toolbarDS"><"filtroDS"f>lr<"data_tDS"t><"infoDS"i>S', 
				"sAjaxSource": "datatable-serverside/dx_seleccionados.php", 
				"fnServerParams": function (aoData, fnCallback) { 
					var idHos = idH; aoData.push(  {"name": "idH", "value": idHos } );
					var aleat = aleatorio; aoData.push(  {"name": "aleatorio", "value": aleat } ); 
				}, "aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_", "sSearch": "" }
			});/*fin datatable*/ $('#clickmeDXS').click(function(e) { oTableSDX.fnDraw(); });
		  }
		});
	}});
}); }

function subirDX(claveDX,idH,idP,idU,aleatorio){ $(document).ready(function(e){ //alert(aleatorio);
	var datosSDX = {idH:idH, idP:idP, idU:idU, claveDX:claveDX,aleatorio:aleatorio}
	$.post('files-serverside/guardarDX.php',datosSDX).done(function(data){ 
		if(data==1){ $('#clickmeDXS').click(); $('#clickmeDX').click(); } else{alert(data);} 
	});
});}

function borrarDX(idDX){ $(document).ready(function(e){ var datosBDX = {idDX:idDX}
	$.post('files-serverside/eliminarDX.php',datosBDX).done(function( data ) { 
		if (data==1){ $('#clickmeDXS, #clickmeDX').click(); } else{alert(data);} 
	});
});}

function dxPrimario(idDX){$(document).ready(function(e){ var datosDXP = {idDX:idDX}
	$.post('files-serverside/primarioDX.php',datosDXP).done(function( data ) { 
		if(data==1){ $('#clickmeDXS, #clickmeDX').click(); }else{alert(data);} 
	});
}); }

function subirMED(claveMED, idH, idP, idU, aleatorio){ $(document).ready(function(e) { 
	var datosSMED = {idH:idH, idP:idP, idU:idU, claveMED:claveMED, aleatorio:aleatorio}
	$.post('files-serverside/guardarMED.php',datosSMED).done(function( data ) { if (data==1){ 
		$('#clickmeMS').click(); $('#clickmeMedi').click(); } else{alert(data);} 
	});
});}
function borrarMed(idMEDC){ $(document).ready(function(e) { var datosBMEDC = {idMEDC:idMEDC}
	$.post('files-serverside/eliminarMed.php',datosBMEDC).done(function( data ) { 
		if (data==1){ $('#clickmeMS, #clickmeMedi').click(); } else{alert(data);} 
	});
});}
function checarHayMedi(idH,aleatorio){ $(document).ready(function(e) { var datosChecaMedi = {idH:idH,aleatorio:aleatorio}
	$.post('files-serverside/checarHayMedi.php',datosChecaMedi).done(function( data ) { 
		if(data >0){ $('#errorSeleccionMedicamentos').hide(); $('#dialog-nivel2').dialog('close'); 
		}else{ $('#errorSeleccionMedicamentos').hide().show('shake'); } 
	}); 
});}

function actulizarMedicamentos(idH,idP,aleatorio){ $(document).ready(function(e) { //alert(2);
	$("#dialog-nivel2").load("htmls/buscarDX.php #buscarMedicamentos",function(response,status,xhr){ if(status=="success"){
		var he3=$('#referencia').height()-$('.botones').height()-100, wi3 = $('#referencia').width() * 0.98;
		$('#dialog-nivel2').dialog({ 
			title: 'BUSCAR MEDICAMENTOS', modal: true, autoOpen: true, closeText: '', width: wi3, height: he3,
			closeOnEscape: false, dialogClass: 'no-close',
			buttons:{//"Nuevo medicamento": function() { },
				"Aceptar":function(){ checarHayMedi(idH,aleatorio); }, "Cerrar":function(){ $('#dialog-nivel2').dialog('close'); }
		    }, create: function( event, ui ) {}, 
		  close:function( event, ui ){ 
			$('#dialog-nivel2').empty(); //Que cuando se cierre esta ventana de buscar medicamentos, que los ponga en la receta
			var datosMedis = {idH:idH,aleatorio:aleatorio}
			$.post('files-serverside/pedirMedis.php',datosMedis).done(function(data){ $('#recetaFrontC').html(data); });
		  },
		  open:function( event, ui ){
			var oTableBMe;
			oTableBMe = $('#dataTableBMedicamentos').dataTable({ 
				"destroy": true, "bJQueryUI": true, "bRetrieve": true, ordering: false,
				"sScrollY": ($('#dialog-nivel2').height()-140)/2, "bAutoWidth": true, "bStateSave": false,
				"bInfo": true, "bFilter": true, "aaSorting": [[1, "asc"]], 
				"aoColumns": [
					{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
				], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": true, "bServerSide": true,
				"sDom": '<"filtroBMe"f>l<"infoBMe">r<"data_tBMe"t>', 
				"sAjaxSource": "../consultas/datatable-serverside/buscar_medicamentos.php",
				"oLanguage": { 
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
					"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
					"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MEDICAMENTOS: _MAX_", "sSearch": "" 
				}
			});//fin datatable
			$(".pieTablaBMedi input").keyup( function () {/* Filter on the column (the index) of this element */
				oTableBMe.fnFilter( this.value, $(".pieTablaBMedi input").index(this) ); 
			});
			$('.filtroBMe input').attr("placeholder", "BUSQUE LOS MEDICAMENTOS AQUÍ, Y DELE CLIC PARA SEECCIONARLOS...").addClass('placeHolder');
			$('.infoBMe').hide(); $('.filtroBMe input').focus(); 
			$('.filtroBMe input').css('width',($('#dialog-nivel2').width()-16)).hide();
			$('.filtroBMe').css('left',-32);
			
			var tableBMedi = $('#dataTableBMedicamentos').DataTable();
			$('#dataTableBMedicamentos tbody').on('click','tr',function(){
				if($(this).hasClass('selected2')){ $(this).removeClass('selected2');}
				else{
					tableBMedi.$('tr.selected2').removeClass('selected2');
					$(this).addClass('selected2'); $('#errorSeleccionMedicamentos').hide();
				}
			});
			
			$('#dataTableBMedicamentos tbody').on('click','tr',function(){ 
				var nTdsMES = $('td', this); subirMED($(nTdsMES[0]).text(),idH,idP,$('#idUser').val(),aleatorio); 
			}); 
			
			var oTableSMED;
			oTableSMED = $('#dataTableMS').dataTable({ 
				"bJQueryUI": true, "bRetrieve": true, "sScrollY": ($('#dialog-nivel2').height()-150)/2,
				"bAutoWidth": true, "bStateSave": false, "bInfo": false, "bFilter": false, ordering: false,
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { }, "aaSorting": [[0, "asc"]], 
				"aoColumns": [
					{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false}
				], "iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": '<"toolbarDS"><"filtroDS"f>lr<"data_tDS"t><"infoDS"i>S', 
				"sAjaxSource": "datatable-serverside/medicamentos_seleccionados.php", 
				"fnServerParams": function (aoData, fnCallback) { 
					var idHo = idH; aoData.push(  {"name": "idH", "value": idHo } );
					var alet = aleatorio; aoData.push(  {"name": "aleatorio", "value": alet } );
				}, "aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { 
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", 
					"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
					"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>MEDICAMENTOS: _MAX_", "sSearch": "" 
				}
			});/*fin datatable*/ $('#clickmeMS').click(function(e) { oTableSMED.fnDraw(); });
		  }
		});
	}});
}); }

function guardarNota(){ $(document).ready(function(e) { //alert($('#tabs_nnm #tabs-1n .jqte_editor').text());
	if($('#formNotaMed').valid() & $('#tabs_nnm #tabs-1n .jqte_editor').text() != ''){ 
		var datosNNM = $('#formNotaMed').serialize();
		$.post('files-serverside/guardarNotaMedica.php', datosNNM).done(function( data ) { 
			if (data == 1){ 
				$('#dialog-nivel3').dialog({
				   autoOpen:true,modal:true,width:500,height:120,title:'NOTA MÉDICA GUARDADA',closeText:'',dialogClass:'no-close',
					open:function( event, ui ){
						$('.miMedi').each(function(index, element) { //alert($(this).prop('lang'));
							var datoM = {idM:$(this).prop('lang'),indiM:$(this).val()}
							$.post('files-serverside/guardarIndiccionesM.php',datoM).done(function(data){ });
						});
						$('#dialog-nivel1').dialog('close'); $('#clickme').click(); 
						$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡La nota médica se guardó satisfactoriamente!</h3></td></tr></table>');
						window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
					},
					close:function( event, ui ){ $("#dialog-nivel3").empty();$('#dialog-nivel3').dialog('destroy');},buttons:{ }
				});
			}else{alert(data);} 
		});
	}
}); }

function notasMedicas(idP,idH,nombreP,aleatorioN1){ $(document).ready(function(e) { //alert(nombreP);
$('#dialog-nivel1').load("htmls/historiales.php",function(response,status,xhr){if(status=="success"){
	var heH = $('#referencia').height() - 95, wiH=$('#referencia').width() * 0.98; //alert(wiH);
	
	$('#aleatorioN1').val(aleatorioN1);
	var oTableDXh;
	oTableDXh = $('#dataTableDXh').dataTable({
		"fnFooterCallback":function(nRow, aaData, iStart, iEnd, aiDisplay){$('span.DataTables_sort_icon').remove(); },
		"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": heH*0.77, 
		"bAutoWidth":true,"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }],destroy: true,
		"iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sAjaxSource": "datatable-serverside/diagnosticos.php",
		"fnServerParams": function (aoData, fnCallback) {
			var alet = $('#aleatorioN1').val(); aoData.push(  {"name": "aleatorio", "value": alet } );
		},
		"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
		"sZeroRecords":"LA NOTA MÉDICA NO CUENTA CON DIAGNÓSTICOS","sInfo":"MOSTRADOS: _END_", 
		"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_","sSearch": "BUSCAR" }
	});/*fin datatable*/ $('#clickmeDXh').click(function(e) { oTableDXh.fnDraw(); });	
	
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true, width:wiH, height:heH, title:'HISTORIAL DE NOTAS MÉDICAS DEL PACIENTE '+nombreP, closeText: '',
		closeOnEscape: false,dialogClass: '', show: { effect: "blind", duration: 600 }, hide: { effect: "fold", duration: 600 },
		open:function( event, ui ){
			var asInitValsIM = new Array(), oTableIM;
			oTableIM = $('#dataTableArchivos').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
				"bJQueryUI": true, "bRetrieve": true, "sScrollY": heH*0.73, "bAutoWidth": true, "bStateSave": false, 
				"bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]], ordering: false,
				"aoColumns":[ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false} ],
				"iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true, 
				"sAjaxSource": "datatable-serverside/archivos_hospitalizacion.php",
				"fnServerParams":function(aoData,fnCallback){
					var idHospitalizacion=idH;aoData.push({"name":"idHo","value":idHospitalizacion}); 
				}, 
				"sDom": '<"filtroC">l<"infoC">r<"data_tC"t>', 
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page",
				"sZeroRecords": "-SIN CONCIDENCIAS-", 
				"sInfo": "MOSTRADAS: _END_", "sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>FOTOGRAFÍAS: _MAX_", 
				"sSearch": "BUSCAR" }
			}); $('#clickmeArch').click(function(e){oTableIM.fnDraw();});
			$('#thi-8-1').click(function(e){oTableIM.fnDraw();});
			
			$('#thi-2-1').click(function(e){ $('#clickmeDXh').click() });
			
			$("#tabs_hist").tabs({active: 2}); $('#tabs_hist ul').removeClass('ui-widget-header');

			$('#thi-6-1').click(function(e){ $("#tabs_sv").tabs({active:0}); $('#tabs_sv ul').removeClass('ui-widget-header'); });
			
			$('.mn').hide(); $('#b_agregarSignosC').show();
			
			$('#nuevaNotaM').click(function(e){ $('#dHistory').hide(); $('#holi').show();
				$("#holi").load("htmls/nota_medica.php", function( response, status, xhr ){if(status=="success"){
					$('#saveNotaM').click(function(e){ guardarNota(); });
					$('#tabs_nnm').height($('#dialog-nivel1').height()*0.98);
					
					$('#cancelNotaM').click(function(e) {
						$("#tabs_nnm").tabs( "destroy" ); $("#tabs_nnm").remove(); $('#holi').html(''); $('#holi').hide();
						$('#dHistory').show();
						$('#dialog-nivel1').dialog({title:'HISTORIAL DE NOTAS MÉDICAS DEL PACIENTE '+nombreP, dialogClass:'' });
					});
			
					$('#tabs_nnm #saveNotaM').click(function(event) { event.preventDefault(); });
					$("#tabs_nnm").tabs({active: 0});
					$('#dialog-nivel1').dialog({ title:'NUEVA NOTA MÉDICA PARA EL PACIENTE '+nombreP, dialogClass:'no-close' });
		
					var d = new Date(); $('#aleatorio_nnm').val(d.format('Y-m-d-H-i-s-u').substring(0,22));
					$('#idUsuario_nnm').val($('#idUser').val()); $('#idPaciente_nnm').val(idP);
					$('#id_hospitalizacion').val(idH);

					$('#b_dictamenC').click(function(e){ actualizarDX(idH,idP,$('#aleatorio_nnm').val()); });
					
					$('#b_medicamentosC').click(function(e){actulizarMedicamentos(idH,idP,$('#aleatorio_nnm').val());});
					var datoCo = {idP:idP}
					$.post('files-serverside/datosSVnnm.php',datoCo).done(function(data){ var datos1 = data.split(';*-');
						$('#usuario_sviNNM').text(datos1[1]); $('#fechaHoraNNM').text(datos1[0]);
						$('#peso0').text(datos1[2]); $('#talla0').text(datos1[3]); $('#imc0').text(datos1[4]);
						$('#ta0').text(datos1[6]+'/'+datos1[7]); $('#fr0').text(datos1[8]); $('#fc0').text(datos1[9]);
						$('#temp0').text(datos1[10]); $('#idSV').val(datos1[11]);
						
						var datosAl = {idPac:idP}
						$.post('files-serverside/alergias.php',datosAl).done(function(data){ $('#alergias0').text(data); });
					});
				
					$('#notaMedicaC, #indiF, #notaMedicamentosC').jqte();
					$("#tabs_nnm").tabs({active: 0}); $('#tabs_nnm ul').removeClass('ui-widget-header');
					$('#tabs_nnm #tabs-1n .jqte_editor').css('height',$('#tabs_nnm').height()*0.38);
					$('#tabs_nnm #tabs-1n .jqte_editor').css('max-height',$('#tabs_nnm').height()*0.38);
					
					$('#tabs_nnm #tabs-2n .jqte_editor').css('height',$('#tabs_nnm').height()*0.2);
					$('#tabs_nnm #tabs-2n .jqte_editor').css('max-height',$('#tabs_nnm').height()*0.2);
					var datosMedis = {idH:idH, aleatorio:$('#aleatorio_nnm').val()}
					$.post('files-serverside/pedirMedis.php',datosMedis).done(function(data){ $('#recetaFrontC').html(data); });
					
					$('#tabs_nnm #tabs-3n .jqte_editor').css('height',$('#tabs_nnm').height()*0.72);
					$('#tabs_nnm #tabs-3n .jqte_editor').css('max-height',$('#tabs_nnm').height()*0.72);
					var oTableDX;
					oTableDX = $('#dataTableDX').dataTable({
						"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
							$('#tabs_nnm span.DataTables_sort_icon').remove();
							window.setTimeout( function(){$('.dx_prim').click(function(event) { event.preventDefault(); });},200);
						},
						"destroy": true, "bJQueryUI": true, "bRetrieve": true, "sScrollY": $('#tabs_nnm').height()*0.28, 
						"bAutoWidth":true,"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
						"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
						"iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true, 
						"sAjaxSource": "datatable-serverside/diagnosticos.php",
						"fnServerParams": function (aoData, fnCallback) {
							var idHo = idH; aoData.push(  {"name": "idH", "value": idHo } );
							var alet = $('#aleatorio_nnm').val(); aoData.push(  {"name": "aleatorio", "value": alet } );
						},
						"sDom": '<"filtroDX">l<"infoDX">r<"data_tDX"t>', 
						"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
						"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
						"sZeroRecords":"LA NOTA MÉDICA NO CUENTA CON DIAGNÓSTICOS","sInfo":"MOSTRADOS: _END_", 
						"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>DIAGNÓSTICOS: _MAX_","sSearch": "BUSCAR" }
					});/*fin datatable*/ $('#clickmeDX').click(function(e) { oTableDX.fnDraw(); });
					
					$('.grafi, .historialhes, .botonC').click(function(event) { event.preventDefault(); });
					$('.grafi').button({ icons: { primary: "ui-icon-image" }, text: false });
					$('.historialhes').button({ icons: { primary: "" }, text: true });
					
					$("#tipoNotaMed").load("genera/tNotaMedica.php", function(response,status,xhr){ if(status=="success"){
						var datosT = {idP:idP, idU:$('#idUser').val(), aleatorio:aleatorioN1, idH, idH}
						$.post('files-serverside/cat_texts.php',datosT).done(function(dataT){ var datosTe = dataT.split('-{]');
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
							
							$("#tipoNotaMed").change(function(e) {
								var datos = {idNM:$("#tipoNotaMed").val()}
								$.post('files-serverside/textoNotaM.php',datos).done(function(data){ //alert(data);
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
									$('#tabs_nnm #tabs-1n .jqte_editor').html(data);
								});
							});
						});
					}});
				} });
				
            });
			
			var oTableHil;
			oTableHil = $('#dataTableHis').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
					$('#dialog-historiales span.DataTables_sort_icon').remove(); var q = 1;
					if(q==1){ window.setTimeout(function(){
						$('#dataTableHis tbody tr:first').addClass('marcadorLista');
						var miIdNota = $('#dataTableHis tbody tr:first span').parent().parent().html().split('"');
						rDXn(miIdNota[1],miIdNota[3]); //alert(miIdNota[1])
					},20); } q++;
				},
				"destroy":true,"bJQueryUI":true,"bRetrieve":true,"bAutoWidth":true,"bStateSave":false,
				"sScrollY":$('#contenedorDTHI').height()-25, "bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]], 
				"aoColumns": [{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }], 
				"iDisplayLength": 300000, "bLengthChange": false, "bProcessing": true, ordering: false, 
				"bServerSide": true,"sAjaxSource": "datatable-serverside/historial_notas_medicas.php",
				"fnServerParams": function (aoData, fnCallback) { var aleatorio = idP, idC = idH;
					aoData.push(  {"name": "aleatorio", "value": aleatorio } ); aoData.push(  {"name": "idC", "value": idC } );
				},
				"sDom": '<"filtroDX1">l<"infoDX1">r<"data_tDX1"t>', 
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage":{"sLengthMenu":"MONSTRANDO _MENU_ records per page",
				"sZeroRecords":"NO HAY HISTORIAL DE NOTAS DE EVOLUCIÓN","sInfo":"MOSTRADAS: _END_", 
				"sInfoEmpty": "MOSTRADAS: 0", "sInfoFiltered": "<br/>NOTAS: _MAX_","sSearch": "BUSCAR" }
			}); $('#clickmeHis').click(function(e) { oTableHil.fnDraw(); });
			
			$('#thi-7-1').click(function(e) { //HC
				$("#tabs-7hi").load("../consultas/htmls/historia_clinicaC.php #tabs_hc", function( response, status, xhr ) {
				if( status == "success" ){
					$('#b_editarHC').button({ icons:{primary:'ui-icon-pencil'} });
					$('#b_actualizarHC').button({ icons:{primary:'ui-icon-refresh'} });
					$('#b_cancelHC').button({ icons:{primary:'ui-icon-cancel'} });
					
					$('#idUsuario_hc').val($('#idUser').val());$('#formHistoriaClinica').validate({ignore: 'hidden'});
					$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').addClass('campoITtab'); 
					$("#tabs_hc").tabs({active: 0}); $('.botonC').click(function(event) { event.preventDefault(); });
					$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').prop('disabled',true); 
					$('#b_actualizarHC, #b_cancelHC').hide(); $('#tabs_hc ul').removeClass('ui-widget-header');
					$('#tabs_hc *').css('font-size','0.97em');
					$('#b_editarHC').click(function(e) {
						$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').prop('disabled',false); 
						$('#b_actualizarHC, #b_cancelHC').show(); $('#b_editarHC').hide();
					});
					$('#b_cancelHC').click(function(e) {
						$('#tabs_hc input, #tabs_hc select, #tabs_hc textarea').prop('disabled',true); 
						$('#b_actualizarHC, #b_cancelHC').hide(); $('#b_editarHC').show(); $('#tabs-2-1').click();
					});
					$('#b_actualizarHC').click(function(e) { 
						var datosHC1 = $('#formHistoriaClinica').serialize();
						$.post('../consultas/files-serverside/actualizarHC.php',datosHC1).done(function(data){ if(data==1){
							$('#texto-informar').text('La historia clínica se ha guardado correctamente.'); 
							$('#thi-7-1').click();
							
							$('#dialog-informar').dialog({autoOpen:true,modal:true,width:500,height:150,
								title:'HISTORIA CLÍNICA ACTUALIZADA',closeText:'', buttons:{},
								open:function(event, ui){ 
									window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); 
								}
							});
						}else{alert(data);} });
					});
				$('#idPaciente_hc').val(idP); var datosIDP = {idP:idP, idC:1}
				  $.post('../consultas/files-serverside/datosSV.php',datosIDP).done(function(data){ var datos = data.split(';*-');
					var datosMiHC = { idP:idP }
					$.post('../consultas/files-serverside/datosHC.php',datosMiHC).done(function(dataHC){ 
						var datosHC = dataHC.split(';*-'); 
						$('.estatusVive').load("../consultas/files-serverside/cargar_estatus_vive.php",function(response,status,xhr){
							$('#estatus_padre').val(datosHC[0]);$('#estatus_madre').val(datosHC[5]);
							$('#estatus_conyugue').val(datosHC[15]);
							$('#formHistoriaClinica select.estatusVive').change(function(e) { 
								if($(this).val()!=''){ $(this).addClass('formatoHC'); }
								else{ $(this).removeClass('formatoHC');} 
						});
						$('#formHistoriaClinica select.estatusVive').each(function(index, element) { 
							if($(this).val()!=''){ $(this).addClass('formatoHC');}
							else{ $(this).removeClass('formatoHC');} 
						}); 
					});
					
					$('.enfermedad').load("../consultas/files-serverside/cargar_enfermedades.php", function(response,status,xhr) {
						$('#ahf_padre_1').val(datosHC[1]);$('#ahf_padre_2').val(datosHC[2]);
						$('#ahf_padre_3').val(datosHC[3]);$('#ahf_padre_4').val(datosHC[4]);
						$('#ahf_madre_1').val(datosHC[6]);$('#ahf_madre_2').val(datosHC[7]);
						$('#ahf_madre_3').val(datosHC[8]);$('#ahf_madre_4').val(datosHC[9]);
						$('#noHnos').val(datosHC[10]);$('#ahf_hnos_1').val(datosHC[11]);
						$('#ahf_hnos_2').val(datosHC[12]);$('#ahf_hnos_3').val(datosHC[13]);
						$('#ahf_hnos_4').val(datosHC[14]);$('#ahf_conyugue_1').val(datosHC[16]);
						$('#ahf_conyugue_2').val(datosHC[17]);$('#ahf_conyugue_3').val(datosHC[18]);
						$('#ahf_conyugue_4').val(datosHC[19]);$('#noHijos').val(datosHC[20]);
						$('#ahf_hijos_1').val(datosHC[21]);$('#ahf_hijos_2').val(datosHC[22]);
						$('#ahf_hijos_3').val(datosHC[23]);$('#ahf_hijos_4').val(datosHC[24]);
						$('#ahf_notas').val(datosHC[25]);$('#enfermedad1').val(datosHC[63]);
						$('#enfermedad2').val(datosHC[64]);$('#enfermedad3').val(datosHC[65]);
						$('#enfermedad4').val(datosHC[66]);
						window.setTimeout(function(){
							$('#formHistoriaClinica select').change(function(e) { 
								if($(this).val()!=''){$(this).addClass('formatoHC');} else{$(this).removeClass('formatoHC');} 
							});
							$('#formHistoriaClinica select').each(function(index, element) { 
								if($(this).val()!=''){ $(this).addClass('formatoHC');} else{ $(this).removeClass('formatoHC');} 
							}); 
							$('#formHistoriaClinica input[type=text],#formHistoriaClinica textarea').keyup(function(e) {
								if($(this).val()!=''){ $(this).addClass('formatoHC').css('color','black');}
								else{ $(this).removeClass('formatoHC').css('color','black');} 
							});
							$('#formHistoriaClinica input[type = text],#formHistoriaClinica textarea').each(function(index, element) { 
								if($(this).val()!=''){ $(this).addClass('formatoHC').css('color','black');}
								else{ $(this).removeClass('formatoHC').css('color','black');} 
							}); 
						},700);
					});
					$('#alergia1').val(datosHC[88]);$('#alergia2').val(datosHC[89]);$('#alergia3').val(datosHC[90]);
					$('#alergia4').val(datosHC[91]);$('#alergia5').val(datosHC[92]);$('#alergia6').val(datosHC[93]);
					$('#cirugia1').val(datosHC[67]); $('#cirugia2').val(datosHC[68]); $('#cirugia3').val(datosHC[69]);
					$('#transfusiones').val(datosHC[70]);$('#app_notas').val(datosHC[71]);$('#menarca').val(datosHC[72]);
					$('#ritmo').val(datosHC[73]);$('#duracionR').val(datosHC[74]);$('#fur').val(datosHC[75]);
					$('#ivsa').val(datosHC[76]);$('#gestas').val(datosHC[77]);$('#partos').val(datosHC[78]);
					$('#cesareas').val(datosHC[79]);$('#abortos').val(datosHC[80]);$('#anticonceptivo').val(datosHC[81]);
					$('#tiempo_uso').val(datosHC[83]);$('#doc').val(datosHC[84]); $('#colposcopiaHC').val(datosHC[85]);
					$('#mastografiaHC').val(datosHC[86]); $('#ago_notas').val(datosHC[87]);
						
					$('.adiccion').load("../consultas/files-serverside/cargar_adicciones.php",function( response, status, xhr ) { 
						$('#adiccion1').val(datosHC[26]);$('#adiccion2').val(datosHC[27]); $('#adiccion3').val(datosHC[28]); 
					});
					$('.deporte').load("../consultas/files-serverside/cargar_deportes.php", function( response, status, xhr ) { 
						$('#deporte1').val(datosHC[35]);$('#deporte2').val(datosHC[36]); 
					});
					$('.inicio').load("../consultas/files-serverside/cargar_inicios.php", function( response, status, xhr ) { 
						$('#inicio_adiccion1').val(datosHC[29]);$('#inicio_adiccion2').val(datosHC[30]);
						$('#inicio_adiccion3').val(datosHC[31]); 
					});
					$('.frecuencia').load("../consultas/files-serverside/cargar_frecuencias.php",function(response, status, xhr ){
						$('#frecuencia_deporte1').val(datosHC[37]);$('#frecuencia_deporte2').val(datosHC[38]); 
						$('#frecuencia_adiccion1').val(datosHC[32]);$('#frecuencia_adiccion2').val(datosHC[33]); 
						$('#frecuencia_adiccion3').val(datosHC[34]);$('#apnp_notas').val(datosHC[39]);
					});
					
					$('.recreacion').load("../consultas/files-serverside/cargar_recreaciones.php",function(response,status, xhr ){
						$('#recreacion1').val(datosHC[40]);$('#recreacion2').val(datosHC[41]);
						$('#recreacion3').val(datosHC[42]); $('#recreacion4').val(datosHC[43]);
						$('#recreacion5').val(datosHC[44]);$('#recreacion6').val(datosHC[45]);
					});
					
					$('#vivienda_hc').load("../consultas/files-serverside/cargar_viviendas.php",function(response, status, xhr){
						$('#vivienda_hc').val(datosHC[46]);$('#habitantes').val(datosHC[47]); 
					});
					
					$('.servicio_hc').load("../consultas/files-serverside/cargar_servicios.php",function(response, status, xhr ) {
						$('#servicios1_hc').val(datosHC[50]);$('#servicios2_hc').val(datosHC[51]);
						$('#servicios3_hc').val(datosHC[52]); $('#servicios4_hc').val(datosHC[53]); 
					});
					
					$('.matV').load("../consultas/files-serverside/cargar_mat_vivienda.php", function( response, status, xhr ) { 
						$('#mat_vivienda1').val(datosHC[48]);$('#mat_vivienda2').val(datosHC[49]);
					});
					$('#aseo_personal').load("../consultas/files-serverside/cargar_aseo_personal.php",function(response,status,xhr){
						$('#aseo_personal').val(datosHC[54]);
					});
					
					$('.vacuna').load("../consultas/files-serverside/cargar_vacunas.php", function( response, status, xhr ) { 
						$('#vacunas1').val(datosHC[55]);$('#vacunas2').val(datosHC[56]);$('#vacunas3').val(datosHC[57]);
						 $('#observacionesVacunas').val(datosHC[58]);
					}); 
					$('#hrs_dormir').val(datosHC[59]);
					
					$('#alimentacion_hc').load("../consultas/files-serverside/cargar_alimentaciones.php",function(response,status,xhr ) { 
						$('#alimentacion_hc').val(datosHC[60]); 
					});
					$('.mascota').load("../consultas/files-serverside/cargar_mascotas.php", function( response, status, xhr ) { 
						$('#mascota1').val(datosHC[61]);$('#mascota2').val(datosHC[62]); 
					});
					$('#tipo_anticon').load("../consultas/files-serverside/cargar_anticonceptivos.php",function(response,status,xhr){
						$('#tipo_anticon').val(datosHC[82]);
					});
						
					});
					
				  });
			} });
			}); //Fin HC
			
			$('#thi-6-1').click(function(e) {
                var datosCon = {idP:idP, idH:idH}
				$.post('files-serverside/datosSV.php',datosCon).done(function(data){ var datos = data.split(';*-');
					$('#edadC').text(datos[1]); $('#sexoC').text(datos[2]);$('#pacienteC').text(datos[0]); 
					$('#pesoC').text(datos[3]);$('#tallaC').text(datos[4]);$('#imcC').text(datos[5]);
					$('#cinturaC').text(datos[6]); $('#tC').text(datos[7]);$('#aC').text(datos[8]);
					$('#frC').text(datos[9]);$('#fcC').text(datos[10]);$('#tempC').text(datos[11]);$('#notasC').text(datos[12]);
					$('#motivoC').text(datos[14]);$('#notaMedicaC').text(datos[15]);
					$('#notaMedicamentosC').text(datos[16]); $('#indiF').text(datos[18]); $('#fechaSignosC').text(datos[13]);
					$('#fechaIngresoC').text(datos[15]);
				});
            });
			$('#b_agregarSignosC').click(function(event) { event.preventDefault(); });
			$('#b_agregarSignosC').click(function(e) { signosVvacios(idP,2); });
		}
	});
} });
});}

function rDXn(idNota,idHospitalizacion){$(document).ready(function(e){
	var datosNM = {idN:idNota, idH: idHospitalizacion}
	$.post('files-serverside/datosNotaMedica.php',datosNM).done(function(data){
		var miDataNE = data.split(';*}-{'); $('#notaNE').html(miDataNE[0]); $('#alergiasNE').html(miDataNE[1]);
		$('#fcNE').text(miDataNE[2]);$('#frNE').text(miDataNE[3]);$('#taNE').text(miDataNE[4]);
		$('#tempNE').text(miDataNE[5]);$('#pesoNE').text(miDataNE[6]);$('#tallaNE').text(miDataNE[7]);
		$('#imcNE').text(miDataNE[8]); //alert(miDataNE[9]);
		$('#aleatorioN1').val(miDataNE[9]); $('#clickmeDXh').click();
		
		//para las indicaciones con medicamentos
		if(miDataNE[10]>0){
			$('#titulo_indi_nh').text('MEDICAMENTOS:'); $('#indicaciones_indi_nh').html(miDataNE[11]);
			$('#medicamentos_indi_nh').html(miDataNE[12]);
		}
		else{
			$('#titulo_indi_nh').text('LA NOTA MÉDICA NO CUENTA CON MEDICAMENTOS');
			$('#medicamentos_indi_nh').html(miDataNE[11]); $('#indicaciones_indi_nh').html('');
		}
		
		//para las recomendaciones
		if(miDataNE[13]=='' || miDataNE[13]==null){$('#recomendaciones_nh').html('LA NOTA MÉDICA NO CUENTA CON RECOMENDACIONES');}
		else{ $('#recomendaciones_nh').html(miDataNE[13]); }
	});
}); }

function imc(a,b){ var imc; 
	imc=redondear((parseFloat(a)/(parseFloat(b)*parseFloat(b))),2); 
	if (imc>0 & imc<10000){ document.getElementById('imcSV').value=imc;}else{ document.getElementById('imcSV').value=''; } 
}
function imc1(a,b){ var imc; 
	imc=redondear((parseFloat(a)/(parseFloat(b)*parseFloat(b))),2); 
	if (imc>0 & imc<10000){ $('.miDvisSV #imcSV').val(imc); }else{ $('.miDvisSV #imcSV').val(''); } 
}
function checarEscala(id){ $(document).ready(function(e) {//if($('#'+id).val()>0){ }else{}
	var x = 0; $('#dialog-nivel2 .escala_g').each(function(index, element) { x = parseInt(x) + parseInt($(this).val()); });
	$('#dialog-nivel2 #total_escala_g').text(x); $('#dialog-nivel2 .'+id).text($('#dialog-nivel2 #'+id).val());
}); }

function signosVvacios(idP,control){ $(document).ready(function(e) {//si control es 1 al cerrar la ventana abre VerSignos
	$("#dialog-nivel2").load("../consultas/htmls/signos_vitales.php",function(response,status,xhr){if(status=="success"){
		$('#tabs_sv #tabs-1-1').text('SIGNOS VITALES');
		$('#idUsuario_sv').val($('#idUser').val()); 
		$('#dialog-nivel2 input, #dialog-nivel2 select, #dialog-nivel2 textarea').addClass('campoITtab'); 
		$(".miDvisSV").tabs({active: 0}); $('#dialog-nivel2 #tabs-4-1').hide(); $('#dialog-nivel2 #tabs-5-1').hide();
		$("#dialog-nivel2").css('overflow','hidden'); //alert(control);
		$('#dialog-nivel2 #formSignosVitales').validate({ignore: 'hidden'});
		var datosIDP = {idP:idP,idC:1}
	  $.post('../consultas/files-serverside/datosSV.php',datosIDP).done(function(data){ 
	  	var datos = data.split(';*-'); 
		$('.miDvisSV #pacienteSV').val(datos[0]); $('.miDvisSV #edadSV').val(datos[1]); $('.miDvisSV #sexoSV').val(datos[2]);
		
		var he1 = $('#referencia').height() - 95, wi1 = $('#referencia').width() * 0.98, 
		titulo1 = 'NUEVOS SIGNOS VITALES. PACIENTE: '+datos[0];
		$('#dialog-nivel2').dialog({
			autoOpen: true, modal: true, width: wi1, height: he1, title: titulo1, closeText: '', closeOnEscape: false, 
			dialogClass: 'no-close',
			buttons: { /*'Guardar': function() { }, 'Cancelar': function() { } */}, 
			open: function( event, ui ) { //$('#dialog1').dialog('close');
				$('#formSignosVitales').validate({ignore: 'hidden'}); $('#tabs_sv ul').removeClass('ui-widget-header'); 
				$('#dialog-nivel2 #tomarNSV,#dialog-nivel2 #tabs-2-1,#dialog-nivel2 #tabs-3-1').hide();
				$('#cancelNSV,#saveNSV').show();
				
				$('.miDvisSV #pesoSV').keyup(function(e){
					if($(this).val()>0 & $(this).val()<650){ imc1($(this).val(),$('.miDvisSV #tallaSV').val()); }
				});
				$('.miDvisSV #tallaSV').keyup(function(e){
					if($(this).val()>0 & $(this).val()<3){imc1($('.miDvisSV #pesoSV').val(),$(this).val());}
				});
				
				$('#cancelNSV').click(function(event) {  event.preventDefault();  $('#dialog-nivel2').dialog('close'); });

				$('#cancelNSV').button({ icons:{ primary:'ui-icon-cancel' } });
				$('#saveNSV').click(function(event){ event.preventDefault(); }); 
				
				$('#saveNSV').click(function(e) {
					if($('#dialog-nivel2 #formSignosVitales').valid()){
						var datosSsv={
							idPx1:idP,idU:$('#idUser').val(),peso:$('.miDvisSV #pesoSV').val(),
							talla:$('.miDvisSV #tallaSV').val(),cintura:$('.miDvisSV #cinturaSV').val(),
							imc:$('.miDvisSV #imcSV').val(), t:$('.miDvisSV #tSV').val(),a:$('.miDvisSV #aSV').val(),
							fr:$('.miDvisSV #frSV').val(), fc:$('.miDvisSV #fcSV').val(), temp:$('.miDvisSV #tempSV').val(), 
							notas:$('.miDvisSV #notasSV').val(), oximetria:$('#tabla_sv #oxiSV').val(), 
							aocular:$('.miDvisSV #abertura_ocular').val(), rverbal:$('.miDvisSV #respuesta_verbal').val(), 
							rmotriz:$('.miDvisSV #respuesta_motriz').val()
						}
						var sumi = 0, valido = 1;
						$('.escala_g').each(function(index, element){ sumi=parseInt(sumi) + parseInt($(this).val()); });
						if(sumi==0){valido=1;}else{$('.escala_g').each(function(index,element){if($(this).val()==0){valido=0;}});}
						
						if(valido==1){
							$.post('../enfermeria/files-serverside/guardarSV.php',datosSsv).done(function(data){ 
								if(data==1){ $('#clickme').click();
									$('#thi-6-1').click();
									$('#texto-informar').text('Los signos vitales se han guardado correctamente.');
									$('#dialog-nivel2').dialog('close');
									$('#dialog--nivel3').dialog({
										title:'DATOS GUARDADOS',modal:true,autoOpen:true,closeText:'',width:600, height:200,
										closeOnEscape:true,dialogClass:'', buttons:{},
										open:function(event,ui){
											window.setTimeout(function(){$('#dialog--nivel3').dialog('close');},2500);
										} 
									});
								} else{alert(data);}
							});
						}else{$('.escala_g').each(function(index, element){ $(this).addClass('error'); });}
					}//fin valid
				});
				$('#saveNSV').button({ icons:{ primary:'ui-icon-disk' } });
			}, close: function( event, ui ){ $(".miDvisSV").tabs("destroy"); }
		});
	  });
	} });
}); }

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
function visualizar(x){ $(document).ready(function(e) { var x1=x; x='takeArchivos/pdf/'+x+'.pdf'; 
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
}); }
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
						Cancelar: function() { $(this).dialog("close"); }
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
				$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); $('.myNotaToma').html('<em>OBSERVACIONES</em>: '+datosP[8]);
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