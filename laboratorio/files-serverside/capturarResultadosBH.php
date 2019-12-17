<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0;
  
$tabla = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;" class="table-condensed table-bordered"> <tr align="center" class="bg-primary">
		<td>FÓRMULA ROJA</td> <td width="" align="">RESULTADO</td> <td align="center" nowrap>VALORES DE REFERENCIA</td> <td align="right">UNIDADES</td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_rango_rl, r.r_vmaximo_rl, r.r_vminimo_rl, r.r_valor_estable_rl, r.r_valor_texto, r.r_boleano_rl, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto, r.r_valor_nma_rl from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) { $i++;

	//Para el tipo RANGO
	if($fila['id_cvr']==3){
		if($fila['r_rango_rl'] < $fila['numero1_rango_rl'] or $fila['r_rango_rl'] > $fila['numero2_rango_rl']){$asterix = '<strong>*</strong>';}else{$asterix = '';}
		if($fila['base_b']=='PLAQUETAS'){
		$tabla = $tabla.'
		<tr><td align="right">Sumatoria</td><td align="right"><span id="sumatoria"></span></td><td></td><td></td></tr>
		<tr> <td nowrap style="font-weight:bold;">'.$fila['base_b'].'</td>
		<td align="right" nowrap>
			<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm diezyseis" style="text-align:center;" required>
		</td>
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
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
		}else{
		$tabla = $tabla.'
		<tr> <td nowrap>'.$fila['base_b'].'</td>
		<td align="right">';
		if($i == 2 or $i == 5 or $i == 6 or $i == 15){
			if($i == 2){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm salto donas" style="text-align:center;" readonly value="CÁLCULO AUTOMÁTICO" required onFocus="salto(2);">';
			}else if($i == 5){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm salto cinco" style="text-align:center;" readonly value="CÁLCULO AUTOMÁTICO" required onFocus="salto(5);">';
			}else if($i == 6){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm salto seis" style="text-align:center;" readonly value="CÁLCULO AUTOMÁTICO" required onFocus="salto(6);">';
			}else if($i == 15){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm salto quince" style="text-align:center;" readonly value="CÁLCULO AUTOMÁTICO" required onFocus="salto(15);">';
			}
		}
		else{
			if($i == 1){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm uno" style="text-align:center;" required onKeyUp="hgm();">';
			}else if($i == 3){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm nosalto tripas" style="text-align:center;" required onKeyUp="hemato(); hgm(); cmhg();">';
			}else if($i == 4){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm cuatro" style="text-align:center;" required onKeyUp="hemato(); cmhg();">';
			}else if($i == 7){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm nosalto siete" style="text-align:center;" required>';
			}else if($i == 9){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm nueve" style="text-align:center;" required onKeyUp="sumatoria();">';
			}else if($i == 10){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm diez" style="text-align:center;" required onKeyUp="sumatoria();">';
			}else if($i == 11){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm once" style="text-align:center;" required onKeyUp="sumatoria();">';
			}else if($i == 12){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm doce" style="text-align:center;" required onKeyUp="sumatoria();">';
			}else if($i == 13){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm trece" style="text-align:center;" required onKeyUp="neutrofilos(); sumatoria();">';
			}else if($i == 14){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm catorce" style="text-align:center;" required onKeyUp="neutrofilos(); sumatoria();">';
			}else if($i == 16){
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm nosalto" style="text-align:center;" required>';
			}else{
				$tabla = $tabla.'
				<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" style="text-align:center;" required>';
			}
		}
		$tabla = $tabla.'
		</td>
		<td align="center">
		';
		if($i>8 and $i <15){
			$tabla = $tabla.'
			% DE LEUCOCITOS
			</td>
			<td align="right"> '.'%'.' </td> </tr>
			';
		}else if($i == 15){ 
			$tabla = $tabla.' 
				SEGMENTADOS + BANDA
				</td>
				<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>'; 
		}
		else{
			$tabla = $tabla.'
			<table width="" border="0" cellspacing="1" cellpadding="2">
			  <tr>
				<td width="1px"></td>
				<td> '.$fila['numero1_rango_rl'].' </td>
				<td width="1px"> - </td>
				<td> '.$fila['numero2_rango_rl'].' </td>
			  </tr>
			</table>
			</td>
			<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>';
		}
	}
		
		if($i==7){
			$tabla = $tabla.'<tr class="bg-primary">
		<td>FÓRMULA BLANCA</td> <td width="" align="center">RESULTADO</td> <td align="center" nowrap>VALORES DE REFERENCIA</td> <td align="right">UNIDADES</td> </tr>';
		}
	}
	//Fin para el tipo RANGO
	
};

$tabla = $tabla.'</table>';

echo $tabla;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>