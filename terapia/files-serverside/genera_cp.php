<?php
require_once('../../Connections/horizonte.php');

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_mx, d_codigo from mexico where d_codigo != '' and d_estado = '".$_GET['idE']."' and d_municipio = '".$_GET['idM']."' and d_asenta = '".$_GET['idC']."' group by d_codigo ";
$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'C.P.'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	echo '<option value="'.$fila['id_mx'].'" selected>'.$fila['d_codigo'].'</option>';
};

?>