<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    $id_p = sqlValue($_POST["id_p"], "int");
    
    mysql_select_db($database_horizonte, $horizonte);
    $result = mysql_query("SELECT tCelular_p, apaterno_p FROM pacientes WHERE id_p = $id_p", $horizonte) or die (mysql_error());
    $row = mysql_fetch_row($result);

    $datos = $row[0].";}".$row[1];

    echo $datos;
    
    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>