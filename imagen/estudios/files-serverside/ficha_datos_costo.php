<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    $id_estudio = sqlValue($_POST["id_estudio"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $result = mysql_query("SELECT c_costo, motivo_costo, concepto_to FROM conceptos WHERE id_to = $id_estudio", $horizonte) or die (mysql_error());
    $row = mysql_fetch_row($result);

    echo $row[0]."*}".$row[1]."*}".$row[2];

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>
