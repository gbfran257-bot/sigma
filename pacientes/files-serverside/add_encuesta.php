<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

    $now = sqlValue(date('Y-m-d H:i:s'), "date");
    $idp = sqlValue($_POST['idp'], "int");
    $idu = sqlValue($_POST['idu'], "int");
    $ref = sqlValue($_POST['ref'], "text");
    $comentarios = sqlValue($_POST['comentarios'], "text");
    $cont = 0;

    mysql_select_db($database_horizonte, $horizonte);
    $buscarEnc = mysql_query("SELECT encuesta_zapata FROM orden_venta WHERE referencia_ov = $ref", $horizonte) or die (mysql_error());
    $enc = mysql_fetch_row($buscarEnc);

    if($enc[0] == 1){
        echo "Esta encuesta ya fue realizada";
    }else{
        mysql_select_db($database_horizonte, $horizonte); 
        $preguntas = mysql_query("SELECT * FROM preguntas_encuesta WHERE clave_e = 1",$horizonte) or die (mysql_error());
        
        while ($fila = mysql_fetch_assoc($preguntas)){
            $clave_p = sqlValue($fila['clave_p'], "text");
            $respuesta = $_POST[$fila['clave_p']];
            if($cont>0){
                $comentarios = "NULL"; //para evitar tener el mismo comentario en todas las respuestas solo lo guardamos una vez
            }
            mysql_select_db($database_horizonte, $horizonte);
            $sql = "INSERT INTO respuestas_encuesta (clave_e_re, clave_p_re, id_p_re, id_u_re, fecha_re, respuesta_re, comentario_re, ref_re) VALUES (1, $clave_p, $idp, $idu, $now, $respuesta, $comentarios, $ref)";
            $insert = mysql_query($sql, $horizonte) or die (mysql_error());
            $cont++;
        }

        //guardamos en tabla OV si la encuesta se contesto
        mysql_select_db($database_horizonte, $horizonte);
        $qrySql = "UPDATE orden_venta SET encuesta_zapata = 1 WHERE referencia_ov = $ref LIMIT 1";
        $actualizar = mysql_query($qrySql, $horizonte) or die (mysql_error());
    
        if(!$insert){
            echo "ocurrio un error";
        }else{ 
            echo 1; 
        }
    
        mysql_close($horizonte);
    }

?>