<?php require_once('Connections/horizonte.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) { session_start(); }

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){ 
	$logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']); 
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL; $_SESSION['MM_UserGroup'] = NULL; $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']); unset($_SESSION['MM_UserGroup']); unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) { header("Location: $logoutGoTo"); exit; }
}
?>
<?php
if (!isset($_SESSION)) { session_start();}
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

$MM_restrictGoTo = "index.php";
if(!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers,$_SESSION['MM_Username'],$_SESSION['MM_UserGroup'])))) {   
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
    case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
    case "long":
    case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
    case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
    case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
    case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
  }
  return $theValue;
}
}

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) { $colname_usuario = $_SESSION['MM_Username']; }
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreDepartamentoUsuario = sprintf("SELECT nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['idDepartamento_u'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error());
$row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario);
$totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombrePuestoUsuario = sprintf("SELECT nombre_cp FROM catalogo_puestos WHERE id_cp = %s", GetSQLValueString($row_usuario['idPuesto_u'], "int"));
$nombrePuestoUsuario = mysql_query($query_nombrePuestoUsuario, $horizonte) or die(mysql_error());
$row_nombrePuestoUsuario = mysql_fetch_assoc($nombrePuestoUsuario);
$totalRows_nombrePuestoUsuario = mysql_num_rows($nombrePuestoUsuario);

if(!isset($_GET['menu']) or $_GET['menu'] ==''){$_GET['menu']='x';}
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="imagenes/favicon.ico">
<meta charset="utf-8">
<title>MENÚ PRINIPAL</title>

<link href="css/plantilla.css" rel="stylesheet" type="text/css">
<link href="jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet" type="text/css">
<script src="jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="funciones/js/caracteres.js"></script>
</head>

<script language="javascript">
//para las tooltips
$(document).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ){ 
	$(this).css(position);$("<div>").addClass("arrow").addClass(feedback.vertical).addClass(feedback.horizontal).appendTo( this );
} } });
//Fin Tooltips
$(document).ready(function(e) {
	//Refrescamos la sesión para que no caduque
	setInterval(function(){$.post('remote_files/refresh_session.php');},500000);
		
	$( window ).resize(function() { $('#logo').css('max-width',$('#logoI').width()*0.5); });
	
	$('#logo').css('max-width',$('#logoI').width()*0.5);
	
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
	
	$("#carga_menu").load('htmls/menus.php #super_menu',function(response,status,xhr){if(status == "success" ){
		$('.super_menu').hide();
		switch($('#tipo_menu').val()){
			case 'mr':
				$('.m_r').show(); $('#titulo_menu').text('MENÚ RECEPCIÓN');
				$('.iconito').html('<img src="imagenes/iconitos/_recepcion.png">'); permisos();
			break;
			case 'mc':
				$('.m_c').show(); $('#titulo_menu').text('MENÚ CONSULTAS');
				$('.iconito').html('<img src="imagenes/iconitos/_consultas.png">');permisos();
			break;
			case 'mh':
				$('.m_h').show(); $('#titulo_menu').text('MENÚ HOSPITAL');
				$('.iconito').html('<img src="imagenes/iconitos/_hospital.png">');permisos();
			break;
			case 'ms':
				$('.m_s').show(); $('#titulo_menu').text('MENÚ SERVICIOS');
				$('.iconito').html('<img src="imagenes/iconitos/_iconoServicios.png">');permisos();
			break;
			case 'mi':
				$('.m_i').show(); $('#titulo_menu').text('MENÚ IMAGEN');
				$('.iconito').html('<img src="imagenes/iconitos/_iconoEstudios.png">');permisos();
			break;
			case 'ml':
				$('.m_l').show(); $('#titulo_menu').text('MENÚ LABORATORIO');
				$('.iconito').html('<img src="imagenes/iconitos/_iconoEstudiosLab.png">');permisos();
			break;
			case 'mre':
				$('.m_re').show(); $('#titulo_menu').text('MENÚ REHABILITACIÓN');
				$('.iconito').html('<img src="imagenes/iconitos/_icono_rehabilitacion.png">');permisos();
			break;
			case 'mf':
				$('.m_f').show(); $('#titulo_menu').text('MENÚ FARMACIA');
				$('.iconito').html('<img src="imagenes/iconitos/_icono_farmacia.png">');permisos();
			break;
			case 'ma':
				$('.m_a').show(); $('#titulo_menu').text('MENÚ ADMINISTRACIÓN');
				$('.iconito').html('<img src="imagenes/iconitos/_icono_admin.png">');permisos();
			break;
			case 'mca':
				$('.m_ca').show(); $('#titulo_menu').text('MENÚ CAJA');
				$('.iconito').html('<img src="imagenes/iconitos/_corteCaja.png">');permisos();
			break;
			case 'mas':
				$('.m_as').show(); $('#titulo_menu').text('MENÚ DE ASOCIADOS');
				$('.iconito').html('<img src="imagenes/iconitos/_asociados.png">');permisos();
			break;
			case 'masm':
				$('.m_asm').show(); $('#titulo_menu').text('MENÚ ASOCIADOS MÉDICOS');
				$('.iconito').html('<img src="imagenes/iconitos/_iconito_medicos.png">');permisos();
			break;
			case 'masp':
				$('.m_asp').show(); $('#titulo_menu').text('MENÚ ASOCIADOS PROMOTORES');
				$('.iconito').html('<img src="imagenes/iconitos/_asociados.png">');permisos();
			break;
			default:
				$('.m_p').show(); $('#titulo_menu').text('MENÚ PRINCIPAL');
				$('.iconito').html('<img src="imagenes/iconitos/_iconoInicio.png">');permisos();
		}
	} });
	
});
function permisos(){
	if($('#tipo_u').val()!=1){ $('.m_administrador').hide(); }
}
</script>

<body> <input name="tipo_u" id="tipo_u" type="hidden" value="<?php echo $row_usuario['acceso_u']; ?>">

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<div id="header" class="header ver_menu">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"></td>
        <td align="left" valign="middle" nowrap><span id="titulo_menu"></span></td>
        <td width="1%" nowrap valign="middle">
        	<span id="dispara_menu">
            	<?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="21">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="21">
                <?php }?>
            	<?php echo $row_usuario['usuario_u']; ?> <span class="ui-icon ui-icon-triangle-1-s"></span>
            </span>
        </td>
        <td width="100" nowrap align="left"> </td>
      </tr>
    </table>
</div>

<div class="contenido" id="contenido" align="center">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height="100px" style="background-color:#e0e1e3"> <td> </td> </tr>
  <tr height="10%">
  	<td>
    	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="20">
          <tr height="">
            <td height="55%" align="center" valign="middle" id="logoI">
              <img id="logo" src="imagenes/empresa/sigma_logo.png">
            </td>
          </tr>
          <tr> <td valign="top" id="carga_menu"> </td> </tr>
        </table>
    </td>
  </tr>
  <tr height="120px" style="background-color:#e0e1e3;"> <td> </td> </tr>
</table>
</div>

<input name="tipo_menu" id="tipo_menu" type="hidden" value="<?php echo $_GET['menu']; ?>">

</body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($nombreDepartamentoUsuario);
mysql_free_result($nombrePuestoUsuario);
?>
