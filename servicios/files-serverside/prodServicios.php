<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $fechaMin = sqlValue($_POST["fechaMin"], "date");
 $fechaMax = sqlValue($_POST["fechaMax"], "date");

 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "SELECT v.precio_vc, v.referencia_vc, p.nombre_completo_p, v.fecha_venta_vc FROM venta_conceptos v left join pacientes p on p.id_p = v.id_paciente_vc where v.id_concepto_es = $idP AND v.temporal_vc = 0 AND v.fecha_venta_vc BETWEEN $fechaMin AND $fechaMax";
 $resultC = mysql_query($sql, $horizonte) or die (mysql_error());
$salida =" <thead><th>REFERENCIAS</th><th>PRECIO</th><th>PACIENTE</th><th>FECHA VENTA</th></thead><tbody>";
while($fila = mysql_fetch_assoc($resultC)){
    $salida.=   "<tr><td>".$fila['referencia_vc']."</td>".
                "<td>".$fila['precio_vc']."</td>".
                "<td>".$fila['nombre_completo_p']."</td>".
                "<td>".$fila['fecha_venta_vc']."</td></tr>";
}
$salida.="</tbody>";

echo $salida;
// echo $sql;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>