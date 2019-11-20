<?php
require("../../../Connections/sigma.php");
require("../../../funciones/php/values.php");

 $ref = sqlValue($_POST["ref"], "text");
 //$ref = sqlValue('20130321-5', "text");
  
mysql_select_db($database_sigma, $sigma);
 $result = mysql_query("SELECT sum(pago_pag), total_pag from pagos_ov where referencia_pag = $ref ", $sigma) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 $old_abonado = $row[0];
 $old_saldo = $row[1]-$old_abonado;
 $new_abonado = $old_abonado;
 $new_saldo = $old_saldo;
  //echo $new_abonado;


$sql="UPDATE orden_venta SET abonado_ov = $new_abonado, saldo_ov = $new_saldo where referencia_ov = ".$ref.";";
	mysql_select_db($database_sigma, $sigma);
$insertar2 = mysql_query($sql, $sigma) or die (mysql_error());
if (!$insertar2) {echo $sql;}
else{echo "ok";}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($sigma);
?>