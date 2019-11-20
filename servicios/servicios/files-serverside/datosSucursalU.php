<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

//Generales
 $idU = sqlValue($_POST["idU"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultR = mysql_query("SELECT idSucursal_u from usuarios where id_u = $idU ", $horizonte) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR);
 
 echo $rowR[0];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>