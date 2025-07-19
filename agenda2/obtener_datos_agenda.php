<?php
    require("../Connections/horizonte.php");
    require("../funciones/php/values.php");

    $id = sqlValue($_POST["id"], "int");
    
    mysql_select_db($database_horizonte, $horizonte);
    $result = mysql_query("SELECT telefono_paciente, nombre_paciente, direccion_paciente, email_paciente, inicio_normal, final_normal FROM agenda WHERE id = $id", $horizonte) or die (mysql_error());
    $row = mysql_fetch_row($result);

    $datos = $row[0].";}".$row[1].";}".$row[2].";}".$row[3].";}".$row[4].";}".$row[5];

    echo $datos;
    
    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>