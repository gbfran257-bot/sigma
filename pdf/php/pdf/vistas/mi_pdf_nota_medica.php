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

?>

<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
    <!--
    #p_header {
        padding: 10px 0;
        border-top: 0px none;
        border-bottom: 0px none;
        width: 100%;
    }

    #p_header .fila #col_1 {
        width: 100%
    }

    #p_footer {
        padding-top: 5px 0;
        border-top: 2px none #46d;
        width: 100%;
    }

    #p_footer .fila td {
        text-align: center;
        width: 100%;
    }

    #p_footer .fila td span {
        font-size: 10px;
        color: #000;
    }

    #p_contenido {
        margin-top: 0px;
        width: 100% !important;
    }

    #p_contenido tr td {
        padding-top: 0px;
        text-align: justify;
        width: ;
    }

    #p_contenido1 {
        margin-top: 0px;
        width: 10cm;
        bottom: 0px;
    }

    #p_contenido1 tr td {
        padding-top: 0px;
        text-align: justify;
        width: ;
    }

    #p_contenido2 {
        margin-top: 0px;
        width: 100%;
    }

    #p_contenido2 tr td {
        padding-top: 0px;
        text-align: justify;
        width: ;
    }

    #tabla1 .fila4 #col_14 {
        width: 100%;
        border: 1px solid red;
    }

    #firmaDR img {
        display: none;
    }
    -->
</style>

<!-- page define la hoja con los márgenes señalados -->
<!-- <page backtop="3mm" backbottom="3mm" backleft="3mm" backright="3mm"> -->
<page backtop="<?php echo $margen_e * 15; ?>mm" backbottom="<?php echo $margen_p * 15; ?>mm" backleft="3mm" backright="3mm">
    <page_header> <!-- Define el header de la hoja -->
        <table id="p_header">
            <tr class="fila">
                <td id="col_1"><?php echo $_GET["encL"]; ?></td>
            </tr>
        </table>
    </page_header>

    <page_footer> <!-- Define el footer de la hoja -->
        <table id="p_footer">
            <tr class="fila">
                <td id="col_2"><?php echo $_GET["pieL"]; ?></td>
            </tr>
        </table>
    </page_footer>
    <!-- Define el cuerpo de la hoja -->
    <?php echo $interpretacion; ?>
    <!-- Fin del cuerpo de la hoja -->
</page>