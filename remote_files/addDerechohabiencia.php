<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    $idU = sqlValue($_POST["id_usr_reg"], "int");
    $clave = sqlValue($_POST["clave_d"], "text");
    $nombre = sqlValue(mb_strtoupper($_POST["nombre_d"]), "text");
    $now = sqlValue(date('Y-m-d H:i:s'), "date");

    mysql_select_db($database_horizonte, $horizonte);
    $sql = "INSERT INTO catalogo_nuevas_derechohabiencias(clave_d, nombre_d, usuario_d, fecha_d)";
    $sql.= "VALUES ($clave, $nombre, $idU, $now)";

    $update = mysql_query($sql, $horizonte) or die (mysql_error());

    if(!$update){echo $sql;} else{echo 1;}

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>