<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


 $idP = sqlValue($_POST["idm"], "int");
 $id_sucursal = sqlValue($_POST["id_sucursal"], "int");
 $min_stock = sqlValue($_POST["min_stock"], "int");
 $max_stock = sqlValue($_POST["max_stock"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $id_usuario = sqlValue($_POST["id_usuario"], "int");

     //Verificamos si existe registro en max_min_generico
    mysql_select_db($database_horizonte, $horizonte);
    $qry_count = mysql_query("SELECT COUNT(id_mmg) FROM max_min_generico WHERE id_suc_mmg = $id_sucursal AND id_generico_mmg = $idP", $horizonte) or die (mysql_error());
    $datos_query_count = mysql_fetch_row($qry_count);
    $count = $datos_query_count[0];
    //obtenemos datos de stock en caso de que exista el registro
    if($count>0){
        //editar la informacion de la tabla
        mysql_select_db($database_horizonte, $horizonte);
        $query_upd_mmg = "UPDATE max_min_generico SET min_mmg = $min_stock, max_mmg = $max_stock WHERE id_suc_mmg = $id_sucursal AND id_generico_mmg = $idP"; 
        $execute_query_updmmg = mysql_query($query_upd_mmg, $horizonte) or die (mysql_error());
    }else{
        //insertar en la tabla
        mysql_select_db($database_horizonte, $horizonte);
        $query_add_mmg = "INSERT INTO max_min_generico (id_suc_mmg, id_generico_mmg, min_mmg, max_mmg, fecha_mmg, id_usuario_mmg) VALUES ($id_sucursal, $idP, $min_stock, $max_stock, $now, $id_usuario)"; 
        $execute_query_mmg = mysql_query($query_add_mmg, $horizonte) or die (mysql_error());
    }

    echo 1;


 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>