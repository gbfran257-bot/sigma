<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int");
 $idE = sqlValue($_POST["idE"], "int"); //en venta de conceptos
 
mysql_select_db($database_horizonte, $horizonte);
$result1 = mysql_query("SELECT p.nombre_p, p.apaterno_p, p.amaterno_p, DATE_FORMAT(p.fNac_p,'%d/%c/%Y'), s.cat_sexo, p.fNac_p from pacientes p left join catalogo_sexos s on s.id_sexo = p.sexo_p where p.id_p = $idP ", $horizonte) or die (mysql_error());
$row1 = mysql_fetch_row($result1);

mysql_select_db($database_horizonte, $horizonte);
$result2 = mysql_query("SELECT v.referencia_vc, v.id_concepto_es, v.nota_radiologo_vc, DATE_FORMAT(v.fecha_venta_vc,'%d/%c/%Y'), v.usuarioEdo4_e, v.id_personal_medico_vc, s.nombre_su, v.contador_vc, v.usuarioEdo4_e from venta_conceptos v left join sucursales s on s.id_su = v.id_sucursal_vc where v.id_vc = $idE ", $horizonte) or die (mysql_error());
$row2 = mysql_fetch_row($result2);
$claveE = sqlValue($row2[1], "int");
$ref = sqlValue($row2[0], "text");
$idUautoriza = sqlValue($row2[4], "int");
$idUmedico = sqlValue($row2[5], "int");

$lista = ''; $k = 0; $lista1 = ''; $k1 = 0;
mysql_select_db($database_horizonte, $horizonte);
$consultaM = "SELECT m.metodo_me from asignar_metodo am left join bases b on b.aleatorio_b = am.aleatorio_ame left join asignar_bases ab on ab.id_base_ab = b.id_b left join metodos m on m.id_me = am.id_metodo_ame where ab.id_estudio_ab = $claveE group by am.id_metodo_ame ";
$query = mysql_query($consultaM) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) {
	if($k==0){
		$lista = $fila['metodo_me'];
	}else{
		$lista = $lista.','.$fila['metodo_me'];	
	}
	$k++;
};//echo $lista;

mysql_select_db($database_horizonte, $horizonte);
$consultaM1 ="SELECT m.muestra_mu from asignar_muestra am left join bases b on b.aleatorio_b = am.aleatorio_am left join asignar_bases ab on ab.id_base_ab = b.id_b left join muestras m on m.id_mu = am.id_muestra_am where ab.id_estudio_ab = $claveE group by am.id_muestra_am ";
$query1 = mysql_query($consultaM1) or die (mysql_error());
while ($fila1 = mysql_fetch_array($query1)) {
	if($k1==0){
		$lista1 = $fila1['muestra_mu'];
	}else{
		$lista1 = $lista1.','.$fila1['muestra_mu'];	
	}
	$k1++;
};//echo $lista;

mysql_select_db($database_horizonte, $horizonte);
$result4d = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, id_u, sexo_u, titulo_u from usuarios where id_u = $idUautoriza ", $horizonte) or die (mysql_error());
$row4d = mysql_fetch_row($result4d);
$quimicoAutoriza = $row4d[0]." ".$row4d[1]." ".$row4d[2];

mysql_select_db($database_horizonte, $horizonte);
$result4d1 = mysql_query("SELECT nombre_u, apaterno_u, amaterno_u, cedulaProfesional_u, id_u, sexo_u, titulo_u from usuarios where id_u = $idUmedico ", $horizonte) or die (mysql_error());
$row4d1 = mysql_fetch_row($result4d1);
$miMedico = $row4d1[0]." ".$row4d1[1]." ".$row4d1[2];

mysql_select_db($database_horizonte, $horizonte);
$result3 = mysql_query("SELECT concepto_to, id_area_to from conceptos where id_to = $claveE ", $horizonte) or die (mysql_error());
$row3 = mysql_fetch_row($result3);
$areaE = sqlValue($row3[1], "int");

mysql_select_db($database_horizonte, $horizonte);
$result4 = mysql_query("SELECT nombre_a from areas where id_a = $areaE ", $horizonte) or die (mysql_error());
$row4 = mysql_fetch_row($result4);

mysql_select_db($database_horizonte, $horizonte);
$result5 = mysql_query("SELECT observaciones_l_ov from orden_venta where referencia_ov = $ref ", $horizonte) or die (mysql_error());
$row5 = mysql_fetch_row($result5);

mysql_select_db($database_horizonte, $horizonte);
$result6 = mysql_query("SELECT count(id_vc) from venta_conceptos where estatus_vc = 2 and referencia_vc = $ref and tipo_concepto_vc = 3", $horizonte) or die (mysql_error());
$row6 = mysql_fetch_row($result6);

$fecha1 = new DateTime($row1[5]); $fecha2 = new DateTime(date("Y-m-d H:i:s")); $fecha = $fecha1->diff($fecha2);
//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
if($anos>0){$row1[5]=$anos." AÑOS";}
if($anos<1){
	if($meses<=2 and $meses>=1){$row1[5]=$meses." MES(ES) ".$dias." DÍA(S)";}
	if($meses>=3){$row1[5]=$meses." MES(ES) ";}
	if($meses==0){$row1[5]=$dias." DÍA(S)";}
	if($meses==0 and $dias<=1){$row1[5]=$dias." DÍA(S) ".$horas." HORA(S)";}
	if($meses==0 and $dias<1){$row1[5]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
} 
if($anos>150 or $anos<0){$row1[5]="DESCONOCIDA";}else{}

mysql_select_db($database_horizonte, $horizonte);
$result7 = mysql_query("SELECT count(id_vc) from venta_conceptos where referencia_vc = $ref and tipo_concepto_vc = 3", $horizonte) or die (mysql_error());
$row7 = mysql_fetch_row($result7);

mysql_select_db($database_horizonte, $horizonte);
$result8 = mysql_query("SELECT min(contador_vc), max(contador_vc) from venta_conceptos where referencia_vc = $ref and tipo_concepto_vc = 3", $horizonte) or die (mysql_error());
$row8 = mysql_fetch_row($result8);

if($row8[0]>1){
	$razon = $row8[1] - $row8[0];
	$nome = $row2[7] - $razon;
}else{$nome = $row2[7];}
  
echo $row1[0].' '.$row1[1].' '.$row1[2].'*}'.$row2[0].'*}'.$row3[0].'*}'.$row4[0].'*}'.$row5[0].'*}'.$row6[0].'*}'.$row4[0].'*}'.$areaE.'*}'.$row2[2].'*}'.$row1[3].'*}'.$row1[4].'*}'.$row1[5].'*}'.$row2[3].'*}'.$miMedico.'*}'.$quimicoAutoriza.'*}'.$row4d[3].'*}'.$lista1.'*}'.$lista.'*}'.$row4d[6].'*}'.$row2[6].'*}'.$nome.' DE '.$row7[0].'*}'.$row2[8].".png";
//Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>