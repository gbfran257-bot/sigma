<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idU"], "int");
 $temporal = sqlValue($_POST["temporal"], "text");
 $concepto = sqlValue(mb_strtoupper($_POST["nombre"]), "text");
 $area = sqlValue($_POST["area"], "int");
 $precio = sqlValue($_POST["precio"], "double");
 $precioU = sqlValue($_POST["precioU"], "double");
 $precioM = sqlValue($_POST["precioM"], "double");
 $precioMU = sqlValue($_POST["precioMU"], "double");
 $precioH = sqlValue($_POST["precio_h"], "double");
 $precio_costoproduccion = sqlValue($_POST["precio_costoproduccion"], "double");
 $honorario_c = sqlValue($_POST["honorario_c"], "double");
 $honorario_cu = sqlValue($_POST["honorario_cu"], "double");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO conceptos(usuario_to, aleatorio_c, concepto_to, id_departamento_to, id_area_to, precio_to, precio_urgencia_to, precio_m, precio_mu, fecha_to, id_tipo_concepto_to, precio_h, c_costo, honorarios_c,  honorarios_cu)";
 $sql.= "VALUES ($idUsuario, $temporal, $concepto, 4, $area, $precio, $precioU, $precioM, $precioMU, $now, 1, $precioH, $precio_costoproduccion, $honorario_c, $honorario_cu)";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if(!$update){ echo $sql; }else{ echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
