<?php
include_once '../Connections/database.php';
include_once 'recursos/utilities.php';

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_POST['usuario'], $_POST['token'])) {
	if(validate_token($_POST['token'])) {
	  $loginUsername=$_POST['usuario'];
	  $password=$_POST['contrasena'];
	  $remember=$_POST['remember'];
	  $MM_fldUserAuthorization = "acceso_u";
	  $MM_redirectLoginSuccess = "index.php";
	  $MM_redirectLoginFailed = "login.php";
	  $MM_redirecttoReferrer = true;
	  
	  mysql_select_db($database_horizonte, $horizonte);
	  $result1a = mysql_query("SELECT contrasena_u, activo_u, validado_u, id_u, acceso_u, idSucursal_u from usuarios where usuario_u = '$loginUsername'", $horizonte) or die (mysql_error());
	  $row1a = mysql_fetch_row($result1a);
	  
	  $contrasena_hashed = $row1a[0];
	  
	  if(password_verify($password, $contrasena_hashed)){
		  mysql_select_db($database_horizonte, $horizonte);
	  	  $result1b = mysql_query("SELECT count(id_u) FROM usuarios WHERE usuario_u='$loginUsername' and activo_u = 1 and validado_u = 1 and usuarioNuevo_u = 0", $horizonte) or die (mysql_error());
	      $row1b = mysql_fetch_row($result1b);
	  
		  $calert = 0; //echo $row1a[3];
		  
		  if($row1a[1]==0){$calert = 1; echo ' '; $myuser_rc = $_POST['usuario'];
			$vmy_alert = 'La cuenta está desactivada, favor de contactar al administrador del sistema.';
		  }
		  if($row1a[2]==0){$calert = 2; echo ' ';
			$myuser_rc = $_POST['usuario'];
		  }
		   
		  if ($row1b[0]>0) {
			$loginStrGroup  = $row1a[4];
			prepLogin($row1a[3], $loginUsername, $remember, $loginStrGroup, $row1a[5]);
		  }
		  else { header("Location: ". $MM_redirectLoginFailed ); }
	  }else{ //usuario y/o contraseña incorrectos
		$calert = 1; echo ' '; $myuser_rc = $_POST['usuario'];
		$vmy_alert = 'Usuario y/o contraseña no válidos.'; 
		header("Location: ". $MM_redirectLoginFailed ); 
	  }
	}else{
		$calert = 1; echo ' '; $myuser_rc = 1;//$_POST['usuario'];
		$vmy_alert = 'Esta petición se ha originado de una fuente desconocida, posible ataque.';
		header("Location: ". $MM_redirectLoginFailed ); 
	}
}else{
	if(isset($_POST['usuarioRC'])) { $calert = 2; echo ' ';
	  	$myuser_rc = $_POST['usuarioRC'];
	}else{header("Location: ". $MM_redirectLoginFailed );}
}