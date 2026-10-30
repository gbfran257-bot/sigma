<?php

require_once("../../../Connections/horizonte2.php");

$tipos_notas = [
    "NOTA" => "nota",
    "RECETA" => "receta",
    "LABORATORIO" => "laboratorio",
    "IMAGEN" => "imagen",
    "ENDOSCOPIA" => "endoscopia",
    "ULTRASONIDO" => "ultrasonido",
    "COLPOSCOPIA" => "colposcopia",
    "SERVICIOS" => "servicios"
];

// Obtenemos los márgenes para el pdf
$id_sucursal = intval(htmlspecialchars($_GET['id_s']));
$tipo_membrete = htmlspecialchars($_GET['tipo_membrete']);

// Dependiendo del tipo de membrete se consulta el margen adecuado
if ($tipo_membrete == $tipos_notas['NOTA']) {
    $query_margenes = "SELECT margen_e_cm, margen_p_cm FROM sucursales WHERE id_su = $id_sucursal";
} elseif ($tipo_membrete == $tipos_notas['RECETA']) {
    $query_margenes = "SELECT margen_e_rm, margen_p_rm FROM sucursales WHERE id_su = $id_sucursal";
} elseif ($tipo_membrete == $tipos_notas['LABORATORIO']) {
    $query_margenes = "SELECT margen_e_la, margen_p_la FROM sucursales WHERE id_su = $id_sucursal";
} elseif ($tipo_membrete == $tipos_notas['IMAGEN']) {
    $query_margenes = "SELECT margen_e_im, margen_p_im FROM sucursales WHERE id_su = $id_sucursal";
} elseif ($tipo_membrete == $tipos_notas['ENDOSCOPIA']) {
    $query_margenes = "SELECT margen_e_en, margen_p_en FROM sucursales WHERE id_su = $id_sucursal";
} elseif ($tipo_membrete == $tipos_notas['ULTRASONIDO']) {
    $query_margenes = "SELECT margen_e_ul, margen_p_ul FROM sucursales WHERE id_su = $id_sucursal";
} elseif ($tipo_membrete == $tipos_notas['COLPOSCOPIA']) {
    $query_margenes = "SELECT margen_e_co, margen_p_co FROM sucursales WHERE id_su = $id_sucursal";
} elseif ($tipo_membrete == $tipos_notas['SERVICIOS']) {
    $query_margenes = "SELECT margen_e_sm, margen_p_sm FROM sucursales WHERE id_su = $id_sucursal";
}

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
    <div></div>
    <!-- Fin del cuerpo de la hoja -->
</page>