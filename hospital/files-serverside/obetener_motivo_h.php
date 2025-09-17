<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $id_h = sqlValue($_POST["id_h"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $result = mysql_query("SELECT motivo_h FROM hospitalizacion WHERE id_h = $id_h", $horizonte) or die (mysql_error());

    // Verificamos si hubo resultados
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_row($result);
        echo $row[0]; // Mostramos el valor de motivo_h
    } else {
        echo "Motivo no encontrado";
    }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>
