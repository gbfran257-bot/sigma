<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_h = sqlValue($_POST["id_h"], "int");
$id_cama_h = sqlValue($_POST["id_cama_h"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");
 
mysql_select_db($database_horizonte, $horizonte);
$sql = "UPDATE hospitalizacion SET fecha_fin_h = $now where id_h = $id_h";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
}else {
    $sql = "UPDATE camas SET ocupado_ca = 0 where id_ca = $id_cama_h";
    $update = mysql_query($sql, $horizonte) or die (mysql_error());

    if (!$update) {
        echo $sql;
    }else {
        echo 1;
    }
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>