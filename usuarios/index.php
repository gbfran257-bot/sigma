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
  if ($logoutGoTo) { header("Location: $logoutGoTo"); exit; }
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
<title>USUARIOS</title>

<link href="../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<link href="../DataTables-1.10.5/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script src="../jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="../jquery-ui-1.12.0/jquery-ui.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.js"></script>
<script src="../jquery-ui-1.12.0/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../funciones/js/caracteres.js"></script>
<script src="../funciones/js/calcula_edad.js"></script>
<script src="../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../funciones/js/redondea.js"></script>
<script src="../funciones/js/jquery.printElement.min.js"></script>
<script src="../funciones/js/stdlib.js"></script>
<script src="../funciones/js/generador_rfc.js"></script>
<script src="../funciones/js/cantidad_a_letra.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../chart_1.0.2/Chart.min.js"></script>
<script src="../funciones/js/jquery.media.js"></script> 
<script src="../funciones/js/jquery.fileDownload.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.iframe-transport.js"></script>
<script src="../jq-file-upload-9.12.5/js/jquery.fileupload.js"></script>

<script language="javascript">
//para las tooltips
$(document).tooltip({position:{my:"center bottom-10",at:"center top",using:function(position,feedback){$(this).css(position);}}});

$(document).ready(function(e) {
	$('#dialog-alertar').dialog({
		autoOpen: false, modal: true, width: 600, height: 150, resizable: false, closeOnEscape: true, 
		closeText:'', title: "ACCESO DENEGADO", dialogClass: '',
		open: function( event, ui ) { window.setTimeout(function(){$('#dialog-alertar').dialog('close');},2000); }
	});
		
	cargaFicha();
	
	//esto va despues de la función que carga la ficha del paciente
	$( window ).resize(function(e) {		
		var he=$('#referencia').height()-$('#header').height()-$('.botones').height() - 160, wi = $('#referencia').width() * 0.96;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
		$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 75).css('width',$('#dialog-confirmarNuevoPaciente').width()-40);
		$('.tabs').css('width',120);
    });
	
});

</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: {
	  step: 60 * 1000,// seconds
	  page: 60 // hours
	},
	_parse: function( value ) {
      if ( typeof value === "string" ) {
        // already a timestamp
        if ( Number( value ) == value ) {
          return Number( value );
        }
        return +Globalize.parseDate( value );
      }
      return value;
    },
	_format: function( value ) {
      return Globalize.format( new Date(value), "t" );
    }
	 	
  });
</script>

<script>
function nuevoUsuario(){ $(document).ready(function(e) {
	var hora_e_lv = '09:00', hora_s_lv = '18:00', hora_e_sd = '09:00', hora_s_sd = '14:00';
	var sli_e_lv = '550', sli_s_lv = '1080', sli_e_sd = '550', sli_s_sd = '850';
	siempre(18.8135, -98.9535, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_lv, hora_s_lv, sli_e_lv, sli_s_lv, hora_e_sd, hora_s_sd, sli_e_sd, sli_s_sd, hora_e_sd, hora_s_sd, sli_e_sd, sli_s_sd);
	
	$('#nombreFotoT').val(''); $('#idPacienteN').val('');
	
	var now = new Date().getTime(), d = new Date();
	$('#nombreFotoT, #temporal_s').val(d.format('Y-m-d-H-i-s-u').substring(0,22)); //alert($('#nombreFotoT').val());
	
	//subeFirma(0);//0 es de que va a subir por primera vez la firma, 1 es que se va a actualizar la firma
	
	var he = $('#referencia').height() - $('#header').height() - 50, wi = $('#referencia').width() * 0.98;
	
    $('#dialog-confirmarNuevoPaciente').dialog({
		title:'NUEVO USUARIO',modal:true,autoOpen:false,closeText:'',width:wi,height:he,closeOnEscape:false, dialogClass:'',
		buttons: {
      },
	  create: function( event, ui ) {},
	  open:function( event, ui ){//alert(8);
	  	$('#nuevo_o_viejo_u').val(0);
			$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab'); 
			$('.pActivo').show();$('.idUsuarioP').val($('#idUsuario').val());
			$('#guardarUser').button(); $('#updateUser').hide();
			$('#guardarUser').click(function(event) {
                event.preventDefault();
				if($('#formGenerales').valid()){ 
					var datosP = $('#formGenerales').serialize();
					$.post('files-serverside/addUsuario.php',datosP).done(function( data ) {//guardamso al nuevo paciente
						if (data==1){//si el paciente se guerdó (los purod datos generales) entonces se activan las demas pestañas y cambia de archivo de guardar a actualizar.
							$('#dialog-confirmaAltaPaciente').dialog('open');
							$('#clickme').click();$('#dialog-confirmarNuevoPaciente').dialog('close');
						}
						else{alert(data);}
					});
				}
            }).show();
			$('#pestanas').removeClass('ui-widget-header');
			var s = $('#accesoU').val();
			$("#tipoUsuario").load('genera/tipos_usuario.php?s='+s,function(response,status,xhr){ if(status == "success"){} });
			var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {
				validateOn:["blur"], isRequired:false, useCharacterMasking:true
			});
			$('#telmovilP').focusout(function(e) { if($(this).val()=='('){$(this).val('');} });
			
			$('#firmaU').val(0);	
			$('#checkbox-fu').click(function(e) {
            	if($(this).prop('checked')==true){ 
					$('#firmaU').val(1); if($('#firma_usuario').html()==''){$('#fileupload_firma').click();}
				}
				else{ $('#firmaU').val(0); }
            });
			
			$('#fotoU').val(0);
			$('#b_subir_foto').click(function(e){ $('#fileupload_foto').click(); });
			
		},
		close:function( event, ui ){ 
			$("#dialog-confirmarNuevoPaciente").tabs("destroy");$('#dialog-confirmarNuevoPaciente').empty();cargaFicha(); 
		}
	});
	$('#dialog-confirmarNuevoPaciente').dialog('open');
}); }//fin función nuevoUsuario
</script>

<script>
$(document).ready(function(e){
	//Refrescamos la sesión para que no caduque, aunque no se refresque la ventana
	setInterval(function(){$.post('../remote_files/refresh_session.php'); },500000);
	
	$('#verMenu').click(function(e){window.location='../menu.php?menu=ma';}); 
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
});
</script>

</head>

<body>
<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>">
<input name="paraFoto" id="paraFoto" type="hidden" value="">

<div id="header" class="header ver_menu">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="120" align="right" class="iconito"><img src="../imagenes/iconitos/_iconoUsuarios.png" height="40"></td>
        <td align="left" valign="middle" nowrap><span id="verMenu" style="cursor:pointer;">USUARIOS</span></td>
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

<div class="contenido" id="contenido" align="center" style="margin-top:23px;">
  <table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" id="dataTablePrincipal" class="tablilla">
    <thead id="cabecera_tBusquedaPrincipal">
      <tr class="titulos_dataceldas">
        <th id="clickme" class="titulosTabs" align="center" width="1px">ID</th>
        <th class="titulosTabs" align="center" width="20px" nowrap>TÍTULO</th>
        <th class="titulosTabs" align="center">NOMBRE</th>
        <th class="titulosTabs" align="center" width="10px" nowrap>USUARIO</th>
        <th class="titulosTabs" align="center" width="10px">SUCURSAL</th>
        <th class="titulosTabs" align="center">ACCESO</th>
     	<th class="titulosTabs" align="center" width="130px" nowrap>DEPARTAMENTO</th>
        <th class="titulosTabs" align="center" width="100px" nowrap>#CELULAR</th>
        <th class="titulosTabs" align="center" width="10px" nowrap>PROMOTOR</th>
        <th class="titulosTabs" align="center" title="Habilitar/Inhabilitar usuario" width="30">HA/IN</th>
        <th class="titulosTabs" align="center" width="10px" nowrap>DOCS</th>
        <th class="titulosTabs" align="center" width="10px" nowrap><span title="PERMISOS">PERM</span></th>
        <th class="titulosTabs" align="center" width="10px" nowrap><span title="UBICACIÓN">UBI</span></th>
      </tr>
    </thead>
    <tbody class="cuerpo_datatable"> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody>
    <tfoot>
        <tr>
            <th><input name="sX" type="hidden" value="" class="search_init"></th>
            <th>
            	<input name="uTitulo" id="uTitulo" type="text" class="search_init campos_b_t" placeholder="-Título-" onKeyUp="conMayusculas(this);" style="" autofocus/>
            </th>
            <th>
            	<input name="uNombre" id="uNombre" type="text" class="search_init campos_b_t" placeholder="-Nombre-" onKeyUp="conMayusculas(this);" autofocus/>
            </th>
            <th><input name="uUser" id="uUser" type="text" class="search_init campos_b_t" placeholder="-Usuario-" onKeyUp="conMayusculas(this);"/></th>
            <th><input style="width:60px" name="uSucursal" id="uSucursal" type="text" class="search_init campos_b_t" placeholder="-Sucursal-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="uAcceso" id="uAcceso" type="text" class="search_init campos_b_t" placeholder="-Acceso-" onKeyUp="conMayusculas(this);"/></th>
            <th>
            <input name="uDepartamento" id="uDepartamento" type="text" class="search_init campos_b_t" placeholder="-Departamento-" onKeyUp="conMayusculas(this);"/>
            </th>
            <th><input name="uCelular" id="uCelular" type="text" class="search_init campos_b_t" placeholder="-Celular-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="uPromotor" id="uPromotor" type="text" class="search_init campos_b_t" placeholder="-Promotor-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sX3" type="hidden" value=""></th>
            <th><input name="sX4" type="hidden" value=""></th>
            <th><input name="sX5" type="hidden" value=""></th>
            <th><input name="sX6" type="hidden" value=""></th>
        </tr>
    </tfoot>
  </table>
</div>

<div id="dialog-confirmarNuevoPaciente" class="dialogos"></div>

<div id="dialog-buscaMedico" title="BUSCAR PROMOTOR" class="dialogos"> </div>

<div id="dialog-confirmaAltaPaciente" class="dialogos"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle" height="100%">LOS DATOS DEL PACIENTE SE HAN GUARDADO SATISFACTORIAMENTE</td> </tr> </table></div>

<form action="paciente.php" method="post" name="formP" target="_self" id="formP">
    <input name="idUsuario" type="hidden" id="idUsuario" value="<?php echo $row_usuario['id_u']; ?>">
    <input name="idPaciente" type="hidden" id="idPaciente" value="">
</form>

<div id="dialog-verPaciente" align="right" class="dialogos"> </div>

<div id="dialog-alertar" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoAlertar">¡Lo sentimos, usted no puede realizar esta acción!</td> </tr>
</table>
</div>

<div id="dialog-editar" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr> <td align="justify" id="usuarioEdit"></td> </tr>
  <tr> <td align="left">
  	<form action="" method="post" name="formEdita" id="formEdita" target="_self">
    	Confirmar <input name="editarUsuarioC" type="checkbox" value="" id="editarUsuarioC">
    </form>
  </td> </tr>
  <tr> <td align="center" style="font-size:0.7em; color:red;">
  	<span style="display:none;" id="errorEditar">Debe confirmar la instrucción.</span>
  </td> </tr>
</table>
</div>

<div id="dialog-confirmacion" class="dialogos">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> <td id="textoConfirma">¡La contraseña se ha reiniciado satisfactoriamente!</td> </tr>
</table>
</div>

<div id="dialog-nivel1" class="dialogos"></div> 
<div id="dialog-nivel2" class="dialogos"></div>
<div id="dialog-nivel3" class="dialogos"></div>

<div id="dialog-confirmarAlgo" class="dialogos"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td align="center" valign="middle"><span id="textoAlgo"></span></td> </tr> </table> </div>

<input name="filtro" id="filtro" type="hidden" value="YO SOLO SE QUE NO SE NADA">
</body>
</html>

<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
?>

<script type="text/javascript">
function myFunction(){
 setTimeout(function(){
	$(document).ready(function(e) {
		var allBotonesIcono = $('.botonaso');
		
		$('.icono_proceso').button({      icons: { primary: "ui-icon-gear"},     text: false });
        $('.icono_realizado').button({    icons: { primary: "ui-icon-comment"},  text: false });
	    $('.icono_capturado').button({    icons: { primary: "ui-icon-check"},    text: false });
	    $('.icono_interpretado').button({ icons: { primary: "ui-icon-search"},   text: false });
		$('.icono_imprimir').button({     icons: { primary: "ui-icon-print"},    text: false });
		$('.icono_entregar').button({     icons: { primary: "ui-icon-person"},   text: false });
		$('.icono_cargado').button({      icons: { primary: "ui-icon-document"}, text: false });
		$('.miPDF').button({              icons: { primary: "ui-icon-document"}, text: false });
		$('.updateB').button({            icons: { primary: "ui-icon-arrowrefresh-1-w"},  text: false });
		
		$('.botonaso').click(function(event) { event.preventDefault(); });
	});
 },9);
}//fin myFunction

$(document).ready(function() {
	var asInitVals = new Array();
	
	var oTableP;
	var tamP = $('#referencia').height() - 160;
	oTableP = $('#dataTablePrincipal').dataTable({
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { myFunction(); },
		"bJQueryUI":true,ordering: false, "bScrollCollapse": true, "sScrollY": tamP, "bAutoWidth": false, "bStateSave": false, 
		"bInfo": true, "bFilter": true, "aaSorting": [[0, "desc"]],
		"aoColumns": [
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
			{"bSortable":false},{"bSortable":false},{"bSortable":false}
		],
		"iDisplayLength": 80, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
		"sDom": '<"toolbar"><"filtro1Principal">lr<"data_tPrincipal"t><"infoPrincipal"i>S',
		"sAjaxSource": "datatable-serverside/usuarios.php",
		"fnServerParams": function (aoData, fnCallback) {
			   var de = $('#filtro').val(); aoData.push(  {"name": "nombre", "value": de /*'2013-02-01 00:00:00'*/ } );
        },
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "ENCONTRADOS: _END_", "sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>USUARIOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},
		scroller: { loadingIndicator: false }
	});
	
	//para los fintros individuales por campo de texto
	$("tfoot input").keyup( function () { /* Filter on the column (the index) of this element */ oTableP.fnFilter( this.value, $("tfoot input").index(this) ); });
    /* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
    $("tfoot input").each( function (i) { asInitVals[i] = this.value; } );
     
    $("tfoot input").focus( function () { if ( this.className == "search_init" ) { this.className = ""; this.value = ""; } } );
     
    $("tfoot input").blur( function (i) { 
		if(this.value=="") { this.className = "search_init campos_b_t"; this.value = asInitVals[$("tfoot input").index(this)]; } 
	} );
	//fin filtros individuales por campo de texto
	
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right; height:10px;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td><button id='addPacientePrincipal' onClick='nuevoUsuario()' class='ui-button ui-widget ui-corner-all' title='Agregar un nuevo usuario'><span class='ui-icon ui-icon-plus'></span> <span class='ui-icon ui-icon-person'></span> </button></td> </tr> </table></div>" );
	$('#addPacientePrincipal').css('height', 30);	
	
	//ponemos los botones de reset y de añadir un paciente de la tabla principal de busqueda de pacientes
	$("div.toolbar").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
	
	if($('.filtro1Principal input').val() ==''){ $('#filtro').val('YO SOLO SE QUE NO SE NADA');
	}else{ $('#filtro').val('%%');oTableP.fnDraw(); }
	
	$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
	$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
		
	window.setTimeout(function(){
		$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
		$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
	},300);
	
	$( window ).resize(function() {
		$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
		$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
	});
			
	$('#clickme').click(function(e) { oTableP.fnDraw(); });

});
</script>

<script>
$(document).ready(function(e) {
	var he1 = $('#referencia').height() - $('#header').height() - 20, wi1 = $('#referencia').width() * 0.97;
	
	$('#dialog-confirmaAltaPaciente').dialog({
		autoOpen: false, modal: true, width: 620, height:150, title: 'DATOS GUARDADOS', closeText: '',
		open:function( event, ui ){
			$('#dialog-confirmarNuevoPaciente').dialog('close');
			window.setTimeout(function(){$('#dialog-confirmaAltaPaciente').dialog('close');},2500);
		}
	});
	
    $('#dialog-verPaciente').dialog({autoOpen:false,modal:true,width:wi1,height:he1,title:'FICHA DEL PACIENTE',closeText:''});
});
</script>

<script>
function verUsuario(x){//x es el id del usuario q seleccionamos
 $(document).ready(function(e) {
	$('#nombreFotoT').val(''); $('#idPacienteN').val(x);
	
	var nowY = new Date().getTime(), dY = new Date(); 
	
	var datos ={idP:x, tempN:dY.format('Y-m-d-H-i-s-u').substring(0,22)}
	$.post('files-serverside/fichaUsuario.php',datos).done(function(data1){ var datosI = data1.split('*}');
		$('#universidadU').val(datosI[70]); $('#id_uni_u').val(datosI[69]);
		//Lunes
		var h_lunes_e = parseFloat(datosI[51].split(':')[1]) + parseFloat(datosI[51].split(':')[0] * 60);
		var h_lunes_s = parseFloat(datosI[52].split(':')[1]) + parseFloat(datosI[52].split(':')[0] * 60);
		if(datosI[51]=='00:00:01'){ 
			var h_e_lu='09:00',h_s_lu='18:00',s_e_lu=550,s_s_lu=1080; $('#checkbox-lu').click();
		}else{ var h_e_lu=datosI[51].substring(0, 5),h_s_lu=datosI[52].substring(0, 5),s_e_lu=h_lunes_e,s_s_lu=h_lunes_s; }
		//Lunes
		//Martes
		var h_martes_e = parseFloat(datosI[53].split(':')[1]) + parseFloat(datosI[53].split(':')[0] * 60);
		var h_martes_s = parseFloat(datosI[54].split(':')[1]) + parseFloat(datosI[54].split(':')[0] * 60);
		if(datosI[53]=='00:00:01'){ 
			var h_e_ma='09:00',h_s_ma='18:00',s_e_ma=550,s_s_ma=1080; $('#checkbox-ma').click(); //Horario Martes 
		}else{ var h_e_ma=datosI[53].substring(0,5),h_s_ma=datosI[54].substring(0,5),s_e_ma=h_martes_e,s_s_ma=h_martes_s; }
		//Martes
		//Miércoles
		var h_miercoles_e = parseFloat(datosI[55].split(':')[1]) + parseFloat(datosI[55].split(':')[0] * 60);
		var h_miercoles_s = parseFloat(datosI[56].split(':')[1]) + parseFloat(datosI[56].split(':')[0] * 60);
		if(datosI[55]=='00:00:01'){ 
			var h_e_mi='09:00',h_s_mi='18:00',s_e_mi=550,s_s_mi=1080; $('#checkbox-mi').click(); //Horario Miércoles
		}else{var h_e_mi=datosI[55].substring(0,5),h_s_mi=datosI[56].substring(0,5),s_e_mi=h_miercoles_e,s_s_mi=h_miercoles_s;}
		//Miércoles
		//Jueves
		var h_jueves_e = parseFloat(datosI[57].split(':')[1]) + parseFloat(datosI[57].split(':')[0] * 60);
		var h_jueves_s = parseFloat(datosI[58].split(':')[1]) + parseFloat(datosI[58].split(':')[0] * 60);
		if(datosI[57]=='00:00:01'){ 
			var h_e_ju='09:00',h_s_ju='18:00',s_e_ju=550,s_s_ju=1080; $('#checkbox-ju').click(); //Horario Jueves
		}else{ var h_e_ju=datosI[57].substring(0,5),h_s_ju=datosI[58].substring(0,5),s_e_ju=h_jueves_e,s_s_ju=h_jueves_s; }
		//Jueves
		//Viernes
		var h_viernes_e = parseFloat(datosI[59].split(':')[1]) + parseFloat(datosI[59].split(':')[0] * 60);
		var h_viernes_s = parseFloat(datosI[60].split(':')[1]) + parseFloat(datosI[60].split(':')[0] * 60);
		if(datosI[59]=='00:00:01'){ 
			var h_e_vi='09:00',h_s_vi='18:00',s_e_vi=550,s_s_vi=1080; $('#checkbox-vi').click(); //Horario Viernes
		}else{ var h_e_vi=datosI[59].substring(0,5),h_s_vi=datosI[60].substring(0,5),s_e_vi=h_viernes_e,s_s_vi=h_viernes_s; }
		//Viernes
		//Sábado
		var h_sabado_e = parseFloat(datosI[61].split(':')[1]) + parseFloat(datosI[61].split(':')[0] * 60);
		var h_sabado_s = parseFloat(datosI[62].split(':')[1]) + parseFloat(datosI[62].split(':')[0] * 60);
		if(datosI[61]=='00:00:01'){ 
			var h_e_sa='09:00',h_s_sa='14:00',s_e_sa=550,s_s_sa=850; $('#checkbox-sa').click(); //Horario Sábado
		}else{ var h_e_sa=datosI[61].substring(0,5),h_s_sa=datosI[62].substring(0,5),s_e_sa=h_sabado_e,s_s_sa=h_sabado_s; }
		//Sábado
		//Domingo
		var h_domingo_e = parseFloat(datosI[63].split(':')[1]) + parseFloat(datosI[63].split(':')[0] * 60);
		var h_domingo_s = parseFloat(datosI[64].split(':')[1]) + parseFloat(datosI[64].split(':')[0] * 60);
		if(datosI[63]=='00:00:01'){ 
			var h_e_do='09:00',h_s_do='14:00',s_e_do=550,s_s_do=850; $('#checkbox-do').click(); //Horario Domingo
		}else{ var h_e_do=datosI[63].substring(0,5),h_s_do=datosI[64].substring(0,5),s_e_do=h_domingo_e,s_s_do=h_domingo_s; }
		//Domingo
		
		$('#nuevo_o_viejo_u').val(1); $('#temporal_s').val(datosI[66]);
		$('#p_latitud_s').val(datosI[49]); $('#p_longitud_s').val(datosI[50]);
		
		siempre(datosI[49],datosI[50],h_e_lu,h_s_lu,s_e_lu,s_s_lu,h_e_ma,h_s_ma,s_e_ma,s_s_ma,h_e_mi,h_s_mi,s_e_mi,s_s_mi,h_e_ju,h_s_ju,s_e_ju,s_s_ju,h_e_vi,h_s_vi,s_e_vi,s_s_vi,h_e_sa,h_s_sa,s_e_sa,s_s_sa,h_e_do,h_s_do,s_e_do,s_s_do);
		//alert(datosI[66]);
		if(datosI[65]==1){ $('#checkbox-fu').click();
			var datos = {aleatorio:datosI[66]}
			$.post('files-serverside/datosFirma.php',datos).done(function( data ){ 
				var t = "<div style='background-image:url(firmas/files/"+data+"."+datosI[67]+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:pointer;' class='conFirma' onClick='reFoto()'></div>";
				$('#firma_usuario').html(t);
			});
		}
		$('#firmaU').val(datosI[65]);	
		$('#checkbox-fu').click(function(e) {
			if($(this).prop('checked')==true){ 
				$('#firmaU').val(1); if($('#firma_usuario').html()==''){$('#fileupload_firma').click();}
			}
			else{ $('#firmaU').val(0); }
		});
		//alert(datosI[42]);
		if(datosI[42]==1){
			var datos = {aleatorio:datosI[66]}
			$.post('files-serverside/datosFoto.php',datos).done(function( data ){ 
				var t = "<div style='background-image:url(fotos/files/"+data+"."+datosI[68]+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:;' class='conFoto' onClick=''></div>";
				$('#foto_usuario').html(t);
			});
		}
		$('#fotoU').val(datosI[42]);	
		$('#b_subir_foto').click(function(e){ reFoto1(); });

		var he=$('#referencia').height() - $('#header').height() - 50, wi=$('#referencia').width() * 0.98;
		var title='USUARIO '+datosI[0]+' '+datosI[1]+' '+datosI[2];
		$('#dialog-confirmarNuevoPaciente').dialog({
			title: title, modal: true, autoOpen: false, closeText: '', width: wi, height: he, closeOnEscape: true,
			dialogClass: '',
			buttons: { }, create: function( event, ui ) {},
		  open:function( event, ui ){
			  $('#updateUser').button();
			  $('#updateUser').click(function(event) { event.preventDefault();
				if($('#formGenerales').valid()){ 
					var datosP = $('#formGenerales').serialize();
					$.post('files-serverside/updateUsuario.php',datosP).done(function( data ) {
						if (data==1){//si el paciente se Actualizó 
							$('#clickme').click();
							$('#dialog-confirmaAltaPaciente').dialog('open');
						}
						else{alert(data);}
					});
				}
			  }).show(); if($('#accesoU').val()!=1){$('#updateUser,#bPromotor').hide();}
			  
			  $('#guardarUser').hide();
			  $('#fichaUsuario ul').removeClass('ui-widget-header');
			  window.setTimeout(function(){//alert(datosI[44]);
					$('#dialog-confirmarNuevoPaciente input, #dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
					$('.idUsuarioP').val($('#idUsuario').val());
					$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
					var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {
						validateOn:["blur"], isRequired:false, useCharacterMasking:true
					});
					var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {
						validateOn:["blur"], isRequired:false, useCharacterMasking:true
					});
					var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {
						validateOn:["blur"], isRequired:false, useCharacterMasking:true
					});
					var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {
						validateOn:["blur"], isRequired:false, useCharacterMasking:true
					});
					//datos generales
					$('.tAlertaU').hide();
					var s = $('#accesoU').val();
					$("#tipoUsuario").load('genera/tipos_usuario.php?s='+s,function(response,status,xhr){ 
						if(status=="success"){$('#tipoUsuario').val(datosI[22]);} 
					});
					$('#nombreP').val(datosI[0]);$('#apaternoP').val(datosI[1]);$('#amaternoP').val(datosI[2]);$("#sexoP").val(datosI[16]);$("#nacionalidadP").val(datosI[26]);$("#fnacP").val(datosI[17]);$('#curpP').val(datosI[6]);
					$('#rfcP').val(datosI[13]);$('#sucursalP').val(datosI[14]);$('#claveUsuario').val(datosI[3]);$('#tipoUsuario').val(datosI[22]);$('#username').val(datosI[21]);$('#notasP').val(datosI[19]);$('#telmovilP').val(datosI[7]);
					$('#idPromotor').val(datosI[46]);$('#promotor').val(datosI[47]);
					//Datos de dirección
					$('#estadoP').val(datosI[34]);var idB = $("#estadoP").find(':selected').text();
					$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(idB),function(response,status,xhr){
						if(status=="success"){ 
						  $('#municipioP').val(datosI[35]);var idM1 = $("#municipioP").find(':selected').text();var id1E = $("#estadoP").find(':selected').text();
							$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(idM1)+'&idE='+escape(id1E), function( response, status, xhr ) {
							  if ( status == "success" ) { 
								$('#coloniaP').val(datosI[36]);var idCx = $("#coloniaP").find(':selected').text();var idEx = $("#estadoP").find(':selected').text();var idMx = $("#municipioP").find(':selected').text();
								$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(idCx)+'&idE='+escape(idEx)+'&idM='+escape(idMx));
							  }
							});
						}
					});
					$('#calleP').val(datosI[31]);$('#noExtP').val(datosI[32]);$('#noIntP').val(datosI[33]);
					//Datos de contacto
					$('#telparticularP').val(datosI[8]);$('#telefonoTrabajoP').val(datosI[9]);$('#extensionTelTraP').val(datosI[10]);$('#avisarP').val(datosI[12]);$('#telefonoEmergenciaP').val(datosI[11]);$('#emailP').val(datosI[15]);
					//Datos adicionales
					$('#departamentoU').val(datosI[23]);var idDe = $("#departamentoU").val();
					$("#areaU").load('files-serverside/genera_areas.php?id='+escape(idDe), function( response, status, xhr ) {
					  if ( status == "success" ) { $('#areaU').val(datosI[24]); }
					});

					$('#puestoU').val(datosI[27]);$('#horarioDe').val(datosI[28]);$('#horarioA').val(datosI[29]);
					$('#escolaridadP').val(datosI[20]);$('#profesionUsuario').val(datosI[25]);
					$('#especialidadU').val(datosI[4]);$('#cedulaU').val(datosI[5]);$('#ocupacionP').val(datosI[41]);
					$('#tsanguineoP').val(datosI[39]);$('#comisionU').val(datosI[30]);$('#precioConsultaU').val(datosI[45]);
					$('#cedulaU1').val(datosI[30]); $('#cTituloU').val(datosI[48]);
					
					$('#claveUsuario').prop('disabled',true);$('#iconoClaveUsuario').addClass('ui-icon ui-icon-check');
					$('#textoClaveUsuarioDisponible').text('Disponible');$('#textoClaveUsuarioDisponible').addClass('textoAceptable');
					$('#username').prop('disabled',true);$('#iconoUsuario').addClass('ui-icon ui-icon-check');
					$('#textoUsuarioDisponible').text('Disponible');$('#textoUsuarioDisponible').addClass('textoAceptable');
				},600);
			},
			close:function( event, ui ){
				$( "#dialog-confirmarNuevoPaciente" ).tabs( "destroy" );$('#dialog-confirmarNuevoPaciente').empty();
				cargaFicha();$('#username').prop('disabled',false);
			}
		});
		$('#dialog-confirmarNuevoPaciente').dialog('open');
	});
 });
}//fin verPaciente

function promotor(idU, nombreU){ $(document).ready(function(e) {//alert(nombreU);
	$("#dialog-buscaMedico").load("htmls/dialogBuscarPromotor.php",function(response,status,xhr){ if(status=="success"){
		var he3 = $('#referencia').height() - 100; var wi3 = $('#referencia').width() * 0.98;
		$('#dialog-buscaMedico').dialog({ 
			title: 'BUSCAR EL PROMOTOR PARA '+nombreU, modal: true, autoOpen: false, closeText: '', width: wi3, 
			height: he3, closeOnEscape: false, dialogClass: 'no-close',
			buttons: {
			"Aceptar": function() {
			   if($('.selected2').length >0){$('#errorSeleccionMédico').hide();
				var datoP = { idUs:idU, idP:$('#idPromotorT').val() }
				$.post('files-serverside/asignarPromotor.php', datoP).done(function( data ) { if(data==1){
					$('#clickme').click();
					$('#dialog-nivel3').dialog({
						autoOpen: true, modal: true, width: 500, height:120, title: 'PROMOTOR ASIGNADO', 
						closeText: '',
						open:function( event, ui ){
							$('#dialog-buscaMedico').dialog('close');
							$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El promotor se asignó satisfactoriamente!</h3></td></tr></table>');
							window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
						},
						close:function( event, ui ){ 
							$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); 
						}, buttons:{ }
					});
				}else{alert(data);} });
			   }else{ $('#errorSeleccionMédico').hide().show('shake'); }
			},
			"Cancelar": function() { $('#dialog-buscaMedico').dialog('close'); }
		  }, create: function( event, ui ) {}, close:function( event, ui ){ $('#dialog-buscaMedico').empty(); },
		  open:function( event, ui ){ var oTableBMC1;
			oTableBMC1 = $('#dataTableBMConsulta').dataTable({
				"bJQueryUI": true, "bRetrieve": true, ordering: false,
				"sScrollY": $('#dialog-buscaMedico').height()-95, "bStateSave": false, "bInfo": true, 
				"bFilter": true, "aaSorting": [[1, "asc"]],
				"aoColumns":[{ "bSortable": false }, { "bSortable": false }, { "bSortable": false }, { "bSortable": false } ], 
				"iDisplayLength": 30, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": '<"toolbarBMC"><"filtroBMC">lr<"data_tBMC"t><"infoBMC"i>S', 
				"sAjaxSource": "datatable-serverside/buscar_promotor.php", 
				"aLengthMenu": [[9, 25, 50, 100, -1], [9, 25, 50, 100, "Todos"]],
				"oLanguage": { "sLengthMenu": "MONSTRANDO _MENU_ records per page", 
				"sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", "sInfo": "MOSTRADOS: _END_", 
				"sInfoEmpty": "MOSTRADOS: 0", "sInfoFiltered": "<br/>PROMOTORES: _MAX_", "sSearch": "" }
			});//fin datatable
			
			$(".pieTablaBMCo input").keyup( function () { /* Filter on the column (the index) of this element */
				oTableBMC1.fnFilter( this.value, $(".pieTablaBMCo input").index(this) );
			});
				
			$('.filtroBMC input').attr("placeholder", "BUSQUE UN USUARIO PROMOTOR AQUÍ, Y DELE CLIC PARA SEECCIONARLO...").addClass('placeHolder');
			$('.infoBMC').hide(); $('.filtroBMC input').focus(); 
			$('.filtroBMC input').css('width',($('#dialog-buscaMedico').width() * 1) ); $('.filtroBMC').css('left',-16);
			$("div.toolbarBMC").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
			
			var tableBM = $('#dataTableBMConsulta').DataTable();
			$('#dataTableBMConsulta tbody').on('click','tr',function(){
				if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
				else{
					tableBM.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
					$('#errorSeleccionMédico').hide();
				}
			});
			
			$('#dataTableBMConsulta tbody').on( 'click', 'tr', function () {
				var nTdsBMC = $('td', this); var idConsulta = $(nTdsBMC[0]).html().split('"'); //alert(idConsulta[1]);
				$('#idPromotorT').val(idConsulta[1]); //alert($('#idPromotorT').val());
			}); //con la clave del médico sacamos su id
		  }
		});
		if($('#accesoU').val()==1){$('#dialog-buscaMedico').dialog('open');}else{$('#dialog-alertar').dialog('open');}
	}});
}); }

function resetP(idU, usr, op){
	if(op == 1){var titulo1 = "INHABILITAR USUARIO";}else{var titulo1 = "HABILITAR USUARIO";}
	$('#dialog-editar').dialog({
		autoOpen: false, modal: true, width: 570, height: 230, resizable: false, closeOnEscape: true, closeText:'', 
		title: titulo1,
		buttons: {
			Aceptar: function(){ 
				if($('#editarUsuarioC').prop('checked')==false){
					$('#errorEditar').show('shake');
					window.setTimeout(function(){$('#errorEditar').hide();},1000);
				}else{
					var dato = { idUs:idU, idU:$('#idUser').val(), user:usr, opc:op }
					$.post('files-serverside/reiniciarContraU.php', dato).done(function( data ) {
						if(data==1){
							$('#dialog-editar').dialog('close'); $('#clickme').click();
							if(op == 1){
								var titulo = "USUARIO INHABILITADO";
								$('#textoConfirma').text('EL usuario se ha inhabilitado satisfactoriamente.');
							}else{
								var titulo = "USUARIO HABILITADO";
								$('#textoConfirma').text('EL usuario se ha habilitado satisfactoriamente.');
							}
							$('#dialog-confirmacion').dialog({
								autoOpen: true, modal: true, width: 600, height: 150, resizable: false, closeOnEscape: true, 
								closeText:'', title: titulo, dialogClass: '',
								open: function( event, ui ) {
									window.setTimeout(function(){$('#dialog-confirmacion').dialog('close');},2000);
								}, buttons: ''
							});
						}else{alert(data);}
					});
				}
			}, Cancelar: function(){ $(this).dialog("close"); document.getElementById('formEdita').reset(); }
		},
		open: function( event, ui ){
			if(op==1){$('#usuarioEdit').text('¿Esta seguro de inhabilitar la cuenta del usuario '+usr+'?');}
			else{$('#usuarioEdit').text('¿Esta seguro de habilitar la cuenta del usuario '+usr+'?'); }
		},
	});//fin del dialog editar
	if($('#accesoU').val()==1){$('#dialog-editar').dialog('open');}else{$('#dialog-alertar').dialog('open');}
}

function cargaFicha(){ $(document).ready(function(e) {
    $("#dialog-confirmarNuevoPaciente").load('htmls/usuario.php',function(response,status,xhr){
		if(status=="success"){
			$('#formGenerales').validate({ ignore: 'hidden', focusCleanup: true,
				rules:{
					claveUsuario:{ required:true, remote:{ url: 'files-serverside/checkClaveUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { clave:function(){ return $('#claveUsuario').val(); } } }, minlength: 4 },
					username:{ required:true, remote:{ url: 'files-serverside/checkUserUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { user:function(){ return $('#username').val(); } } }, minlength: 4 }
				},
				messages:{
					claveUsuario:{ required: 'SE DEBE DE INGRESAR EL IDENTIFICADOR DEL USUARIO.', remote:'ESTE IDENTIFICADOR YA ESTA EN USO, FAVOR DE INTENTAR CON OTRO', minlength:'EL IDENTIFICADOR CONSTA DE 4 CARACTERES' },
					username:{ required: 'SE DEBE DE INGRESAR EL NOMBRE DE USUARIO.', remote:'ESTE NOMBRE DE USUARIO YA ESTA EN USO, FAVOR DE INTENTAR CON OTRO', minlength:'EL NOMBRE DE USUARIO CONSTA DE MÍNIMO 4 CARACTERES' }
				}
			}); $('#formGenerales').submit(function() { return false; });
			var i=0;
			$('#tabs-6-1').click(function(e) {
				$('.eliminar_cto').click(function(event) {event.preventDefault();});

				if(i%2==0){i++;
            	var oTableCo, tam1 = $('#dialog-confirmarNuevoPaciente').height()-120;
				oTableCo = $('#dataTableTos').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
						$('span.DataTables_sort_icon').remove(); $('#dataTableTos_wrapper td').removeClass('sorting_1');
					},
					"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tam1, "bAutoWidth": false, 
					"bInfo": true, "bFilter": false, ordering: false,
					"aoColumns":[
						{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},
						{"bSortable":false}
					],
					"iDisplayLength": 300, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
					"sDom": 't', "sAjaxSource": "datatable-serverside/conceptos_usuario.php",
					"fnServerParams":function(aoData, fnCallback){
						var tempTo = $('#temporal_s').val(); aoData.push(  {"name": "temp", "value": tempTo } );
					},
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "NO CUENTA CON CONCEPTOS",
						"sInfo":"ENCONTRADOS: _END_","sInfoEmpty":"MOSTRADOS: 0","sInfoFiltered":"<br/>CONCEPTOS: _MAX_","sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					}
				});
				$('#clickmeTos').click(function(e) { oTableCo.fnDraw(); });
				}
            });
			
			var he = $('#referencia').height() - $('#header').height() - 160, wi = $('#referencia').width() * 0.96;
			$("#dialog-confirmarNuevoPaciente").tabs({active: 0});
			$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
			
			window.setTimeout(function(){
				$('.miTab').css('height', $('#dialog-confirmarNuevoPaciente').height() - 30).css('width',$('#dialog-confirmarNuevoPaciente').width()-20).css('color','white');
			},100);
			
			//inicializamos el formulario de usuario
			$( "#spinner" ).timespinner();
			var current = $( "#spinner" ).timespinner( "value" );
			Globalize.culture( "de-DE" );
			$( "#spinner" ).timespinner( "value", current );
			$('#fnacP').datepicker({
				changeMonth: true, changeMonth: true, nextText: "Siguiente", prevText: "Anterior", showAnim : "slideDown", changeYear: true, maxDate: +0, minDate: -43800, dateFormat: "dd/mm/yy",
				dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
				monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", "Noviembre", "Diciembre" ],
				monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"] 
			}).css('text-align','center');
					
			$("#sexoP").load('files-serverside/genera_sexos.php');
			$("#sucursalP").load('files-serverside/genera_sucursales.php?idS='+$('#sucursalU').val());
			$("#tsanguineoP").load('files-serverside/genera_tsangre.php');
			$("#especialidadU").load('files-serverside/genera_especialidades.php');
			
			$("#estadoP").load('files-serverside/genera_estados.php',function(response,status,xhr){if(status=="success"){ 
				$("#estadoP").change(function(event){
					var id = $("#estadoP").find(':selected').text();//alert(id);
					$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(id),function(response,status,xhr){
						  if ( status == "success" ) { 
								if ($("#estadoP").val()==''){
									var id1x=$("#estadoP").find(':selected').text(),idx=$("#municipioP").find(':selected').text();
									var id3 = $("#coloniaP").find(':selected').text();
									$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(idx)+'&idE='+escape(id1x));
									$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(id3)+'&idE='+escape(id1x)+'&idM='+escape(idx));
								}
						  }
					});
				});
		 	} });
			
			$("#municipioP").change(function(event){
				var id = $("#municipioP").find(':selected').text();var id1 = $("#estadoP").find(':selected').text();
				$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(id)+'&idE='+escape(id1));
				if ($("#municipioP").val()==''){
					var id1 = $("#estadoP").find(':selected').text();
					var id2 = $("#municipioP").find(':selected').text();
					var id3 = $("#coloniaP").find(':selected').text();
					$("#cpP").load('files-serverside/genera_cp.php?idE='+escape(id1)+'&idM='+escape(id2)+'&idC='+escape(id3));
				}
			});
			$("#coloniaP").change(function(event){
				var idC = $("#coloniaP").find(':selected').text();var idE = $("#estadoP").find(':selected').text();var idM = $("#municipioP").find(':selected').text();
				$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(idC)+'&idE='+escape(idE)+'&idM='+escape(idM));
			});
			
			$('#ocupacionP').keyup(function(e) {
				var y=$(this).val(), b="files-serverside/genera_ocupaciones.php?ocupacion="+y;
				$( "#ocupacionP" ).autocomplete({ source: b, minLength: 2 }); 
			});
			
			$("#departamentoU").load('files-serverside/genera_depto.php', function( response, status, xhr ) {
			  if ( status == "success" ) { 
					$("#departamentoU").change(function(event){
						var id = $("#departamentoU").val();//alert(id);
						$("#areaU").load('files-serverside/genera_areas.php?id='+escape(id), function( response, status, xhr ) {
						  if ( status == "success" ) { 
								if ($("#departamentoU").val()==''){
									var id1x = $("#departamentoU").find(':selected').text();
									$("#areaU").load('files-serverside/genera_areas.php?id='+escape(idx));
								}
						  }
						});	
					});
			  }
			});
			
			$("#escolaridadP").load('files-serverside/genera_escolaridades.php');
			$("#puestoU").load('files-serverside/genera_puestos.php');
			$("#discapacidadP").load('files-serverside/genera_discapacidades.php');
			//fin de las inicializaciones del formulario de usuarios
			
			$('#horarioDe').timepicker({
				currentText:'Ahora',closeText:'Ok',timeOnlyTitle:'Escoge la Hora',timeText:'Hora',hourText:'Horas',
				minuteText:'Minutos'
			});
			$('#horarioDe').css('text-align','center');
			$('#horarioA').timepicker({
				currentText: 'Ahora', closeText: 'Ok', timeOnlyTitle: 'Escoge la Hora', timeText: 'Hora', hourText: 'Horas',
				minuteText: 'Minutos'
			});
			$('#horarioA').css('text-align','center');
							
			$('#profesionUsuario').keyup(function(e) {
				var x=$(this).val(), a="files-serverside/catProfesiones.php?profesion="+x;
			   $('#profesionUsuario').autocomplete({ source: a, minLength: 2 }); 
			});//Fin de las inicializaciones de los campos de la ficha del usuario
			
			var cuadrado = 20;
			$('button').css('min-width',cuadrado).css('min-height',cuadrado);
			
			$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
			
			$('form').submit(function(event) { event.preventDefault(); });
			$('#bPromotor').click(function(event) { event.preventDefault(); });
			
			$('#comisionU').keyup(function(e) {
				if($(this).val()>100){$('#comisionU').val(100);} if($(this).val()<0){$('#comisionU').val(0);}
			});
			
			$('#claveUsuario').keyup(function(e) {
				var x=$(this).val();
				if( x.length>3 & x.length<5 ){
					var claveUsuario1 = $('#claveUsuario').val();
					var datoU ={ claveUsuario1:claveUsuario1}
					$.post('files-serverside/disponibleClaveUsuario.php',datoU).done(function( data ) {
						if (data == 1){
							$('#textoClaveUsuarioDisponible').text('Disponible');$('#textoClaveUsuarioDisponible').addClass('textoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick');
							$('#iconoClaveUsuario').addClass('ui-icon ui-icon-check');
						}else{
							$('#textoClaveUsuarioDisponible').text('No Disponible');$('#textoClaveUsuarioDisponible').addClass('textoNoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoAceptable');
							$('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check');
							$('#iconoClaveUsuario').addClass('ui-icon ui-icon-closethick');
						}
					});
		
				}else{
					$('#textoClaveUsuarioDisponible').text('Muy Corto');$('#textoClaveUsuarioDisponible').addClass('textoAlerta');
					$('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert');$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick');
					$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check');
				}
				if(x.length<=3){ 
					$('#textoClaveUsuarioDisponible').removeClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable');
					$('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert');
				}
				if(x.length==0){ $('#textoClaveUsuarioDisponible').text('Vacío');}
			});
			$('#username').keyup(function(e) {
				var x=$(this).val();
				if( x.length>3 & x.length<9 ){
					var userName = $('#username').val(), datoUN ={userName:userName}
					$.post('files-serverside/disponibleUserName.php',datoUN).done(function( data1 ) {
						if (data1 == 1){
							$('#textoUsuarioDisponible').text('Disponible');$('#textoUsuarioDisponible').addClass('textoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoNoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-closethick');
							$('#iconoUsuario').addClass('ui-icon ui-icon-check');
						}else{
							$('#textoUsuarioDisponible').text('No Disponible');$('#textoUsuarioDisponible').addClass('textoNoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoAceptable');
							$('#textoUsuarioDisponible').removeClass('textoAlerta');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-alert');
							$('#iconoUsuario').removeClass('ui-icon ui-icon-check');
							$('#iconoUsuario').addClass('ui-icon ui-icon-closethick');
						}
					});
				}else{
					$('#textoUsuarioDisponible').text('Muy Corto');$('#textoUsuarioDisponible').addClass('textoAlerta');
					$('#iconoUsuario').addClass('ui-icon ui-icon-alert');$('#iconoUsuario').removeClass('ui-icon ui-icon-closethick');
					$('#iconoUsuario').removeClass('ui-icon ui-icon-check');
				}
				if(x.length<=3){ 
					$('#textoUsuarioDisponible').removeClass('textoAceptable'); $('#textoUsuarioDisponible').removeClass('textoNoAceptable');
					$('#iconoUsuario').addClass('ui-icon ui-icon-alert');
				}
				if(x.length==0){ $('#textoUsuarioDisponible').text('Vacío');}
			});
		}
	});//fin de load
	$('#formGenerales input,#dialog-confirmarNuevoPaciente select, #dialog-confirmarNuevoPaciente textarea').addClass('campoITtab');
	return true;
}); }//fin cargar ficha

function cargaFoto(){$(document).ready(function(e) {
	$('#form-foto').submit(function(event) { event.preventDefault(); }); $('#form-foto').validate();
	'use strict'; //Para el upload // Change this to the location of your server-side upload handler:
	var ko = $('#idUser').val();
	var url = window.location.hostname === 'blueimp.github.io' ?
				'//jquery-file-upload.appspot.com/' : 'fotos/index.php?idU='+ko+'&idP='+$('#temporal_s').val()+'&nombreD='+escape($('#titulo_foto').val());
	$('#fileupload_foto').fileupload({
		url: url, dataType: 'json',
		submit:function (e, data) {
			$.each(data.files, function (index, file) {
				var input=$('#temporal_s'); 
				data.formData={
					titulo_d:input.val(),ext_d:file.name.split('.')[1],e:$('#nuevo_o_viejo_u').val(),noT:$('#temporal_s').val() 
				};
				$('#ext_foto').val(file.name.split('.')[1]);
			});
		},
		progress: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10); 
			$('#progress2 .bar').css('width',progress + '%');
		},
		done: function (e, data) { $('#nuevo_o_viejo_u').val(1);
			$('#dialog-nivel3').dialog({
				autoOpen:true, modal: true, width: 500, height:120, title: 'FOTOGRAFÍA CARGADA', closeText: '',
				open:function( event, ui ){
					$('#fotoU').val(1);
					$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡La fotografía se guardó satisfactoriamente!</h3></td></tr></table>');
					window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
					$('#progress2 .bar').css('width',0);
					//Aquí mostrar la foto
					var datos = {aleatorio:$('#temporal_s').val()}
					$.post('files-serverside/datosFoto.php',datos).done(function( data ){ 
						var t = "<div style='background-image:url(fotos/files/"+data+"."+$("#ext_foto").val()+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:;' class='conFoto' onClick=''></div>";
						$('#foto_usuario').html(t);
					});
				},
				close:function( event, ui ){ 
					$("#dialog-nivel3").empty();$('#dialog-nivel3').dialog('destroy');
				}, buttons:{ }
			});
		},
	}); //Para el upload
});}

function cargaFirma(){$(document).ready(function(e) {//e = 0 primera vez, e=1 actualiza firma
	$('#form-firma').submit(function(event) { event.preventDefault(); }); $('#form-firma').validate();
	'use strict'; //Para el upload // Change this to the location of your server-side upload handler:
	var ko = $('#idUser').val();
	var url = window.location.hostname === 'blueimp.github.io' ?
				'//jquery-file-upload.appspot.com/' : 'firmas/index.php?idU='+ko+'&idP='+$('#temporal_s').val()+'&nombreD='+escape($('#titulo_firma').val());
	$('#fileupload_firma').fileupload({
		url: url, dataType: 'json',
		submit:function (e, data) {
			$.each(data.files, function (index, file) {
				var input=$('#temporal_s'); 
				data.formData={
					titulo_d:input.val(),ext_d:file.name.split('.')[1],e:$('#nuevo_o_viejo_u').val(),noT:$('#temporal_s').val() 
				};
				$('#ext_firma').val(file.name.split('.')[1]);
			});
		},
		progress: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10); 
			$('#progress1 .bar').css('width',progress + '%');
		},
		done: function (e, data) { $('#nuevo_o_viejo_u').val(1);
			$('#dialog-nivel3').dialog({
				autoOpen:true, modal: true, width: 500, height:120, title: 'FIRMA CARGADA', closeText: '',
				open:function( event, ui ){
					$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡La firma se guardó satisfactoriamente!</h3></td></tr></table>');
					window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
					$('#progress1 .bar').css('width',0);
					//Aquí mostrar la foto
					var datos = {aleatorio:$('#temporal_s').val()}
					$.post('files-serverside/datosFirma.php',datos).done(function( data ){ 
						var t = "<div style='background-image:url(firmas/files/"+data+"."+$("#ext_firma").val()+"?"+Math.round(Math.random()*1000)+");background-size:contain;background-repeat:no-repeat;background-position:center;background-color:white; width:100%; height:100%; cursor:pointer;' class='conFirma' onClick='reFoto()'></div>";
						$('#firma_usuario').html(t);
					});
				},
				close:function( event, ui ){ 
					$("#dialog-nivel3").empty();$('#dialog-nivel3').dialog('destroy');
				}, buttons:{ }
			});
		},
	}); //Para el upload
});}

function reFoto(){ $('#fileupload_firma').click(); }
function reFoto1(){ $('#fileupload_foto').click(); }

function siempre(la,lo,h_e_lu,h_s_lu,s_e_lu,s_s_lu,h_e_ma,h_s_ma,s_e_ma,s_s_ma,h_e_mi,h_s_mi,s_e_mi,s_s_mi,h_e_ju,h_s_ju,s_e_ju,s_s_ju,h_e_vi,h_s_vi,s_e_vi,s_s_vi,h_e_sa,h_s_sa,s_e_sa,s_s_sa,h_e_do,h_s_do,s_e_do,s_s_do){ $(document).ready(function(e) {
	cargaFirma(); cargaFoto();
	var i=0; $('#nvo_cto, .eliminar_cto, #b_subir_foto').click(function(event) { event.preventDefault(); });
	$('#tabs-2-1').click(function(e) {
	  if(i%2==0){i++;
	  var map = new google.maps.Map(document.getElementById('map'), {
		center: new google.maps.LatLng(la, lo), zoom: 16, scrollwheel: false //Cuautla :3
	  });
	  marker = new google.maps.Marker({
		map: map, draggable: true, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la, lo)
	  });

	  $('#p_latitud').text(redondear(la,4)); $('#p_latitud_s').val(la);
	  $('#p_longitud').text(redondear(lo,4)); $('#p_longitud_s').val(lo);
	  marker.addListener('dragend', function(){
		  map.panTo(marker.getPosition());
		  var markerLatLng = marker.getPosition();
		  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
		  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
	  });
	  google.maps.event.addListener(marker, 'click', function(){ });
	  
	  var geocoder = new google.maps.Geocoder();
	  $('.mi_dir').keyup(function(e) { 
		  var address = $('#estadoP').find(':selected').text()+' '+$('#municipioP').find(':selected').text()+' '+$('#coloniaP').find(':selected').text()+' '+document.getElementById('calleP').value;

		  geocoder.geocode({'address': address}, function(results, status) { 
			if (status === google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			  var markerLatLng = results[0].geometry.location;
			  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
			  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
			  
			  marker.setPosition(results[0].geometry.location);
			} //else { alert('Geocode was not successful for the following reason: ' + status); }
		  });
	  });
	  $('.mi_dir').change(function(e) { 
		  var address = $('#estadoP').find(':selected').text()+' '+$('#municipioP').find(':selected').text()+' '+$('#coloniaP').find(':selected').text()+' '+document.getElementById('calleP').value;

		  geocoder.geocode({'address': address}, function(results, status) { 
			if (status === google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			  var markerLatLng = results[0].geometry.location;
			  $('#p_latitud').text(redondear(markerLatLng.lat(),4)); $('#p_latitud_s').val(markerLatLng.lat());
			  $('#p_longitud').text(redondear(markerLatLng.lng(),4)); $('#p_longitud_s').val(markerLatLng.lng());
			  
			  marker.setPosition(results[0].geometry.location);
			} //else { alert('Geocode was not successful for the following reason: ' + status); }
		  });
	  });
	  }
	});
	
	window.setTimeout(function(){$('.checki,.checki1').checkboxradio(); $('.checki').click();},200);
	
	$('#slider-lunes').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_lu, s_s_lu ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1='0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#lunes_de').html(hours1+':'+minutes1); jQuery('#lunes_a').html(hours2+':'+minutes2);
		jQuery('#lunes_de1').val(hours1+':'+minutes1+':00'); jQuery('#lunes_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#lunes_de").html(h_e_lu); $("#lunes_a").html(h_s_lu); $("#lunes_de1").val(h_e_lu+':00'); $("#lunes_a1").val(h_s_lu+':00');
	
	$('#checkbox-lu').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-lunes').slider({disabled: false, values: [ s_e_lu, s_s_lu ]});
			$('.texto_lu').html('<span style="float:right;">(DE <span class="lun-vier-i" id="lunes_de"></span> A <span class="lun-vier-f" id="lunes_a"></span>)</span>'); 
			$("#lunes_de").html(h_e_lu);$("#lunes_a").html(h_s_lu);$("#lunes_de1").val(h_e_lu+':00');
			$("#lunes_a1").val(h_s_lu+':00');
		}
		else{
			$('#slider-lunes').slider({disabled: true, values: [h_e_lu,h_s_lu]});$(".texto_lu").html('(No labora)');
			$("#lunes_de1").val('00:00:01'); $("#lunes_a1").val('00:00:01');
		}
	});
	
	$('#slider-martes').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_ma, s_s_ma ],
	  slide: function( event, ui ) { 
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60); 

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1 = '0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#martes_de').html(hours1+':'+minutes1); jQuery('#martes_a').html(hours2+':'+minutes2);
		jQuery('#martes_de1').val(hours1+':'+minutes1+':00'); jQuery('#martes_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#martes_de").html(h_e_ma);$("#martes_a").html(h_s_ma);$("#martes_de1").val(h_e_ma+':00');$("#martes_a1").val(h_s_ma+':00');
	
	$('#checkbox-ma').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-martes').slider({disabled: false, values: [ s_e_ma, s_s_ma ]});
			$('.texto_ma').html('<span style="float:right;">(DE <span class="lun-vier-i" id="martes_de"></span> A <span class="lun-vier-f" id="martes_a"></span>)</span>'); 
			$("#martes_de").html(h_e_ma); $("#martes_a").html(h_s_ma); $("#martes_de1").val(h_e_ma+':00'); 
			$("#martes_a1").val(h_s_ma+':00');
		}
		else{
			$('#slider-martes').slider({disabled: true, values: [s_e_ma,s_s_ma]});$(".texto_ma").html('(No labora)');
			$("#martes_de1").val('00:00:01'); $("#martes_a1").val('00:00:01');
		}
	});
	
	$('#slider-miercoles').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_mi, s_s_mi ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0' + hours; if(minutes1.length<10) minutes1='0'+minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#miercoles_de').html(hours1+':'+minutes1); jQuery('#miercoles_a').html(hours2+':'+minutes2);
		jQuery('#miercoles_de1').val(hours1+':'+minutes1+':00'); jQuery('#miercoles_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#miercoles_de").html(h_e_mi); $("#miercoles_a").html(h_s_mi); $("#miercoles_de1").val(h_e_mi+':00'); 
	$("#miercoles_a1").val(h_s_mi+':00');
	
	$('#checkbox-mi').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-miercoles').slider({disabled: false, values: [ s_e_mi, s_s_mi ]});
			$('.texto_mi').html('<span style="float:right;">(DE <span class="lun-vier-i" id="miercoles_de"></span> A <span class="lun-vier-f" id="miercoles_a"></span>)</span>'); 
			$("#miercoles_de").html(h_e_mi); $("#miercoles_a").html(h_s_mi);
			$("#miercoles_de1").val(h_e_mi+':00'); $("#miercoles_a1").val(h_s_mi+':00');
		}
		else{
			$('#slider-miercoles').slider({disabled:true, values: [s_e_mi,s_s_mi]});$(".texto_mi").html('(No labora)');
			$("#miercoles_de1").val('00:00:01'); $("#miercoles_a1").val('00:00:01');
		}
	});
	
	$('#slider-jueves').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_ju, s_s_ju ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0' + hours; if(minutes1.length<10) minutes1='0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#jueves_de').html(hours1+':'+minutes1); jQuery('#jueves_a').html(hours2+':'+minutes2);
		jQuery('#jueves_de1').val(hours1+':'+minutes1+':00'); jQuery('#jueves_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#jueves_de").html(h_e_ju);$("#jueves_a").html(h_s_ju);$("#jueves_de1").val(h_e_ju+':00');$("#jueves_a1").val(h_s_ju+':00');
	
	$('#checkbox-ju').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-jueves').slider({disabled: false, values: [ s_e_ju, s_s_ju ]});
			$('.texto_ju').html('<span style="float:right;">(DE <span class="lun-vier-i" id="jueves_de"></span> A <span class="lun-vier-f" id="jueves_a"></span>)</span>'); 
			$("#jueves_de").html(h_e_ju); $("#jueves_a").html(h_s_ju);
			$("#jueves_de1").val(h_e_ju+':00'); $("#jueves_a1").val(h_s_ju+':00');
		}
		else{
			$('#slider-jueves').slider({disabled:true, values: [s_e_ju,s_s_ju]});$(".texto_ju").html('(No labora)');
			$("#jueves_de1").val('00:00:01'); $("#jueves_a1").val('00:00:01');
		}
	});
	
	$('#slider-viernes').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_vi, s_s_vi ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1='0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#viernes_de').html(hours1+':'+minutes1); jQuery('#viernes_a').html(hours2+':'+minutes2);
		jQuery('#viernes_de1').val(hours1+':'+minutes1+':00'); jQuery('#viernes_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#viernes_de").html(h_e_vi); $("#viernes_a").html(h_s_vi);$("#viernes_de1").val(h_e_vi+':00'); 
	$("#viernes_a1").val(h_s_vi+':00');
	
	$('#checkbox-vi').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-viernes').slider({disabled: false, values: [ s_e_vi, s_s_vi ]});
			$('.texto_vi').html('<span style="float:right;">(DE <span class="lun-vier-i" id="viernes_de"></span> A <span class="lun-vier-f" id="viernes_a"></span>)</span>'); 
			$("#viernes_de").html(h_e_vi); $("#viernes_a").html(h_s_vi);
			$("#viernes_de1").val(h_e_vi+':00'); $("#viernes_a1").val(h_s_vi+':00');
		}
		else{
			$('#slider-viernes').slider({disabled:true, values: [s_e_vi,s_s_vi]});$(".texto_vi").html('(No labora)');
			$("#viernes_de1").val('00:00:01'); $("#viernes_a1").val('00:00:01');
		}
	});
	
	$('#slider-sabado').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_sa, s_s_sa ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1='0'+minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#sabado_de').html(hours1+':'+minutes1); jQuery('#sabado_a').html(hours2+':'+minutes2);
		jQuery('#sabado_de1').val(hours1+':'+minutes1+':00'); jQuery('#sabado_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#sabado_de").html(h_e_sa);$("#sabado_a").html(h_s_sa);$("#sabado_de1").val(h_e_sa+':00');$("#sabado_a1").val(h_s_sa+':00');
	
	$('#checkbox-sa').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-sabado').slider({disabled: false, values: [ s_e_sa, s_s_sa ]});
			$('.texto_sa').html('<span style="float:right;">(DE <span class="sab-dom-i" id="sabado_de"></span> A <span class="sab-dom-f" id="sabado_a"></span>)</span>'); 
			$("#sabado_de").html(h_e_sa); $("#sabado_a").html(h_s_sa);
			$("#sabado_de1").val(h_e_sa+':00'); $("#sabado_a1").val(h_s_sa+':00');
		}
		else{
			$('#slider-sabado').slider({disabled:true, values: [s_e_sa,s_s_sa]});$(".texto_sa").html('(No labora)');
			$("#sabado_de1").val('00:00:01'); $("#sabado_a1").val('00:00:01');
		}
	});
	
	$('#slider-domingo').slider({
	  range: true, min: 0, max: 1440, step: 30, values: [ s_e_do, s_s_do ],
	  slide: function( event, ui ) {
		var hours1 = Math.floor(ui.values[0] / 60); var minutes1 = ui.values[0] - (hours1 * 60);

		if(hours1.length<10) hours1='0'+hours; if(minutes1.length<10) minutes1 = '0' + minutes; if(minutes1 == 0) minutes1 = '00';

		var hours2 = Math.floor(ui.values[1] / 60); var minutes2 = ui.values[1] - (hours2 * 60);
		if(hours2.length < 10) hours2= '0' + hours; if(minutes2.length < 10) minutes2 = '0' + minutes;

		if(minutes2 == 0) minutes2 = '00';
		jQuery('#domingo_de').html(hours1+':'+minutes1); jQuery('#domingo_a').html(hours2+':'+minutes2);
		jQuery('#domingo_de1').val(hours1+':'+minutes1+':00'); jQuery('#domingo_a1').val(hours2+':'+minutes2+':00');
	  }
	});
	$("#domingo_de").html(h_e_do); $("#domingo_a").html(h_s_do); $("#domingo_de1").val(h_e_do+':00'); 
	$("#domingo_a1").val(h_e_do+':00');
	
	$('#checkbox-do').click(function(e) {
		if($(this).prop('checked')==true){ 
			$('#slider-domingo').slider({disabled: false, values: [ s_e_do, s_s_do ]});
			$('.texto_do').html('<span style="float:right;">(DE <span class="sab-dom-i" id="domingo_de"></span> A <span class="sab-dom-f" id="domingo_a"></span>)</span>'); 
			$("#domingo_de").html(h_e_do); $("#domingo_a").html(h_s_do);
			$("#domingo_de1").val(h_e_do+':00'); $("#domingo_a1").val(h_s_do+':00');
		}
		else{
			$('#slider-domingo').slider({disabled:true, values: [s_e_do,s_s_do]});$(".texto_do").html('(No labora)');
			$("#domingo_de1").val('00:00:01'); $("#domingo_a1").val('00:00:01');
		}
	});
	
}); }

function nuevo_concepto(){ $(document).ready(function(e) {
	$("#dialog-nivel2").load("htmls/usuario.php #concepto",function(response,status,xhr){ if(status=="success"){
		$('#formFconsulta').validate(); $('#areaC').load('../consultas/consultas/genera/areasConsulta.php');
		$('#tempCto').val($('#temporal_s').val()); $('#idUsuarioNC').val($('#idUser').val());
		$('#dialog-nivel2').dialog({
			title:'AGREGAR UN NUEVO CONCEPTO',modal:true,autoOpen:true,closeText:'', width: 800, height: 470, 
			closeOnEscape: true, dialogClass: '',
			buttons: {
			"Guardar": function() {
				if($('#formFconsulta').valid()){
					var datosP = $('#formFconsulta').serialize();
					$.post('files-serverside/addConcepto.php',datosP).done(function( data ) {
						if (data==1){
							$('#clickmeTos').click();
							$('#dialog-nivel3').dialog({
								autoOpen: true, modal: true, width: 500, height:120, title: 'CONCEPTO AGREGADO', 
								closeText: '',
								open:function( event, ui ){
									$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El concepto se guardó satisfactoriamente!</h3></td></tr></table>');
									$('#dialog-nivel2').dialog('close');
									window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
								},
								close:function(event,ui){ 
									$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); 
								}, buttons:{ }
							});
						} else{alert(data);}
					});
				}
			}, "Cancelar": function() { $(this).dialog('close'); }
		  },
		  open:function( event, ui ){
			  $('#dialog-nivel2 input, #dialog-nivel2 select, #dialog-nivel2 textarea').addClass('campoITtab'); 
		  }, close:function( event, ui ){ $('#dialog-nivel2').empty(); }
		});
	} });
}); }

function verConcepto(idCto){ $(document).ready(function(e) {
	$("#dialog-nivel2").load("htmls/usuario.php #concepto",function(response,status,xhr){ if(status=="success"){
		$('#dialog-nivel2').dialog({
			title:'ACTUALIZAR CONCEPTO',modal:true,autoOpen:true,closeText:'', width: 800, height: 470, 
			closeOnEscape: true, dialogClass: '',
			buttons: {
			"Actualizar": function() {
				if($('#formFconsulta').valid()){
					var datosP = $('#formFconsulta').serialize();
					$.post('files-serverside/updateConcepto.php',datosP).done(function( data ) { if (data==1){
						$('#clickmeTos').click();
						$('#dialog-nivel3').dialog({
							autoOpen:true, modal:true,width:500,height:120,title:'CONCEPTO ACTUALIZADO', closeText: '',
							open:function( event, ui ){
								$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El concepto se ha actualizado satisfactoriamente!</h3></td></tr></table>');
								$('#dialog-nivel2').dialog('close');
								window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
							},
							close:function( event, ui ){ $("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); }, 
							buttons:{ }
						});
					} else{alert(data);} });
				}
			}, "Cancelar": function() { $(this).dialog('close'); }
		  },
		  open:function(event,ui){
			  $('#dialog-nivel2 input, #dialog-nivel2 select, #dialog-nivel2 textarea').addClass('campoITtab');
			  var datosTo = {idTo:idCto}
			  $.post('files-serverside/datos_cto.php',datosTo).done(function(data){
			  	var datosC = data.split('{}*');
				$('#nombreC').val(datosC[0]); $('#precioC').val(datosC[2]); $('#precioCurgencia').val(datosC[3]);
				$('#precioMe').val(datosC[4]); $('#precioMe1').val(datosC[5]); $('#idConsulta').val(idCto);
				$('#areaC').load('../consultas/consultas/genera/areasConsulta.php',function(response,status,xhr){ 
					if(status=="success"){$('#areaC').val(datosC[1]);}
				});
			  });
		  }, close:function( event, ui ){ $('#dialog-nivel2').empty(); }
		});
	} });
}); }

function eliminar_concepto(idCto, nombre_to){ $(document).ready(function(e) {
	$("#dialog-nivel2").load("../pacientes/htmls/eliminacion.php", function(response,status,xhr){ if ( status == "success" ) { 
		$('#dialog-nivel2').dialog({ title: 'ELIMINAR CONCEPTO', modal: true, autoOpen: true, closeText: '', width: 700, 
			height: 230, closeOnEscape: true, dialogClass: '',
			buttons:{
				"Aceptar":function(){
					if($('#confirmaEA').prop('checked')==true){
						var datos = {id:idCto}
						$.post('files-serverside/eliminarConcepto.php',datos).done(function( data ) { if (data==1){
							$('#dialog-nivel2').dialog('close');
							$('#dialog-confirmarAlgo').dialog({title:'CONCEPTO ELIMINADO',modal:true,autoOpen:true, closeText: '',
								width: 600, height: 200, closeOnEscape: true, dialogClass: '',
								buttons:{ "Cerrar":function(){ $('#dialog-confirmarAlgo').dialog('close'); } },
								open:function( event, ui ) {
									$('#textoAlgo').text('¡EL CONCEPTO SE HA ELIMINADO SATISFACTORIAMENTE!');
									$('#debeConfirmarCOEA').hide();
									window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
									$('#dialog-nivel2').dialog('close');$('#clickmeTos').click();
								}, close:function( event, ui ) { $('#clickmeTos').click(); }
							});
						} else{alert(data);} });
					}else{
						$('#debeConfirmarCOEA').hide().show('shake');
						window.setTimeout(function(){$('#debeConfirmarCOEA').hide()},1500);
					}
				}, "Cancelar":function(){ $('#dialog-nivel2').dialog('close'); }
			},
			open:function(event,ui){$('#texto_eliminar_algo').html('¿ESTÁ SEGURO DE ELIMINAR EL CONCEPTO '+nombre_to+'?');}, 
			close:function(event,ui){ $('#dialog-nivel2').empty();$('#tabla_eliminar_algo').remove(); }
		});
	} });
}); }

function documentos(id_su, clave_su){ $(document).ready(function(e) {
$("#dialog-nivel1").load("htmls/usuario.php #dataTableDocs",function(response, status, xhr){ if ( status == "success" ) {
	$('#b_subir_doc').click(function(e) { subir_documento(id_su); });
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 60;
	$('#dialog-nivel1').dialog({
		autoOpen:true,modal:true,width:w,height:h,title:'DOCUMENTOS DEL USUARIO '+clave_su,closeText:'', dialogClass:'',
		closeOnEscape:true,
		open:function( event, ui ){
			var oTableDo, tamF = $('#dialog-nivel1').height()-40;
			oTableDo = $('#dataTableDocs').dataTable({
				"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
					$('span.DataTables_sort_icon').remove(); $('#dataTableDocs_wrapper td').removeClass('sorting_1');
				},
				"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tamF, "bAutoWidth": false, 
				"bInfo": true, "bFilter": false, ordering: false,
				"aoColumns": [ {"bSortable":false},{"bSortable":false},{"bSortable":false},{"bVisible":false} ],
				"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
				"sDom": 't', "sAjaxSource": "datatable-serverside/documentos.php",
				"fnServerParams":function(aoData, fnCallback){ var id_s = id_su; aoData.push({"name": "id_s", "value": id_s });},
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
				"oLanguage": {
					"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "EL USUARIO NO CUENTA CON DOCUMENTOS",
					"sInfo":"ENCONTRADOS: _END_","sInfoEmpty":"MOSTRADOS: 0","sInfoFiltered":"<br/>DOCUMENTOS: _MAX_","sSearch": "",
					"oPaginate": {
						"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
						"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
					}
				}
			}); $('#clickmeDo').click(function(e){oTableDo.fnDraw();});
			
			$('.boton_mem').click(function(event){event.preventDefault();});
		}, close:function( event, ui ){ $("#dialog-nivel1").empty(); $('#dialog-nivel1').dialog('destroy'); }, buttons:{ }
	});
} }); }); }
function subir_documento(idS){ $(document).ready(function(e) {
$("#dialog-nivel2").load("htmls/usuario.php #documento",function(response,status,xhr){ if(status == "success"){
	$('#dialog-nivel2').dialog({
		autoOpen:true,modal:true,width:800,height:300,title:'SUBIR UN DOCUMENTO',closeText:'',
		open:function( event, ui ){
			$('#form-documento').submit(function(event) { event.preventDefault(); });
			$('#form-documento').validate(); $('#fileupload_docu').addClass('ui-state-disabled');
			$('#titulo_documento').keyup(function(e) {//$('#fileupload').valid();
				if($(this).val()!=''){$('#fileupload_docu').removeClass('ui-state-disabled');}
				else{$('#fileupload_docu').addClass('ui-state-disabled');}
			});
			'use strict'; //Para el upload // Change this to the location of your server-side upload handler:
			var ko = $('#idUser').val();
			var url = window.location.hostname === 'blueimp.github.io' ?
						'//jquery-file-upload.appspot.com/' : 'documentos/index.php?idU='+ko+'&idP='+idS+'&nombreD='+escape($('#titulo_documento').val());
			$('#fileupload_docu').fileupload({
				url: url, dataType: 'json',
				submit:function (e, data) {
					$.each(data.files, function (index, file) {
						var input=$('#titulo_documento'); data.formData = {titulo_d: input.val(), ext_d:file.name.split('.')[1] };
					});
				},
				progress: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10); $('#progress .bar').css('width',progress + '%');
				},
				done: function (e, data) {
					$('#dialog-nivel3').dialog({
						autoOpen: true, modal: true, width: 500, height:120, title: 'DOCUMENTO CARGADO', closeText: '',
						open:function( event, ui ){
							$('#dialog-nivel3').html('<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2"><tr><td align="center" valign="middle"><h3>¡El archivo se guardó satisfactoriamente!</h3></td></tr></table>');
							$('#dialog-nivel2').dialog('close');
							window.setTimeout(function(){$('#dialog-nivel3').dialog('close');},2500);
						},
						close:function( event, ui ){ 
							$("#dialog-nivel3").empty(); $('#dialog-nivel3').dialog('destroy'); $('#clickmeDo').click();
						}, buttons:{ }
					});
				},
			}); //Para el upload
		},
		close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{ "Cancelar":function(){$('#dialog-nivel2').dialog('close');} }
	});
} });
}); }
function ver_logo(nombre_img, name_s, exte, time,titulo,carpeta,id_doc,que_es){ $(document).ready(function(e) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel2').dialog({
		autoOpen: true, modal: true, width: w, height:h, title: titulo+' DE LA EMPRESA '+ name_s, closeText: '',
		open:function( event, ui ){
			$("#dialog-nivel2").load('../pacientes/htmls/miPDFdocs.php #tablaMiPDF', function( response, status, xhr ) { 
				if ( status == "success" ) { //alert(exte);
					if(exte != 'pdf' & exte != 'PDF'){
						x=carpeta+'/files/'+id_doc+'.'+exte+'?'+time;
						$('#mi_documento').html('<img src='+x+' style="max-width:750px; border:5px solid white; border-radius:4px; background-color:rgba(255, 255, 255, 1);">');
					}else{
						x=carpeta+'/files/'+id_doc+'.pdf';
						$('#mi_documento').html('<a class="media" href=""> </a>');
						$('a.media').media({width:890, height:h-136, src:x});	
					}
				}
			});
		}, close:function( event, ui ){ $("#dialog-nivel2").empty(); $('#dialog-nivel2').dialog('destroy'); },
		buttons:{
			"Imprimir":function(){$('#dialog-nivel2 #tablaMiPDF').printElement();},
			"Eliminar":function(){delete_documento(id_doc,titulo,exte,que_es,carpeta);},
			"Cerrar":function(){$('#dialog-nivel2').dialog('close');}
		}
	});
}); }

function delete_documento(id_doc, nombre_doc, tipo_doc, titulo,carpeta){ $(document).ready(function(e) {//alert(tipo_doc);
$("#dialog-nivel3").load("../pacientes/htmls/eliminacion.php", function( response, status, xhr ) { if ( status == "success" ) { 
	$('#dialog-nivel3').dialog({ title: 'ELIMINAR ARCHIVO', modal: true, autoOpen: true, closeText: '', width: 700, 
		height: 230, closeOnEscape: true, dialogClass: '',
		buttons:{
			"Aceptar":function(){
				if($('#confirmaEA').prop('checked')==true){
					var datos = {id:id_doc, tipo:tipo_doc, que_es:titulo,carpeta:carpeta}
					$.post('files-serverside/eliminarDocumento.php',datos).done(function( data ) { if (data==1){
						$('#dialog-nivel2').dialog('close');
						$('#dialog-confirmarAlgo').dialog({ title:'ARCHIVO ELIMINADO',modal:true, autoOpen: true, closeText: '',
							width: 600, height: 200, closeOnEscape: true, dialogClass: '',
							buttons:{ "Cerrar":function(){ $('#dialog-confirmarAlgo').dialog('close'); } },
							open:function( event, ui ) {
								$('#textoAlgo').text('¡EL ARCHIVO SE HA ELIMINADO SATISFACTORIAMENTE!');
							    document.getElementById('form-eliminarAlgo').reset();$('#debeConfirmarCOEA').hide();
								window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
								$('#dialog-nivel3').dialog('close');$('#clickme,#clickmeMem,#clickmeFo').click();
							}, close:function( event, ui ) { $('#clickme,#clickmeMem,#clickmeDo').click(); }
						});
					} else{alert(data);} });
				}else{
					$('#debeConfirmarCOEA').hide().show('shake');
					window.setTimeout(function(){$('#debeConfirmarCOEA').hide()},1500);
				}
			}, "Cancelar":function(){ $('#dialog-nivel3').dialog('close'); }
		},
		open:function(event, ui){$('#texto_eliminar_algo').html('¿ESTÁ SEGURO QUE DESEA ELIMINAR EL ARCHIVO '+nombre_doc+'?');}, 
		close:function(event,ui){ $('#dialog-nivel3').empty();$('#tabla_eliminar_algo').remove(); }
	});
} });
}); }

function permisos(idU, nombreU){ $(document).ready(function(e){
$("#dialog-nivel1").load("htmls/usuario.php #permisos", function( response, status, xhr ) { if ( status == "success" ) {
	$("#dialog-nivel1").tabs({active: 0}); $('#permisos ul').removeClass('ui-widget-header');
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({ 
		title:'PERMISOS DEL USUARIO '+nombreU,modal:true,autoOpen:false,closeText:'',width:w,height:h,closeOnEscape:true,
		dialogClass:'', buttons:{},
		open:function(event, ui){
			var datosP = {idU:idU}
			$.post('files-serverside/datosPermisos.php',datosP).done(function(data){ var datosP = data.split('{}*');
				$('#st_usuario_s').val(datosP[0]);
			});
			
			$('#st_usuario_s').change(function(e) {
				var datos = {idU:idU, tipo:$(this).val()}
				$.post('files-serverside/actualizarPermiso.php',datos).done(function(data){ if (data==1){
					$('#dialog-confirmarAlgo').dialog({ title:'PERMISO ACTUALIZADO',modal:true, autoOpen: true, closeText: '',
						width: 600, height: 130, closeOnEscape: false, dialogClass: 'no-close',
						buttons:{ },
						open:function( event, ui ) {
							$('#textoAlgo').text('¡LOS PERMISOS DEL USUARIO SE ACTUALIZARON SATISFACTORIAMENTE!');
							window.setTimeout(function(){$('#dialog-confirmarAlgo').dialog('close');},1500);
						}, close:function( event, ui ) { }
					});
				} });
            });
		}, 
		close:function(event,ui){$('#dialog-nivel1').empty(); $("#dialog-nivel1").tabs("destroy");}
	});
	if($('#accesoU').val()==1){$('#dialog-nivel1').dialog('open');}else{$('#dialog-alertar').dialog('open');}
} });
}); }

function computeTotalDistance(result) { var total = 0,  myroute = result.routes[0];
  for (var i = 0; i < myroute.legs.length; i++) { total += myroute.legs[i].distance.value; }
  total = total / 1000; document.getElementById('total').innerHTML = total + ' km';
}

function ubicacion(idU, nombreU){ $(document).ready(function(e){
$("#dialog-nivel1").load("htmls/usuario.php #ubicacion", function( response, status, xhr ) { if ( status == "success" ) {
	var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
	$('#dialog-nivel1').dialog({ 
		title:'UBICACIÓN DEL USUARIO '+nombreU,modal:true,autoOpen:true,closeText:'',width:w,height:h,closeOnEscape:true,
		dialogClass:'', 
		buttons:{
			"CÓMO LLEGAR":function(){ var datosP = {idU:idU}
				$.post('files-serverside/datosUbicacion.php',datosP).done(function(data){ var datosP = data.split('{}*');
					$('#right-panel').css('height',$('#indicaciones_map').height())-4;
					$('#indicaciones_map').css('min-width',240);
					$('#right-panel').html('<p>Distancia total: <span id="total"></span></p>');
					
					var la1 = datosP[0], lo1 = datosP[1]; 
					var map = new google.maps.Map(document.getElementById('map1'), {
						center: new google.maps.LatLng(la1, lo1), zoom: 16, scrollwheel: false //Cuautla :3
					});
					var directionsService = new google.maps.DirectionsService;
  					var directionsDisplay = new google.maps.DirectionsRenderer({
						draggable: false,
						map: map,
						panel: document.getElementById('right-panel')
					});
					directionsDisplay.addListener('directions_changed', function() {
    computeTotalDistance(directionsDisplay.getDirections());
  });
					directionsDisplay.setMap(map);
					marker = new google.maps.Marker({
						map:map,draggable:false, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la1, lo1)
					});
					var infoWindow = new google.maps.InfoWindow({map: map});
					// Try HTML5 geolocation.
					  if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function(position) {
						  var pos = { lat: position.coords.latitude, lng: position.coords.longitude };
					
						  map.setCenter(pos);//infoWindow.setContent('Location found.');infoWindow.setPosition(pos);
						  marker = new google.maps.Marker({
								map:map,draggable:false, animation: google.maps.Animation.DROP, 
								position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
						  });
						  var selectedMode = document.getElementById('mode').value;
						  directionsService.route({
							origin: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
							//transitOptions: TransitOptions, 
							drivingOptions: { departureTime: new Date(Date.now()),   trafficModel: "optimistic" },
							destination: new google.maps.LatLng(la1, lo1),
							travelMode: google.maps.TravelMode[selectedMode], avoidTolls: true
						  }, function(response, status) {
							if (status === google.maps.DirectionsStatus.OK) { directionsDisplay.setDirections(response);
							} else { window.alert('Directions request failed due to ' + status); }
						  });
						}, function() { handleLocationError(true, infoWindow, map.getCenter()); });
					  } else { // Browser doesn't support Geolocation
						//handleLocationError(false, infoWindow, map.getCenter());
						infoWindow.setPosition(map.getCenter());
  						infoWindow.setContent(false ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
					  }
				});	
			}
		},
		open:function(event, ui){ var datosP = {idU:idU}
			$.post('files-serverside/datosUbicacion.php',datosP).done(function(data){ var datosP = data.split('{}*');
				if (navigator.geolocation) { //alert(9);
				var la1 = datosP[0], lo1 = datosP[1]; 
				var map = new google.maps.Map(document.getElementById('map1'), {
					center: new google.maps.LatLng(la1, lo1), zoom: 16, scrollwheel: false //Cuautla :3
				}); var infoWindow = new google.maps.InfoWindow({map: map});
				marker = new google.maps.Marker({
					map: map, draggable: false, animation: google.maps.Animation.DROP, position: new google.maps.LatLng(la1, lo1)
				});
				}
			});		
		}, 
		close:function(event,ui){$('#dialog-nivel1').empty(); /*$("#dialog-nivel1").tabs("destroy");*/ }
	});
} });
}); }

function universidad(idU){ $(document).ready(function(e){
	$("#dialog-nivel2").load("htmls/buscar_universidad.php", function( response, status, xhr ){ if(status=="success"){
		var w = $('#referencia').width() * 0.98, h = $('#referencia').height() - $('#header').height() - 50;
		$('#dialog-nivel2').dialog({ 
			title:'UNIVERSIDAD DEL USUARIO ',modal:true,autoOpen:true,closeText:'',width:w,height:h,closeOnEscape:false,
			dialogClass:'no-close', 
			buttons:{
				"Aceptar": function() {
				   if($('.selected2').length >0){$('#errorSeleccionUni').hide();
					$('#dialog-nivel2').dialog('close');
				   }else{ $('#errorSeleccionUni').hide().show('shake'); }
				},
				"Cancelar": function() { $('#dialog-nivel2').dialog('close'); }
			},
			open:function(event, ui){ var asInitVals0i = new Array();
				var oTableUni, tamU = $('#dialog-nivel2').height()-100;
				oTableUni = $('#dataTableBuniversidad').dataTable({
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { 
						$('span.DataTables_sort_icon').remove(); $('#dataTableBuniversidad_wrapper td').removeClass('sorting_1');
					},
					"bJQueryUI": true, "bScrollInfinite": true, "bScrollCollapse": true, "sScrollY": tamU, "bAutoWidth": false, 
					"bInfo": true, "bFilter": true, ordering: false,
					"aoColumns":[
						{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false},{"bSortable":false}
					],
					"iDisplayLength": 100, "bLengthChange": false, "bProcessing": false, "bServerSide": true,
					"sDom": 't', "sAjaxSource": "datatable-serverside/universidades.php",
					"fnServerParams":function(aoData, fnCallback){ },
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
					"oLanguage": {
						"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "-SIN COINCIDENCIAS-",
						"sInfo":"ENCONTRADAS: _END_","sInfoEmpty":"MOSTRADAS: 0","sInfoFiltered":"<br/>UNIVERSIDADES: _MAX_","sSearch": "",
						"oPaginate": {
							"sNext": "<span class='paginacionPrincipal'>Siguiente</span>",
							"sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;"
						}
					}
				}); $('#clickme_buni').click(function(e){oTableUni.fnDraw();});
				
				//para los fintros individuales por campo de texto
				$("tfoot input.campos_q").keyup(function(){/* Filter on the column (the index) of this element */ 
					oTableUni.fnFilter( this.value, $("tfoot input.campos_q").index(this) ); 
				});
				/* * Support functions to provide a little bit of 'user friendlyness' to the textboxes in  * the footer */
				$("tfoot input.campos_q").each( function (i) { asInitVals0i[i] = this.value; } );
				 
				$("tfoot input.campos_q").focus( function () { 
					if ( this.className == "search_init" ) { this.className = ""; this.value = "";} 
				} );
				 
				$("tfoot input").blur( function (i) { 
					if ( this.value == "" ) { 
						this.className="search_init campos_q campos_b_t";
						this.value=asInitVals0i[$("tfoot input.campos_q").index(this)];
					} 
				} );
				//fin filtros individuales por campo de texto
				
				var tableBU = $('#dataTableBuniversidad').DataTable();
				$('#dataTableBuniversidad tbody').on('click','tr',function(){
					if($(this).hasClass('selected2')){$(this).removeClass('selected2');}
					else{
						tableBU.$('tr.selected2').removeClass('selected2');$(this).addClass('selected2');
						$('#errorSeleccionUni').hide();
					}
				});
				
				$('#dataTableBuniversidad tbody').on( 'click', 'tr', function () {
					var nTdsBU = $('td', this); var idUni = $(nTdsBU[0]).html().split('"'); //alert($(nTdsBU[2]).html());
					$('#id_uni_u').val(idUni[1]); $('#universidadU').val($(nTdsBU[2]).html());
				}); //con la clave del médico sacamos su id
	
			}, 
			close:function(event,ui){$('#dialog-nivel2').empty(); }
		});
	} });
}); }

function initMap() { }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbPi4G3-wjEbEt_77OmTBhxWvmR23ds9Q&signed_in=true&callback=initMap"
	async defer>
</script>