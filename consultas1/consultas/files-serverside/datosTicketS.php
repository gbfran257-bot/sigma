<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

//Generales
 $idPaciente = sqlValue($_POST["idPaciente"], "int");
 $claveE = sqlValue($_POST["claveS"], "text");

 mysql_select_db($database_horizonte, $horizonte); 
 $resultR = mysql_query("SELECT referencia_ov from orden_venta where id_paciente_ov = $idPaciente ORDER BY fecha_venta_ov desc limit 1 ", $horizonte);
 $rowR = mysql_fetch_row($resultR);

 mysql_select_db($database_horizonte, $horizonte); //sacamos el precio del Estudio
 $resultC = mysql_query("SELECT precio_vc from venta_conceptos where referencia_vc = '$rowR[0]' and tipo_concepto_vc = 2 and clave_concepto_es = $claveE ", $horizonte);
 $rowC = mysql_fetch_row($resultC);
 
 mysql_select_db($database_horizonte, $horizonte); //nombre del Estudio
 $resultCA = mysql_query("SELECT nombre_serv from servicios where clave_serv = $claveE ", $horizonte);
 $rowCA = mysql_fetch_row($resultCA);
 
 $adicionales = $rowC[0].";*".$rowCA[0];
 
 echo $adicionales;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>