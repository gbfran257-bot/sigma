<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idPx1"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $peso = sqlValue($_POST["peso"], "double");
 $talla = sqlValue($_POST["talla"], "double");
 $cintura = sqlValue($_POST["cintura"], "double");
 $imc = sqlValue($_POST["imc"], "double");
 $t = sqlValue($_POST["t"], "int");
 $a = sqlValue($_POST["a"], "int");
 $fr = sqlValue($_POST["fr"], "int");
 $fc = sqlValue($_POST["fc"], "int");
 $temp = sqlValue($_POST["temp"], "double");
 $notas = sqlValue($_POST["notas"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");

 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO signos_vitales (id_paciente_sv, id_usuario_sv, fecha_sv, peso_sv, talla_sv, imc_sv, cintura_sv, t_sv, a_sv, fr_sv, fc_sv, temperatura_sv, notas_sv)";
 $sql.= "VALUES ($idP, $idU, $now, $peso, $talla, $imc, $cintura, $t, $a, $fr, $fc, $temp, $notas )";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) { echo $sql; }else{  echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>