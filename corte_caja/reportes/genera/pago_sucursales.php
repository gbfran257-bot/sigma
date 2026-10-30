<?php
require_once('../../../Connections/horizonte.php');
require("../../../funciones/php/values.php");

if(!empty(strlen($_GET['nameSucu']) && strlen($_GET['min'] && strlen($_GET['max'])))){
  $nameSucu = $_GET['nameSucu'];
  $min = $_GET['min'];
  $max = $_GET['max'];
  $id_u =$_GET['id_u'];
  $swhere=" WHERE p.fecha_pag BETWEEN '$min' AND '$max' AND s.nombre_su LIKE \"%".$nameSucu."%\"";
}else{
  $min = $_GET['min'];
  $max = $_GET['max'];
  $id_u =$_GET['id_u'];
  $swhere=" WHERE p.fecha_pag BETWEEN '$min' AND '$max' ";
}
$now = date('Y-m-d H:i:s');

mysql_select_db($database_horizonte, $horizonte);
$consultaP = "SELECT s.nombre_su, COUNT(p.id_pag) as Nventas, SUM(p.pago_pag) as totalS, s.p_tabulador_l_su from pagos_ov p left join orden_venta ov on ov.referencia_ov = p.referencia_pag left join sucursales s on s.id_su = ov.sucursal_ov";

$order  = " GROUP BY s.nombre_su";

$query1 = $consultaP . $swhere .$order;
// echo $query1;
$query = mysql_query($query1) or die (mysql_error());

mysql_select_db($database_horizonte, $horizonte);
$consultaU = "SELECT usuario_u from usuarios WHERE id_u = $id_u";
$query1U = mysql_query($consultaU) or die (mysql_error());
$rowtU = mysql_fetch_row($query1U);


require('../../../fpdf/fpdf.php');
class PDF extends FPDF
{
  // Cabecera de página
  function Header(){
     
      // Arial bold 15
      $this->SetFont('Arial','B',12);
      // Movernos a la derecha
      $this->Cell(45);
      // Título
      $this->Cell(100,10,'PAGOS POR SUCURSALES',1,1,'C');
      // Salto de línea
      $this->Ln(20);

      $this->SetX(15);
      $this->Cell(60,10,'SUCURSAL',1,0,'C');
      $this->Cell(30,10,'# PAGOS',1,0,'C');
      $this->Cell(30,10,'TOTAL',1,0,'C');
      $this->Cell(30,10,'COMISION',1,0,'C');
      $this->Cell(30,10,'TOTAL CADIT',1,1,'C');
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
  $comision = intval(($fila['totalS']*(1-($fila['p_tabulador_l_su']*0.01)))*100)/100;
  $totalActual = $fila['totalS'];

  $NVentasT = $NVentasT + $fila['Nventas'];
  $totalGeneral = $totalGeneral + $fila['totalS'];
  $totalComision = $totalComision + $comision;
  $totalCadit = $totalCadit + ($totalActual - $comision);
  $pdf->SetX(15);
  $pdf->Cell(60,10,$fila['nombre_su'],1,0,'C');
  $pdf->Cell(30,10,$fila['Nventas'],1,0,'C');
  $pdf->Cell(30,10,$fila['totalS'],1,0,'C');
  $pdf->Cell(30,10,$comision,1,0,'C');
  $pdf->Cell(30,10,$totalActual - $comision,1,1,'C');
}


$pdf->SetX(15);
$pdf->Cell(60,10,"TOTALES",1,0,'C');
$pdf->Cell(30,10,$NVentasT,1,0,'C');
$pdf->Cell(30,10,$totalGeneral,1,0,'C');
$pdf->Cell(30,10,$totalComision,1,0,'C');
$pdf->Cell(30,10,$totalCadit,1,1,'C');

$pdf->Cell(70,10,$id_h,0,1,'C');
$pdf->SetX(15);
$pdf->Cell(20,10,"FECHAS: ",1,0,'C');
$pdf->Cell(95,10,"DE ".$min." A ".$max,1,1,'C');
// $pdf->Cell(15,10,"EDAD:",1,0,'C');
// $pdf->Cell(15,10,utf8_decode($edad),1,0,'C');
// $pdf->Cell(30,10,utf8_decode($sexo),1,1,'C');

$pdf->SetX(15);
$pdf->Cell(20,10,"IMPRIMIO: ",1,0,'C');
$pdf->Cell(95,10,$rowtU[0],1,0,'C');
$pdf->Cell(30,10,utf8_decode('FECHA IMPRESIÓN'),1,0,'C');
$pdf->Cell(30,10,$now,1,1,'C');


$pdf->Output();
?>