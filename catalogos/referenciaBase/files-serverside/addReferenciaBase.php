<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idU = sqlValue($_POST["id_usr_reg"], "int");
 $nombre = sqlValue(mb_strtoupper($_POST["tipo_ref"]), "text");
//  $abreviacion = sqlValue($_POST["abreviacion_u"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO catalogo_valores_referencia(tipo_cvr, usuario_cvr, fecha_cvr)";
 $sql.= "VALUES ($nombre, $idU, $now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>