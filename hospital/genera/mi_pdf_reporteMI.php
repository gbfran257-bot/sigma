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
$pdf->Cell(190,10,'VALE DE MATERIAL Y MEDICAMENTOS INDICADOS',0,1,'C');
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
$pdf->cell(1);
$pdf->cell(27,5,'DIAGNOSTICO:',0,0,'L');
$pdf->cell(68,5,utf8_decode($diagnostico),0,0,'L');
$pdf->cell(36,5,'MEDICO TRATANTE:',0,0,'L');
$pdf->cell(59,5,utf8_decode($medico_tratante),0,1,'L');
//fila 4
$pdf->cell(1);
//$pdf->SetFont('Arial','U',10);
$pdf->cell(75,5,'NOMBRE DE QUIEN ENTREGA MAT Y MED:',0,0,'L');
$pdf->cell(115,5,'__________________________________________________________',0,1,'L');
//fila 5
$pdf->cell(1);
$pdf->cell(70,5,'NOMBRE DE QUIEN RECIBE MAT Y MED:',0,0,'L');
$pdf->cell(120,5,'____________________________________________________________',0,1,'L');
//fila 6
$pdf->cell(1);
$pdf->cell(50,5,'NOMBRE DEL VERIFICADOR:',0,0,'L');
$pdf->cell(140,5,'_______________________________________________________________________',0,1,'L');
//fila 7
$pdf->cell(1);
$pdf->cell(53,5,'NOMBRE DE QUIEN SOLICITA:',0,0,'L');
$pdf->cell(137,5,'_____________________________________________________________________',0,1,'L');
//fila 8
$pdf->cell(1);
$pdf->cell(74,5,'USUARIO, FECHA Y HORA DE IMPRESION:',0,0,'L');
$pdf->cell(116,5,utf8_decode($getData1[0]) . " " .date('d-m-Y H:i:s'),0,1,'L');
//fila 9
$pdf->SetFont('Arial','B',12);
$pdf->setTextColor(255, 0, 0);
$pdf->cell(1);
$pdf->cell(24,5,'ALERGIAS:',0,0,'L');

$pdf->SetFont('Arial','',10);
$pdf->setTextColor(0, 0, 0);

$pdf->cell(167,5,'____________________________________________________________________________________',0,1,'L');
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
$pdf->cell(59,10,utf8_decode('FIRMA DE AUTORIZACIÓN'),0,0,'C');
$pdf->cell(0.1,10,'',1,1,'C');

//LINEA
$pdf->cell(1);
$pdf->cell(189.5,0.1,'',1,1,'C');

//consulta
mysql_select_db($database_horizonte, $horizonte); 
$datos = mysql_query('SELECT DATE_FORMAT(m.fecha_mh,"%d/%m/%Y") as fecha, mc.concepto_to as concepto, m.cantidad_texto_mh as cantidad, concat_ws(" ", t.abreviacion_ti, u.nombre_u, apaterno_u) as doctor, m.indicacion_mh as indicacion, DATE_FORMAT(m.fecha_mh,"%H:%i:%s") as hora, u.cedulaProfesional_u as cedula FROM medicamentos_hospital m left join conceptos mc on mc.id_to = m.id_medicamento_mh left join usuarios u on u.id_u = m.id_u_mh left join titulos t on t.id_ti = u.id_titulo_u left join hospitalizacion h on h.id_h = m.id_hospitalizacion_mh left join pacientes p on p.id_p = h.id_paciente_h left join venta_conceptos v on v.id_vc = h.id_consulta_vc_h left join orden_venta o on o.referencia_ov = v.referencia_vc where m.id_hospitalizacion_mh = ' . $id_h . ' order by m.fecha_mh asc' ,$horizonte) or die (mysql_error());

//contador
$contador = 1;
while ($fila = mysql_fetch_assoc($datos)) {
    //VARIABLES
    $medicamento = $fila['concepto'];
    $nombre_doctor = $fila['doctor'] . " " . $fila['cedula'];
    $indicacion = $fila['indicacion'];
    $cantidad = $fila['cantidad'];
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
    if($contador == 8 || $contador > 9 && $contador % 9 == 0){
        $pdf->Ln(15);

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
        $pdf->cell(59,10,utf8_decode('FIRMA DE AUTORIZACIÓN'),0,0,'C');
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
    $pdf->cell(59,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(20,5,'CANTIDAD:',0,0,'L');
    $pdf->cell(15,5,$cantidad,0,0,'L');
    $pdf->cell(65,5,utf8_decode('PERSONAL MÉDICO/CEDULA:'),0,0,'L');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(59,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
    //
    $pdf->cell(1);
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(5,5,$contador,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(25,5,$fecha,0,0,'C');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(100,5,utf8_decode($nombre_doctor),1,0,'L');
    $pdf->cell(0.1,5,'',1,0,'C');
    $pdf->cell(59,5,'',0,0,'C');
    $pdf->cell(0.1,5,'',1,1,'C');
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
if($contador >= 16 && $contador % 16 == 0){
    $pdf->Ln(14);
}else{
    $pdf->Ln(20);
}
//FIRMAS
$pdf->cell(1);
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
$pdf->cell(95,5,'(NOMBRE COMPLETO Y FIRMA)',0,1,'C');

$pdf->Output();
?>
