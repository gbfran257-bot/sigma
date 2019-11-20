<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_POST["idE"], "int");
  
$tabla = '<table width="100%" border="0" cellspacing="1" cellpadding="4"> <tr style="background-color:#FF6633; color:white;">
		<td>TIPO DE VR</td> <td width="200px">RESULTADO</td> <td>VALORES DE REFERENCIA</td> <td>UNIDADES</td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_rango_rl, r.r_vmaximo_rl, r.r_vminimo_rl, r.r_valor_estable_rl, r.r_valor_texto, r.r_boleano_rl from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) {//$fila['convenio_cv'];
	//Para el tipo TEXTO
	if($fila['id_cvr']==1){
		$tabla = $tabla.'
		<tr> <td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required" style="text-align:center;" value="'.$fila['r_valor_texto'].'">
		</td>
		<td>'.$fila['valor_texto_rl'].'</td>
		<td> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEXTO
	
	//Para el tipo POSITIVO-NEGATIVO
	if($fila['id_cvr']==2){
		if($fila['boleano_rl']==1){
			$bol = 'POSITIVO';
			$filita = '<option value="1" selected>POSITIVO</option><option value="0">NEGATIVO</option>';
		}else{
			$bol = 'NEGATIVO';
			$filita = '<option value="1">POSITIVO</option><option value="0" selected>NEGATIVO</option>';
		}
		$tabla = $tabla.'
		<tr> <td>'.$fila['tipo_cvr'].'</td>
		<td>
			<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
			  <option value="">-SELECCIONAR</option>
			  '.$filita.'
			</select>
		</td>
		<td>'.$bol.'</td>
		<td> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEPOSITIVO-NEGATIVO
	
	//Para el tipo RANGO
	if($fila['id_cvr']==3){
		$tabla = $tabla.'
		<tr> <td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required" style="text-align:center;" value="'.$fila['r_rango_rl'].'">
		</td>
		<td>
			<table width="" border="0" cellspacing="1" cellpadding="2">
			  <tr>
				<td width="1px">DE</td>
				<td>
					'.$fila['numero1_rango_rl'].'
				</td>
				<td width="1px">A</td>
				<td>
					'.$fila['numero2_rango_rl'].'
				</td>
			  </tr>
			</table>
		</td>
		<td> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO
	
	//Para el tipo VALOR MAXIMO
	if($fila['id_cvr']==5){
		$tabla = $tabla.'
		<tr> <td>'.$fila['tipo_cvr'].'</td>
		<td>
		<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required" style="text-align:center;" value="'.$fila['r_vmaximo_rl'].'">
		</td>
		<td> '.$fila['valor_maximo_rl'].' </td>
		<td> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MAXIMO
	
	//Para el tipo VALOR MINIMO
	if($fila['id_cvr']==6){
		$tabla = $tabla.'
		<tr> <td>'.$fila['tipo_cvr'].'</td>
		<td>
		<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required" style="text-align:center;" value="'.$fila['r_vminimo_rl'].'">
		</td>
		<td> '.$fila['valor_minimo_rl'].' </td>
		<td> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MINIMO
	
	//Para el tipo RANGO +-
	if($fila['id_cvr']==7){
		$tabla = $tabla.'
		<tr> <td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required"  style="text-align:center;" value="'.$fila['r_valor_estable_rl'].'">
		</td>
		<td>
			<table width="" border="0" cellspacing="1" cellpadding="2">
			  <tr>
				<td>
					'.$fila['valor_estable_rl'].'
				</td>
				<td width="5px">+-</td>
				<td>
					'.$fila['valor_variable_rl'].'
				</td>
			  </tr>
			</table>
		</td>
		<td> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO +-
};

$tabla = $tabla.'</table>';

echo $tabla;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>