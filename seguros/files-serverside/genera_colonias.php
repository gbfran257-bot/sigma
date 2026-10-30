<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT * from mexico where d_asenta != '' and d_estado = '".$_GET['idE']."' and d_municipio = '".$_GET['idM']."' group by d_asenta ";
$query = mysql_query($consulta) or die (mysql_error());
if ($_GET['idE']!='-SELECCIONAR-' and $_GET['idM']!='-SELECCIONAR-'){
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
}
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_mx'].'">'.$fila['d_asenta'].'</option>';
};

?>