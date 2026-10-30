<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$contador = 0;
$referencia_hospital=0;

$idP = sqlValue($_POST["idP"], "int");
$idU = sqlValue($_POST["idU"], "int");
$id_venta_con = sqlValue($_POST["id_vc"], "int");
 
$now = sqlValue(date('Y-m-d H:i:s'), "date"); 
$fecha1="'".date('Y-m-d')." 00:00:00"."'";
$fecha2="'".date('Y-m-d')." 23:59:59"."'"; 
$fecha=date('Ymd');

//contador por dia
mysql_select_db($database_horizonte, $horizonte);
$resultR = mysql_query("SELECT COUNT(id_rh) FROM referencias_hospital WHERE fecha_rh BETWEEN ".$fecha1." and ".$fecha2." ", $horizonte) or die(mysql_error());
$rowR = mysql_fetch_row($resultR);

//contador global
mysql_select_db($database_horizonte, $horizonte);
$contador_global = mysql_query("SELECT COUNT(id_rh) FROM referencias_hospital", $horizonte) or die(mysql_error());
$resultado_cont = mysql_fetch_row($contador_global);
$cont_glob = $resultado_cont[0]+=1;

//sucursal de la consulta(orden de venta) donde se realizo la hospitalizacion
mysql_select_db($database_horizonte, $horizonte);
$verif_sucursal = mysql_query("SELECT s.id_su FROM venta_conceptos vc LEFT JOIN orden_venta ov ON ov.referencia_ov = vc.referencia_vc LEFT JOIN sucursales s ON s.id_su = ov.sucursal_ov WHERE vc.id_vc = $id_venta_con LIMIT 1", $horizonte) or die(mysql_error());
$resultado_suc = mysql_fetch_row($verif_sucursal);

if($rowR[0]==0){ 
    $referencia_hospital=$fecha."-"."1"; 
    $referencia_hospital="'H-".$referencia_hospital."'"; 
    $contador = 1;
}else{ 
    $contador_id_rh=$rowR[0]+1;
    $referencia_hospital=$fecha."-".$contador_id_rh; 
    $referencia_hospital="'H-".$referencia_hospital."'"; 
    $contador = $contador_id_rh;
}

mysql_select_db($database_horizonte, $horizonte);
$sql_ins_rh = "INSERT INTO referencias_hospital (id_rh, referencia_rh, usuario_rh, fecha_rh, estado_rh, id_paciente_rh, contador_rh, contador_global, id_sucursal_rh) VALUES (NULL, $referencia_hospital, $idU, $now, '0', $idP, $contador, $cont_glob, $resultado_suc[0])";
$ejecutar_qry1 = mysql_query($sql_ins_rh, $horizonte) or die (mysql_error());

if(!$ejecutar_qry1){
    echo "Ocurrio un problema: consultas/files-serverside/crear_insertar_ref_hospital.php";
}else{
    mysql_select_db($database_horizonte, $horizonte);
    $sql_ins_his = "INSERT INTO hist_referencias_hospital (id_hrh, referencia_rh_hrh, usuario_hrh, fecha_alta_hrh, estado_hrh) VALUES (NULL, $referencia_hospital, $idU, $now, '0')";
    $ejecutar_qry2 = mysql_query($sql_ins_his, $horizonte) or die (mysql_error());

    if(!$ejecutar_qry2){
        echo "Ocurrio un problema: consultas/files-serverside/crear_insertar_ref_hospital.php";
    }else{
        echo "1;*-$referencia_hospital";
    }

    
}



?>