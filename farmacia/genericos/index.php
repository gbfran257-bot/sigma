<?php require_once('../../Connections/horizonte.php'); ?>
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
    if (in_array($UserName, $arrUsers)) { $isValid = true;  } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { $isValid = true; } 
    if (($strUsers == "") && true) { $isValid = true; } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../index.php";
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
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  	if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
	  $theValue=function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	
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

if (isset($_SESSION['MM_Username'])) { $colname_usuario = $_SESSION['MM_Username']; }
mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT id_u, nombre_u, apaterno_u, amaterno_u, idSucursal_u, usuario_u, idDepartamento_u, idPuesto_u, acceso_u, sexo_u, foto_u, nombreFoto_u FROM usuarios WHERE usuario_u = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error()); $row_usuario = mysql_fetch_assoc($usuario); $totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreSucursalUsuario = sprintf("SELECT nombre_su FROM sucursales WHERE clave_su = %s", GetSQLValueString($row_usuario['idSucursal_u'], "text"));
$nombreSucursalUsuario = mysql_query($query_nombreSucursalUsuario, $horizonte) or die(mysql_error()); $row_nombreSucursalUsuario = mysql_fetch_assoc($nombreSucursalUsuario); $totalRows_nombreSucursalUsuario = mysql_num_rows($nombreSucursalUsuario);

mysql_select_db($database_horizonte, $horizonte);
$query_nombreDepartamentoUsuario = sprintf("SELECT nombre_d FROM departamentos WHERE id_d = %s", GetSQLValueString($row_usuario['idDepartamento_u'], "int"));
$nombreDepartamentoUsuario = mysql_query($query_nombreDepartamentoUsuario, $horizonte) or die(mysql_error()); $row_nombreDepartamentoUsuario = mysql_fetch_assoc($nombreDepartamentoUsuario); $totalRows_nombreDepartamentoUsuario = mysql_num_rows($nombreDepartamentoUsuario);
?>

<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="../../imagenes/favicon.ico">
<meta charset="utf-8">
<title>MEDICAMENTOS</title>

<link href="../../css/plantilla.css" rel="stylesheet" type="text/css">
<link href="../../css/medicamentos.css" rel="stylesheet" type="text/css">
<link href="../../jquery-ui-1.11.4/flick/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../DataTables-1.10.5/media/css/jquery.dataTables.css">

<script src="../../jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="../../jquery-ui-1.11.4/jquery-ui.js"></script>
<script src="../../jquery-ui-1.11.4/external/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../../DataTables-1.10.5/media/js/jquery.dataTables.js"></script>
<script src="../../DataTables-1.10.5/extensions/Scroller/js/dataTables.scroller.js"></script>
<script src="../../jquery-ui-1.11.4/external/jquery/globalize.js"></script>
<script src="../../jquery-ui-1.11.4/external/jquery/globalize.culture.de-DE.js"></script>
<script src="../../funciones/js/caracteres.js"></script>
<script src="../../funciones/js/calcula_edad.js"></script>
<script src="../../jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="../../funciones/js/redondea.js"></script>
<script src="../../funciones/js/jquery.printElement.min.js"></script>
<script src="../../funciones/js/stdlib.js"></script>
<script src="../../funciones/js/generador_rfc.js"></script>
<script src="../../funciones/js/cantidad_a_letra.js"></script>
<script type="text/javascript" src="imagenes/ajaxupload.js"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../chart_1.0.2/Chart.min.js"></script>
<script type="text/javascript" src="../../funciones/js/jquery.media.js"></script> 
<script type="text/javascript" src="../../funciones/js/jquery.fileDownload.js"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script>
$(document).tooltip({position:{my:"center bottom-20",at:"center top",using:function(position,feedback){$(this).css(position);}}});

$(document).ready(function(e) {
	$('#dialog-desaignaConvenio').dialog({ autoOpen:false});
	$('#formNM').validate({ ignore: 'hidden', focusCleanup: true,
		rules:{ idNM:{ required:true, remote:{ url: '../usuarios/files-serverside/checkClaveUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { clave:function(){ return $('#idNM').val(); } } }, minlength: 4 } },
		messages:{ idNM:{ required: 'Se debe ingresar el identificador del médico.', remote:'Este identificador ya está en uso, favor de intentar con otro.', minlength:'El identificador consta de 4 caracteres' } }
	});
	
	$('#idNM').keyup(function(e) {
		var x=$(this).val();
			if( x.length>3 & x.length<5 ){
				var claveUsuario1 = $('#idNM').val(); var datoU ={ claveUsuario1:claveUsuario1}
				$.post('../../usuarios/files-serverside/disponibleClaveUsuario.php',datoU).done(function( data ) {
					if (data == 1){
						$('#textoClaveUsuarioDisponible').text('Disponible');$('#textoClaveUsuarioDisponible').addClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
						$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert'); $('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-check');
					}else{
						$('#textoClaveUsuarioDisponible').text('No Disponible');$('#textoClaveUsuarioDisponible').addClass('textoNoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoAlerta');
						$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-alert'); $('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-closethick');
					}
				});
			}else{
				$('#textoClaveUsuarioDisponible').text('Muy Corto');$('#textoClaveUsuarioDisponible').addClass('textoAlerta'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert');$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-closethick');
				$('#iconoClaveUsuario').removeClass('ui-icon ui-icon-check');
			}
			if(x.length<=3){ $('#textoClaveUsuarioDisponible').removeClass('textoAceptable'); $('#textoClaveUsuarioDisponible').removeClass('textoNoAceptable'); $('#iconoClaveUsuario').addClass('ui-icon ui-icon-alert'); }
			if(x.length==0){ $('#textoClaveUsuarioDisponible').text('Vacío');}
	});
		
	$('#misDatosUsuario').hide(); var dj = 1;
	
	$('.miUsuario').click( function(e) { dj++; if(dj%2==0){ $('#misDatosUsuario').stop().show('explode','slow'); }else{ $('#misDatosUsuario').stop().hide('explode','slow'); } });
	
	var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75); var cy = $('#header table').height() - 4;

	$('#misDatosUsuario').css('right',cx).css('top',cy);
	
	//esto va despues de la función que carga la ficha del paciente		
	$( window ).resize(function(e) {
        var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75); var cy = $('#header table').height() - 4;
	
		$('#misDatosUsuario').css('right',cx).css('top',cy);
		
		var he = $('#referencia').height() - 200; var wi = $('#referencia').width() * 0.98;
		$("#dialog-confirmarNuevoPaciente").tabs({active: 0});$("#dialog-confirmarNuevoPaciente").css('width',wi).css('height',he);
		
		$('.tabs').css('width',wi/7.5);
    });
	
	$('#dialog-nadaOV').dialog({ autoOpen: false, modal: true, closeOnEscape: true, width: 500, height:200, 
		title: 'REVISE LA ORDEN DE VENTA', closeText: '', dialogClass: 'no-close', 
		buttons: { Cerrar: function() {  $('#dialog-nadaOV').dialog('close'); } } 
	});
	
	$('#addMedico').button({ icons: { primary: "ui-icon-plusthick" }, text: true });
});
</script>

<script>
  $.widget( "ui.timespinner", $.ui.spinner, {
	options: { step: 60 * 1000, /*seconds*/ page: 60 /*hours*/ },
	_parse: function( value ) { if ( typeof value === "string" ) { if ( Number( value ) == value ) { return Number( value ); } return +Globalize.parseDate( value ); } return value; },
	_format: function( value ) { return Globalize.format( new Date(value), "t" ); }
  });
</script>

<script>
function nuevoPaciente(){
$(document).ready(function(e) {
	var he = $('#referencia').height() - $('#header').height()-50; var wi = $('#referencia').width() * 0.98;
	
    $('#dialog-verPaciente').dialog({
		title: 'ALTA DE UN NUEVO MEDICAMENTO, INGRESE LOS DATOS REQUERIDOS.', modal: true, autoOpen: false, closeText: '', 
		width: wi, height: he, closeOnEscape: false, dialogClass: 'no-close',
		buttons: { //"Guardar": function() { }, "Cancelar": function() { }
      }, create: function( event, ui ) {},
	  open:function( event, ui ){
		$('.t_uno').css('height',$('#dialog-verPaciente').height()-50);
		$('#nombreP').focus(); $('#tabs-1-1').click(function(e) { $('#nombreP').focus(); });
		$('#savePac,#cancelSavePac').button({});
		$('.botonesSaveP').show();
		$('.botonesUpdateP').hide();
		$('#dialog-verPaciente input, #dialog-verPaciente select, #dialog-verPaciente textarea').addClass('campoITtab'); 
		$('.pActivo').show();$('#tabs-5-1, #tabs-4-1').hide();$('.idUsuarioP').val($('#idUser').val()); 
		$('#pestanas').removeClass('ui-widget-header');
		
		$('#savePac').click(function(e) {
            if($('#formGenerales').valid()){ 
				var datosP = $('#formGenerales').serialize();
				$.post('files-serverside/addPaciente.php',datosP).done(function( data ) { 
					if (data==1){ 
						$('#dialog-verPaciente').dialog('close'); 
						$('#texto-informar').text('¡El nuevo paciente se ha guardado satisfactoriamente!');
						$('#dialog-informar').dialog({
							autoOpen: true, modal: true, width: 600, height:200, title: 'DATOS GUARDADOS', closeText: '',
							open:function( event, ui ){ $('#dialog-verPaciente').dialog('close'); 
							$('#clickme').click(); window.setTimeout(function(){$('#dialog-informar').dialog('close');},2000); }
						});
					} 
					else{alert(data);} 
				});
			}
        });
		$('#cancelSavePac').click(function(e) {
            $('#dialog-verPaciente').dialog('close');
		  if($('#hayFoto').val()==1){
				var a = $('#gallery .eliminame'); //alert(a.attr('name'));	
				$.get("imagenes/procesa.php?action=eliminar",{id:a.attr("name")},function(){
					a.parent().parent().parent().fadeOut("slow"); $('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Agregar fotografía" }).show(); $('#hayFoto').val(0);
				})
			}else{}
        });
		var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {
			validateOn:["blur"], isRequired:false, useCharacterMasking:true
		});
		var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {
			validateOn:["blur"], isRequired:false, useCharacterMasking:true
		});
		var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {
			validateOn:["blur"], isRequired:false, useCharacterMasking:true
		});
		var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {
			validateOn:["blur", "change"], minChars:18, maxChars:18
		});
		$('#telmovilP, #telparticularP, #telefonoTrabajoP').focusout(function(e) { if($(this).val()=='('){$(this).val('');} }); 
		
	  }, close:function( event, ui ){ $( "#dialog-verPaciente" ).tabs( "destroy" );$('#dialog-verPaciente').empty(); }
	});
	$('#dialog-verPaciente').dialog('open');
});/*Fin ready*/ }//Fin nuevoPaciente()

function openFile(file) {
    var extension = file.substr( (file.lastIndexOf('.') +1) );
    switch(extension) {
        case 'jpg':
		case 'JPG':
        case 'png'://case 'gif':
		case 'PNG':
            return 1;
        break; //case 'zip': //case 'rar': //alert('was zip rar'); //break; //case 'pdf': //alert('was pdf'); //break;
        default:
            return 0;
    }
};
</script>

<script>
$(document).ready(function(e) { $('#miMenu').hide(); $('#verMenu').click(function(e) { verMenu(); }); });
function verMenu(){ $(document).ready(function(e) { $('#miMenu').show('fold','slow'); $('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">MEDICAMENTOS</span>'); }); }
function ocultarMenu(){ $(document).ready(function(e) { $('#miMenu').hide('fold','slow'); $('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">MEDICAMENTOS</span>'); }); }

$(document).ready(function(e){ 
	$("#upload").button({ icons: { primary: "ui-icon-image" }, text: true }); 
});
</script>

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"> </div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="indicePaciente" type="hidden" id="indicePaciente">
<input name="sucursalOV" type="hidden" id="sucursalOV" value="<?php echo $row_usuario['idSucursal_u']; ?>">
<input name="today" id="today" type="hidden" value="<?php echo date("d/m/Y"); ?>"> <input name="filtro" id="filtro" type="hidden" value="YO SOLO SE QUE NO SE NADA">

<input name="precioTemp" id="precioTemp" type="hidden" value="0"> <input name="urgeAtender1" id="urgeAtender1" type="hidden" value="0"> <input name="contaItems" id="contaItems" type="hidden" value="0"><input name="estado_pago_ov" id="estado_pago_ov" type="hidden" value="0">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../../imagenes/iconitos/_medicamentosIcon.png" height="40"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">MEDICAMENTOS</span></td>
        <td id="celdaUsuario" width="50%" valign="top" align="center">
            <table class="miUsuario" width="1%" height="100%" border="0" cellspacing="0" cellpadding="4" style="border-radius:0px;">
              <tr>
                <td align="center" nowrap valign="middle">
                <?php if($row_usuario['foto_u'] == 1){?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="25">
                <?php }else{?>
                	<img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="25">
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
                <img class="fotoUsuario" id="miFotoUsuarioMini" src="../../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80">
            <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
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
<tr valign="middle" align="center" class="fondoMenu">
    <td class="eii">
    <img title="Menú recepción" src="../../imagenes/submenu/_farmacia.png" width="90" onClick="window.location='../../menu_farmacia.php'">
    </td>
    <td class="eid"><img title="Inicio" src="../../imagenes/submenu/_inicio.png" width="90" onClick="window.location='../../menu.php'"></td>
</tr> </table>
</div>

<div class="contenido" id="contenido" align="center">
<table width="90%" height="100%" border="0" cellpadding="4" cellspacing="2" id="dataTablePrincipal" class="tablilla"> 
<thead id="cabecera_tBusquedaPrincipal" class="">
  <tr bgcolor="#FF6633" style="font-size:1.3em;">
    <th id="clickme"class="titulosTabs"align="center" nowrap width="" style="color:white;" nowrap>NOMBRE</th>
    <th class="titulosTabs" align="center" style="color:white;" width="200px" nowrap>DESCRIPCIÓN</th>
    <th class="titulosTabs" align="center" style="color:white;" width="200px" nowrap>CANTIDAD</th>
    <th class="titulosTabs" align="center" style="color:white;" width="200px">PRESENTACIÓN</th>
    <th class="titulosTabs" align="center" style="color:white;" width="200px">NIVEL</th>
    <th class="titulosTabs" align="center" style="color:white;" width="200px">GRUPO</th>
    <!--<th class="titulosTabs" align="center" width="10px" style="color:white;">COSTO</th>
    <th class="titulosTabs" align="center" style="color:white;" nowrap width="80px"><span title="PRECIO AL PÚBLICO">PRECIO P</span></th>
    <th class="titulosTabs" align="center" style="color:white;" width="80px" nowrap><span title="PRECIO HOSPITAL">PRECIO H</span></th>
    <th class="titulosTabs" align="center" width="80px" style="color:white;"><span title="PRECIO MEMBRESÍA">PRECIO M</span></th> -->
  </tr>
</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
	<tfoot>
        <tr>
            <th><input name="sMedicamento" id="sMedicamento" type="text" class="search_init campos_b_t" placeholder="-MEDICAMENTO-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sDescripcion" id="sDescripcion" type="text" class="search_init campos_b_t" placeholder="-DESCRIPCIÓN-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sCantidad" id="sCantidad" type="text" class="search_init campos_b_t" placeholder="-CANTIDAD-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sPresentacion" id="sPresentacion" type="text" class="search_init campos_b_t" placeholder="-PRESENTACIÓN-" onKeyUp="conMayusculas(this);"/></th>
            <th><input name="sNivel" id="sNivel" type="text" class="search_init campos_b_t" placeholder="-NIVEL-" onKeyUp="conMayusculas(this);"/></th>
            <th>
            <input name="sGrupo" id="sGrupo" type="text" class="search_init campos_b_t" placeholder="-GRUPO-" onKeyUp="conMayusculas(this);"/>
            </th>
        </tr>
    </tfoot>
</table>
</div>

<div id="dialog-verPaciente" style="display:none; overflow:hidden;"> </div>

<div id="dialog-confirmarAlgo" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2"> <tr> <td align="center" valign="middle"><span id="textoAlgo"></span></td> </tr> </table> </div>

<div id="dialog-nuevaVisita" style="display:none;"> </div>

<div id="dialog-buscaMedico" title="BUSCAR MÉDICO" style="display:none;"> </div>

<div id="dialog-buscarItems" title="BUSCAR/AGREGAR ITEMS" style="display:none;background-repeat:no-repeat; background-position:center; background-size:cover; color:white;"> </div>

<div id="dialog-confirmaciones" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle" height="100%"><span id="texto-confirmaciones">GUARDADO SATISFACTORIAMENTE</span></td></tr></table></div>

<div id="dialog-confirmacion1" style="display:none;"> <p class="textoMsjConfirmacion1">Guardando Datos...</p> ¡Por favor espere! </div>

<div id="dialog-agregarM" style="display:none;"> </div>

<div id="dialog-confirmarNM" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> <tr> <td>EL NUEVO MÉDICO SE DIÓ DE ALTA SATISFACTORIAMENTE.</td> </tr> </table> </div>

<div id="dialog-conveniosP" style="display:none;"> </div>

<div id="dialog-preguntar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3"> <tr> <td align="left"><span id="textoPreguntar">¿ESTA SEGURO QUE</span></td> </tr> </table></div>

<div id="dialog-nuevo" style="display:none;"> </div>

<div id="dialog-informar" style="display:none;"><table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="middle" height="100%"><span id="texto-informar"></span></td></tr></table></div>

<div id="dialog-historial" style="display:none;"> </div>

<div id="dialog-rDX" style="display:none;"> </div>

<input name="miFacturados" id="miFacturados" type="hidden" value="0,1">

</body>
</html>

<?php mysql_free_result($usuario); mysql_free_result($nombreSucursalUsuario); mysql_free_result($nombreDepartamentoUsuario); ?>

<script type="text/javascript">
function misPacientes(){ $(document).ready(function(e) {window.setTimeout(function(){/*alert($('.miPaciente').length);*/},200); });}
$(document).ready(function() {
	var asInitVals = new Array();
	
	var oTableP;
	var tamP = $('#referencia').height() - 160;
	oTableP = $('#dataTablePrincipal').dataTable({
		serverSide: true,"sScrollY": tamP, ordering: false, searching: true,ordering: false, "bJQueryUI": false,
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) { misPacientes(); },
		"aoColumns": [
			{ "bSortable": false }, { "bSortable": false },{ "bSortable": false }, { "bSortable": false }, { "bSortable": false },
			{ "bSortable": false }
		],
		"sDom": '<"filtro1Principal">r<"data_tPrincipal"t><"infoPrincipal"iS>',
		"sAjaxSource": "datatable-serverside/medicamentos.php",
		"fnServerParams": function (aoData, fnCallback) { 
			var de = $('#filtro').val(), cv = $('#convenioP1').val(); 
			aoData.push( {"name": "nombre", "value": de } ); 
			aoData.push( {"name": "convenio", "value": cv } ); 
		},
		"oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "MEDICAMENTOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN MEDICAMENTO FILTRADO.", "sInfoFiltered": " TOTAL DE MEDICAMENTOS: _MAX_", "sSearch": "",
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
	
	$('.infoPrincipal').append( "<div style='border:1px solid none; text-align:right;'><table id='ocultarFP' style='float:right;' width='' border='0' cellspacing='0' cellpadding='6'> <tr> <td><img title='Agregar un nuevo medicamento' id='addPacientePrincipal' onClick='nuevoPaciente()' src='../../imagenes/botones/_add.png' width='' height=''></td> <td>&nbsp;</td> </tr> </table></div>" );
	$('#addPacientePrincipal').css('height', 30);
	$('.filtro1Principal input').attr("placeholder", "BUSQUE UN MEDICAMENTO AQUÍ...").addClass('placeHolder');
	
	//ponemos los botones de reset y de añadir un paciente de la tabla principal de busqueda de pacientes
	$("div.toolbar").css('white-space','nowrap').css('border','1px none red').css('padding','10px');
	
	if($('.filtro1Principal input').val() ==''){ $('#filtro').val('YO SOLO SE QUE NO SE NADA'); }else{ $('#filtro').val('%%');oTableP.fnDraw(); }
	
	$('#convenioP1').change(function(e) { oTableP.fnDraw(); });
	
	$('.filtro1Principal').css('left',$('#botonesPrincipal').width() );
	$('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );
		
	window.setTimeout(function(){ $('.filtro1Principal').css('left',$('#botonesPrincipal').width() ); $('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) );  },300);
	
	$( window ).resize(function() { $('.filtro1Principal').css('left',$('#botonesPrincipal').width() ); $('.filtro1Principal input').css('width', ($('#referencia').width() * 0.98) ); });
	
	var search_boxP = $('.filtro1Principal input');
	var busquedaP = $('.filtro1Principal');
	var data_tP = $('#dataTablePrincipal tbody');
	var info_tP = $('.infoPrincipal *');
	var reseteP = $('#resetePrincipal');
	var div_botonesP = $('.botonesPrincipal');
	var paginacionesP = $('.paginacionPrincipal');
	var cabeceraP = $('#cabecera_tBusquedaPrincipal');
	
	//$('#ocultarFP').hide();
	
	//if($('.filtro1Principal input').val() ==''){ div_botonesP.hide(); $('#ocultarFP').hide();
	//}else{ div_botonesP.show(); $('#ocultarFP').show(); }
	
	paginacionesP.hide();
	
	search_boxP.focus();
	
	/*search_boxP.keyup(function(e) {
    	if( $(this).val() == '' ){ $('#filtro').val('YO SOLO SE QUE NO SE NADA'); $('#ocultarFP').hide(); div_botonesP.hide(); oTableP.fnDraw();
		}else { $('#filtro').val('%%'); $('#ocultarFP').show(); div_botonesP.show(); oTableP.fnDraw(); }
    });*/
		
	$('#clickme').click(function(e) { oTableP.fnDraw(); });

});
</script>