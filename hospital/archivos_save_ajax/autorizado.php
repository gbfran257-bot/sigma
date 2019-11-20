<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idEvc = sqlValue($_POST["idEstudioPro"], "int");
 $idP = sqlValue($_POST["idPacientePro"], "int");
 $idU = sqlValue($_POST["idUserPro"], "int");
 $nota = sqlValue($_POST["notaPro"], "text");
 $now = sqlValue(date('Y-m-d H:i:s'), "date");
 
 if(isset($_POST["refPro"])){$ref = sqlValue($_POST["refPro"], "text");}else{$ref = '';}
 if(isset($_POST["checaPro"])){$checaPro = sqlValue($_POST["checaPro"], "int");}else{$checaPro = '';}
 
mysql_select_db($database_horizonte, $horizonte);
	$sql = "UPDATE venta_conceptos SET estatus_vc = 7, usuarioEdo4_e = $idU, fechaEdo4_e = $now, nota_radiologo_vc = $nota where id_vc = $idEvc ";
  
$update = mysql_query($sql, $horizonte);
	
if (!$update) { echo $sql; }else { 
	//actualizamos los valores de los estudios de laboratorio
	mysql_select_db($database_horizonte, $horizonte);
	$consulta = "SELECT r.id_rl, t.id_cvr from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
	$query = mysql_query($consulta) or die (mysql_error());
	while ($fila = mysql_fetch_array($query)) { 
		//Para los de texto
		if($fila['id_cvr']==1){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "text");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_valor_texto = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de texto
		//Para los de POSITIVO-NEGATIVO
		if($fila['id_cvr']==2){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "int");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_boleano_rl = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de POSITIVO-NEGATIVO
		//Para los de RANGO
		if($fila['id_cvr']==3){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "double");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_rango_rl = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de RANGO
		//Para los de VALOR MAXIMO
		if($fila['id_cvr']==5){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "double");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_vmaximo_rl = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de VALOR MAXIMO
		//Para los de VALOR MÍNIMO
		if($fila['id_cvr']==6){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "double");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_vminimo_rl = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de VALOR MÍNIMO
		//Para los de VALOR ESTABLE
		if($fila['id_cvr']==7){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "double");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_valor_estable_rl = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de VALOR ESTABLE
		//echo $sqlV;
		//Para los de VALOR NORMAL,MODERADO,ALTO
		if($fila['id_cvr']==8){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "double");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_valor_nma_rl = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de VALOR NORMAL,MODERADO,ALTO
		//Para los de VALOR NORMAL,MODERADO,ALTO inverso
		if($fila['id_cvr']==9){
			$miID = $fila['id_rl'];
			$value = sqlValue($_POST[$miID], "double");
			
			mysql_select_db($database_horizonte, $horizonte);
			$sqlV = "UPDATE resultados_laboratorio SET r_valor_nma_i_rl = $value where id_rl = $miID limit 1 "; 
			$updateV = mysql_query($sqlV, $horizonte);
		}
		//Fin para los de VALOR NORMAL,MODERADO,ALTO inverso
	}//FIn while
}

echo 1;

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>