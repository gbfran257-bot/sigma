<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultC = mysql_query("SELECT count(id_am) from asignar_muestra where aleatorio_am = $noTemp and temporal_am = 1 ", $horizonte) or die (mysql_error());
	 $rowC = mysql_fetch_row($resultC);
		
echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>