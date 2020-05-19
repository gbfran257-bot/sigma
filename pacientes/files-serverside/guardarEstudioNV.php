<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $noTemp = sqlValue($_POST["noAleatorio"], "text");
 $idP = sqlValue($_POST["idP"], "int");
 $idU = sqlValue($_POST["idU"], "int");
 if(isset($_POST["idMedico"])){$idMedico = sqlValue($_POST["idMedico"], "int");}else{$idMedico=0;}
 
 $idE = sqlValue($_POST["idE"], "int");
 mysql_select_db($database_horizonte, $horizonte); 
 $resultC = mysql_query("SELECT id_to, id_departamento_to, id_area_to, precio_to, id_tipo_concepto_to, aleatorio_c from conceptos where id_to = $idE ", $horizonte) or die (mysql_error());
 $rowC = mysql_fetch_row($resultC); $tempiU = sqlValue($rowC[5], "text");

 if($rowC[4]==1){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $resultMCt = mysql_query("SELECT id_u from usuarios where temporal_u = $tempiU ", $horizonte) or die (mysql_error());
	 $rowMCt = mysql_fetch_row($resultMCt);
	 
	 $idMedico = $rowMCt[0];
 }

 $idConvenio = sqlValue($_POST["idConvenio"], "int");
 if($_POST["idConvenio"]==''){$idConvenio=0;}
 $idDepartamento = sqlValue($rowC[1], "int");
 $idArea = sqlValue($rowC[2], "int");
 $idSucursal = sqlValue($_POST["idSucursal"], "int");
 $observaciones = sqlValue($_POST["observaciones"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 $precio = sqlValue($_POST["precioTo"], "double");
 if(empty($_POST["precio_original"]))
 	$precio_orig = $precio;
 else
 	$precio_orig = sqlValue($_POST["precio_original"], "double");
 $honor = sqlValue($_POST["honor"], "double");
 $tipoConcepto = sqlValue($_POST["tipoConcepto"], "int");
 $id_con_bene = sqlValue($_POST["id_con_bene"], "int");
 $ocupado = sqlValue($_POST["ocupado"], "int");
 
 if($_POST["agendar"]==1){ $fechaC = sqlValue($_POST["fechaC"], "text"); } else{ $fechaC = $now; }
 
 if($ocupado==0){
	 mysql_select_db($database_horizonte, $horizonte); 
	 $sql="INSERT INTO venta_conceptos(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,precio_original,honorarios,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios)";
	 $sql.="VALUES ($noTemp, $idP, $idU, $idMedico, $idE, $idConvenio, $observaciones, $fechaC, $precio, $precio_orig, $honor, $idU, $fechaC, $id_con_bene)";
	 
	 $sql_1="INSERT INTO venta_conceptos_1(no_temp_vc,id_paciente_vc,id_usuario_vc,id_personal_medico_vc,id_concepto_es,id_convenio_vc,observaciones_vc,fecha_venta_vc,precio_vc,usuarioEdo1_e,fechaEdo1_e,id_conceptos_beneficios)";
	 $sql_1.="VALUES ($noTemp, $idP, $idU, $idMedico, $idE, $idConvenio, $observaciones, $fechaC, $precio, $idU, $fechaC, $id_con_bene)";
	  
	 $update = mysql_query($sql, $horizonte) or die (mysql_error());
	 if (!$update) { echo $sql; }else{ 
	 	echo 1;
		
		$update_1 = mysql_query($sql_1, $horizonte) or die (mysql_error());
	 }
 }else{echo 1;}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
