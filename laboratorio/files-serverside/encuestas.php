<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
header('Content-Type: application/json; charset=utf-8');
//reciimos variables por get
$noStudy = sqlValue($_GET["noStudy"], "int");
$enlacePdf = sqlValue($_GET["enlacePdf"], "text");
//Datos para el Json
$jUserExist = 1;
$jUserName = "No Data";
$operationResponse = 0;
$jEncuestaResponse = 0;

mysql_select_db($database_horizonte, $horizonte);
// $buscarId = mysql_query("SELECT COUNT(id_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
$buscarId = mysql_query("SELECT COUNT(p.id_p), CONCAT_WS(' ', p.nombre_p, p.apaterno_p, p.amaterno_p), p.id_p FROM venta_conceptos vc
    LEFT JOIN pacientes p ON p.id_p = vc.id_paciente_vc
    WHERE vc.id_vc = " . $noStudy, $horizonte) or die (mysql_error());
$id = mysql_fetch_row($buscarId);

if($id[0] > 0){
    //Obtenemos nombre de paciente
    $jUserName = $id[1];
    //Buscamos si existe encuesta
    mysql_select_db($database_horizonte, $horizonte);
    $buscarIdVentaConcepto = mysql_query("SELECT COUNT(*) FROM venta_conceptos vc
        LEFT JOIN conceptos c ON c.id_to = vc.id_concepto_es
        WHERE c.concepto_to LIKE 'CUESTIONARIO%' AND vc.id_vc = " . $noStudy, $horizonte) or die (mysql_error());
    $idVentaConcepto = mysql_fetch_row($buscarIdVentaConcepto);
    $jEncuestaAtSystem = $idVentaConcepto[0];
    //Si el usuario y la encuesta existen insertamos los datos.
    if($jEncuestaAtSystem[0] > 0){
        $jEncuestaResponse = 1;
        //insertamos el enlace del pdf en un campo exixtente(para no crear mas campos)
        mysql_select_db($database_horizonte, $horizonte);
        $modificarEnlacePdf = "UPDATE venta_conceptos SET nota_radiologo_vc = $enlacePdf, estatus_vc = 8 WHERE id_vc = ". $noStudy ." LIMIT 1"; 
        $ejecutarModEnlace = mysql_query($modificarEnlacePdf, $horizonte) or die (mysql_error());
        //agregamos respuesta si se ejecuta la consulta
        if($ejecutarModEnlace){
            $operationResponse = 1;
        }
    }
}else{
    $jUserExist = 0;
    $idPaciente = 0;
}

$array = array(
    "paciente" => array(
        array("nombre" => $jUserName, "id" => $id[2], "noStudy" => $noStudy)
    ),
    "respuesta" => array(
        array("userExist" => $jUserExist, "encuestaAtSystem" => $jEncuestaResponse, "operationSuccess" => $operationResponse)
    )
);


echo json_encode($array, JSON_UNESCAPED_UNICODE);

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>