<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$noTemp = sqlValue($_POST["base_est"], "text");
$idM = sqlValue($_POST["id_m"], "int");
$idU = sqlValue($_POST["idU"], "int");

$now = sqlValue(date('Y-m-d H:i:s'), "date");

    mysql_select_db($database_horizonte, $horizonte); 
    $sql="INSERT INTO asignar_metodo(id_base_ame,id_metodo_ame,usuario_ame,fecha_ame)";
    $sql.= "VALUES ($noTemp, $idM, $idU, $now)";
    // print_r($sql);
    $update = mysql_query($sql, $horizonte) or die (mysql_error());
    if (!$update) { echo $sql; }else{ echo 1; }


 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>