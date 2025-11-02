<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$fecha = new DateTime();
$fecha->modify('-306 days');
echo $fecha->format('Y-m-d');

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>