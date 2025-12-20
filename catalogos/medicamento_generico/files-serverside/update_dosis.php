<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id = sqlValue($_POST["idConcepto"], "int");
//$dosis = sqlValue($_POST["input_dosis"], "text");
//$dosis = strtoupper($dosis);
$dosis = sqlValue(mb_strtoupper($_POST["input_dosis"]), "text");

mysql_select_db($database_horizonte, $horizonte);
$query_update = "UPDATE conceptos SET descripcion_to = $dosis WHERE id_to = $id LIMIT 1"; 
$run_query = mysql_query($query_update, $horizonte) or die (mysql_error());

if($run_query){
    echo 1;
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>