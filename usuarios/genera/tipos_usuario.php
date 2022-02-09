<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';

$tipo_user = $_SESSION['MM_UserGroup'];
$sucu_user = $_SESSION['MM_Usersucu'];

mysql_select_db($database_horizonte, $horizonte);

if($tipo_user==14){
	$consulta = "SELECT id_tu, nombre_tu from tipo_usuario where id_tu = 14 ";
}else{
	if($_GET['s']==1){$consulta = "SELECT id_tu, nombre_tu from tipo_usuario order by nombre_tu asc ";}
	else{$consulta = "SELECT id_tu, nombre_tu from tipo_usuario where nombre_tu != 'ADMINISTRADOR' order by nombre_tu asc ";}
}

$query = mysql_query($consulta) or die (mysql_error());
echo '<option value="">'.'-SELECCIONAR-'.'</option>';
while ($fila = mysql_fetch_array($query)) {
	if($fila['id_tu'] != 15){
		echo '<option value="'.$fila['id_tu'].'">'.$fila['nombre_tu'].'</option>';	
	}
};

?>
