<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int"); $i = 0; $f = 0; $idU = sqlValue($_GET["idU"], "int"); $filillas = 0; $filillasm = 0;
  
$tabla = '<table width="100" border="0" cellspacing="6" cellpadding="4" style="text-align:left;">
			<tr> <td colspan="1" style="font-weight:bold;">MICROORGANISMO AISLADO:</td> <td colspan="5"></td> </tr>
			';
			mysql_select_db($database_horizonte, $horizonte);
			$consultam = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_valor_texto, r.r_boleano_rl, b.base_b from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc and b.base_b like '%_MIORG' and r.boleano_rl = 1 order by r.id_rl asc ";
			$querym = mysql_query($consultam) or die (mysql_error());
			while ($filam = mysql_fetch_array($querym)) {//$fila['convenio_cv'];
				//Para el tipo TEXTO
				$filillasm++; $nameMi = explode("_MIORG", $filam['base_b']);
				$tabla = $tabla.'
				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="1" nowrap>'.ucfirst(strtolower($nameMi[0])).'</td><td></td>
					<td colspan="1" align="left" nowrap>'.$filam['r_valor_texto'].' '.$filam['valor_texto_rl'].'</td>
					<td colspan="1">&nbsp;</td><td width="200"></td>
				</tr>
				';
				//Fin para el tipo TEXTO
			};
			if($filillasm==0){//No procede
				$tabla = $tabla.'<tr> <td colspan="6">NO HUBO DESARROLLO BACTERIANO A LAS 48 HORAS DE INCUBACIÓN.</td> </tr>';
			}
			$tabla=$tabla.'
			<tr> <td colspan="1" style="font-weight:bold;"><br><br>ANTIBIOGRAMA:</td> <td colspan="5"></td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_valor_texto, r.r_boleano_rl, b.base_b from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc and b.base_b like '%_MIANTI' and r.r_valor_texto is not null order by r.id_rl asc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) {//$fila['convenio_cv'];
	//Para el tipo TEXTO
	if($fila['id_cvr']==1){ $filillas++; $nameAn = explode("_MIANTI", $fila['base_b']);
		$tabla = $tabla.'
		<tr>
		<td colspan="1">&nbsp;</td>
		<td colspan="1" nowrap>'.$nameAn[0].'</td>
		<td colspan="1">&nbsp;</td>
		<td colspan="1" nowrap>'.$fila['r_valor_texto'].'</td><td width="1">'.$asterix.'</td><td></td>
		</tr>
		';
	}
	//Fin para el tipo TEXTO
};
if($filillas==0){//No procede
	$tabla = $tabla.'<tr> <td colspan="6">NO PROCEDE.<br><br><br><br><br><br><br><br><br><br><br><br><br></td> </tr>';
}
/*if($filillas==1){$espacios = 'height="480"';}
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
else{$espacios = '';}*/$espacios = 'height="105"';

if($f>0){
	$tabla = $tabla.'
		<tr> <td '.$espacios.' valign="top" nowrap colspan="6" style="font-size:0.2em; font-style:italic;" id="notaF">
<em>NOTA: <strong>*</strong> SIGNIFICA VALOR FUERA DE RANGO</em></td> </tr>';
}else{$tabla = $tabla.'
	<tr><td colspan="6"><br><br>&nbsp;</td></tr>
	<tr> <td nowrap colspan="6" style="font-size:0.2em; font-style:italic;" id="notaF"><hr style=" height:1px;">
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