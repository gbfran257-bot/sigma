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
  
  mysql_select_db($database_horizonte, $horizonte);
  $result1a = mysql_query("SELECT contrasena_u, activo_u, validado_u from usuarios where usuario_u = '$loginUsername'", $horizonte) or die (mysql_error());
  $row1a = mysql_fetch_row($result1a);
  
  $contrasena_hashed = $row1a[0];
  
  if(password_verify($password, $contrasena_hashed)){
	  $LoginRS__query=sprintf("SELECT usuario_u, contrasena_u, acceso_u FROM usuarios WHERE usuario_u=%s and activo_u = 1 and validado_u = 1 and usuarioNuevo_u = 0",
	  GetSQLValueString($loginUsername, "text")); $calert = 0;
	  
	  if($row1a[1]==0){$calert = 1; echo ' '; $myuser_rc = $_POST['usuario'];
	  	$vmy_alert = 'La cuenta está desactivada, favor de contactar al administrador del sistema.';
	  }
	  if($row1a[2]==0){$calert = 2; echo ' ';
	  	$myuser_rc = $_POST['usuario'];
	  }
	   
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
  }else{ //usuario y/o contraseña incorrectos
  	$calert = 1; echo ' '; $myuser_rc = $_POST['usuario'];
	$vmy_alert = 'Usuario y/o contraseña no válidos.';
  	header("Location: ". $MM_redirectLoginFailed ); 
  }
}else{
	if(isset($_POST['usuarioRC'])) { $calert = 2; echo ' ';
	  	$myuser_rc = $_POST['usuarioRC'];
	}else{header("Location: ". $MM_redirectLoginFailed );}
}
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="imagenes/favicon.ico">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>INICIAR SESIÓN</title>

<link href="css/index.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<script src="jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap-validator/js/validator.js"></script>
<script src="funciones/js/caracteres.js"></script>

<script>
$(document).ready(function() { 
	var bootstrapButton = $.fn.button.noConflict() //return $.fn.button to previously assigned value
	$.fn.bootstrapBtn = bootstrapButton 

	$('#entrar').click(function(event) { event.preventDefault(); });
	
	$('#entrar').on('click', function(){
		if($('#usuario').val()!='' & $('#contrasena').val()!=''){ if($('#form1 .has-error').length==0){
			//checamos si el usuario es nuevo, si es nuevo abre pestaña para que configure su contraseña y verifique su email
			var datosL = $('#form1').serialize();
			$.post('remote_files/usuarioNuevo.php', datosL).done(function( data ) {
				var datos = data.split('[;}');//1 es usuario nuevo, 2 no existe y 0 si existe
				if(datos[0]==1){//Se abre la ventana para configurar la nueva contraseña del usuario y verificar su email
					crearVNU(datos[4], escape(datos[1]), datos[2], datos[3]);
				}else{ $('#form1').submit(); /*Se loguea al usuario normalmente*/ }
			});
		} }
	});
		
	$('#tabla_container').height($('#referencia').height()-$('#header').height()-$('#footer').height());
	
});
</script>

</head>
<body>
<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<div class="container-fluid" id="container" align="center" style="border:1px none red;">
	
	<div class="row bg-primary" id="header"> <div class="col-md-12" style=" height:40px;">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
          <tr> <td align="center" valign="middle">
          	<h5 class="visible-xs">SISTEMA INTEGRAL DE GESTIÓN MÉDICA AVANZADA</h5>
            <h4 class="hidden-xs">SISTEMA INTEGRAL DE GESTIÓN MÉDICA AVANZADA</h4>
          </td> </tr>
        </table>
    </div> </div>
    <div class="row"> <div class="col-md-12">
    	<table id="tabla_container" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
    	<tr>
        	<td width="50%" class="hidden-xs">
            <div class="row" style="height:100%"> <div class="col-md-12" style="height:100%; background:url(imagenes/empresa/_doctor1.png) no-repeat top; background-size:contain;"></div> </div>
            </td>
        	<td align="left">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" width="100%">
                  <tr height="">
                    <td valign="bottom">
                    <div class="row hidden-xs"> <div class="col-md-12" style="background-color:white; color:black;">
                        <img id="logo" class="img-responsive" src="imagenes/empresa/brand.png" style="width:95%;"><br>
                    </div> </div>
                    <div class="row visible-xs"> <div class="col-md-12" style="background-color:white; color:black;">
                        <img id="logo" class="img-responsive" src="imagenes/empresa/brand.png" style="width:100%;"><br>
                    </div> </div>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" style="vertical-align:top !important;">
                    <div class="row"> 
                        <div class="col-sm-offset-1 col-md-9"><br><br>
                        	<div class="panel panel-default" style="z-index:1000000;">
                              <div class="panel-heading">Iniciar sesión</div>
                              <div class="panel-body">
                            <form class="form-horizontal" style="height:100%;" name="form1" id="form1" method="POST" action="<?php echo $loginFormAction; ?>" data-toggle="validator">
                          <div class="form-group">
                            <div class="col-sm-offset-0 col-sm-12">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-user-md fa-fw fa-lg"></i></span>
                                  <input  name="usuario" id="usuario" type="text" class="form-control input-lg" data-minlength="4" onKeyUp="conMayusculas(this); nick(this.value, this.name);" maxlength="20" placeholder="Usuario" required data-error="El nombre de usuario es obligatorio (mínimo 4 caracteres)">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-0 col-sm-12">
                                <div class="input-group margin-bottom-sm">
                                  <span class="input-group-addon"><i class="fa fa-key fa-fw fa-lg"></i></span>
                                  <input name="contrasena" type="password" class="form-control input-lg" maxlength="20" id="contrasena" placeholder="Contraseña" required data-minlength="6" data-error="La contraseña es obligatoria (mínimo 6 caracteres)">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                          </div>
                          
                          	<div id="alerta_ucnv" class="alert alert-danger alert-dismissible hidden" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              	<span aria-hidden="true">&times;</span>
                              </button>
                              <strong>
                              	<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
                                <span id="texto_ucnv">Usuario y/o contraseña no válidos.</span>
                              </strong> 
                            </div>
                            
                          <div class="form-group">
                            <div class="col-sm-offset-0 col-sm-12">
                              <div class="checkbox">
                                <button id="entrar" type="submit" class="btn btn-primary">Entrar</button>
                                <label> <input type="checkbox"> Recordarme </label>
                                <a onClick="recuperarContra();" class="btn btn-link btn-xs" href="#" role="button">¿Olvidaste la contraseña?</a>
                              </div>
                            </div>
                          </div>
                        </form> 
                        </div></div></div>
                        </div> 
                    </div> 
                    
                    </td>
                  </tr>
                </table>
            </td>
        </tr>
    	</table>
    </div> </div>
        
	<div id="footer" class="row bg-primary"><div class="col-md-12" style="height:30px;">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
          <tr> <td align="center" valign="middle"><h6>&copy; GLOSS <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </h6></td> </tr>
        </table>
    </div> </div>
    
</div>

<input name="my_alert" id="my_alert" type="hidden" value="<?php echo $calert; ?>">
    
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"> </div><!-- /.modal -->

</body>
</html>

<script>
$(document).ready(function(e) {
	if($('#my_alert').val()==1){ 
		$('#texto_ucnv').text('<?php echo $vmy_alert; ?>');
		$('#alerta_ucnv').removeClass('hidden');
		$('#usuario').val('<?php echo $myuser_rc; ?>');
	} else if($('#my_alert').val()==2){ no_validada(); }
	
});
function crearVNU(u,em,suc,ti){ //u es el nombre de usuario (username)
	$("#myModal").load('htmls/nuevoUsuario.php', function( response, status, xhr ){ if(status=="success"){
		$('#formNuevoU').validator(); $('#myModal').modal('show'); $('#usuarioN').val(u.toUpperCase());
		$('.miUsuarioNU').text(u); $('#emailNU, #emailNU1').val(em);
		$('#btn_config_c').on('click',function(){
			if($('#contrasenaNU1').val()!='' & $('#emailNU1').val()!=''){ if($('#formNuevoU .has-error').length==0){
				$('#btn_config_c').html('<i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i> Procesando...');
				$('#btn_config_c').prop('disabled','disabled');
				
				var datosNU = $('#formNuevoU').serialize();
				$.post('remote_files/configuracionNU.php', datosNU).done(function( data ) {
					if(data ==1){//Si los datos se actualizaron abre una ventana de configuración:
						$('.mi_hide, #btn_config_c').addClass('hidden');
						$('#mi_alert_rp').removeClass('hidden');
						$('#btn_cancel_config_c').text('Entendido');
						$('#contrasena').val('');
					}else{window.location.reload();}
				});
			} }
		});	
	} });
}

function recuperarContra(){ 
	$("#myModal").load('htmls/recuperarContra.php', function(response,status,xhr){ if(status=="success"){
		$('#formRecuperaC').validator();
		$('#myModal').modal('show'); document.getElementById('formRecuperaC').reset(); $('#mi_alert_rp').hide();
		$('#formRecuperaC input').keyup(function(e) { $('#mi_alert_rp').hide(); });
		var i =0;
		$('#btn_recupera_psw').on('click', function () {
				
			var datosRC = $('#formRecuperaC').serialize();
			$.post('remote_files/checkRC.php', datosRC).done(function( data ) {
				switch(data){
					case '1':
						$('#btn_recupera_psw').html('<i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i> Procesando...');
						$('#btn_recupera_psw').prop('disabled','disabled');
						$.post('remote_files/recuperarContra.php', datosRC).done(function( data1 ) {
							if(data1 == 1){ 
								$('.mi_hide, #btn_recupera_psw').addClass('hidden');
								$('#mi_alert_rp').removeClass('alert-danger'); $('#mi_alert_rp').addClass('alert-success');
								$('#btn_cancel_recupera_psw').text('Entendido');
								$('#mi_alert_rp').html('<small><i class="fa fa-check fa-lg" aria-hidden="true"></i> Un correo electrónico con un link para restablecer tu contraseña ha sido enviado a tu email. Revisa la bandeja de entrada de tu email que registraste en la cuenta del sistema.<br> <br><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i> En algunos casos puede que el correo que te enviamos se encuentre en la bandeja de correo no deseado.</small>');
								$('#mi_alert_rp').show();
							}else{alert(data1);}
						});
					break;
					case '2':
						$('#formRecuperaC').submit();
					break;
					case '3':
						$('#mi_alert_rp').html('<small><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Su cuenta se encuentra desactivada, contacte al administrador del sistema.</small>');
						$('#mi_alert_rp').show();
					break;
					default:
						if($('#usuarioRC').val()!='' & $('#emailRC').val()!=''){ if($('#formRecuperaC .has-error').length==0){ 
							$('#mi_alert_rp').html('<small><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Esta cuenta no existe, verifique los datos o contacte al administrador del sistema.</small>');
							$('#mi_alert_rp').show();
						} }
				}
			});
					
			$('#mi_alert_rp').hide();
		});
	} });
}

function no_validada(){
	$("#myModal").load('htmls/modal_reenviar_mail_cc.php', function( response, status, xhr ){ if(status=="success"){
		$('#myModal').modal('show'); $('#usuario').val('<?php echo $myuser_rc; ?>');
		$('#btn_reenviar_email_unv').on('click',function(){
			if('<?php echo $myuser_rc; ?>' != ''){
				$('#btn_reenviar_email_unv').html('<i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i> Procesando...');
				$('#btn_reenviar_email_unv').prop('disabled','disabled');
				var datosRC = {usuarioN:'<?php echo $myuser_rc; ?>'}
				$.post('remote_files/confirmacion.php', datosRC).done(function( data ){
					if(data==1){
						$('.mi_hide, #btn_reenviar_email_unv').addClass('hidden');
						$('#btn_cancel_mail_unv').text('Entendido');
						$('#mi_alert_reunv').removeClass('hidden');
					}
				});
			}
		});
	} });
}
</script>