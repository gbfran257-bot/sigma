<?php if (!isset($_SESSION)) { session_start(); }?>
<?php require_once('Connections/horizonte.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
	  $theValue=function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
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
?>
<?php
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) { $_SESSION['PrevUrl'] = $_GET['accesscheck']; }
if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['contrasena'];
  $MM_fldUserAuthorization = "acceso_u";
  $MM_redirectLoginSuccess = "menu.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_horizonte, $horizonte);
  	
  $LoginRS__query=sprintf("SELECT usuario_u, contrasena_u, acceso_u FROM usuarios WHERE usuario_u=%s AND contrasena_u=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $horizonte) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    $loginStrGroup  = mysql_result($LoginRS,0,'acceso_u');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) { $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	}
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else { header("Location: ". $MM_redirectLoginFailed ); }
}
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="imagenes/favicon.ico">
<meta charset="utf-8">
<title>INICIAR SESIÓN</title>

<link href="css/plantilla.css" rel="stylesheet" type="text/css">
<link href="css/index.css" rel="stylesheet" type="text/css">
<link href="jquery-ui-1.12.0/jquery-ui.min.css" rel="stylesheet">
<script src="jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="jquery-ui-1.12.0/jquery-ui.min.js"></script>
<script src="jquery-validation-1.9.0/jquery.validate.js"></script>
<script src="funciones/js/caracteres.js"></script>

<script>
//para las tooltips
$(document).tooltip({ position: { my: "center bottom-20",	at: "center top", using: function( position, feedback ) { $( this ).css( position ); $( "<div>" ).addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this ); } } });

$(document).ready(function() { //$('#usuario').focus();
	
	$('#form1').validate({//valida el formulario
		onfocusout: false, onkeyup: false,
		rules:{
			usuario:{ "remote": { url: 'remote_files/checkUser.php', type: "post", data: { usuario:function() { return $('#usuario').val(); } } }, required:true, minlength:4 },
			contrasena:{ required:true, minlength:4, "remote": { url: 'remote_files/checkContrasena.php?usuario='+escape($('#usuario').val()), type: "post", data: { contrasena:function() { return $('#contrasena').val(); }, user:function() { return $('#usuario').val(); } } } }
		},//fin reglas
		messages:{
			usuario:{ required:"DEBE INGRESAR EL NOMBRE DE USUARIO.", minlength:"4 DÍGITOS POR LO MENOS.", remote:'EL NOMBRE DE USUARIO NO EXISTE.' },//fin mensajes de user
			contrasena:{ required:"DEBE INGRESAR LA CONTRASEÑA.", minlength:"4 DÍGITOS POR LO MENOS.", remote:'NO SE RECONOCE LA COMBINACIÓN USUARIO/CONTRASEÑA.' }//fin de mensajes de psw
		}//fin mensajes
	});//fin validacion formx
	
	$('#dialog-confirmarContra').dialog({ 
		autoOpen:false, modal:true, width:650, height:300, closeOnEscape: false, dialogClass: 'no-close', 
		title:'LA CONTRASEÑA SE HA ENVIADO A TU EMAIL',
		open: function( event, ui ) {$("#dialog-recuperarContra").dialog('close');},
		close: function( event, ui ) { }, buttons:{ Cerrar:function(){ $("#dialog-confirmarContra").dialog('close'); } }
	});
	$('#dialog-confirmacion').dialog({ 
		autoOpen:false, modal:true, width:650, height:300, closeOnEscape: false, dialogClass: 'no-close', 
		title:'CONFIGURACIÓN REALIZADA',
		open: function( event, ui ) {$("#dialog-nuevoU").dialog('close');},
		close: function( event, ui ) { }, buttons:{ Continuar:function(){ $('#form1').submit(); } }
	});
	
	$('#entrar').click(function(e) {
		if( $('#form1').valid() ){ 
			//checamos si el usuario es nuevo, si es nuevo abre pestaña para que configure su contraseña y verifique su email
			var datosL = $('#form1').serialize();
			$.post('remote_files/usuarioNuevo.php', datosL).done(function( data ) {
				var datos = data.split(';');
				if(datos[0]==1){//Se abre la ventana para configurar la nueva contraseña del usuario y verificar su email
					//alert(datos[2]);
					crearVNU($('#usuario').val(), escape(datos[1]), datos[2], datos[3]);
				}else{ $('#form1').submit(); /*Se loguea al usuario normalmente*/ }
			});
		}else{}
	});
	
	$('#entrar').mouseover(function(e) { 
		$('#entrar span').removeClass('ui-icon-locked'); $('#entrar span').addClass('ui-icon-unlocked'); 
	});
	$('#entrar').mouseleave(function(e) { 
		$('#entrar span').removeClass('ui-icon-unlocked'); $('#entrar span').addClass('ui-icon-locked'); 
	});
	
	var xh = $('#referencia').height();$('#logo').css('max-width',$('#referencia').width()*0.45);
	$('#contenido').css('height',xh);
	
	$( window ).resize(function() {
		var xh = $('#referencia').height();$('#logo').css('max-width',$('#referencia').width()*0.45);
	  	$('#contenido').css('height',xh);
		$('#tablaAcceso').css('width', $('#logo').width()*0.9);
	});
	
	$('#logo').css('max-width',$('#referencia').width()*0.45);
	
	$("#dialog-nuevoU").dialog({
		autoOpen:false,modal:true,width:800,height:530,closeOnEscape:false,dialogClass:'no-close',title:'PRIMER INICIO DE SESIÓN',
		open: function( event, ui ) { },
		close: function( event, ui ) { document.getElementById('formNuevoU').reset();},
		buttons:{
			Continuar:function(){
				if($('#formNuevoU').valid()){
					var datosNU = $('#formNuevoU').serialize();
					$.post('remote_files/configuracionNU.php', datosNU).done(function( data ) {
						if(data ==1){
							//Si los datos se actualizaron abre una ventana de configuración:
							$('#contrasena').val($('#contrasenaNU').val());
							$("#dialog-confirmacion").dialog('open');
						}else{alert(data);}
					});
				}
			},
			Cancelar:function(){$("#dialog-nuevoU").dialog('close');}
		}
	});
	
});
</script>

</head>
<body>

<div id="dialog-nuevoU" style="display:none; overflow:hidden;"></div>

<div id="dialog-recuperarContra" style="display:none; overflow:hidden;"></div>

<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<div class="contenido" id="contenido" align="center">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
  <tr height="50px" bgcolor="#000000">
  <td colspan="2"></td>
  </tr>
  <tr>
    <td>
    <form style="height:100%;" name="form1" id="form1" method="POST" action="<?php echo $loginFormAction; ?>">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4" id="tablaI">
      <tr height="45%" class="row1I">
      	<td width="50%" rowspan=""> </td>
        <td align="center" valign="bottom"><br>
        	<span style="display:block; color:#9c9d9f; text-align:center; font-size:3em;">Te damos la bienvenida</span>
        	<img id="logo" src="imagenes/empresa/sigma_logo.png">
            <!--<img id="logo" src="imagenes/empresa/logo_cerebro.png" width="" height=""> -->
        </td>
      </tr>
      <tr height="35%">
      	<td width="50%"> </td>
        <td valign="middle">
        <table width="100%" height="" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td class="celda_relleno" width="45%"></td>
            <td style="max-width:250px;min-width:250px;" nowrap>
            <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="">
                <input name="usuario" type="text" class="campoDatosTabla" id="usuario" onKeyUp="conMayusculas(this); nick(this.value, this.name);" maxlength="12" placeholder="Usuario" style="text-align:left;" style="color:black;" autofocus>
                <span id="content" class="error_usuario"></span>
                </td>
              </tr>
              <tr>
                <td align="">
                <input name="contrasena" class="campoDatosTabla" type="password" maxlength="10" id="contrasena" placeholder="Contraseña" style="text-align:left;" style="color:black;">
                <span id="content1" class="error_usuario"></span>
                </td>
              </tr>
              <tr style="display:none;">
                <td nowrap align="right">
                	<span class="olvidasteC" onClick="recuperarContra();">¿Olvidaste la contraseña?</span>
                </td>
              </tr>
              <tr>
                <td nowrap align="right">
                <button id="entrar" class="ui-button ui-widget ui-corner-all">
                	<span class="ui-icon ui-icon-locked"></span> Entrar
                </button>
                </td>
              </tr>
            </table>
            </td>
            <td class="celda_relleno" width="45%"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr height="">
      	<td width="50%"> </td>
      	<td align="center" valign="top"> </td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr height="50px" bgcolor="#000000">
  <td colspan="2"></td>
  </tr>
</table>
<div class="footer" id="footer">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> 
	<tr> 
    	<td align="center" style="padding-bottom:0px"> &copy; GLOSS <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </td>
    </tr> 
</table>
</div>

</div>
    
<div id="dialog-confirmacion" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="tDialog">
	<tr> <td align="justify" style="text-transform:uppercase">
    ¡Muy bien! Ahora que se ha configurado la nueva contraseña y se verificó tu correo electrónico, ya puedes iniciar sesion.
   	</td></tr>
    <tr> <td align="center"> ¡BIENVENIDO! </td></tr>
</tr></table>
</div>

<div id="dialog-confirmarContra" style="display:none;">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="4" class="tDialog">
<tr><td align="justify" style="color:;">Revisa la bandeja de entrada de tu email.</td></tr>
<tr><td align="justify" style="color:;">Nota: En algunos casos puede que el correo que te enviamos se encuentre en la bandeja de correo no deseado.</td></tr>
</table>
</div>

</body>
</html>

<script>
function crearVNU(u,em,suc,ti){ $(document).ready(function(e) {//u es el nombre de usuario (username)
    $("#dialog-nuevoU").load('htmls/nuevoUsuario.php #nuevoUsuario', function( response, status, xhr ){
	if ( status == "success" ) { 
		$('#usuarioN').val(u); 
		$('#contrasenaNU').focusout(function(e) { $('#contrasenaNU').val($('#contrasenaNU').val().toUpperCase()); });
		$('#nuevoUsuario input').addClass('campoDatosTabla'); $('.miUsuarioNU').text(u); $('#emailNU').val(em);
		$('#tituloU').val(ti); $('#emailNU1').val(em); $('#sucursalNU').text(suc); //alert(ti);
		
		$('#formNuevoU').validate({//validamos el formulario de la configuración del nuevo usuario
			rules:{contrasenaNU:{rangelength: [6, 10]}, contrasenaNU1:{equalTo: "#contrasenaNU"}, emailNU1:{equalTo: "#emailNU"} },
			messages:{ contrasenaNU:{rangelength:'La contraseña debe ser de 6 a 10 dígitos.'}, contrasenaNU1:{equalTo:'Las contraseñas no coinciden.'}, emailNU1:{equalTo:'Los emails no coinciden.'} }
		});
		$("#dialog-nuevoU").dialog('open');
	}
	});
}); }

function recuperarContra(){ $(document).ready(function(e) {
    $("#dialog-recuperarContra").load('htmls/recuperarContra.php #recuperarContra', function( response, status, xhr ){
	if ( status == "success" ) {
		$('#formRecuperaC').validate({ }); $('#formRecuperaC input').keyup(function(e) { $('#ucDesconocidos').hide(); });
		
		$("#dialog-recuperarContra").dialog({
			autoOpen:true, modal:true, width:600, height:350, closeOnEscape: false, dialogClass:'', title:'RECUPERAR CONTRASEÑA',
			closeText:'',
			create: function( event, ui ) {$('dialog-recuperaContra').dialog('open');},
			open: function(event, ui){ $('#ucDesconocidos').hide(); $('#formRecuperaC input').addClass('campoDatosTabla');},
			close: function( event, ui ) { document.getElementById('formRecuperaC').reset();},
			buttons:{
				Continuar:function(){
					if($('#formRecuperaC').valid()){
						var datosRC = $('#formRecuperaC').serialize();
						$.post('remote_files/checkRC.php', datosRC).done(function( data ) {
							if(data =='ok'){ //si la combinación usuario/contraseña es congruente:
								$('#ucDesconocidos').hide();
								$.post('remote_files/recuperarContra.php', datosRC).done(function( data ) {
								if(data =='ok'){ //si la combinación usuario/contraseña es congruente:
									$("#dialog-confirmarContra").dialog('open');
								}else{alert(data);}
							});
							}else{$('#ucDesconocidos').hide().show('pulsate');}
						});
					}
				},
				Cancelar:function(){$("#dialog-recuperarContra").dialog('close');}
			}
		});
	}
	});
}); }
</script>