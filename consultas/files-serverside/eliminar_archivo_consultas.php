<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_consulta = sqlValue($_POST["id_consulta"], "int");

//eliminamos el archivo pdf/img del servidor
mysql_select_db($database_horizonte, $horizonte);
$result = mysql_query("SELECT archivo_consultas FROM venta_conceptos WHERE id_vc = " . $id_consulta, $horizonte) or die (mysql_error());
$row = mysql_fetch_row($result);

$carpeta = "../archivos_consultas/".$row[0];

unlink($carpeta);

//actualizamos el registro para borrar el enlace del archivo
mysql_select_db($database_horizonte, $horizonte);
$query_upd_archivoConsultas = "UPDATE venta_conceptos SET archivo_consultas = '0' WHERE id_vc = $id_consulta LIMIT 1"; 
$execute_query_mmg = mysql_query($query_upd_archivoConsultas, $horizonte) or die (mysql_error());

if($execute_query_mmg){
    echo 1;
}

mysql_close($horizonte);
?>