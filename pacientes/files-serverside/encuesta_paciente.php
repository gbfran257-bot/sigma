<?php
    // Incluir la biblioteca FPDF
    require('../../fpdf/fpdf.php');
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $ref = sqlValue($_GET["ref"], "text");

    // Crear una nueva instancia de la clase FPDF
    $pdf = new FPDF();

    // Añadir una página
    $pdf->AddPage();

    $image1 = "imagenes/generales/logo_zapata.png";
    $pdf->Image("../../imagenes/generales/logo_zapata.png", 10, 10, 25, 0);
    $pdf->Image("../../imagenes/generales/direccion_salud_zapata.png", 170, 9, 35, 0);
    
    //$pdf->Cell(1);

    // Establecer la fuente (Arial, Negrita, Tamaño 16)
    $pdf->SetFont('Arial', 'B', 13);

    // Título
    $pdf->Cell(190,10,utf8_decode('ENCUESTA DE SATISFACCIÓN DEL SERVICIO MÉDICO'),0,1,'C');
    $pdf->Cell(190,10,utf8_decode('Y ENFERMERIA'),0,1,'C');
    // Salto de línea
    $pdf->Ln(10);

    /* obtenemos datos generales */
    mysql_select_db($database_horizonte, $horizonte);
    $qryGenerales =mysql_query("SELECT CONCAT_WS(' ', p.nombre_p, p.apaterno_p, p.amaterno_p), s.nombre_su, DATE_FORMAT(ov.fecha_venta_ov, '%d/%m/%Y %H:%i'), ov.referencia_ov FROM orden_venta ov LEFT JOIN sucursales s ON s.id_su = ov.sucursal_ov LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov WHERE ov.referencia_ov = $ref", $horizonte) or die (mysql_error());
    $generales = mysql_fetch_row($qryGenerales);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 5, utf8_decode("PACIENTE:   " . $generales[0]), 0, 1, 'L');
    $pdf->Cell(60, 5, utf8_decode("REFERENCIA: " . $generales[3]), 0, 0, 'L');
    $pdf->Cell(70, 5, utf8_decode("SUCURSAL: " . $generales[1]), 0, 0, 'C');
    $pdf->Cell(60, 5, utf8_decode("FECHA: " . $generales[2]), 0, 1, 'C');

    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 13);

    mysql_select_db($database_horizonte, $horizonte);
    $consulta = "SELECT pe.pregunta_p, re.respuesta_re, re.comentario_re FROM preguntas_encuesta pe LEFT JOIN respuestas_encuesta re ON pe.clave_p = re.clave_p_re WHERE re.ref_re = $ref";
    $ejecutar_query = mysql_query($consulta, $horizonte);

    while ($resultado = mysql_fetch_assoc($ejecutar_query)) {
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(190,11,utf8_decode($resultado['pregunta_p']),0,1,'L');

        if($resultado['respuesta_re'] == 1){
            $pdf->SetTextColor(0, 128, 0);
            $r = "Bueno";
        }else if($resultado['respuesta_re'] == 2){
            $pdf->SetTextColor(230, 204, 0);
            $r = "Regular";
        }elseif($resultado['respuesta_re'] == 3){
            $pdf->SetTextColor(255, 0, 0);
            $r = "Malo";
        }else{

        }
        
        $pdf->Cell(190,11,utf8_decode($r),0,1,'L');
    }

    


    /* $id_usuario = intval($_GET['id_usuario']);
    mysql_select_db($database_horizonte, $horizonte);
    $resultC =mysql_query("SELECT usuario_u FROM usuarios WHERE id_u = $id_usuario ", $horizonte) or die (mysql_error());
    $usuario = mysql_fetch_row($resultC); */

    /* mysql_select_db($database_horizonte, $horizonte);
    $consulta = "SELECT s.id, c.concepto_to, g.nombre_generico_med, s.existencias, mms.max_mm, mms.min_mm, CAST(mms.max_mm AS SIGNED) - CAST(s.existencias AS SIGNED) as surtir, s.id_Producto, s.id_stock FROM stock_has_bach s left join conceptos c on c.id_to = s.id_Producto left join stock s1 on s1.id = s.id_stock left join usuarios u on u.id_u = s.usuario_registro left join sucursales su on su.id_su = s1.id_su left join medicamentos g on g.id_med = c.id_medicamento_g left join estatus es on es.id_est = s.estatus left join max_min_stock mms on mms.id_producto = s.id_Producto WHERE (s.fecha_update BETWEEN '2001-01-01 00:00:00' AND '$fecha') AND (s.es_traspaso = 0 AND s.id_stock = $id_sucursal) AND (existencias = 0 OR existencias < mms.min_mm) group by s.id_Producto ORDER BY concepto_to LIMIT 0, 1000;";
    $ejecutar_query = mysql_query($consulta, $horizonte);

    while ($resultado = mysql_fetch_assoc($ejecutar_query)) {

    } */

    // Salida del PDF al navegador
    $pdf->Output();
?>
