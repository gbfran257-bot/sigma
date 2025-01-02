<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idPaciente = sqlValue($_GET["idPaciente"], "int");

$jUserExist = 1;
$jUserName = "No Data";

mysql_select_db($database_horizonte, $horizonte);
$buscarId = mysql_query("SELECT COUNT(id_p) FROM pacientes WHERE id_p = " . $idPaciente, $horizonte) or die (mysql_error());
$id = mysql_fetch_row($buscarId);

if($id[0] > 0){

}else{
    $jUserExist = 0;
}

$array = array(
    "paciente" => array(
        array("nombre" => $jUserName, "id" => "id", "idEncuesta" => "idEncuesta")
    ),
    "respuesta" => array(
        array("userExist" => $jUserExist, "operationSuccess" => "operationSuccess")
    )
);


echo json_encode($array);

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>