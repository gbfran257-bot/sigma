<?php 
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

//initialize the session
if (!isset($_SESSION)) { session_start(); }

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)){ session_start(); }
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
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, usuario_u, acceso_u, sexo_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>REPORTE DE PRODUCTIVIDAD</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../css/pacientes.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../funciones/js/stdlib.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="../funciones/js/jquery.media.js"></script> 
<script src="../funciones/js/jquery.fileDownload.js" type="text/javascript" ></script>

<script language="javascript">
//para las tooltips
$(document).ready(function() {
	
	$('#verMenu').click(function(e){window.location='../menu.php?menu=mr';}); 
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
	
	$('button').click(function(event) { event.preventDefault(); });
	$('#dataTable input').click(function(event) { event.preventDefault(); });
	$('#formD').submit(function(event) { event.preventDefault(); return false; });
	$('#formRI').submit(function(event) { event.preventDefault(); return false; });
});

$(document).ready(function(e) {	
	var xh = $('#referencia').height() - $('#cabecerita').height();
	$('#contenido').css('height',xh);
	
	$( window ).resize(function() {
		var xh = $('#referencia').height() - $('#cabecerita').height();
	  	$('#contenido').css('height',xh);
	});
});
</script>
</head>

<body onLoad="generales()">

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<div id="header" class="header">
<table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoResultados.png" height="40"></td>
        <td align="left" valign="middle"><span style="cursor:pointer;" id="verMenu">REPORTE DE PRODUCTIVIDAD</span></td>
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
//función para la info de detalle de cada registro
function fnFormatDetails ( oTable, nTr, x){//, y, z )
    var aData = oTable.fnGetData( nTr );
	var sOut = x;
    return sOut;
}
//función para la info de detalle de cada registro

//para filtros con cuadro de textos individuales
var asInitVals = new Array();
//fin fintros con cuadro de texto indivicuales

$(document).ready(function() {
	/* * Insert a 'details' column to the table */
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    nCloneTd.innerHTML = '<img src="../imagenes/generales/details_open.png">';
    nCloneTd.className = "center";
     
    $('#dataTable thead tr').each( function () { } );
     
    $('#dataTable tbody tr').each( function () { } );
	
	var ff='50%';
	var tam1 = $('#granContenido').height()  - 100;
	var tam = parseInt($(document).height()) - parseInt(500) - parseInt($('#tablaEncabezado').height());
	var oTable = $('#dataTable').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
			window.setTimeout(function(){$('#clickme').removeClass('sorting_asc');},100);
			$('#clickme div span').remove();
		},
		"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam1, "bAutoWidth": false,
		"bStateSave": false, "bInfo": true, "bFilter": true, "aaSorting": [[0, "asc"]],
		"aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 0 ] }, { "bSortable": false, "aTargets": [ 1 ] }, { "bSortable": false, "aTargets": [ 2 ] }, { "bSortable": false, "aTargets": [ 3 ] }, { "bSortable": false, "aTargets": [ 4 ] }, { "bSortable": false, "aTargets": [ 5 ] }, { "bSortable": false, "aTargets": [ 6 ] }, { "bSortable": false, "aTargets": [ 7 ] }, { "bSortable": false, "aTargets": [ 8 ] }, { "bSortable": false, "aTargets": [ 9 ] }, { "bSortable": false, "aTargets": [ 10 ] }, { "bSortable": false, "aTargets": [ 11 ] }, { "bSortable": false, "aTargets": [ 12 ] }, { "bSortable": false, "aTargets": [ 13 ] }, { "bSortable": false, "aTargets": [ 14 ] }, { "bSortable": false, "aTargets": [ 15 ] }, { "bSortable": false, "aTargets": [ 16 ] }, { "bSortable": false, "aTargets": [ 17 ] }
        ],
		"iDisplayLength": 10000, "bProcessing": false, "bServerSide": true, "sDom": '<"filtro1">r<"data_t"t>s',
		"sAjaxSource": "datatable-serverside/reporte.php",
 		"fnServerParams": function (aoData, fnCallback) { },
		"aLengthMenu": [[7, 15, 30, 100, -1], [7, 15, 30, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "_MENU_ REGISTROS",
			"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "MOSTRADOS: _END_",
			"sInfoEmpty": "MOSTRADOS: 0",
			"sInfoFiltered": "<br/>REGISTROS: _MAX_",
			"sSearch": "BUSCAR"
		}
	});
	
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
		onClose: function( selectedDate ) {
			$( "#fechaA" ).datepicker( "option", "minDate", selectedDate );
		},
		"onSelect": function(date) {
      		min = date+' 00:00:00';//new Date(date).getTime();
      		oTable.fnDraw();
    	}
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({
		defaultDate: "+0",
		maxDate: +0,
		onClose: function( selectedDate ) {
			$( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate );
		},
		"onSelect": function(date) {
      		max = date+' 23:59:59';//new Date(date).getTime();
      		oTable.fnDraw();
    	}
	}).css('max-width','100px');
	
	$('#miFiltroDeptos').change(function(e) {  oTable.fnDraw(); });
	
	$('#clickme').click(function(e) {
		oTable.fnDraw();
    });
	
//para filtros con cuadro de textos individuales
	$("tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
	 /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
     * the footer
     */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; });
     
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
     
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );
	
	var busqueda = $('.filtro1');
	var data_t = $('#dataTable tbody');
	var info_t = $('.info *');
	var resete = $('#resete');
	var noRegistros = $('.regis *');
	
	noRegistros.css('float','right');
	
	var dataT = $('.dataT');
	dataT.css('font-size','0.7em');  
	pie=$('#dataTable .mimimi');
	pie.css('background-color','black');  
	
});
	
</script>
<script>
function generales(fi,ff,b){
	$(document).ready(function(e) {
		var aba=0;
		$.post('files-serverside/datosReporte.php', aba, processDatasR);
				function processDatasR(data) {
					//alert(data);
					console.log(data);					
						var d=data.split(";");
						$('#fechaInicioP').text(d[0]);
						$('#diasTranscurridos').text(d[1]);
						$('#noPacientes').text(redondear(d[2],2));
						$('#noVentas').text(d[3]);
						$('#noIngreso').text(d[4]);
						$('#noConsultas').text(d[5]);
						$('#noLaboratorios').text(d[6]);
						$('#noImagenes').text(d[7]);
						$('#noServicios').text(d[8]);
						$('#promedioPPD').text(redondear(d[9],2));
						$('#promedioOVPD').text(redondear(d[10],2));
						$('#promedioINPD').text(redondear(d[11],2));
						$('#promedioCPD').text(redondear(d[12],2));
						$('#promedioLPD').text(redondear(d[13],2));
						$('#promedioIPD').text(redondear(d[14],2));
						$('#promedioSPD').text(redondear(d[15],2));
				}
	});
}
</script>

<div class="contenido" id="contenido" align="center" style="margin:42px auto; font-size:11px;"> 

<input name="usuario" id="usuario" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
<input name="idUsuario" id="idUsuario" type="hidden" value="<?php echo $row_usuario['id_u']; ?>">

<div id="granContenido" style="height:100%">
<div id="tablaEncabezado"><table id="" width="100%" border="0" cellspacing="5" cellpadding="2">
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
 	 	<tr>
    	<td>INICIO:&nbsp;<span id="fechaInicioP"></span></td>
    	<td>DÍAS TRANSCURRIDOS:&nbsp;<span id="diasTranscurridos"></span></td>
    	<td>#PACIENTES:&nbsp;<span id="noPacientes"></span></td>
        <td>#VENTAS:&nbsp;<span id="noVentas"></span></td>
        <td>$INGRESO:&nbsp;<span id="noIngreso"></span></td>
    	<td>#CONSULTAS:&nbsp;<span id="noConsultas"></span></td>
    	<td>#LABORATORIOS:&nbsp;<span id="noLaboratorios"></span></td>
        <td>#IMÁGEN:&nbsp;<span id="noImagenes"></span></td>
        <td>#SERVICIOS:&nbsp;<span id="noServicios"></span></td>
  		</tr>
		</table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="3">
 	 	<tr>
    	<td>PACIENTESxDIA:&nbsp;<span id="promedioPPD"></span></td>
    	<td>VENTASxDÍA:&nbsp;<span id="promedioOVPD"></span></td>
        <td>INGRESOxDÍA:&nbsp;<span id="promedioINPD"></span></td>
    	<td>CONSULTASxDÍA:&nbsp;<span id="promedioCPD"></span></td>
        <td>LABORATORIOSxDÍA:&nbsp;<span id="promedioLPD"></span></td>
        <td>IMAGENxDÍA:&nbsp;<span id="promedioIPD"></span></td>
        <td>SERVICIOSxDÍA:&nbsp;<span id="promedioSPD"></span></td>
  		</tr>
		</table>
    </td>
  </tr>
</table>
</div>

  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="tablilla" id="dataTable">
    <thead id="cabecera_tBusquedaP">
      <tr class="titulos_dataceldas">
        <th id="clickme">USUARIO</th>
        <th>FECHA-I</th>
        <th>FECHA-F</th>
        <th nowrap>DÍAS L</th>
        <th nowrap>PACIENTES</th>
        <th>VENTAS</th>
        <th>INGRESO</th>
        <th nowrap>CNTAS</th>
        <th nowrap>LAB</th>
        <th nowrap>IMG</th>
        <th nowrap>SERVI</th>
        <td nowrap>PCETSxDÍA</td>
    	<td nowrap>VENTASxDÍA</td>
        <td nowrap>INGRESOxDÍA</td>
    	<td nowrap>CNTASxDÍA</td>
        <td nowrap>LABSxDÍA</td>
        <td nowrap>IMGSxDÍA</td>
        <td nowrap>SERVISxDÍA</td>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
  </table>

</div>

  <div id="divRangoFechas" style="display:none"><table width="100%">
  <tr>
    <td>De </td>
    <td><input name="fechaDe" class="fechas" type="text" id="fechaDe" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td>A </td>
    <td><input name="fechaA" type="text" class="fechas" id="fechaA" value="<?php echo date("Y-m-d"); ?>" readonly ></td>
    <td id="rangosFechas">
    	<input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">Hoy</label>
        <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">Todos</label>
    </td>
    <td align="right"></td>
  </tr>
</table>
</div><br>
</div>

<input name="miReferencia" id="miReferencia" type="hidden">

</body>
</html>
<?php
mysql_free_result($usuario);
?>
<script>
$(document).ready(function(e) {
	var divRangoFechas = $('#divRangoFechas');
	divRangoFechas.css('width','80%').css('float','left').css('border-width','1px').css('border-style','none'); 
	
	$( '#rangosFechas' ).buttonset().css('font-size','0.9em');
	$('.rad').css('font-size','0.8em');
	
	$('#granContenido').css('height',$('#referencia').height() - $('#tablaEncabezado').height() + 17);
	$('#dataTable').css('height',$('#referencia').height() - $('#tablaEncabezado').height() - $('#cabecera_tBusquedaP').height() -29 );
});
</script>