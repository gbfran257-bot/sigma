<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

    $id = sqlvalue($_POST['id'],'int');
    $cantidad = sqlValue($_POST['cantidad'], 'text');

    //actualizamos la cantidad del registro
    mysql_select_db($database_horizonte, $horizonte);
    $QryUpd ="UPDATE medicamentos_hospital SET cantidad_texto_mh = $cantidad WHERE id_mh = " . $id;
    $update = mysql_query($QryUpd, $horizonte) or die (mysql_error());

    if(!$update){
        echo $sql;
    }else{ 
        echo 1; 
    }
?>