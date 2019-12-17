<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int");  $i = 0; $f = 0;
  
$tabla = '<table width="100%" height="" border="0" cellspacing="1" cellpadding="4" style="text-align:left;" class="table table-condensed table-bordered"> <thead><tr align="center" class="bg-primary">
		<th>DETERMINACION</th> <th>RESULTADO</th> <th>VALORES DE REFERENCIA</th> <th>UNIDADES</th> </tr> </thead>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_rango_rl, r.r_vmaximo_rl, r.r_vminimo_rl, r.r_valor_estable_rl, r.r_valor_texto, r.r_boleano_rl, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto, r.r_valor_nma_rl from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
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
		if($fila['r_valor_texto']!=$fila['valor_texto_rl']){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td class="'.$clase.'">'.$fila['r_valor_texto'].'</td>
		<td align="center">'.$fila['valor_texto_rl'].'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEXTO
	
	//Para el tipo POSITIVO-NEGATIVO
	if($fila['id_cvr']==2){
		if($fila['boleano_rl']==1){$bol = 'POSITIVO';}
		else{$bol = 'NEGATIVO';}
		if($fila['r_boleano_rl']==1){ $filita = 'POSITIVO';}
		else{ $filita = 'NEGATIVO'; }
		
		if($filita!=$bol){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td class="'.$clase.'">'.$filita.'</td>
		<td align="center">'.$bol.'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEPOSITIVO-NEGATIVO
	
	//Para el tipo RANGO
	if($fila['id_cvr']==3){
		if($fila['r_rango_rl'] < $fila['numero1_rango_rl'] or $fila['r_rango_rl'] > $fila['numero2_rango_rl']){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td class="'.$clase.'">'.$fila['r_rango_rl'].'</td>
		<td>DE '.$fila['numero1_rango_rl'].' A '.$fila['numero2_rango_rl'].'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO
	
	//Para el tipo VALOR MAXIMO
	if($fila['id_cvr']==5){
		if($fila['r_vmaximo_rl'] > $fila['valor_maximo_rl']){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td class="'.$clase.'">'.$fila['r_vmaximo_rl'].'</td>
		<td align="center"> < '.$fila['valor_maximo_rl'].' </td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MAXIMO
	
	//Para el tipo VALOR MINIMO
	if($fila['id_cvr']==6){
		if($fila['r_vminimo_rl'] < $fila['valor_minimo_rl']){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td class="'.$clase.'">'.$fila['r_vminimo_rl'].'</td>
		<td align="center"> > '.$fila['valor_minimo_rl'].' </td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MINIMO
	
	//Para el tipo RANGO +-
	if($fila['id_cvr']==7){
		if( $fila['r_valor_estable_rl'] < ($fila['valor_estable_rl']-$fila['valor_variable_rl']) or $fila['r_valor_estable_rl'] > ($fila['valor_estable_rl']+$fila['valor_variable_rl']) ){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td class="'.$clase.'">'.$fila['r_valor_estable_rl'].'</td>
		<td>'.$fila['valor_estable_rl'].' +- '.$fila['valor_variable_rl'].'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO +-
	
	//Para el tipo NORMAL,MODERADO,ALTO
	if($fila['id_cvr']==8){
		if( $fila['r_valor_nma_rl'] > ($fila['r_valor_r1_moderado']) or $fila['r_valor_nma_rl'] > ($fila['r_valor_alto']) ){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td align="left">'.$name1[0].'</td>
		<td class="'.$clase.'">'.$fila['r_valor_nma_rl'].'</td>
		<td>NORMAL < '.$fila['r_valor_normal'].' MODERADO '.$fila['r_valor_r1_moderado'].' - '.$fila['r_valor_r2_moderado'].' ALTO > '.$fila['r_valor_alto'].'</td>
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