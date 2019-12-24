<?php 
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");
include_once '../../recursos/session.php';
include_once '../../Connections/database.php';
include_once '../../recursos/utilities.php';
	$tempo = sqlValue($_GET['tempo'], "text");
	if(isset($_SESSION['id'])){
		$id_u = $_SESSION['id']; $acceso = $_SESSION['MM_UserGroup'];
		
		mysql_select_db($database_horizonte, $horizonte);
		if($acceso!=1){
			$consulta = "SELECT s.nombre_su as name, s.id_su as id from sucursales s WHERE id_su in (select id_sucursal_su from sucursales_usuarios where id_usuario_su = $id_u) and id_su not in (select id_sucursal_su from sucursales_usuarios where aleatorio_su = $tempo) group by s.id_su order by s.nombre_su asc ";
		}else{
			$consulta = "SELECT s.nombre_su as name, s.id_su as id from sucursales s WHERE id_su not in (select id_sucursal_su from sucursales_usuarios where aleatorio_su = $tempo) group by s.id_su order by s.nombre_su asc ";
		}
		$query = mysql_query($consulta) or die (mysql_error());
		echo '<option value="">'.'-Buscar la sucursal a asignar-'.'</option>';
		while ($fila = mysql_fetch_array($query)) {
			echo '<option value="'.$fila['id'].'">'.$fila['name'].'</option>';
		};
		
	}else{ header("Location: " . '../../logout.php' ); }
?>