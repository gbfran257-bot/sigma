<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int");$i = 0;
  
$tabla = '<table width="100%" border="0" cellspacing="1" cellpadding="4" style="text-align:left;"> <tr style="background-color:#FF6633; color:white;" align="center">
		<td>DETERMINACION</td> <td>TIPO DE VR</td> <td width="200px">RESULTADO</td> <td>VALORES DE REFERENCIA</td> <td>UNIDADES</td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) { $i++;
	$name1 = explode("_EGO", $fila['base_b']);
	
	//Para el tipo TEXTO
	if($fila['id_cvr']==1){
		$tabla = $tabla.'
		<tr> 
		<td>'.$name1[0].'</td>
		<td align="center">'.$fila['tipo_cvr'].'</td>
		<td align="center">';
			if($name1[0]=='ASPECTO'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="TRANSPARENTE" selected>TRANSPARENTE</option>
				  		<option value="LIGERAMENTE TURBIO">LIGERAMENTE TURBIO</option>
						<option value="TURBIO">TURBIO</option>
						<option value="HEMORRAGICO">HEMORRAGICO</option>
					</select>
				';
			}else if($name1[0]=='COLOR'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="AMARILLO">AMARILLO</option>
				  		<option value="AMARILLO CLARO" selected>AMARILLO CLARO</option>
						<option value="AMARILLO OSCURO">AMARILLO OSCURO</option>
						<option value="ANARANJADO">ANARANJADO</option>
						<option value="ANARANJADO OSCURO">ANARANJADO OSCURO</option>
						<option value="MARRON">MARRON</option>
						<option value="ROJIZO">ROJIZO</option>
						<option value="ROSADO">ROSADO</option>
						<option value="AMBAR">AMBAR</option>
					</select>
				';
			}
			else if($name1[0]=='OLOR'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NORMAL" selected>NORMAL</option>
				  		<option value="FETIDO">FETIDO</option>
					</select>
				';
			}
			else if($name1[0]=='GLUCOSA'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="50.0">50.0</option>
						<option value="100.0">100.0</option>
						<option value="300.0">300.0</option>
						<option value="500.0">500.0</option>
						<option value="1000.0">1000.0</option>
						<option value="2000.0">2000.0</option>
					</select>
				';
			}
			else if($name1[0]=='BILIRRUBINA'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
						<option value="1.0">1.0</option>
						<option value="2.0">2.0</option>
						<option value="4.0">4.0</option>
					</select>
				';
			}
			else if($name1[0]=='CETONAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
						<option value="5.0">5.0</option>
						<option value="15.0">15.0</option>
						<option value="40.0">40.0</option>
						<option value="80.0">80.0</option>
						<option value="160.0">160.0</option>
					</select>
				';
			}
			else if($name1[0]=='DENSIDAD'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="1.000">1.000</option>
				  		<option value="1.005" selected>1.005</option>
						<option value="1.010">1.010</option>
						<option value="1.015">1.015</option>
						<option value="1.020">1.020</option>
						<option value="1.025">1.025</option>
						<option value="1.030">1.030</option>
					</select>
				';
			}
			else if($name1[0]=='PH'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="5.0" selected>5.0</option>
				  		<option value="5.5">5.5</option>
						<option value="6.0">6.0</option>
						<option value="6.5">6.5</option>
						<option value="7.0">7.0</option>
						<option value="7.5">7.5</option>
						<option value="8.0">8.0</option>
						<option value="8.5">8.5</option>
						<option value="9">9</option>
					</select>
				';
			}
			else if($name1[0]=='SANGRE'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50.</option>
						<option value="250">250</option>
					</select>
				';
			}
			else if($name1[0]=='PROTEINAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
						<option value="15.0">15.0</option>
						<option value="30.0">30.0</option>
						<option value="100.0">100.0</option>
						<option value="300.0">300.0</option>
						<option value="2000.0">2000.0</option>
					</select>
				';
			}
			else if($name1[0]=='UROBILINOGENO'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NORMAL">NORMAL</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
						<option value="0.2" selected>0.2</option>
						<option value="1.0">1.0</option>
						<option value="2.0">2.0</option>
						<option value="4.0">4.0</option>
						<option value="8.0">8.0</option>
						<option value="12.0">12.0</option>
					</select>
				';
			}
			else if($name1[0]=='LEUCOCITOS' and $i ==13){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
						<option value="15.0">15.0</option>
						<option value="25.0">25.0</option>
						<option value="70.0">70.0</option>
						<option value="125.0">125.0</option>
						<option value="500.0">500.0</option>
					</select>
				';
			}
			else if($name1[0]=='SEDIMENTO'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NULO">NULO</option>
						<option value="ESCASO" selected>ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
					</select>
				';
			}
			else if($name1[0]=='CELULAS EPITELIALES'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
					</select>
				';
			}
			else if($name1[0]=='CELULAS RENALES'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
					</select>
				';
			}
			else if($name1[0]=='FILAMENTO DE MUCINA'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
					</select>
				';
			}
			else if($name1[0]=='LEVADURAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
					</select>
				';
			}
			else if($name1[0]=='CILINDROS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="0 - 1">0 - 1</option>
						<option value="0 - 2">0 - 2</option>
						<option value="1 - 3">1 - 3</option>
						<option value="3- 5">3- 5</option>
					</select>
				';
			}
			else if($name1[0]=='ERITROCITOS'){
				$tabla = $tabla.'<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required" style="text-align:center;"onKeyUp="conMayusculas(this);" value="NEGATIVO">';
			}
			else if($name1[0]=='BACTERIAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
					</select>
				';
			}
			else if($name1[0]=='LEUCOCITOS'){
				$tabla = $tabla.'<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required" style="text-align:center;"onKeyUp="conMayusculas(this);" value="NEGATIVO">';
			}
			else if($name1[0]=='CRISTALES'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
				  		<option value="NEGATIVO" selected>NEGATIVO</option>
				  		<option value="ESCASO">ESCASO</option>
						<option value="MODERADO">MODERADO</option>
						<option value="ABUNDANTE">ABUNDANTE</option>
					</select>
				';
			}
			else{
				$tabla = $tabla.'
					<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="campoITtab required" style="text-align:center;"onKeyUp="conMayusculas(this);">
				';
			}
		$tabla = $tabla.'</td>
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
		<td>'.$name1[0].'</td>
		<td align="center">'.$fila['tipo_cvr'].'</td>
		<td align="center">
			<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="required">
			  <option value="1">POSITIVO</option>
			  <option value="0" selected>NEGATIVO</option>
			</select>
		</td>
		<td align="center">'.$bol.'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo POSITIVO-NEGATIVO
};

$tabla = $tabla.'</table>';

echo $tabla;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>