<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0; $f = 0; 
  
$tabla = '<table width="100%" height="" border="0" cellspacing="1" cellpadding="4" style="text-align:left;" class="table table-condensed table-bordered"> <thead><tr align="center" class="bg-primary">
		<th>EXAMEN FÍSICO</th> <th>RESULTADO</th> <th nowrap>VALORES DE REFERENCIA</th> <th>UNIDADES</th> </tr> </thead>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_rango_rl, r.r_vmaximo_rl, r.r_vminimo_rl, r.r_valor_estable_rl, r.r_valor_texto, r.r_boleano_rl, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto, r.r_valor_nma_rl from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) { $i++;
	$name1 = explode("_EGO", $fila['base_b']);
	
	//Para el tipo TEXTO
	if($fila['id_cvr']==1){
		if($fila['r_valor_texto']!=$fila['valor_texto_rl']){
			if( $i==1 or $i==2 or $i==3 or $i==7 or $i==8 or $i==14 or $i==15 or $i==16 or $i==17 or $i==18 or $i==19 or $i==20 and $i==21 or $i==22 or $i==23){
				$clase = '';
			}else{
				$clase = 'bg-danger'; $f++;
			}
		}	
		else{$asterix = '';}
		$tabla = $tabla.'
		<tr> <td nowrap>'.$name1[0].'</td>
		<td align="right" nowrap class="'.$clase.'">'.$fila['r_valor_texto'].' </td>
		';
		if($i==1 or $i==2 or $i==3 or $i==7 or $i==8 or $i==12 or $i==14){
			$tabla=$tabla.'
			<td align="center"> - </td>
			<td align="right" style="display:;"> - </td> </tr>
			';
		}else{
			if($i==15 or $i==16 or $i==17 or $i==18 or $i==19 or $i==20 or $i==21 or $i==22 or $i==23){
				$tabla=$tabla.'<td align="center"> - </td>';
			}else{$tabla=$tabla.'<td align="center">'.$fila['valor_texto_rl'].'</td>';}

			$tabla=$tabla.'<td align="right" style="display:;"> '.$fila['abreviacion_un'].' </td>';
			
			$tabla=$tabla.'</tr>';	
		}
		
		if($i==3){
			$tabla = $tabla.'<tr align="center" class="bg-primary">
		<td>EXAMEN QUÍMICO</td> <td>RESULTADO</td> <td align="center" nowrap>VALORES DE REFERENCIA</td> <td align="right">UNIDADES</td> </tr>';
		}
		
		if($i==14){
			$tabla = $tabla.'<tr align="center" class="bg-primary">
		<td>EXAMEN MICROSCÓPICO</td> <td width="" align="right">RESULTADO</td> <td align="center" nowrap>VALORES DE REFERENCIA</td> <td align="right" style="display:;">UNIDADES</td> </tr>';
		}
	}
	//Fin para el tipo TEXTO
	
	//Para el tipo POSITIVO-NEGATIVO
	if($fila['id_cvr']==2){
		if($fila['boleano_rl']==1){ $bol = 'POSITIVO';}else{ $bol = 'NEGATIVO'; }
		if($fila['r_boleano_rl']==1){ $filita = 'POSITIVO';}else{ $filita = 'NEGATIVO'; }
		
		if($filita!=$bol){
			$clase = 'bg-danger'; $f++;
		}else{$clase = '';}
		
		$tabla = $tabla.'
		<tr> <td nowrap>'.$name1[0].'</td>
		<td align="right" nowrap> 
			'.$asterix.' '.$filita.'
		</td>
		<td align="center">'.$bol.'</td>';
		
		if($i==12){$tabla=$tabla.'<td align="right" style="display:;"> - </td>';
		}else{$tabla=$tabla.'<td align="right" style="display:;"> '.$fila['abreviacion_un'].' </td>';}
		
		$tabla=$tabla.'</tr>';
	}
	//Fin para el tipo TEPOSITIVO-NEGATIVO
	
	//Para el tipo RANGO
	if($fila['id_cvr']==3){
		if($fila['r_rango_rl'] < $fila['numero1_rango_rl'] or $fila['r_rango_rl'] > $fila['numero2_rango_rl']){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		$tabla = $tabla.'
		<tr> <td nowrap>'.$name1[0].'</td>
		<td align="right" nowrap class="'.$clase.'">'.$fila['r_rango_rl'].'</td>
		<td align="center">
			<table width="" border="0" cellspacing="1" cellpadding="2">
			  <tr>
				<td width="1px"></td>
				<td> '.$fila['numero1_rango_rl'].' </td>
				<td width="1px"> - </td>
				<td> '.$fila['numero2_rango_rl'].' </td>
			  </tr>
			</table>
		</td>
		<td align="right" style="display:;"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO
	
	//Para el tipo VALOR MAXIMO
	if($fila['id_cvr']==5){
		if($fila['r_vmaximo_rl'] > $fila['valor_maximo_rl']){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		$tabla = $tabla.'
		<tr> <td nowrap>'.$name1[0].'</td>
		<td align="right" nowrap class="'.$clase.'">'.$fila['r_vmaximo_rl'].'</td>
		<td align="center"> <= '.$fila['valor_maximo_rl'].' </td>
		<td align="right" style="display:;"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MAXIMO
	
	//Para el tipo VALOR MINIMO
	if($fila['id_cvr']==6){
		if($fila['r_vminimo_rl'] < $fila['valor_minimo_rl']){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		$tabla = $tabla.'
		<tr> <td nowrap>'.$name1[0].'</td>
		<td align="right" nowrap class="'.$clase.'">'.$fila['r_vminimo_rl'].'</td>
		<td align="center"> >= '.$fila['valor_minimo_rl'].' </td>
		<td align="right" style="display:;"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo VALOR MINIMO
	
	//Para el tipo RANGO +-
	if($fila['id_cvr']==7){
		if( $fila['r_valor_estable_rl'] < ($fila['valor_estable_rl']-$fila['valor_variable_rl']) or $fila['r_valor_estable_rl'] > ($fila['valor_estable_rl']+$fila['valor_variable_rl']) ){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		$tabla = $tabla.'
		<tr> <td nowrap>'.$name1[0].'</td>
		<td align="right" nowrap class="'.$clase.'">'.$fila['r_valor_estable_rl'].'</td>
		<td align="center">
			<table width="" border="0" cellspacing="1" cellpadding="2">
			  <tr>
				<td> '.$fila['valor_estable_rl'].' </td>
				<td width="5px">+-</td>
				<td> '.$fila['valor_variable_rl'].' </td>
			  </tr>
			</table>
		</td>
		<td align="right" style="display:;"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo RANGO +-
	
	//Para el tipo NORMAL,MODERADO,ALTO
	if($fila['id_cvr']==8){
		if( $fila['r_valor_nma_rl'] > ($fila['r_valor_r1_moderado']) or $fila['r_valor_nma_rl'] > ($fila['r_valor_alto']) ){$clase = 'bg-danger'; $f++;}else{$clase = '';}
		$tabla = $tabla.'
		<tr> <td nowrap>'.$name1[0].'</td>
		<td align="right" nowrap class="'.$clase.'">'.$fila['r_valor_nma_rl'].'</td>
		<td align="center">
			<table width="" border="0" cellspacing="1" cellpadding="3" style="text-align:right;">
			  <tr>
				<td width="80px">NORMAL < </td>
				<td align="center">
					'.$fila['r_valor_normal'].'
				</td>
			  </tr>
			  <tr>
				<td width="80px">MODERADO</td>
				<td align="center">
					'.$fila['r_valor_r1_moderado'].' - '.$fila['r_valor_r2_moderado'].'
				</td>
			  </tr>
			  <tr>
				<td width="80px">ALTO > </td>
				<td align="center">
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

if($f>0){
	$tabla = $tabla.'<tr> <td nowrap colspan="4" id="notaF"><hr style=" height:1px;"><em>NOTA: <strong>*</strong> SIGNIFICA VALOR FUERA DE RANGO</em> </td> </tr>';
}else{$tabla = $tabla.'<tr> <td nowrap colspan="4" id="notaF"><hr style=" height:1px;"></td> </tr>';}

$tabla = $tabla.'</table>';

echo $tabla;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>