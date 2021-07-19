<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id = sqlValue($_POST["idColonia"], "int");
 $estado = sqlValue($_POST["estadoCol"], "int");
 $municipio = sqlValue($_POST["municipioCol"], "int");
 $CP = sqlValue($_POST["CP_col"], "int");

 
 $estadoName = sqlValue(mb_strtoupper($_POST["estadoCol1"]), "text");
 $municipioName = sqlValue(mb_strtoupper($_POST["municipioCol1"]), "text");
 $col_Col = sqlValue(mb_strtoupper($_POST["col_Col"]), "text");
  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE mexico set c_oficina = $estado, c_municipio = $municipio, d_codigo = $CP,d_asenta=$col_Col, d_municipio = $municipioName, d_estado = $estadoName  where id_mx = $id limit 1";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());    
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>