<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$id_rh = sqlValue($_POST["id_rh"], "int");
$id_ov = sqlValue($_POST["id_ov"], "int");
$idU = sqlValue($_POST["idU"], "int");
$fecha=date('YmdHis');

if(isset($_POST["ref_ov"])){
    $ref_ov = sqlValue($_POST["ref_ov"], "text");
    mysql_select_db($database_horizonte, $horizonte);
    $resultado = mysql_query("SELECT id_ov FROM orden_venta WHERE referencia_ov = $ref_ov", $horizonte) or die (mysql_error());
    $datos = mysql_fetch_row($resultado);
    $id_ov = $datos[0];
// echo $datos[0].'*}'.$datos[1].'*}'.$datos[2];
}
 
mysql_select_db($database_horizonte, $horizonte);
$sql = "INSERT INTO seguimiento_referencias_hospital (id_srh, id_rh_srh, referencia_ov_srh, usuario_srh, fecha_srh, accion_srh) VALUES (NULL, $id_rh, $id_ov, $idU, $fecha, '0')";
$ejecutar = mysql_query($sql, $horizonte) or die (mysql_error());

if(!$ejecutar){
    echo "Ocurrio un problema";
}else{
    echo "1";
}

?>