<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $id_pqx = sqlValue($_POST["id_pqx"], "int");

    $sql1="DELETE FROM personal_equipo_qx WHERE id_pqx = $id_pqx LIMIT 1";

    $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

    if(!$update1) {
        echo $sql1; 
    }else{
        echo 1;
    }
    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>