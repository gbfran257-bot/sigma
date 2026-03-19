<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_medicamento = sqlValue($_POST["id_medicamento"], "int");
$id_hospitalizacion = sqlValue($_POST["id_hospitalizacion"], "int");

mysql_select_db($database_horizonte, $horizonte);
$resultAl = mysql_query("SELECT CONCAT_WS(' ', u.nombre_u, u.apaterno_u) AS usuario, DATE_FORMAT(md.fecha_md, '%d/%m/%Y %H:%i:%s') AS fecha, CASE WHEN md.accion_md = 0 THEN 'SE CREA REGISTRO' WHEN md.accion_md = 1 THEN 'SE ACTUALIZA INDICACIÓN' END AS accion, md.dosis_md AS indicacion FROM modificaciones_dosis md LEFT JOIN usuarios u on u.id_u = md.usuario_md WHERE md.id_hospitalizacion_md = $id_hospitalizacion AND md.id_medicamento_md = $id_medicamento ORDER BY md.fecha_md DESC", $horizonte) or die (mysql_error());
$salida = "";
$cont = 1;
while ($fila = mysql_fetch_assoc($resultAl)) {

    $salida.=    "<tr>".
                    "<td>". $cont . " </td>".
                    "<td>". $fila['usuario']. " </td>".
                    "<td> ". $fila['fecha'] ."</td> " .
                    "<td> ". $fila['accion'] ."</td> " .
                    "<td> ". $fila['indicacion'] . " </td> ". 
                "</tr>";
    $cont++;
}

echo $salida;

?>