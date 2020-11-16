<?php if (!isset($_SESSION)) { session_start(); }?>
<?php 
	require_once('Connections/horizonte.php');
	include_once 'Connections/database.php';
	include_once 'recursos/utilities.php';
	include_once 'partes/parseLogin.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="SISTEMA DE EXPEDIENTE CLÍNICO ELECTRÓNICO">
<meta name="author" content="ING EMMANUEL ANZURES BAUTISTA">

<title>INICIAR SESIÓN</title>

<link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon">
<link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">

<link href="css/index.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
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
				}else{ console.log("enviando", $("#form1").serialize()); $('#form1').trigger("submit"); /*Se loguea al usuario normalmente*/ }
			});
		} }
	});
		
	$('#tabla_container').height($('#referencia').height()-$('#header').height()-$('#footer').height());
	
});
</script>
<style>
	#header, #footer{
		background-color: red;
	}
</style>
</head>
<?php
	if((isset($_SESSION['MM_Username']) || isCookieValid($db))){ echo "<script> window.location.href = 'index.php'; </script>"; }
?>
<body style="overflow:hidden;">
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
                        	<div class="panel panel-primary" style="z-index:1000000;">
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
                                  <input name="contrasena" type="password" class="form-control input-lg" maxlength="20" id="contrasena" placeholder="Contraseña" required data-minlength="4" data-error="La contraseña es obligatoria (mínimo 4 caracteres)">
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
                                <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                                <button id="entrar" name="entrar" type="submit" class="btn btn-primary">Entrar</button>
                                <label> <input name="remember" value="yes" type="checkbox"> Recordarme </label>
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