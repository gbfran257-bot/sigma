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
<title>REPORTE LABORATORIO</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../css/reportes.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="../jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet">
<link href="../TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../DataTables-1.9.1/media/js/jquery.dataTables.js"></script>
<script src="../TableTools-2.1.5/media/js/TableTools.js"></script>
<script src="../TableTools-2.1.5/media/js/ZeroClipboard.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/retardo.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../jQuery-TE_v.1.4.0/uncompressed/jquery-te-1.4.0.js" type="text/javascript" charset="utf-8"></script>
<script src="takeArchivos/ajaxupload.js" type="text/javascript"></script>
<script src="../funciones/js/jquery.media.js" type="text/javascript"></script> 
<script src="../funciones/js/jquery.fileDownload.js" type="text/javascript"></script>

<script>
$(document).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });

$(document).ready(function(e) {
	$('#verMenu').click(function(e){window.location='../menu.php?menu=ml';}); 
	
	//Refrescamos la sesión para que no caduque
	setInterval(function(){$.post('../remote_files/refresh_session.php');},500000);
		
	$( window ).resize(function() { $('#logo').css('max-width',$('#logoI').width()*0.4); });
		
	var i = 1;
	
	$('#dispara_menu').click(function(e) { i++;
		if(i%2==0){
			$('#header').after('<div id="div_menu" class="ver_menu" style="border:1px none red; z-index:1000000000000; position:fixed; width:240px;"><table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="left"><ul id="menu_u1" style="border-bottom-left-radius:4px;border-bottom-right-radius:4px;"><li><div id="mi_perfil"><span class="ui-icon ui-icon-person"></span> Mi perfil</div></li><li><div><span class="ui-icon ui-icon-gear"></span> Configuración</div></li><li><div><span class="ui-icon ui-icon-power"></span> <a href="<?php echo $logoutAction ?>">Cerrar sesión</a></div></li><li><div id="ayuda"><span class="ui-icon ui-icon-info"></span> Ayuda</div></li><li><div id="reportar_problema"><span class="ui-icon ui-icon-wrench"></span> Reportar problema</div></li><li><div id="politicas_condiciones"><span class="ui-icon ui-icon-script"></span> Políticas y condiciones</div></li><li><div id="aviso_privacidad"><span class="ui-icon ui-icon-alert"></span> Aviso de privacidad</div></li><li><div id="acerca_de"><span class="ui-icon ui-icon-star"></span> Acerca de</div></li><li><div id="mi_chat"><span class="ui-icon ui-icon-comment"></span> Chat</div></li></ul></td></tr></table></div>');
			$('#div_menu').css('top',$('#header').height()-0); $('#menu_u1').menu(); 
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
	var tam = $('#referencia').height() - 190;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
			/* Calculate the market share for browsers on this page */
            var iTotal = 0;
            for ( var i=iStart ; i<iEnd ; i++ ) { iTotal    += aaData[ aiDisplay[i] ][7]*1; }
             
            /* Modify the footer row to match what we want */
            var nCells = nRow.getElementsByTagName('td');
			nCells[7].innerHTML  = '$'+redondear(parseFloat(iTotal * 100)/100,2);
		},
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
		"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, 
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false }
		],
		"iDisplayLength": 50000000000, "bLengthChange": false, "bProcessing": false, "bServerSide": true, 
		"sDom": '<"opcTable"T><"data_t"t><"info"i>', 
		"oTableTools": {
			"sSwfPath": "../TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
				{
					"sExtends": "pdf", "sButtonText": "PDF", "sPdfOrientation": "landscape", "sPdfSize": "letter",
					"sPdfMessage": "Reporte de Ingresos."
				},
				{ "sExtends": "xls", "sButtonText": "EXCEL" },
				{ "sExtends": "copy", "sButtonText": "COPIAR" },
				{
					"sExtends": "print", "sButtonText": "IMPRIMIR",
					"sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar."
				}
			]
		},
		"sAjaxSource": "datatable-serverside/reportes.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de = document.getElementById('fechaDe').value+' 00:00:00'; 
			var a = $('#fechaA').val()+' 23:59:59';
			var convenio = $('#sConvenio').val();
			var access = $('#accesoU').val();
			var id_u = $('#idUser').val();
			aoData.push(  {"name": "min", "value": de } ); 
			aoData.push(  {"name": "max", "value": a } );
			aoData.push(  {"name": "convenio", "value": convenio } ); 
			aoData.push({"name": "access", "value": access });
			aoData.push({"name": "id_u", "value": id_u });
		},
		"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
		"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "&nbsp;TOTAL DE ESTUDIOS: _MAX_", "sSearch": "BUSCAR" }
	});//fin data table
	
	$('#clickme').click(function(e) { oTable.fnDraw(); });
	
	$('#sConvenio').change(function(e) { $('#clickme').click(); });
	
	$('.info').css('width','100px').css('float','right').css('white-space','nowrap').css('color','black').css('right','-30');
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { oTable.fnFilter( this.value, $("tfoot input").index(this) ); });
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus(function(){if(this.className=="search_init"){ this.className = ""; this.value = ""; } } );
     
    $("tfoot input").blur( function (i) { if ( this.value == "" ) { this.className = "search_init"; this.value = asInitVals[$("tfoot input").index(this)]; } } );
	//fin filtros individuales por campo de texto
		
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
	
	$('#sConvenio').load('genera/convenios.php',function(response,status,xhr){if( status == "success" ) {} });
			
});

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
	var divRangoFecha = $('#divRangoFechas');
	divRangoFecha.css('width','80%').css('float','left').css('border-width','1px').css('border-style','none').css('color','white');
	
	$('#rangosFechas').buttonset().css('font-size','0.9em');
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
<input name="titleEst" id="titleEst" value="" type="hidden">

<div id="header" class="header">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoEstudiosLab.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">REPORTE LABORATORIO</span></td>
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
        <th>REFERENCIA</th>
        <th>ESTUDIO</th>
     	<th>ESTATUS</th>
        <th>SUCURSAL</th>
        <th>ÁREA</th>
        <th nowrap>TOTAL($)</th>
      </tr>
    </thead>
    <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot> <tr>
        <td></td>
        <td>
        <input name="sPacientea" id="sPacientea" type="hidden" class="search_init" />
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
        <input name="sPaciente4" id="sPaciente4" type="text" placeholder="Sucursal" class="search_init" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente6" id="sPaciente6" type="text" placeholder="Área" class="search_init" style="width:90%;" />
        </td>
        <td></td>
    </tr> </tfoot>
  </table>
  
  <div id="divRangoFechas"><table width="100%" style="color:black;" border="0" cellpadding="3" cellspacing="0">
  <tr align="left">
    <td nowrap width="1%">De </td> 
    <td nowrap><input name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td nowra width="1%"p>A </td> 
    <td nowrap><input name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td id="rangosFechas" nowrap width="160px">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td align="left" width="80%"><select name="sConvenio" id="sConvenio" style="max-width:400px;"></select></td>
  </tr>
</table>
</div>
  
</div>

<div style="display:none;" id="dialog-upload" title="INTERPRETACIÓN">
	<span id="spanDialog"></span>
  	<iframe id="miFrame" allowtransparency="yes" frameborder="0" src="../editorTexto/Untitled-3.php" style="width:850px; height:440px;"></iframe>
</div>

<div id="dialog-alerta" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td id="miAlerta">&nbsp;</td> </tr> </table> </div>
<div id="dialog-subiendo" style="display:none;"> <div id="progressbar"></div> </div>
<div id="dialog-visualizador" style="display:none;"> </div>
<div id="dialog-pregunta" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td id="miPregunta">&nbsp;</td> </tr> </table> </div>
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
