<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idE = sqlValue($_POST['idE'],'text');

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT DATE_FORMAT(fecha_venta_vc, '%d/%m/%Y %H:%i:%s'), nota_toma_muestra, estudio_a_i, estudio_a_i_user, DATE_FORMAT(fecha_a_i, '%d-%m-%Y %H:%i') FROM venta_conceptos WHERE id_vc = ".$idE, $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2);

$usuario = "-";

if($row2[2]>0){
    mysql_select_db($database_horizonte, $horizonte);
    $resultUser = mysql_query("SELECT CONCAT_WS(' ', nombre_u, apaterno_u, amaterno_u) FROM usuarios WHERE id_u = " . $row2[3], $horizonte) or die (mysql_error());
    $rowUser = mysql_fetch_row($resultUser);
    $usuario = $rowUser[0];
}


if(!$result2){ echo "error"; }
else{
    echo $row2[0] . "*}" . $row2[1] . "*}" . $row2[2] . "*}" . $usuario . "*}" . $row2[4];
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>