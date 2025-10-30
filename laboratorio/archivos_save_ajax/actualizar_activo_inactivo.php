<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $valor_a_i = sqlValue($_POST["valor_a_i"], "int");
    $id_e = sqlValue($_POST["id_e"], "int");
    $usuario = sqlValue($_POST["usuario"], "int");
    $now = sqlValue(date('Y-m-d H:i:s'), "date");

    mysql_select_db($database_horizonte, $horizonte);
    $sql = "UPDATE venta_conceptos SET estudio_a_i = $valor_a_i, estudio_a_i_user = $usuario, fecha_a_i = $now WHERE id_vc = $id_e LIMIT 1";
    $update = mysql_query($sql, $horizonte);

    if(!$update) {
        echo $sql;
    }else {
        echo 1;
    }

    mysql_close($horizonte);
?>