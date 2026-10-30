<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    $id_estudio = sqlValue($_POST["id_estudio"], "int");
    $clave_sat = sqlValue($_POST["clave_sat"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $sql = "UPDATE conceptos SET sat_c = $clave_sat WHERE id_to = $id_estudio LIMIT 1";

    $update = mysql_query($sql, $horizonte) or die (mysql_error());

    if (!$update) { echo $sql; }else{ echo 1; }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>