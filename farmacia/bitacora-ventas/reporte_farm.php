<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
require("../../fpdf/fpdf.php");

$now = date('Y-m-d H:i:s');

class PDF extends FPDF
{
  // Cabecera de página
  function Header(){
     
      $this->SetFont('Arial','B',20);
      $this->Cell(190,8,'TICKET DE VENTA',0,1,'C');

  }
// Pie de página
function Footer(){
    // Posición: a 2,5 cm del final
    $this->SetY(-25);
    $this->SetFont('Arial','',12);
    // Número de página
    // $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');

    $this->Cell(190,5,'FARMACIA CRUZ ROJA',0,1,'C');
    $this->Cell(190,5,'LIBRAMIENTO TEQUESQUITENGO - TLATENCHI, CP 62907',0,1,'C');
    $this->Cell(190,5,'JOJUTLA DE JUAREZ, MOR.',0,1,'C');
}
  
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,8,utf8_decode('DATOS DEL PACIENTE'),0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Ln(1);
// 
$pdf->SetX(5);
$pdf->Cell(23,6,utf8_decode("PACIENTE:"),0,0,'L');
$pdf->Cell(114,6,utf8_decode($_GET['paciente']),0,0,'L');
$pdf->Cell(17,6,utf8_decode('FECHA:'),0,0,'L');
$pdf->Cell(45,6,$now,0,1,'L');
// 
$pdf->SetX(5);
$pdf->Cell(37,6,utf8_decode("NOMBRE TITULAR:"),0,0,'L');
$pdf->Cell(100,6,utf8_decode($_GET['titular']),0,0,'L');
$pdf->Cell(17,6,utf8_decode('TIPO:'),0,0,'L');
$pdf->Cell(45,6,utf8_decode($_GET['tipo']),0,1,'L');
// 
$pdf->SetX(5);
$pdf->Cell(34,6,utf8_decode("ATENDIÒ:"),0,0,'L');
$pdf->Cell(34,6,utf8_decode($_GET['atendio']),0,0,'L');

$pdf->Cell(34,6,utf8_decode("# TRABAJADOR:"),0,0,'L');
$pdf->Cell(35,6,utf8_decode($_GET['clave']),0,0,'L');

$pdf->Cell(17,6,utf8_decode("SEXO:"),0,0,'L');
$pdf->Cell(45,6,utf8_decode($_GET['sexo']),0,1,'L');
// 
$pdf->SetX(5);
$pdf->Cell(34,6,utf8_decode("PARENTESCO:"),0,0,'L');
$pdf->Cell(34,6,utf8_decode($_GET['parentesco']),0,0,'L');

$pdf->Cell(34,6,utf8_decode("EDAD:"),0,0,'L');
$pdf->Cell(35,6,utf8_decode($_GET['edad']),0,0,'L');

$pdf->Cell(17,6,utf8_decode("TEL:"),0,0,'L');
$pdf->Cell(45,6,utf8_decode($_GET['telefono']),0,1,'L');
// 
$pdf->SetX(5);
$pdf->Cell(34,6,utf8_decode("REF:"),0,0,'L');
$pdf->Cell(34,6,utf8_decode($_GET['referencia']),0,0,'L');

$pdf->Cell(34,6,utf8_decode("AREÀ:"),0,0,'L');
$pdf->Cell(55,6,utf8_decode($_GET['area']),0,1,'L');
// 
$pdf->SetLineWidth(0.8);
$pdf->Line(5, 60, 204, 60);
$pdf->SetLineWidth(0.2);
// 
$pdf->Ln(5);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,8,utf8_decode('DESCRIPCIÒN DE LOS PRODUCTOS O SERVICIOS'),0,1,'C');
$pdf->SetFont('Arial','',11);

$pdf->Ln(5);
$pdf->SetX(5);
$pdf->Cell(66,5,utf8_decode('#'),0,0,'L');
$pdf->Cell(66,5,utf8_decode('CONCEPTO'),0,0,'C');
$pdf->Cell(66,5,utf8_decode('PRECIO'),0,1,'R');
// 
$pdf->Ln(2);
mysql_select_db($database_horizonte, $horizonte); 
$resultado = mysql_query("SELECT vc.id_vc , a.nombre_a, t.tipo_concepto_tc,c.concepto_to, vc.precio_vc, vc.precio_vc, vc.id_vc, c.id_tipo_concepto_to, d.nombre_d, COUNT(c.id_to)
                          FROM venta_conceptos vc
                          left join conceptos c on c.id_to = vc.id_concepto_es 
                          left join departamentos d on d.id_d = c.id_departamento_to 
                          left join areas a on id_a = c.id_area_to  
                          left join convenios cv on cv.id_cv = vc.id_convenio_vc 
                          left join catalogo_tipo_conceptos t on t.id_tc = c.id_tipo_concepto_to
                          WHERE vc.no_temp_vc = '".$_GET['aleatorio']."' and vc.precio_vc IS NOT NULL and vc.id_concepto_es not in(19,20,21,22,23)
                          GROUP BY c.id_to;",$horizonte) or die (mysql_error());

while ($fila = mysql_fetch_assoc($resultado)) {
  $pdf->SetX(5);
  $pdf->Cell(15,5,utf8_decode($fila['COUNT(c.id_to)']),0,0,'L');
  $pdf->Cell(150,5,utf8_decode($fila['concepto_to']),0,0,'L');
  $pdf->Cell(33,5,utf8_decode($fila['precio_vc']),0,1,'R');
  
}
// 
$pdf->SetY(-110);

$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('SUBTOTAL'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['subtotal']),0,1,'L');

$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('CARGOS ADICIONALES'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['cargos']),0,1,'L');

$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('DESCUENTO'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['descuento']),0,1,'L');

$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('IVA'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['iva']),0,1,'L');

$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('TOTAL'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['total']),0,1,'L');
// 
$pdf->Ln(5);
$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('FORMA DE PAGO'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['forma']),0,1,'L');

$pdf->SetX(40);
$pdf->Cell(45,8,utf8_decode('FIRMA DEL PACIENTE'),0,0,'C');
$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('SU PAGO'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['su_pago']),0,1,'L');

$pdf->SetLineWidth(0.8);
$pdf->Line(20, 241, 105, 241);
$pdf->SetLineWidth(0.2);

$pdf->SetX(140);
$pdf->Cell(45,8,utf8_decode('SALDO ACTUAL'),0,0,'R');
$pdf->Cell(17,8,utf8_decode($_GET['saldo']),0,1,'L');




$pdf->Output();




?>