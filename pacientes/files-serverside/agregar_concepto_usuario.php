<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $now = sqlValue(date('Y-m-d H:i:s'), "date");
    $id_consulta = sqlValue($_POST["id_consulta"], "int");
    $usuario = sqlValue($_POST["usuario"], "int");
    $concepto = sqlValue($_POST["concepto"], "int");
    $precio = sqlValue($_POST["precio"], "double");
    
    $sql1="INSERT INTO personal_equipo_qx(id_pqx, id_consulta_pqx, usuario_pqx, precio_concepto_pqx, id_concepto_pqx, fecha_registro_pqx) VALUES (NULL, $id_consulta, $usuario, $precio, $concepto, $now)";

    $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

    if(!$update1) {
        echo $sql1; 
    }else{
        echo 1;
    }
    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>