<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$estadoCol1 = sqlValue($_POST['estadoCol1'], "text");
$municipioCol1 = sqlValue($_POST['municipioCol1'], "text");
$col_Col = sqlValue($_POST['col_Col'], "text");
$CP_col = sqlValue($_POST['CP_col'], "text");
$estadoCol = sqlValue($_POST['estadoCol'], "text");
$municipioCol = sqlValue($_POST['municipioCol'], "text");

  
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO mexico(d_codigo, d_asenta, d_municipio,d_estado,c_oficina,c_municipio)";
 $sql.= "VALUES ($CP_col,$col_Col,$municipioCol1,$estadoCol1,$estadoCol,$municipioCol)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>