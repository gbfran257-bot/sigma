<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_p"], "int");

//  $now = sqlValue(date('Y-m-d H:i:s'), "date");

//hacemos un conteo de cuantos medicamentos comerciales estan asignados al generico
mysql_select_db($database_horizonte, $horizonte);
$countMEds = mysql_query("SELECT COUNT(*) FROM conceptos WHERE id_medicamento_g = " . $id, $horizonte) or die (mysql_error());
$resultCount = mysql_fetch_row($countMEds);

if($resultCount[0] <= 0){

    mysql_select_db($database_horizonte, $horizonte);
    $sql = "DELETE FROM medicamentos WHERE id_med = $id";
     
    $update = mysql_query($sql, $horizonte) or die (mysql_error());
       
    if(!$update){
        echo $sql;
    }else{
        echo 1;
    }

}else{
    echo 2;
}
  


 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>