<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");
//Generales
 $ref = sqlValue($_POST["ref"], "text");
 //$ref = "'"."20130318-2"."'";
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultR = mysql_query("SELECT subtotal_consulta_ov, subtotal_servicios_ov, subtotal_estudios_ov from orden_venta where referencia_ov = $ref ", $horizonte) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR);
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultAbonadoC = mysql_query("SELECT sum(pago_pag) from pagos_ov where referencia_pag = $ref and tipo_concepto_pag = 1 " , $horizonte) or die (mysql_error());
 $rowAbonadoC = mysql_fetch_row($resultAbonadoC);
 
 $abonadoC=$rowAbonadoC[0];
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultAbonadoS = mysql_query("SELECT sum(pago_pag) from pagos_ov where referencia_pag = $ref and tipo_concepto_pag = 2 " , $horizonte) or die (mysql_error());
 $rowAbonadoS = mysql_fetch_row($resultAbonadoS);
 
 $abonadoS=$rowAbonadoS[0];
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultAbonadoE = mysql_query("SELECT sum(pago_pag) from pagos_ov where referencia_pag = $ref and tipo_concepto_pag = 3 " , $horizonte) or die (mysql_error());
 $rowAbonadoE = mysql_fetch_row($resultAbonadoE);
 
 $abonadoE=$rowAbonadoE[0];
 
 $subtotales = $rowR[0].";".$rowR[1].";".$rowR[2].";".$abonadoC.";".$abonadoS.";".$abonadoE;
 echo $subtotales;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>