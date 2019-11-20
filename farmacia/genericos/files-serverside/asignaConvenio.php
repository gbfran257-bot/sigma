<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

//datos generales
 list( $dia, $mes, $ano ) = explode( "/", sqlValue($_POST['fechaIC'], "date") ); $raya = "-"; $fI = $ano.$raya.$mes.$raya.$dia;
 list( $dia1, $mes1, $ano1 ) = explode( "/", sqlValue($_POST['fechaFC'], "date") ); $raya1 = "-"; $fF = $ano1.$raya1.$mes1.$raya1.$dia1;

 $idU = sqlValue($_POST["idU_AC"], "int");
 $idP = sqlValue($_POST["idP_AC"], "int");
 $idC = sqlValue($_POST["idC_AC"], "int");
 $fI = sqlValue($fI, "date");
 $fF = sqlValue($fF, "date");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO convenios_paciente (id_paciente_cvp, id_convenio_cvp, fecha_expedicion_cvp, fecha_expiracion_cvp, usuario_cvp, fecha_cvp)";
 $sql.= "VALUES ($idP, $idC, $fI, $fF, $idU, now() )";
  
 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	
 if (!$update) {echo $sql;}
 else{
	mysql_select_db($database_horizonte, $horizonte);
 	$resultX=mysql_query("SELECT MAX(id_cvp) from convenios_paciente limit 1 ", $horizonte) or die (mysql_error());
 	$rowX = mysql_fetch_row($resultX); $idConvenio_paciente = sqlValue($rowX[0], "int");
	
	mysql_select_db($database_horizonte, $horizonte);
	$result = mysql_query("SELECT id_ac, infinito_ac, cantidad_ac from asigna_conceptos_convenios where id_convenio_ac = $idC", $horizonte) or die (mysql_error()); 
	
	while ( $row = mysql_fetch_row($result) ){ 	
		if($row[1]==''){$miInfinito = 0;}else{$miInfinito = $row[1];}
		$miInfinito = sqlValue($miInfinito, "int");
		
		if($miInfinito==1){$i=1;}else{$i=$row[2];}
		
		mysql_select_db($database_horizonte, $horizonte);
		$sqlZ = "INSERT INTO conceptos_beneficios (id_concepto_convenio_cb, id_convenio_paciente_cb, infinito_cb, id_paciente_cb, id_usuario_cb, fecha_cb)";
		$sqlZ.= "VALUES ($row[0], $idConvenio_paciente, $miInfinito, $idP, $idU, $now )";
		
		for($j=1;$j<=$i;$j++){ $updateZ = mysql_query($sqlZ, $horizonte) or die (mysql_error()); }
			
		if (!$updateZ) {echo $sqlZ;}
		else{}
	} 
 	echo 1; 
}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>