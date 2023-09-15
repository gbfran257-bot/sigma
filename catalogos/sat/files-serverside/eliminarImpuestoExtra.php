<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id = sqlValue($_POST["id_impuesto_catalogo"], "int");

mysql_select_db($database_horizonte, $horizonte);

$sql_eliminar = "DELETE FROM impuesto_catalogo WHERE id = $id";
$eliminar = mysql_query($sql_eliminar, $horizonte) or die(mysql_error());

echo json_encode([$sql_eliminar]);

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
