<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$id = sqlValue($_POST["id"], "int");
$referencia = sqlValue($_POST["referencia"], "text");
$id_ov = sqlValue($_POST["id_ov"], "int");

mysql_select_db($database_horizonte, $horizonte);
$sql_bus_ref = "SELECT COUNT(id_rrh) FROM rel_referencias_hospital WHERE referencia_rrh = $referencia";
$ejecutar_qry1 = mysql_query($sql_bus_ref, $horizonte) or die (mysql_error());
$aResultTotal = mysql_fetch_array($ejecutar_qry1);

if($aResultTotal[0]<1){

    mysql_select_db($database_horizonte, $horizonte);
    $sql_ins_rrh = "INSERT INTO rel_referencias_hospital (id_rrh, id_rh_rrh, referencia_rrh) VALUES (NULL, $id, $referencia)";
    $ejecutar_qry2 = mysql_query($sql_ins_rrh, $horizonte) or die (mysql_error());

    if(!$ejecutar_qry2){
        echo "Ocurrio un problema";
    }else{
        mysql_select_db($database_horizonte, $horizonte);
        $sql_upd_arh = "UPDATE orden_venta SET add_ref_hospital = '1' WHERE id_ov = $id_ov";
        $ejecutar_qry3 = mysql_query($sql_upd_arh, $horizonte) or die (mysql_error());

        if(!$ejecutar_qry3){
            echo "Ocurrio un problema";
        }else{
            echo "1";
        }

    }

}else{
    echo "Ya ha sido agregado";
}


?>