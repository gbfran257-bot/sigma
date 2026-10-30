<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_mh = sqlValue($_POST["id_mh"], "int");
$indi_mh = sqlValue($_POST["indi_mh"], "text");
$id_medicamento_mh = sqlValue($_POST["id_medicamento_mh"], "int");
$id_u = sqlValue($_POST["id_u"], "int");
$id_hospitalizacion_mh = sqlValue($_POST["id_hospitalizacion_mh"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

mysql_select_db($database_horizonte, $horizonte);
$sql_s_p = "UPDATE medicamentos_hospital SET indicacion_mh = $indi_mh WHERE id_mh = $id_mh LIMIT 1";
$update_s_p = mysql_query($sql_s_p, $horizonte) or die (mysql_error());

//insertamos en el historial de modificaciones
mysql_select_db($database_horizonte, $horizonte);
$update_historial_qry = "INSERT INTO modificaciones_dosis (id_md, id_hospitalizacion_md, id_medicamento_md, dosis_md, usuario_md, fecha_md, accion_md) VALUES (NULL, $id_hospitalizacion_mh, $id_medicamento_mh, $indi_mh, $id_u, $now, '1')";
$update_historial = mysql_query($update_historial_qry, $horizonte) or die (mysql_error());

if($update_s_p){
    echo 1;
} else {
    "No se pudo actualzar la indicacion";
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>