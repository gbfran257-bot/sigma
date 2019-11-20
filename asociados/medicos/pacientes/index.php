<?php require_once('../../../Connections/horizonte.php'); ?>
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
	
  $logoutGoTo = "../../../index.php";
  if ($logoutGoTo) { header("Location: $logoutGoTo"); exit; }
}
?>
<?php
if (!isset($_SESSION)) { session_start(); }
$MM_authorizedUsers = "1,2,3,4,5,6,7,8";
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

$MM_restrictGoTo = "../../../index.php";
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
$query_nombreDepartamentoUsuario = sprintf("SELECT id_d, nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['idDepartamento_u'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error());
$row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario);
$totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_areas_estudiosL = "SELECT nombre_a, id_a FROM areas WHERE departamento_a = 1 ORDER BY nombre_a asc";
$areas_estudiosL = mysql_query($query_areas_estudiosL, $horizonte) or die(mysql_error());
$row_areas_estudiosL = mysql_fetch_assoc($areas_estudiosL);
$totalRows_areas_estudiosL = mysql_num_rows($areas_estudiosL);

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

mysql_select_db($database_horizonte, $horizonte);
$query_departamentosOV = "
	SELECT u.id_u, u.nombre_u, u.apaterno_u, u.amaterno_u FROM usuarios u ORDER BY u.nombre_u ASC
";
$departamentosOV = mysql_query($query_departamentosOV, $horizonte) or die(mysql_error());
$row_departamentosOV = mysql_fetch_assoc($departamentosOV);
$totalRows_departamentosOV = mysql_num_rows($departamentosOV);
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../../../imagenes/general/favicon.ico">
<meta charset="utf-8">
<title>REPORTE VENTAS</title>

<link href="../../../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../../../css/medico_ventas.css" rel="stylesheet" type="text/css">
<link href="../../../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link href="../../../TableTools-2.1.5/media/css/TableTools.css" rel="stylesheet">

<script src="../../../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../../../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../../../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script src="../../../TableTools-2.1.5/media/js/TableTools.js"></script>
<script src="../../../TableTools-2.1.5/media/js/ZeroClipboard.js"></script>
<script src="../../../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../../../funciones/js/caracteres.js"></script>
<script src="../../../funciones/js/redondea.js"></script>
<script src="../../../funciones/js/jquery.printElement.min.js"></script>
<script type="text/javascript" src="../../../funciones/js/jquery.media.js"></script> 

<script language="javascript"> //para las tooltips
$( document ).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });

$(document).ready(function() { //inicializaciones					
	$('#menu_lat img').css('width','70%').css('height','84%').css('background-color','rgba(255,255,255,0.9)').css('border-radius','6px');
	$('#menu_lat img').hover(function(e) { $(this).css('cursor','pointer'); });									
});
</script>

<script>
$(document).ready(function(e) {
    var miUsuario = $('.miUsuario'),
	misDatosUsuario = $('#misDatosUsuario');
	misDatosUsuario.hide();
	 var dj = 1;
	miUsuario.click( function(e) { dj++; if(dj%2==0){ misDatosUsuario.stop().show('explode','slow'); }else{ misDatosUsuario.stop().hide('explode','slow'); } } );
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
	var cy = $('#header table').height() -8;

	misDatosUsuario.css('right',cx).css('top',cy);
});

</script>
<script>
$(document).ready(function(e) { $('#miMenu').hide(); $('#verMenu').click(function(e) { verMenu(); }); });
function verMenu(){ $(document).ready(function(e) { $('#miMenu').show('fold','slow'); $('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">MIS PACIENTES AFILIADOS</span>'); }); }
function ocultarMenu(){ $(document).ready(function(e) { $('#miMenu').hide('fold','slow'); $('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">MIS PACIENTES AFILIADOS</span>'); }); }
</script>

<script type="text/javascript">
$(document).ready(function() {
	
	var asInitVals = new Array();
	
	var tam = $('#referencia').height() - 185;
	var wT = $('#referencia').width()*0.9;
	
	var oTable = $('#dataTable').dataTable({
		//funciones para calcular los totales en los campos del pie de página
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$( '#rangosFechas' ).buttonset();
			
			$("#miFiltroDeptos").selectmenu({
				change:function(event,ui){$('#clickme').click();} 
			}).selectmenu("menuWidget").addClass("overflow");
			
			$('.opcTable').css('float','left');
			$('span.DataTables_sort_icon').remove();
			$("#saldos").button();
        },
		//fin de funciones para calcular los totales en los campos del pie de página
		"bJQueryUI": false, "sScrollY": tam, "bAutoWidth": false, "bPaginate": true,
		"sPaginationType": "two_button",  "bStateSave": false, "bInfo": false, "bFilter": true, ordering: false,
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,1 ] } ],
		"aaSorting": [[1, "desc"]],
		"iDisplayLength": 5000000, "bLengthChange": false, "bProcessing": false,
		"bServerSide": true,
		"sDom": '<"opcTable"T><"filtro1"><"regis"l>r<"data_t"t><"info"i><"paginacion">',
		"oTableTools": {
			"sSwfPath": "../../../TableTools-2.1.5/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [ 
						{
							"sExtends": "pdf",
							"sButtonText": "PDF",
							"sPdfOrientation": "landscape",
							"sPdfSize": "letter",
							"sPdfMessage": "Reporte de Ingresos."
						},
						{
							"sExtends": "xls",
							"sButtonText": "Excel"
						},
						{
							"sExtends": "copy",
							"sButtonText": "Copiar"
						},
						{
							"sExtends": "print",
							"sButtonText": "Imprimir",
							"sInfo": "</br>VISTA DE IMPRESIÓN </br></br></br> Presione SCAPE al terminar."
						}
						]
		},
		"sAjaxSource": "datatable-serverside/reportes.php",
 		"fnServerParams": function (aoData, fnCallback) {
			   var filtroDepto = $('#miFiltroDeptos').val();
			   aoData.push(  {"name": "depto", "value": filtroDepto /*'2013-02-15 23:59:59'*/ } );
        },
		"aLengthMenu": [[7, 15, 30, 100, -1], [7, 15, 30, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "_MENU_ REGISTROS",
			"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS",
			"sInfo": "MOSTRADOS: _END_",
			"sInfoEmpty": "MOSTRADOS: 0",
			"sInfoFiltered": " REGISTROS: _MAX_",
			"sSearch": "BUSCAR"
		}
		
	}); $('#clickme').click(function(e) { oTable.fnDraw(); });
	
	$('.regis').append('<div id="filtroDepto" style="border:1px none red;width:50%; padding-right:;float:right;" align="right"><select style=" width:98%;" name="miFiltroDeptos" id="miFiltroDeptos"><option value="x">-REFIERE-</option><?php do { ?> <option value="<?php echo $row_departamentosOV['id_u']?>" <?php if($row_departamentosOV['id_u']==$row_usuario['id_u']){echo 'selected';} ?> ><?php echo $row_departamentosOV['nombre_u'].' '.$row_departamentosOV['apaterno_u'].' '.$row_departamentosOV['amaterno_u']?></option><?php } while ($row_departamentosOV = mysql_fetch_assoc($departamentosOV)); $rows = mysql_num_rows($departamentosOV); if($rows > 0) { mysql_data_seek($departamentosOV, 0); $row_departamentosOV = mysql_fetch_assoc($departamentosOV); }?></select></div>');
	
	window.setTimeout(function(){
		oTable.fnDraw();
		if($('#accesoU').val()>=7){
			$("#miFiltroDeptos").selectmenu( "disable" );
		}
	},500);
	
	$('#radio1').click(function(e) { 
		$('#fechaDe').val('<?php echo date("Y-m-d"); ?>'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$('#radio2').click(function(e) { 
		$('#fechaDe').val('2000-01-01'); $('#fechaA').val('<?php echo date("Y-m-d"); ?>'); oTable.fnDraw(); 
	});
	$( "#fechaDe" ).datepicker({ 
		defaultDate: "-1", maxDate: +0, 
		onClose: function( selectedDate ) { 
			$('#fechaA').datepicker("option", "minDate", selectedDate);
		}, 
		"onSelect": function(date) { 
			min = date+' 00:00:00'; 
			oTable.fnDraw();
		} 
	}).css('max-width','100px');
	$( "#fechaA" ).datepicker({ 
		defaultDate: "+0", maxDate: +0, 
		onClose: function( selectedDate ) { 
			$( "#fechaDe" ).datepicker( "option", "maxDate", selectedDate ); 
		}, 
		"onSelect": function(date) { 
			max = date+' 23:59:59'; oTable.fnDraw(); 
		} 
	}).css('max-width','100px');
	
	$('#miFiltroDeptos').change(function(e) { oTable.fnDraw(); });
	
//para filtros con cuadro de textos individuales
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
	 /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in * the footer */
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
	$('.info').css('border','1px none red').css('float','right').css('color','black').css('font-size','12px');
});
		
// EndOAWidget_Instance_2586523
  </script>

<script>
$(document).ready(function(e) {
	var dataT = $('.dataT');
	dataT.css('font-size','0.8em');  
	pie=$('#dataTable .mimimi');
	pie.css('background-color','black');
	$('.search_init input').css('width','98%');
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>
<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../../../imagenes/iconitos/_iconoPacientes.png" height="45"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">MIS PACIENTES AFILIADOS</span></td>
        <td id="celdaUsuario" width="50%" valign="top" align="center">
            <table class="miUsuario" width="1%" height="100%" border="0" cellspacing="0" cellpadding="4" style="border-radius:0px;">
              <tr>
                <td align="center" nowrap valign="middle">
                <?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="25">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="25">
                <?php }?>
                </td>
                <td nowrap valign="middle" class="usuarioPerfil">
                <?php echo $row_usuario['usuario_u']; ?>
                </td>
              </tr>
            </table>
    <div id="misDatosUsuario">
    <table width="100%" border="0" cellspacing="2" cellpadding="">
        <tr>
            <td>
            <?php if($row_usuario['foto_u'] == 1){?>
                <img class="fotoUsuario" id="miFotoUsuarioMini" src="../../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80">
            <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
            <?php }?>
            </td>
            <td align="center"><?php echo $row_usuario['nombre_u']." ".$row_usuario['apaterno_u']." ".$row_usuario['amaterno_u']; ?> <br> <span style="font-size:0.7em">(<?php echo $row_usuario['idPuesto_u']; ?>)</span></td>
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
  	<td class="eii"><img title="MENÚ ANTERIOR" src="../../../imagenes/submenu/_asociados.png" width="100" onClick="window.location='../../../menu_asociados_medicos.php'"></td>
	<td class="eid"><img title="INICIO" src="../../../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../../../menu.php'"></td>
  </tr>
</table>
</div>
  
  <div class="contenido" id="contenido" align="center">
   
<input name="usuario" id="usuario" type="hidden" value="<?php echo $row_usuario['usuario_u']; ?>">
  <table cellspacing="1" cellpadding="4" id="dataTable" class="tablilla" width="100%" height="100%">
    <thead id="">
      <tr style="font-size:1.1em;" bgcolor="#FF6633">
        <th style="color:white;" width="10px" id="clickme">#</th>
        <th style="color:white;">PACIENTE</th>
      </tr>
    </thead>
    <tbody style=" font-size:0.8em;">
		<tr>
			<td class="dataTables_empty">Cargando datos del servidor</td>
		</tr>
	</tbody>
    <tfoot>
		<tr bgcolor="#FF6633" style="color:white;">
			<th><input name="sX" type="hidden" value=""></th>
			<th><input name="sPaciente" id="sPaciente" type="text" placeholder="-Paciente-" class="search_init" width="98%" /></th>
		</tr>
	</tfoot>
  </table>
 
</div>

</div>

<div class="footer" id="footer" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle">
    	&copy; GLOSS <?php echo date('Y'); ?>. Todos los derechos reservados.
    </td>
  </tr>
</table>
</div>

<div id="dialog-procesar" style="display:none;"> </div>

<div id="dialog-est" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5" style="border-radius:4px;">
  <tr> 
  	<td width="" nowrap class="titulosTabla" id="contenidoC" bgcolor="#E6E7E8"> </td> 
  </tr>
</table>
</div>

<div id="dialog-visualizador" style="display:none;"> </div>

</body>
</html>

<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
mysql_free_result($areas_estudiosL);
mysql_free_result($fechaRangoInicial);
mysql_free_result($fechaRangoFinal);
mysql_free_result($departamentosOV);
?>

<script>
jQuery(function($){
    $.datepicker.regional['es'] = {//dateFormat: 'mm/dd/yy',
        closeText: 'Cerrar', changeMonth: true, changeYear: true, numberOfMonths: 3, dateFormat: "yy-mm-dd", prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;', currentText: 'Hoy',
        monthNames:[
			'Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
		], 
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun', 'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'], 
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],  weekHeader: 'Sm', firstDay: 1, isRTL: false, 
		showMonthAfterYear: false, yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});

$(document).ready(function(e) {
var divRangoFechas = $('#divRangoFechas');
	divRangoFechas.css('width','80%').css('float','left').css('border-width','1px').css('border-style','none'); 
	
	$( '#rangosFechas' ).buttonset().css('font-size','0.9em');
	$('.rad').css('font-size','0.8em');
});

function est(a,b,kp){ //a es el id del estudio, b es el id del estudio ambos en venta de conceptos
	$(document).ready(function(e) {
		var url = window.location.href, myL = url.split('http://'), myL1 = myL[1].split('/'), koby = myL1[0].split(':8888'); 
		var link_1 = koby[0]+koby[1]; //alert(myL1[0]);
		var idE = {idE:a,h:koby[0]}
		$.post('files-serverside/datosInterpretar.php',idE).done(function( data ) {//alert(data);
			var dataE = data.split(';*-');
			if(dataE[0]!=''){
				$('#referencia_est').val(dataE[12]);
				$('#paciente_est').val(dataE[0]);
				$('#folio_est').val(dataE[8]);
				$('#contenidoC').html(dataE[19]);
				var pu = 'http://192.168.1.59:8080/wado?requestType=PATIENT&studyUID='+dataE[16];
				var linkOsiL = 'osirix://?methodName=DownloadURL&Display=YES&URL='+pu; //alert(dataE[17]);
				var ka = '<a href='+dataE[17]+' id="myOsirixL"><img src="../imagenes/osirix.png"></a>'
				//var ka = '<a id="myOsirixL"><img onClick="firstC('+a+');" src="../imagenes/osirix.png"></a>' //alert(ka);
				//$('#chosto').html(''); //$('#chosto').append(ka);
				var titleS = 'ESTUDIO '+dataE[8]+'. '+dataE[0]+'. '+dataE[1];
				var he = $('#referencia').height() - 100; var wi = $('#referencia').width() * 0.98;
				
				$('#dialog-est').dialog({
					autoOpen:true,modal:true,width:wi,height: he, closeOnEscape: true, title: titleS, closeText: '',
					buttons: {
						'Imprimir': function(){ $('#tablaImpresion').printElement(); },
						'Visualizador osirix': function() {
							var url=window.location.href,myL=url.split('http://'),myL1=myL[1].split('/'),koby=myL1[0].split(':8888');
							var link_1 = koby[0]+koby[1]; window.open(dataE[17]); 
						},
						'Visualizador html': function() {
							var url=window.location.href,myL=url.split('http://'),myL1=myL[1].split('/'),koby=myL1[0].split(':8888');
							var link_1 = koby[0]+koby[1]; //alert(myL1[0]);
							window.open('http://'+koby[0]+':8080/oviyam2/viewer.html?patientID='+kp); 
						},
						'Visualizador avanzado': function() { 
							var url=window.location.href,myL=url.split('http://'),myL1=myL[1].split('/'),koby=myL1[0].split(':8888');
							var link_1 = koby[0]+koby[1];
							window.open('http://'+koby[0]+':8080/weasis-pacs-connector/viewer?patientID='+kp); 
						},
					}
				});
			}
		});
	});
}
function visualizar(x){ $(document).ready(function(e) { var x1=x; x='../../../laboratorio/takeArchivos/pdf/'+x+'.pdf'; 
	$("#dialog-visualizador").load('../../../laboratorio/htmls/miPDF.php #tablaMiPDF', function( response, status, xhr ) { if ( status == "success" ) {
		var he1 = $('#referencia').height() - 100; var wi1 = $('#referencia').width() * 0.98;
		$('#dialog-visualizador').dialog({
			title: 'ARCHIVO PDF DEL RESULTADO', modal: true, autoOpen: true,
			closeText: '', width: wi1, height: he1, closeOnEscape: true, dialogClass: '',
			buttons: { 
				"CERRAR": function() { $(this).dialog('close'); }
		  }, 
		  open:function( event, ui ){$('a.media').media({width:wi1, height:470, src:x});}, 
		  close:function( event, ui ){ $("#dialog-visualizador").empty();}
		}); 
	} });
}); }
 </script>