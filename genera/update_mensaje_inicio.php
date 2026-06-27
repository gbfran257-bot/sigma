<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    $titulo = sqlValue($_POST["titulo"], "text");
    $mensaje = sqlValue($_POST["mensaje"], "text");
    $activo = sqlValue($_POST["activo"], "int");

    mysql_select_db($database_horizonte, $horizonte);

	$sql = "UPDATE mensaje_inicio SET titulo = $titulo, mensaje = $mensaje, activo = $activo WHERE id = 1";

	$update = mysql_query($sql, $horizonte) or die (mysql_error());

    if(!$update){
        echo $sql;
    } 
    else{ 
        echo 1;
    }

    mysql_close($horizonte);
?>