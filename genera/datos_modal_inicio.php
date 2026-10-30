<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    mysql_select_db($database_horizonte, $horizonte);
    $query = mysql_query("SELECT activo, titulo, mensaje FROM mensaje_inicio WHERE id = 1", $horizonte) or die (mysql_error());
    $datos = mysql_fetch_row($query);

    echo $datos[0].'*;'.$datos[1].'*;'.$datos[2];
    mysql_close($horizonte);
?>