<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_a"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT i.item_i, i.descripcion_i, i.id_tipo_i, CONCAT(i.id_unidad_i,'(',u.abreviacion_un,')'), i.id_presentacion_i FROM inventario i LEFT JOIN unidades u ON u.id_un = i.id_unidad_i WHERE id_i = $id LIMIT 1", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 $datos = $row[0].'*}'.$row[1].'*}'.$row[2].'*}'.$row[3].'*}'.$row[4];

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>