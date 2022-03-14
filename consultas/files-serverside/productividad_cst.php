<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idC = sqlValue($_POST["idC"], "int");
$min = sqlValue($_POST["min"], "date");
$max = sqlValue($_POST["max"], "date");


$sql = "SELECT v.id_vc , DATE_FORMAT(v.fecha_venta_vc,'%d/%c/%Y %H:%i:%s') as fecha_venta_vc, v.referencia_vc, concat(t.abreviacion_ti,' ',u.nombre_u, ' ', u.apaterno_u)as nombre from venta_conceptos v left join conceptos e on e.id_to = v.id_concepto_es left join usuarios u on u.id_u = v.usuarioEdo3_e left join titulos t on t.id_ti = u.id_titulo_u where e.id_tipo_concepto_to = 1 and v.temporal_vc=0 and e.id_to = $idC AND v.estatus_vc = 6 and  v.fecha_venta_vc BETWEEN $min AND $max";
mysql_select_db($database_horizonte, $horizonte); 
$resultCP = mysql_query($sql, $horizonte) or die (mysql_error());
$salida ='';
$cont = 1;
while($file = mysql_fetch_assoc($resultCP)){
    $salida.=   "<tr>". 
                    "<td>". 
                        $cont . 
                    "</td>".
                    "<td>". 
                        $file['referencia_vc']. "<br>". $file['fecha_venta_vc']. 
                    "</td>".
                    "<td>". 
                        $file['nombre'].
                    "</td>".
                "</td>";   
    $cont++;
   
}

echo $salida;

?>