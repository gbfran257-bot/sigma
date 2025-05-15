<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$noTemp = sqlValue($_POST["noTemp"], "text");
$editando = sqlValue($_POST["editando_ov"], "int");

//si es ov nueva
if($editando == 0){
    mysql_select_db($database_horizonte, $horizonte); 
    $sql="SELECT count(id_vc) from venta_conceptos where no_temp_vc=$noTemp AND temporal_vc = 1";
    $update = mysql_query($sql, $horizonte) or die (mysql_error());
    $row = mysql_fetch_row($update);
    if ($row[0] < 1) { 
        echo $sql; 
    }else{ 
        echo 1;
    }
}else if($editando == 1){
    //si se esta editando
    echo 1;
}



//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>