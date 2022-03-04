<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

if(strlen($_GET['idP']) && strlen($_GET['edad']) ){
  $edad = $_GET['edad'];
  $idP = $_GET['idP'];
  $id_u = $_GET['id_u'];
  $sexo = $_GET['sexo'];
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

require('../../fpdf/fpdf.php');
class PDF extends FPDF
{
  // Cabecera de página
  function Header(){
     
      // Arial bold 15
      $this->SetFont('Arial','B',12);
      // Movernos a la derecha
      $this->Cell(45);
      // Título
      $this->Cell(100,10,'REPORTE DE SIGNOS VITALES',1,1,'C');
      // Salto de línea
      $this->Ln(20);

      $this->SetX(10);
      $this->Cell(30,10,'FECHA',1,0,'C');
      $this->Cell(30,10,'APLICO',1,0,'C');
      $this->Cell(20,10,'PESO',1,0,'C');
      $this->Cell(20,10,'TALLA',1,0,'C');
      $this->Cell(15,10,'IMC',1,0,'C');
      $this->Cell(20,10,'CINTURA',1,0,'C');
      $this->Cell(15,10,'T/A',1,0,'C');
      $this->Cell(15,10,'FC',1,0,'C');
      $this->Cell(15,10,'TEMP',1,0,'C');
      $this->Cell(10,10,'OXI',1,1,'C');
  }
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
$pdf->SetFont('Times','',9);

// $pdf->Cell(70,10,$id_h,0,1,'C');
$total = 0;
while ($fila = mysql_fetch_assoc($query)) {
  // $total = $total + $fila['precio_to'];
  $pdf->SetX(10);
  $pdf->Cell(30,10,$fila['Fecha'],1,0,'C');
  $pdf->Cell(30,10,$fila['usuario'],1,0,'C');
  $pdf->Cell(20,10,$fila['peso_sv'],1,0,'C');
  $pdf->Cell(20,10,$fila['talla_sv'],1,0,'C');
  $pdf->Cell(15,10,$fila['imc_sv'],1,0,'C');
  $pdf->Cell(20,10,$fila['cintura_sv'],1,0,'C');
  $pdf->Cell(15,10,$fila['t_sv']."/".$fila['a_sv'],1,0,'C');
  $pdf->Cell(15,10,$fila['fr_sv']."/".$fila['fc_sv'],1,0,'C');
  $pdf->Cell(15,10,$fila['temperatura_sv'],1,0,'C');
  $pdf->Cell(10,10,$fila['oximetria_sv'],1,1,'C');
}

$pdf->Cell(70,10,$id_h,0,1,'C');
$pdf->SetX(20);
$pdf->Cell(20,10,"PACIENTE: ",1,0,'C');
$pdf->Cell(95,10,$nombreP,1,0,'C');
$pdf->Cell(15,10,"EDAD:",1,0,'C');
$pdf->Cell(15,10,utf8_decode($edad),1,0,'C');
$pdf->Cell(30,10,utf8_decode($sexo),1,1,'C');

$pdf->SetX(20);
$pdf->Cell(20,10,"IMPRIMIO: ",1,0,'C');
$pdf->Cell(95,10,$rowtU[0],1,0,'C');
$pdf->Cell(30,10,utf8_decode('FECHA IMPRESIÓN'),1,0,'C');
$pdf->Cell(30,10,$now,1,1,'C');


$pdf->Output();
?>