<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$id_rh = sqlValue($_POST["id_rh"],"int");
 
mysql_select_db($database_horizonte, $horizonte);
$res_total = mysql_query("SELECT SUM(ov.gran_total_ov) FROM orden_venta ov LEFT JOIN rel_referencias_hospital rrh ON rrh.referencia_rrh = ov.referencia_ov WHERE rrh.id_rh_rrh = $id_rh", $horizonte) or die (mysql_error());
$dato_t = mysql_fetch_row($res_total);

mysql_select_db($database_horizonte, $horizonte);
$res_abono = mysql_query("SELECT SUM(cantidad_abonada_arh) FROM abonos_referencias_hospital WHERE id_rh_arh = $id_rh", $horizonte) or die (mysql_error());
$dato_a = mysql_fetch_row($res_abono);

//obtenemos los pagos de las referencias
mysql_select_db($database_horizonte, $horizonte);
$result_pagos_ov = mysql_query("SELECT SUM(pag.pago_pag) FROM pagos_ov pag LEFT JOIN rel_referencias_hospital rrh ON rrh.referencia_rrh = pag.referencia_pag WHERE rrh.id_rh_rrh = $id_rh", $horizonte) or die (mysql_error());
$datos_pagos_ov = mysql_fetch_row($result_pagos_ov);

/* $saldo = $dato_t[0] - $dato_a[0]; */
$saldo = ($dato_t[0] - $datos_pagos_ov[0]) - $dato_a[0];

/* $total = $dato_t[0] - $datos_pagos_ov[0]; */

$total = $dato_t[0];
$sumatoria = $datos_pagos_ov[0] + $dato_a[0];
$sumatoria = number_format($sumatoria, 2);

echo number_format($total, 2).'*}'.number_format($dato_a[0], 2).'*}'.number_format($saldo, 2).'*}'.number_format($datos_pagos_ov[0], 2).'*}'.$sumatoria;

?>