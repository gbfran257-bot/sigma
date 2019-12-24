<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idH = sqlValue($_POST["idH"], "int");
 $aleatorio = sqlValue($_POST["aleatorio"], "text");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_mh) from medicamentos_hospital where id_hospitalizacion_mh = $idH and aleatorio_mh = $aleatorio", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
		
 echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>