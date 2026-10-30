<?php
// Incluir la clase FPDF
require('../../../fpdf/fpdf.php');
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

// Crear una instancia de la clase FPDF
$pdf = new FPDF();

// Agregar una página
$pdf->AddPage();

// Establecer fuente y tamaño de texto
$pdf->SetFont('Arial','B',14);

// Título
$pdf->Cell(0, 10, "FORMATO DE ENTREGA DE RESULTADOS LABORATORIO", 0, 1, 'C');

// Establecer fuente y tamaño de texto
$pdf->SetFont('Arial','B',10);

$pdf->Cell(0, 5, "DATOS DEL PACIENTE", 0, 1, 'C');

// Salto de línea
$pdf->Ln(3);

// Obtenemos la informacion
mysql_select_db($database_horizonte, $horizonte);
$query = "SELECT CONCAT(p.nombre_p, ' ', p.apaterno_p, ' ', p.amaterno_p) AS nombre, ov.expediente_externo, ov.folio_externo, cs.cat_sexo, DATE_FORMAT(p.fNac_p, '%d/%m/%Y') AS fnac, TIMESTAMPDIFF(YEAR, p.fNac_p, CURDATE()) AS edad, ov.referencia_ov, ov.usuario_ov FROM orden_venta ov LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov LEFT JOIN catalogo_sexos cs ON cs.id_sexo = p.sexo_p WHERE ov.id_ov = " . $_GET['id'];
if (!$resultado_query = mysql_query($query, $horizonte)) {
  die(mysql_error());
}
$informacion = mysql_fetch_object($resultado_query);

//obtenemos quien atendio
mysql_select_db($database_horizonte, $horizonte);
$query_atendio = "SELECT nombre_u FROM usuarios WHERE id_u = " . $informacion->usuario_ov;
$resultado_atendio = mysql_query($query_atendio, $horizonte);
$usuario_atendio = mysql_fetch_object($resultado_atendio);

//obtenemos numero de elementos
mysql_select_db($database_horizonte, $horizonte);
$query_nElementos = "SELECT count(c.concepto_to) AS numero from orden_venta o left join venta_conceptos v on v.referencia_vc = o.referencia_ov left join conceptos c on c.id_to = v.id_concepto_es where o.referencia_ov = '".$informacion->referencia_ov."' order by v.contador_vc ASC";
$resultado_nElementos = mysql_query($query_nElementos, $horizonte);
$elementos = mysql_fetch_object($resultado_nElementos);

// Establecer fuente y tamaño de texto
$pdf->SetFont('Arial', '', 9);

$pdf->Cell(95, 5, 'PACIENTE: '.utf8_decode($informacion->nombre), 0, 0, 'L');
$pdf->Cell(95, 5, 'ENTREGA: '. date("d/m/Y H:i"), 0, 1, 'L');

$pdf->Cell(48, 5, 'ATENDIO: '.utf8_decode($usuario_atendio->nombre_u), 0, 0, 'L');
$pdf->Cell(47, 5, 'EXP: '.utf8_decode($informacion->expediente_externo), 0, 0, 'L');
$pdf->Cell(47, 5, 'FOLIO: '.utf8_decode($informacion->folio_externo), 0, 0, 'L');
$pdf->Cell(48, 5, 'SERVICIO: '.utf8_decode($_GET['sucursal']), 0, 1, 'L');

$pdf->Cell(48, 5, 'SEXO: '.utf8_decode($informacion->cat_sexo), 0, 0, 'L');
$pdf->Cell(47, 5, 'F. NAC: '.utf8_decode($informacion->fnac), 0, 0, 'L');
$pdf->Cell(48, 5, 'EDAD: '.utf8_decode($informacion->edad).utf8_decode(" AÑOS"), 0, 1, 'L');

// Salto de línea
$pdf->Ln(1);

// Agregar línea horizontal
$pdf->SetLineWidth(0.5); // Establecer grosor de línea
$pdf->SetDrawColor(0, 0, 0); // Establecer color de línea (negro)
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Agregar línea horizontal

$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetX(20);
$pdf->Cell(150, 5, '# EXAMENES SOLICITADOS', 0, 0, 'L');
$pdf->Cell(20, 5, 'ENTREGADO', 0, 1, 'C');

$pdf->SetFont('Arial', '', 8);

mysql_select_db($database_horizonte, $horizonte);
$query_bitacora = "SELECT c.concepto_to, v.contador_vc from orden_venta o left join venta_conceptos v on v.referencia_vc = o.referencia_ov left join conceptos c on c.id_to = v.id_concepto_es where o.referencia_ov = '".$informacion->referencia_ov."' order by v.contador_vc ASC";
$ejecutar_bitacora = mysql_query($query_bitacora, $horizonte);

// Recuperar datos de la consulta SQL e iterar sobre ellos
while ($resultadoBitacora = mysql_fetch_assoc($ejecutar_bitacora)) {
    //limitamos el numero de caracteres del concepto_to
    $concepto = substr($resultadoBitacora['concepto_to'],0,90);
    $pdf->SetX(20);
    $pdf->Cell(150, 5, $resultadoBitacora['contador_vc'] . " " . utf8_decode($concepto), 0, 0, 'L');
    $pdf->Cell(20, 5, $pdf->Rect($pdf->GetX()+8, $pdf->GetY(), 4, 4), 0, 1, 'C');
}

if($elementos->numero < 3){
  $pdf->Ln(10 - $elementos->numero);
}

$pdf->Ln(5);

// Agregar línea horizontal
$pdf->SetLineWidth(0.5); // Establecer grosor de línea
$pdf->SetDrawColor(0, 0, 0); // Establecer color de línea (negro)
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Agregar línea horizontal

// Salto de línea
$pdf->Ln(5);

// Agregar línea horizontal
$pdf->SetLineWidth(0.1); // Establecer grosor de línea
$pdf->SetDrawColor(0, 0, 0); // Establecer color de línea (negro)
//$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Agregar línea horizontal

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(95, 5, 'NOMBRE Y FIRMA DE QUIEN ENTREGA', 0, 0, 'C');
$pdf->Cell(95, 5, 'NOMBRE Y FIRMA DE QUIEN RECIBE', 0, 1, 'C');

// Salto de línea
if($elementos->numero <= 11){
  $pdf->Ln(20);
}else{
  $pdf->Ln(10);
}


$pdf->Line(20, $pdf->GetY(), 100, $pdf->GetY()); // Línea izquierda
$pdf->Line(115, $pdf->GetY(), 195, $pdf->GetY()); // Línea derecha

//TERMINA PRIMERA PARTE

//obtenemos numero de elementos
mysql_select_db($database_horizonte, $horizonte);
$query_nElementos = "SELECT count(c.concepto_to) AS numero from orden_venta o left join venta_conceptos v on v.referencia_vc = o.referencia_ov left join conceptos c on c.id_to = v.id_concepto_es where o.referencia_ov = '".$informacion->referencia_ov."' order by v.contador_vc ASC";
$resultado_nElementos = mysql_query($query_nElementos, $horizonte);
$elementos = mysql_fetch_object($resultado_nElementos);

if($elementos->numero > 13){
    $pdf->AddPage();
}else if($elementos->numero > 11){
    $pdf->SetY(145); 
}else if($elementos->numero <= 11){
    $pdf->SetY(160); 
}
 
// Establecer fuente y tamaño de texto
$pdf->SetFont('Arial','B',14);

// Título
$pdf->Cell(0, 10, "FORMATO DE ENTREGA DE RESULTADOS LABORATORIO", 0, 1, 'C');

// Establecer fuente y tamaño de texto
$pdf->SetFont('Arial','B',10);

$pdf->Cell(0, 5, "DATOS DEL PACIENTE", 0, 1, 'C');

// Salto de línea
$pdf->Ln(3);

// Obtenemos la informacion
mysql_select_db($database_horizonte, $horizonte);
$query = "SELECT CONCAT(p.nombre_p, ' ', p.apaterno_p, ' ', p.amaterno_p) AS nombre, ov.expediente_externo, ov.folio_externo, cs.cat_sexo, DATE_FORMAT(p.fNac_p, '%d/%m/%Y') AS fnac, TIMESTAMPDIFF(YEAR, p.fNac_p, CURDATE()) AS edad, ov.referencia_ov, ov.usuario_ov FROM orden_venta ov LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov LEFT JOIN catalogo_sexos cs ON cs.id_sexo = p.sexo_p WHERE ov.id_ov = " . $_GET['id'];
if (!$resultado_query = mysql_query($query, $horizonte)) {
  die(mysql_error());
}
$informacion = mysql_fetch_object($resultado_query);

//obtenemos quien atendio
mysql_select_db($database_horizonte, $horizonte);
$query_atendio = "SELECT nombre_u FROM usuarios WHERE id_u = " . $informacion->usuario_ov;
$resultado_atendio = mysql_query($query_atendio, $horizonte);
$usuario_atendio = mysql_fetch_object($resultado_atendio);

// Establecer fuente y tamaño de texto
$pdf->SetFont('Arial', '', 9);

$pdf->Cell(95, 5, 'PACIENTE: '.utf8_decode($informacion->nombre), 0, 0, 'L');
$pdf->Cell(95, 5, 'ENTREGA: '. date("d/m/Y H:i"), 0, 1, 'L');

$pdf->Cell(48, 5, 'ATENDIO: '.utf8_decode($usuario_atendio->nombre_u), 0, 0, 'L');
$pdf->Cell(47, 5, 'EXP: '.utf8_decode($informacion->expediente_externo), 0, 0, 'L');
$pdf->Cell(47, 5, 'FOLIO: '.utf8_decode($informacion->folio_externo), 0, 0, 'L');
$pdf->Cell(48, 5, 'SERVICIO: '.utf8_decode($_GET['sucursal']), 0, 1, 'L');

$pdf->Cell(48, 5, 'SEXO: '.utf8_decode($informacion->cat_sexo), 0, 0, 'L');
$pdf->Cell(47, 5, 'F. NAC: '.utf8_decode($informacion->fnac), 0, 0, 'L');
$pdf->Cell(48, 5, 'EDAD: '.utf8_decode($informacion->edad).utf8_decode(" AÑOS"), 0, 1, 'L');

// Salto de línea
$pdf->Ln(1);

// Agregar línea horizontal
$pdf->SetLineWidth(0.5); // Establecer grosor de línea
$pdf->SetDrawColor(0, 0, 0); // Establecer color de línea (negro)
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Agregar línea horizontal

$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetX(20);
$pdf->Cell(150, 5, '# EXAMENES SOLICITADOS', 0, 0, 'L');
$pdf->Cell(20, 5, 'ENTREGADO', 0, 1, 'C');

$pdf->SetFont('Arial', '', 8);

mysql_select_db($database_horizonte, $horizonte);
$query_bitacora = "SELECT c.concepto_to, v.contador_vc from orden_venta o left join venta_conceptos v on v.referencia_vc = o.referencia_ov left join conceptos c on c.id_to = v.id_concepto_es where o.referencia_ov = '".$informacion->referencia_ov."' order by v.contador_vc ASC";
$ejecutar_bitacora = mysql_query($query_bitacora, $horizonte);

// Recuperar datos de la consulta SQL e iterar sobre ellos
while ($resultadoBitacora = mysql_fetch_assoc($ejecutar_bitacora)) {
    $concepto = substr($resultadoBitacora['concepto_to'],0,90);
    $pdf->SetX(20);
    $pdf->Cell(150, 5, $resultadoBitacora['contador_vc'] . " " . utf8_decode($concepto), 0, 0, 'L');
    $pdf->Cell(20, 5, $pdf->Rect($pdf->GetX()+8, $pdf->GetY(), 4, 4), 0, 1, 'C');
}

if($elementos->numero < 3){
  $pdf->Ln(10 - $elementos->numero);
}

$pdf->Ln(5);

// Agregar línea horizontal
$pdf->SetLineWidth(0.5); // Establecer grosor de línea
$pdf->SetDrawColor(0, 0, 0); // Establecer color de línea (negro)
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Agregar línea horizontal

// Salto de línea
$pdf->Ln(5);

// Agregar línea horizontal
$pdf->SetLineWidth(0.1); // Establecer grosor de línea
$pdf->SetDrawColor(0, 0, 0); // Establecer color de línea (negro)
//$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Agregar línea horizontal

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(95, 5, 'NOMBRE Y FIRMA DE QUIEN ENTREGA', 0, 0, 'C');
$pdf->Cell(95, 5, 'NOMBRE Y FIRMA DE QUIEN RECIBE', 0, 1, 'C');

// Salto de línea
if($elementos->numero <= 11){
  $pdf->Ln(20);
}else{
  $pdf->Ln(10);
}

$pdf->Line(20, $pdf->GetY(), 100, $pdf->GetY()); // Línea izquierda
$pdf->Line(115, $pdf->GetY(), 195, $pdf->GetY()); // Línea derecha


// Generar el PDF y mostrarlo en el navegador
$pdf->Output();
?>
