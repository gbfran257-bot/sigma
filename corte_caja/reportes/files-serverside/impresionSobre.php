<?php
// Incluir la biblioteca FPDF
require('../../../fpdf/fpdf.php');
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

//recibimos variables
$id_p = $_GET['id_p'];
$referencia = $_GET['referencia'];
$ov = $_GET['ov'];
//

//obtenemos datos del paciente
mysql_select_db($database_horizonte, $horizonte);
$getDatosPaciente =mysql_query("SELECT CONCAT_WS(' ', p.nombre_p, p.apaterno_p, p.amaterno_p), DATE_FORMAT(p.fNac_p, '%d/%m/%Y'), TIMESTAMPDIFF(YEAR, p.fNac_p, CURDATE()), cs.cat_sexo 
                       FROM pacientes p 
                       LEFT JOIN catalogo_sexos cs ON cs.id_sexo = p.sexo_p 
                       WHERE p.id_p = $id_p", $horizonte) or die (mysql_error());
$paciente = mysql_fetch_row($getDatosPaciente);
//

//obtenemos datos del doctor
mysql_select_db($database_horizonte, $horizonte);
$getDatosDoctor =mysql_query("SELECT CONCAT_WS(' ', u.nombre_u, u.apaterno_u, u.amaterno_u) 
                              FROM venta_conceptos v 
                              LEFT JOIN usuarios u ON u.id_u = v.id_personal_medico_vc
                              WHERE v.referencia_vc = '$referencia' AND v.id_personal_medico_vc <> 0 ORDER BY id_vc DESC LIMIT 1", $horizonte) or die (mysql_error());
$doctor = mysql_fetch_row($getDatosDoctor);
//

//Obtenemos datos de la sucursal
mysql_select_db($database_horizonte, $horizonte);
$getDatosSucursal =mysql_query("SELECT s.nombre_su, CONCAT_WS(', ', s.calle_su, s.colonia_su, s.cp_su, s.ciudad_su, s.estado_su), s.email_su, s.telefono_su FROM sucursales s
                                LEFT JOIN orden_venta ov ON ov.sucursal_ov = s.id_su
                                WHERE ov.id_ov = $ov", $horizonte) or die (mysql_error());
$sucursal = mysql_fetch_row($getDatosSucursal);
//

// Crear una nueva instancia de la clase FPDF
//$pdf = new FPDF();
$pdf = new FPDF('P', 'mm', array(215.9, 279.4));

// Añadir una página
$pdf->AddPage();


// Establecer la fuente (Arial, Negrita, Tamaño 16)
$pdf->SetFont('Arial', '', 10);

$pdf->setY(45);
$pdf->Cell(190, 5, utf8_decode("PACIENTE: $paciente[0]"), 0, 1, 'L');
$pdf->Cell(190, 5, utf8_decode("F. NAC: $paciente[1]    EDAD: $paciente[2] AÑOS    SEXO: $paciente[3]"), 0, 1, 'L');
$pdf->Cell(190, 5, utf8_decode("MÉDICO: $doctor[0]"), 0, 1, 'L');
$pdf->Cell(190, 5, utf8_decode("FECHA Y HORA DE IMPRESIÓN: " . date("Y-m-d H:i:s")), 0, 1, 'L');

$pdf->setY(115);
$pdf->Cell(190, 5, utf8_decode("SUCURSAL: $sucursal[0]"), 0, 1, 'L');
$pdf->Cell(190, 5, utf8_decode("DIRECCION: $sucursal[1]"), 0, 1, 'L');
$pdf->Cell(190, 5, utf8_decode("CORREO: $sucursal[2]    TELEFONO: $sucursal[3]"), 0, 1, 'L');

// Salida del PDF al navegador
$pdf->Output();
	
//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>