<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$idU = sqlValue($_POST['idU'],"int");
$idProd= sqlValue($_POST['idPro'],"int");
$cant = sqlValue($_POST['cant'],"int");
$id_su=sqlValue($_POST['su'],"int");
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


//obtenemos datos del registro de stock del producto a transferir
mysql_select_db($database_horizonte, $horizonte);
$resultR = mysql_query("SELECT * from stock_has_bach where id = $idProd " , $horizonte) or die(mysql_error());
$rowR = mysql_fetch_row($resultR);

    // $noRef = "'TRANFERENCIA'";
    $lote = sqlValue($rowR[3], "text");
    $caducidad = sqlValue($rowR[4], "date");
    $idProducto =  $rowR[5];
    $costo = $rowR[6];
    // $contador = 0;

//sacamos el almacen correspondiente por dicha sucursal 
mysql_select_db($database_horizonte, $horizonte);
$resultA = mysql_query("SELECT id from stock where id_su = $id_su ", $horizonte) or die(mysql_error());
$rowA = mysql_fetch_row($resultA);
    $sucu = $rowA[0];

//registro de trasnferencia en tabla de stock
mysql_select_db($database_horizonte, $horizonte);
$sql = "INSERT INTO `stock_has_bach` (`id`, `referencia_compra`, `id_stock`, `Lote`, `fecha_expiracion`, `id_Producto`, `costo_unitario`, `cantidad`, `estatus`, `existencias`, `contador`, `usuario_registro`, `fecha_update`, `fecha_registro`) VALUES (NULL, $noRef, $sucu, $lote, $caducidad, $idProducto, $costo, $cant, 17, $cant, $contador, $idU, $now, $now) ";
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
     echo $sql; 
}else{
    //si se guarda correctamente  restamos la cantidad transferida del registro anterior 
    mysql_select_db($database_horizonte, $horizonte);
    $sql1 = "UPDATE stock_has_bach SET existencias = existencias - $cant WHERE id = $idProd ";
    $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());

    if (!$update1) {
        echo $sql1; 
   }else{
       echo 1;
   }
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>