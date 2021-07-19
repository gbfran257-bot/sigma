<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");


$archivo = $_FILES["archivo"];
$file_name = explode(".", $_FILES['archivo']['name']);
$allowed_extension = array("jpg", "jpeg", "png", "gif"); 

if(in_array($file_name[1], $allowed_extension)){
    $new_name = $_POST['NombreArchivo']. '.' .  $file_name[1];
   
    $name = sqlValue(mb_strtoupper($_POST["NombreArchivo"]), "text");
    $extD = sqlValue($file_name[1], "text");
    $now = sqlValue(date('Y-m-d H:i:s'), "date");
    $idU = $_POST['idU'];

    mysql_select_db($database_horizonte, $horizonte);
    $sql1= "SELECT temporal_u FROM usuarios where id_u = $idU";
    $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
    $rowT = mysql_fetch_row($update1);
    $aleatorio = sqlValue($rowT[0], "text");

        //quitamos anterior foto de perfil
        mysql_select_db($database_horizonte, $horizonte);
        $sql5 = "SELECT id_do, ext_do FROM documentos WHERE perfil_do = 1 AND aleatorio_do = $aleatorio";
        // echo $sql5;
        $update5 = mysql_query($sql5, $horizonte) or die (mysql_error());
        $row5 = mysql_fetch_row($update5);

        if($update5){
            
            $carpeta1 = $row5[0].'.'.$row5[1];
            unlink($carpeta1);

            if($row5[0] != ''){
                mysql_select_db($database_horizonte, $horizonte);
            $sql6 = "DELETE FROM documentos WHERE id_do = $row5[0]";
            $update6 = mysql_query($sql6, $horizonte) or die (mysql_error());
            }
            
        }

        //POR SI HAY ALGUN OTRO REGISTRO  DE ESE USUARIO MARCADO COMO FOTO DE PERFIL
        mysql_select_db($database_horizonte, $horizonte);
        $sql4 = "UPDATE documentos set perfil_do = 0 where aleatorio_do = $aleatorio";
        $update4 = mysql_query($sql4, $horizonte) or die (mysql_error());

        mysql_select_db($database_horizonte, $horizonte);
        $sql = "INSERT INTO documentos (nombre_do, ext_do, aleatorio_do, tipo_quien_do, usuario_do, fecha_do, que_es_do, perfil_do)";
        $sql.= "VALUES ($name, $extD, $aleatorio, 3, $idU, $now, 'FOTO',1)";
        // echo $sql;
        $update = mysql_query($sql, $horizonte) or die (mysql_error());

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