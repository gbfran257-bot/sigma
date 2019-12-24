<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idMedH = sqlValue($_POST["idMedH"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $sql="INSERT INTO medicamentos_aplicados_hospi(id_medicamento_hospital_mah,id_usuario_mah,fecha_mah) VALUES($idMedH, $idU, $now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){ echo $sql; }else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>