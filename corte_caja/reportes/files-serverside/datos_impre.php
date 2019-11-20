<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $idU = sqlValue($_POST["idU"], "int");
 
 $fecha = date('Y-m-d');
 $hora = date('H:i:s');
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultHl = mysql_query("SELECT u.usuario_u, s.nombre_su from usuarios u left join sucursales s on s.id_su = u.idSucursal_u where id_u = $idU",$horizonte) or die (mysql_error());
 $rowHl = mysql_fetch_row($resultHl);
 
 echo $rowHl[0].'_;}{'.$rowHl[1].'_;}{'.$fecha.'_;}{'.$hora;
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>