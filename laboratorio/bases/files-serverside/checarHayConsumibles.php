<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultC = mysql_query("SELECT count(id_ac) from asignar_consumibles where aleatorio_ac = $noTemp and temporal_ac = 1 ", $horizonte) or die (mysql_error());
	 $rowC = mysql_fetch_row($resultC);
		
echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>