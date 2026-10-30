<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_um"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT nombre_des, tipo_des, descuento_des from catalogo_descuentos where id_des = $id ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0].'*}'.$row[1].'*}'.$row[2];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>