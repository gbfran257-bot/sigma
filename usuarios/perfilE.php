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
<title>USUARIOS</title>

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
<script type="text/javascript" src="imagenes/ajaxupload.js"></script>
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
	$('#changeContra').click(function(event) { event.preventDefault(); });
	$('#changeContra').button({ icons: { primary: "ui-icon-disk" }, text: true });
	
	$('#tablaPrincipal').css('width',$('#referencia').width()-20).css('height',$('#referencia').height()-60);
	
	//esto va despues de la función que carga la ficha del paciente
	$( window ).resize(function(e) {
        var cx = ($(window).width() - ($('.miUsuario').offset().left)) - ($('#misDatosUsuario').width()*0.75);
		var cy = $('#header table').height();
	
		misDatosUsuario.css('right',cx).css('top',cy);
		
		var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - 160;
		var wi = $('#referencia').width() * 0.96;
    });
	$('.miTab').css('height', $('#referencia').height() - 100).css('width',$('#referencia').width()-0);
	$('.tabs').css('width',wi/7.2);
	$('#formGenerales').validate({ ignore: 'hidden', focusCleanup: true,
		rules:{
			claveUsuario:{ required:true, remote:{ url: 'files-serverside/checkClaveUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { clave:function(){ return $('#claveUsuario').val(); } } }, minlength: 4 },
			username:{ required:true, remote:{ url: 'files-serverside/checkUserUsuario.php?idU='+$('#idPacienteN').val(), type: "post", data: { user:function(){ return $('#username').val(); } } }, minlength: 4 },
			cNueva: {
				required:true, minlength: 6
			},
			cNueva1: {
			  equalTo: "#cNueva", minlength: 6
			}
		},
		messages:{
			claveUsuario:{ required: 'SE DEBE DE INGRESAR EL IDENTIFICADOR DEL USUARIO.', remote:'ESTE IDENTIFICADOR YA ESTA EN USO, FAVOR DE INTENTAR CON OTRO', minlength:'EL IDENTIFICADOR CONSTA DE 4 CARACTERES' },
			username:{ required: 'SE DEBE DE INGRESAR EL NOMBRE DE USUARIO.', remote:'ESTE NOMBRE DE USUARIO YA ESTA EN USO, FAVOR DE INTENTAR CON OTRO', minlength:'EL NOMBRE DE USUARIO CONSTA DE MÍNIMO 4 CARACTERES' }
		}
	});
	var he = $('#referencia').height() - $('#header').height() - $('#footer').height() - 160;
	var wi = $('#referencia').width() * 0.96;
	$("#miPestanas").tabs({active: 0});
	
	$('.miTab').css('height', $('#tablaPrincipal').height() - 75).css('width',$('#tablaPrincipal').width()-40);
	$('.tabs').css('width',wi/7.2);
	$('#miPestanas').css('border-style','none');
	$('#pestanas').removeClass('ui-widget-header');
	$('#formGenerales input, #formGenerales select, #formGenerales textarea').addClass('campoITtab');
	$('#fnacP').datepicker({
		changeMonth: true, changeMonth: true, nextText: "Siguiente", prevText: "Anterior", showAnim : "slideDown", changeYear: true, maxDate: +0, minDate: -43800, dateFormat: "dd/mm/yy",
		dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
		monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septimbre", "Octubre", "Noviembre", "Diciembre" ],
		monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"] //"onSelect": function(date) { $('#edadP').val(calcular_edad(date)); }
	}).css('text-align','center');
	$("#sexoP").load('files-serverside/genera_sexos.php');
	$("#sucursalP").load('files-serverside/genera_sucursales.php?idS='+$('#sucursalU').val());
	$("#tsanguineoP").load('files-serverside/genera_tsangre.php');
	$("#especialidadU").load('files-serverside/genera_especialidades.php');
	$("#estadoP").load('files-serverside/genera_estados.php', function( response, status, xhr ) {
	  if ( status == "success" ) { 
		$("#estadoP").change(function(event){
			var id = $("#estadoP").find(':selected').text();//alert(id);
			$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(id),function( response, status, xhr ) {
				  if ( status == "success" ) { 
					if ($("#estadoP").val()==''){
						var id1x = $("#estadoP").find(':selected').text();
						var idx = $("#municipioP").find(':selected').text();
						var id3 = $("#coloniaP").find(':selected').text();
						$("#coloniaP").load('files-serverside/genera_colonias.php?idM='+escape(idx)+'&idE='+escape(id1x));
						$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(id3)+'&idE='+escape(id1x)+'&idM='+escape(idx));
					}
				  }
			});
		});
	  }
	});
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
		var idC=$("#coloniaP").find(':selected').text(),idE=$("#estadoP").find(':selected').text();
		var idM=$("#municipioP").find(':selected').text();
		$("#cpP").load('files-serverside/genera_cp.php?idC='+escape(idC)+'&idE='+escape(idE)+'&idM='+escape(idM));
	});
	
	$('#ocupacionP').keyup(function(e) {
		var y=$(this).val();
		var b="files-serverside/genera_ocupaciones.php?ocupacion="+y;
		$( "#ocupacionP" ).autocomplete({
			source: b,
			minLength: 2
		}); 
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
	
	$('#usuarioForaneo').click(function(e){if($(this).prop('checked')==true){$('#usuarioF').val(1);}else{$('#usuarioF').val(0);} });
	$('#horarioDe').timepicker({
		currentText: 'Ahora',
		closeText: 'Ok',
		timeOnlyTitle: 'Escoge la Hora',
		timeText: 'Hora',
		hourText: 'Horas',
		minuteText: 'Minutos'
	});
	$('#horarioDe').css('text-align','center');
	$('#horarioA').timepicker({
		currentText: 'Ahora',
		closeText: 'Ok',
		timeOnlyTitle: 'Escoge la Hora',
		timeText: 'Hora',
		hourText: 'Horas',
		minuteText: 'Minutos'
	});
	$('#horarioA').css('text-align','center');
	$('#profesionUsuario').keyup(function(e) {
		var x=$(this).val();
		var a="files-serverside/catProfesiones.php?profesion="+x;
	   $('#profesionUsuario').autocomplete({
			source: a,
			minLength: 2
		}); 
	});//Fin de las inicializaciones de los campos de la ficha del usuario
	
	var cuadrado = 20;
	$('button').css('min-width',cuadrado).css('min-height',cuadrado);
	$('#addConvenio').button({ icons: { primary: "ui-icon-plusthick" }, text: false });
	
	$('form').submit(function(event) { event.preventDefault(); });
	$('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Agregar fotografía" });
	$('#upload').click(function(event) { event.preventDefault(); });
	
	var x = $('#idUser').val();
	$('#nombreFotoT').val('');
	$('#idPacienteN').val(x);//asignamos el id del U a la variable para saber cual paciente actualizar por su id
	var datos ={idP:x}
	$.post('files-serverside/fichaUsuario.php',datos).done(function( data1 ) {
		if (data1 != "ok"){
			var datosI = data1.split('*}');
			$('.idUsuarioP').val($('#idUsuario').val());$('.uActivo').hide();
			if(datosI[42]==1){//Si el usuario tiene fotografía //Si el usuario tiene fotografía, entonces la carga // Listar  fotos que hay en mi tabla
				photoSi(datosI[44],datosI[43],x);
			}else{//Si el paciente NO tiene fotografía
				var now = new Date().getTime(); var d = new Date(); 
				photoNo(datosI[44],d.format('Y-m-d-H-i-s-u').substring(0,22),x);
			}
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
			$("#tipoUsuario").load('genera/tipos_usuario.php', function( response, status, xhr ) { 
				if ( status == "success" ) { $('#tipoUsuario').val(datosI[22]); } 
			});
			$('#nombreP').val(datosI[0]);$('#apaternoP').val(datosI[1]);$('#amaternoP').val(datosI[2]);$("#sexoP").val(datosI[16]);$("#nacionalidadP").val(datosI[26]);$("#fnacP").val(datosI[17]);$('#curpP').val(datosI[6]);
			$('#rfcP').val(datosI[13]);$('#sucursalP').val(datosI[14]);$('#claveUsuario').val(datosI[3]);$('#tipoUsuario').val(datosI[22]);$('#username').val(datosI[21]);$('#notasP').val(datosI[19]);$('#telmovilP').val(datosI[7]);
			if (datosI[38] == 1){$('#usuarioForaneo').prop('checked',true);$('#usuarioF').val(1);}else{$('#usuarioForaneo').prop('checked',false);$('#usuarioF').val(0);}
			//Datos de dirección
			$('#estadoP').val(datosI[34]);var idB = $("#estadoP").find(':selected').text();
			$("#municipioP").load('files-serverside/genera_municipios.php?id='+escape(idB), function( response, status, xhr ) {
				if ( status == "success" ) { 
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
			$('#cedulaU1').val(datosI[30]);
			
			$('#claveUsuario').prop('disabled',true);$('#iconoClaveUsuario').addClass('ui-icon ui-icon-check');
			$('#textoClaveUsuarioDisponible').text('Disponible');$('#textoClaveUsuarioDisponible').addClass('textoAceptable');
			$('#username').prop('disabled',true);$('#iconoUsuario').addClass('ui-icon ui-icon-check');
			$('#textoUsuarioDisponible').text('Disponible');$('#textoUsuarioDisponible').addClass('textoAceptable');

		}else{alert(data);}
	});
	
});
function verMenu(){
	$(document).ready(function(e) {
        $('#miMenu').show('fold','slow');
		$('#verMenu').replaceWith('<span onClick="ocultarMenu()" id="verMenu" style="cursor:pointer;">USUARIOS</span>');
    });
}
function ocultarMenu(){
	$(document).ready(function(e) {
        $('#miMenu').hide('fold','slow');
		$('#verMenu').replaceWith('<span onClick="verMenu()" id="verMenu" style="cursor:pointer;">USUARIOS</span>');
    });
}
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

</head>

<body>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; border: 1px solid red; z-index:1000000000000000000000;"></div>

<input name="idUser" type="hidden" id="idUser" value="<?php echo $row_usuario['id_u']; ?>">
<input name="accesoU" type="hidden" id="accesoU" value="<?php echo $row_usuario['acceso_u']; ?>">
<input name="sucursalU" type="hidden" id="sucursalU" value="<?php echo $row_usuario['idSucursal_u']; ?>">

<div id="header" class="header" style="display:;">
    <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" class="iconito"><img src="../imagenes/iconitos/_iconoUsuarios.png" height="50"></td>
        <td align="left" valign="middle"><span id="verMenu" style="cursor:pointer;">USUARIOS</span></td>
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
    <table width="100%" border="0" cellspacing="2" cellpadding="">
        <tr>
            <td>
            <?php if($row_usuario['foto_u'] == 1){?>
                <img class="fotoUsuario" id="miFotoUsuarioMini" src="../usuarios/imagenes/perfil/<?php echo $row_usuario['nombreFoto_u']; ?>" width="80">
            <?php }else{?>
                <img class="fotoUsuario" id="miFotoUsuario" src="../usuarios/takePicture/fotografiasPerfil/<?php if($row_usuario['sexo_u'] == 1){echo 'm';}else{echo 'h';} ?>.jpg" width="80">
            <?php }?>
            </td>
            <td align="center"><?php echo $row_usuario['nombre_u']." ".$row_usuario['apaterno_u']." ".$row_usuario['amaterno_u']; ?> <br> <span style="font-size:0.7em">(<?php echo $row_usuario['idPuesto_u']; ?>)</span></td>
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

<div id="miMenu" class="miMenu" align="center">
<table width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" class="">
  <tr valign="middle" align="center">
    <td class="eii"><img title="Menú anterior" src="../imagenes/submenu/_asociados.png" width="90" onClick="window.location='../menu_asociados_medicos.php'"></td>
    <td class="eid"><img title="INICIO" src="../imagenes/submenu/_inicio.png" width="100" onClick="window.location='../menu.php'"></td>
  </tr>
</table>
</div>

<div class="contenido" id="contenido" align="center" id="">
<table id="tablaPrincipal"width=""height=""border="0" cellpadding="2" cellspacing="0" style="border:1px none aqua; padding-top:6px;">
<tbody> <tr> <td id="miPestanas">
    <table width="100%" border="0" cellspacing="0" cellpadding="2" id="">
  <tr>
    <td id="">
    <ul id="pestanas" style="font-size:0.9em;">
        <li><a class="tabs" id="tabs-1-1" href="#tabs-1" style="color:; background-color:#FF6600;">GENERALES</a></li>
        <li><a class="tabs" id="tabs-2-1" href="#tabs-2" style="color:; background-color:#008F4C;">DIRECCIÓN</a></li>
        <li><a class="tabs" id="tabs-3-1" href="#tabs-3" style="color:; background-color:#0071BC;">CONTACTO</a></li>
        <li><a class="tabs" id="tabs-4-1" href="#tabs-4" style="color:; background-color:#AA0000;">ADICIONALES</a></li>
        <li><a class="tabs" id="tabs-4-1" href="#tabs-5" style="color:; background-color:#DB7093;">CONTRASEÑA</a></li>
      </ul>
    </td>
  </tr>
</table>

 <input name="nombreFotoT" id="nombreFotoT" type="hidden" value=""> <input name="hayFoto" id="hayFoto" type="hidden" value="0">
 <input name="idPacienteN" type="hidden" id="idPacienteN">
 
 <form action="" method="post" name="formGenerales" id="formGenerales" target="_self">
  <div class="miTab" id="tabs-1" style="font-size:0.8em;">
  	<span class="summary"></span>
    <input name="idUsuarioP" id="idUsuarioP" class="idUsuarioP" type="hidden" value="">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4" style="background-color:rgba(255,102,0,0.5); border:2px solid rgba(255,102,0,1);">
      <tr>
        <td width="75%" align="left" valign="top">
            <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
              <tr align="left" valign="bottom">
                <td class="titulosTabs" width="33.3%">NOMBRE(S) *</td>
                <td class="titulosTabs" width="33.3%">A.PATERNO *</td>
                <td class="titulosTabs">A.MATERNO</td>
              </tr>
              <tr valign="top">
                <td><input name="nombreP" id="nombreP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value="" disabled></td>
                <td><input name="apaternoP" id="apaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" class="required" value="" disabled></td>
                <td><input name="amaternoP" id="amaternoP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" value="" disabled></td>
              </tr>
            </table>
        </td>
        <td style="border:1px none red;" rowspan="6" valign="top">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr height="40px">
                <td><button id="upload">Agregar fotografía</button></td>
              </tr>
              <tr>
                <td valign="top" style="border:1px none gold;" id="miFotito">
                	<ul id="gallery" style="border:1px none red; text-align:center;"> <!-- Cargar Fotos --> </ul>
                </td>
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td style="border:1px none blue;">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr align="left">
                <td class="titulosTabs" width="33.3%">SEXO *</td>
                <td class="titulosTabs" width="33.3%">NACIONALIDAD *</td>
                <td class="titulosTabs">FECHA DE NACIMIENTO *</td>
              </tr>
              <tr>
                <td><select name="sexoP" id="sexoP" class="required" disabled></select></td>
                <td><input name="nacionalidadP" id="nacionalidadP" type="text" value="MEXICANA" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" disabled></td>
                <td><input name="fnacP" id="fnacP" type="text" placeholder="DD/MM/AAAA" class="required" disabled></td>
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left">
            <td class="titulosTabs" width="33.3%">CURP</td>
            <td class="titulosTabs" width="17%" align="center">RFC</td>
            <td class="titulosTabs" width="">SUCURSAL</td>
          </tr>
          <tr>
            <td><input name="curpP" type="text" id="curpP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="18" disabled></td>
            <td><input name="rfcP" type="text" id="rfcP" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" maxlength="13" disabled></td>
            <td><select name="sucursalP" id="sucursalP" class="required" disabled></select></td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left">
            <td class="titulosTabs" width="50%"><span title="El tipo de acceso que tendrá el usuario en el sistema">TIPO DE USUARIO *</span></td>
            <td class="titulosTabs"><span title="El nombre de usuario que se utilizará para firmarse y entrar al sistema. Por defaul al crear un usuario su contraseña será la misma que el nommbre de usuario.">NOMBRE DE USUARIO *</span></td>
          </tr>
          <tr>
            <td>
            <select name="tipoUsuario" id="tipoUsuario" class="required" disabled> </select>
            </td>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td><input name="username" id="username" type="text" maxlength="8" onKeyUp="conMayusculas(this); nick(this.value, this.name);" class="required" disabled></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
      <tr>
        <td>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr align="left">
            <td class="titulosTabs">NOTAS</td>
            <td class="titulosTabs" width="33.3%">TELÉFONO CELULAR</td>
          </tr>
          <tr>
            <td>
            <textarea name="notasP" id="notasP" cols="" rows="" style="resize:none;" onKeyUp="conMayusculas(this);" disabled></textarea>
            </td>
            <td>
            <span id="sprytextfield1">
            <input name="telmovilP" id="telmovilP" type="text" maxlength="15" disabled>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            </td>
          </tr>
        </table>
        </td>
        <!--<td></td> -->
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-2" style="font-size:0.8em;">
  	<span class="summary"></span>
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:rgba(0,143,76,0.5); border:2px solid rgba(0,143,76,1);">
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr valign="bottom">
            <td class="titulosTabs">ESTADO</td>
          </tr>
          <tr>
            <td valign="top"><select name="estadoP" id="estadoP" class="required" disabled></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr valign="bottom">
            <td class="titulosTabs">MUNICIPIO</td>
          </tr>
          <tr>
            <td valign="top"><select name="municipioP" id="municipioP" class="required" disabled></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="titulosTabs" valign="bottom">COLONIA</td>
          </tr>
          <tr>
            <td valign="top"><select name="coloniaP" id="coloniaP" disabled></select></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr valign="bottom">
            <td class="titulosTabs">CALLE</td>
          </tr>
          <tr>
            <td valign="top"><input name="calleP" id="calleP" type="text" onKeyUp="conMayusculas(this);" disabled></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="33.3%">
            	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr valign="bottom">
                    <td class="titulosTabs">NÚMERO EXT</td>
                  </tr>
                  <tr>
                    <td valign="top"><input name="noExtP" id="noExtP" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" disabled></td>
                  </tr>
                </table>
            </td>
            <td width="33.3%">
            	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr valign="bottom">
                    <td class="titulosTabs">NÚMERO INT</td>
                  </tr>
                  <tr>
                    <td valign="top"><input name="noIntP" id="noIntP" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" disabled></td>
                  </tr>
                </table>
            </td>
            <td>
            	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr valign="bottom">
                    <td class="titulosTabs">C.P.</td>
                  </tr>
                  <tr>
                    <td valign="top"><select name="cpP" id="cpP" disabled></select></td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-3" style="font-size:0.8em;">
  	<span class="summary"></span>
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:rgba(0,113,188,0.5); border:2px solid rgba(0,113,188,1);">
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
          	<td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs" width="35%">TELÉFONO PARTICULAR</td>
              </tr>
              <tr>
                <td valign="top">
                <span id="sprytextfield2">
            <input name="telparticularP" id="telparticularP" type="text" maxlength="15" disabled>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                </td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs" width="35%">TELÉFONO DE TRABAJO</td>
              </tr>
              <tr>
                <td valign="top">
                <span id="sprytextfield3">
            <input name="telefonoTrabajoP" id="telefonoTrabajoP" type="text" maxlength="15" disabled>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                </td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">EXTENSIÓN</td>
              </tr>
              <tr>
                <td valign="top">
                <input name="extensionTelTraP" type="text" id="extensionTelTraP" onKeyUp="telefono(this.value, this.name);" maxlength="5" disabled>
                </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr valign="bottom">
            <td class="titulosTabs">CONTACTO DE EMERGENCIA</td>
          </tr>
          <tr>
            <td valign="top"><input name="avisarP" id="avisarP" type="text" onKeyUp="conMayusculas(this); solo_letras_numeros(this.value, this.name);" disabled></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr valign="bottom">
            <td class="titulosTabs">TELÉFONO DE EMERGENCIA</td>
          </tr>
          <tr>
            <td valign="top">
            <span id="sprytextfield4">
            <input name="telefonoEmergenciaP" id="telefonoEmergenciaP" type="text" maxlength="15" disabled>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr valign="bottom">
            <td class="titulosTabs">EMAIL</td>
          </tr>
          <tr>
            <td valign="top">
            <input class="email" disabled name="emailP" id="emailP" type="text" onKeyUp="conMinusculas(this);">
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>

  <div class="miTab" id="tabs-4" style="font-size:0.8em;">
  	<span class="summary"></span>
  	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style="background-color:rgba(170,0,0,0.5); border:2px solid rgba(170,0,0,1);">
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="33.3%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">DEPARTAMENTO</td>
              </tr>
              <tr>
                <td valign="top"><select name="departamentoU" id="departamentoU" class="required" disabled></select></td>
              </tr>
            </table>
            </td>
            <td width="33.3%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">ÁREA</td>
              </tr>
              <tr>
                <td valign="top"><select name="areaU" id="areaU" class="required" disabled></select></td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">PUESTO</td>
              </tr>
              <tr>
                <td valign="top"><select name="puestoU" id="puestoU" class="required" disabled></select></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="33.3%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">HORARIO DE ENTRADA</td>
              </tr>
              <tr>
                <td valign="top"><input name="horarioDe" id="horarioDe" type="text" readonly value="08:00" disabled></td>
              </tr>
            </table>
            </td>
            <td width="33.3%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">HORARIO DE SALIDA</td>
              </tr>
              <tr>
                <td valign="top"><input name="horarioA" id="horarioA" type="text" readonly value="18:00" disabled></td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">ESCOLARIDAD</td>
              </tr>
              <tr>
                <td valign="top"><select name="escolaridadP" id="escolaridadP" disabled ></select></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left" class="profesional">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="25%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">PROFESIÓN</td>
              </tr>
              <tr>
                <td valign="top"><input name="profesionUsuario" id="profesionUsuario" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" disabled></td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">CÉDULA PROFESIONAL</td>
              </tr>
              <tr>
                <td valign="top"><input name="cedulaU" id="cedulaU" type="text" onKeyUp="conMayusculas(this); nick(this.value, this.name);" disabled></td>
              </tr>
            </table>
            </td>
            <td width="25%">
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">ESPECIALIDAD</td>
              </tr>
              <tr>
                <td valign="top">
                <select name="especialidadU" id="especialidadU" disabled></select>
                </td>
              </tr>
            </table>
            </td>
            <td>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="bottom">
                <td class="titulosTabs">CÉDULA PROFESIONAL ESPECIALIDAD</td>
              </tr>
              <tr>
                <td valign="top"><input name="cedulaU1" id="cedulaU1" type="text" onKeyUp="conMayusculas(this); nick(this.value, this.name);" disabled></td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr align="left">
        <td>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
          <tr valign="bottom">
            <td class="titulosTabs">OCUPACIÓN</td>
            <td class="titulosTabs" width="33.3%">TIPO SANGUÍNEO</td>
          </tr>
          <tr>
            <td valign="top"><input name="ocupacionP" id="ocupacionP" type="text" onKeyUp="conMayusculas(this); solo_letras(this.value, this.name);" disabled></td>
            <td valign="top"><select name="tsanguineoP" id="tsanguineoP" disabled></select></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="miTab" id="tabs-5" style="font-size:0.8em;">
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="6" style="background-color:rgba(219,112,147,0.5); border:2px solid rgba(219,112,147,1);">
      <tr>
        <td colspan="2" align="left" class="titulosTabs">PARA CAMBIAR LA CONTRASEÑA INDIQUE LOS SIGUIENTES DATOS</td>
      </tr>
      <tr>
        <td align="right" class="titulosTabs" width="50%">CONTRASEÑA ACTUAL</td>
        <td>
        <input name="cActual"type="password" class="required" id="cActual" maxlength="10" style="max-width:300px; min-width:100px;" onKeyUp="conMayusculas(this); nick(this.value, this.name);">
        <span id="errorC" style="display:block; font-size:0.9em; color:red">LA CONTRASEÑA ES INCORRECTA</span>
        </td>
      </tr>
      <tr>
        <td align="right" class="titulosTabs">NUEVA CONTRASEÑA</td>
        <td>
        <input name="cNueva" id="cNueva" class="required" type="text" maxlength="10" style="max-width:300px; min-width:100px;"onKeyUp="conMayusculas(this); nick(this.value, this.name);">
        </td>
      </tr>
       <tr>
        <td align="right" class="titulosTabs">CONFIRMAR NUEVA CONTRASEÑA</td>
        <td>
        <input name="cNueva1" id="cNueva1" class="required" type="text" maxlength="10" style="max-width:300px; min-width:100px;" onKeyUp="conMayusculas(this); nick(this.value, this.name);">
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
        <button id="changeContra">Cambiar</button>
        </td>
      </tr>
  </table>
  </div>
  </form>
 
</td> </tr> </tbody>
</table>
</div>

<div id="dialog-confirmar" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td id="miTextoC">&nbsp;</td>
  </tr>
</table>
</div>

<div class="footer" id="footer" style="display:none;"> <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" valign="middle"> &copy; HORIZONTE MÉDICA <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS.</td> </tr> </table> </div>

<input name="filtro" id="filtro" type="hidden" value="YO SOLO SE QUE NO SE NADA">
</body>
</html>

<?php
mysql_free_result($usuario);
mysql_free_result($nombreSucursalUsuario);
mysql_free_result($nombreDepartamentoUsuario);
?>
<script>
$(document).ready(function(e) { $('#errorC').hide();
 $('#changeContra').click(function(e) {
 	if($('#cActual').valid() & $('#cNueva').valid() & $('#cNueva1').valid()){
		var idU = { id:$('#idUser').val(), cA:$('#cActual').val(), cNueva:$('#cNueva').val() }
		$.post('files-serverside/datosContraUsuario.php',idU).done(function( data ) {
			if(data == 1){//La contraseña se actualizó correctamente
				$('#errorC').hide();
				$('#miTextoC').text('La contraseña se ha actualizado correctamente');
				$('#dialog-confirmar').dialog({
					autoOpen: true, modal: true, width: 620, height:150, title: 'CONTRASEÑA ACTUALIZADA', closeText: '',
					open:function( event, ui ){ window.setTimeout(function(){$('#dialog-confirmar').dialog('close');},2500); },
					close:function( event, ui ){ document.getElementById('formGenerales').reset();	 }
				});
			}else if (data == 0){//las contraseñas no coinciden
				$('#errorC').hide().show('shake').text('LA CONTRASEÑA ES INCORRECTA');
			}else if (data == 'x'){//las contraseñas no coinciden
				$('#errorC').hide().show('shake').text('LAS CONTRASEÑA ANTERIOR Y LA NUEVA CONTRASEÑA DEBEN SER DISTINTAS');
			}
			else{//ocurrió un error en la DB y no se guardó la consulta
				$('#errorC').hide().show('shake').text('OCURRIO UN ERROR INESPERADO, VUELVA A INTENTARLO');
			}
		});
	}
 });
});
function SubirPhoto(a,b){//si el paciente cuenta con fotografía. A es el id del paciente, b es el nombre que tiene la fotografía y x es de nuevo el id del paciente
	$(document).ready(function(e) { //alert('cargar foto, el id del paciente es '+a+' el nombre del archivo de la foto es '+b); //Todo el pedo de la fotografía del perfil
		var button = $('#upload'), interval;
		new AjaxUpload(button,{
			action: 'imagenes/procesa.php?action='+b+'&idP='+a, 
			name: 'image',
			onChange : function(file, ext){
				if(openFile(file)==0){//si el archivo no es una imagen
					$('#upload').button({ icons: { primary: "ui-icon-alert" }, text: true, label: "Archivo no válido" });
					return false; //se cancela
				}
			},
			onSubmit : function(file, ext){//alert('Procesa en ver paciente agregar foto si no existe foto'); // cambiar el texto del boton cuando se selecicione la imagen		
				button.text('Subiendo');//alert(a+';2');alert(a+'_'+b);
				interval = window.setInterval(function(){
					var text = button.text();
					if (text.length < 11){
						button.text(text + '.');					
					} else {
						button.text('Subiendo');				
					}
				}, 200);
			},
			onComplete: function(file, response){//alert(file);
				$('#upload').button({ icons: { primary: "ui-icon-image" }, text: true, label: "Cambiar la fotografía" }).hide();
				$('#hayFoto').val(1); //$('#gallery .eliminame').parent().parent().parent().show();		
				window.clearInterval(interval);
				var xa= a, xb = b+'.jpg', xc = a;//alert(xa+'----'+xb);
				return photoSi(xa,xb,a);
			}
		});return;
    });
}
function photoSi(a,b,x){//si el paciente cuenta con fotografía. A es el id del paciente, b es el nombre que tiene la fotografía y x es de nuevo el id del paciente
	$(document).ready(function(e) { //alert('Si hay foto, el id del paciente es '+a+' el nombre del archivo de la foto es '+b+' de nuevo el id del paciente es '+x); //Todo el pedo de la fotografía del perfil
		$('#upload').hide(); //alert('hay foto y el id del paciente es '+datosI[39]);
		return cargarPhoto(a,b);//Cargamos la foto
    });
}
function photoNo(a,b,x){//si el paciente NO cuenta con fotografía. A es el id del paciente, b es el nombre que va tomar la fotografía y x es de nuevo el id del paciente
	$(document).ready(function(e) { //alert('No hay foto, el id del paciente es '+a+' el nombre del archivo de la foto es '+b+' de nuevo el id del paciente es '+x); //Todo el pedo de la fotografía del perfil
		$("#gallery").html('');
		$('#upload').button({
		  icons: { primary: "ui-icon-image" },
		  text: true, label: "Agregar fotografía"
		}).show();//alert('no hay foto y el id del paciente es '+datosI[39]);
		return SubirPhoto(a,b);
    });
}
function cargarPhoto(a,b){//a es el id del paciente y b es el nombre de la foto
$(document).ready(function(e) {//alert(b);
    $("#gallery").load("imagenes/procesa.php?action=listFotos&idPac="+a, function( response, status, xhr ) { 
		if ( status == "success" ) { 
			$('#gallery .eliminame1').click(function(e) {
				return eliminarPhoto(a,b);
			});
		}
	});return;
});
}
function eliminarPhoto(a,b){//a es el id del paciente y b es el nombre de la foto
$(document).ready(function(e) {
	var a1 = $('#gallery .eliminame1'); //alert(a.attr('name'));	
	$.get("imagenes/procesa.php?action=eliminar1",{idP:a, nombreF:b},function(){//alert('Procesa en ver paciente eliminar foto existente');
		a1.parent().fadeOut("slow"); //alert(a.attr('name'));//alert(x+'5');
		$('#upload').button({
		  icons: { primary: "ui-icon-image" },
		  text: true, label: "Agregar fotografía"
		}).show();
		$('#hayFoto').val(0); $('#nombreFotoT').val(''); $('#idPacienteN').val(''); $('#idPacienteN').val(a);
		var now = new Date().getTime(); var d = new Date();
		return photoNo(a,d.format('Y-m-d-H-i-s-u').substring(0,22),a);
	});
});
}
</script>