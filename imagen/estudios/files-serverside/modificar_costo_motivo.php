<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    $id_estudio = sqlValue($_POST["id_estudio"], "int");
    $costo_produccion = sqlValue($_POST["costo_produccion"], "double");
    $motivo_costo = sqlValue($_POST["motivo_costo"], "text");

    mysql_select_db($database_horizonte, $horizonte);
    $sql = "UPDATE conceptos SET c_costo = $costo_produccion, motivo_costo = $motivo_costo WHERE id_to = $id_estudio LIMIT 1";

    $update = mysql_query($sql, $horizonte) or die (mysql_error());

    if (!$update) { echo $sql; }else{ echo 1; }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>