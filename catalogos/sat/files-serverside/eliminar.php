<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id = sqlValue($_POST["id_p"], "int");

//  $now = sqlValue(date('Y-m-d H:i:s'), "date");

mysql_select_db($database_horizonte, $horizonte);

// Antes de eliminar la cuenta debemos eliminar los impuestos aplicados a dicha cuenta
$sql_eliminar = "DELETE FROM impuesto_catalogo WHERE id_sat = $id";
$eliminar = mysql_query($sql_eliminar, $horizonte) or die(mysql_error());

if (!$eliminar) echo $sql_eliminar;

$sql = "DELETE FROM catalogo_sat WHERE id_sat = $id";
$update = mysql_query($sql, $horizonte) or die(mysql_error());

if (!$update) {
    echo $sql;
} else {
    echo 1;
}

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
