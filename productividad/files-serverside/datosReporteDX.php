<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 //fecha inicial
 mysql_select_db($database_horizonte, $horizonte);
 $result = mysql_query("select min(date_format(fecha_venta_ov,'%d/%m/%Y')), fecha_venta_ov from orden_venta order by fecha_venta_ov asc limit 1", $horizonte) or die (mysql_error());
 $row = mysql_fetch_row($result); //$f1 = '"'.$row[0].'"'; echo $f1;
 
 mysql_select_db($database_horizonte, $horizonte);
 $result0 = mysql_query("select min(fecha_venta_ov) from orden_venta where fecha_venta_ov is not NULL order by fecha_venta_ov asc limit 1", $horizonte) or die (mysql_error());
 $row0 = mysql_fetch_row($result0); //echo $row0[0];
 
 //dias transcurridos
 mysql_select_db($database_horizonte, $horizonte);
 $result1 = mysql_query("select DATEDIFF(now(),'$row0[0]') from orden_venta ", $horizonte) or die (mysql_error());
 $row1 = mysql_fetch_row($result1);
 
 //total de consultas
 mysql_select_db($database_horizonte, $horizonte);
 $result1z = mysql_query("select count(id_vc) from venta_conceptos where tipo_concepto_vc = 1 and temporal_vc = 0", $horizonte) or die (mysql_error());
 $row1z = mysql_fetch_row($result1z);
 
 $avance = $row1z[0];
 
 //total de dx dados
 mysql_select_db($database_horizonte, $horizonte);
 $result2 = mysql_query("select count(id_dxc) from dx_consultas where temp_dxc = 0 ", $horizonte) or die (mysql_error());
 $row2 = mysql_fetch_row($result2);
 
 //total de ingresos
 mysql_select_db($database_horizonte, $horizonte);
 $result3 = mysql_query("select sum(gran_total_ov) from orden_venta where 1 = 1 ", $horizonte) or die (mysql_error());
 $row3 = mysql_fetch_row($result3);
 
 //total de consultas
 mysql_select_db($database_horizonte, $horizonte);
 $result4 = mysql_query("select count(id_vc) from venta_conceptos where tipo_concepto_vc = 1 and temporal_vc = 0", $horizonte) or die (mysql_error());
 $row4 = mysql_fetch_row($result4);
 
 //total de estudios de laboratorios
 mysql_select_db($database_horizonte, $horizonte);
 $result4a = mysql_query("select count(id_vc) from venta_conceptos where tipo_concepto_vc = 3 and temporal_vc = 0", $horizonte) or die (mysql_error());
 $row4a = mysql_fetch_row($result4a);
 
 //total de estudios de imagen
 mysql_select_db($database_horizonte, $horizonte);
 $result4b = mysql_query("select count(id_vc) from venta_conceptos where tipo_concepto_vc = 4 and temporal_vc = 0", $horizonte) or die (mysql_error());
 $row4b = mysql_fetch_row($result4b);
 
 //total de servicios
 mysql_select_db($database_horizonte, $horizonte);
 $result4c = mysql_query("select count(id_vc) from venta_conceptos where tipo_concepto_vc = 2 and temporal_vc = 0", $horizonte) or die (mysql_error());
 $row4c = mysql_fetch_row($result4c);
 
 //promedio pacientes por día
 $row5 = round($row1z[0]/$row1[0],2);
 
 //Promedio ordenes de venta por día
 $row6 = round($row2[0]/$row1[0],2);
 
 //Total igreso por día
 $row7 = round($row3[0]/$row1[0],2);
 
 //Total consultas por día
 $row7a = round($row4[0]/$row1[0],2);
 
 //Total estudios laboratorio por día
 $row7b = round($row4a[0]/$row1[0],2);
 
 //Total estudios imagen por día
 $row7c = round($row4b[0]/$row1[0],2);
 
 //Total servicios por día
 $row7d = round($row4c[0]/$row1[0],2);
 
 //Total fuera de rango hombres hipertensos
 mysql_select_db($database_horizonte, $horizonte);
 $result8 = mysql_query("select count(id_ov) from orden_venta where usuario_ov = 1 ", $horizonte) or die (mysql_error());
 $row8 = mysql_fetch_row($result8);

 //Total posibles ultrasonidos
 mysql_select_db($database_horizonte, $horizonte);
 $result9 = mysql_query("select count(id_ov) from orden_venta where usuario_ov = 1 ", $horizonte) or die (mysql_error());
 $row9 = mysql_fetch_row($result9);
 
 //Porcentaje posibles ultras
 if($row1[0]!=0){ $PPU = round(($row1z[0]*1)/$row1[0],2);}else{$PPU = 0;}//$PPU =111;
 //Porcentaje total fuera de Rango
 if($row1[0]!=0){ $PTFR = round(($row2[0]*1)/$row1[0],2);}else{$PTFR = 0;}//$PTFR =111;
 //Total Hipertensos fuera de rango
 $Thipertensos = 111;
 //%Total Hipertensos fuera de rango
 if($row1[0]!=0){
 $PTH = ($row6[0]*100)/$row1[0];}else{$PTH = 0;}$PTH = 111;
 //%Total dislipidemicos fuera de rango
 if($row1[0]!=0){
 $PTD = ($row7[0]*100)/$row1[0];}else{$PTD = 0;}$PTD =111;
 //%Total diabéticos fuera de rango
 if($row1[0]!=0){
 $PTDi = ($row8[0]*100)/$row1[0];}else{$PTDi = 0;}$PTDi =111;
 
 //%Total Hipertensos
 if($row1[0]!=0){
 $PTH1 = ($row2[0]*100)/$row1[0];}else{$PTH1 = 0;}$PTH1 =111;
 //%Total dislipidemicos
 if($row1[0]!=0){
 $PTD1 = ($row3[0]*100)/$row1[0];}else{$PTD1 = 0;}$PTD1 = 111;
 //%Total diabéticos
 if($row1[0]!=0){
 $PTDi1 = ($row4[0]*100)/$row1[0];}else{$PTDi1 = 0;}$PTDi1 = 111;
	
 echo $row[0].";".$row1[0].";".$avance.";".$row2[0].";".$PPU.";".$PTFR.";".$row4a[0].";".$row4b[0].";".$row4c[0].";".$row5.";".$row6.";".$row7.";".$row7a.";".$row7b.";".$row7c.";".$row7d.";".$row8[0].";".$PTDi.";".$PTH1.";".$PTD1.";".$PTDi1.";".$row9[0].";".$PPU;

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>