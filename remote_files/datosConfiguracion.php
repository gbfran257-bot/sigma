<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$resultP = mysql_query("SELECT nombre_sistema_cf, nombre_db_cf, nombre_membresia_cf, precio_membresia_cf, periodo_membresia_cf, dias_avisar_membresia_cf, tecla_cf, formato_co_cf, formato_nm_cf, formato_la_cf, formato_im_cf, formato_en_cf, formato_ul_cf, formato_cp_cf, formato_sm_cf, link_sistema_local, link_pacs_local, link_sistema_externo, link_pacs_externo, sitio_web from configuracion order by id_cf desc limit 1 ", $horizonte) or die (mysql_error());
$rowP = mysql_fetch_row($resultP);

$datos = $rowP[0].'};['.$rowP[1].'};['.$rowP[2].'};['.$rowP[3].'};['.$rowP[4].'};['.$rowP[5].'};['.$rowP[6].'};['.$rowP[7].'};['.$rowP[8].'};['.$rowP[9].'};['.$rowP[10].'};['.$rowP[11].'};['.$rowP[12].'};['.$rowP[13].'};['.$rowP[14].'};['.$rowP[15].'};['.$rowP[16].'};['.$rowP[17].'};['.$rowP[18].'};['.$rowP[19];

echo $datos;

mysql_close($horizonte);
?>