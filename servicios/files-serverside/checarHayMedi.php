<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["noAleatorio"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_mr) from medicamentos_receta where id_co_mr = $idC", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
		
 echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>