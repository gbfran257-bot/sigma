<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $min = sqlValue($_POST["min"], "date");
    $max = sqlValue($_POST["max"], "date");

    mysql_select_db($database_horizonte, $horizonte);
    $resultAl = mysql_query("SELECT ovd.referencia_ov AS referencia, CONCAT_WS(' ', p.nombre_p, p.apaterno_p, p.amaterno_p) AS paciente, DATE_FORMAT(ovd.tiempo, '%d/%m/%Y %H:%i:%s') AS fecha_cancelada, ovd.motivo_del AS motivo FROM orden_venta_del ovd LEFT JOIN pacientes p on p.id_p = ovd.id_paciente_ov WHERE ovd.fecha_venta_ov BETWEEN $min AND $max ORDER BY ovd.tiempo DESC", $horizonte) or die (mysql_error());
    $salida = "";
    $cont = 1;
    while ($fila = mysql_fetch_assoc($resultAl)) {

    $salida.=    "<tr>".
                    "<td>". $cont . " </td>".
                    "<td>". $fila['referencia']. " </td>".
                    "<td> ". $fila['paciente'] ."</td> " .
                    "<td> ". $fila['fecha_cancelada'] ."</td> " .
                    "<td> ". $fila['motivo'] . " </td> ". 
                "</tr>";
    $cont++;
    }

    echo $salida;
?>