<?php require_once('../Connections/horizonte.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

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
if (!isset($_SESSION)) {
  session_start();
}
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
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
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

if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

if($row_usuario['acceso_u']==6){
	//header("Location: diagnostico/laboratorio/listado.php");
}

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

?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../imagenes/favicon.ico">
<meta charset="utf-8">
<title>AGENDA</title>

<link href="../css/pacientes.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../DataTables-1.10.2/media/css/jquery.dataTables.css">

<script src="../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../DataTables-1.10.2/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.2/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/calcula_edad.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../jquery-ui-1.11.4/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../funciones/js/stdlib.js"></script>
<script type="text/javascript" src="../pacientes/imagenes/ajaxupload.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script language="javascript"> //para las tooltips
$(document).tooltip( {position:{my:"center bottom-20",at:"center top",using:function(position,feedback){$(this).css(position);}} });
</script>

<script>
$(document).ready(function(e) {
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
	var cy = $('#header table').height() -8;

	misDatosUsuario.css('right',cx).css('top',cy);
	var miMenu=$('#miMenu');
	miMenu.hide();
	$('#verMenu').click(function(e) { verMenu(); });
	
	var cuadrado = 20;
	$('button').css('min-width',cuadrado).css('min-height',cuadrado);
	
	$('#tablaPrincipal').css('width',$('#referencia').width()-20).css('height',$('#referencia').height()-50);
	
	//esto va despues de la función que carga la ficha del paciente
	$( window ).resize(function(e) {
        var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
		var cy = $('#header table').height();
	
		misDatosUsuario.css('right',cx).css('top',cy);
		
		var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - 160;
		var wi = $('#referencia').width() * 0.96;
    });

	var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - 160;
	var wi = $('#referencia').width() * 0.96;
	
	var cuadrado = 20;
	$('button').css('min-width',cuadrado).css('min-height',cuadrado);
			
});
function verMenu(){
	$(document).ready(function(e) {
        $('#miMenu').show('fold','slow');
		$('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">AGENDA</span>');
    });
}
function ocultarMenu(){
	$(document).ready(function(e) {
        $('#miMenu').hide('fold','slow');
		$('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">AGENDA</span>');
    });
}
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../imagenes/iconitos/_agenda.png" height="50"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">AGENDA</span></td>
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

<div id="miMenu" class="miMenu" align="center">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
  <tr valign="middle" align="center">
    <td class="eii"><img title="MENÚ ANTERIOR" src="../imagenes/submenu/_recepcion.png" width="100" onClick="window.location='../menu_recepcion.php'"></td>
    <td class="eid"><img title="INICIO" src="../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../menu.php'"></td>
  </tr>
</table>
</div>

<div class="contenido" id="contenido" align="center" style="border:1px none aqua;">
<table border="0" cellspacing="0" cellpadding="2" id="tablaPrincipal">
  <tr>
    <td valign="top">
    <iframe src="../wdCalendar/wdCalendar/sample.php" width="100%" height="100%" style="border:0px none red;"></iframe>
    </td>
  </tr>
</table>
</div>

<div class="footer" id="footer" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle"> &copy; HORIZONTE MÉDICA <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS.</td> </tr> </table> </div>

</body>
</html>

<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
?>