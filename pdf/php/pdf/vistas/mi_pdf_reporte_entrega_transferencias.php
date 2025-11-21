<?php

date_default_timezone_set("America/Mexico_City");

$folio = $_GET['f'];
$receptor = $_GET['r'];
$fecha_movimiento_impresion = date("Y-m-d H:i:s");
$emisor_fecha_hora = $_GET['e'];
$id_usuario = $_GET['idu'];

require("../../../Connections/horizonte2.php");

$query_usuario = "SELECT usuario_u FROM usuarios WHERE id_u = {$id_usuario}";
$resultado_query_usuario = mysqli_query($horizonte, $query_usuario);
$usuario = mysqli_fetch_object($resultado_query_usuario)->usuario_u;

$query_transferencias = "SELECT producto, nombre_generico, lote, cantidad_transferir, id_sucursal_origen, id_sucursal_destino FROM transferencia_temporal WHERE id_transferencia = \"{$folio}\"";
$resultado_query_transferencias = mysqli_query($horizonte, $query_transferencias);
$transferencias = mysqli_fetch_all($resultado_query_transferencias, MYSQLI_ASSOC);

$query_sucursal_origen = "SELECT nombre_su FROM sucursales WHERE id_su = {$transferencias[0]['id_sucursal_origen']}";
$resultado_query_sucursal_origen = mysqli_query($horizonte, $query_sucursal_origen);
$sucursal_origen = mysqli_fetch_object($resultado_query_sucursal_origen)->nombre_su;

$query_sucursal_destino = "SELECT nombre_su FROM sucursales WHERE id_su = {$transferencias[0]['id_sucursal_destino']}";
$resultado_query_sucursal_destino = mysqli_query($horizonte, $query_sucursal_destino);
$sucursal_destino = mysqli_fetch_object($resultado_query_sucursal_destino)->nombre_su;

$query_fecha_hora_recepcion = "SELECT fecha_recepcion FROM transferencia_temporal WHERE id_transferencia = \"{$folio}\" LIMIT 1";
$resultado_query_fecha_hora_recepcion = mysqli_query($horizonte, $query_fecha_hora_recepcion);
$fecha_hora_recepcion = mysqli_fetch_object($resultado_query_fecha_hora_recepcion)->fecha_recepcion;

mysqli_close($horizonte);

?>

<style>
    <!--
    #contenido,
    #footer {
        text-align: center;
        width: 100%;
    }

    #footer {
        color: #9A9A9A;
    }

    #footer #numero_pagina {
        width: 350px;
    }

    #footer #fecha_impresion {
        width: 350px;
    }

    #resumen {
        border-spacing: 0px;
        border-collapse: collapse;
    }

    #resumen,
    #resumen th,
    #resumen td {
        border: solid #40698e;
        margin: 0px;
        padding: 0px;
        font-size: 10px;
    }

    #resumen th {
        color: #40698e;
        font-weight: bold;
    }
    -->
</style>

<!-- <page backtop="3mm" backbottom="3mm" backleft="3mm" backright="3mm"> -->
<page backtop="3mm" backbottom="3mm" backleft="3mm" backright="3mm">
    <page_header></page_header> <!-- Define el header de la hoja -->

    <page_footer> <!-- Define el footer de la hoja -->
        <table id="footer">
            <tr>
                <td id="numero_pagina" align="right">PÁGINA [[page_cu]] / [[page_nb]] </td>
                <td id="fecha_impresion">FECHA DE IMPRESIÓN: <?php echo $fecha_movimiento_impresion; ?></td>
            </tr>
        </table>
    </page_footer>

    <table id="contenido">
        <tr>
            <td colspan="5" align="center" style="width: 100%; padding-bottom: 20px;">
                <h3>REPORTE DE ENTREGA DE LA TRANSFERENCIA</h3>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 10px;" id="folio_transferencia">REFERENCIA DE TRANSFERENCIA: <?php echo $folio; ?></td>
            <td style="padding-bottom: 10px;" id="fecha_movimiento">FECHA DE MOVIMIENTO: <?php echo $fecha_movimiento_impresion; ?></td>
        </tr>
        <tr>
            <td style="padding-bottom: 10px;" id="folio_transferencia">SUCURSAL ORIGEN: <?php echo $sucursal_origen; ?></td>
            <td id="fecha_movimiento">SUCURSAL DESTINO: <?php echo $sucursal_destino ?></td>
        </tr>
        <tr>
            <td colspan="5" style="padding-top: 30px;">
                <table id="resumen" style="width: 100%; border-spacing: 0px;">
                    <tr>
                        <th style="padding: 5px;"><strong>#</strong></th>
                        <th style="padding: 5px;"><strong>PRODUCTO</strong></th>
                        <th style="padding: 5px;"><strong>NOMBRE GENERICO</strong></th>
                        <th style="padding: 5px;"><strong>LOTE</strong></th>
                        <th style="padding: 5px;"><strong>CANT. A TRANSF.</strong></th>
                    </tr>
                    <?php $cont = 0; ?>
                    <?php foreach ($transferencias as $transferencia) : ?>
                        <tr>
                            <td style="width: 35px;"><?php echo ++$cont; ?></td>
                            <td style="width: 230px;"><?php echo substr($transferencia['producto'], 0, 40); ?></td>
                            <td style="width: 215px;"><?php echo substr($transferencia['nombre_generico'], 0, 40); ?></td>
                            <td style="width: 140px;"><?php echo $transferencia['lote']; ?></td>
                            <td style="width: 100px;"><?php echo $transferencia['cantidad_transferir']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="width: 250px; padding-top: 100px;">USUARIO EMISOR: <?php echo $emisor_fecha_hora; ?></td>
            <td align="center" style="width: 250px; padding-top: 100px;">USUARIO RECEPTOR: <?php echo $receptor . " " . $fecha_hora_recepcion; ?></td>
        </tr>
        <tr>
            <td align="center" style="width: 250px; padding-top: 30px;">_________________________</td>
            <td align="center" style="width: 250px; padding-top: 30px;">_________________________</td>
        </tr>
    </table>
</page>