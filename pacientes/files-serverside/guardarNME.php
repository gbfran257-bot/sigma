<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $nombre = sqlValue($_POST["nombreUs"], "text");
 $apaterno = sqlValue($_POST["apaternoUs"], "text");
 $amaterno = sqlValue($_POST["amaternoUs"], "text");
 $idU = sqlValue($_POST["id_u_nm"], "int");
 $sucursal = sqlValue($_POST["sucursalUs"], "int");
 $sexo = sqlValue($_POST["sexoUs"], "int");
 $telefono = sqlValue($_POST["telmovilUs"], "text");
 $fnac = sqlValue($_POST["fnacUs"], "date");
 $username = sqlValue($_POST["username"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 if($_POST["sexoUs"]==1){$titulo=sqlValue('DRA.', "text");}
 else{$titulo=sqlValue('DR.', "text");}
 $especialidad = sqlValue($_POST["especialidadU"], "int");
	
 mysql_select_db($database_horizonte, $horizonte); 
 $sql="INSERT INTO usuarios(idUsuarioR_u, nombre_u, apaterno_u, amaterno_u, sexo_u, nacionalidad_u, fNac_u, idSucursal_u, acceso_u, usuario_u, contrasena_u, tCelular_u, idDepartamento_u, idArea_u, idPuesto_u, idEscolaridad_u, idProfesion_u, titulo_u, fecha_ingreso_u, especialidad_u) VALUES ($idU, $nombre, $apaterno, $amaterno, $sexo, 'MEXICANA', $fnac, $sucursal, '2', $username, $username, $telefono, '4', '21', '1', '6', '4782', $titulo, $now, $especialidad)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>