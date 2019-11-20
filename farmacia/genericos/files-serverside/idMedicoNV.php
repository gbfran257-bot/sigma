<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idM = sqlValue($_POST["idM"], "text");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultR = mysql_query("SELECT id_u from usuarios where clave_u = $idM limit 1 ", $horizonte) or die (mysql_error());
 $rowR = mysql_fetch_row($resultR);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultRu = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, clave_u, especialidad_u, precio_consulta_u, comision_consulta_u, idDepartamento_u, idArea_u, idPuesto_u from usuarios where id_u = $rowR[0] ", $horizonte) or die (mysql_error());
 $rowRu = mysql_fetch_row($resultRu);
 
 $idEspecialidad = sqlValue($rowRu[4], "int");
 $idPuesto = sqlValue($rowRu[9], "int");
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultEu = mysql_query("SELECT nombre_especialidad from especialidades where id_es = $idEspecialidad ", $horizonte) or die (mysql_error());
 $rowEu = mysql_fetch_row($resultEu);
 
 mysql_select_db($database_horizonte, $horizonte); 
 $resultPu = mysql_query("SELECT nombre_cp from catalogo_puestos where id_cp = $idPuesto ", $horizonte) or die (mysql_error());
 $rowPu = mysql_fetch_row($resultPu);
 
 $cadena = $rowR[0].";".$rowRu[0]." ".$rowRu[1]." ".$rowRu[2].";".$rowRu[3].";".$rowEu[0].";".$rowRu[5].";".$rowRu[6].";".$rowRu[7].";".$rowRu[8].";".$rowPu[0];
 
 echo $cadena;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>