<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_mh = sqlValue($_POST["id_mh"], "int");
$indi_mh = sqlValue($_POST["indi_mh"], "text");

mysql_select_db($database_horizonte, $horizonte);
$sql_s_p = "UPDATE medicamentos_hospital SET indicacion_mh = $indi_mh WHERE id_mh = $id_mh LIMIT 1";
//echo $sql_s_p;
$update_s_p = mysql_query($sql_s_p, $horizonte) or die (mysql_error());

if($update_s_p){
    echo 1;
} else {
    "No se pudo actualzar la indicacion";
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>