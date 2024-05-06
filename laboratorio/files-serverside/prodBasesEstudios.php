<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_b = sqlValue($_POST["id_b"], "int");
 $fechaMin = sqlValue($_POST["fechaMin"], "date");
 $fechaMax = sqlValue($_POST["fechaMax"], "date");

 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "SELECT v.id_vc, e.concepto_to, COUNT(b.id_b) FROM venta_conceptos v LEFT JOIN conceptos e ON e.id_to = v.id_concepto_es LEFT JOIN asignar_bases ab ON ab.id_estudio_ab = e.id_to LEFT JOIN bases b ON b.id_b = ab.id_base_ab WHERE v.fecha_venta_vc BETWEEN $fechaMin AND $fechaMax and e.id_tipo_concepto_to = 3 and v.temporal_vc=0 and b.id_b = $id_b GROUP BY concepto_to";
 $resultC = mysql_query($sql, $horizonte) or die (mysql_error());
$salida =" <thead><th>ESTUDIO</th><th>CANTIDAD</th></thead><tbody>";
while($fila = mysql_fetch_assoc($resultC)){
    $salida.=   "<tr><td>".$fila['concepto_to']."</td>".
                "<td>".$fila['COUNT(b.id_b)']."</td></tr>";
}
$salida.="</tbody>";

echo $salida;
// echo $sql;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>