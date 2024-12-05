<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

    $check = sqlvalue($_POST['check'],'int');
    $id_mah = sqlvalue($_POST['id_mah'],'int');
    $valor = 0;
    //actualizamos el campo check_adicional

    if($check==0){
        $valor = 1;
    }else if($check==1){
        $valor = 0;
    }

    mysql_select_db($database_horizonte, $horizonte);
    $QryUpd ="UPDATE medicamentos_aplicados_hospi SET check_adicional = $valor WHERE id_mah = " . $id_mah . " LIMIT 1";
    $update = mysql_query($QryUpd, $horizonte) or die (mysql_error());

    if(!$update){
        echo $sql;
    }else{ 
        echo 1; 
    }
?>