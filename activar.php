<?php 
	require_once('Connections/horizonte.php');
	require_once('funciones/php/values.php');
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="imagenes/favicon.ico">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ACTIVAR CUENTA</title>

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

<input name="idUser" type="hidden" id="idUser" value="">

<div class="container-fluid">	
    <div class="row bg-primary" id="header"> <div class="col-md-12" style=" height:40px;">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
          <tr> <td align="center" valign="middle">
          	<h5 class="visible-xs">ACTIVACIÓN DE LA CUENTA POR MEDIO DEL CORREO DE VERIFICACIÓN</h5>
            <h4 class="hidden-xs">ACTIVACIÓN DE LA CUENTA POR MEDIO DEL CORREO DE VERIFICACIÓN</h4>
          </td> </tr>
        </table>
    </div> </div>
    
    <div class="row"> <div class="col-md-12">
    	<table id="tabla_container" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
    	<tr><td valign="top"><br>
        	<?php
			if(isset($_GET['id'])) {
				$encode_id = $_GET['id'];
				$decode_id = base64_decode($encode_id);
				$user_id_array = explode('encodeuserid', $decode_id);
				$id = sqlValue($user_id_array[1], "int");
				//Para que la cuenta sea verificada debe cumplir lo siguiente:
				//1.- Usuario nuevo = 0
				//2.- Activo = 1
				//3.- Validado = 0
				mysql_select_db($database_horizonte, $horizonte);
				$result1 = mysql_query("SELECT count(id_u) from usuarios where id_u = $id", $horizonte) or die (mysql_error());
				$row1 = mysql_fetch_row($result1); //checamos si existe el usuario
				
				if($row1[0]>0){
					mysql_select_db($database_horizonte, $horizonte);
					$result0 = mysql_query("SELECT usuarioNuevo_u, activo_u, validado_u from usuarios where id_u = $id", $horizonte) or die (mysql_error());
					$row0 = mysql_fetch_row($result0);
					if($row0[2]==0){
						//Validamos sin pedos, actualizamos validado a 1
						mysql_select_db($database_horizonte, $horizonte);
						$sql1 = "UPDATE usuarios set validado_u = 1 where activo_u = 1 and usuarioNuevo_u = 0 and id_u = $id limit 1 ";
						$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
						
						if (!$update1) { echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Un error ha ocurrido, inténtelo de nuevo o contacte a el administrador del sistema.</p>'; }else{
							echo '<p class="bg-success"><i class="fa fa-check fa-lg" aria-hidden="true"></i> La cuenta se ha validado exitosamente, ahora puede iniciar sesión en el sistema.</p>';
						}
			
					}else{ //No validamos
						if($row0[0]==1){
							//El usuario no ha configurado su contraseña ni su correo electrónico
							echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Su cuenta no ha sido configurada, primero debe ingresar sesión con su usuario y contraseña de default para configurar su nueva contraseña y correo electrónico. Si tiene dudas de como hacerlo por favor contacte al administrador del sistema.</p>';
						}else{
							if($row0[1]==0){
								//El usuario está desactivado, favor de contartar al administrador del sistema
								echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Su cuenta ha sido inhabilitada. Si tiene dudas al respecto por favor contacte al administrador del sistema.</p>';
							}else{
								//Error desconocido, favor de contactar el administrador del sistema
								echo '<p class="bg-warning"><i class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i> Su cuenta ya ha sido validada, no es necesario validarla otra vez.</p>';
							}		
						}
					}
				}else{ echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Los datos para activar la cuenta son incorrectos, favor de contactar al administrador del sistema.</p>'; }
			}else{ echo '<p class="bg-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Los datos para activar la cuenta son incorrectos, favor de contactar al administrador del sistema.</p>'; }
		  ?><br>
		  <p>Dé click en el siguiente link para continuar <a href="index.php">INICIO</a></p>
        </td></tr>
        </table>
    </div> </div>
  
  	<div id="footer" class="row bg-primary"><div class="col-md-12" style="height:30px; color:;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
          <tr> <td align="center" valign="middle"><h6>&copy; GLOSS <?php echo date('Y'); ?>. TODOS LOS DERECHOS RESERVADOS. </h6></td> </tr>
        </table>
    </div> </div>
</div>


</body>
</html>

<script>
$(document).ready(function() { 
	var bootstrapButton = $.fn.button.noConflict() //return $.fn.button to previously assigned value
	$.fn.bootstrapBtn = bootstrapButton 
	$('#tabla_container').height($('#referencia').height()-$('#header').height()-$('#footer').height());
});
</script>