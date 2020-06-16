<?php 
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

//Checamos el nivel de acceso del usuario, para ver si es multisucursal
mysql_select_db($database_horizonte, $horizonte);
$resultNu = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = '$_GET[idU]' ", $horizonte) or die (mysql_error()); $rowNu = mysql_fetch_row($resultNu); //echo $rowNu[0];

mysql_select_db($database_horizonte, $horizonte);
if($rowNu[0]==1){ 
	$consulta1 = "SELECT DISTINCT id_su, nombre_su, tipo_tabulador_su, clave_su from sucursales order by nombre_su asc"; 
	$query1 = mysql_query($consulta1) or die (mysql_error());
	while ($fila1 = mysql_fetch_array($query1)) { echo '<option clave="'.$fila1['clave_su'].'" tipo="'.$fila1['tipo_tabulador_su'].'" value="'.$fila1['id_su'].'">'.$fila1['nombre_su'].'</option>'; };
}
else{
	$consulta1 = "SELECT DISTINCT id_su, nombre_su, tipo_tabulador_su, clave_su  from sucursales where id_su = $rowNu[1] order by nombre_su asc";
	$query1 = mysql_query($consulta1) or die (mysql_error());
	while ($fila1 = mysql_fetch_array($query1)) { echo '<option clave="'.$fila1['clave_su'].'" tipo="'.$fila1['tipo_tabulador_su'].'" selected value="'.$fila1['id_su'].'">'.$fila1['nombre_su'].'</option>'; };
}

?>