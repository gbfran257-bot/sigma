<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $id = sqlValue($_POST["id"], "int");
    $pago = sqlValue($_POST["pago"], "double");
    $id_u = sqlValue($_POST["id_u"], "int");
    $motivo = sqlValue($_POST["motivo"], "text");
    $now = sqlValue(date('Y-m-d H:i:s'), "date");

    //buscamos la informacion que se insertara en la tabla historial_mod_pagos
    mysql_select_db($database_horizonte, $horizonte);
    $qry_search = mysql_query("SELECT pago_pag, referencia_pag, departamento_pa FROM pagos_ov WHERE id_pag = $id", $horizonte) or die (mysql_error());
    $get_qry_search = mysql_fetch_row($qry_search);

    $pago_pag = sqlValue($get_qry_search[0], "double");
    $referencia_pag = sqlValue($get_qry_search[1], "text");
    $departamento_pa = sqlValue($get_qry_search[2], "int");
    //insertamos los datos
    mysql_select_db($database_horizonte, $horizonte);
    $query_add_hmp = "INSERT INTO historial_mod_pagos (referencia_hmp, tipo_mov_hmp, abono_anterior_hmp, abono_nuevo_hmp, usuario_hmp, fecha_hmp, motivo_modificacion_hmp, departamento_hmp) VALUES ($referencia_pag, 1, $pago_pag, $pago, $id_u, $now, $motivo, $departamento_pa)"; 
    $execute_query_hmp = mysql_query($query_add_hmp, $horizonte) or die (mysql_error());

    //Actualizamos datos de la tabla pagos_ov
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