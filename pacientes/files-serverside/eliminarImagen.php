<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idImg =$_POST['id'];
mysql_select_db($database_horizonte, $horizonte);
$sql = "SELECT ext_do FROM documentos WHERE id_do = $idImg";
$ext = mysql_query($sql, $horizonte) or die (mysql_error());
$extF = mysql_fetch_row($ext);

mysql_select_db($database_horizonte, $horizonte);
$sql = "DELETE FROM documentos WHERE id_do = $idImg";
$update = mysql_query($sql, $horizonte) or die (mysql_error());

if(!$update) { 
    echo $sql; 
}else{ 
    unlink("../documentos/fotos/".$idImg.".".$extF[0]);
	echo 1; 
}