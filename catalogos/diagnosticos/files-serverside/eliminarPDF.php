<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");

//  $now = sqlValue(date('Y-m-d H:i:s'), "date");
mysql_select_db($database_horizonte, $horizonte);
$sql1 = "SELECT pdf from  diagnosticos WHERE id_di = $id";
$update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
$row = mysql_fetch_row($update1);

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE diagnosticos SET pdf = null WHERE id_di = $id";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());


	
 if(!$update){
    echo $sql1;
 } else{
    if(unlink('../documentos/'.$row[0])){
        echo 1;
     }else{
        echo $sql;
     }
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>