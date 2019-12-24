<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_u"], "int");
 $sexo = sqlValue($_POST["sexo"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $apaterno = sqlValue(mb_strtoupper($_POST["apaterno"]), "text");
 $amaterno = sqlValue(mb_strtoupper($_POST["amaterno"]), "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT idSucursal_u from usuarios where id_u = $idU limit 1", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 $id_sucu = sqlValue($row[0], "int");
 if($_POST["sexo"]==1){$id_titulo_u = 3;}else{$id_titulo_u = 2;}
 
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("SELECT max(id_u) from usuarios", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1); $sum = $row1[0]+1; $usuario = sqlValue('USUARIO'.$sum, "text");
 
 $hashed_password = sqlValue(password_hash('USUARIO'.$sum, PASSWORD_DEFAULT), "text");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO usuarios(nombre_u, apaterno_u, amaterno_u, idSucursal_u, sexo_u, idEscolaridad_u, idDepartamento_u, idArea_u, fecha_ingreso_u, idUsuarioR_u, idPuesto_u, id_titulo_u, acceso_u, multisucursal_u, usuario_u, contrasena_u) values($nombre, $apaterno, $amaterno, $id_sucu, $sexo, 6, 4, 4, $now, $idU, 1, $id_titulo_u, 7, 0, $usuario, $hashed_password)";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>