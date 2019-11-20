<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["myIDestudio"], "int");
 $idU = sqlValue($_POST["myIDusuario"], "int");
 $diagnostico = sqlValue($_POST["miDiagnostico"], "text");
 //$nota = sqlValue(str_replace(";",".",$_POST["nota"]), "text");
 
mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE venta_conceptos SET interpretacion_vc = $diagnostico, estatus_vc = 5, usuarioEdo5_e = $idU, fechaEdo5_e = now() where id_vc = $idE limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else {
	 echo "ok";
}
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>