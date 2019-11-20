<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0; $f = 0; $idU = sqlValue($_GET["idU"], "int"); $filillas = 0;
  
$tabla = '<table id="p_contenido" width="100" border="0" cellspacing="6" cellpadding="4" style="text-align:left;"> <tr style="font-weight:bold;">
		<td width="260">DETERMINACION</td> <td width="170" align="left">RESULTADO</td> <td width="210" align="center">VALORES DE REFERENCIA</td> <td width="">UNIDADES</td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_rango_rl, r.r_vmaximo_rl, r.r_vminimo_rl, r.r_valor_estable_rl, r.r_valor_texto, r.r_boleano_rl, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto, r.r_valor_nma_rl, r.r_valor_normal_i, r.r_valor_r1_moderado_i, r.r_valor_r2_moderado_i, r.r_valor_alto_i, r.r_valor_nma_i_rl from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc order by r.id_rl asc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) {//$fila['convenio_cv'];
	//Para el tipo TEXTO
	if($fila['id_cvr']==1){ $filillas++;
		if($fila['r_valor_texto']!=$fila['valor_texto_rl']){
			$asterix = '<strong>*</strong>'; $f++;
		}	
		else{$asterix = '';}
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			'.$asterix.' '.$fila['r_valor_texto'].'
		</td>
		<td align="center">'.$fila['valor_texto_rl'].'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEXTO
	
	//Para el tipo POSITIVO-NEGATIVO
	if($fila['id_cvr']==2){ $filillas++;
		if($fila['boleano_rl']==1){ $bol = 'POSITIVO';
		}else{ $bol = 'NEGATIVO'; }
		if($fila['r_boleano_rl']==1){ $filita = 'POSITIVO';
		}else{ $filita = 'NEGATIVO'; }
		
		if($filita!=$bol){
			$asterix = '<strong>*</strong>'; $f++;
		}else{$asterix = '';}
		
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			  '.$asterix.' '.$filita.'
		</td>
		<td align="center">'.$bol.'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEPOSITIVO-NEGATIVO
	
	//Para el tipo RANGO
	if($fila['id_cvr']==3){ $filillas++;
		if($fila['r_rango_rl'] < $fila['numero1_rango_rl'] or $fila['r_rango_rl'] > $fila['numero2_rango_rl']){$asterix = '<strong>*</strong>'; $f++;}else{$asterix = '';}
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			'.$asterix.' '.$fila['r_rango_rl'].'
		</td>
		<td align="center">
			'.$fila['numero1_rango_rl'].' A '.$fila['numero2_rango_rl'].'
		</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO
	
	//Para el tipo VALOR MAXIMO
	if($fila['id_cvr']==5){ $filillas++;
		if($fila['r_vmaximo_rl'] > $fila['valor_maximo_rl']){$asterix = '<strong>*</strong>'; $f++;}else{$asterix = '';}
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			'.$asterix.' '.$fila['r_vmaximo_rl'].'
		</td>
		<td align="center"> '.$fila['valor_maximo_rl'].' </td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MAXIMO
	
	//Para el tipo VALOR MINIMO
	if($fila['id_cvr']==6){ $filillas++;
		if($fila['r_vminimo_rl'] < $fila['valor_minimo_rl']){$asterix = '<strong>*</strong>'; $f++;}else{$asterix = '';}
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			'.$asterix.' '.$fila['r_vminimo_rl'].'
		</td>
		<td align="center"> '.$fila['valor_minimo_rl'].' </td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MINIMO
	
	//Para el tipo RANGO +-
	if($fila['id_cvr']==7){ $filillas++;
		if( $fila['r_valor_estable_rl'] < ($fila['valor_estable_rl']-$fila['valor_variable_rl']) or $fila['r_valor_estable_rl'] > ($fila['valor_estable_rl']+$fila['valor_variable_rl']) ){$asterix = '<strong>*</strong>'; $f++;}else{$asterix = '';}
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			'.$asterix.' '.$fila['r_valor_estable_rl'].'
		</td>
		<td align="center">
			'.$fila['valor_estable_rl'].' +- '.$fila['valor_variable_rl'].'
		</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO +-
	
	//Para el tipo NORMAL,MODERADO,ALTO
	if($fila['id_cvr']==8){ $filillas++;
		if( $fila['r_valor_nma_rl'] > ($fila['r_valor_normal']) ){$asterix = '<strong>*</strong>'; $f++;}else{$asterix = '';}
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			'.$asterix.' '.$fila['r_valor_nma_rl'].'
		</td>
		<td align="center">
			NORMAL &#60; '.$fila['r_valor_normal'].'<br>
			MODERADO '.$fila['r_valor_r1_moderado'].' - '.$fila['r_valor_r2_moderado'].'<br>
			ALTO &#62; '.$fila['r_valor_alto'].'
		</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo NORMAL,MODERADO,ALTO
	//Para el tipo NORMAL,MODERADO,ALTO inverso
	if($fila['id_cvr']==9){ $filillas++;
		if( $fila['r_valor_nma_i_rl'] <= ($fila['r_valor_normal_i']) ){$asterix = '<strong>*</strong>'; $f++;}else{$asterix = '';}
		$tabla = $tabla.'
		<tr> 
		<td>'.$fila['base_b'].'</td>
		<td align="left">
			'.$asterix.' '.$fila['r_valor_nma_i_rl'].'
		</td>
		<td align="center">
			NORMAL &#62; '.$fila['r_valor_normal_i'].'<br>
			MODERADO '.$fila['r_valor_r1_moderado_i'].' - '.$fila['r_valor_r2_moderado_i'].'<br>
			ALTO &#60; '.$fila['r_valor_alto_i'].'
		</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo NORMAL,MODERADO,ALTO inverso
};
if($filillas==1){$espacios = 'height="480"';}
else if($filillas==2){$espacios = 'height="455"';}
else if($filillas==3){$espacios = 'height="430"';}
else if($filillas==4){$espacios = 'height="405"';}
else if($filillas==5){$espacios = 'height="380"';}
else if($filillas==6){$espacios = 'height="355"';}
else if($filillas==7){$espacios = 'height="330"';}
else if($filillas==8){$espacios = 'height="305"';}
else if($filillas==9){$espacios = 'height="280"';}
else if($filillas==10){$espacios = 'height="255"';}
else if($filillas==11){$espacios = 'height="230"';}
else if($filillas==12){$espacios = 'height="205"';}
else if($filillas==13){$espacios = 'height="180"';}
else if($filillas==14){$espacios = 'height="155"';}
else if($filillas==15){$espacios = 'height="130"';}
else if($filillas==16){$espacios = 'height="105"';}
else{$espacios = '';}

if($f>0){
	$tabla = $tabla.'<tr> <td '.$espacios.' valign="top" nowrap colspan="4" style="font-size:0.2em; font-style:italic;" id="notaF"><hr style=" height:1px;">
<em>NOTA: <strong>*</strong> SIGNIFICA VALOR FUERA DE RANGO</em></td> </tr>';
}else{$tabla = $tabla.'<tr> <td nowrap colspan="4" style="font-size:0.2em; font-style:italic;" id="notaF"><hr style=" height:1px;">
</td> </tr>';}

$tabla = $tabla.'</table>';
$tabla1 = sqlValue($tabla, "text");

 mysql_select_db($database_horizonte, $horizonte);
 $sqlX = "UPDATE usuarios SET variable_temporal_u = $tabla1 where id_u = $idU limit 1";
 $updateX = mysql_query($sqlX, $horizonte) or die (mysql_error());
	
 if(!$updateX){ echo $sqlX; }else{ echo $tabla; }
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>