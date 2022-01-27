<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_mh = sqlValue($_POST["id_mh"], "int");

mysql_select_db($database_horizonte, $horizonte);
$sql = "UPDATE medicamentos_hospital SET estatus_mh = 18 where id_mh = $id_mh";
$result = mysql_query($sql, $horizonte) or die (mysql_error());

if(!$result){echo $sql;} else{ echo 1; }

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);

?>