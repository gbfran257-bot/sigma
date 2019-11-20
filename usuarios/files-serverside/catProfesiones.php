<?php
header('content-type: text/html; charset: utf-8');
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $profesion = $_GET['profesion'];
  
 mysql_select_db($database_horizonte, $horizonte);
 $query_catalogoSexos = "SELECT id_profesion, nombre_profesion FROM profesiones where nombre_profesion like '%$profesion%' ";
 $catalogoSexos = mysql_query($query_catalogoSexos, $horizonte) or die(mysql_error());
 $row_catalogoSexos = mysql_fetch_assoc($catalogoSexos);
 $totalRows_catalogoSexos = mysql_num_rows($catalogoSexos);
 $b = array();
 do{
	 //echo $row_catalogoSexos['nombre_profesion'];
	 $b[] = utf8_encode($row_catalogoSexos['nombre_profesion']);
}
 while ($row_catalogoSexos = mysql_fetch_assoc($catalogoSexos));
  $rows = mysql_num_rows($catalogoSexos);
  if($rows > 0) {
      mysql_data_seek($catalogoSexos, 0);
	  $row_catalogoSexos = mysql_fetch_assoc($catalogoSexos);
  }
 
 echo json_encode($b);
 //echo json_decode(json_encode($arr));
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>