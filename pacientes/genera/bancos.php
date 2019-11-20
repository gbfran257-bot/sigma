<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_b, nombrecito_b from catalogo_bancos order by nombrecito_b asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-Banco-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_b'].'">'.$fila['nombrecito_b'].'</option>';
};

?>