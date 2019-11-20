<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

$myidu = sqlValue($_GET["myidu"], "int");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT u.id_u as id, concat(t.abreviacion_ti,' ',u.nombre_u,' ',u.apaterno_u) as nombre, u.amaterno_u as materno from usuarios u left join titulos t on t.id_ti = u.id_titulo_u where t.abreviacion_ti != 'C.' or id_u = $myidu order by concat(u.nombre_u,' ',u.apaterno_u) asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="" selected>'.'-USUARIO-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].' '.$fila['materno'].'</option>';
};

?>