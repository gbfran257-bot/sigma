<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idE = sqlValue($_POST['idE'],'text');

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT DATE_FORMAT(fecha_venta_vc, '%d/%m/%Y %H:%i:%s'), nota_toma_muestra FROM venta_conceptos WHERE id_vc = ".$idE, $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2);

if(!$result2){ echo "error"; }
else{
    echo $row2[0] . "*}" . $row2[1];
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>