<?php 
	require_once('Connections/horizonte.php');
	require_once('funciones/php/values.php');
	include_once 'funciones/php/send-email.php';
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="imagenes/favicon.ico">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CONFIGURAR NUEVA CONTRASEÑA</title>

<link href="css/index.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

<script src="jquery-ui-1.12.0/external/jquery/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap-validator/js/validator.js"></script>
<script src="funciones/js/caracteres.js"></script>

</head>

<body>
<div id="referencia" style="display:none; position:fixed; width:100%; height:100%; z-index:1000000000000000000000;"></div>

<div class="container-fluid">
    <div class="row bg-primary" id="header"> <div class="col-md-12" style=" height:40px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
          <tr> <td align="center" valign="middle">
            <h5 class="visible-xs">RECUPERAR SU CUENTA RESTABLECIENDO UNA NUEVA CONTRASEÑA</h5>
            <h4 class="hidden-xs">RECUPERAR SU CUENTA RESTABLECIENDO UNA NUEVA CONTRASEÑA</h4>
          </td> </tr>
        </table>
    </div> </div>
    
    <div class="row"> <div class="col-sm-offset-0 col-md-12">
    	<table id="tabla_container" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
    	<tr><td valign="top"><br>
		<?php
            if(isset($_GET['id'])) {
                $encode_id = $_GET['id']; $decode_id = base64_decode($encode_id); $user_id_array = explode('encodeuserid', $decode_id);
                $id = sqlValue($user_id_array[1], "int");
        
                mysql_select_db($database_horizonte, $horizonte);
                $result1 = mysql_query("SELECT count(id_u) from usuarios where id_u = $id", $horizonte) or die (mysql_error());
                $row1 = mysql_fetch_row($result1); //checamos si existe el usuario
                
                if($row1[0]>0){ //existe el usuario
                    $melo = 1; //echo $id;
                }else{ 
                    echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Los datos para activar la cuenta son incorrectos, favor de contactar al administrador del sistema.</p>';
                    $melo = 0;
                }
            }else{ 
                if(isset($_POST['contrasena']) and isset($_POST['id_u'])) {
                    $melo = 1;
                    $encode_id = $_POST['id_u']; $decode_id = base64_decode($encode_id); 
                    $user_id_array = explode('encodeuserid', $decode_id); $id = sqlValue($user_id_array[1], "int");
                    
                    mysql_select_db($database_horizonte, $horizonte);
                    $result1 = mysql_query("SELECT count(id_u) from usuarios where id_u = $id", $horizonte) or die (mysql_error());
                    $row1 = mysql_fetch_row($result1); //checamos si existe el usuario
                    
                    mysql_select_db($database_horizonte, $horizonte);
                    $result1x = mysql_query("SELECT email_u, usuario_u from usuarios where id_u = $id", $horizonte) or die (mysql_error());
                    $row1x = mysql_fetch_row($result1x); //checamos su email
                    
                    if($row1[0]>0){ //existe el usuario y cambiamos su contraseña
                        $contrasena = sqlValue(password_hash($_POST["contrasena"], PASSWORD_DEFAULT), "text");
                        mysql_select_db($database_horizonte, $horizonte);
                        $sql1 = "UPDATE usuarios set contrasena_u = $contrasena where id_u = $id limit 1 ";
                        $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
                        
                        if (!$update1) { echo $sql1; }else{
                            //preparar el email body
                            $mail_body = '<html>
                            <body style="background-color:#DDDDDD; color:#000; font-family: Arial, Helvetica, sans-serif;
                                                line-height:1.8em;">
                            <h2>Ha cambiado su contrasena</h2>
                            <p>Estimad@ '.$row1x[1].'<br><br>Gracias por usar el servicio de recuperacion de contrasena, le informamos que su contrasena ha sido cambiada satisfactoriamente. Ahora puede iniciar sesion con su nueva contrasena.</p>
                            <p><a href="http://localhost/sigma/">Ir al sistema</a></p>
                            <p>Si no reconoce esta accion por favor contacte al administrador de su sustema.</p>
                            <p><strong>&copy;2018</strong></p>
                            </body>
                            </html>';
                            
                            //$mail->addAddress($email, $username);
                            $mail->addAddress($row1x[0], $row1x[1]);
                            $mail->Subject = "Contrasena cambiada";
                            $mail->Body = $mail_body;
                            
                            //Error Handling for PHPMailer
                            if(!$mail->Send()){
                                $result = "<script type=\"text/javascript\">
                                swal(\"Error\",\" Email sending failed: $mail->ErrorInfo \",\"error\");</script>";
                                echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Un error ha ocurrido, por favor vuelva a intentarlo más tarde.</p>';
                            }
                            else{ 
                                echo '<p class="bg-success"><i class="fa fa-check fa-lg" aria-hidden="true"></i> Su contraseña ha sido cambiada satisfactoriamente, ahora puede iniciar sesión con sus nuevos datos.</p>'; 
                                $melo = 0;
                                }
                        }
                    }else{ 
                        echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Los datos para activar la cuenta son incorrectos, favor de contactar al administrador del sistema.</p>'; 
                        $melo = 0;
                    }
                    
                }else{ 
                    echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Los datos para activar la cuenta son incorrectos, favor de contactar al administrador del sistema.</p>';
                    $melo = 0;
                }
            }
          ?>
          <p id="no_melo">Dé click en el siguiente link para continuar <a href="index.php">INICIO</a></p>
        </td></tr>
        <tr><td valign="top" align="">
        <div class="row" id="field_form"> 
        <div class="col-sm-offset-3 col-md-6">
        
        <div class="panel panel-default" style="z-index:1000000;">
        <div class="panel-heading">INDIQUE Y CONFIRME LA NUEVA CONTRASEÑA:</div>
        <div class="panel-body">
        
        <table id="mi_tabla_rc" width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" class="">
          <tr>
            <td>
            <form class="form-horizontal" style="height:100%;" name="form-reset" id="form-reset" target="_self" method="POST" data-toggle="validator" action="reset.php">
            <input name="id_u" id="id_u" type="hidden" value="<?php echo $_GET['id']; ?>">
            <input name="melo" id="melo" type="hidden" value="<?php echo $melo; ?>">
            <table class="mi_hide" width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td align="">
                    <div class="form-group">
                        <div class="col-sm-offset-0 col-sm-12">
                            <div class="input-group margin-bottom-sm">
                              <span class="input-group-addon"><i class="fa fa-key fa-fw fa-lg"></i></span>
                              <input name="contrasena" id="contrasena" type="password" class="form-control input-lg" data-minlength="6" maxlength="20" placeholder="Nueva contraseña" required data-error="La contraseña es obligatoria (de 6 a 20 caracteres)">
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                      </div>
                </td>
              </tr>
              <tr>
                <td align="">
                    <div class="form-group">
                        <div class="col-sm-offset-0 col-sm-12">
                            <div class="input-group margin-bottom-sm">
                              <span class="input-group-addon"><i class="fa fa-repeat fa-fw fa-lg"></i></span>
                              <input name="contrasena1" id="contrasena1" type="password" class="form-control input-lg" data-minlength="6" maxlength="20" placeholder="Confirmar contraseña" required data-error="Las contraseñas no coinciden" data-match="#contrasena">
                              <span class="input-group-addon"><i class="fa fa-key fa-fw fa-lg"></i></span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                      </div>
                </td>
              </tr>
              <tr>
                <td align="">
                    <div class="form-group">
                        <div class="col-sm-offset-0 col-sm-12">
                          <div class="checkbox">
                            <button id="resetBTN" type="submit" class="btn btn-primary">Reset</button>
                          </div>
                        </div>
                      </div>
                </td>
              </tr>
            </table>
            </form>
            </div></div></div> </div></div>
        </td></tr>
        </table>
    </div> </div>

  <div id="footer" class="row bg-primary"><div class="col-md-12" style="height:30px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
          <tr> <td align="center" valign="middle"><h6>&copy; <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </h6></td> </tr>
        </table>
    </div> </div>
  
</div>

</body>
</html>

<script>
$(document).ready(function(e) {
	var bootstrapButton = $.fn.button.noConflict(); //return $.fn.button to previously assigned value
	$.fn.bootstrapBtn = bootstrapButton;
	$('#tabla_container').height($('#referencia').height()-$('#header').height()-$('#footer').height());
	
    $('#resetBTN').click(function(event) { event.preventDefault(); });
	
	$('#resetBTN').click(function(e) {
		if($('#contrasena').val()!='' & $('#contrasena1').val()!=''){ if($('#form-reset .has-error').length==0){
			$('#resetBTN').html('<i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i> Procesando...');
			$('#resetBTN').prop('disabled','disabled'); window.setTimeout(function(){$('#form-reset').submit();},1000);
		} }
	});
	
	if($('#melo').val()==1){$('#field_form').show(); $('#no_melo').hide();}else{$('#field_form').hide();$('#no_melo').show();}
});
</script>