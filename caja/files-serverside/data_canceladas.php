<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $min = sqlValue($_POST["min"], "date");
    $max = sqlValue($_POST["max"], "date");

	mysql_select_db($database_horizonte, $horizonte);
	$result1 = mysql_query("SELECT COUNT(id_ov) FROM orden_venta_del WHERE fecha_venta_ov BETWEEN $min AND $max", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);

    if (!$result1) {echo "Error en consulta";} else{ echo $row1[0]; }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);

?>