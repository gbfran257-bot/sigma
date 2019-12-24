<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT * from mexico where d_municipio != '' and d_estado = '".$_GET['id']."' group by d_municipio ";
$query = mysql_query($consulta) or die (mysql_error());
if ($_GET['id']!='-SELECCIONAR-'){
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
}
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_mx'].'">'.$fila['d_municipio'].'</option>';
};

?>