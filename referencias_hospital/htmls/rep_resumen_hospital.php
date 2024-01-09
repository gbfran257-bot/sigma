<?php

require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
require("../../fpdf/fpdf.php");

$now = date('Y-m-d H:i:s');
$min = $_GET['min'] . ' 00:00:00';
$max = $_GET['max'] . ' 23:59:59';
$id_rh = $_GET['id_rh'];

class PDF extends FPDF
{
  // Cabecera de página
  function Header(){
     
      $this->SetFont('Arial','B',18);
      $this->Cell(190,8,'RESUMEN HOSPITAL',0,1,'C');

  }
    // Pie de página
    function Footer(){
        // Posición: a 2,5 cm del final
        $this->SetY(-25);
        $this->SetFont('Arial','',12);
        // Número de página
        // $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');

        $this->Cell(190,5,'HENRI DUNANT',0,1,'C');
        $this->Cell(190,5,'Río Pánuco No. 100, Colonia Los Volcanes',0,1,'C');
        $this->Cell(190,5,'CUERNAVACA, MOR.',0,1,'C');
    }

}

    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFont('Arial','',11);

    $pdf->Ln(5);
    $pdf->SetX(5);
    $pdf->Cell(66,5,utf8_decode('#'),0,0,'L');
    $pdf->Cell(66,5,utf8_decode('CONCEPTO'),0,0,'C');
    $pdf->Cell(66,5,utf8_decode('PRECIO'),0,1,'R');



    
// 
/* $pdf->Ln(2);
mysql_select_db($database_horizonte, $horizonte); 
$resultado = mysql_query("SELECT COUNT(c.id_tipo_concepto_to) FROM venta_conceptos vc left join orden_venta ov on ov.referencia_ov = vc.referencia_vc left join estatus e on e.id_est = vc.estatus_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to LEFT JOIN rel_referencias_hospital rel ON rel.referencia_rrh = ov.referencia_ov where rel.id_rh_rrh = 21 AND c.id_tipo_concepto_to = 1 AND (ov.fecha_venta_ov BETWEEN '2023-01-01 00:00:00' AND '2023-12-05 23:59:59')",$horizonte) or die (mysql_error());

while ($fila = mysql_fetch_assoc($resultado)) {
  $pdf->SetX(5);
  $pdf->Cell(15,5,utf8_decode($fila['COUNT(c.id_tipo_concepto_to)']),0,0,'L');
  $pdf->Cell(150,5,utf8_decode($fila['COUNT(c.id_tipo_concepto_to)']),0,0,'L');
  $pdf->Cell(33,5,utf8_decode($fila['COUNT(c.id_tipo_concepto_to)']),0,1,'R');
  
} */
// 

// CONSULTAS

$pdf->Ln(10);

/* $pdf->SetFont('Arial','B',14);
$pdf->Cell(55,5,utf8_decode("CONSULTAS"),0,1,'C');
$pdf->SetFont('Arial','',11); */

//$pdf->Ln(2);

//CONSULTAS
mysql_select_db($database_horizonte, $horizonte); 
$consultas = mysql_query("SELECT count(c.id_to), tc.tipo_concepto_tc, c.concepto_to, tc.tipo_concepto_tc, concat(vc.referencia_vc,'/',contador_vc), vc.estatus_vc, vc.precio_vc, id_personal_medico_vc, e.estatus_est, vc.id_vc, c.id_departamento_to, vc.id_vc, vc.referencia_vc, motivo_c_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov FROM venta_conceptos vc left join orden_venta ov on ov.referencia_ov = vc.referencia_vc left join estatus e on e.id_est = vc.estatus_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to LEFT JOIN rel_referencias_hospital rel ON rel.referencia_rrh = ov.referencia_ov where rel.id_rh_rrh = $id_rh AND c.id_tipo_concepto_to = 1 AND (ov.fecha_venta_ov BETWEEN '$min' AND '$max') GROUP BY vc.id_vc",$horizonte) or die (mysql_error());

$titulo = 0;
while ($fila = mysql_fetch_assoc($consultas)) {
    

    
    if($fila['count(c.id_to)']>0 && $titulo<=0){
        $pdf->SetX(5);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(55,5,utf8_decode("CONSULTAS"),0,1,'C');
        $pdf->SetFont('Arial','',11);
        $pdf->Ln(3);
        $titulo = 1;
    }
    $pdf->SetX(5);  
    $pdf->Cell(15,5,utf8_decode($fila['count(c.id_to)']),0,0,'L');
    $pdf->Cell(150,5,utf8_decode($fila['concepto_to']),0,0,'L');
    $pdf->Cell(33,5,utf8_decode($fila['precio_vc']),0,1,'R');
    $pdf->Ln(4);
  
}
// 

//SERVICIOS
mysql_select_db($database_horizonte, $horizonte); 
$servicios = mysql_query("SELECT count(c.id_to), tc.tipo_concepto_tc, c.concepto_to, tc.tipo_concepto_tc, concat(vc.referencia_vc,'/',contador_vc), vc.estatus_vc, vc.precio_vc, id_personal_medico_vc, e.estatus_est, vc.id_vc, c.id_departamento_to, vc.id_vc, vc.referencia_vc, motivo_c_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov FROM venta_conceptos vc left join orden_venta ov on ov.referencia_ov = vc.referencia_vc left join estatus e on e.id_est = vc.estatus_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to LEFT JOIN rel_referencias_hospital rel ON rel.referencia_rrh = ov.referencia_ov where rel.id_rh_rrh = $id_rh AND c.id_tipo_concepto_to = 2 AND (ov.fecha_venta_ov BETWEEN '$min' AND '$max') GROUP BY vc.id_vc",$horizonte) or die (mysql_error());

$titulo = 0;
while ($fila = mysql_fetch_assoc($servicios)) {
    

    
    if($fila['count(c.id_to)']>0 && $titulo<=0){
        $pdf->SetX(5);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(50,5,utf8_decode("SERVICIOS"),0,1,'C');
        $pdf->SetFont('Arial','',11);
        $pdf->Ln(3);
        $titulo = 1;
    }
    $pdf->SetX(5);  
    $pdf->Cell(15,5,utf8_decode($fila['count(c.id_to)']),0,0,'L');
    $pdf->Cell(150,5,utf8_decode($fila['concepto_to']),0,0,'L');
    $pdf->Cell(33,5,utf8_decode($fila['precio_vc']),0,1,'R');
    $pdf->Ln(4);
  
}
// 

//LABORATORIO
mysql_select_db($database_horizonte, $horizonte); 
$laboratorio = mysql_query("SELECT count(c.id_to), tc.tipo_concepto_tc, c.concepto_to, tc.tipo_concepto_tc, concat(vc.referencia_vc,'/',contador_vc), vc.estatus_vc, vc.precio_vc, id_personal_medico_vc, e.estatus_est, vc.id_vc, c.id_departamento_to, vc.id_vc, vc.referencia_vc, motivo_c_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov FROM venta_conceptos vc left join orden_venta ov on ov.referencia_ov = vc.referencia_vc left join estatus e on e.id_est = vc.estatus_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to LEFT JOIN rel_referencias_hospital rel ON rel.referencia_rrh = ov.referencia_ov where rel.id_rh_rrh = $id_rh AND c.id_tipo_concepto_to = 3 AND (ov.fecha_venta_ov BETWEEN '$min' AND '$max') GROUP BY vc.id_vc",$horizonte) or die (mysql_error());

$titulo = 0;
while ($fila = mysql_fetch_assoc($laboratorio)) {
    

    
    if($fila['count(c.id_to)']>0 && $titulo<=0){
        $pdf->SetX(5);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(95,5,utf8_decode("ESTUDIOS DE LABORATORIO"),0,1,'C');
        $pdf->SetFont('Arial','',11);
        $pdf->Ln(3);
        $titulo = 1;
    }
    $pdf->SetX(5);  
    $pdf->Cell(15,5,utf8_decode($fila['count(c.id_to)']),0,0,'L');
    $pdf->Cell(150,5,utf8_decode($fila['concepto_to']),0,0,'L');
    $pdf->Cell(33,5,utf8_decode($fila['precio_vc']),0,1,'R');
    $pdf->Ln(4);
  
}
// 

//IMAGEN
mysql_select_db($database_horizonte, $horizonte); 
$imagen = mysql_query("SELECT count(c.id_to), tc.tipo_concepto_tc, c.concepto_to, tc.tipo_concepto_tc, concat(vc.referencia_vc,'/',contador_vc), vc.estatus_vc, vc.precio_vc, id_personal_medico_vc, e.estatus_est, vc.id_vc, c.id_departamento_to, vc.id_vc, vc.referencia_vc, motivo_c_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov FROM venta_conceptos vc left join orden_venta ov on ov.referencia_ov = vc.referencia_vc left join estatus e on e.id_est = vc.estatus_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to LEFT JOIN rel_referencias_hospital rel ON rel.referencia_rrh = ov.referencia_ov where rel.id_rh_rrh = $id_rh AND c.id_tipo_concepto_to = 4 AND (ov.fecha_venta_ov BETWEEN '$min' AND '$max') GROUP BY vc.id_vc",$horizonte) or die (mysql_error());

$titulo = 0;
while ($fila = mysql_fetch_assoc($imagen)) {
    

    
    if($fila['count(c.id_to)']>0 && $titulo<=0){
        $pdf->SetX(5);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(80,5,utf8_decode("ESTUDIOS DE IMAGEN"),0,1,'C');
        $pdf->SetFont('Arial','',11);
        $pdf->Ln(3);
        $titulo = 1;
    }
    $pdf->SetX(5);  
    $pdf->Cell(15,5,utf8_decode($fila['count(c.id_to)']),0,0,'L');
    $pdf->Cell(150,5,utf8_decode($fila['concepto_to']),0,0,'L');
    $pdf->Cell(33,5,utf8_decode($fila['precio_vc']),0,1,'R');
    $pdf->Ln(4);
  
}
// 

//FARMACIA
mysql_select_db($database_horizonte, $horizonte); 
$farmacia = mysql_query("SELECT count(c.id_to), tc.tipo_concepto_tc, c.concepto_to, tc.tipo_concepto_tc, concat(vc.referencia_vc,'/',contador_vc), vc.estatus_vc, vc.precio_vc, id_personal_medico_vc, e.estatus_est, vc.id_vc, c.id_departamento_to, vc.id_vc, vc.referencia_vc, motivo_c_ov, observaciones_i_ov, observaciones_l_ov, observaciones_s_ov, motivo_desc_c_ov, motivo_desc_i_ov, motivo_desc_l_ov, motivo_desc_s_ov, motivo_desc_f_ov FROM venta_conceptos vc left join orden_venta ov on ov.referencia_ov = vc.referencia_vc left join estatus e on e.id_est = vc.estatus_vc left join conceptos c on c.id_to = vc.id_concepto_es left join catalogo_tipo_conceptos tc on tc.id_tc = c.id_tipo_concepto_to LEFT JOIN rel_referencias_hospital rel ON rel.referencia_rrh = ov.referencia_ov where rel.id_rh_rrh = $id_rh AND c.id_tipo_concepto_to = 5 AND (ov.fecha_venta_ov BETWEEN '$min' AND '$max') GROUP BY vc.id_vc",$horizonte) or die (mysql_error());

$titulo = 0;
while ($fila = mysql_fetch_assoc($farmacia)) {
    

    
    if($fila['count(c.id_to)']>0 && $titulo<=0){
        $pdf->SetX(5);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(52,5,utf8_decode("FARMACIA"),0,1,'C');
        $pdf->SetFont('Arial','',11);
        $pdf->Ln(3);
        $titulo = 1;
    }
    $pdf->SetX(5);  
    $pdf->Cell(15,5,utf8_decode($fila['count(c.id_to)']),0,0,'L');
    $pdf->Cell(150,5,utf8_decode($fila['concepto_to']),0,0,'L');
    $pdf->Cell(33,5,utf8_decode($fila['precio_vc']),0,1,'R');
    $pdf->Ln(4);
  
}
// 





    $pdf->Output();

?>