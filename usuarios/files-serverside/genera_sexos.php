<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT cat_sexo, id_sexo from catalogo_sexos where id_sexo in (1,2) order by id_sexo asc";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_sexo'].'">'.$fila['cat_sexo'].'</option>';
};

?>