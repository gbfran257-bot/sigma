<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
header('Content-Type: application/json; charset=utf-8');
//reciimos variables por get
$idPaciente = sqlValue($_GET["idPaciente"], "int");
//Datos para el Json
$pacienteExist = 0;
$jUserName = "No Data";

mysql_select_db($database_horizonte, $horizonte);
$buscarId = mysql_query("SELECT COUNT(id_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
$id = mysql_fetch_row($buscarId);

if($id[0] > 0){
    //Obtenemos nombre de paciente
    mysql_select_db($database_horizonte, $horizonte);
    $buscarNombre = mysql_query("SELECT CONCAT_WS(' ', nombre_p, apaterno_p, amaterno_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
    $nombre = mysql_fetch_row($buscarNombre);
    $jUserName = $nombre[0];
    //Cambiamos valor de variables
    $pacienteExist = 1;
}

$array = array(
    "paciente" => array(
        array("nombre" => $jUserName, "pacienteExist" => $pacienteExist)
    )
);


echo json_encode($array, JSON_UNESCAPED_UNICODE);

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>