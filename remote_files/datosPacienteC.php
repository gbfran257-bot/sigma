<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$curp = sqlValue($_POST["curpPaciente"], "text"); 

mysql_select_db($database_horizonte, $horizonte);

$result1 = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where curp_p = $curp ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

$nombreP = $row1[0].' '.$row1[1].' '.$row1[2];

echo $nombreP;

mysql_close($horizonte);
?>