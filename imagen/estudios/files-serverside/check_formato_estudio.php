<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultR1 = mysql_query("SELECT formato_fc from formatos_conceptos where id_fc = $idE", $horizonte);
 $rowR1 = mysql_fetch_row($resultR1);

 echo $rowR1[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>