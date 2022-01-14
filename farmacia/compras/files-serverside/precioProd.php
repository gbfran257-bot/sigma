<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

// $idU = sqlValue($_POST['idU'],"int");
$idProd = sqlValue($_POST['prod'],"int"); 
// $costoVal = sqlValue($_POST['costoVal'],"int"); 


mysql_select_db($database_horizonte, $horizonte);
$resultR = mysql_query("SELECT concepto_to, precio_to from conceptos where id_to = $idProd ", $horizonte) or die(mysql_error());
$rowR = mysql_fetch_row($resultR);

echo $rowR[0]."}{[_}".$rowR[1];
?>