<?php require_once('../../Connections/horizonte.php'); ?>
<?php

$idSucursal = $_GET['idS'];

mysql_select_db($database_horizonte, $horizonte);
$consulta1 = "SELECT DISTINCT id_su, nombre_su from sucursales where id_su in ($idSucursal) limit 1";
$query1 = mysql_query($consulta1) or die (mysql_error());

while ($fila1 = mysql_fetch_array($query1)) {
	
		echo '<option value="'.$fila1['id_su'].'">'.$fila1['nombre_su'].'</option>';
	
};

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT DISTINCT id_su, nombre_su from sucursales where id_su not in ($idSucursal) order by id_su asc";
$query = mysql_query($consulta) or die (mysql_error());

while ($fila = mysql_fetch_array($query)) {
	
		echo '<option value="'.$fila['id_su'].'">'.$fila['nombre_su'].'</option>';
	
};

?>