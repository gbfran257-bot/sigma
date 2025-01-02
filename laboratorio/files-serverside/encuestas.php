<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
header('Content-Type: application/json; charset=utf-8');
//reciimos variables por get
$idPaciente = sqlValue($_GET["idPaciente"], "int");
$idEncuesta = sqlValue($_GET["idEncuesta"], "int");
$enlacePdf = sqlValue($_GET["enlacePdf"], "text");
$cuestionario = sqlValue("CUESTIONARIO" . $_GET['idEncuesta'] . "_%", "text");
//Datos para el Json
$jUserExist = 1;
$jUserName = "No Data";
$operationResponse = 0;
$jEncuestaResponse = 0;

mysql_select_db($database_horizonte, $horizonte);
$buscarId = mysql_query("SELECT COUNT(id_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
$id = mysql_fetch_row($buscarId);

if($id[0] > 0){
    //Obtenemos nombre de paciente
    mysql_select_db($database_horizonte, $horizonte);
    $buscarNombre = mysql_query("SELECT CONCAT_WS(' ', nombre_p, apaterno_p, amaterno_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
    $nombre = mysql_fetch_row($buscarNombre);
    $jUserName = $nombre[0];
    //Buscamos si existe encuesta
    mysql_select_db($database_horizonte, $horizonte);
    $buscarIdVentaConcepto = mysql_query("SELECT COUNT(vc.id_vc) FROM conceptos c LEFT JOIN venta_conceptos vc ON vc.id_concepto_es = c.id_to WHERE c.concepto_to LIKE $cuestionario AND vc.id_paciente_vc = " . $idPaciente, $horizonte) or die (mysql_error());
    $idVentaConcepto = mysql_fetch_row($buscarIdVentaConcepto);
    $jEncuestaAtSystem = $idVentaConcepto[0];
    //Si el usuario y la encuesta existen insertamos los datos.
    if($jEncuestaAtSystem[0] > 0){
        $jEncuestaResponse = 1;
        //buscamos el ultimo id registrado de la encuesta y el paciente
        mysql_select_db($database_horizonte, $horizonte);
        $buscarUltId = mysql_query("SELECT vc.id_vc FROM conceptos c LEFT JOIN venta_conceptos vc ON vc.id_concepto_es = c.id_to WHERE c.concepto_to LIKE $cuestionario AND vc.id_paciente_vc = $idPaciente ORDER BY id_vc DESC LIMIT 1", $horizonte) or die (mysql_error());
        $ultId = mysql_fetch_row($buscarUltId);
        //insertamos el enlace del pdf en un campo exixtente(para no crear mas campos)
        mysql_select_db($database_horizonte, $horizonte);
        $modificarEnlacePdf = "UPDATE venta_conceptos SET nota_radiologo_vc = $enlacePdf WHERE id_vc = ". $ultId[0] ." LIMIT 1"; 
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
        array("nombre" => $jUserName, "id" => $idPaciente, "idEncuesta" => $idEncuesta)
    ),
    "respuesta" => array(
        array("userExist" => $jUserExist, "encuestaAtSystem" => $jEncuestaResponse, "operationSuccess" => $operationResponse)
    )
);


echo json_encode($array, JSON_UNESCAPED_UNICODE);

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>