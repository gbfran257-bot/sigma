<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $quien = sqlValue($_POST["quien"], "int");
 $control = sqlValue($_POST["control"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
  
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT id, title from events where a_quien = $control and id_quien = $quien order by id desc limit 1", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 echo $row[0].'}[-]{'.$row[1];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>