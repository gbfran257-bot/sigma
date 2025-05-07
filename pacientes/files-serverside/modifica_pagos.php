<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $id = sqlValue($_POST["id"], "int");
    $pago = sqlValue($_POST["pago"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $query_upd = "UPDATE pagos_ov SET pago_pag = $pago WHERE id_pag = $id LIMIT 1"; 
    $execute_query_upd = mysql_query($query_upd, $horizonte) or die (mysql_error());

    if($execute_query_upd){
        echo 1;
    }else{
        echo "error";
    }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>