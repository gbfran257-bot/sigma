<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id_e"], "int");
  
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT nombre_e, nivel_e, control_e, entidad_e from catalogo_escuelas where id_e = $id limit 1", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 echo $row[0].'}[-]{'.$row[1].'}[-]{'.$row[2].'}[-]{'.$row[3];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>