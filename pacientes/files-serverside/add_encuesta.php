<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

    $now = sqlValue(date('Y-m-d H:i:s'), "date");

    mysql_select_db($database_horizonte, $horizonte); 
    $preguntas = mysql_query("SELECT * FROM preguntas_encuesta WHERE clave_e = 1",$horizonte) or die (mysql_error());
    
    while ($fila = mysql_fetch_assoc($preguntas)){
        $clave_p = sqlValue($fila['clave_p'], "text");
        $idp = sqlValue($_POST['idp'], "int");
        $idu = sqlValue($_POST['idu'], "int");
        $ref = sqlValue($_POST['ref'], "text");
        $respuesta = $_POST[$fila['clave_p']];

        mysql_select_db($database_horizonte, $horizonte);
        $sql = "INSERT INTO respuestas_encuesta (clave_e_re, clave_p_re, id_p_re, id_u_re, fecha_re, respuesta_re, comentario_re, ref_re) VALUES (1, $clave_p, $idp, $idu, $now, $respuesta, 'sdfsdf', $ref)";
        $insert = mysql_query($sql, $horizonte) or die (mysql_error());
    }

    if(!$insert){
        echo "ocurrio un error";
    }else{ 
        echo 1; 
    }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>