<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0;
  
$tabla = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;" class="table-condensed table-bordered"> <tr align="center" class="bg-primary">
		<td>DETERMINACION</td> <td>TIPO DE VR</td> <td width="200px">RESULTADO</td> <td>VALORES DE REFERENCIA</td> <td>UNIDADES</td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) { $i++;
	$name1 = explode("_COPRO", $fila['base_b']);
	
	if( $i == 1){ 
		$name1[0] = $name1[0].' (1M)';
	}else if($i==2){
		$name1[0] = $name1[0].' (2M)';
	}else{
		$name1[0] = $name1[0].' (3M)';
		$i = 0;
	}
	
	//Para el tipo TEXTO
	if($fila['id_cvr']==1){
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required style="text-align:center;"onKeyUp="conMayusculas(this);">
		</td>
		<td align="center">'.$fila['valor_texto_rl'].'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEXTO
	
	//Para el tipo POSITIVO-NEGATIVO
	if($fila['id_cvr']==2){
		if($fila['boleano_rl']==1){$bol = 'POSITIVO';}else{$bol='NEGATIVO';}
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td>'.$fila['tipo_cvr'].'</td>
		<td>
			<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
			  <option value="">-SELECCIONAR</option>
			  <option value="1">POSITIVO</option>
			  <option value="0">NEGATIVO</option>
			</select>
		</td>
		<td align="center">'.$bol.'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEPOSITIVO-NEGATIVO
	
	//Para el tipo RANGO
	if($fila['id_cvr']==3){
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required style="text-align:center;">
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
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO
	
	//Para el tipo VALOR MAXIMO
	if($fila['id_cvr']==5){
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td>'.$fila['tipo_cvr'].'</td>
		<td>
		<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required style="text-align:center;">
		</td>
		<td> '.$fila['valor_maximo_rl'].' </td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MAXIMO
	
	//Para el tipo VALOR MINIMO
	if($fila['id_cvr']==6){
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required style="text-align:center;">
		</td>
		<td> '.$fila['valor_minimo_rl'].' </td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MINIMO
	
	//Para el tipo RANGO +-
	if($fila['id_cvr']==7){
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required  style="text-align:center;">
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
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO +-
	
	//Para el tipo NORMAL,MODERADO,ALTO
	if($fila['id_cvr']==8){
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td>'.$fila['tipo_cvr'].'</td>
		<td>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required  style="text-align:center;">
		</td>
		<td>
			<table width="" border="0" cellspacing="0" cellpadding="2" style="text-align:left;">
			  <tr>
				<td width="5px">NORMAL < </td>
				<td>
					'.$fila['r_valor_normal'].'
				</td>
			  </tr>
			  <tr>
				<td width="5px">MODERADO</td>
				<td>
					'.$fila['r_valor_r1_moderado'].' - '.$fila['r_valor_r2_moderado'].'
				</td>
			  </tr>
			  <tr>
				<td width="5px">ALTO > </td>
				<td>
					'.$fila['r_valor_alto'].'
				</td>
			  </tr>
			</table>
		</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo NORMAL,MODERADO,ALTO
};

$tabla = $tabla.'</table>';

echo $tabla;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>