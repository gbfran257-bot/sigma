<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    if (isset($_POST['lista_pacientes'])) {
        $checkboxes = $_POST['lista_pacientes'];
        if (is_array($checkboxes)) {
            //variables para la ov y conceptos
            $id_sucursal = sqlValue($_POST['id_sucursal'], "int");
            $id_usuario = sqlValue($_POST['id_usuario'], "int");
            $precio_sucursal = $id_sucursal . "_precio";
            //variables que simulan milisegundos
            $conteo = 0;
            $contador_vc = 0;
            $milisegundos = "";
            $correos_no_enviados = "Correos no enviados a: ";
            $no_enviados = 0;
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

                //obtenemos datos para ingresar en la ov
                mysql_select_db($database_horizonte, $horizonte);
                $qry_precio_total = mysql_query("SELECT COALESCE(SUM($precio_sucursal), 0), COUNT(*) FROM conceptos WHERE concepto_to LIKE 'CUESTIONARIO%' OR concepto_to LIKE 'cuestionario%'", $horizonte) or die(mysql_error());
                $precio_total = mysql_fetch_row($qry_precio_total);
                
                //creamos la orden de venta
                mysql_select_db($database_horizonte, $horizonte);
                $sql = "INSERT INTO orden_venta(total_c, subtotal_ov, gran_total_ov, sub_total_c, usuario_ov, id_paciente_ov, fecha_venta_ov, adicionales_c_ov, p_desc_cta, desc_d_cta, t_desc_cta, motivo_c_ov, medico_c_ov, referencia_ov, contador_ov, sucursal_ov, no_temp_ov, total_ei, total_el, total_s, sub_total_i, sub_total_l, sub_total_s, adicionales_ei_ov, adicionales_el_ov, adicionales_s_ov, medico_ei_ov, medico_el_ov, personal_s_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, p_desc_img, desc_d_img, t_desc_img, p_desc_lab, desc_d_lab, t_desc_lab, p_desc_serv, desc_d_serv, t_desc_serv, iva_ov, total_p, sub_total_p, adicionales_p_ov, p_desc_pro, desc_d_pro, t_desc_pro, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov, folio_externo, expediente_externo, doctor, cedula) VALUES (0, $precio_total[0], $precio_total[0], 0, $id_usuario, $id, $now, 0, 0, 0, 0, NULL, 1, ".$noRef.", $contador, $id_sucursal, '$aleatorio', 0, $precio_total[0], 0, 0, $precio_total[0], 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";  
                $update = mysql_query($sql, $horizonte) or die (mysql_error());

                //creamos los pagos
                mysql_select_db($database_horizonte, $horizonte); 
                $sqlF4 = "INSERT INTO pagos_ov(pago_pag, usuario_pag, fecha_pag, referencia_pag, no_temp_pag, forma_pago_pag, departamento_pa) VALUES ('0', $id_usuario, $now, ".$noRef.", '$aleatorio', '1','1')";
                $insertarF4 = mysql_query($sqlF4, $horizonte) or die (mysql_error());

                //creamos los conceptos
                mysql_select_db($database_horizonte, $horizonte);
                $qry_count_conceptos = "SELECT id_to, COALESCE( $precio_sucursal ,0) FROM conceptos WHERE concepto_to LIKE 'CUESTIONARIO%' OR concepto_to LIKE 'cuestionario%'";
                $conceptos_ov = mysql_query($qry_count_conceptos) or die (mysql_error());

                while ($fila = mysql_fetch_row($conceptos_ov)) {
                    $contador_vc+=1;
                    mysql_select_db($database_horizonte, $horizonte); 
                    $sql="INSERT INTO venta_conceptos(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios,cantidad,id_vc_shb, referencia_vc, temporal_vc, contador_vc)";
                    $sql.="VALUES ('$aleatorio', $id, $id_usuario, 1, ".$fila[0].", 1, NULL, $now, ".$fila[1].",  $id_usuario, $now, 0, 1, 0, $noRef, 0, $contador_vc)";
                    //var_dump($sql);
                    $sql_1="INSERT INTO venta_conceptos_1(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios,cantidad,id_vc_shb, referencia_vc, temporal_vc, contador_vc)";
                    $sql_1.="VALUES ('$aleatorio', $id, $id_usuario, 1, ".$fila[0].", 1, NULL, $now, ".$fila[1].",  $id_usuario, $now, 0, 1, 0, $noRef, 0, $contador_vc)";
                        
                    $update = mysql_query($sql, $horizonte) or die (mysql_error());
                    $update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
                }
                $contador_vc = 0;

                //obtenemos correo
                mysql_select_db($database_horizonte, $horizonte);
                $qry_datos_paciente = mysql_query("SELECT COUNT(*), email_p FROM pacientes WHERE id_p = $id AND email_p IS NOT NULL", $horizonte) or die(mysql_error());
                $datos_paciente = mysql_fetch_row($qry_datos_paciente);
                //obtenemos ultimo id_ov agregado
                mysql_select_db($database_horizonte, $horizonte);
                $qry_ultimo_id = mysql_query("SELECT id_ov FROM orden_venta ORDER BY id_ov DESC LIMIT 1", $horizonte) or die(mysql_error());
                $ultimo_id = mysql_fetch_row($qry_ultimo_id);

                if($datos_paciente[0] > 0){
                    
                    /* $mensaje = "Ingresa al siguiente enlace https://gloss-323916.web.app/ y escribe el codigo de acceso $ultimo_id[0] para comenzar tu cuestionario";
                    
                    $enviado = mail($datos_paciente[1],"CODIGO DE CUESTIONARIOS",$mensaje);

                    
                    if(!$enviado){
                        $correos_no_enviados = $correos_no_enviados . $datos_paciente[1] . ", ";
                        $no_enviados++;
                    }else{
                        
                        mysql_select_db($database_horizonte, $horizonte);
                        $qry_registro_enviado = mysql_query("SELECT COUNT(*) FROM historial_emails WHERE id_p_he = $id", $horizonte) or die(mysql_error());
                        $registro_enviado = mysql_fetch_row($qry_registro_enviado);

                        
                        if ($registro_enviado[0] == 0){
                            mysql_select_db($database_horizonte, $horizonte);
                            $qry_ins_reg = "INSERT INTO historial_emails (id_p_he, fecha_he, usuario_he) VALUES ($id, $now, $id_usuario)";  
                            $ins_reg = mysql_query($qry_ins_reg, $horizonte) or die (mysql_error());
                        }else if($registro_enviado[0] > 0){
                            mysql_select_db($database_horizonte, $horizonte);
                            $qry_upd_reg = "UPDATE historial_emails SET fecha_he = $now WHERE id_p_he = $id LIMIT 1";  
                            $upd_reg = mysql_query($qry_upd_reg, $horizonte) or die (mysql_error());
                        }
                    } */

                    $api_key = '';

                    $data = [
                        'from' => 'SIGMA NOM35 <sigmanom35@desarrollodpp.com>',
                        'to' => [$datos_paciente[1]],
                        'subject' => 'Código de acceso',
                        'html' => "<p>Ingresa al siguiente enlace https://gloss-323916.web.app/ y escribe el codigo de acceso <strong> $ultimo_id[0] </strong> para comenzar tu cuestionario</p>"
                    ];

                    $ch = curl_init('https://api.resend.com/emails');

                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $api_key,
                        'Content-Type: application/json',
                    ]);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    $response = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if(!curl_errno($ch)) {
                        mysql_select_db($database_horizonte, $horizonte);
                        $qry_registro_enviado = mysql_query("SELECT COUNT(*) FROM historial_emails WHERE id_p_he = $id", $horizonte) or die(mysql_error());
                        $registro_enviado = mysql_fetch_row($qry_registro_enviado);
                        if ($registro_enviado[0] == 0){
                            mysql_select_db($database_horizonte, $horizonte);
                            $qry_ins_reg = "INSERT INTO historial_emails (id_p_he, fecha_he, usuario_he) VALUES ($id, $now, $id_usuario)";  
                            $ins_reg = mysql_query($qry_ins_reg, $horizonte) or die (mysql_error());
                        }else if($registro_enviado[0] > 0){
                            mysql_select_db($database_horizonte, $horizonte);
                            $qry_upd_reg = "UPDATE historial_emails SET fecha_he = $now WHERE id_p_he = $id LIMIT 1";  
                            $upd_reg = mysql_query($qry_upd_reg, $horizonte) or die (mysql_error());
                        }
                    }else{
                        $correos_no_enviados = $correos_no_enviados . $datos_paciente[1] . ", ";
                        $no_enviados++;
                    }

                    curl_close($ch);

                }

                //sleep(1);
                $conteo++;
                usleep(500000); // Espera 0.5 segundos (500 milisegundos)
            }

            if($no_enviados == 0){
                $correos_no_enviados = "";
            }

            echo 1 . ';-{'.$correos_no_enviados;
        }
    } else {
        echo "No se seleccionaron registros.";
    }

?>