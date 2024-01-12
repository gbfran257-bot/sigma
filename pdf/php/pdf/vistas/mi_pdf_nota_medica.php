<?php

// Obtenemos la interpretacion de la nota médica
$id_consulta = intval(htmlspecialchars($_GET['id_c']));
$query_interpretacion = "SELECT nota_interpretacion FROM venta_conceptos WHERE id_vc = $id_consulta";
if (!$resultado_interpretacion = mysqli_query($horizonte, $query_interpretacion)) {
    die(mysqli_error($horizonte));
}
$interpretacion = $resultado_interpretacion->fetch_object()->nota_interpretacion;

// Obtenemos los márgenes para el pdf
$query_margenes = "SELECT margen_e_cm, margen_p_cm FROM sucursales WHERE id_su = $id_sucursal";
if (!$resultado_margenes = mysqli_query($horizonte, $query_margenes)) {
    die(mysqli_error($horizonte));
}
$margenes = $resultado_margenes->fetch_object();
$margen_e = $margenes->margen_e_cm;
$margen_p = $margenes->margen_p_cm;

$header_footer_width = $print_size == "Letter" ? LETTER_SIZE_HEADER_FOOTER_WIDTH : HALF_LETTER_SIZE_HEADER_FOOTER_WIDTH;
?>

<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
    <!--
    #p_header,
    #p_footer {
        border: 0px none;
    }

    table {
        width: 100%;
    }

    p {
        margin: 2px 0px;
        padding: 0px;
        text-align: justify !important;
    }
    -->
</style>

<!-- page define la hoja con los márgenes señalados -->
<!-- <page backtop="3mm" backbottom="3mm" backleft="3mm" backright="3mm"> -->
<page backtop="<?php echo $margen_e * 8; ?>mm" backbottom="<?php echo $margen_p * 8; ?>mm" backleft="3mm" backright="3mm">
    <page_header> <!-- Define el header de la hoja -->
        <table id="p_header">
            <tr>
                <td>
                    <img src="<?php echo $_GET['encL']; ?>" width="<?php echo $header_footer_width; ?>" height="<?php echo HEADER_FOOTER_HEIGHT; ?>" />
                </td>
            </tr>
        </table>
    </page_header>

    <page_footer> <!-- Define el footer de la hoja -->
        <table id="p_footer">
            <tr>
                <td>
                    <img src="<?php echo $_GET['pieL']; ?>" width="<?php echo $header_footer_width; ?>" height="<?php echo HEADER_FOOTER_HEIGHT; ?>" />
                </td>
            </tr>
        </table>
    </page_footer>
    <!-- Define el cuerpo de la hoja -->
    <?php echo $interpretacion; ?>
    <!-- Fin del cuerpo de la hoja -->
</page>