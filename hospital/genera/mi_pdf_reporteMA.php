<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

if(strlen($_GET['id_h']) && strlen($_GET['nombre']) ){
  $id_h = $_GET['id_h'];
  $nombre_P = sqlValue($_GET['nombre'],'text');
  $id_u = $_GET['id_u'];
}

mysql_select_db($database_horizonte, $horizonte);
$consultaU = "SELECT usuario_u from usuarios WHERE id_u = $id_u";
$query1U = mysql_query($consultaU) or die (mysql_error());
$rowtU = mysql_fetch_row($query1U);

mysql_select_db($database_horizonte, $horizonte);
$consulta1 = "SELECT p.id_p, p.nombre_completo_p from pacientes p left join hospitalizacion h on h.id_paciente_h = p.id_p left join medicamentos_hospital m1 on m1.id_hospitalizacion_mh = h.id_h  WHERE  m1.id_hospitalizacion_mh = $id_h group by p.nombre_completo_p asc";
$query1 = mysql_query($consulta1) or die (mysql_error());
$rowt = mysql_fetch_row($query1);

$name = sqlValue($rowt[1],'text');
$now = date('Y-m-d H:i:s');


mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT m.id_mah, mc.concepto_to, m.id_mah, m.id_mah, u.usuario_u as aplico, DATE_FORMAT(m.fecha_mah,'%d/%m/%Y') as Fecha, m.id_mah, DATE_FORMAT(m.fecha_mah,'%H:%i:%s') as minutos ,mc.precio_to  from medicamentos_aplicados_hospi m left join medicamentos_hospital m1 on m1.id_mh = m.id_medicamento_hospital_mah left join conceptos mc on mc.id_to = m1.id_medicamento_mh left join usuarios u on u.id_u = m.id_usuario_mah left join titulos t on t.id_ti = u.id_titulo_u WHERE  m1.id_hospitalizacion_mh = $id_h";
$query = mysql_query($consulta) or die (mysql_error());

// Consultamos el diagnóstico y el médico tratante
mysql_select_db($database_horizonte, $horizonte);
$query_diagnostico_medico = "SELECT motivo_h, usuario_u FROM hospitalizacion h LEFT JOIN usuarios u ON h.id_usuario_h = u.id_u WHERE id_h = {$id_h}";
if (!$resultado_query_diagnostico_medico = mysql_query($query_diagnostico_medico, $horizonte)) {
  die(mysql_error());
}

$diagnostico_medico = mysql_fetch_object($resultado_query_diagnostico_medico);

require('../../fpdf/fpdf.php');
class PDF extends FPDF
{
// Pie de página
function Footer(){
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
  
}


// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Arial bold 15
$pdf->SetFont('Arial','B',12);
// Movernos a la derecha
$pdf->Cell(45);
// Título
$pdf->Cell(100,10,'Medicamentos Aplicados',1,0,'C');
// Salto de línea
$pdf->Ln(20);

$pdf->SetFont('Times','',7);

// $pdf->Cell(70,10,$id_h,0,1,'C');
$pdf->SetX(20);
$pdf->Cell(20,10,"PACIENTE: ",1,0,'C');
$pdf->Cell(95,10,$rowt[1],1,1,'C');

$pdf->SetX(20);
$pdf->Cell(20,10,"IMPRIMIO: ",1,0,'C');
$pdf->Cell(95,10,$rowtU[0],1,0,'C');
$pdf->Cell(30,10,iconv("UTF-8", "windows-1252", 'FECHA IMPRESIÓN'),1,0,'C');
$pdf->Cell(30,10,$now,1,1,'C');

$pdf->Ln(10);

$pdf->SetX(20);
$pdf->Cell(30,10, iconv("UTF-8", "windows-1252", "DIAGNÓSTICO:") ,1,0,'C');
$pdf->Cell(110,10,iconv("UTF-8", "windows-1252", $diagnostico_medico->motivo_h),1,1,'C');

$pdf->SetX(20);
$pdf->Cell(40,10, iconv("UTF-8", "windows-1252", "MÉDICO TRATANTE:") ,1,0,'C');
$pdf->Cell(100,10,iconv("UTF-8", "windows-1252", $diagnostico_medico->usuario_u),1,0,'C');

$pdf->Ln(20);

$pdf->SetX(20);
$pdf->Cell(80,10,'MEDICAMENTO',1,0,'C');
$pdf->Cell(35,10,'QUIEN APLICO',1,0,'C');
$pdf->Cell(40,10,'FECHA / HORA',1,0,'C');
$pdf->Cell(20,10,'PRECIO',1,1,'C');

$total = 0;
while ($fila = mysql_fetch_assoc($query)) {
  
  $total = $total + $fila['precio_to'];
  $pdf->SetX(20);
  $pdf->Cell(80,10,$fila['concepto_to'],1,0,'C');
  $pdf->Cell(35,10,$fila['aplico'],1,0,'C');
  $pdf->Cell(40,10,$fila['Fecha']." ".$fila['minutos'],1,0,'C');
  $pdf->Cell(20,10,$fila['precio_to'],1,1,'C');
}

$pdf->SetX(20);
$pdf->Cell(80,10,'TOTAL',1,0,'C');
$pdf->Cell(35,10,"",1,0,'C');
$pdf->Cell(40,10,"",1,0,'C');
$pdf->Cell(20,10,"$".$total,1,1,'C');

$pdf->Output();
?>
