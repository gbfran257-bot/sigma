<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $claveUsuario = sqlValue($_POST['claveUsuario1'], "text");
 //$idU = sqlValue($_GET["idU"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT count(id_u) FROM usuarios where clave_u = $claveUsuario", $horizonte) or die(mysql_error());
 $row = mysql_fetch_row($result);
 	
if($row[0]>0){
	echo 0;
}//si nadie lo tiene
else{
	echo 1;
} //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>