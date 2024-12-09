<?php
require_once('../../Connections/horizonte.php');
require("../../funciones/php/values.php");

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
//fila 7
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
$pdf->cell(159,10,utf8_decode('DESCRIPCIÓN DEL MEDICAMENTO'),1,1,'C');

//LINEA
$pdf->cell(1);
$pdf->cell(189.5,0.1,'',1,1,'C');

//consulta
mysql_select_db($database_horizonte, $horizonte); 
$datos = mysql_query("SELECT m.id_mah, mc.concepto_to, m.id_mah, m.id_mah, CONCAT_WS(' ', u.usuario_u, u.apaterno_u, u.amaterno_u, u.cedulaProfesional_u) as aplico, DATE_FORMAT(m.fecha_mah,'%d/%m/%Y') as Fecha, m.id_mah, DATE_FORMAT(m.fecha_mah,'%H:%i:%s') as minutos ,mc.precio_to, m1.indicacion_mh, DATE_FORMAT(m.fecha_mah,'%d/%m/%Y') as fecha, DATE_FORMAT(m.fecha_mah,'%H:%i:%s') as hora  from medicamentos_aplicados_hospi m left join medicamentos_hospital m1 on m1.id_mh = m.id_medicamento_hospital_mah left join conceptos mc on mc.id_to = m1.id_medicamento_mh left join usuarios u on u.id_u = m.id_usuario_mah left join titulos t on t.id_ti = u.id_titulo_u WHERE  m1.id_hospitalizacion_mh = " . $id_h . " ORDER BY m.fecha_mah ASC ",$horizonte) or die (mysql_error());

//contador
$contador = 1;
while ($fila = mysql_fetch_assoc($datos)) {
    //VARIABLES
    $medicamento = $fila['concepto_to'];
    $nombre_doctor = $fila['aplico'];
    $indicacion1 = $fila['indicacion_mh'];
    //$cantidad = $fila['cantidad'];
    $fecha = $fila['fecha'];
    $hora = $fila['hora'];
    //condiciones
    
    $nombre_doctor = substr($nombre_doctor, 0, 40);
    $medicamento = substr($medicamento, 0, 40);
    $cantidad = substr($cantidad, 0, 7);
    $indicacion1 = substr($indicacion1, 0, 67);

    // Texto mayusculas
    $nombre_doctor = strtoupper($nombre_doctor);
    $indicacion1 = strtoupper($indicacion1);
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
        $pdf->cell(159,10,utf8_decode('DESCRIPCIÓN DEL MEDICAMENTO'),0,0,'C');
        $pdf->cell(0.1,10,'',1,0,'C');
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
    $pdf->cell(159,5,utf8_decode($medicamento),1,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //
    $datosCantDoctor = 'CANTIDAD: ' . "1" . '  PERSONAL MÉDICO/CEDULA: ' . $nombre_doctor;
    $datosCantDoctor = substr($datosCantDoctor, 0, 67);
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,$contador,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,$fecha,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(159,5,utf8_decode($datosCantDoctor),1,1,'L');

    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,$hora,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(159,5,utf8_decode('LOTE: ') . '12345' . utf8_decode(' CADUCIDAD: ') . '22/DIC/24',0,0,'L');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(159,5,utf8_decode('INDICACIÓN: ') . utf8_decode($indicacion1),1,0,'L');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //LINEA
    $pdf->cell(1);
    $pdf->cell(189.5,0.1,'',1,1,'C');

    $contador++;
}
//restamos 1 al contador debido a la ultima iteracion
$contador--;

$pdf->Output();
?>
