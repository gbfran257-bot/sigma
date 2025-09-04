<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    $idU = sqlValue($_POST["id_usr_update"], "int");
    $id_d = sqlValue($_POST["id_unidad_m"], "int");
    $clave_d = sqlValue(mb_strtoupper($_POST["clave_d"]), "text");
    $nombre_d = sqlValue($_POST["nombre_d"], "text");
    $now = sqlValue(date('Y-m-d H:i:s'), "date");

    mysql_select_db($database_horizonte, $horizonte);
    $sql = "UPDATE catalogo_nuevas_derechohabiencias set clave_d = $clave_d, nombre_d = $nombre_d, usuario_d = $idU, fecha_d = $now where id_d = $id_d  limit 1";

    $update = mysql_query($sql, $horizonte) or die (mysql_error());

    if(!$update){echo $sql;} else{echo 1;}

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);

?>