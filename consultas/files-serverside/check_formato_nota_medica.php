<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idUsuario = sqlValue($_POST["idU"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $resultR3 = mysql_query("SELECT idSucursal_u from usuarios where id_u = $idUsuario", $horizonte);
 $rowR3 = mysql_fetch_row($resultR3); $idSucursal = sqlValue($rowR3[0], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT formato_co_su from sucursales where id_su = $idSucursal", $horizonte);
 $rowR = mysql_fetch_row($resultR);

 if($rowR[0]==''){
	 //Entonces checamos si hay un formato desde la configuración principal
	 mysql_select_db($database_horizonte, $horizonte);
	 $resultR1 = mysql_query("SELECT formato_co_cf from configuracion order by id_cf desc limit 1", $horizonte);
	 $rowR1 = mysql_fetch_row($resultR1);

	 if($rowR[0]==''){echo '';}else{echo $rowR1[0];}
 }else{ echo $rowR[0];}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>