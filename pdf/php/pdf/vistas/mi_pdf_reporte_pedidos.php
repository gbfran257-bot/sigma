<?php

$pedidos = unserialize(base64_decode($_GET['p']));

require("../../../Connections/horizonte2.php");

$id_usuario = intval($_GET['idu']);

$query_usuario = "SELECT usuario_u FROM usuarios WHERE id_u = {$id_usuario}";

$resultado_quer_usuario = mysqli_query($horizonte, $query_usuario);

$usuario = strtoupper(mysqli_fetch_object($resultado_quer_usuario)->usuario_u);

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
        margin: 0px;
        padding: 0px;
    }

    #resumen th {
        background-color: #4472c4;
        color: #FFFFFF;
        font-weight: bold;
        border-top: solid #4472c4;
        border-left: solid #FFFFFF;
        border-right: solid #FFFFFF;
        border-bottom: solid #FFFFFF;
    }

    #numeral {
        border-left: solid #4472c4;
    }

    #surtir {
        border-right: solid #4472c4;
    }

    #resumen td {
        border: solid #ffffff;
    }

    .first-even {
        border-left: solid #cfd5ea;
    }

    .last-even {
        border-right: solid #cfd5ea;
    }

    .first-odd {
        border-left: solid #e9ebf5;
    }

    .last-odd {
        border-right: solid #e9ebf5;
    }

    .even {
        background-color: #cfd5ea;
    }

    .odd {
        background-color: #e9ebf5;
    }

    .even,
    .odd {
        color: #6c6c6c;
    }

    .last-row-even {
        border-bottom: solid #cfd5ea;
    }

    .last-row-odd {
        border-bottom: solid #e9ebf5;
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
                <td id="fecha_impresion">FECHA DE IMPRESIÓN: <?php echo $_GET['fi']; ?></td>
            </tr>
        </table>
    </page_footer>

    <table id="contenido">
        <tr>
            <td colspan="5" align="center" style="width: 100%; padding-bottom: 20px;">
                <h3>REPORTE DE PEDIDO</h3>
            </td>
        </tr>
        <tr>
            <td style="padding-bottom: 10px;" align="left">SUCURSAL: <?php echo $_GET['s']; ?></td>
        </tr>
        <tr>
            <td style="padding-bottom: 10px;" align="left">IMPRIMIÓ: <?php echo $usuario; ?></td>
            <td style="padding-bottom: 10px;" align="left">FECHA DE IMPRESIÓN: <?php echo $_GET['fi']; ?></td>
        </tr>
        <tr>
            <td colspan="5" style="padding-top: 10px;">
                <table id="resumen" style="width: 100%; border-spacing: 0px;">
                    <tr>
                        <th id="numeral" style="padding: 10px;"><strong>#</strong></th>
                        <th style="padding: 10px;"><strong>PRODUCTO</strong></th>
                        <th style="padding: 10px;"><strong>NOMBRE GENÉRICO</strong></th>
                        <th style="padding: 10px;"><strong>EXISTENCIA</strong></th>
                        <th style="padding: 10px;"><strong>MÁXIMO</strong></th>
                        <th style="padding: 10px;"><strong>MÍNIMO</strong></th>
                        <th id="surtir" style="padding: 10px;"><strong>SURTIR</strong></th>
                    </tr>

                    <?php $even_odd_identifier = 1; ?>
                    <?php $row_identifier = 0; ?>
                    <?php for ($i = 0; $i < count($pedidos); $i++) : ?>
                        <?php $row_class = $even_odd_identifier++ % 2 == 0 ? "odd" : "even"; ?>
                        <?php if ($row_identifier < count($pedidos) - 1) : ?>
                            <?php $first_column_class = "first-" . $row_class; ?>
                            <?php $last_column_class = "last-" . $row_class; ?>
                            <?php $column_class = ""; ?>
                        <?php elseif ($row_identifier == count($pedidos) - 1) : ?>
                            <?php $first_column_class = "first-" . $row_class . " " . "last-row-" . $row_class; ?>
                            <?php $last_column_class = "last-" . $row_class . " " . "last-row-" . $row_class; ?>
                            <?php $column_class = "last-row-" . $row_class; ?>
                        <?php endif; ?>
                        <?php $row_identifier++; ?>
                        <tr class="<?php echo $row_class; ?>" style="vertical-align: middle;">
                            <td class="<?php echo $first_column_class; ?>" style="width: 92px; vertical-align: middle;"><?php echo $pedidos[$i][0]; ?></td>
                            <td class="<?php echo $column_class; ?>" style="width: 92px; vertical-align: middle;"><?php echo $pedidos[$i][1]; ?></td>
                            <td class="<?php echo $column_class; ?>" style="width: 92px; vertical-align: middle;"><?php echo $pedidos[$i][2]; ?></td>
                            <td class="<?php echo $column_class; ?>" style="width: 92px; vertical-align: middle;"><?php echo $pedidos[$i][3]; ?></td>
                            <td class="<?php echo $column_class; ?>" style="width: 92px; vertical-align: middle;"><?php echo $pedidos[$i][4]; ?></td>
                            <td class="<?php echo $column_class; ?>" style="width: 92px; vertical-align: middle;"><?php echo $pedidos[$i][5]; ?></td>
                            <td class="<?php echo $last_column_class; ?>" style="width: 92px; vertical-align: middle;"><?php echo $pedidos[$i][6]; ?></td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </td>
        </tr>
    </table>
</page>