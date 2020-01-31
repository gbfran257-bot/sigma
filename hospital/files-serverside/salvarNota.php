<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idC = sqlValue($_POST["idC"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 $notaDictamen = sqlValue($_POST["notaDictamen"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $idP = sqlValue($_POST["idP"], "int");
 $idN = sqlValue($_POST["idN"], "int");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "insert into notas_de_hospital (nota_nh, id_hospitalizacion_nh, id_nota_nh, usuario_nh, fecha_nh, tipo_nota_nh, id_sv_nh) VALUES($notaDictamen, $idC, $idN, $idU, $now,1,0)";
 $update = mysql_query($sql, $horizonte) or die (mysql_error());

 if (!$update) { echo $sql; } else{ echo 1; }

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>