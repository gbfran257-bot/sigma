<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

 $concepto = sqlValue($_POST["via_admin"], "text");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO catalogo_via_administracion(concepto)";
 $sql.= "VALUES ($concepto)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>