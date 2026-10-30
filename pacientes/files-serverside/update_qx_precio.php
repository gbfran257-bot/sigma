<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $id_pqx = sqlValue($_POST["id_pqx"], "int");
    $precio = sqlValue($_POST["precio"], "double");

    $sql1="UPDATE personal_equipo_qx SET precio_concepto_pqx = $precio WHERE id_pqx = $id_pqx LIMIT 1";

    $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

    if(!$update1) {
        echo $sql1; 
    }else{
        echo 1;
    }
    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>