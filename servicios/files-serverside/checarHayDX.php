<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["noAleatorio"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT count(id_dxc) from dx_consultas where id_c_dxc = $idC", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC);
		
 echo $rowC[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>