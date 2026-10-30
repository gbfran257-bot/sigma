<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    $id_e_d = sqlValue($_POST["id_e_d"], "int");
    
    mysql_select_db($database_horizonte, $horizonte);
    $result = mysql_query("SELECT email_u FROM usuarios WHERE id_u = $id_e_d", $horizonte) or die (mysql_error());
    $row = mysql_fetch_row($result);

    $datos = $row[0].";}";

    echo $datos;
    
    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>