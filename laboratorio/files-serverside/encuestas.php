<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");
//reciimos variables por get
$idPaciente = sqlValue($_GET["idPaciente"], "int");
$idEncuesta = sqlValue($_GET["idEncuesta"], "int");
//Datos para el Json
$jUserExist = 1;
$jUserName = "No Data";

mysql_select_db($database_horizonte, $horizonte);
$buscarId = mysql_query("SELECT COUNT(id_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
$id = mysql_fetch_row($buscarId);

if($id[0] > 0){
    //Obtenemos nombre de paciente
    mysql_select_db($database_horizonte, $horizonte);
    $buscarNombre = mysql_query("SELECT CONCAT_WS(' ', nombre_p, amaterno_p, apaterno_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
    $nombre = mysql_fetch_row($buscarNombre);
    $jUserName = $nombre[0];
    //Buscamos el id de la encuesta
}else{
    $jUserExist = 0;
    $idPaciente = 0;
}

$array = array(
    "paciente" => array(
        array("nombre" => $jUserName, "id" => $idPaciente, "idEncuesta" => $idEncuesta)
    ),
    "respuesta" => array(
        array("userExist" => $jUserExist, "operationSuccess" => "operationSuccess")
    )
);


echo json_encode($array);

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>