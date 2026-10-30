<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    $id = sqlvalue($_POST['id'],'int');
    $codigo = sqlValue($_POST['codigo'], 'text');

    if($infoQry <= 0){
        mysql_select_db($database_horizonte, $horizonte);
        $QryUpd = "UPDATE conceptos set codigo_barras_to = " . $codigo . " WHERE id_to = " . $id . " LIMIT 1";
        $update = mysql_query($QryUpd, $horizonte) or die (mysql_error());
    }
    if($update){
        echo 1;
    }else{
        echo "ocurrio un error";
    }
?>