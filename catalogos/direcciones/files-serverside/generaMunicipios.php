<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id = sqlValue($_GET["id"], "text");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT * from mexico where d_municipio != '' AND d_estado = $id group by d_municipio ";
echo $consulta;
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_mx'].'">'.$fila['d_municipio'].'</option>';
};

?>