<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT forma_pago_fp, id_fp from catalogo_forma_pago order by id_fp asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-FORMAS DE PAGO-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_fp'].'">'.$fila['forma_pago_fp'].'</option>';
};



?>