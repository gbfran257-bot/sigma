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
$MM_authorizedUsers = "1,2,3,4,5";
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
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
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

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_usuario, apellido_paterno_usuario, apellido_materno_usuario, fotografia_usuario, sucursal_usuario, usuario_usuario, departamento_usuario, puesto FROM usuarios WHERE usuario_usuario = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM sucursales WHERE clave_su = %s", GetSQLValueString($row_usuario['sucursal_usuario'], "text"));
$nombreSucursalUsuario = mysql_query($query_nombreSucursalUsuario, $horizonte) or die(mysql_error());
$row_nombreSucursalUsuario = mysql_fetch_assoc($nombreSucursalUsuario);
$totalRows_nombreSucursalUsuario = mysql_num_rows($nombreSucursalUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreDepartamentoUsuario = sprintf("SELECT nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['departamento_usuario'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error());
$row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario);
$totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MENÚ CAJA. SIGMA GLOSS</title>
<style type="text/css">
#tabla_contenido{
	background-color:rgba(255, 255, 255, 0.3);
	border-radius:6px;
	border: 5px solid rgba(255, 255, 255, 0.0);
}
#tabla_contenido img{cursor:pointer;}
#tabla_contenido img:hover{
	transform:scale(1.1,1.1);
	-ms-transform: scale(1.1,1.1);
	-webkit-transform: scale(1.1,1.1);
	box-shadow:black 0px 0px 0px;
}
#celdaUsuario{
	font-weight:normal;
	font-style:;
	margin-top:2px;
	font-variant:normal;
}
#misDatosUsuario{
	background-image:url(../jquery-ui-1.10.2/css/dark-hive/images/ui-bg_loop_25_000000_21x21.png);
	margin:-1px 9% auto;
	position:fixed;
	display:block;
	border-width:2px;
	border-style:solid;
	border-color:black;
	float:;
	width:220px;
	text-align:left;
	border-bottom-right-radius: 6px;
	border-bottom-left-radius: 6px;
	font-size:0.6em;
}
#miUsuario{
	vertical-align:central;
	cursor:pointer;
	font-size:0.7em;
}
#miUsuario:hover{ 
	background-color:rgba(255,255,255,0.2);
	border 7px;
	border-style:solid;
	border-color:rgba(255,255,255,0);
}
.fotoUsuario{
	border-width:2px;
	border-color:white;
	border-style:ridge;
	border-radius:6px;
}
a:link {
	color: rgb(255,255,255);
}
a:visited {
	color: rgb(255,255,255);
}
a:hover {
	color:rgb(204,204,204);
	font-style:italic;
}
a:active {
	color: rgb(255,255,255);
}
</style>
<link href="../jquery-ui-1.10.2/css/dark-hive/jquery-ui-1.10.2.custom.min.css" rel="stylesheet">
<link href="../css/index.css" rel="stylesheet" type="text/css">
<script src="../jquery-ui-1.10.2/js/jquery-1.9.1.js"></script>
<script src="../jquery-ui-1.10.2/js/jquery-ui-1.10.2.custom.min.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script language="javascript">
//para las tooltips
$( document ).tooltip({
	position: {
		my: "center bottom-20",	at: "center top",
		using: function( position, feedback ) {
			$( this ).css( position );
			$( "<div>" )
			.addClass( "arrow" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
		}
	}
});
//Fin Tooltips
</script>
<script>
$(document).ready(function(e) {
    var miUsuario = $('#miUsuario'),
		misDatosUsuario = $('#misDatosUsuario');
	misDatosUsuario.hide();
	miUsuario.mouseover(function(e) {
		misDatosUsuario.stop().show('explode','slow');
    });
	$('#cabecerita').mouseleave(function(e) {
        //alert('d');
		misDatosUsuario.stop().hide('explode','slow');
    });
});
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
</head>

<body>

<div id="header" class="header">
  
  <div class="cabecerita nop" id="cabecerita">
  
    <table width="100%">
      <tr>
        <td class="cabe" align="right"><img src="../imagenes/pagina_menu_principal/icono_menu.png" height="25"></td>
        <td align="left" valign="middle">MENÚ CAJA</td>
        <td id="celdaUsuario" width="40%" valign="middle">
        <span id="miUsuario"><?php echo $row_usuario['usuario_usuario']; ?>&nbsp;<img id="miFotoUsuarioMini" src="../fotografia_perfil_usuarios/<?php echo $row_usuario['id_u']; ?>.jpg" width="24"></span>
        <div id="misDatosUsuario">
        <table width="100%" border="0" cellspacing="2" cellpadding="">
  		<tr>
    		<td><img class="fotoUsuario" id="miFotoUsuario" src="../fotografia_perfil_usuarios/<?php echo $row_usuario['id_u']; ?>.jpg" width="100"></td>
    		<td align="center"><?php echo $row_usuario['nombre_usuario']." ".$row_usuario['apellido_paterno_usuario']." ".$row_usuario['apellido_materno_usuario']; ?><br>
<span style="font-size:0.7em">(<?php echo $row_usuario['puesto']; ?>)</span></td>
  		</tr>
		</table>
        <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
  		<tr>
    	<td style="font-weight:bold;" align="center"><?php echo $row_nombreSucursalUsuario['nombre_su']; ?></td>
  		</tr>
  		<tr>
    	<td style="font-size:0.8em;" align="center"><?php echo $row_nombreDepartamentoUsuario['nombre_d']; ?></td>
  		</tr>
  		<tr>
    	<td style="font-size:0.8em;" align="center"><span style="text-decoration:underline; cursor:pointer;"><a href="<?php echo $logoutAction ?>">CERRAR SESIÓN</a></span></td>
  		</tr>
		</table>


        </div>
        </td>
      </tr>
    </table>
  </div>

</div>

<div class="contenido" id="contenido" align="center">
    
    <div id="contenedor">

    <table width="90%" height="100%;">
      <tr>
        <td height="30%" align="center">
        <img src="../imagenes/login_x/sigma_logo.png" id="sigma_logo" width="462" height="158">  
        </td>
      </tr>
      <tr>
        <td valign="center">
        
   <div id="contenidoMenu" align="center"> 
  <span id="menuPrincipal">  
    <table border="0" cellpadding="4" id="tabla_contenido">
      <tr>
        <td valign="middle" align="center" style="display:none;"><img src="../imagenes/pagina_menu_principal/reportes.png" alt="pagina_pacientes/index.php" width="80" class="imgMenu" id="reportes" onClick="MM_goToURL('parent','Reportes/reportes.php');return document.MM_returnValue"></td>
        <td valign="middle" align="center"><img src="../imagenes/pagina_menu_principal/reportes.png" width="80" class="imgMenu" id="reportes1" onClick="MM_goToURL('parent','Reportes/reportes.php');return document.MM_returnValue"></td>
        <td valign="middle" align="center"><img src="../imagenes/pagina_menu_principal/inicio.png" width="80" class="imgMenu" id="inicio" onClick="MM_goToURL('parent','../menu.php');return document.MM_returnValue"></td>
      </table>
      </span>
  
  </div>
        </td>
      </tr>
    </table>

  </div>
    
 <div class="logos" id="logos">
 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
    	<td align="right"><img src="../imagenes/generales/gloss-logo1.png" name="miLogoGloss" width="174" height="50" id="miLogoGloss"></td>
        <td width="40%"></td>
    	<td align="left"><img src="../imagenes/generales/sigma-logo1.png" name="miLogoSigma" width="146" height="50" id="miLogoSigma"></td>
  	</tr>
	</table>
 </div>
  
 </div>
  
<div class="footer" id="footer">Pié de Página</div>

</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($nombreSucursalUsuario);

mysql_free_result($nombreDepartamentoUsuario);
?>
