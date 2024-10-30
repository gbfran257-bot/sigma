<?php
// Incluir la biblioteca FPDF
require('../../fpdf/fpdf.php');
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

// Crear una nueva instancia de la clase FPDF
$pdf = new FPDF();

// Añadir una página
$pdf->AddPage();

// Establecer la fuente (Arial, Negrita, Tamaño 16)
$pdf->SetFont('Arial', 'B', 16);

$id_usuario = intval($_GET['id_usuario']);
mysql_select_db($database_horizonte, $horizonte);
$resultC =mysql_query("SELECT usuario_u FROM usuarios WHERE id_u = $id_usuario ", $horizonte) or die (mysql_error());
$usuario = mysql_fetch_row($resultC);

// Añadir un texto (Centrado)
$pdf->Cell(0, 10, "REPORTE DE PEDIDO", 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
//$pdf->Cell(0, 10, "SUCURSAL: ". substr($_GET['nombre'],13,100), 0, 1, 'L');
$pdf->Cell(0, 10, "SUCURSAL: ". $_GET['nombre'], 0, 1, 'L');
$pdf->Cell(90, 10, 'IMPRIMIO: ' . $usuario[0], 0, 0, 'L');
$pdf->Cell(60, 10, 'FECHA: ' . date("Y-m-d"), 0, 1, 'L');
// Añadir otro texto (Izquierda)
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(0, 10, 'Este es un archivo PDF generado con FPDF.', 0, 1, 'L');


$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 10, 'PRODUCTO', 1, 0, 'L');
$pdf->Cell(70, 10, 'NOMBRE GENERICO', 1, 0, 'L');
$pdf->Cell(19, 10, 'EXISTENCIA', 1, 0, 'L');
$pdf->Cell(13, 10, 'MAXIMO', 1, 0, 'L');
$pdf->Cell(12, 10, 'MINIMO', 1, 0, 'L');
$pdf->Cell(12, 10, 'SURTIR', 1, 1, 'L');

/* for($i=1;$i<=100;$i++){
    $pdf->Cell(50, 10, $i, 1, 0, 'L');
    $pdf->Cell(50, 10, $i, 1, 0, 'L');
    $pdf->Cell(25, 10, $i, 1, 0, 'L');
    $pdf->Cell(25, 10, $i, 1, 0, 'L');
    $pdf->Cell(25, 10, $i, 1, 0, 'L');
    $pdf->Cell(20, 10, $i, 1, 1, 'L');
} */

$id_sucursal = $_GET['sucursal'];
$fecha = date("Y-m-d");
mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT s.id, c.concepto_to, g.nombre_generico_med, s.existencias, mms.max_mm, mms.min_mm, CAST(mms.max_mm AS SIGNED) - CAST(s.existencias AS SIGNED) as surtir, s.id_Producto, s.id_stock FROM stock_has_bach s left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g left join estatus es on es.id_est = s.estatus left join max_min_stock mms on mms.id_producto = s.id_Producto WHERE (s.fecha_update BETWEEN '2001-01-01' AND '$fecha') AND (s.es_traspaso = 0 AND s.id_stock = $id_sucursal) AND (existencias = 0 OR existencias < mms.min_mm) group by s.id_Producto ORDER BY concepto_to LIMIT 0, 500;";
$ejecutar_query = mysql_query($consulta, $horizonte);

//obtenemos id de sucursal
mysql_select_db($database_horizonte, $horizonte);
$query_sucursal =mysql_query("SELECT id_su from stock where id = " . $id_sucursal, $horizonte) or die (mysql_error());
$sucursal_data = mysql_fetch_row($query_sucursal);

// Recuperar datos de la consulta SQL e iterar sobre ellos
while ($resultado = mysql_fetch_assoc($ejecutar_query)) {
    //revisamos existencias totales y omitimos registros
    mysql_select_db($database_horizonte, $horizonte);
    $resultado_suma =mysql_query("SELECT SUM(existencias) FROM stock_has_bach WHERE id_Producto = ".$resultado['id_Producto']." AND id_stock = " . $resultado['id_stock'], $horizonte) or die (mysql_error());
    $sumatoria = mysql_fetch_row($resultado_suma);

    //maximos y minimos
    mysql_select_db($database_horizonte, $horizonte);
    $query_mm_s =mysql_query("SELECT min_mm, max_mm FROM max_min_stock WHERE id_suc = ".$sucursal_data[0]." AND id_producto = " . $resultado['id_Producto'], $horizonte) or die (mysql_error());
    $resultados_mm_s = mysql_fetch_row($query_mm_s);

    $surtir = $resultados_mm_s[1] - $sumatoria[0];

    if($surtir < 0){
        continue;
    }
    $pdf->Cell(60, 10, utf8_decode(substr($resultado['concepto_to'],0,35)), 1, 0, 'L');
    $pdf->Cell(70, 10, utf8_decode(substr($resultado['nombre_generico_med'],0,40)), 1, 0, 'L');
    $pdf->Cell(19, 10, $sumatoria[0], 1, 0, 'L');
    $pdf->Cell(13, 10, $resultados_mm_s[1], 1, 0, 'L');
    $pdf->Cell(12, 10, $resultados_mm_s[0], 1, 0, 'L');
    $pdf->Cell(12, 10, $surtir, 1, 1, 'L');
}

// Salida del PDF al navegador
$pdf->Output();
?>
