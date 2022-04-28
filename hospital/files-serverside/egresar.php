<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
$idU = sqlValue($_POST["id_u"], "int"); //id usuario que egreso al paciente
$id_h = sqlValue($_POST["id_h"], "int");
$id_cama_h = sqlValue($_POST["id_cama_h"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

//buscamos el id del estatus de egresado en caso de desconocerse
mysql_select_db($database_horizonte, $horizonte);
$sql1 = "SELECT id_est FROM estatus WHERE estatus_est = 'EGRESO' ";
$estatus1 = mysql_query($sql1, $horizonte) or die (mysql_error());
$estus = mysql_fetch_row($estatus1);
$egresado =  $estus[0];

mysql_select_db($database_horizonte, $horizonte);
$sql = "UPDATE hospitalizacion SET fecha_fin_h = $now, id_usuario_egreso_h = $idU, estatus_h = $egresado where id_h = $id_h";
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
