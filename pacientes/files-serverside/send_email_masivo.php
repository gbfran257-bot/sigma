<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    /* $id = sqlValue($_POST["id"], "int");
    $pago = sqlValue($_POST["pago"], "int");
    $id_u = sqlValue($_POST["id_u"], "int");
    $motivo = sqlValue($_POST["motivo"], "text");
    $now = sqlValue(date('Y-m-d H:i:s'), "date");

    mysql_select_db($database_horizonte, $horizonte);
    $qry_search = mysql_query("SELECT pago_pag, referencia_pag, departamento_pa FROM pagos_ov WHERE id_pag = $id", $horizonte) or die (mysql_error());
    $get_qry_search = mysql_fetch_row($qry_search);

    $pago_pag = sqlValue($get_qry_search[0], "double");
    $referencia_pag = sqlValue($get_qry_search[1], "text");
    $departamento_pa = sqlValue($get_qry_search[2], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $query_add_hmp = "INSERT INTO historial_mod_pagos (referencia_hmp, tipo_mov_hmp, abono_anterior_hmp, abono_nuevo_hmp, usuario_hmp, fecha_hmp, motivo_modificacion_hmp, departamento_hmp) VALUES ($referencia_pag, 1, $pago_pag, $pago, $id_u, $now, $motivo, $departamento_pa)"; 
    $execute_query_hmp = mysql_query($query_add_hmp, $horizonte) or die (mysql_error());

    mysql_select_db($database_horizonte, $horizonte);
    $query_upd = "UPDATE pagos_ov SET pago_pag = $pago WHERE id_pag = $id LIMIT 1"; 
    $execute_query_upd = mysql_query($query_upd, $horizonte) or die (mysql_error());

    if($execute_query_upd){
        echo 1;
    }else{
        echo "error";
    }

    mysql_close($horizonte); */


if (isset($_POST['lista_pacientes'])) {
    $checkboxes = $_POST['lista_pacientes'];
    if (is_array($checkboxes)) {
        //variables que simulan milisegundos
        $conteo = 0;
        $milisegundos = "";
        foreach ($checkboxes as $id) {
            //obtenemos la referencia
            $contador = 0; 
            $noRef=0;
            $now = sqlValue(date('Y-m-d H:i:s'), "date"); 
            $fecha1="'".date('Y-m-d')." 00:00:00"."'";
            $fecha2="'".date('Y-m-d')." 23:59:59"."'"; 
            $da=date('Ymd');
        
            mysql_select_db($database_horizonte, $horizonte);
            $resultR = mysql_query("SELECT count(id_ov) from orden_venta where fecha_venta_ov between ".$fecha1." and ".$fecha2." ", $horizonte) or die(mysql_error());
            $rowR = mysql_fetch_row($resultR);
           
            if($rowR[0]==0){
                $noRef=$da."-"."1";
                $noRef="'".$noRef."'";
                $contador = 1;
            }else{
                $daa=$rowR[0]+1;
                $noRef=$da."-".$daa;
                $noRef="'".$noRef."'";
                $contador = $daa;
            }

            //obtenemos el aleatorio
            if($conteo <=9){
                $milisegundos = "0" . "$conteo";
            }else{
                $milisegundos = "$conteo";
            }
            $fecha = new DateTime();
            $aleatorio = $fecha->format('Y-m-d-H-i-s') . '-' . "$milisegundos";
            
            //creamos la orden de venta
            mysql_select_db($database_horizonte, $horizonte);
            $sql = "INSERT INTO orden_venta(total_c, subtotal_ov, gran_total_ov, sub_total_c, usuario_ov, id_paciente_ov, fecha_venta_ov, adicionales_c_ov, p_desc_cta, desc_d_cta, t_desc_cta, motivo_c_ov, medico_c_ov, referencia_ov, contador_ov, sucursal_ov, no_temp_ov, total_ei, total_el, total_s, sub_total_i, sub_total_l, sub_total_s, adicionales_ei_ov, adicionales_el_ov, adicionales_s_ov, medico_ei_ov, medico_el_ov, personal_s_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, p_desc_img, desc_d_img, t_desc_img, p_desc_lab, desc_d_lab, t_desc_lab, p_desc_serv, desc_d_serv, t_desc_serv, iva_ov, total_p, sub_total_p, adicionales_p_ov, p_desc_pro, desc_d_pro, t_desc_pro, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov, folio_externo, expediente_externo, doctor, cedula) VALUES (0, 0, 0, 0, 1, $id, $now, 0, 0, 0, 0, NULL, 1, ".$noRef.", $contador, 4, '$aleatorio', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";  
            $update = mysql_query($sql, $horizonte) or die (mysql_error());

            //sleep(1);
            $conteo++;
            usleep(500000); // Espera 0.5 segundos (500 milisegundos)
        }
        echo 1;
    }
} else {
    echo "No se recibieron datos.";
}

?>