<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 $medicamento = sqlValue($_POST["medicamento"], "text");
 $medicamento = strtoupper($medicamento);

//editar la informacion de la tabla
mysql_select_db($database_horizonte, $horizonte);
$query_upd = "UPDATE medicamentos SET nombre_generico_med = $medicamento WHERE id_med = $id LIMIT 1"; 
$run_query = mysql_query($query_upd, $horizonte) or die (mysql_error());

if($run_query){
    echo 1;
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>