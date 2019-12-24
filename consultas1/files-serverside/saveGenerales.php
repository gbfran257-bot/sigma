<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["idC"], "int");
 $peso = sqlValue($_POST["peso"], "double");
 $talla = sqlValue($_POST["talla"], "double");
 $imc = sqlValue($_POST["imc"], "double");
 $t = sqlValue($_POST["t"], "int");
 $a = sqlValue($_POST["a"], "int");
 $fr = sqlValue($_POST["fr"], "int");
 $fc = sqlValue($_POST["fc"], "int");
 $temp = sqlValue($_POST["temp"], "double");
 $motivo = sqlValue($_POST["motivo"], "text");
 $nota = sqlValue($_POST["nota"], "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE consultas SET peso_con = $peso, talla_con = $talla, imc_con = $imc, t_con = $t, a_con = $a, fr_con = $fr, fc_con = $fc, temp_con = $temp, motivo_consulta_con = $motivo, nota_general_con = $nota where id_con = $idC ";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) {
 	echo $sql;
 }else{ 
	echo "ok";
 }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>