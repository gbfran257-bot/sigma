<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    $usuario = sqlValue($_POST['usuario'], 'int');
    $id = sqlvalue($_POST['id'],'int');
    $max = sqlValue($_POST['max'], 'int');
    $sucursal = sqlValue($_POST['sucursal'], 'int');

    //Verificamos si existe registro en base de datos.
    mysql_select_db($database_horizonte, $horizonte);
    $buscar_registro = mysql_query("SELECT COUNT(*) FROM max_min_stock WHERE id_suc = ".$sucursal." AND id_producto = ".$id, $horizonte) or die(mysql_error());
    $runQry = mysql_fetch_row($buscar_registro);
    $infoQry = $runQry[0];

    //si no existe registro, lo creamos, caso contrario debemos actualizar.
    if($infoQry <= 0){
        mysql_select_db($database_horizonte, $horizonte);
        $QryIns = "INSERT INTO max_min_stock (id_suc, id_producto, max_mm, min_mm, id_u) VALUES ($sucursal, $id, $max, ".($max-1).", $usuario)";
        $insertar = mysql_query($QryIns, $horizonte) or die (mysql_error());
    }else{
        mysql_select_db($database_horizonte, $horizonte);
        $QryUpd = "UPDATE max_min_stock set max_mm = " . $max . " WHERE id_suc = " . $sucursal . " AND id_producto = " . $id;
        $update = mysql_query($QryUpd, $horizonte) or die (mysql_error());
    }
    echo 1;
?>