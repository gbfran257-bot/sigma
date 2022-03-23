<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$fp = sqlValue(trim(mb_strtoupper($_POST["fp"])), "text");
// $descripcion = sqlValue(trim(mb_strtoupper($_POST["descripcion"])), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");


 mysql_select_db($database_horizonte, $horizonte);
    $sql = "INSERT INTO  catalogo_forma_pago (id_fp, forma_pago_fp, id_usuario_fp,fecha_fp)";
    $sql.= "VALUES (null,$fp,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>