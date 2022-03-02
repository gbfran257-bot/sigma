<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");


$clave = sqlValue(trim(mb_strtoupper($_POST["clave"])), "text");
$descripcion = sqlValue(trim(mb_strtoupper($_POST["descripcion"])), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

if($_POST["iva"] =='excento'){
    $excento = 1;
    $iva= 0;
}else{
    $excento = 0;
    $iva = sqlValue($_POST["iva"], "int");
}

 mysql_select_db($database_horizonte, $horizonte);
    $sql = "INSERT INTO  catalogo_sat (clave_sat, descripcion_sat, iva, excento, id_usuario_sat, fecha_sat)";
    $sql.= "VALUES ($clave,$descripcion,$iva,$excento,$idU,$now)";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if(!$update){echo $sql;} else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>
