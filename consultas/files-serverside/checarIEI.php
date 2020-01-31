<?php
require("../../Connections/horizonte.php");
require("../../Connections/ipacs.php");
require("../../funciones/php/values.php");

 $idVC = sqlValue($_POST["idVC"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $result1 = mysql_query("SELECT count(id_vc) from venta_conceptos where (interpretacion_vc is not NULL or interpretacion_vc != '') and id_vc = $idVC", $horizonte) or die (mysql_error()); $row1 = mysql_fetch_row($result1);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $result1a = mysql_query("SELECT id_pacs from venta_conceptos where id_vc = $idVC", $horizonte) or die (mysql_error()); $row1a = mysql_fetch_row($result1a);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $result2 = mysql_query("SELECT count(id_do) from documentos where id_quien_do = $idVC and tipo_quien_do = 4 and que_es_do = 'FOTOGRAFIA'", $horizonte) or die (mysql_error()); $row2 = mysql_fetch_row($result2);
 
 //mysql_select_db($database_ipacs, $ipacs); 
 $result3 = pg_query($ipacs, "SELECT count(pk) from patient where pat_id = $row1a[0]");
 $row3 = pg_fetch_row($result3);
		
 echo $row1[0].';'.$row2[0].';'.$row3[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
 pg_close($ipacs);
?>
