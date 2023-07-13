<?php

require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$idVentaConcepto = sqlValue($_GET['aleatorio'], 'text');

mysql_select_db($database_horizonte, $horizonte);
$queryResult = mysql_query("SELECT conceptos.concepto_to as nombre, motivo_alteracion AS concepto, descuento AS monto
                            FROM venta_conceptos
                            LEFT JOIN conceptos ON venta_conceptos.id_concepto_es = conceptos.id_to
                            LEFT JOIN departamentos ON conceptos.id_departamento_to = departamentos.id_d
                            LEFT JOIN catalogo_tipo_conceptos on conceptos.id_tipo_concepto_to = catalogo_tipo_conceptos.id_tc
                            WHERE no_temp_vc = $idVentaConcepto AND venta_conceptos.descuento > 0 AND venta_conceptos.motivo_alteracion != '' AND conceptos.id_departamento_to = 4 AND catalogo_tipo_conceptos.id_tc = 1",
                $horizonte) or die (mysql_error());

$descuentos = [];
$cont = 1;

while($descuento = mysql_fetch_object($queryResult)) {
    $descuento->num = $cont++;
    array_push($descuentos, $descuento);
}

echo json_encode($descuentos);

mysql_close($horizonte);

?>