<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
header('Content-Type: application/json; charset=utf-8');
//reciimos variables por get
$idOrden = sqlValue($_GET["idOrden"], "int");
//Datos para el Json
$numEstudios = 0;
$jUserName = "No Data";

mysql_select_db($database_horizonte, $horizonte);
$contarEstudios = mysql_query("SELECT CONCAT_WS(' ', p.nombre_p, p.apaterno_p, p.amaterno_p), count(c.id_to)  FROM orden_venta ov
    LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov
    LEFT JOIN venta_conceptos vc ON vc.no_temp_vc = ov.no_temp_ov
    LEFT JOIN conceptos c ON c.id_to = vc.id_concepto_es
    WHERE ov.id_ov = $idOrden AND c.concepto_to LIKE 'CUESTIONARIO%'", $horizonte) or die (mysql_error());
$contador = mysql_fetch_row($contarEstudios);

if($contador[1] > 0){
    /* mysql_select_db($database_horizonte, $horizonte);
    $buscarNombre = mysql_query("SELECT CONCAT_WS(' ', nombre_p, apaterno_p, amaterno_p) FROM pacientes WHERE id_p = " . $idOrden, $horizonte) or die (mysql_error());
    $nombre = mysql_fetch_row($buscarNombre);
    $jUserName = $nombre[0]; */

    //obtenemos los datos de los cuestionarios
    mysql_select_db($database_horizonte, $horizonte);
$obtenerEstudios = mysql_query("SELECT c.concepto_to, vc.id_vc  FROM orden_venta ov
    LEFT JOIN pacientes p ON p.id_p = ov.id_paciente_ov
    LEFT JOIN venta_conceptos vc ON vc.no_temp_vc = ov.no_temp_ov
    LEFT JOIN conceptos c ON c.id_to = vc.id_concepto_es
    WHERE ov.id_ov = $idOrden AND c.concepto_to LIKE 'CUESTIONARIO%'", $horizonte) or die (mysql_error());

    while($fila = mysql_fetch_row($obtenerEstudios)){
        $numEstudio = substr($fila[0],12,1);
        $estudios[] = array(
            "idExam" => $numEstudio,
            "noStudy" => $fila[1]
        );
    }
}

$array = array(
    "paciente" => array(
        array("nombre" => $contador[0], "numEstudios" => $contador[1])
    ),
    "study" => $estudios
);


echo json_encode($array, JSON_UNESCAPED_UNICODE);

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>