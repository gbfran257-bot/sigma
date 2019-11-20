<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_mx, d_municipio from mexico where d_municipio != '' and d_estado = '".$_GET['id']."' group by d_municipio ";
$query = mysql_query($consulta) or die (mysql_error());
if ($_GET['id']!='-ENTIDAD FEDERATIVA-'){
echo '<option value="">'.'-MUNICIPIO-'.'</option>';
}
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_mx'].'">'.$fila['d_municipio'].'</option>';
};

?>