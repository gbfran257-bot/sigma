<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idDX = sqlValue($_POST["idDX"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $idC = sqlValue($_POST["idC"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO dx_consultas (id_p_dxC, id_dx_dxC, id_u_dxC, id_c_dxC, fecha_dxC)";
 $sql.= "VALUES ($idP, $idDX, $idU, $idC, now())";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) {
 	echo $sql;
 }else{ 
 	echo "ok";
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>