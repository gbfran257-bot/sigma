<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_mh = sqlValue($_POST["id_mh"], "int");

mysql_select_db($database_horizonte, $horizonte);
$resultAl = mysql_query("SELECT u.usuario_u, DATE_FORMAT(s.fecha_s,'%d/%m/%Y %H:%i:%s') as fecha , s.nota_s, s.movimiento from suspension_medicamento_hospital s left join medicamentos_hospital mh on mh.id_mh = s.id_mh_s left join usuarios u on s.id_user_s = u.id_u left join conceptos c on c.id_to = mh.id_medicamento_mh where id_mh_s = $id_mh ", $horizonte) or die (mysql_error());
$salida = "";
$cont = 1;
while ($fila = mysql_fetch_assoc($resultAl)) {

    $salida.=    "<tr>".
                    "<td>". $cont . " </td>".
                    "<td>". $fila['usuario_u']. " </td>".
                    "<td> ". $fila['fecha'] ."</td> " .
                    "<td> ". $fila['movimiento'] ."</td> " .
                    "<td> ". $fila['nota_s'] . " </td> ". 
                "</tr>";
    $cont++;
}

echo $salida;

?>