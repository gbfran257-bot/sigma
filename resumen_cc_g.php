<?php 
require("Connections/config.php");
require("funciones/php/values.php");

// Verificar y usar la variable de conexión correcta
if(!isset($mysql) || !$mysql) {
    die("Error: No hay conexion a la base de datos. Verifica config.php");
}

# Definimos las variables
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-d');
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');
$check_hoy = isset($_GET['check_hoy']) ? $_GET['check_hoy'] : '';

if($check_hoy == '1'){
    $fecha_inicio = date('Y-m-d');
    $fecha_fin = date('Y-m-d');
}

// =============================================
// 1. OBTENER TOTAL DE ORDENES DE VENTA (TABLA 1)
// =============================================
$query_total_ordenes = "SELECT SUM(gran_total_ov) AS total_ventas FROM orden_venta WHERE DATE(fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_total_ordenes = mysqli_query($mysql, $query_total_ordenes);
$row_total_ordenes = mysqli_fetch_assoc($result_total_ordenes);
$total_ordenes_venta = $row_total_ordenes['total_ventas'] ? $row_total_ordenes['total_ventas'] : 0;

// =============================================
// 2. OBTENER TOTAL DE ORDENES CANCELADAS
// =============================================
$query_total_canceladas = "SELECT COUNT(*) as total_ordenes, SUM(gran_total_ov) as total_monto FROM orden_venta_del WHERE DATE(fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_total_canceladas = mysqli_query($mysql, $query_total_canceladas);
$row_canceladas = mysqli_fetch_assoc($result_total_canceladas);
$total_cancelaciones_ordenes = $row_canceladas['total_ordenes'] ? $row_canceladas['total_ordenes'] : 0;
$total_cancelaciones_monto = $row_canceladas['total_monto'] ? $row_canceladas['total_monto'] : 0;

// =============================================
// 3. OBTENER VISITAS, PACIENTES Y PRODUCTOS POR DEPARTAMENTO
// =============================================
$query_visitas_departamentos = "
SELECT 
    d.id_d,
    d.nombre_d,
    COUNT(DISTINCT vc.referencia_vc) AS num_visitas,
    COUNT(DISTINCT vc.id_paciente_vc) AS num_pacientes,
    COUNT(vc.id_concepto_es) AS num_productos
FROM venta_conceptos vc
INNER JOIN conceptos c ON vc.id_concepto_es = c.id_to
INNER JOIN departamentos d ON c.id_departamento_to = d.id_d
WHERE DATE(vc.fecha_venta_vc) BETWEEN '$fecha_inicio' AND '$fecha_fin'
    AND (vc.temporal_vc = 0 OR vc.temporal_vc IS NULL)
GROUP BY d.id_d, d.nombre_d
ORDER BY d.nombre_d";

$result_visitas = mysqli_query($mysql, $query_visitas_departamentos);

// Calcular totales
$total_productos_general = 0;
$visitas_por_departamento = [];

while($row = mysqli_fetch_assoc($result_visitas)) {
    $visitas_por_departamento[$row['id_d']] = [
        'id_d' => $row['id_d'],
        'nombre_d' => $row['nombre_d'],
        'num_visitas' => $row['num_visitas'],
        'num_pacientes' => $row['num_pacientes'],
        'num_productos' => $row['num_productos']
    ];
    $total_productos_general += $row['num_productos'];
}

// =============================================
// 4. OBTENER VISITAS POR AREA
// =============================================
$query_visitas_areas = "
SELECT 
    COALESCE(NULLIF(c.linea_c,''), 'SIN AREA') AS area,
    COUNT(DISTINCT vc.referencia_vc) AS num_visitas,
    COUNT(DISTINCT vc.id_paciente_vc) AS num_pacientes,
    COUNT(vc.id_concepto_es) AS num_conceptos
FROM venta_conceptos vc
INNER JOIN conceptos c ON vc.id_concepto_es = c.id_to
WHERE DATE(vc.fecha_venta_vc) BETWEEN '$fecha_inicio' AND '$fecha_fin'
    AND (vc.temporal_vc = 0 OR vc.temporal_vc IS NULL)
GROUP BY area
ORDER BY area";

$result_visitas_areas = mysqli_query($mysql, $query_visitas_areas);

// Calcular totales por area
$total_conceptos_areas_general = 0;
$visitas_por_area = [];

while($row = mysqli_fetch_assoc($result_visitas_areas)) {
    $visitas_por_area[] = [
        'area' => $row['area'],
        'num_visitas' => $row['num_visitas'],
        'num_pacientes' => $row['num_pacientes'],
        'num_conceptos' => $row['num_conceptos']
    ];
    $total_conceptos_areas_general += $row['num_conceptos'];
}

// =============================================
// 5. CONSULTA PARA SALDO DE DEPARTAMENTOS
// =============================================
$query_saldo_original = "
WITH ordenes AS (
    SELECT 
        o.referencia_ov,
        o.gran_total_ov,
        COALESCE(SUM(p.pago_pag), 0) AS total_pagado,
        o.gran_total_ov - COALESCE(SUM(p.pago_pag), 0) AS saldo
    FROM orden_venta o
    LEFT JOIN pagos_ov p ON p.referencia_pag = o.referencia_ov
    WHERE DATE(o.fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'
    GROUP BY o.referencia_ov, o.gran_total_ov
),
detalle AS (
    SELECT 
        vc.referencia_vc,
        d.id_d,
        d.nombre_d,
        COUNT(vc.id_concepto_es) AS productos,
        SUM(vc.precio_vc) AS total_venta,
        COUNT(DISTINCT vc.id_paciente_vc) AS pacientes
    FROM venta_conceptos vc
    INNER JOIN conceptos c ON vc.id_concepto_es = c.id_to
    INNER JOIN departamentos d ON c.id_departamento_to = d.id_d
    WHERE (vc.temporal_vc = 0 OR vc.temporal_vc IS NULL)
        AND DATE(vc.fecha_venta_vc) BETWEEN '$fecha_inicio' AND '$fecha_fin'
    GROUP BY vc.referencia_vc, d.id_d, d.nombre_d
)
SELECT 
    d.id_d,
    d.nombre_d,
    SUM(o.saldo * (d.total_venta / o.gran_total_ov)) AS saldo,
    SUM(d.pacientes) AS num_pacientes,
    SUM(d.productos) AS num_productos
FROM detalle d
INNER JOIN ordenes o ON o.referencia_ov = d.referencia_vc
GROUP BY d.id_d, d.nombre_d
ORDER BY d.nombre_d";

$result_saldo_original = mysqli_query($mysql, $query_saldo_original);

// Guardar resultados de saldo original
$saldos_originales = [];
$pacientes_originales = [];
$productos_originales = [];

while($row = mysqli_fetch_assoc($result_saldo_original)) {
    $saldos_originales[$row['id_d']] = $row['saldo'];
    $pacientes_originales[$row['id_d']] = $row['num_pacientes'];
    $productos_originales[$row['id_d']] = $row['num_productos'];
}

// =============================================
// 6. CONSULTA PARA ORDENES CANCELADAS (MODAL) - CON REFERENCIA
// =============================================
$query_ordenes_canceladas = "SELECT 
                                id_ov AS referencia,
                                fecha_venta_ov,
                                subtotal_ov,
                                (adicionales_c_ov + adicionales_p_ov + adicionales_ei_ov + adicionales_el_ov + adicionales_s_ov) as cargos_extras,
                                (desc_d_cta + desc_d_img + desc_d_lab + desc_d_serv + desc_d_pro + t_desc_cta + t_desc_img + t_desc_lab + t_desc_serv + t_desc_pro) as descuentos,
                                gran_total_ov as total,
                                motivo_del
                            FROM orden_venta_del
                            WHERE DATE(fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'
                            ORDER BY fecha_venta_ov DESC";

$result_canceladas = mysqli_query($mysql, $query_ordenes_canceladas);

// =============================================
// 7. CONSULTA PARA PAGOS POR USUARIO (SOLO TOTAL > 0)
// =============================================
$query_pagos_usuario = "SELECT 
                            u.usuario_u AS usuario,
                            COUNT(p.id_pag) AS num_pagos,
                            COALESCE(SUM(p.pago_pag), 0) AS total
                        FROM usuarios u
                        INNER JOIN pagos_ov p ON p.usuario_pag = u.id_u  
                        WHERE DATE(p.fecha_pag) BETWEEN '$fecha_inicio' AND '$fecha_fin'
                        GROUP BY u.id_u, u.usuario_u
                        HAVING total > 0
                        ORDER BY total DESC";

$result_pagos_usuario = mysqli_query($mysql, $query_pagos_usuario);

// Calcular total de pagos por usuario
$total_pagos_usuario = 0;
$pagos_usuario_data = [];
if($result_pagos_usuario && mysqli_num_rows($result_pagos_usuario) > 0) {
    while($usuario = mysqli_fetch_assoc($result_pagos_usuario)) {
        $total_pagos_usuario += $usuario['total'];
        $pagos_usuario_data[] = $usuario;
    }
}

// =============================================
// 8. CONSULTA PARA DEPARTAMENTOS CON PAGOS DIRECTOS (PARA PDF)
// =============================================
$query_departamentos_pdf = "
WITH 
pagos_filtrados AS (
    SELECT 
        referencia_pag,
        departamento_pa AS id_departamento,
        pago_pag
    FROM pagos_ov
    WHERE DATE(fecha_pag) BETWEEN '$fecha_inicio' AND '$fecha_fin'
        AND departamento_pa IS NOT NULL
),
total_por_depto AS (
    SELECT 
        id_departamento,
        SUM(pago_pag) AS total_pagos
    FROM pagos_filtrados
    GROUP BY id_departamento
),
metricas_ordenes AS (
    SELECT 
        pf.id_departamento,
        pf.referencia_pag,
        vc.id_paciente_vc,
        vc.id_concepto_es
    FROM pagos_filtrados pf
    INNER JOIN venta_conceptos vc ON pf.referencia_pag = vc.referencia_vc
    INNER JOIN conceptos c ON vc.id_concepto_es = c.id_to
    WHERE c.id_departamento_to = pf.id_departamento
        AND (vc.temporal_vc = 0 OR vc.temporal_vc IS NULL)
)
SELECT 
    d.nombre_d AS departamento,
    COUNT(DISTINCT mo.referencia_pag) AS num_visitas,
    COUNT(DISTINCT mo.id_paciente_vc) AS num_pacientes,
    COUNT(mo.id_concepto_es) AS num_conceptos,
    td.total_pagos AS total
FROM total_por_depto td
INNER JOIN departamentos d ON td.id_departamento = d.id_d
LEFT JOIN metricas_ordenes mo ON td.id_departamento = mo.id_departamento
GROUP BY d.id_d, d.nombre_d, td.total_pagos
ORDER BY d.nombre_d";

$result_departamentos_pdf = mysqli_query($mysql, $query_departamentos_pdf);

// Almacenar resultados de departamentos para PDF
$departamentos_pdf_data = [];
$total_visitas_departamentos_pdf = 0;
$total_pacientes_departamentos_pdf = 0;
$total_conceptos_departamentos_pdf = 0;
$total_pagos_departamentos_pdf = 0;

if($result_departamentos_pdf && mysqli_num_rows($result_departamentos_pdf) > 0) {
    while($row = mysqli_fetch_assoc($result_departamentos_pdf)) {
        $departamentos_pdf_data[] = [
            'departamento' => $row['departamento'],
            'num_visitas' => $row['num_visitas'],
            'num_pacientes' => $row['num_pacientes'],
            'num_conceptos' => $row['num_conceptos'],
            'total' => $row['total']
        ];
        $total_visitas_departamentos_pdf += $row['num_visitas'];
        $total_pacientes_departamentos_pdf += $row['num_pacientes'];
        $total_conceptos_departamentos_pdf += $row['num_conceptos'];
        $total_pagos_departamentos_pdf += $row['total'];
    }
}

// =============================================
// 9. CONSULTA PARA ORDENES CON SALDO (MODAL) - CON DATOS DEL PACIENTE
// =============================================
$query_ordenes_saldo = "SELECT 
                            o.id_ov AS referencia,
                            p.id_p,
                            CONCAT(COALESCE(p.nombre_p, ''), ' ', COALESCE(p.apaterno_p, ''), ' ', COALESCE(p.amaterno_p, '')) AS nombre_paciente,
                            o.gran_total_ov AS total,
                            COALESCE(pa.total_pagado, 0) AS abonado,
                            (o.gran_total_ov - COALESCE(pa.total_pagado, 0)) AS saldo
                        FROM orden_venta o 
                        INNER JOIN pacientes p ON o.id_paciente_ov = p.id_p
                        LEFT JOIN (
                            SELECT 
                                referencia_pag, 
                                SUM(pago_pag) AS total_pagado 
                            FROM pagos_ov 
                            GROUP BY referencia_pag
                        ) pa ON o.referencia_ov = pa.referencia_pag 
                        WHERE DATE(o.fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin' 
                        HAVING saldo > 0 
                        ORDER BY o.id_ov";
$result_ordenes_saldo = mysqli_query($mysql, $query_ordenes_saldo);

// =============================================
// 10. CONSULTA PARA TOTALES DE ORDENES (TABLA 1)
// =============================================
$query_contador = "SELECT COUNT(id_ov) as total_ordenes FROM orden_venta WHERE DATE(fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_contador = mysqli_query($mysql, $query_contador);
$total_ordenes = ($result_contador && mysqli_num_rows($result_contador) > 0) ? mysqli_fetch_assoc($result_contador)['total_ordenes'] : 0;

$query_subtotal = "SELECT SUM(subtotal_ov) as subtotal_venta FROM orden_venta WHERE DATE(fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_subtotal = mysqli_query($mysql, $query_subtotal);
$row_subtotal = ($result_subtotal && mysqli_num_rows($result_subtotal) > 0) ? mysqli_fetch_assoc($result_subtotal) : null;
$subtotal_venta = ($row_subtotal && $row_subtotal['subtotal_venta'] !== null) ? $row_subtotal['subtotal_venta'] : 0;

$query_cargos = "SELECT SUM(adicionales_c_ov + adicionales_p_ov + adicionales_ei_ov + adicionales_el_ov + adicionales_s_ov) AS cargos_extras FROM orden_venta WHERE DATE(fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_cargos = mysqli_query($mysql, $query_cargos);
$row_cargos = ($result_cargos && mysqli_num_rows($result_cargos) > 0) ? mysqli_fetch_assoc($result_cargos) : null;
$cargos_extras = ($row_cargos && $row_cargos['cargos_extras'] !== null) ? $row_cargos['cargos_extras'] : 0;

$query_total = "SELECT SUM(gran_total_ov) AS TOTAL FROM orden_venta WHERE DATE(fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_total = mysqli_query($mysql, $query_total);
$row_total = ($result_total && mysqli_num_rows($result_total) > 0) ? mysqli_fetch_assoc($result_total) : null;
$total_general = ($row_total && $row_total['TOTAL'] !== null) ? $row_total['TOTAL'] : 0;

$total_descuentos = ($subtotal_venta + $cargos_extras) - $total_general;
if($total_descuentos === null) $total_descuentos = 0;

$query_abonado = "SELECT SUM(pa.total_pagado) AS ABONADO FROM orden_venta o LEFT JOIN (SELECT referencia_pag, SUM(pago_pag) AS total_pagado FROM pagos_ov GROUP BY referencia_pag) pa ON o.referencia_ov = pa.referencia_pag WHERE DATE(o.fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_abonado = mysqli_query($mysql, $query_abonado);
$row_abonado = ($result_abonado && mysqli_num_rows($result_abonado) > 0) ? mysqli_fetch_assoc($result_abonado) : null;
$total_abonado = ($row_abonado && $row_abonado['ABONADO'] !== null) ? $row_abonado['ABONADO'] : 0;

$query_saldo = "SELECT SUM(o.gran_total_ov) - SUM(pa.total_pagado) AS SALDO FROM orden_venta o LEFT JOIN (SELECT referencia_pag, SUM(pago_pag) AS total_pagado FROM pagos_ov GROUP BY referencia_pag) pa ON o.referencia_ov = pa.referencia_pag WHERE DATE(o.fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$result_saldo = mysqli_query($mysql, $query_saldo);
$row_saldo = ($result_saldo && mysqli_num_rows($result_saldo) > 0) ? mysqli_fetch_assoc($result_saldo) : null;
$total_saldo_general = ($row_saldo && $row_saldo['SALDO'] !== null) ? $row_saldo['SALDO'] : 0;

// =============================================
// 11. ORDENES SIN CONCEPTOS
// =============================================
$query_ordenes_sin_conceptos = "SELECT COUNT(DISTINCT o.referencia_ov) as total, SUM(o.gran_total_ov) as total_venta FROM orden_venta o LEFT JOIN venta_conceptos vc ON vc.referencia_vc = o.referencia_ov AND DATE(vc.fecha_venta_vc) BETWEEN '$fecha_inicio' AND '$fecha_fin' WHERE DATE(o.fecha_venta_ov) BETWEEN '$fecha_inicio' AND '$fecha_fin' AND vc.id_concepto_es IS NULL";
$result_sin_conceptos = mysqli_query($mysql, $query_ordenes_sin_conceptos);
$sin_conceptos = mysqli_fetch_assoc($result_sin_conceptos);

// Variable para controlar si se debe mostrar el PDF
$generar_pdf = isset($_GET['generar_pdf']) && $_GET['generar_pdf'] == '1';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de ventas</title>
    <link rel="stylesheet" href="css/reporte_cc_g.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h1>SISTEMA DE REPORTES - RESUMEN DE VENTAS</h1>
        <p>Generación de reportes por fechas</p>
    </div>

    <!-- TABLA 1: ÓRDENES DE VENTA -->
    <div class="section">
        <h2 class="section-title">
            ÓRDENES DE VENTA
            <button type="button" class="btn-canceladas" onclick="mostrarModalCanceladas()">
                Ver Cancelaciones
            </button>
        </h2>
        <div class="table-wrapper">
            <table class="main-table">
                <thead>
                    <tr>
                        <th># ÓRDENES</th>
                        <th class="text-right">SUBTOTAL</th>
                        <th class="text-right">CARGOS EXTRAS</th>
                        <th class="text-right">DESCUENTOS</th>
                        <th class="text-right">ABONADO</th>
                        <th class="text-right">TOTAL</th>
                        <th class="text-right">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"><strong><?php echo number_format($total_ordenes, 0); ?></strong></td>
                        <td class="text-right">$ <?php echo number_format($subtotal_venta, 2); ?></td>
                        <td class="text-right">$ <?php echo number_format($cargos_extras, 2); ?></td>
                        <td class="text-right">$ <?php echo number_format($total_descuentos, 2); ?></td>
                        <td class="text-right">$ <?php echo number_format($total_abonado, 2); ?></td>
                        <td class="text-right">$ <?php echo number_format($total_general, 2); ?></td>
                        <td class="text-right"><span class="saldo-link" onclick="mostrarModalSaldo()">$ <?php echo number_format($total_saldo_general, 2); ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

 <!-- TABLA 2: DEPARTAMENTOS (CORREGIDO - ALINEACIÓN DE COLUMNAS) -->
<div class="section">
    <h2 class="section-title">VENTAS POR DEPARTAMENTO</h2>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>DEPARTAMENTO</th>
                    <th class="text-right"># VISITAS</th>
                    <th class="text-right"># PACIENTES</th>
                    <th class="text-right"># PRODUCTOS</th>
                    <th class="text-right">TOTAL VENTAS</th>
                    <th class="text-right">SALDO</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_visitas_acum = 0;
                $total_pacientes_acum = 0;
                $total_productos_acum = 0;
                $total_ventas_acum = 0;
                $total_saldo_acum = 0;
                
                // Calcular el valor por producto
                $valor_por_producto = ($total_productos_general > 0) ? ($total_ordenes_venta / $total_productos_general) : 0;
                
                foreach($visitas_por_departamento as $id_d => $depto) {
                    $num_visitas = $depto['num_visitas'];
                    $num_pacientes = $depto['num_pacientes'];
                    $num_productos = $depto['num_productos'];
                    $total_ventas = $num_productos * $valor_por_producto;
                    $saldo = $saldos_originales[$id_d] ? $saldos_originales[$id_d] : 0;
                    
                    $total_visitas_acum += $num_visitas;
                    $total_pacientes_acum += $num_pacientes;
                    $total_productos_acum += $num_productos;
                    $total_ventas_acum += $total_ventas;
                    $total_saldo_acum += $saldo;
                    ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($depto['nombre_d']); ?></strong></td>
                        <td class="text-right"><?php echo number_format($num_visitas, 0); ?></td>
                        <td class="text-right"><?php echo number_format($num_pacientes, 0); ?></td>
                        <td class="text-right"><?php echo number_format($num_productos, 0); ?></td>
                        <td class="text-right">$ <?php echo number_format($total_ventas, 2); ?></td>
                        <td class="text-right">$ <?php echo number_format($saldo, 2); ?></td>
                    </tr>
                    <?php
                }
                
                if($sin_conceptos['total'] > 0) {
                    $total_visitas_acum += $sin_conceptos['total'];
                    $total_ventas_acum += $sin_conceptos['total_venta'];
                    ?>
                    <tr style="background-color: #fff8e7;">
                        <td><strong>⚠️ ÓRDENES SIN CONCEPTOS</strong></td>
                        <td class="text-right"><strong><?php echo number_format($sin_conceptos['total'], 0); ?></strong></td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        <td class="text-right"><strong>$ <?php echo number_format($sin_conceptos['total_venta'], 2); ?></strong></td>
                        <td class="text-right">$ 0.00</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td><strong>TOTALES</strong></td>
                    <td class="text-right"><strong><?php echo number_format($total_visitas_acum, 0); ?></strong></td>
                    <td class="text-right"><strong><?php echo number_format($total_pacientes_acum, 0); ?></strong></td>
                    <td class="text-right"><strong><?php echo number_format($total_productos_acum, 0); ?></strong></td>
                    <td class="text-right"><strong>$ <?php echo number_format($total_ventas_acum, 2); ?></strong></td>
                    <td class="text-right"><strong>$ <?php echo number_format($total_saldo_acum, 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    <!-- TABLA 3: ÁREAS (CORREGIDO - DISTRIBUCIÓN POR CONCEPTOS) -->
    <div class="section">
        <h2 class="section-title">VENTAS POR ÁREA</h2>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>ÁREA</th>
                        <th class="text-right"># VISITAS</th>
                        <th class="text-right"># PACIENTES</th>
                        <th class="text-right"># CONCEPTOS</th>
                        <th class="text-right">TOTAL VENTAS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_areas_visitas = 0;
                    $total_areas_pacientes = 0;
                    $total_areas_conceptos = 0;
                    $total_areas_ventas = 0;
                    $contador = 1;
                    
                    // Calcular el valor por concepto
                    $valor_por_concepto = ($total_conceptos_areas_general > 0) ? ($total_ordenes_venta / $total_conceptos_areas_general) : 0;
                    
                    foreach($visitas_por_area as $area_data) {
                        $area = $area_data['area'];
                        $num_visitas = $area_data['num_visitas'];
                        $num_pacientes = $area_data['num_pacientes'];
                        $num_conceptos = $area_data['num_conceptos'];
                        $total_ventas = $num_conceptos * $valor_por_concepto;
                        
                        $total_areas_visitas += $num_visitas;
                        $total_areas_pacientes += $num_pacientes;
                        $total_areas_conceptos += $num_conceptos;
                        $total_areas_ventas += $total_ventas;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $contador++; ?></td>
                            <td><strong><?php echo htmlspecialchars($area); ?></strong></td>
                            <td class="text-right"><?php echo number_format($num_visitas, 0); ?></td>
                            <td class="text-right"><?php echo number_format($num_pacientes, 0); ?></td>
                            <td class="text-right"><?php echo number_format($num_conceptos, 0); ?></td>
                            <td class="text-right">$ <?php echo number_format($total_ventas, 2); ?></td>
                        </tr>
                        <?php
                    }
                    
                    if($contador == 1) {
                        echo "<tr><td colspan='6' class='text-center'>No hay datos en el rango de fechas seleccionado</td></tr>";
                    }
                    ?>
                </tbody>
                <?php if($contador > 1): ?>
                <tfoot>
                    <tr class="total-row">
                        <td class="text-center"><strong><?php echo ($contador-1); ?></strong></td>
                        <td><strong>TOTALES</strong></td>
                        <td class="text-right"><strong><?php echo number_format($total_areas_visitas, 0); ?></strong></td>
                        <td class="text-right"><strong><?php echo number_format($total_areas_pacientes, 0); ?></strong></td>
                        <td class="text-right"><strong><?php echo number_format($total_areas_conceptos, 0); ?></strong></td>
                        <td class="text-right"><strong>$ <?php echo number_format($total_areas_ventas, 2); ?></strong></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <!-- TABLA 4: PAGOS POR USUARIO -->
    <div class="section" id="seccion-pagos">
        <h2 class="section-title">PAGOS POR USUARIO</h2>
        <div class="table-wrapper">
            <table class="modal-table" id="tabla-pagos">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>USUARIO</th>
                        <th class="text-right"># PAGOS</th>
                        <th class="text-right">TOTAL $</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(count($pagos_usuario_data) > 0) {
                        $total_usuarios_pagos = 0;
                        $contador_usuarios = 1;
                        
                        foreach($pagos_usuario_data as $usuario) {
                            $total_usuarios_pagos++;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $contador_usuarios++; ?></td>
                                <td><strong><?php echo htmlspecialchars($usuario['usuario']); ?></strong></td>
                                <td class="text-right"><?php echo number_format($usuario['num_pagos']); ?></td>
                                <td class="text-right">$ <?php echo number_format($usuario['total'], 2); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td class="text-center"><strong><?php echo $total_usuarios_pagos; ?></strong></td>
                                <td><strong>TOTALES</strong></td>
                                <td class="text-right"><strong><?php echo number_format($total_usuarios_pagos); ?></strong></td>
                                <td class="text-right"><strong>$ <?php echo number_format($total_pagos_usuario, 2); ?></strong></td>
                            </tr>
                        </tfoot>
                        <?php 
                    } else {
                        echo "<tbody><tr><td colspan='4' class='text-center'>No hay pagos registrados en el rango de fechas seleccionado</td></tr></tbody>";
                    }
                    ?>
            </table>
        </div>
    </div>

    <!-- TABLA 5: DEPARTAMENTOS PARA PDF -->
    <div class="section" id="seccion-departamentos-pdf" style="<?php echo $generar_pdf ? 'display: block;' : 'display: none;'; ?>">
        <h2 class="section-title">REPORTE DE DEPARTAMENTOS</h2>
        <p style="margin-bottom: 10px; font-size: 12px; color: #555;">Métricas de ventas y pagos por departamento en el período seleccionado</p>
        <div class="table-wrapper">
            <table class="modal-table" id="tabla-departamentos-pdf">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>DEPARTAMENTO</th>
                        <th class="text-right"># VISITAS</th>
                        <th class="text-right"># PACIENTES</th>
                        <th class="text-right"># CONCEPTOS</th>
                        <th class="text-right">TOTAL PAGADO $</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(count($departamentos_pdf_data) > 0) {
                        $contador_deptos = 1;
                        foreach($departamentos_pdf_data as $depto) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $contador_deptos++; ?></td>
                                <td><strong><?php echo htmlspecialchars($depto['departamento']); ?></strong></td>
                                <td class="text-right"><?php echo number_format($depto['num_visitas'], 0); ?></td>
                                <td class="text-right"><?php echo number_format($depto['num_pacientes'], 0); ?></td>
                                <td class="text-right"><?php echo number_format($depto['num_conceptos'], 0); ?></td>
                                <td class="text-right">$ <?php echo number_format($depto['total'], 2); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td class="text-center"><strong><?php echo count($departamentos_pdf_data); ?></strong></td>
                                <td><strong>TOTALES GENERALES</strong></td>
                                <td class="text-right"><strong><?php echo number_format($total_visitas_departamentos_pdf, 0); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($total_pacientes_departamentos_pdf, 0); ?></strong></td>
                                <td class="text-right"><strong><?php echo number_format($total_conceptos_departamentos_pdf, 0); ?></strong></td>
                                <td class="text-right"><strong>$ <?php echo number_format($total_pagos_departamentos_pdf, 2); ?></strong></td>
                            </tr>
                        </tfoot>
                        <?php 
                    } else {
                        echo "<tbody><tr><td colspan='6' class='text-center'>No hay datos en el rango de fechas seleccionado</td><td></tbody>";
                    }
                    ?>
            </table>
        </div>
    </div>

    <!-- Formulario de filtros -->
    <form method="GET" action="" class="filter-footer" id="filtrosAbajo">
        <div class="filter-group">
            <label>📅 Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio_footer" value="<?php echo htmlspecialchars($fecha_inicio); ?>">
        </div>
        <div class="filter-group">
            <label>📅 Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin_footer" value="<?php echo htmlspecialchars($fecha_fin); ?>">
        </div>
        <div class="filter-group checkbox-group">
            <input type="checkbox" name="check_hoy" value="1" id="check_hoy_footer" <?php echo ($check_hoy == '1') ? 'checked' : ''; ?>>
            <label for="check_hoy_footer">⭐ Solo Hoy</label>
        </div>
        <button type="submit" class="btn-filtrar">🔍 Aplicar Filtros</button>
        <button type="button" class="btn-pdf" onclick="generarPDFPagos()">📄 Generar Reporte PDF</button>
    </form>
    
    <div class="footer-info">
        📅 Reporte generado el <?php echo date('d/m/Y H:i:s'); ?> | Rango: <?php echo htmlspecialchars($fecha_inicio) . " — " . htmlspecialchars($fecha_fin); ?>
        <?php if($check_hoy == '1') echo " | Modo: solo hoy"; ?>
    </div>
</div>

<!-- MODAL SALDOS CON DATOS DEL PACIENTE -->
<div id="modalSaldo" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Órdenes con Saldo Pendiente</h2>
            <span class="close" onclick="cerrarModal('modalSaldo')">&times;</span>
        </div>
        <div class="modal-body">
            <div class="table-wrapper">
                <table class="modal-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>REFERENCIA</th>
                            <th>PACIENTE</th>
                            <th class="text-right">TOTAL ($)</th>
                            <th class="text-right">ABONADO ($)</th>
                            <th class="text-right">SALDO ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result_ordenes_saldo && mysqli_num_rows($result_ordenes_saldo) > 0) {
                            $total_saldo_general_modal = 0;
                            $contador_saldos = 1;
                            while($orden = mysqli_fetch_assoc($result_ordenes_saldo)) {
                                $total_saldo_general_modal += $orden['saldo'];
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $contador_saldos++; ?></td>
                                    <td><strong><?php echo htmlspecialchars($orden['referencia']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($orden['nombre_paciente']); ?></td>
                                    <td class="text-right">$ <?php echo number_format($orden['total'], 2); ?></td>
                                    <td class="text-right">$ <?php echo number_format($orden['abonado'], 2); ?></td>
                                    <td class="text-right" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); font-weight: 700;">$ <?php echo number_format($orden['saldo'], 2); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr style="background: linear-gradient(135deg, #2c3e50 0%, #1a4a6f 100%); color: white; font-weight: 700;">
                                <td colspan="5" class="text-right">TOTAL GENERAL SALDOS:</td>
                                <td class="text-right">$ <?php echo number_format($total_saldo_general_modal, 2); ?></td>
                            </tr>
                            <?php
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>✅ No hay órdenes con saldo pendiente en el rango seleccionado</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ÓRDENES CANCELADAS -->
<div id="modalCanceladas" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Órdenes Canceladas</h2>
            <span class="close" onclick="cerrarModal('modalCanceladas')">&times;</span>
        </div>
        <div class="modal-body">
            <div class="table-wrapper">
                <table class="modal-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>REFERENCIA</th>
                            <th class="text-right">Subtotal</th>
                            <th class="text-right">Cargos Extras</th>
                            <th class="text-right">Descuentos</th>
                            <th class="text-right">Total</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result_canceladas && mysqli_num_rows($result_canceladas) > 0) {
                            $total_canceladas_sum = 0;
                            while($cancelada = mysqli_fetch_assoc($result_canceladas)) {
                                $total_canceladas_sum += $cancelada['total'];
                                echo "<tr>
                                        <td>" . date('d/m/Y', strtotime($cancelada['fecha_venta_ov'])) . "</td>
                                        <td><strong>" . htmlspecialchars($cancelada['referencia']) . "</strong></td>
                                        <td class='text-right'>$ " . number_format($cancelada['subtotal_ov'], 2) . "</td>
                                        <td class='text-right'>$ " . number_format($cancelada['cargos_extras'], 2) . "</td>
                                        <td class='text-right'>$ " . number_format($cancelada['descuentos'], 2) . "</td>
                                        <td class='text-right'>$ " . number_format($cancelada['total'], 2) . "</td>
                                        <td>" . htmlspecialchars($cancelada['motivo_del']) . "</td>
                                    </tr>";
                            }
                            echo "<tr style='background: linear-gradient(135deg, #e67e22 0%, #d35400 100%); color: white; font-weight: 700;'>
                                    <td colspan='5' class='text-right'>TOTAL GENERAL CANCELACIONES:</td>
                                    <td class='text-right'>$ " . number_format($total_canceladas_sum, 2) . "</td>
                                    <td></td>
                                </tr>";
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>✅ No hay órdenes canceladas en el rango seleccionado</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarModalSaldo() { document.getElementById('modalSaldo').style.display = 'block'; }
    function mostrarModalCanceladas() { document.getElementById('modalCanceladas').style.display = 'block'; }
    function cerrarModal(modalId) { document.getElementById(modalId).style.display = 'none'; }
    
    function generarPDFPagos() {
        var fechaInicio = document.getElementById('fecha_inicio_footer').value;
        var fechaFin = document.getElementById('fecha_fin_footer').value;
        var checkHoy = document.getElementById('check_hoy_footer').checked ? '1' : '';
        
        var url = window.location.pathname + '?';
        url += 'fecha_inicio=' + fechaInicio;
        url += '&fecha_fin=' + fechaFin;
        if (checkHoy === '1') url += '&check_hoy=1';
        url += '&generar_pdf=1';
        
        window.open(url, '_blank');
    }
    
    window.onclick = function(event) {
        if (event.target == document.getElementById('modalSaldo')) document.getElementById('modalSaldo').style.display = 'none';
        if (event.target == document.getElementById('modalCanceladas')) document.getElementById('modalCanceladas').style.display = 'none';
    }
    
    function sincronizarFiltros() {
        var checkHoyArriba = document.getElementById('check_hoy');
        var checkHoyAbajo = document.getElementById('check_hoy_footer');
        var fechaInicioArriba = document.getElementById('fecha_inicio');
        var fechaInicioAbajo = document.getElementById('fecha_inicio_footer');
        var fechaFinArriba = document.getElementById('fecha_fin');
        var fechaFinAbajo = document.getElementById('fecha_fin_footer');
        if (checkHoyArriba && checkHoyAbajo) checkHoyAbajo.checked = checkHoyArriba.checked;
        if (fechaInicioArriba && fechaInicioAbajo) fechaInicioAbajo.value = fechaInicioArriba.value;
        if (fechaFinArriba && fechaFinAbajo) fechaFinAbajo.value = fechaFinArriba.value;
    }
    
    var checkHoyElement = document.getElementById('check_hoy');
    var checkHoyFooter = document.getElementById('check_hoy_footer');
    var fechaInicioElement = document.getElementById('fecha_inicio');
    var fechaFinElement = document.getElementById('fecha_fin');
    var fechaInicioFooter = document.getElementById('fecha_inicio_footer');
    var fechaFinFooter = document.getElementById('fecha_fin_footer');
    
    if(checkHoyElement) {
        checkHoyElement.addEventListener('change', function() {
            if(this.checked) {
                var hoy = new Date().toISOString().split('T')[0];
                if(fechaInicioElement) fechaInicioElement.value = hoy;
                if(fechaFinElement) fechaFinElement.value = hoy;
                if(fechaInicioElement) fechaInicioElement.disabled = true;
                if(fechaFinElement) fechaFinElement.disabled = true;
                if(checkHoyFooter) {
                    checkHoyFooter.checked = true;
                    if(fechaInicioFooter) fechaInicioFooter.value = hoy;
                    if(fechaFinFooter) fechaFinFooter.value = hoy;
                    if(fechaInicioFooter) fechaInicioFooter.disabled = true;
                    if(fechaFinFooter) fechaFinFooter.disabled = true;
                }
            } else {
                if(fechaInicioElement) fechaInicioElement.disabled = false;
                if(fechaFinElement) fechaFinElement.disabled = false;
                if(checkHoyFooter) {
                    checkHoyFooter.checked = false;
                    if(fechaInicioFooter) fechaInicioFooter.disabled = false;
                    if(fechaFinFooter) fechaFinFooter.disabled = false;
                }
            }
            sincronizarFiltros();
        });
    }
    
    if(checkHoyFooter) {
        checkHoyFooter.addEventListener('change', function() {
            if(this.checked) {
                var hoy = new Date().toISOString().split('T')[0];
                if(fechaInicioFooter) fechaInicioFooter.value = hoy;
                if(fechaFinFooter) fechaFinFooter.value = hoy;
                if(fechaInicioFooter) fechaInicioFooter.disabled = true;
                if(fechaFinFooter) fechaFinFooter.disabled = true;
                if(checkHoyElement) {
                    checkHoyElement.checked = true;
                    if(fechaInicioElement) fechaInicioElement.value = hoy;
                    if(fechaFinElement) fechaFinElement.value = hoy;
                    if(fechaInicioElement) fechaInicioElement.disabled = true;
                    if(fechaFinElement) fechaFinElement.disabled = true;
                }
            } else {
                if(fechaInicioFooter) fechaInicioFooter.disabled = false;
                if(fechaFinFooter) fechaFinFooter.disabled = false;
                if(checkHoyElement) {
                    checkHoyElement.checked = false;
                    if(fechaInicioElement) fechaInicioElement.disabled = false;
                    if(fechaFinElement) fechaFinElement.disabled = false;
                }
            }
            sincronizarFiltros();
        });
    }
    
    if(fechaInicioElement && fechaInicioFooter) {
        fechaInicioElement.addEventListener('change', function() { fechaInicioFooter.value = this.value; });
        fechaInicioFooter.addEventListener('change', function() { if(fechaInicioElement) fechaInicioElement.value = this.value; });
    }
    
    if(fechaFinElement && fechaFinFooter) {
        fechaFinElement.addEventListener('change', function() { fechaFinFooter.value = this.value; });
        fechaFinFooter.addEventListener('change', function() { if(fechaFinElement) fechaFinElement.value = this.value; });
    }
    
    if(checkHoyElement && checkHoyElement.checked) {
        if(fechaInicioElement) fechaInicioElement.disabled = true;
        if(fechaFinElement) fechaFinElement.disabled = true;
        if(fechaInicioFooter) fechaInicioFooter.disabled = true;
        if(fechaFinFooter) fechaFinFooter.disabled = true;
    }
    sincronizarFiltros();

    <?php if($generar_pdf): ?>
    window.onload = function() {
        document.querySelectorAll('.header, .btn-canceladas, .btn-filtrar, .btn-pdf, .filter-footer, .footer-info, .modal').forEach(el => {
            if(el) el.style.display = 'none';
        });
        
        document.querySelectorAll('.section').forEach((section, index) => {
            if(section.id !== 'seccion-pagos' && section.id !== 'seccion-departamentos-pdf') {
                section.style.display = 'none';
            } else {
                section.style.display = 'block';
            }
        });
        
        var tablaPagos = document.getElementById('tabla-pagos');
        if(tablaPagos) {
            var thead = tablaPagos.querySelector('thead tr');
            var thFirma = document.createElement('th');
            thFirma.textContent = 'FIRMA DE ENTERADO';
            thFirma.classList.add('text-center');
            thead.appendChild(thFirma);
            
            var tbody = tablaPagos.querySelector('tbody');
            if(tbody) {
                var filas = tbody.querySelectorAll('tr');
                filas.forEach(fila => {
                    var tdFirma = document.createElement('td');
                    tdFirma.classList.add('text-center');
                    tdFirma.innerHTML = '&nbsp;';
                    fila.appendChild(tdFirma);
                });
            }
            
            var tfoot = tablaPagos.querySelector('tfoot tr');
            if(tfoot) {
                var tdFirmaFooter = document.createElement('td');
                tdFirmaFooter.innerHTML = '&nbsp;';
                tdFirmaFooter.classList.add('text-center');
                tfoot.appendChild(tdFirmaFooter);
            }
        }
        
        var elementosViejos = document.querySelectorAll('.declaraciones, .timestamp');
        elementosViejos.forEach(el => el.remove());
        
        var container = document.querySelector('.container');
        var headerPDF = document.createElement('div');
        headerPDF.className = 'pdf-header';
        headerPDF.innerHTML = `
            <h1 style="margin: 0 0 5px 0; font-size: 18px;">REPORTE DE PAGOS POR DEPARTAMENTO</h1>
            <p style="margin: 0; font-size: 12px;">Período: ${new Date('<?php echo $fecha_inicio; ?>').toLocaleDateString('es-ES')} — ${new Date('<?php echo $fecha_fin; ?>').toLocaleDateString('es-ES')}</p>
        `;
        container.insertBefore(headerPDF, document.querySelector('#seccion-pagos'));
        
        var seccionPagos = document.querySelector('#seccion-departamentos-pdf');
        if(!seccionPagos) seccionPagos = document.querySelector('#seccion-pagos');
        
        var footerPDF = document.createElement('div');
        footerPDF.className = 'pdf-footer';
        footerPDF.innerHTML = `
            <div class="declaraciones">
                <p><strong>DECLARACIONES</strong></p>
            </div>
            <br />
            <br />
            <br />
            
        `;
        if(seccionPagos) seccionPagos.appendChild(footerPDF);
        
        window.print();
    };
    <?php endif; ?>
</script>
</body>
</html>