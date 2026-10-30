<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$id = sqlValue($_GET["id"], "int");
 	
     mysql_select_db($database_horizonte, $horizonte);
     $sql1= "SELECT temporal_u FROM usuarios where id_u = $id";
     $update1 = mysql_query($sql1, $horizonte) or die (mysql_error());
     $rowT = mysql_fetch_row($update1);

     $tempo = sqlValue($rowT[0], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$sql2 = "SELECT id_do, ext_do FROM documentos where  perfil_do = 1 and aleatorio_do = $tempo and usuario_do = $id";
	$update2 = mysql_query($sql2, $horizonte) or die (mysql_error());
	$rowSe = mysql_fetch_row($update2);

	if(!$update1){echo $sql1; }else{
        echo $rowSe[0].'.'.$rowSe[1];
	}
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>