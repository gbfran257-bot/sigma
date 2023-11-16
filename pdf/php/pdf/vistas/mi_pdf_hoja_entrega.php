<?php

$productos_seleccionados = unserialize(base64_decode($_GET['ps']));

$id_usuario = $_GET['idu'];

require("../../../Connections/horizonte2.php");

$query_usuario = "SELECT usuario_u FROM usuarios WHERE id_u = {$id_usuario}";

$resultado_query_usuario = mysqli_query($horizonte, $query_usuario);

$usuario = mysqli_fetch_object($resultado_query_usuario)->usuario_u;

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
    }

    #resumen th {
        color: #40698e;
        font-weight: bold;
    }
    -->
</style>

<!-- <page backtop="3mm" backbottom="3mm" backleft="3mm" backright="3mm"> -->
<page>
    <page_header></page_header>

    <table id="contenido">
        <tr>
            <td colspan="5" align="center" style="width: 100%; padding-bottom: 20px;">
                <h3>REPORTE DE LA ENTREGA DE LA TRANSFERENCIA</h3>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 10px;" id="folio_transferencia">FOLIO DE TRANSFERENCIA: <?php echo $_GET['ft']; ?></td>
            <td style="padding-bottom: 10px;" id="fecha_movimiento">FECHA DE MOVIMIENTO: <?php echo $usuario . " " . $_GET['fm']; ?></td>
        </tr>
        <tr>
            <td style="padding-bottom: 10px;" id="folio_transferencia">SUCURSAL ORIGEN: <?php echo $_GET['so']; ?></td>
            <td id="fecha_movimiento">SUCURSAL DESTINO: <?php echo $_GET['sd']; ?></td>
        </tr>
        <tr>
            <td colspan="5" style="padding-top: 30px;">
                <table id="resumen" style="width: 100%; border-spacing: 0px;">
                    <tr>
                        <th style="padding: 5px;"><strong>#</strong></th>
                        <th style="padding: 5px;"><strong>PRODUCTO</strong></th>
                        <th style="padding: 5px;"><strong>NOMBRE GENÉRICO</strong></th>
                        <th style="padding: 5px;"><strong>LOTE</strong></th>
                        <th style="padding: 5px;"><strong>CANTIDAD A TRANSFERIR</strong></th>
                    </tr>
                    <?php $cont = 0; ?>
                    <?php foreach ($productos_seleccionados as $producto_seleccionado) : ?>
                        <tr>
                            <td style="width: 140px;"><?php echo ++$cont; ?></td>
                            <td style="width: 140px;"><?php echo $producto_seleccionado->producto; ?></td>
                            <td style="width: 140px;"><?php echo $producto_seleccionado->nombre_generico; ?></td>
                            <td style="width: 140px;"><?php echo $producto_seleccionado->lote; ?></td>
                            <td style="width: 140px;"><?php echo $producto_seleccionado->cantidad_transferir; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="width: 250px; padding-top: 100px;">USUARIO EMISOR: <?php echo $usuario . " " . $_GET['fm']; ?></td>
            <td align="center" style="width: 250px; padding-top: 100px;">USUARIO RECEPTOR: </td>
        </tr>
        <tr>
            <td align="center" style="width: 250px; padding-top: 30px;">_________________________</td>
            <td align="center" style="width: 250px; padding-top: 30px;">_________________________</td>
        </tr>
    </table>

    <page_footer>
        <table id="footer">
            <tr>
                <td id="numero_pagina" align="right">PÁGINA X / X</td>
                <td id="fecha_impresion">FECHA DE IMPRESIÓN: <?php echo $usuario . " " . $_GET['fm']; ?></td>
            </tr>
        </table>
    </page_footer>
</page>