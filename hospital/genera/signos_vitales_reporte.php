<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

if(strlen($_GET['idP']) && strlen($_GET['edad']) ){
  $edad = $_GET['edad'];
  $idP = $_GET['idP'];
  $id_u = $_GET['id_u'];
  $sexo = $_GET['sexo'];
  $id_h_sv = $_GET['id_h_sv'];
}

mysql_select_db($database_horizonte, $horizonte);
$consultaP = "SELECT nombre_completo_p from pacientes WHERE id_p = $idP";
$query1P = mysql_query($consultaP) or die (mysql_error());
$rowtP = mysql_fetch_row($query1P);

mysql_select_db($database_horizonte, $horizonte);
$consultaU = "SELECT usuario_u from usuarios WHERE id_u = $id_u";
$query1U = mysql_query($consultaU) or die (mysql_error());
$rowtU = mysql_fetch_row($query1U);

mysql_select_db($database_horizonte, $horizonte);
$consulta1 = "SELECT DATE_FORMAT(fecha_sv,'%d/%m/%Y %H:%i:%s') as Fecha, usuario_u as usuario, peso_sv, talla_sv,imc_sv, cintura_sv, t_sv,a_sv, fr_sv, fc_sv, temperatura_sv, oximetria_sv FROM signos_vitales LEFT JOIN usuarios on id_u = id_usuario_sv WHERE id_paciente_sv = $idP order by id_sv desc limit 10 ";

$query = mysql_query($consulta1) or die (mysql_error());
$rowt = mysql_fetch_row($query1);

// $name = sqlValue($rowt[1],'text');
$now = date('Y-m-d H:i:s');
$nombreP= $rowtP[0];

// Consultamos el diagnóstico y el médico tratante
mysql_select_db($database_horizonte, $horizonte);
$query_diagnostico_medico = "SELECT motivo_h, usuario_u FROM hospitalizacion h LEFT JOIN usuarios u ON h.id_usuario_h = u.id_u WHERE id_h = {$id_h_sv}";
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
$pdf->Cell(100,10,'REPORTE DE SIGNOS VITALES',1,1,'C');
// Salto de línea

$pdf->SetFont('Times','',9);

$pdf->Cell(70,10,$id_h,0,1,'C');
$pdf->SetX(20);
$pdf->Cell(20,10,"PACIENTE: ",1,0,'C');
$pdf->Cell(95,10,$nombreP,1,0,'C');
$pdf->Cell(15,10,"EDAD:",1,0,'C');
$pdf->Cell(15,10,iconv("UTF-8", "windows-1252", $edad),1,0,'C');
$pdf->Cell(30,10,iconv("UTF-8", "windows-1252", $sexo),1,1,'C');

$pdf->SetX(20);
$pdf->Cell(20,10,"IMPRIMIO: ",1,0,'C');
$pdf->Cell(95,10,$rowtU[0],1,0,'C');
$pdf->Cell(30,10,iconv("UTF-8", "windows-1252", 'FECHA IMPRESIÓN'),1,0,'C');
$pdf->Cell(30,10,$now,1,1,'C');

$pdf->SetX(20);
$pdf->Cell(30,10, iconv("UTF-8", "windows-1252", "DIAGNÓSTICO") ,1,0,'C');
$pdf->Cell(145,10,iconv("UTF-8", "windows-1252", $diagnostico_medico->motivo_h),1,1,'C');
$pdf->SetX(20);
$pdf->Cell(40,10, iconv("UTF-8", "windows-1252", "MÉDICO TRATANTE") ,1,0,'C');
$pdf->Cell(135,10,iconv("UTF-8", "windows-1252", $diagnostico_medico->usuario_u),1,1,'C');

$pdf->Ln(10);

$pdf->SetX(10);
$pdf->Cell(30,10,'FECHA',1,0,'C');
$pdf->Cell(30,10,'APLICO',1,0,'C');
$pdf->Cell(20,10,'PESO',1,0,'C');
$pdf->Cell(20,10,'TALLA',1,0,'C');
$pdf->Cell(15,10,'IMC',1,0,'C');
$pdf->Cell(20,10,'CINTURA',1,0,'C');
$pdf->Cell(15,10,'T/A',1,0,'C');
$pdf->Cell(15,10,'FC',1,0,'C');
$pdf->Cell(15,10,'TEMP',1,0,'C');
$pdf->Cell(10,10,'OXI',1,1,'C');

// $pdf->Cell(70,10,$id_h,0,1,'C');
$total = 0;

$signos_vitales = mysql_fetch_array($query);
$num_signos_vitales = count($signos_vitales);
$limite_signos_vitales = $num_signos_vitales > 10 ? 10 : $num_signos_vitales;

for ($i = 0; $i < $limite_signos_vitales; $i++) {
  $pdf->SetX(10);
  $pdf->Cell(30,10,$signos_vitales[0],1,0,'C');
  $pdf->Cell(30,10,$signos_vitales[1],1,0,'C');
  $pdf->Cell(20,10,$signos_vitales[2],1,0,'C');
  $pdf->Cell(20,10,$signos_vitales[3],1,0,'C');
  $pdf->Cell(15,10,$signos_vitales[4],1,0,'C');
  $pdf->Cell(20,10,$signos_vitales[5],1,0,'C');
  $pdf->Cell(15,10,$signos_vitales[6]."/".$fila['a_sv'],1,0,'C');
  $pdf->Cell(15,10,$signos_vitales[7]."/".$fila['fc_sv'],1,0,'C');
  $pdf->Cell(15,10,$signos_vitales[8],1,0,'C');
  $pdf->Cell(10,10,$signos_vitales[9],1,1,'C');
}

$pdf->Output();
?>