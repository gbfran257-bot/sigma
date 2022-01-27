<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$archivo = $_FILES["archivo"];
$file_name = explode(".", $_FILES['archivo']['name']);
$allowed_extension = array("jpg", "jpeg", "png", "gif"); 

if(in_array($file_name[1], $allowed_extension)){
    $new_name = $_POST['NombreArchivo']. '.' .  $file_name[1];
   
    $name = sqlValue(mb_strtoupper($_POST["NombreArchivo"]), "text");
    $extD = sqlValue($file_name[1], "text");
    $now = sqlValue(date('Y-m-d H:i:s'), "date");
    $idU = $_POST['idU'];
    $aleatorio = sqlValue("imagen_".$idU, "text");

    if(isset($_POST['idP'])){
        $idP =$_POST['idP'];
        mysql_select_db($database_horizonte, $horizonte);
        $sql = "INSERT INTO documentos (nombre_do, ext_do, aleatorio_do, tipo_quien_do, usuario_do, fecha_do, que_es_do)";
        $sql.= "VALUES ($name, $extD, $idP, 1, $idU, $now, 'IMAGEN')";
        $update = mysql_query($sql, $horizonte) or die (mysql_error());
    }else{
        mysql_select_db($database_horizonte, $horizonte);
        $sql = "INSERT INTO documentos (nombre_do, ext_do, aleatorio_do, tipo_quien_do, usuario_do, fecha_do, que_es_do)";
        $sql.= "VALUES ($name, $extD, $aleatorio, 1, $idU, $now, 'IMAGEN')";
        $update = mysql_query($sql, $horizonte) or die (mysql_error());
    }
    

    mysql_select_db($database_horizonte, $horizonte);
 	$resultF = mysql_query("SELECT MAX(id_do) from documentos limit 1 ", $horizonte) or die (mysql_error());
 	$rowF = mysql_fetch_row($resultF);
    $idDocu = $rowF[0] .".". $file_name[1];

    $resultado = move_uploaded_file($archivo["tmp_name"], $idDocu);
}

if($resultado){
    if($update){
        echo "Subido con éxito";
    }
} else {
    echo "Error al subir archivo";
}