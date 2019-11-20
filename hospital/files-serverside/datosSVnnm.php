<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
  
 mysql_select_db($database_horizonte, $horizonte); 
 $resultS = mysql_query("SELECT DATE_FORMAT(fecha_sv,'%d/%c/%Y %H:%i:%s'), id_usuario_sv, peso_sv, talla_sv, imc_sv, cintura_sv, t_sv, a_sv, fr_sv, fc_sv, temperatura_sv, id_sv from signos_vitales where id_paciente_sv = $idP order by id_sv desc limit 1", $horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS); $us_sv = sqlValue($rowS[1], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultUs = mysql_query("SELECT usuario_u from usuarios where id_u = $us_sv", $horizonte) or die (mysql_error());
 $rowUs = mysql_fetch_row($resultUs);
 
 echo $rowS[0].";*-".$rowUs[0].';*-'.$rowS[2].';*-'.$rowS[3].';*-'.$rowS[4].';*-'.$rowS[5].';*-'.$rowS[6].';*-'.$rowS[7].';*-'.$rowS[8].';*-'.$rowS[9].';*-'.$rowS[10].';*-'.$rowS[11];
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>