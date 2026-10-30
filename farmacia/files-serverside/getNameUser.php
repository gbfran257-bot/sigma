<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $idU = sqlValue($_POST["idU"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $query = mysql_query("SELECT CONCAT_WS(' ', nombre_u, apaterno_u, amaterno_u) FROM usuarios WHERE id_u = $idU LIMIT 1", $horizonte) or die (mysql_error());
    $exec = mysql_fetch_row($query);

    echo $exec[0];

    mysql_close($horizonte);
?>