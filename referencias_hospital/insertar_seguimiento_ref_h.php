<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$id_referencia_h = sqlValue($_POST["id_referencia_h"],"int");
$referencia_ov = sqlValue($_POST["referencia_ov"],"text");
 
mysql_select_db($database_horizonte, $horizonte);
$sql = "INSERT INTO rel_referencias_hospital (id_rrh, id_rh_rrh, referencia_rrh) VALUES (NULL, $id_referencia_h, $referencia_ov)";
$ejecutar = mysql_query($sql, $horizonte) or die (mysql_error());

if(!$ejecutar){
    echo "Ocurrio un problema";
}else{
    mysql_select_db($database_horizonte, $horizonte);
    $sql_upd_arh = "UPDATE orden_venta SET add_ref_hospital = '1' WHERE referencia_ov = $referencia_ov";
    $ejecutar_qry3 = mysql_query($sql_upd_arh, $horizonte) or die (mysql_error());

    if(!$ejecutar_qry3){
        echo "Ocurrio un problema";
    }else{
        echo "1";
    }
}

?>