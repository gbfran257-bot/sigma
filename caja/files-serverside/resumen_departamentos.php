<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $min = sqlValue($_POST["min"], "date");
    $max = sqlValue($_POST["max"], "date");
    $id_departamento = sqlValue($_POST["id_departamento"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $resultAl = mysql_query("SELECT pag.referencia_pag AS referencia, CONCAT_WS(' ', p.nombre_p, p.apaterno_p, p.amaterno_p) AS paciente, pag.pago_pag AS pago, DATE_FORMAT(pag.fecha_pag, '%d/%m/%Y %H:%i') AS fecha FROM pagos_ov pag LEFT JOIN orden_venta ov ON ov.referencia_ov = pag.referencia_pag LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov WHERE pag.fecha_pag BETWEEN $min AND $max AND pag.pago_pag > 0 AND pag.departamento_pa = $id_departamento ORDER BY pag.fecha_pag DESC", $horizonte) or die (mysql_error());
    $salida = "";
    $cont = 1;
    while ($fila = mysql_fetch_assoc($resultAl)) {

    $salida.=    "<tr>".
                    "<td>". $cont . " </td>".
                    "<td>". $fila['referencia']. " </td>".
                    "<td> ". $fila['paciente'] ."</td> " .
                    "<td> ". $fila['pago'] ."</td> " .
                    "<td> ". $fila['fecha'] ."</td> " .
                "</tr>";
    $cont++;
    }

    echo $salida;
?>