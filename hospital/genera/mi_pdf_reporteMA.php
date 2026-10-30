<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

/* if(strlen($_GET['id_h']) && strlen($_GET['nombre']) ){
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

$pdf->Output(); */

//Variables
$id_h = $_GET['id_h'];
$id_p = $_GET['id_p'];
$id_u = $_GET['id_u'];

//Datos del paciente
mysql_select_db($database_horizonte, $horizonte);
$data_query = 'SELECT CONCAT_WS(" ", p.nombre_p, p.apaterno_p, p.amaterno_p), YEAR(NOW()) - YEAR(p.fNac_p), DATE_FORMAT(p.fNac_p,"%d/%m/%Y"), c.cat_sexo FROM pacientes p LEFT JOIN catalogo_sexos c on c.id_sexo = p.sexo_p WHERE id_p = ' . $id_p;
$runData_paciente = mysql_query($data_query) or die (mysql_error());
$getData = mysql_fetch_row($runData_paciente);
//Datos del USUARIO
mysql_select_db($database_horizonte, $horizonte);
$data_query1 = 'SELECT usuario_u FROM usuarios WHERE id_u = ' . $id_u;
$runData_user = mysql_query($data_query1) or die (mysql_error());
$getData1 = mysql_fetch_row($runData_user);
//Datos hospitalizacion
mysql_select_db($database_horizonte, $horizonte);
$data_query2 = 'SELECT c.no_ca, CONCAT_WS(" ", t.abreviacion_ti, u.nombre_u, u.apaterno_u, u.amaterno_u), h.motivo_h, DATE_FORMAT(h.fecha_inicio_h,"%d/%m/%Y") FROM hospitalizacion h LEFT JOIN camas c ON c.id_ca = h.id_cama_h LEFT JOIN usuarios u ON u.id_u = h.id_medicoh_h LEFT JOIN titulos t ON t.id_ti = u.id_titulo_u WHERE h.id_h = ' . $id_h;
$runData_hosp = mysql_query($data_query2) or die (mysql_error());
$getData2 = mysql_fetch_row($runData_hosp);
//variables paciente.
$nombre_paciente = substr($getData[0],0,40);
$diagnostico = substr($getData2[2],0,31);
$medico_tratante = substr($getData2[1],0,25);
//Mayusculas
$nombre_paciente = strtoupper($nombre_paciente);
$diagnostico = strtoupper($diagnostico);
$medico_tratante = strtoupper($medico_tratante);
//Alergias
$alergias = "";
$aler = "";
mysql_select_db($database_horizonte, $horizonte);
$resultAl = mysql_query("SELECT alergia1_hc, alergia2_hc, alergia3_hc, alergia4_hc, alergia5_hc, alergia6_hc from historia_clinica where id_paciente_hc = $id_p order by id_hc DESC LIMIT 1", $horizonte) or die (mysql_error());
$rowAl = mysql_fetch_row($resultAl);

if($rowAl[0]=='' and $rowAl[1]=='' and $rowAl[2]=='' and $rowAl[3]=='' and $rowAl[4]=='' and $rowAl[5]==''){$alergias='NINGUNA';}
else{
    if($rowAl[0]!=''){$aler = $rowAl[0];}
    if($rowAl[1]!=''){$aler = $aler.', '.$rowAl[1];}
    if($rowAl[2]!=''){$aler = $aler.', '.$rowAl[2];}
    if($rowAl[3]!=''){$aler = $aler.', '.$rowAl[3];}
    if($rowAl[4]!=''){$aler = $aler.', '.$rowAl[4];}
    if($rowAl[5]!=''){$aler = $aler.', '.$rowAl[5];}
    if($aler[0]==', '){$alergias = substr($aler, 1);}else{$alergias = $aler;}
}
$alergias = substr($alergias, 0, 60);

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
$pdf->SetFont('Arial','BU',12);
// Movernos a la IZQUIERDA
$pdf->Cell(1);
// Título
$pdf->Cell(190,10,'MEDICAMENTOS APLICADOS',0,1,'C');
// Salto de línea
$pdf->Ln(5);
//letra
$pdf->SetFont('Arial','',10);
// Movernos a la IZQUIERDA
$pdf->Cell(1);
//fila 1
$pdf->Cell(45,5,'NOMBRE DEL PACIENTE:',0,0,'L');
$pdf->Cell(95,5,utf8_decode($nombre_paciente),0,0,'L');
$pdf->Cell(10,5,'NAC.',0,0,'L');
$pdf->Cell(40,5,$getData[2],0,1,'L');
//fila 2
$pdf->cell(1);
$pdf->cell(12,5,'EDAD:',0,0,'L');
$pdf->cell(35,5,$getData[1] . utf8_decode(" AÑOS"),0,0,'L');
$pdf->cell(12,5,'SEXO:',0,0,'L');
$pdf->cell(35,5,$getData[3],0,0,'L');
/* $pdf->cell(14,5,'FECHA:',0,0,'L');
$pdf->cell(34,5,$getData2[3],0,0,'L'); */
$pdf->cell(15,5,'CAMA:',0,0,'L');
$pdf->cell(36,5,$getData2[0],0,1,'L');
//fila 3
/* $pdf->cell(1);
$pdf->cell(27,5,'DIAGNOSTICO:',0,0,'L');
$pdf->cell(68,5,utf8_decode($diagnostico),0,0,'L');
$pdf->cell(36,5,'MEDICO TRATANTE:',0,0,'L');
$pdf->cell(59,5,utf8_decode($medico_tratante),0,1,'L'); */
//fila 4
$pdf->cell(1);
//$pdf->SetFont('Arial','U',10);
$pdf->cell(28,5,'DIAGNOSTICO: ',0,0,'L');
$pdf->cell(115,5,utf8_decode($diagnostico),0,1,'L');
//fila 5
$pdf->cell(1);
$pdf->cell(37,5,'MEDICO TRATANTE: ',0,0,'L');
$pdf->cell(120,5,utf8_decode($medico_tratante),0,1,'L');
//fila 6
/* $pdf->cell(1);
$pdf->cell(50,5,'NOMBRE DEL VERIFICADOR:',0,0,'L');
$pdf->cell(140,5,'_______________________________________________________________________',0,1,'L'); */
//fila 7
/* $pdf->cell(1);
$pdf->cell(53,5,'NOMBRE DE QUIEN SOLICITA:',0,0,'L');
$pdf->cell(137,5,'_____________________________________________________________________',0,1,'L'); */
//fila 8
$pdf->cell(1);
$pdf->cell(74,5,'USUARIO, FECHA Y HORA DE IMPRESION:',0,0,'L');
$pdf->cell(116,5,utf8_decode($getData1[0]) . " " .date('d-m-Y H:i:s'),0,1,'L');
//fila 9
$pdf->SetFont('Arial','B',12);
$pdf->setTextColor(255, 0, 0);
$pdf->cell(1);
$pdf->cell(24,5,'ALERGIAS:',0,0,'L');

$pdf->cell(167,5,$alergias,0,1,'L');
$pdf->setTextColor(0, 0, 0);
$pdf->SetFont('Arial','',10);
//fila 10

$pdf->Ln(7);

//lINEA INICIAL
$pdf->cell(1);
$pdf->cell(189.5,0.1,'',1,1,'C');

$pdf->cell(1);
$pdf->cell(0.1,10,'',1,0,'C');
$pdf->cell(5,10,'#',0,0,'C');
$pdf->cell(0.1,10,'',1,0,'C');
$pdf->cell(25,10,'FECHA/HORA',0,0,'C');
$pdf->cell(0.1,10,'',1,0,'C');
$pdf->cell(100,10,utf8_decode('DESCRIPCIÓN DEL MEDICAMENTO'),0,0,'C');
$pdf->cell(0.1,10,'',1,0,'C');
$pdf->cell(59,10,utf8_decode('REACCIONES'),0,0,'C');
$pdf->cell(0.1,10,'',1,1,'C');

//LINEA
$pdf->cell(1);
$pdf->cell(189.5,0.1,'',1,1,'C');

//consulta
mysql_select_db($database_horizonte, $horizonte); 
$datos = mysql_query("SELECT m.id_mah, mc.concepto_to, m.id_mah, m.id_mah, CONCAT_WS(' ', u.usuario_u, u.apaterno_u, u.amaterno_u) as aplico, DATE_FORMAT(m.fecha_mah,'%d/%m/%Y') as Fecha, m.id_mah, DATE_FORMAT(m.fecha_mah,'%H:%i:%s') as minutos ,mc.precio_to, m1.indicacion_mh, DATE_FORMAT(m.fecha_mah,'%d/%m/%Y') as fecha, DATE_FORMAT(m.fecha_mah,'%H:%i:%s') as hora  from medicamentos_aplicados_hospi m left join medicamentos_hospital m1 on m1.id_mh = m.id_medicamento_hospital_mah left join conceptos mc on mc.id_to = m1.id_medicamento_mh left join usuarios u on u.id_u = m.id_usuario_mah left join titulos t on t.id_ti = u.id_titulo_u WHERE  m1.id_hospitalizacion_mh = " . $id_h ,$horizonte) or die (mysql_error());

//contador
$contador = 1;
while ($fila = mysql_fetch_assoc($datos)) {
    //VARIABLES
    $medicamento = $fila['concepto_to'];
    $nombre_doctor = $fila['aplico'];
    $indicacion = $fila['indicacion_mh'];
    //$cantidad = $fila['cantidad'];
    $fecha = $fila['fecha'];
    $hora = $fila['hora'];
    $indicacion1 = "";
    $indicacion2 = "";
    //condiciones
    if(strlen($indicacion) >= 35){
        $indicacion1 = substr($indicacion, 0, 35);
        $indicacion2 = substr($indicacion, 35, 70);
    }else{
        $indicacion1 = $indicacion;
    }
    $nombre_doctor = substr($nombre_doctor, 0, 40);
    $medicamento = substr($medicamento, 0, 40);
    $cantidad = substr($cantidad, 0, 7);

    // Texto mayusculas
    $nombre_doctor = strtoupper($nombre_doctor);
    $indicacion1 = strtoupper($indicacion1);
    $indicacion2 = strtoupper($indicacion2);
    $medicamento = strtoupper($medicamento);

    //salta condicional
    if($contador == 10 || $contador > 11 && $contador % 11 == 0){
        $pdf->Ln(30);

        $pdf->cell(1);
        $pdf->cell(189.5,0.1,'',1,1,'C');

        $pdf->cell(1);
        $pdf->cell(0.1,10,'',1,0,'C');
        $pdf->cell(5,10,'#',0,0,'C');
        $pdf->cell(0.1,10,'',1,0,'C');
        $pdf->cell(25,10,'FECHA/HORA',0,0,'C');
        $pdf->cell(0.1,10,'',1,0,'C');
        $pdf->cell(100,10,utf8_decode('DESCRIPCIÓN DEL MEDICAMENTO'),0,0,'C');
        $pdf->cell(0.1,10,'',1,0,'C');
        $pdf->cell(59,10,utf8_decode('REACCIONES'),0,0,'C');
        $pdf->cell(0.1,10,'',1,1,'C');

        $pdf->cell(1);
        $pdf->cell(189.5,0.1,'',1,1,'C');
    }

    //DATOS
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(100,5,utf8_decode($medicamento),1,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(59,5,'_________________________',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,$contador,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,$fecha,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(100,5,utf8_decode('APLICÓ: ') . utf8_decode($nombre_doctor),1,0,'L');
    /* $pdf->cell(20,5,'CANTIDAD:',0,0,'L');
    $pdf->cell(15,5,$cantidad,0,0,'L');
    $pdf->cell(65,5,utf8_decode('PERSONAL MÉDICO/CEDULA:'),0,0,'L'); */
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(59,5,'_________________________',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //
/*     $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,$contador,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,$fecha,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(100,5,utf8_decode($nombre_doctor),1,0,'L');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(59,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C'); */
    //
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,$hora,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(22,5,utf8_decode('INDICACIÓN:'),0,0,'L');
    $pdf->cell(78,5,utf8_decode($indicacion1),0,0,'L');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(59,5,'_________________________',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(100,5,utf8_decode($indicacion2),0,0,'L');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(59,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //LINEA
    $pdf->cell(1);
    $pdf->cell(189.5,0.1,'',1,1,'C');

    $contador++;
}
//restamos 1 al contador debido a la ultima iteracion
$contador--;
//SALTO condicional
/* if($contador >= 16 && $contador % 16 == 0){
    $pdf->Ln(14);
}else{
    $pdf->Ln(20);
} */
//FIRMAS
/* $pdf->cell(1);
$pdf->cell(95,5,'________________________________________',0,0,'C');
$pdf->cell(95,5,'________________________________________',0,1,'C');

$pdf->cell(1);
$pdf->cell(95,5,'NOMBRE DE QUIEN ENTREGA MAT Y MED',0,0,'C');
$pdf->cell(95,5,'NOMBRE DE QUIEN RECIBE MAT Y MED',0,1,'C');

$pdf->cell(1);
$pdf->cell(95,5,'(NOMBRE COMPLETO Y FIRMA)',0,0,'C');
$pdf->cell(95,5,'(NOMBRE COMPLETO Y FIRMA)',0,1,'C');

//SALTO CONDICIONAL
if($contador <= 5 || $contador >= 16 && $contador % 16 == 0){
    $pdf->Ln(14);
}elseif($contador <= 5 || $contador >= 15 && $contador % 15 == 0){
    $pdf->Ln(20);
}else{
    $pdf->Ln(15);
}


$pdf->cell(1);
$pdf->cell(95,5,'________________________________________',0,0,'C');
$pdf->cell(95,5,'________________________________________',0,1,'C');

$pdf->cell(1);
$pdf->cell(95,5,'NOMBRE DEL VERIFICADOR',0,0,'C');
$pdf->cell(95,5,'NOMBRE DE QUIEN SOLICITA',0,1,'C');

$pdf->cell(1);
$pdf->cell(95,5,'(NOMBRE COMPLETO Y FIRMA)',0,0,'C');
$pdf->cell(95,5,'(NOMBRE COMPLETO Y FIRMA)',0,1,'C'); */

$pdf->Output();
?>
