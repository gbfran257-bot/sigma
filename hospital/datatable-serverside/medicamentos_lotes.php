<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $id_mh = sqlValue($_POST["id_mh"], "int");
    $id_u = sqlValue($_POST["id_u"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $id_c = "SELECT id_medicamento_mh from medicamentos_hospital where id_mh = $id_mh";
    $id_concepto = mysql_query($id_c, $horizonte) or die (mysql_error());
    $id_con = mysql_fetch_row($id_concepto);
    $medicamento = $id_con[0];

    mysql_select_db($database_horizonte, $horizonte);
    $qry_id_stock = "SELECT s.id FROM usuarios u left join stock s on s.id_su = u.sucursal_hospital WHERE id_u = $id_u LIMIT 1";
    $exec_id_stock = mysql_query($qry_id_stock, $horizonte) or die (mysql_error());
    $result_id_stock = mysql_fetch_row($exec_id_stock);
    $id_stock = $result_id_stock[0];

    mysql_select_db($database_horizonte, $horizonte);
    $resultAl = mysql_query("SELECT shb.id, c.concepto_to, shb.Lote FROM stock_has_bach shb left join conceptos c on c.id_to = shb.id_Producto WHERE shb.id_Producto = $medicamento and shb.id_stock = $id_stock and shb.existencias > 0 group by shb.Lote", $horizonte) or die (mysql_error());
    $salida = "";
    $cont = 1;
    while ($fila = mysql_fetch_assoc($resultAl)) {

        $salida.=    "<tr>".
                        "<td>". $cont . " </td>".
                        "<td>". $fila['concepto_to']. " </td>".
                        "<td> ". $fila['Lote'] ."</td> " .
                        "<td><button type='button' class='btn btn-success btn-sm' onclick='aplicarMedNuevo($id_mh,$id_u,".$fila['id'].")'>Aplicar</button></td> " .
                    "</tr>";
        $cont++;
    }

    echo $salida;

?>