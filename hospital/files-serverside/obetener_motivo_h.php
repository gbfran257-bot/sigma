<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $id_h = sqlValue($_POST["id_h"], "int");
    $id_u = sqlValue($_POST["id_u"], "int");

    mysql_select_db($database_horizonte, $horizonte); 
    $qrySuc = mysql_query("SELECT COALESCE(s.nombre_su, 'SIN SUCURSAL') FROM usuarios u LEFT JOIN sucursales s ON s.id_su = u.sucursal_hospital WHERE id_u = $id_u", $horizonte) or die (mysql_error());
    $rowSuc = mysql_fetch_row($qrySuc);

    mysql_select_db($database_horizonte, $horizonte);
    $result = mysql_query("SELECT motivo_h FROM hospitalizacion WHERE id_h = $id_h", $horizonte) or die (mysql_error());

    // Verificamos si hubo resultados
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_row($result);
        echo $row[0] . " SUCURSAL: " . $rowSuc[0]; // Mostramos el valor de motivo_h
    } else {
        echo "Motivo no encontrado SUCURSAL: " . $rowSuc[0];
    }

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>
