<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$idS = sqlValue($_POST['idS'],"int");
$cant = sqlValue($_POST['cant'],"int");


    //si se guarda correctamente  restamos la cantidad transferida del registro anterior 
    mysql_select_db($database_horizonte, $horizonte);
    $sql1 = "UPDATE stock_has_bach SET existencias = $cant WHERE id = $idS ";
    $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

    if (!$update1) {
        echo $sql1; 
   }else{
       echo 1;
   }


 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>