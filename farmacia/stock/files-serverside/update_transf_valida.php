<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    $id_temporal = sqlValue($_POST['id_temporal'],"text");
 
    mysql_select_db($database_horizonte, $horizonte);
    $sql1 = "UPDATE transferencia_temporal SET transf_valida = 1 WHERE id_temporal = $id_temporal";
    $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

    if (!$update1) {
        echo $sql1; 
    }else{
        echo 1;
    }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>
