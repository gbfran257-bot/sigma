<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

// $valor = sqlValue($_POST["val"], "double");
// $id_to = sqlValue($_POST["id_to"], "int");
 $id_u = sqlValue($_POST["id_u"], "int");
 $id_su = sqlValue($_POST["id_su"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 //primero tenemos que saber si existe su tabulador, sino entnces escogemos el tabulador base
 $tabu = $_POST['id_su'].'_precio'; $resultT = mysql_query("SHOW COLUMNS FROM conceptos LIKE '$tabu' ");
 $existsT = (mysql_num_rows($resultT))?TRUE:FALSE;
 if($existsT){
	$precio_nor = $_POST['id_su'].'_precio'; $precio_ur = $_POST['id_su'].'_precio_u';
	
	//Checamos si hay cambio, sino hay cambio entonces no se actualiza
	mysql_select_db($database_horizonte, $horizonte);
	foreach($_POST["val"] as $ind=>$valor){
		$valor = sqlValue($valor, "double");
		$id_to = sqlValue($_POST["id_to"][$ind], "int");
		$result = mysql_query("SELECT $precio_nor from conceptos where id_to = $id_to ", $horizonte) or die (mysql_error());
		$row = mysql_fetch_row($result);
		 
		if($row[0] < $valor or $row[0] > $valor){
			mysql_select_db($database_horizonte, $horizonte);
	 		$sql = "UPDATE conceptos set $precio_nor = $valor, usuario_to = $id_u, fecha_to = $now where id_to = $id_to";
			
			$update = mysql_query($sql, $horizonte) or die (mysql_error());

	 		if (!$update) { echo $sql; }
		}
	}
 }
 echo 1;
 /*else{
	 //Checamos si hay cambio, sino hay cambio entonces no se actualiza
	 mysql_select_db($database_horizonte, $horizonte);
	 $result = mysql_query("SELECT precio_to from conceptos where id_to = $id_to ", $horizonte) or die (mysql_error());
	 $row = mysql_fetch_row($result);
	 
	 if($row[0] < $valor or $row[0] > $valor){
		mysql_select_db($database_horizonte, $horizonte);
	 	$sql = "UPDATE conceptos set precio_to = $valor, usuario_to = $id_u, fecha_to = $now where id_to = $id_to";
		$update = mysql_query($sql, $horizonte) or die (mysql_error());

 		if (!$update) { echo $sql; }else{ echo 1; }
	 }else{ echo 1; }
 }*/

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>