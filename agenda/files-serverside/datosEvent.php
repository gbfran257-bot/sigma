<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
  
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT id, title, description, estatus, a_quien, id_quien, color from events where id = $id limit 1", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 echo $row[0].'}[-]{'.$row[1].'}[-]{'.$row[2].'}[-]{'.$row[3].'}[-]{'.$row[4].'}[-]{'.$row[5].'}[-]{'.$row[6];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>