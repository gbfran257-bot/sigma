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
<title>RESULTADOS IMAGEN</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../css/resultados.css" rel="stylesheet" type="text/css">
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
		if($('#accesoU').val()==10){}else{ //Si no es radiologo externo
			$('#miMenu').show('fold','slow');
			$('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">DIAGNÓSTICO</span>');
		}
    });
}
function ocultarMenu(){
	$(document).ready(function(e) {
        $('#miMenu').hide('fold','slow');
		$('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">DIAGNÓSTICO</span>');
    });
}
</script>
</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>

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

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../imagenes/iconitos/_iconoEstudios.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">DIAGNÓSTICO</span></td>
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
    <td class="eii"><img title="MENÚ ANTERIOR" src="../imagenes/submenu/_imagen.png" width="100" onClick="window.location='../menu_imagen.php'"></td>
    <td class="eid"><img title="INICIO" src="../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../menu.php'"></td>
  </tr>
</table>
</div>

<div id="contenedor" class="contenedor">
  
  <div class="contenido" id="contenido" align="center">
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
	
	var tam = $('#referencia').height() - 155;
	
	oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {  myFunction(); },
		"bJQueryUI": false, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
		"bStateSave": false, "bInfo": false, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, 
			{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }
		],
		"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true, "sDom": '<"data_t"t><"info"i>', 
		"sAjaxSource": "datatable-serverside/estudios.php",
		"fnServerParams": function (aoData, fnCallback) {
			   var de = document.getElementById('fechaDe').value+' 00:00:00'; var a = $('#fechaA').val()+' 23:59:59';
			   var acceso = $('#accesoU').val(); var idU = $('#idUser').val();
               aoData.push(  {"name": "min", "value": de } ); aoData.push(  {"name": "max", "value": a } );
			   aoData.push(  {"name": "acceso", "value": acceso } ); aoData.push(  {"name": "idU", "value": idU } );
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
     
    $("tfoot input.pat").focus( function () { if ( this.className == "pat" ) { this.className = ""; this.value = "";myFunction(); } } );
     
    $("tfoot input.pat").blur( function (i) { if ( this.value == "" ) { this.className = "pat"; this.value = asInitVals[$("tfoot input.pat").index(this)];myFunction(); } } );
	//fin filtros individuales por campo de texto
	
	//para los filtros individuales por select
	/* Add a select menu for each TH element in the table footer */
    $("tfoot td .miSelect").each( function ( i ) {
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
        $('select', this).change( function () { oTable.fnFilter( $(this).val(), i ); } );
    } );
	$('#s_urg').change( function () { oTable.fnFilter( $(this).val(), 3 ); myFunction(); } );
	$('#s_estatus').change( function () { oTable.fnFilter( $(this).val(), 5 ); myFunction(); } );
	//fin para filtros individuales por select
	
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
	
	$('#input').jqte();
});
</script>

  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="1" id="dataTable" class="tablilla">
    <thead id="cabecera_tBusquedaP">
      <tr id="" bgcolor="#FF6633">
        <th id="clickme" style="color:white;">PACIENTE</th>
        <th style="color:white;">REFERENCIA</th>
        <th style="color:white;">ESTUDIO</th>
     	<th style="color:white;">ESTATUS</th>
        <th style="color:white;">ASIGNAR</th>
		<th style="color:white;">EDITAR</th>
        <th style="color:white;">ID-PACS</th>
        <th style="color:white;">ÁREA</th>
      </tr>
    </thead>
    <tbody>
		<tr>
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
    <tfoot>
    	<tr bgcolor="#FF6633">
        <td>
        <input name="sPaciente" id="sPaciente" type="text" placeholder="Paciente" class="search_init pat" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente1" id="sPaciente1" type="text" placeholder="Referencia" class="search_init pat" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente2" id="sPaciente2" type="text" placeholder="Estudio" class="search_init pat" style="width:90%;" />
        </td>
        <td>
        <input name="sPaciente3" id="sPaciente3" type="text" placeholder="Estatus" class="search_init pat" style="width:90%;" />
        </td>
        <td><input name="sPaciente4" id="sPaciente4" type="hidden" class="search_init pat" style="width:90%;" /></td>
        <td><input name="sPaciente5" id="sPaciente5" type="hidden" class="search_init pat" style="width:90%;" /></td>
        <td>
        </td>
        <td>
        <input name="sPaciente9e" id="sPaciente9e" type="hidden" class="search_init pat" style="width:90%;" />
        <input name="sPaciente10" id="sPaciente10" type="text" placeholder="Área" class="search_init pat" style="width:90%;" />
        </td>
        </tr>
    </tfoot>
  </table>
  
  <div id="divRangoFechas"><table height="1px" width="100%" border="0" cellpadding="3" cellspacing="0" style="color:black;">
  <tr>
    <td>De</td> 
    <td><input name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td>A</td> 
    <td><input name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td id="rangosFechas" nowrap>
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td width="99%"></td>
  </tr>
</table>
</div>
  
  </div>
  
</div>

</div>

<div class="footer" id="footer" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle"> &copy; GLOSS <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </td> </tr> </table> </div>

<div id="dialog-captura" style="display:none; background-color:#EEE; text-align:left; color:black; font-size:0.8em;">
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
  
  <tr>
  	<td colspan="" height="1%" nowrap><strong style="text-decoration:underline;"><em>Nota del radiólogo</em></strong></td>
  	<td colspan="2"> <span class="myNotaTR"></span></td>
    <td colspan="" height="1%" nowrap>Diagnóstico:</td>
  </tr>
    
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

<div id="dialog-alertar" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoAlertar">¡Lo sentimos, usted no puede realizar esta acción!</td> </tr>
</table>
</div>

<div id="dialog-confirmacion" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoConfirma">¡El estudio se ha transferido satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-confirmInterpretacion" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td align="center">¡El estudio se ha interpretado satisfactoriamente!</td> </tr>
  <tr> <td align="center">¿Desea imprimir el resultado del estudio de una vez?</td> </tr>
</table>
</div>

<div id="dialog-confirmaAsignaPacs" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td align="center">¡El estudio se ha asignado al PACS satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-transferir" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#EEE">
  <tr> <td align="justify">Para transferir la interpretación del estudio <span id="estudioTransfer"></span> de la referencia <span id="referenciaTransfer"></span> del paciente <span id="pacienteTransfer"></span>, seleccione el radiólogo externo</td> </tr>
  <tr> <td align="left">
  	Radiólogo <select name="radiologoExte" id="radiologoExte"></select>
  </td> </tr>
  <tr> <td align="center" style="font-size:0.7em; color:red;">
  	<span style="display:none;" id="errorRadiologo">Debe seleccionar un radiólogo de la lista.</span>
  </td> </tr>
</table>
</div>

<div id="dialog-editar" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#EEE">
  <tr> <td align="justify">Esta seguro de querer editar la interpretación del estudio <span class="estudioEdit"></span> de la referencia <span class="referenciaEdit"></span> del paciente <span class="pacienteEdit"></span>?</td> </tr>
  <tr> <td align="left">
  	Confirmar <input name="editarInterpretacionC" type="checkbox" value="" id="editarInterpretacionC">
  </td> </tr>
  <tr> <td align="center" style="font-size:0.7em; color:red;">
  	<span style="display:none;" id="errorEditar">Debe confirmar la instrucción.</span>
  </td> </tr>
</table>
</div>

<div id="dialog-impresion" style="display:none;">
<table id="tablaImpresion" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:0.8em;">
  <tr>
    <td height="3%" id="miEncabezado"><br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
        	<table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="25%" align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="1%" nowrap align="left">REFERENCIA:</td> 
                    <td class="myReferenciaP" align="left" width="" nowrap></td> 
                  </tr>
                </table>
                </td>
                <td width="25%" align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td nowrap width="1%" align="left">FECHA:</td> 
                    <td class="myFechaP" align="left" width="" nowrap></td> 
                  </tr>
                </table>
                </td>
                <td width="" align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="myEstudioP" align="left" width="" style="font-weight:bold;" nowrap></td> 
                  </tr>
                </table>
                </td>
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>
        	<table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="100%" align="left" nowrap>
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="1%" nowrap align="left">REFERIÓ:</td>
                    <td class="myMedicoP" align="left" width="" nowrap></td> 
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
  <tr>
    <td style="border-top:1px dashed black; padding-top:10px; border-bottom:1px none black; padding-bottom:10px;" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:16px;">
      <tr> <td class="myDiagnosticoP" align="left" valign="top">a</td> </tr>
    </table>
    </td>
  </tr>
  <tr height="1%">
    <td class="myFirmaP">
    <table height="1%" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:">
      <tr> <td width="50%" height="50">&nbsp;</td> <td class="firmaDR" align="center"> </td> </tr>
      <tr> <td width="50%">&nbsp;</td> <td nowrap align="center"><span class="nombreDR"> </span></td> </tr>
      <tr> <td>&nbsp;</td> <td nowrap align="center"><span class="puestoDR"></span>&nbsp;CEDULA ESPECIALIDAD&nbsp;<span class="cedula">1233213</span></td> </tr>
      <tr> <td>&nbsp;</td> <td nowrap align="center">CERTIFICADO POR CONSEJO MEXICANO DE RADIOLOGÍA E IMAGEN</td> </tr>
      <!--<tr><td>&nbsp;</td> <td nowrap align="center" style="padding-bottom:0.8cm;">&nbsp;&nbsp;2011 AL 2015. NO. FOLIO 2711</td> </tr> -->
    </table>
    </td>
  </tr>
</table>
</div>

<div id="dialog-est" style="display:none;">
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
        
  	<!--<a href="osirix://?methodName=DownloadURL&amp;Display=YES&amp;URL='http://192.168.1.59:8080/wado?requestType=WADO&studyUID=1.2.840.113619.2.332.3.163578213.155.1440441100.385&seriesUID=1.2.840.113619.2.332.3.163578213.734.1440441128.82&objectUID=1.2.840.113619.2.332.3.163578213.734.1440441128.822.1&contentType=application%2Fdicom&transferSyntax=1.2.840.10008.1.2.1'"><img src="../imagenes/osirix.png" id="myCli"></a> -->
    
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

<div id="dialog-procesar" style="display:none;"> </div>

<div id="dialog-medico" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> <td>Sólo un <strong>médico</strong> puede realizar esta acción.</td> </tr>
</table>
</div>

<div id="dialog-noest" style="display:none; overflow:hidden;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr height="1px;"> 
  	<td align="left">
  	El estudio <span id="estudioEpacs"></span> del paciente <span id="pacienteEpacs"></span> con referencia <span id="referenciaEpacs"></span> no está asignado a ningún estudio en la base de datos del PACS, para corregir ésto se debe seleccionar y asignar el estudio correspondiente del pacs de la lista
  	</td> 
  </tr>
  <tr> <td align="center">
  	<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" id="dataTablePc" class="tablilla">
        <thead id="cabecera_tBusquedaP">
          <tr id="" bgcolor="#FF6633">
            <th id="clickmePc" style="color:white;">FECHA</th>
            <th style="color:white;">PACIENTE</th>
            <th style="color:white;">ESTUDIO</th>
            <th style="color:white;" nowrap>ID-PACS</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td class="dataTables_empty">Cargando datos del servidor</td>
            </tr>
        </tbody>
        <tfoot>
            <tr bgcolor="#FF6633">
            <td> <input name="sFecha" id="sFecha" type="text" placeholder="Fecha" class="search_init sea" style="width:90%;" /> </td>
            <td>
            <input name="sPaciente" id="sPaciente" type="text" placeholder="Paciente" class="search_init sea" style="width:90%;"/>
            </td>
            <td>
            <input name="sEstudio" id="sEstudio" type="text" placeholder="Estudio" class="search_init sea" style="width:90%;" />
            </td>
            <td><input name="sIdPc" id="sIdPc" type="text" placeholder="ID-PACS" class="search_init sea" style="width:90%;" /></td>
            </tr>
        </tfoot>
      </table>
  </td> </tr>
  <tr height="1px"><td><div id="errorSeleccionConsulta" style="display:none; border:1px none red; top:0px;"><span style="color:#ff0000; text-decoration:underline; font-size:12px;">Debe de seleccionar un estudio, dé clic sobre uno de ellos.</span></div></td></tr>
</table>
</div>

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
function All(){
$(document).ready(function(e) {
	$('#myCli').click();
});
}
$(document).ready(function(e) {
	var tamHX = $('#referencia').height() - 100;
	var tamWX = $('#referencia').width() * 0.98;
	
	$('#dialog-procesar').dialog({ autoOpen: false, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close' });//fin del dialog procesar
	
	$('#dialog-est').dialog({
		autoOpen: false, modal: true, width: 880, height: 350, closeOnEscape: true, title: 'VISUALIZAR ESTUDIO', closeText: '',
		buttons: {
			'Visualizador html': function() {//alert($('#referencia_est').val());
				var url=window.location.href, myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888');
				
				var link_1 = koby[0]+koby[1]; //alert(myL1[0]);
				//window.open('http://192.168.1.59:8080/oviyam2/viewer.html?patientID='+$('#referencia_est').val()); },
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
	
	$('#dialog-impresion').dialog({
		autoOpen: false, modal: true, width: 850, height: tamHX, resizable: false, closeOnEscape: true, closeText:'', 
		title: "IMPRESIÓN HOJA DE RESULTADO",
		buttons: {
			Imprimir: function(){ $('#tablaImpresion').printElement(); },
			Cerrar: function() { $(this).dialog("close"); }
		}
	});//fin del dialog impresion
	
    $('#dialog-captura').dialog({
		autoOpen: false, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: true, closeText:'',
		close: function( event, ui ) { document.getElementById('form-captura').reset(); },
		open: function(event, ui ){ $('#dialog-captura *').css('color','black'); }
	});//fin del dialog rMasto
	
	$('#dialog-confirmInterpretacion').dialog({
		autoOpen:false, modal:true, title:'CONFIRMACIÓN ESTUDIO INTERPRETADO', width: 550, height: 230, resizable: false, closeText:'', closeOnEscape: true,
		buttons:{
			'Imprimir': function(){ imprimir($('#preImprimir').val()); $('#dialog-confirmInterpretacion').dialog('close'); },
			'Cerrar': function(){ $('#dialog-confirmInterpretacion').dialog('close'); }
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
		open: function( event, ui ) {
			window.setTimeout(function(){$('#dialog-alertar').dialog('close');},2000);
		}
	});
		
	$('#dialog-confirmCaptura').dialog({
		autoOpen:false, modal:true, title:'CONFIRMACIÓN CAPTURA', width: 600, height: 200, resizable: false, closeText:'', closeOnEscape: true,
		open: function( event, ui ) { setTimeout(function(){$('#dialog-confirmCaptura').dialog('close');},2000); },
		close: function( event, ui ) { interpretar($('#myIDestudio').val(),$('#myIDestudio').val()) }
	});
	
        $( "#dialog-upload" ).dialog({
            autoOpen: false, show: "blind", modal: true, width: 900, height: 650, hide: "explode", resizable: false, 
			closeOnEscape: false,
			buttons: {
				"Guardar": function() {
					var datox ={estatus:'ENTREGADO', interpretacion:window.frames.miFrame.hola(), id_vc_ini:$('#id_vc_ini').val(), usuario_ini:$('#usuario_ini').val()}
					$.post('archivos_save_ajax/edoPendienteAentregado.php', datox, processData);
					function processData(data) {
						console.log(data);
						if (data == "ok"){	
							$( this ).dialog( "close" );
						}else{alert(data);}
					}
				},
				"Cancelar": function() { $( this ).dialog( "close" ); }
			},
        });
		$('#upload_button1').button({ icons: { primary: "ui-icon-folder-open" } });
    });//fin ready

function procesar(a,b){//a es el id del paciente y b es el id del estudio en venta de conceptos
	$(document).ready(function(e) {
        //if($('#accesoU').val()>3){}else{
			$("#dialog-procesar").load('htmls/procesar.php', function( response, status, xhr ) {
				if ( status == "success" ) { 
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
							autoOpen: true, modal: true, width: tamWX, height: tamHX, resizable: false, closeOnEscape: false, closeText:'', title: "PROCESAR ESTUDIO(S)", dialogClass: 'no-close',
							close: function( event, ui ) { $('#dialog-procesar').dialog('destroy');},
							buttons: {
								Procesar: function(){
									if($('#checaPro').val()==0){$('#notificacionPro').hide().show('pulsate');}
									else{
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
		//}
    });
}
function realizar(a,b){//a es el id del paciente y b es el id del estudio en venta de conceptos
$(document).ready(function(e) {
	$("#dialog-procesar").load('htmls/procesar.php', function( response, status, xhr ) {
		if ( status == "success" ) { 
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
	});
});
}
function capturar(a,b,radExt){ //alert(radExt);
	//a es el id del paciente, b es el id del estudio en venta de conceptos
	$(document).ready(function(e) {
		$('#myIDestudio').val(b);
		var dato = { idVC:b, idP:a }
		$.post('files-serverside/datosCaptura.php', dato, processData);
		function processData(data) {
		  	console.log(data);
			var datos = data.split('*}');
			$('.myPaciente').html(datos[0]);
			$('.myReferencia').html(datos[1]);
			$('.myEdad').html(datos[2]);
			$('.mySexo').html(datos[3]);
			$('.myFecha').html(datos[4]);
			$('#titleEst').val(datos[5]);
			$('.myNotaTR').html(datos[7]).css('color','red');
			$('#dialog-captura').dialog({title: 'DIAGNÓSTICO ESTUDIO '+$('#titleEst').val()});
			$('#input').jqte();
			$('#input').jqteVal(datos[6]);
			window.setTimeout(function(){
				$('#input').jqte();
				$('#input').jqteVal(datos[6]);
			},600);
		}
		$('#dialog-captura').dialog({ //title: $('#titleEst').val(),
		buttons: {
			"Guardar": function() {
				if($('#form-captura').valid()){
					$('#miDiagnostico').val($('.jqte_editor').html());
					var datos = $('#form-captura').serialize();
					$.post('files-serverside/capturar.php',datos,processData);
					function processData(data) {
						console.log(data);
						if (data == 'ok'){
							$('#clickme').click();
							$('#dialog-captura').dialog('close');
							$('#dialog-confirmCaptura').dialog('open');
							document.getElementById('form-captura').reset();
						}else{ alert(data); }
					}
				}
			},
			"Cancelar": function() { document.getElementById('form-captura').reset(); $(this).dialog("close"); }
			}
		});
		$('#tCaptura textarea, #tCaptura input').attr('disabled',false);
		$('#tablaUsuariosEstados').hide();
		window.setTimeout(function(){$('.jqte_editor').css('height',$('#dialog-captura').height()*0.7);},200);
		
		if(radExt==0){
			if($('#accesoU').val()==1 || $('#accesoU').val()==2 || $('#accesoU').val()==10 || $('#accesoU').val()==11){
				$('#dialog-captura').dialog('open');
			}else{$('#dialog-alertar').dialog('open');}
		}else{
			if($('#idUser').val()==radExt){
				$('#dialog-captura').dialog('open');
			}else{
				$('#dialog-alertar').dialog('open');
			}
		}
    });
}
function interpretar(a,b, radExt){//a es el id del estudio alert(a);
	$(document).ready(function(e) { 
		$('#preImprimir').val(b);//asignamos el id del estudio a una variable para llamarlo inmediatamente a imprimir cuando se interpreta
		var dato = { idE:b }
		$.post('files-serverside/datosInterpretar.php', dato, processData);
		function processData(data) {
		  	console.log(data);
			var datos = data.split(';*-');
			document.getElementById('form-captura').reset();
			$('#myIDestudio').val(b);
			$('.myPaciente').html(datos[0]);
			$('.myReferencia').html(datos[1]);
			$('.myEdad').html(datos[2]);
			$('.mySexo').html(datos[3]);
			$('.myFecha').html(datos[4]);
			$('.myNotaTR').html(datos[13]).css('color','red');

			$('#input').jqte();
			$('#input').jqteVal(datos[5]);
			window.setTimeout(function(){
				$('#input').jqte();
				$('#input').jqteVal(datos[5]);
			},600);
		}
		$('#dialog-captura').dialog({
			title: 'INTERPRETAR RESULTADO',
			buttons: {
        		Interpretar: function() {
					if($('#form-captura').valid()){
						$('#miDiagnostico').val($('.jqte_editor').html()); //alert($('#miDiagnostico').val());

							var datosX = $('#form-captura').serialize();
							$.post('files-serverside/interpretar.php',datosX,processDataX);
							function processDataX(data) {
								console.log(data);
								if (data == 'ok'){ //CAMBIAMOS EL ESTATUS A INTERPRETADO
									$('#clickme').click();
									$('#dialog-captura').dialog('close');
									$('#dialog-confirmInterpretacion').dialog('open');
									document.getElementById('form-captura').reset();
								}else{
									alert(data);
								}
							}

					}
				},
				Cancelar: function() {
					$(this).dialog("close");
					document.getElementById('form-captura').reset();
				}
			}
		});
		$('#tCaptura textarea, #tCaptura input').attr('disabled',false);
		$('#tablaUsuariosEstados').hide();
		
		if(radExt==0){
			if($('#accesoU').val()==1 || $('#accesoU').val()==2 || $('#accesoU').val()==10 || $('#accesoU').val()==11){
				$('#dialog-captura').dialog('open');
				window.setTimeout(function(){$('.jqte_editor').css('height',$('#contieneET').height()*0.7);},200);
			}else{$('#dialog-alertar').dialog('open');}
		}else{
			if($('#idUser').val()==radExt){
				$('#dialog-captura').dialog('open');
				window.setTimeout(function(){$('.jqte_editor').css('height',$('#contieneET').height()*0.7);},200);
			}else{
				$('#dialog-alertar').dialog('open');
			}
		}		
		
    });//fin ready
}
function transferir(x, estudio, referencia, paciente){// x=id del estudio en vc
	$(document).ready(function(e) {
		$('#dialog-transferir').dialog({
			autoOpen: true, modal: true, width: 750, height: 270, resizable: false, closeOnEscape: true, closeText:'', 
			title: "TRANSFERIR LA INTERPRETACIÓN",
			buttons: {
				Transferir: function(){ 
					if($('#radiologoExte').val()==''){
						$('#errorRadiologo').show('shake');
						window.setTimeout(function(){$('#errorRadiologo').hide();},1000);
					}else{
						var dato = { idE:x, radiologo:$("#radiologoExte").val(), idU:$('#idUser').val() }
						$.post('files-serverside/transferirInterpretacion.php', dato).done(function( data ) {
							if(data==1){
								$('#dialog-transferir').dialog('close');
								$('#clickme').click();
								//dialog-confirmacion
								$('#dialog-confirmacion').dialog({
									autoOpen: true, modal: true, width: 600, height: 150, resizable: false, closeOnEscape: true, 
									closeText:'', title: "TRANSFERENCIA DE ESTUDIO EXITOSA", dialogClass: '',
									open: function( event, ui ) {
										$('#textoConfirma').text('!El estudio se ha transferido satisfactoriamente!');
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
				$("#radiologoExte").load('genera/genera_radiologos_externos.php', function( response, status, xhr ) { });
				$('#estudioTransfer').text(estudio);$('#referenciaTransfer').text(referencia);$('#pacienteTransfer').text(paciente);
			},
		});//fin del dialog impresion
    });//fin ready
}//fin transferir
function editar(x, estudio, referencia, paciente){// x=id del estudio en vc
	$(document).ready(function(e) {
		$('#dialog-editar').dialog({
			autoOpen: false, modal: true, width: 750, height: 270, resizable: false, closeOnEscape: true, closeText:'', 
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

function imprimir(x){// x=id del estudio
	$(document).ready(function(e) {
		$('#dialog-impresion').dialog('open');
		var dato = { idE:x }
		$.post('files-serverside/datosInterpretar.php', dato).done(function( data ) {
			var datos = data.split(';*-');
			document.getElementById('form-captura').reset();
			$('.myPacienteP').html(datos[0]);
			$('.myReferenciaP').html(datos[1]);
			$('.myEdadP').html(datos[2]);
			$('.mySexoP').html(datos[3]);
			$('.myFechaP').html(datos[4]);
			$('.myDiagnosticoP').html(datos[5]);//alert(data);
			$('.myNotaP').html(datos[6]);
			$('.myUnidadMedicaP').html('TECNOLOGÍA DIAGNOSTICA INTEGRAL');
			$('.myMedicoP').html(datos[7]);
			$('.myEstudioP').html(datos[8]);
			$('.nombreDR').html(datos[9]);
			$('.puestoDR').html('MÉDICO RADIÓLOGO');
			$('.cedula').html(datos[10]);
			$('.myFnacP').html(datos[14]);
			if(datos[11]!='.png'){
				$('.firmaDR').html('<img src="../usuarios/takePicture/firmas/'+datos[11]+'" width="" height="75">');
			}
		});
    });//fin ready
}//fin imprimir
function noest(idVC,nombreE,nombreP,ref,fecha, idPacs){ $(document).ready(function(e) {
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
			//fin para filtro individual por campo de texto

			var tam = $('#referencia').height() - 380;
			
			var oTablePc = $('#dataTablePc').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { },
				"bJQueryUI": false, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam, "bAutoWidth": false, 
				"bStateSave": false, "bInfo": false, "bFilter": true, "bDestroy": true,
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
				if ( this.value == "" ) { this.className = "sea"; this.value = asInitVals1[$("tfoot input.sea").index(this)]; } 
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
		},
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
}); }

function est(a,b){ //a es el id del estudio, b es el id del estudio ambos en venta de conceptos
	$(document).ready(function(e) {
		var url = window.location.href, myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888'); 
		var link_1 = koby[0]+koby[1]; //alert(myL[0]);
		var idE = {idE:a,h:koby[0]}
		$.post('files-serverside/datosInterpretar.php',idE).done(function( data ) {//alert(data);
			var dataE = data.split(';*-');
			if(dataE[0]!=''){
				$('#referencia_est').val(dataE[12]); $('#idEstudioPacs').val(dataE[19]);
				$('#paciente_est').val(dataE[0]);
				$('#folio_est').val(dataE[8]);
				var pu = 'http://192.168.1.59:8080/wado?requestType=PATIENT&studyUID='+dataE[16];
				var linkOsiL = 'osirix://?methodName=DownloadURL&Display=YES&URL='+pu;
				var ka = '<a href='+dataE[17]+' id="myOsirixL"><img src="../imagenes/osirix.png"></a>'
				$('#chosto').html('');
				$('#chosto').append(ka);
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
			if(i+1 == dataE[16]){
				$('.miApend img').each(function(index, element) {
                    $(this).click();
                });
			}
		}
	});
});}
</script>
