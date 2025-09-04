<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    $id_d = sqlValue($_POST["id_d"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $result = mysql_query("SELECT clave_d, nombre_d from catalogo_nuevas_derechohabiencias where id_d = $id_d ", $horizonte) or die (mysql_error());
    $row = mysql_fetch_row($result);

    $datos = $row[0]."*}".$row[1];

    echo $datos;

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>