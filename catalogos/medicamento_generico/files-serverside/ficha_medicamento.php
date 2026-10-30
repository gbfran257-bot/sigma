<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["id_um"], "int");
 $id_sucursal = sqlValue($_POST["id_sucursal"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT * from medicamentos where id_med = $id ", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);

 //Verificamos si existe registro en max_min_generico
 mysql_select_db($database_horizonte, $horizonte);
 $qry_count = mysql_query("SELECT COUNT(id_mmg) FROM max_min_generico WHERE id_suc_mmg = $id_sucursal AND id_generico_mmg = $id", $horizonte) or die (mysql_error());
 $datos_query_count = mysql_fetch_row($qry_count);
 $count = $datos_query_count[0];
 //obtenemos datos de stock en caso de que exista el registro
 if($count>0){
     mysql_select_db($database_horizonte, $horizonte);
     $qry_datos_extra = mysql_query("SELECT min_mmg, max_mmg FROM max_min_generico WHERE id_suc_mmg = $id_sucursal AND id_generico_mmg = $id", $horizonte) or die (mysql_error());
     $datos_extra = mysql_fetch_row($qry_datos_extra);

     $minimo_mmg = $datos_extra[0];
     $maximo_mmg = $datos_extra[1];
 }else{
    $minimo_mmg = 0;
    $maximo_mmg = 0;
 }

 $datos = $row[0].'*}'. $row[1].'*}'. $row[2].'*}'. $row[3].'*}'. $row[4].'*}'. $row[5].'*}'. $row[6].'*}'. $row[7].'*}'. $row[8].'*}'. $row[9].'*}'. $row[10].'*}'. $row[11].'*}'. $row[12].'*}'. $row[13].'*}'. $row[14].'*}'. $row[15].'*}'. $row[16].'*}'. $row[17].'*}'. $row[18].'*}'. $row[19].'*}'. $row[20].'*}'. $row[21].'*}'. $row[22] .'*}'. $row[23].'*}'. $row[24].'*}'.$minimo_mmg.'*}'.$maximo_mmg;

 echo $datos;
 
 //Cerrar conexión a la Base de Datos
mysql_close($horizonte);
?>