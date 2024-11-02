<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idE = sqlValue($_POST["idE"], "int");
 
mysql_select_db($database_horizonte, $horizonte);
  
	$result = mysql_query("SELECT observaciones_vc, id_paciente_vc from venta_conceptos where id_vc = $idE limit 1", $horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	$result1 = mysql_query("SELECT nombre_p, apaterno_p, amaterno_p from pacientes where id_p = $row[1] limit 1", $horizonte) or die (mysql_error());
 	$row1 = mysql_fetch_row($result1);

	//obtenemos datos extra
	$result_mas_datos = mysql_query("SELECT p.fNac_p, cs.cat_sexo, DATE_FORMAT(p.fNac_p,'%d/%m/%Y') FROM pacientes p LEFT JOIN catalogo_sexos cs ON cs.id_sexo = p.sexo_p WHERE id_p = $row[1] limit 1", $horizonte) or die (mysql_error());
 	$mas_datos = mysql_fetch_row($result_mas_datos);

	//obtenemos la edad
	$fecha1 = new DateTime($mas_datos[0]); 
	$fecha2 = new DateTime(date("Y-m-d H:i:s")); 
	$fecha = $fecha1->diff($fecha2);
	$anos=$fecha->y; $meses=$fecha->m; $dias=$fecha->d; $horas=$fecha->h; $minutos=$fecha->i; $segundos=$fecha->s;
	$edad = "";
	if($anos>0){
		$edad=$anos." AÑOS";
	}
	if($anos<1){
		if($meses<=2 and $meses>=1){$edad=$meses." MES(ES) ".$dias." DÍA(S)";}
		if($meses>=3){$edad=$meses." MES(ES) ";}
		if($meses==0){$edad=$dias." DÍA(S)";}
		if($meses==0 and $dias<=1){$edad=$dias." DÍA(S) ".$horas." HORA(S)";}
		if($meses==0 and $dias<1){$edad=$horas." HORA(S) ".$minutos." MINUTO(S)";}
	} 
	if($anos>150 or $anos<0){$edad="DESCONOCIDA";}
	
	$paciente = $row1[0].' '.$row1[1].' '.$row1[2];
	$datosExtra = " - SEXO: " . $mas_datos[1] . " - F. NAC: " . $mas_datos[2] . " - EDAD: " . $edad;
	
	$resultK=mysql_query("SELECT imagen_ie from img_ultrasonido where id_estudio_vc_ie = $idE order by id_ie desc limit 1", $horizonte) or die (mysql_error());
 	$rowK = mysql_fetch_row($resultK); if ($rowK[0]==''){$rowK[0]=0;}
  
echo 'PACIENTE: '.$paciente.$datosExtra.'*[+'.$rowK[0];

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>