<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

 $id = sqlValue($_POST["id"], "int");
 $id_rh = sqlValue($_POST["id_rh"], "int");
 $id_ov = sqlValue($_POST["id_ov"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $fecha=date('YmdHis');
 
mysql_select_db($database_horizonte, $horizonte); 
$sql = "delete from rel_referencias_hospital where id_rrh = $id limit 1";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { 
    echo "ocurrio un problema"; 
}else{ 
	
    mysql_select_db($database_horizonte, $horizonte);
    $sql_upd_arh = "UPDATE orden_venta SET add_ref_hospital = '0' WHERE id_ov = $id_ov";
    $ejecutar_qry1 = mysql_query($sql_upd_arh, $horizonte) or die (mysql_error());

    if (!$ejecutar_qry1) {
        echo "ocurrio un problema"; 
    }else{
        mysql_select_db($database_horizonte, $horizonte); 
        $sql1 = "INSERT INTO seguimiento_referencias_hospital (id_srh, id_rh_srh, referencia_ov_srh, usuario_srh, fecha_srh, accion_srh) VALUES (NULL, $id_rh, $id_ov, $idU, $fecha, '1')";
        $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

        echo 1; 
    } 
}

 
 mysql_close($horizonte);
?>