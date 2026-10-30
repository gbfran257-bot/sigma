<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $referencia = sqlValue($_POST["referencia"], "text");
 $idpago = sqlValue($_POST["pago"], "int");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE pagos_ov SET forma_pago_pag = $idpago WHERE referencia_pag = $referencia limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>