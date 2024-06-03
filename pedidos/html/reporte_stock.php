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
$resultC =mysql_query("SELECT usuario_u FROM usuarios WHERE id_u = $id_usuario ", $horizonte) or die (mysql_error());
$usuario = mysql_fetch_row($resultC);

// Añadir un texto (Centrado)
$pdf->Cell(0, 10, "REPORTE DE PEDIDO", 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "SUCURSAL: ". substr($_GET['nombre'],13,100), 0, 1, 'L');
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

$consulta = "SELECT s.id, c.concepto_to, g.nombre_generico_med, s.existencias, mms.max_mm, mms.min_mm, CAST(mms.max_mm AS SIGNED) - CAST(s.existencias AS SIGNED) as surtir FROM stock_has_bach s left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g left join estatus es on es.id_est = s.estatus left join max_min_stock mms on mms.id_producto = s.id_Producto WHERE (s.fecha_update BETWEEN '2001-01-01' AND '$fecha') AND (s.es_traspaso = 0 AND s.id_stock = $id_sucursal) AND (existencias = 0 OR existencias < mms.min_mm) order by s.id desc LIMIT 0, 500;";
$ejecutar_query = mysql_query($consulta, $horizonte);

// Recuperar datos de la consulta SQL e iterar sobre ellos
while ($resultado = mysql_fetch_assoc($ejecutar_query)) {
    $pdf->Cell(60, 10, substr($resultado['nombre_generico_med'],0,35), 1, 0, 'L');
    $pdf->Cell(70, 10, substr($resultado['concepto_to'],0,40), 1, 0, 'L');
    $pdf->Cell(19, 10, $resultado['existencias'], 1, 0, 'L');
    $pdf->Cell(13, 10, $resultado['max_mm'], 1, 0, 'L');
    $pdf->Cell(12, 10, $resultado['min_mm'], 1, 0, 'L');
    $pdf->Cell(12, 10, $resultado['surtir'], 1, 1, 'L');
}

// Salida del PDF al navegador
$pdf->Output();
?>
