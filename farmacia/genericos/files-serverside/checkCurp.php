<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$curpP = sqlValue($_POST["curpP"], "text");
$idP = sqlValue($_POST["idP"], "int");

mysql_select_db($database_horizonte, $horizonte);
if($_POST["idP"]!=NULL or $_POST["idP"]!=''){
$result1 = mysql_query("SELECT COUNT(id_p) from pacientes where curp_p = $curpP and id_p != $idP ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1); $c=0;
}else{
	$result1 = mysql_query("SELECT COUNT(id_p) from pacientes where curp_p = $curpP ", $horizonte) or die (mysql_error());
	$row1 = mysql_fetch_row($result1); $c=1;
}
//si alguien que no sea este productor tiene el crup
if($row1[0]>0){ echo 'false'; }//si nadie lo tiene
else{ echo 'true'; }

mysql_close($horizonte);
?>