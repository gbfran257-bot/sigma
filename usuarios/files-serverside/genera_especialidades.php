<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT * from especialidades order by nombre_especialidad asc ";
$query = mysql_query($consulta) or die (mysql_error());
if ($_GET['id']!='-SELECCIONAR-'){
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
}
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_es'].'">'.$fila['nombre_especialidad'].'</option>';
};

?>