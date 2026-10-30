<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $min = sqlValue($_POST["min"], "date");
    $max = sqlValue($_POST["max"], "date");

    mysql_select_db($database_horizonte, $horizonte);
    $resultAl = mysql_query("SELECT ov.referencia_ov AS referencia, CONCAT_WS(' ', p.nombre_p, p.apaterno_p, p.amaterno_p) AS paciente, ov.gran_total_ov AS total, sum(pag.pago_pag) AS abonado, ov.gran_total_ov - sum(pag.pago_pag) AS saldo, s.nombre_su AS sucursal FROM orden_venta ov LEFT JOIN pagos_ov pag on pag.referencia_pag = ov.referencia_ov LEFT JOIN pacientes p on p.id_p = ov.id_paciente_ov LEFT JOIN sucursales s on s.id_su = ov.sucursal_ov WHERE ov.fecha_venta_ov BETWEEN $min AND $max GROUP BY ov.referencia_ov HAVING SUM(pag.pago_pag) < ov.gran_total_ov ORDER BY ov.fecha_venta_ov DESC", $horizonte) or die (mysql_error());
    $salida = "";
    $cont = 1;
    while ($fila = mysql_fetch_assoc($resultAl)) {

    $salida.=    "<tr>".
                    "<td>". $cont . " </td>".
                    "<td>". $fila['referencia']. " </td>".
                    "<td> ". $fila['paciente'] ."</td> " .
                    "<td> ". $fila['total'] ."</td> " .
                    "<td> ". $fila['abonado'] ."</td> " .
                    "<td> ". $fila['saldo'] ."</td> " .
                    "<td> ". $fila['sucursal'] ."</td> " .
                "</tr>";
    $cont++;
    }

    echo $salida;
?>