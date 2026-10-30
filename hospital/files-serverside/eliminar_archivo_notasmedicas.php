<?php
 require("../../Connections/horizonte.php");
 require("../../funciones/php/values.php");
 
 $id_consulta = sqlValue($_POST["id_consulta"], "int");
 
 //eliminamos el archivo pdf/img del servidor
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT archivo_notas_medicas FROM notas_de_hospital WHERE id_nh = " . $id_consulta, $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result);
 
 $carpeta = "../archivos_notas_medicas/".$row[0];
 
 unlink($carpeta);
 
 //actualizamos el registro para borrar el enlace del archivo
 mysql_select_db($database_horizonte, $horizonte);
 $query_upd_archivoConsultas = "UPDATE notas_de_hospital SET archivo_notas_medicas = '0' WHERE id_nh = $id_consulta LIMIT 1"; 
 $execute_query_mmg = mysql_query($query_upd_archivoConsultas, $horizonte) or die (mysql_error());
 
 if($execute_query_mmg){
     echo 1;
 }
 
 mysql_close($horizonte);
 ?>