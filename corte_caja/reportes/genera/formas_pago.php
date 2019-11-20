<?php
require_once('../../../Connections/horizonte.php');
require("../../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_fp, forma_pago_fp from catalogo_forma_pago order by forma_pago_fp asc ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_fp'].'">'.$fila['forma_pago_fp'].'</option>';
};

?>