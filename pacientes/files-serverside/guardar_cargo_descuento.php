<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$personal = sqlValue($_POST["personal"], "int");
$tipo = sqlValue($_POST["tipo"], "int");
$temp = sqlValue($_POST["temp"], "text");
$monto = sqlValue($_POST["monto"], "double");
$motivo = sqlValue($_POST["motivo"], "text");
$area = sqlValue($_POST["area"], "text");
mysql_select_db($database_horizonte, $horizonte); 
//verificamos si el registro existe
$sqlcount = "SELECT COUNT(*) FROM conceptos_carg_desc WHERE tipo = $tipo AND no_temp_cd = $temp";
$ejecutar = mysql_query($sqlcount, $horizonte) or die (mysql_error());
$resultado = mysql_fetch_row($ejecutar);
$count = $resultado[0];
// si no existe, lo creamos
if($count<=0){
    $sql="INSERT INTO conceptos_carg_desc (id_personal_medico_cd, tipo, no_temp_cd, monto, motivo_carg_desc, tipo_area) VALUES ($personal, $tipo, $temp, $monto, $motivo, $area)";
    $update = mysql_query($sql, $horizonte) or die (mysql_error());
}else{
    //si existe, lo actualizamos
    $sql="UPDATE conceptos_carg_desc SET id_personal_medico_cd = $personal, monto = $monto, motivo_carg_desc = $motivo WHERE tipo = $tipo AND no_temp_cd = $temp";
    $update = mysql_query($sql, $horizonte) or die (mysql_error());
}
if (!$update) { echo $sql; }else{ 
	echo 1;
}
//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>