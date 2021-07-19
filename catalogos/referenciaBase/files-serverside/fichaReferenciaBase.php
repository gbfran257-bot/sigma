<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id_ref = sqlValue($_POST["id_ref"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT tipo_cvr from catalogo_valores_referencia where id_cvr = $id_ref ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>