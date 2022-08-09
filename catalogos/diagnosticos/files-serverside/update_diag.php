<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idest"], "int");
 $clave = sqlValue(mb_strtoupper($_POST["clave"]), "text");
 $diag = sqlValue(mb_strtoupper($_POST["diagno"]), "text");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 if(isset($_FILES['gpi'])){
    $gpi = $_FILES["gpi"];
    $pdf = move_uploaded_file ($gpi["tmp_name"] , "../documentos/".$gpi["name"]);
    $gpi_name = sqlValue($gpi["name"], "text");
}

if($pdf){
    mysql_select_db($database_horizonte, $horizonte);
    $sql = "UPDATE diagnosticos set nombre_di = $diag, clave_di = $clave, usuario_di = $idU, fecha_di = $now, pdf = $gpi_name where id_di = $id limit 1";
     
    $update = mysql_query($sql, $horizonte) or die (mysql_error());    
       
    if(!$update){echo $sql;} else{echo 1;}
}else{
    mysql_select_db($database_horizonte, $horizonte);
    $sql = "UPDATE diagnosticos set nombre_di = $diag, clave_di = $clave, usuario_di = $idU, fecha_di = $now where id_di = $id limit 1";
     
    $update = mysql_query($sql, $horizonte) or die (mysql_error());    
       
    if(!$update){echo $sql;} else{echo 1;}
}

  


 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>