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
<title>REPORTE IMAGEN</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
<link href="../jquery-ui-1.12.1/jquery-ui.structure.css" rel="stylesheet">
<link href="../jquery-ui-1.12.1/jquery-ui.theme.css" rel="stylesheet">
<link rel="stylesheet" href="../DataTables-1.10.13/media/css/jquery.dataTables.css">
<link href="../DataTables-1.10.13/extensions/Buttons/css/buttons.jqueryui.css" rel="stylesheet">

<script src="../jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="../DataTables-1.10.13/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.13/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/dataTables.buttons.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/buttons.jqueryui.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/buttons.html5.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/buttons.print.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/jszip.min.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/vfs_fonts.js"></script>
<script src="../DataTables-1.10.13/extensions/Buttons/js/buttons.colVis.js"></script>
<script src="../DataTables-1.10.13/extensions/Select/js/dataTables.select.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../laboratorio/takeArchivos/ajaxupload.js" type="text/javascript"></script>
<script src="../funciones/js/jquery.media.js" type="text/javascript"></script> 
<script src="../funciones/js/jquery.metadata.js" type="text/javascript"></script>
<script src="../funciones/js/jquery.fileDownload.js" type="text/javascript"></script>

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

<script type="text/javascript">
//para fintro individual por campo de texto
var asInitVals = new Array();
//fin para filtro individual por campo de texto
$(document).ready(function() {
	$( "#progressbar" ).progressbar({ value: false });
	  
	$('#dialog-subiendo').dialog({ autoOpen: false, modal: true, closeOnEscape: false, width: 620, height:150, title: 'CARGANDO ARCHIVO', closeText: '', dialogClass: 'no-close', open:function( event, ui ){ } });
	$('#dialog-alerta').dialog({ autoOpen: false, modal: true, width: 620, height:150, title: '¡ATENCIÓN!', closeText: '', open:function( event, ui ){ window.setTimeout(function(){$('#dialog-alerta').dialog('close');},2500); } });
	
	var tam = $('#referencia').height() - 200;
	
	oTable = $('#dataTable').DataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
			myFunction(); $('span.DataTables_sort_icon').remove();
			window.setTimeout(function(){$('#clickme').removeClass('sorting_asc');},10);
			/* Calculate the market share for browsers on this page */
            //var iTotal = 0; for ( var i=iStart ; i<iEnd ; i++ ) { iTotal += aaData[ aiDisplay[i] ][7]*1; }
            /* Modify the footer row to match what we want */
            //var nCells = nRow.getElementsByTagName('td'); nCells[7].innerHTML = '$'+redondear(parseFloat(iTotal * 100)/100,2);
		},
		"bJQueryUI": true, ordering: true, scroller: false, deferRender: true, "sScrollY": tam, scrollCollapse: false,
		"bAutoWidth": false, "bPaginate": true, "bStateSave": false, "iDisplayLength": 500000000000, "bLengthChange": false,
		"bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]], "bProcessing": false, "bServerSide": true,
		"aoColumns": [
			{ "bSortable": false, "aTargets": [ 0 ] }, 
			{ "bSortable": false, "aTargets": [ 1 ] }, 
			{ "bSortable": false, "aTargets": [ 2 ] }, 
			{ "bSortable": false, "aTargets": [ 3 ] }, 
			{ "bSortable": false, "aTargets": [ 4 ], "bVisible": false }, 
			{ "bSortable": false, "aTargets": [ 5 ], "bVisible": false }, 
			{ "bSortable": false, "aTargets": [ 6 ], "bVisible": false }, 
			{ "bSortable": false, "aTargets": [ 7 ], "bVisible": true }, 
			{ "bSortable": false, "aTargets": [ 8 ], "bVisible": true }, 
			{ "bSortable": false, "aTargets": [ 9 ], "bVisible": true }, 
			{ "bSortable": false, "aTargets": [ 10 ] },
			{ "bSortable": false, "aTargets": [ 11 ] },
			{ "bSortable": false, "aTargets": [ 12 ] },
			{ "bSortable": false, "aTargets": [ 13 ] },
			{ "bSortable": false, "aTargets": [ 14 ] },
			{ "bSortable": false, "aTargets": [ 15 ] },
			{ "bSortable": false, "aTargets": [ 16 ] },
			{ "bSortable": false, "aTargets": [ 17 ] },
			{ "bSortable": false, "aTargets": [ 18 ], "bVisible": false },
		],
		"sDom": 'B<"info"i><"opcTable"T><"data_t"t>', 
		buttons: [
            'copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5',
			{ extend: 'print', exportOptions: { columns: ':visible' } },
            'colvis'
        ],
		"sAjaxSource": "datatable-serverside/reportes.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de = document.getElementById('fechaDe').value+' 00:00:00', a = $('#fechaA').val()+' 23:59:59';
			var convenio = $('#sConvenio').val(); 
			aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } );
			aoData.push(  {"name": "convenio", "value": convenio } ); 
		},
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { 
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "&nbsp;TOTAL DE ESTUDIOS: _MAX_", 
			"sSearch": "BUSCAR", buttons: { colvis: 'Columnas', copyTitle: 'Copiar', }
		}
	});//fin data table
	// Apply the search
    oTable.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) { that.search( jQuery.fn.dataTable.ext.type.search.string(this.value) ).draw(); }
        } );
    } );
	
	$('#clickme').click(function(e) { oTable.draw(); myFunction(); });
	
	$('.info').css('float','right').css('white-space','nowrap').css('color','black').css('border','1px none red');
	
	$('#sConvenio').change(function(e) { $('#clickme').click(); });
	
	$('#radio1').click(function(e) { $('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.draw(); });
	$('#radio2').click(function(e) { $('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.draw(); });
	$( "#fechaDe" ).datepicker({
	  	defaultDate: "-1", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaA" ).datepicker( "option", "minDate", selectedDate ); },
		"onSelect": function(date) { min = date+' 00:00:00'; oTable.draw(); }
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({
		defaultDate: "+0", maxDate: +0,
		onClose: function( selectedDate ) { $( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); },
		"onSelect": function(date) { max = date+' 23:59:59'; oTable.draw(); }
	}).css('max-width','100px');
	
	$('#sConvenio').load('genera/convenios.php',function(response,status,xhr){if( status == "success" ) {} });
			
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
	$( '#rangosFechas' ).buttonset().css('font-size','0.9em');
	$('.rad').css('font-size','0.8em');
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

<div style="display:none;" id="dialog-upload" title="INTERPRETACIÓN">
		<span id="spanDialog"></span>
  <iframe id="miFrame" allowtransparency="yes" frameborder="0" src="../editorTexto/Untitled-3.php" style="width:850px; height:440px;"></iframe>
</div>

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoEstudios.png" height="40"></td>
        <td align="left" valign="middle" nowrap><span id="verMenu" style="cursor:pointer;">REPORTE DE ESTUDIOS DE IMAGEN</span></td>
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

<div class="contenido" id="contenido" align="center">

  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr class="titulos_dataceldas">
        <th id="clickme" width="1px">#</th>
        <th>PACIENTE</th>
        <th width="1%" nowrap>REFERENCIA</th>
        <th>ESTUDIO</th>
     	<th width="1px">ESTATUS</th>
        <th width="1px">SUCURSAL</th>
        <th width="1px">ÁREA</th>
        <th nowrap width="10">REG</th>
        <th nowrap width="10">HORA</th>
        <th nowrap width="1">PROC</th>
        <th nowrap width="40">HORA</th>
        <th nowrap width="1">REA</th>
        <th nowrap width="40">HORA</th>
        <th nowrap width="1">CAP</th>
        <th nowrap width="40">HORA</th>
        <th nowrap width="1">INTER</th>
        <th nowrap width="40">HORA</th>
        <th nowrap width="40">TIEMPO</th>
        <th nowrap width="40">PRODECENCIA</th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
    	<tr>
        	<td></td>
        	<td><input name="sPaciente" id="sPaciente" type="text" placeholder="Paciente" class="" style="width:90%;" /></td>
        	<td><input name="sPaciente1" id="sPaciente1" type="text" placeholder="Referencia" class="" style="width:90%;"/></td>
        	<td><input name="sPaciente2" id="sPaciente2" type="text" placeholder="Estudio" class="" style="width:90%;" /></td>
        	<td><input name="sPaciente3" id="sPaciente3" type="text" placeholder="Estatus" class="" style="width:90%;" /></td>
			<td><input name="sPaciente4" id="sPaciente4" type="text" placeholder="Sucursal" class="" style="width:90%;" /></td>
            <td><input name="sPaciente6" id="sPaciente6" type="text" placeholder="Área" class="" style="width:90%;" /></td>
            <td><input name="sPaciente7" id="sPaciente7" type="text" placeholder="Registró" class="" style="width:90%;" /></td>
            <td></td>
            <td><input name="sPaciente8"id="sPaciente8"type="text" placeholder="Procesó" class="" style="width:90%;" /></td>
            <td></td>
            <td><input name="sPaciente9"id="sPaciente9"type="text" placeholder="Realizó" class="" style="width:90%;" /></td>
            <td></td>
            <td><input name="sPaciente10"id="sPaciente10"type="text" placeholder="Capturó" class="" style="width:90%;" /></td>
            <td></td>
            <td><input name="sPaciente11"id="sPaciente11"type="text" placeholder="Interpretó" class="" style="width:90%;" /></td>
            <td></td>
            <td></td>
            <td><input name="sPaciente12"id="sPaciente12"type="text" placeholder="Procedencia" class="" style="width:90%;" /></td>
        </tr>
    </tfoot>
  </table>
  
  <div id="divRangoFechas" style="border:1px none blue; display:block; position:relative; float:left; width:70%;"><table width="100%" style="color:black;" border="0" cellpadding="3" cellspacing="0">
  <tr align="left">
    <td nowrap>De </td> 
    <td nowrap><input name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td nowrap>A </td> 
    <td nowrap><input name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td id="rangosFechas" nowrap width="150">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td align="left" width="90%"><select name="sConvenio" id="sConvenio"></select></td>
  </tr>
</table>
</div>
  
  </div>

<div id="dialog-captura" style="display:none; text-align:left; background-size:cover; background-repeat:no-repeat; background-position:center;">
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
  <tr> <td style="color:red;">Recomendamos que confirme de inmediato el resultado interpretándolo... Se abrirá la ventana de interpretación.</td> </tr>
</table>
</div>

<div id="dialog-confirmInterpretacion" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td align="center">¡El estudio se ha interpretado satisfactoriamente!</td> </tr>
  <tr> <td align="center">¿Desea imprimir el resultado del estudio de una vez?</td> </tr>
</table>
</div>

<div id="dialog-impresion" style="display:none;">
<table id="tablaImpresion" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
  <tr>
    <td height="3%" id="miEncabezado"><br><br><br><br><br><br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="220px" align="left">PACIENTE:</td> 
                <td class="myPacienteP" align="left" width="" nowrap></td> 
                <td class="mySexoP" align="left" width="140px"></td> 
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="220px" nowrap align="left">FECHA DE NACIMIENTO: </td> 
                <td class="myFnacP" align="left" width="110px" nowrap></td> 
                <td width="" nowrap align="right">EDAD:</td> 
                <td class="myEdadP" align="left" width="140px"></td> 
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                  <td width="220px" nowrap align="left" align="left">REFERENCIA DEL ESTUDIO:</td> 
                  <td class="myReferenciaP" align="left" width=""></td> 
                  <td nowrap width="" align="right">FECHA DEL ESTUDIO:</td> 
                  <td class="myFechaP" align="left" width="140px"></td> 
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
              	<td nowrap width="220px" align="left">UNIDAD MÉDICA:</td> 
                <td class="myUnidadMedicaP" align="left" width=""></td>
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> <td nowrap width="220px" align="left">Dr(a).</td> <td class="myMedicoP" align="left"></td> </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> <td width="220px" nowrap align="left">ESTUDIO:</td> <td class="myEstudioP" align="left"></td> </tr>
            </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td style="border-top:1px dashed black; padding-top:10px; border-bottom:1px dashed black; padding-bottom:10px;" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> <td class="myDiagnosticoP" align="left" valign="top">a</td> </tr>
    </table>
    </td>
  </tr>
  <tr height="1%">
    <td class="myFirmaP">
    <table height="1%" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> <td width="50%">&nbsp;</td> <td class="firmaDR" align="center"> </td> </tr>
      <tr> <td>&nbsp;</td> <td nowrap align="center"><span class="dr">DR.</span>&nbsp;<span class="nombreDR">MALAN</span></td> </tr>
      <tr> <td>&nbsp;</td> <td nowrap align="center">MÉDICO RADIÓLOGO</td> </tr>
      <tr> <td>&nbsp;</td> <td nowrap align="center"><span class="puestoDR"></span>&nbsp;CEDULA ESPECIALIDAD&nbsp;<span class="cedula">1233213</span></td> </tr>
      <tr> <td>&nbsp;</td> <td nowrap align="center">RECTIFICADO POR CONSEJO MEXICANO DE RADIOLOGÍA E IMAGEN</td> </tr>
      <tr><td>&nbsp;</td> <td nowrap align="center" style="padding-bottom:0.8cm;">&nbsp;&nbsp;2011 AL 2015. NO. FOLIO 2711</td> </tr>
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
  <a href="osirix://?methodName=DownloadURL&Display=YES&URL='http://clidi.ddns.net:3333/wado?requestType=WADO&studyUID=1.3.51.0.7.14163771183.54367.43849.37406.22234.65265.49021'"><img src="../imagenes/osirix.png"></a> </td> </tr>
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
		$('#dialog-entregar').dialog({ autoOpen: true, modal: true, width: 700, height: 200, closeOnEscape: false, title: title, closeText: '',
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
		autoOpen:false, modal:true, title:'CONFIRMACIÓN ESTUDIO INTERPRETADO', width: 550, height: 230, resizable: false, closeText:'', closeOnEscape: true,
		buttons:{ 'Imprimir': function(){ imprimir($('#preImprimir').val()); $('#dialog-confirmInterpretacion').dialog('close'); }, 'Cerrar': function(){ $('#dialog-confirmInterpretacion').dialog('close'); } }
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
		
		//del pdf
		$('.mipdf').each(function(index, element) {//alert(index);
			var button = $(this), interval; var idP=$(this).prop('id');
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
					$.post('archivos_save_ajax/cargar.php', datosCargar).done(function( data ) { if (data == 1){ $('#clickme').click(); }else{alert(data);} });
					window.clearInterval(interval); 
				}
			});//Fin del pdf 
		});
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
		autoOpen:false, modal:true, title:'CONFIRMACIÓN CAPTURA', width: 600, height: 200, resizable: false, closeText:'', closeOnEscape: true,
		open: function( event, ui ) { setTimeout(function(){$('#dialog-confirmCaptura').dialog('close');},2000); }, close: function( event, ui ) { interpretar($('#myIDestudio').val(),$('#myIDestudio').val()) }
	});
	
        $( "#dialog-upload" ).dialog({
            autoOpen: false, show: "blind", modal: true, width: 900, height: 650, hide: "explode", resizable: false, closeOnEscape: false,
			buttons: {
				"Guardar": function() {
					var datox ={estatus:'ENTREGADO', interpretacion:window.frames.miFrame.hola(), id_vc_ini:$('#id_vc_ini').val(), usuario_ini:$('#usuario_ini').val()}
					$.post('archivos_save_ajax/edoPendienteAentregado.php', datox, processData);
					function processData(data) { console.log(data); if (data == "ok"){ $( this ).dialog( "close" ); }else{alert(data);} }
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
					//para los checkbox de la ventana de proceso
					$('#individualPro').click(function(e) { if($(this).prop('checked')==true){ $('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();}else{ $('#individualPro').prop('checked',true); } });
					$('#variosPro').click(function(e) { if($(this).prop('checked')==true){ $('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();}else{ $('#variosPro').prop('checked',true); } });
					
					$('#idPacientePro').val(a); $('#idEstudioPro').val(b); var datoP = {idP:a, idE:b}
					$.post('archivos_save_ajax/datosProcesar.php', datoP).done(function( data ) { var datosP = data.split('*}'); 
						$('#pacientePro').val(datosP[0]); $('#refPro').val(datosP[1]); $('#ordenPro').text(datosP[1]); $('#estPro').val(datosP[2]); $('#areaPro').val(datosP[3]); $('#observacionPro').val(datosP[4]);
						$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); $('#checaPro').val(0); $('#notificacionPro').hide();
						
						if(datosP[5]>1){ $('.variosEstu').show();$('#checaPro').val(0); }else{ $('.variosEstu').hide();$('#checaPro').val(1); }
						
						var tamHX = $('#referencia').height() - 100; var tamWX = $('#referencia').width() * 0.95;
						$('#dialog-procesar').dialog({
							autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close',
							close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
							buttons: {
								Procesar: function(){
									if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
									else{
										$('#idUserPro').val($('#idUser').val());
										var datoP = $('#form-procesar').serialize();
										$.post('archivos_save_ajax/procesar.php', datoP).done(function( data ) { if (data == 1){ $('#clickme').click(); $('#dialog-procesar').dialog('close');}else{alert(data);} });
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
function realizar(a,b){//a es el id del paciente y b es el id del estudio en venta de conceptos
$(document).ready(function(e) {
	$("#dialog-procesar").load('htmls/procesar.php', function( response, status, xhr ) {
		if ( status == "success" ) { 
			//para los checkbox de la ventana de proceso
			$('#individualPro').click(function(e) { if($(this).prop('checked')==true){ $('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();}else{ $('#individualPro').prop('checked',true); } });
			$('#variosPro').click(function(e) { if($(this).prop('checked')==true){ $('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();}else{ $('#variosPro').prop('checked',true); } });
			
			$('.miProcesar').text('Capturar');$('.miprocesar').text('capturar');$('.miProcesados').text('capturados');
			$('#idPacientePro').val(a); $('#idEstudioPro').val(b); var datoP = {idP:a, idE:b}
			$.post('archivos_save_ajax/datosCapturar.php', datoP).done(function( data ) { var datosP = data.split('*}');
				$('#pacientePro').val(datosP[0]); $('#refPro').val(datosP[1]); $('#ordenPro').text(datosP[1]); $('#estPro').val(datosP[2]); $('#areaPro').val(datosP[3]); $('#observacionPro').val(datosP[4]);
				$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); $('#checaPro').val(0); $('#notificacionPro').hide();
				
				if(datosP[5]>1){$('.variosEstu').show();$('#checaPro').val(0);}else{$('.variosEstu').hide();$('#checaPro').val(1);}
				
				var tamHX = $('#referencia').height() - 100; var tamWX = $('#referencia').width() * 0.95;
				$('#dialog-procesar').dialog({
					autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "CAPTURAR ESTUDIO(S)", dialogClass: 'no-close',
					close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
					buttons: {
						Capturar: function(){
							if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
							else{
								$('#idUserPro').val($('#idUser').val());
								var datoP = $('#form-procesar').serialize();
								$.post('archivos_save_ajax/realizar.php', datoP).done(function( data ) { if (data == 1){ $('#clickme').click(); $('#dialog-procesar').dialog('close');}else{alert(data);} });
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
function capturar(a,b){ //a es el id del paciente, b es el id del estudio en venta de conceptos
$(document).ready(function(e) {
	$("#dialog-procesar").load('htmls/procesar.php', function( response, status, xhr ) {
		if ( status == "success" ) { 
			//para los checkbox de la ventana de proceso
			$('#individualPro').click(function(e) { if($(this).prop('checked')==true){ $('#variosPro').prop('checked',false); $('#checaPro').val(1); $('#notificacionPro').hide();}else{ $('#individualPro').prop('checked',true); } });
			$('#variosPro').click(function(e) { if($(this).prop('checked')==true){ $('#individualPro').prop('checked',false); $('#checaPro').val(2); $('#notificacionPro').hide();}else{ $('#variosPro').prop('checked',true); } });
			
			$('.miProcesar').text('Autorizar');$('.miprocesar').text('autorizar');$('.miProcesados').text('autorizados');
			$('#idPacientePro').val(a); $('#idEstudioPro').val(b); var datoP = {idP:a, idE:b}
			$.post('archivos_save_ajax/datosAutorizar.php', datoP).done(function( data ) { var datosP = data.split('*}');
				$('#pacientePro').val(datosP[0]); $('#refPro').val(datosP[1]); $('#ordenPro').text(datosP[1]); $('#estPro').val(datosP[2]); $('#areaPro').val(datosP[3]); $('#observacionPro').val(datosP[4]);
				$('#estudiosPro').text(datosP[5]); $('#areaPro1').text(datosP[6]); $('#notaPro').val(datosP[8]); $('#checaPro').val(0); $('#notificacionPro').hide();
				
				if(datosP[5]>1){$('.variosEstu').show();$('#checaPro').val(0);}else{$('.variosEstu').hide();$('#checaPro').val(1);}
				
				var tamHX = $('#referencia').height() - 100; var tamWX = $('#referencia').width() * 0.95;
				$('#dialog-procesar').dialog({
					autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "AUTORIZAR ESTUDIO(S)", dialogClass: 'no-close',
					close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
					buttons: {
						Autorizar: function(){
							if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
							else{
								$('#idUserPro').val($('#idUser').val());
								var datoP = $('#form-procesar').serialize();
								$.post('archivos_save_ajax/autorizar.php', datoP).done(function( data ) { if (data == 1){ $('#clickme').click(); $('#dialog-procesar').dialog('close');}else{alert(data);} });
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
function interpretar(a,b){ $(document).ready(function(e) { //a es el id del estudio en venta de conceptos
	
}); }

function imprimir(x){// x=id del estudio
	$(document).ready(function(e) {
		$('#dialog-impresion').dialog('open');
		var dato = { idE:x }
		$.post('files-serverside/datosInterpretar.php', dato, processData);
		function processData(data) {
			console.log(data);
			var datos = data.split(';*-');
			document.getElementById('form-captura').reset();
			$('.myPacienteP').html(datos[0]);
			$('.myReferenciaP').html(datos[1]);
			$('.myEdadP').html(datos[2]);
			$('.mySexoP').html(datos[3]);
			$('.myFechaP').html(datos[4]);
			$('.myDiagnosticoP').html(datos[5]);//alert(data);
			$('.myNotaP').html(datos[6]);
			$('.myUnidadMedicaP').html('CLÍNICA SAN ANTONIO');
			$('.myMedicoP').html(datos[7]);
			$('.myEstudioP').html(datos[8]);
			$('.nombreDR').html(datos[9]);
			$('.puestoDR').html('MÉDICO RADIÓLOGO');
			$('.cedula').html(datos[10]);
			$('.myFnacP').html(datos[14]);
			$('.firmaDR').html('<img src="../usuarios/takePicture/firmas/'+datos[11]+'" width="" height="65">');
			if(datos[15]==1){$('.dr').html('DRA.');}else if(datos[15]==2){$('.dr').html('DR.');}
		}
    });//fin ready
}//fin imprimir
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