<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

 $id_medi = sqlValue($_POST["id_medi"], "int");//Del medicamento comercial
 
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("SELECT m.id_medicamento_g, m.concepto_to, m.precio_to, m.precio_h, m.precio1_to, m.costo_maquila_to, m.codigo_barras_to, m.descripcion_to from conceptos m where m.id_to = $id_medi", $horizonte) or die(mysql_error());
 $row1 = mysql_fetch_row($result1); $id_medi_co = sqlValue($row1[0], "int");
  
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("SELECT m.nombre_generico_med, m.descripcion_med, m.cantidad_med, m.grupo_med, m.nivel_med, m.riesgo_embarazo_med, m.presentaciones_med, m.via_administracion_med, m.via_administracion_dosis_med, m.generalidades_med, m.interacciones_med, m.efectos_adversos_med, m.contraindicaciones_precauciones_med, r.texto_cre, m.id_med from medicamentos m left join cat_riesgo_embarazo r on r.cat_cre = m.riesgo_embarazo_med where m.id_med = $id_medi_co", $horizonte) or die(mysql_error());
 $row = mysql_fetch_row($result);
 
 echo $row[0].'}{[_}'.$row[1].'}{[_}'.$row[2].'}{[_}'.$row[3].'}{[_}'.$row[4].'}{[_}'.$row[5].'}{[_}'.$row[6].'}{[_}'.$row[7].'}{[_}'.$row1[7].'}{[_}'.$row[9].'}{[_}'.$row[10].'}{[_}'.$row[11].'}{[_}'.$row[12].'}{[_}'.$row[13].'}{[_}'.$row[14].'}{[_}'.$row1[1].'}{[_}'.$row1[2].'}{[_}'.$row1[3].'}{[_}'.$row1[4].'}{[_}'.$row1[5].'}{[_}'.$row1[6];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);

?>