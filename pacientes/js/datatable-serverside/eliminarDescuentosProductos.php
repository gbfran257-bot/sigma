<?php

require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$idVentaConcepto = sqlValue($_POST['aleatorio'], 'text');

mysql_select_db($database_horizonte, $horizonte);
$queryResult = mysql_query(
    "UPDATE venta_conceptos
                            LEFT JOIN conceptos ON venta_conceptos.id_concepto_es = conceptos.id_to
                            LEFT JOIN departamentos ON conceptos.id_departamento_to = departamentos.id_d
                            LEFT JOIN catalogo_tipo_conceptos on conceptos.id_tipo_concepto_to = catalogo_tipo_conceptos.id_tc
                            SET venta_conceptos.descuento = 0, venta_conceptos.motivo_alteracion = ''
                            WHERE venta_conceptos.no_temp_vc = $idVentaConcepto
                                AND venta_conceptos.descuento > 0
                                AND venta_conceptos.motivo_alteracion != ''
                                AND conceptos.id_departamento_to = 3
                                AND catalogo_tipo_conceptos.id_tc = 5;",
    $horizonte
) or die(mysql_error());

echo json_encode($queryResult);

mysql_close($horizonte);
