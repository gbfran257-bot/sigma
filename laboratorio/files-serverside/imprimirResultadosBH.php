<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0; $leuco = 0; $f = 0; $idU = sqlValue($_GET["idU"], "int");
  
$tabla = '<table id="p_contenido" width="100" border="0" cellspacing="6" cellpadding="3" style="text-align:left;"> <tr style="font-weight:bold;">
		<td width="250">FÓRMULA ROJA</td> <td width="1%"></td> <td width="90" align="right">RESULTADO</td> <td width="1"></td> <td width="230" align="center" nowrap>VALORES DE REFERENCIA</td> <td width="80" align="right">UNIDADES</td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_rango_rl, r.r_vmaximo_rl, r.r_vminimo_rl, r.r_valor_estable_rl, r.r_valor_texto, r.r_boleano_rl, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto, r.r_valor_nma_rl, round(r.r_rango_rl,0) as roro from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) { $i++;
	
	if($i==8){$leuco = $fila['r_rango_rl'];}
	//Para el tipo RANGO
	if($fila['id_cvr']==3){
		if($fila['r_rango_rl'] < $fila['numero1_rango_rl'] or $fila['r_rango_rl'] > $fila['numero2_rango_rl']){
			$asterix = '<strong>*</strong>'; $f++;
		}else{$asterix = '';}
		
		if($i>8 and $i<16){
			if( (($fila['r_rango_rl']*$leuco)/100) < $fila['numero1_rango_rl'] or (($fila['r_rango_rl']*$leuco)/100) > $fila['numero2_rango_rl']){
				$asterix = '<strong>* </strong>'; $f++;
			}else{$asterix = '';}	
		}
		
		if($fila['base_b']=='PLAQUETAS'){
			$tabla = $tabla.'
			<tr> <td nowrap style="font-weight:bold;">'.$fila['base_b'].'</td>
			<td></td>
			<td align="right">'.$fila['r_rango_rl'].'</td><td>'.$asterix.'</td>
			<td align="center">'.$fila['numero1_rango_rl'].' - '.$fila['numero2_rango_rl'].'
			</td>
			<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
			';
		}
		else{
			if($i>8 and $i < 16){
				$hb = (($fila['r_rango_rl']*$leuco)/100);
				$porcen = round($fila['r_rango_rl'],1).'%';
			}else{
				$hb = $fila['r_rango_rl'];
				$porcen = '';
			}
			$tabla = $tabla.'
				<tr> <td nowrap>'.$fila['base_b'].'</td>
				<td align="right">'.$porcen.'</td>
				<td align="right">'.$hb.'</td><td>'.$asterix.'</td>
				<td align="center">'.$fila['numero1_rango_rl'].' - '.$fila['numero2_rango_rl'].'</td>
				<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
				';
		}
	
		if($i==7){
			$tabla = $tabla.'<tr style="font-weight:bold;">
		<td>FÓRMULA BLANCA</td> <td></td> <td width="" align="right">RESULTADO</td> <td></td> <td align="center" nowrap>VALORES DE REFERENCIA</td> <td align="right">UNIDADES</td> </tr>';
		}
	}
		//Fin para el tipo RANGO
};

if($f>0){
	$tabla = $tabla.'<tr> <td nowrap colspan="6" style="font-size:0.2em; font-style:italic;" id="notaF"><hr style=" height:1px;">
<em>NOTA: <strong>*</strong> SIGNIFICA VALOR FUERA DE RANGO</em> </td> </tr>';
}else{$tabla = $tabla.'<tr> <td nowrap colspan="6" style="font-size:0.2em; font-style:italic;" id="notaF"><hr style=" height:1px;">
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