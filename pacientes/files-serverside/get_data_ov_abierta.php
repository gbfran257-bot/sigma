<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $aleatorio = sqlValue($_POST["aleatorio"], "text");
 mysql_select_db($database_horizonte, $horizonte); 
 $result = mysql_query("SELECT ov.sucursal_ov, ov.medico_ei_ov, ov.medico_el_ov, ov.personal_s_ov, ov.folio_externo, ov.expediente_externo, ov.motivo_c_ov, ov.observaciones_i_ov, ov.observaciones_l_ov, ov.observaciones_s_ov FROM orden_venta ov WHERE no_temp_ov = $aleatorio", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 echo json_encode($row);
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
