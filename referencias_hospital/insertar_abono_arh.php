<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$id_rh = sqlValue($_POST["id_rh"], "int");
$abono = sqlValue($_POST["abono"], "float");
$idU = sqlValue($_POST["idU"], "int");
$forma_pago = sqlValue($_POST["forma_pago"], "int");
$persona_abona = sqlValue($_POST["persona_abona"], "text");
$fecha=date('YmdHis');
 
mysql_select_db($database_horizonte, $horizonte);
$sql = "INSERT INTO abonos_referencias_hospital (id_rh_arh, usuario_arh, fecha_arh, cantidad_abonada_arh, nom_pers_abona_arh, forma_pago_arh) VALUES ($id_rh, $idU, $fecha, $abono, $persona_abona, $forma_pago)";
$ejecutar = mysql_query($sql, $horizonte) or die (mysql_error());

if(!$ejecutar){
    echo "Ocurrio un problema";
}else{
    echo "1";
}

?>