<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_u = sqlValue($_GET["id_u"], "int");

mysql_select_db($database_horizonte, $horizonte);
//$consulta = "SELECT DISTINCT s.id_su AS id, s.nombre_su AS nombre FROM sucursales s LEFT JOIN sucursales_usuarios su ON su.id_sucursal_su = s.id_su WHERE su.id_usuario_su = 1 ORDER BY s.nombre_su ASC";
$consulta = "SELECT DISTINCT s.id_su AS id, s.nombre_su AS nombre FROM sucursales s LEFT JOIN sucursales_usuarios su ON su.id_sucursal_su = s.id_su LEFT JOIN usuarios u on u.id_u = su.id_usuario_su WHERE u.id_u = $id_u ORDER BY s.nombre_su ASC";
$query = mysql_query($consulta) or die (mysql_error());

while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
};

?>