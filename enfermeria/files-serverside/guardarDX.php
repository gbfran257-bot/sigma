<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $claveDX = sqlValue($_POST["claveDX"], "text");
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultC = mysql_query("SELECT id_di from diagnosticos where clave_di = $claveDX ", $horizonte) or die (mysql_error());
	 $rowC = mysql_fetch_row($resultC);
 $idDX = sqlValue($rowC[0], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 	mysql_select_db($database_horizonte, $horizonte); 
	 $resultIDC = mysql_query("SELECT id_vc from venta_conceptos where no_temp_vc = $noTemp and tipo_concepto_vc = 1 limit 1 ", $horizonte) or die (mysql_error());
	 $rowIDC = mysql_fetch_row($resultIDC);
	
 mysql_select_db($database_horizonte, $horizonte); 
$sql="INSERT INTO dx_consultas(no_temp_dxc,id_p_dxc,id_u_dxc,id_dx_dxc,fecha_dxc, id_c_dxc) VALUES ($noTemp, $idP, $idU, $idDX, $now, $rowIDC[0])";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>