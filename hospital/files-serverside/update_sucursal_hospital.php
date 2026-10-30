<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_u = sqlValue($_POST["id_u"], "int");
$id_su = sqlValue($_POST["id_su"], "int");

mysql_select_db($database_horizonte, $horizonte);
$sql_s_p = "UPDATE usuarios SET sucursal_hospital = $id_su WHERE id_u = $id_u LIMIT 1";
$update_s_p = mysql_query($sql_s_p, $horizonte) or die (mysql_error());

if($update_s_p){
    echo 1;
} else {
    "No se pudo establecer la sucursal";
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>