<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$concepto = sqlValue(mb_strtoupper($_POST['conceptoDescuento']), "text");
$tipo = sqlValue(mb_strtoupper($_POST['tipoDes']), "text");
$cantidad = sqlValue(mb_strtoupper($_POST['cantidadDes']), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO  catalogo_descuentos (nombre_des, tipo_des,descuento_des, usuario_des, fecha_des)";
 $sql.= "VALUES ($concepto,$tipo,$cantidad,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>