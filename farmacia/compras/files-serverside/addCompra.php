<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$compras = $_POST['datos'];
$idU = sqlValue($_POST['idU'],"int");
$costoT = sqlValue($_POST['costoT'],"int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");
$fecha1="'".date('Y-m-d')." 00:00:00"."'";
$fecha2="'".date('Y-m-d')." 23:59:59"."'";
$da = date('Ymd');
    
    //generamos la referencia
    mysql_select_db($database_horizonte, $horizonte);
    $resultR = mysql_query("SELECT count(id), max(contador) from stock_has_bach where fecha_registro between ".$fecha1." and ".$fecha2." ", $horizonte) or die(mysql_error());
    $rowR = mysql_fetch_row($resultR);

    if($rowR[0]==0){ 
        $noRef=$da."-"."1"; 
        $noRef="'".$noRef."'"; 
        $contador = 1;
    }else{ 
        $daa=$rowR[1]+1;
        $noRef=$da."-".$daa;
        $noRef="'".$noRef."'";
        $contador = $daa;
    }//fin generamos la referencia

    for ($i=0; $i < count($compras); $i++) { 
        $lote = sqlValue($compras[$i]['lote'],"text");
        $idProducto = $compras[$i]['producto'];
        $costo = $compras[$i]['costo'];
        $cantidad = $compras[$i]['cantidad'];
        $sucursal = $compras[$i]['sucursal'];
        $caducidad = "'".$compras[$i]['caducidad']." 00:00:00"."'";
        $estatus = $compras[$i]['estatus'];

        mysql_select_db($database_horizonte, $horizonte);
        $resultA = mysql_query("SELECT id from stock where id_su = $sucursal ", $horizonte) or die(mysql_error());
        $rowA = mysql_fetch_row($resultA);
        $sucu = $rowA[0];

        mysql_select_db($database_horizonte, $horizonte);
        $sql = "INSERT INTO `stock_has_bach` (`id`, `referencia_compra`, `id_stock`, `Lote`, `fecha_expiracion`, `id_Producto`, `costo_unitario`, `cantidad`, `estatus`, `existencias`, `contador`, `usuario_registro`, `fecha_update`, `fecha_registro`) VALUES (NULL, $noRef, $sucu, $lote, $caducidad,  $idProducto, $costo, $cantidad, $estatus, $cantidad, $contador, $idU, $now, $now) ";
        // echo $sql;
        $result = mysql_query($sql, $horizonte) or die(mysql_error());
    

        if (!$result) {
            echo $sql;
            $hecho = 0;
        } else{ 
           $hecho = 1; 
        }
    }

    if ($hecho == 1) {
       echo 1;
    }else{ 
       echo $sql;
    }
?>
