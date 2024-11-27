<?php 
require_once('../../../Connections/horizonte.php'); 
require("../../../funciones/php/values.php");

$idU = sqlValue($_GET['idU'], "int");

mysql_select_db($database_horizonte, $horizonte); 
$resultAU = mysql_query("SELECT multisucursal_u, idSucursal_u from usuarios where id_u = $idU",$horizonte) or die (mysql_error());
$rowAU = mysql_fetch_row($resultAU); $id_suc = sqlValue($rowAU[1], "int");
	
    switch($rowAU[0]){
		case 0://Solo vé lo suyo
			
			$consulta1 = "SELECT id_su, nombre_su from sucursales where id_su = $rowAU[1]";

		break;
		case 2://Ve todo lo de su sucursal y lo suyo
			$consulta1 = "SELECT id_su, nombre_su from sucursales where id_su = $rowAU[1]";

		break;
		case 1://Ve todo de todas las sucursales
			$consulta1 = "SELECT id_su, nombre_su from sucursales";

		break;
		default:
			echo 'Ha ocurrido un error';
	}

	//agregamos ordenacion a los resultados
	$consulta1 .= " ORDER BY nombre_su ASC";

	mysql_select_db($database_horizonte, $horizonte);
	$query1 = mysql_query($consulta1) or die (mysql_error());


while ($fila1 = mysql_fetch_array($query1)) {
	
		echo '<option value="'.$fila1['id_su'].'">'.$fila1['nombre_su'].'</option>';
	
};

?>