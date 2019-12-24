<?php
header('content-type: text/html; charset: utf-8');
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 //$_GET['ocupacion'] = 'DISE';
 $profesion = $_GET['ocupacion'];
  
 mysql_select_db($database_horizonte, $horizonte);
 $query_catalogoSexos = "SELECT id_subarea_ocupacion, ocupacion FROM catalogo_ocupaciones where ocupacion like '%".$profesion."%' ";
 $catalogoSexos = mysql_query($query_catalogoSexos, $horizonte) or die(mysql_error());
 $row_catalogoSexos = mysql_fetch_assoc($catalogoSexos);
 $totalRows_catalogoSexos = mysql_num_rows($catalogoSexos);
 $b = array();
 do{
	 //echo $row_catalogoSexos['nombre_profesion'];
	 $b[] = utf8_encode($row_catalogoSexos['ocupacion']);
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