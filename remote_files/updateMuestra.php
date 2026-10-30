<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

 $idU = sqlValue($_POST["idU"], "int");
 $idM = sqlValue($_POST["idM"], "int");
 $muestra = sqlValue(mb_strtoupper($_POST["muestra"]), "text");
 $idCondicion = sqlValue($_POST["idCondicion"], "int");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE muestras SET muestra_mu = $muestra, id_condicion_mu = $idCondicion, usuario_reg_mu = $idU, fecha_reg_mu = NOW() WHERE id_mu = $idM limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>