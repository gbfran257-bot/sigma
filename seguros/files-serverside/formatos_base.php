<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 mysql_select_db($database_horizonte, $horizonte);
 $resultSu1 = mysql_query("SELECT formato_co_cf, formato_nm_cf, formato_la_cf, formato_im_cf, formato_en_cf, formato_ul_cf, formato_cp_cf, formato_sm_cf from configuracion order by id_cf desc limit 1 ", $horizonte) or die (mysql_error());
 $rowSu1 = mysql_fetch_row($resultSu1);

 echo $rowSu1[0].'{*]-[}'.$rowSu1[1].'{*]-[}'.$rowSu1[2].'{*]-[}'.$rowSu1[3]."{*]-[}".$rowSu1[4]."{*]-[}".$rowSu1[5]."{*]-[}".$rowSu1[6]."{*]-[}".$rowSu1[7];
	
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>