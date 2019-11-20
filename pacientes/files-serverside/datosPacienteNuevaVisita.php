<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idP = sqlValue($_POST["idP"], "int"); $idSucursal = NULL;
 if(isset($_POST["idU"])){$idU=sqlValue($_POST["idU"], "int");
 	mysql_select_db($database_horizonte, $horizonte);
 	$resultS = mysql_query("SELECT idSucursal_u from usuarios where id_u = $idU ", $horizonte) or die (mysql_error());
 	$rowS = mysql_fetch_row($resultS);
	$idSucursal = $rowS[0];
 }

 	mysql_select_db($database_horizonte, $horizonte);
 	$result = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p, fNac_p, sexo_p, id_p, indice_p, idSucursal_p, foto_p, id_p, temporal_p from pacientes where id_p = $idP ", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result); $temp_u = sqlValue($row[10], "text");
	
	mysql_select_db($database_horizonte, $horizonte);
 	$resultEx1 = mysql_query("SELECT ext_do from documentos where nombre_do = $temp_u and que_es_do = 'FOTO' ", $horizonte) or die (mysql_error());
 	$rowEx1 = mysql_fetch_row($resultEx1);
	
	$nombre = $row[0]." ".$row[1]." ".$row[2];
	$sexo='';
	if ($row[4]==1){$sexo = 'MUJER';} if ($row[4]==2){$sexo = 'HOMBRE';}
	
	$fecha1 = new DateTime($row[3]);
	$fecha2 = new DateTime(date("Y-m-d H:i:s"));
	$fecha = $fecha1->diff($fecha2);
	//printf('%d AÑOS %d MESES %d DÍAS %d HORAS %d MINUTOS', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
	$anos=$fecha->y;
	$meses=$fecha->m;
	$dias=$fecha->d;
	$horas=$fecha->h;
	$minutos=$fecha->i;
	if($anos>0){$row[3]=$anos." AÑOS";}
	if($anos<1){
		if($meses<=2 and $meses>=1){$row[3]=$meses." MES(ES) ".$dias." DÍA(S)";}
		if($meses>=3){$row[3]=$meses." MES(ES) ";}
		if($meses==0){$row[3]=$dias." DÍA(S)";}
		if($meses==0 and $dias<=1){$row[3]=$dias." DÍA(S) ".$horas." HORA(S)";}
		if($meses==0 and $dias<1){$row[3]=$horas." HORA(S) ".$minutos." MINUTO(S)";}
	} 
	if($anos>150 or $anos<0){$row[3]="DESCONOCIDA";}
	
	$edad = $row[3];
	
	echo $nombre.";".$edad.";".$sexo.";".$row[5].";".$row[6].";".$row[7].";".$idSucursal.";".$row[8].";".$row[9].";".$rowEx1[0].";".$row[10];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>