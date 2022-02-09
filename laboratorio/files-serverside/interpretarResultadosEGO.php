<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int");$i = 0;
  
$tabla = '<table id="p_contenido" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-condensed table-bordered"> <tr align="center" class="bg-primary">
		<td>DETERMINACION</td> <td>TIPO DE VR</td> <td width="200px">RESULTADO</td> <td>VALORES DE REFERENCIA</td> <td>UNIDADES</td> </tr>';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, r.r_rango_rl, r.r_vmaximo_rl, r.r_vminimo_rl, r.r_valor_estable_rl, r.r_valor_texto, r.r_boleano_rl, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto, r.r_valor_nma_rl from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) { $i++;
	$name1 = explode("_EGO", $fila['base_b']);
	
	//Para el tipo TEXTO
	if($fila['id_cvr']==1){
		$tabla = $tabla.'
		<tr> 
		<td>'.$name1[0].'</td>
		<td align="">'.$fila['tipo_cvr'].'</td>
		<td align="center">';
			if($name1[0]=='ASPECTO'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='TRANSPARENTE'){$tabla = $tabla.'<option value="TRANSPARENTE" selected>TRANSPARENTE</option>';}else{$tabla = $tabla.'<option value="TRANSPARENTE">TRANSPARENTE</option>';}
				  		if($fila['r_valor_texto']=='LIGERAMENTE TURBIO'){$tabla = $tabla.'<option value="LIGERAMENTE TURBIO" selected>LIGERAMENTE TURBIO</option>';}else{$tabla = $tabla.'<option value="LIGERAMENTE TURBIO">LIGERAMENTE TURBIO</option>';}
				  		if($fila['r_valor_texto']=='TURBIO'){$tabla = $tabla.'<option value="TURBIO" selected>TURBIO</option>';}else{$tabla = $tabla.'<option value="TURBIO">TURBIO</option>';}
						if($fila['r_valor_texto']=='HEMORRAGICO'){$tabla = $tabla.'<option value="HEMORRAGICO" selected>HEMORRAGICO</option>';}else{$tabla = $tabla.'<option value="HEMORRAGICO">HEMORRAGICO</option>';}
					$tabla = $tabla.'</select>
				';
			}else if($name1[0]=='COLOR'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='AMARILLO'){$tabla = $tabla.'<option value="AMARILLO" selected>AMARILLO</option>';}else{$tabla = $tabla.'<option value="AMARILLO">AMARILLO</option>';}
						if($fila['r_valor_texto']=='AMARILLO CLARO'){$tabla = $tabla.'<option value="AMARILLO CLARO" selected>AMARILLO CLARO</option>';}else{$tabla = $tabla.'<option value="AMARILLO CLARO">AMARILLO CLARO</option>';}
						if($fila['r_valor_texto']=='AMARILLO OSCURO'){$tabla = $tabla.'<option value="AMARILLO OSCURO" selected>AMARILLO OSCURO</option>';}else{$tabla = $tabla.'<option value="AMARILLO OSCURO">AMARILLO OSCURO</option>';}
						if($fila['r_valor_texto']=='ANARANJADO'){$tabla = $tabla.'<option value="ANARANJADO" selected>ANARANJADO</option>';}else{$tabla = $tabla.'<option value="ANARANJADO">ANARANJADO</option>';}
						if($fila['r_valor_texto']=='ANARANJADO OSCURO'){$tabla = $tabla.'<option value="ANARANJADO OSCURO" selected>ANARANJADO OSCURO</option>';}else{$tabla = $tabla.'<option value="ANARANJADO OSCURO">ANARANJADO OSCURO</option>';}
						if($fila['r_valor_texto']=='MARRON'){$tabla = $tabla.'<option value="MARRON" selected>MARRON</option>';}else{$tabla = $tabla.'<option value="MARRON">MARRON</option>';}
						if($fila['r_valor_texto']=='ROJIZO'){$tabla = $tabla.'<option value="ROJIZO" selected>ROJIZO</option>';}else{$tabla = $tabla.'<option value="ROJIZO">ROJIZO</option>';}
						if($fila['r_valor_texto']=='ROSADO'){$tabla = $tabla.'<option value="ROSADO" selected>ROSADO</option>';}else{$tabla = $tabla.'<option value="ROSADO">ROSADO</option>';}
						if($fila['r_valor_texto']=='AMBAR'){$tabla = $tabla.'<option value="AMBAR" selected>AMBAR</option>';}else{$tabla = $tabla.'<option value="AMBAR">AMBAR</option>';}					
					$tabla = $tabla.'</select>
				';
			}
			else if($name1[0]=='OLOR'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NORMAL'){$tabla = $tabla.'<option value="NORMAL" selected>NORMAL</option>';}else{$tabla = $tabla.'<option value="NORMAL">NORMAL</option>';}
						if($fila['r_valor_texto']=='FETIDO'){$tabla = $tabla.'<option value="FETIDO" selected>FETIDO</option>';}else{$tabla = $tabla.'<option value="FETIDO">FETIDO</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='GLUCOSA'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='50.0'){$tabla = $tabla.'<option value="50.0" selected>50.0</option>';}else{$tabla = $tabla.'<option value="50.0">50.0</option>';}
						if($fila['r_valor_texto']=='100.0'){$tabla = $tabla.'<option value="100.0" selected>100.0</option>';}else{$tabla = $tabla.'<option value="100.0">100.0</option>';}
						if($fila['r_valor_texto']=='300.0'){$tabla = $tabla.'<option value="300.0" selected>300.0</option>';}else{$tabla = $tabla.'<option value="300.0">300.0</option>';}
						if($fila['r_valor_texto']=='500.0'){$tabla = $tabla.'<option value="500.0" selected>500.0</option>';}else{$tabla = $tabla.'<option value="500.0">500.0</option>';}
						if($fila['r_valor_texto']=='1000.0'){$tabla = $tabla.'<option value="1000.0" selected>1000.0</option>';}else{$tabla = $tabla.'<option value="1000.0">1000.0</option>';}
						if($fila['r_valor_texto']=='2000.0'){$tabla = $tabla.'<option value="2000.0" selected>2000.0</option>';}else{$tabla = $tabla.'<option value="2000.0">2000.0</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='BILIRRUBINA'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
						if($fila['r_valor_texto']=='1.0'){$tabla = $tabla.'<option value="1.0" selected>1.0</option>';}else{$tabla = $tabla.'<option value="1.0">1.0</option>';}
						if($fila['r_valor_texto']=='2.0'){$tabla = $tabla.'<option value="2.0" selected>2.0</option>';}else{$tabla = $tabla.'<option value="2.0">2.0</option>';}
						if($fila['r_valor_texto']=='4.0'){$tabla = $tabla.'<option value="4.0" selected>4.0</option>';}else{$tabla = $tabla.'<option value="4.0">4.0</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='CETONAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
						if($fila['r_valor_texto']=='5.0'){$tabla = $tabla.'<option value="5.0" selected>5.0</option>';}else{$tabla = $tabla.'<option value="5.0">5.0</option>';}
						if($fila['r_valor_texto']=='15.0'){$tabla = $tabla.'<option value="15.0" selected>15.0</option>';}else{$tabla = $tabla.'<option value="15.0">15.0</option>';}
						if($fila['r_valor_texto']=='40.0'){$tabla = $tabla.'<option value="40.0" selected>40.0</option>';}else{$tabla = $tabla.'<option value="40.0">40.0</option>';}
						if($fila['r_valor_texto']=='80.0'){$tabla = $tabla.'<option value="80.0" selected>80.0</option>';}else{$tabla = $tabla.'<option value="80.0">80.0</option>';}
						if($fila['r_valor_texto']=='160.0'){$tabla = $tabla.'<option value="160.0" selected>160.0</option>';}else{$tabla = $tabla.'<option value="160.0">160.0</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='DENSIDAD'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='1.000'){$tabla = $tabla.'<option value="1.000" selected>1.000</option>';}else{$tabla = $tabla.'<option value="1.000">1.000</option>';}
						if($fila['r_valor_texto']=='1.005'){$tabla = $tabla.'<option value="1.005" selected>1.005</option>';}else{$tabla = $tabla.'<option value="1.005">1.005</option>';}
						if($fila['r_valor_texto']=='1.010'){$tabla = $tabla.'<option value="1.010" selected>1.010</option>';}else{$tabla = $tabla.'<option value="1.010">1.010</option>';}
						if($fila['r_valor_texto']=='1.015'){$tabla = $tabla.'<option value="1.015" selected>1.015</option>';}else{$tabla = $tabla.'<option value="1.015">1.015</option>';}
						if($fila['r_valor_texto']=='1.020'){$tabla = $tabla.'<option value="1.020" selected>1.020</option>';}else{$tabla = $tabla.'<option value="1.020">1.020</option>';}
						if($fila['r_valor_texto']=='1.025'){$tabla = $tabla.'<option value="1.025" selected>1.025</option>';}else{$tabla = $tabla.'<option value="1.025">1.025</option>';}
						if($fila['r_valor_texto']=='1.030'){$tabla = $tabla.'<option value="1.030" selected>1.030</option>';}else{$tabla = $tabla.'<option value="1.030">1.030</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='PH'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='5.0'){$tabla = $tabla.'<option value="5.0" selected>5.0</option>';}else{$tabla = $tabla.'<option value="5.0">5.0</option>';}
						if($fila['r_valor_texto']=='5.5'){$tabla = $tabla.'<option value="5.5" selected>5.5</option>';}else{$tabla = $tabla.'<option value="5.5">5.5</option>';}
						if($fila['r_valor_texto']=='6.0'){$tabla = $tabla.'<option value="6.0" selected>6.0</option>';}else{$tabla = $tabla.'<option value="6.0">6.0</option>';}
						if($fila['r_valor_texto']=='6.5'){$tabla = $tabla.'<option value="6.5" selected>6.5</option>';}else{$tabla = $tabla.'<option value="6.5">6.5</option>';}
						if($fila['r_valor_texto']=='7.0'){$tabla = $tabla.'<option value="7.0" selected>7.0</option>';}else{$tabla = $tabla.'<option value="7.0">7.0</option>';}
						if($fila['r_valor_texto']=='7.5'){$tabla = $tabla.'<option value="7.5" selected>7.5</option>';}else{$tabla = $tabla.'<option value="7.5">7.5</option>';}
						if($fila['r_valor_texto']=='8.0'){$tabla = $tabla.'<option value="8.0" selected>8.0</option>';}else{$tabla = $tabla.'<option value="8.0">8.0</option>';}
						if($fila['r_valor_texto']=='8.5'){$tabla = $tabla.'<option value="8.5" selected>8.5</option>';}else{$tabla = $tabla.'<option value="8.5">8.5</option>';}
						if($fila['r_valor_texto']=='9'){$tabla = $tabla.'<option value="9" selected>9</option>';}else{$tabla = $tabla.'<option value="9">9</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='SANGRE'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
						if($fila['r_valor_texto']=='5'){$tabla = $tabla.'<option value="5" selected>5</option>';}else{$tabla = $tabla.'<option value="5">5</option>';}
						if($fila['r_valor_texto']=='10'){$tabla = $tabla.'<option value="10" selected>10</option>';}else{$tabla = $tabla.'<option value="10">10</option>';}
						if($fila['r_valor_texto']=='25'){$tabla = $tabla.'<option value="25" selected>25</option>';}else{$tabla = $tabla.'<option value="25">25</option>';}
						if($fila['r_valor_texto']=='50'){$tabla = $tabla.'<option value="50" selected>50</option>';}else{$tabla = $tabla.'<option value="50">50</option>';}
						if($fila['r_valor_texto']=='250'){$tabla = $tabla.'<option value="250" selected>250</option>';}else{$tabla = $tabla.'<option value="250">250</option>';}			
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='PROTEINAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
						if($fila['r_valor_texto']=='15.0'){$tabla = $tabla.'<option value="15.0" selected>15.0</option>';}else{$tabla = $tabla.'<option value="15.0">15.0</option>';}
						if($fila['r_valor_texto']=='30.0'){$tabla = $tabla.'<option value="30.0" selected>30.0</option>';}else{$tabla = $tabla.'<option value="30.0">30.0</option>';}
						if($fila['r_valor_texto']=='100.0'){$tabla = $tabla.'<option value="100.0" selected>100.0</option>';}else{$tabla = $tabla.'<option value="100.0">100.0</option>';}
						if($fila['r_valor_texto']=='300.0'){$tabla = $tabla.'<option value="300.0" selected>300.0</option>';}else{$tabla = $tabla.'<option value="300.0">300.0</option>';}
						if($fila['r_valor_texto']=='2000.0'){$tabla = $tabla.'<option value="2000.0" selected>2000.0</option>';}else{$tabla = $tabla.'<option value="2000.0">2000.0</option>';}	
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='UROBILINOGENO'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NORMAL'){$tabla = $tabla.'<option value="NORMAL" selected>NORMAL</option>';}else{$tabla = $tabla.'<option value="NORMAL">NORMAL</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
						if($fila['r_valor_texto']=='0.2'){$tabla = $tabla.'<option value="0.2" selected>0.2</option>';}else{$tabla = $tabla.'<option value="0.2">0.2</option>';}
						if($fila['r_valor_texto']=='1.0'){$tabla = $tabla.'<option value="1.0" selected>1.0</option>';}else{$tabla = $tabla.'<option value="1.0">1.0</option>';}
						if($fila['r_valor_texto']=='2.0'){$tabla = $tabla.'<option value="2.0" selected>2.0</option>';}else{$tabla = $tabla.'<option value="2.0">2.0</option>';}
						if($fila['r_valor_texto']=='4.0'){$tabla = $tabla.'<option value="4.0" selected>4.0</option>';}else{$tabla = $tabla.'<option value="4.0">4.0</option>';}
						if($fila['r_valor_texto']=='8.0'){$tabla = $tabla.'<option value="8.0" selected>8.0</option>';}else{$tabla = $tabla.'<option value="8.0">8.0</option>';}
						if($fila['r_valor_texto']=='12.0'){$tabla = $tabla.'<option value="12.0" selected>12.0</option>';}else{$tabla = $tabla.'<option value="12.0">12.0</option>';}					
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='LEUCOCITOS' and $i ==13){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='15.0'){$tabla = $tabla.'<option value="15.0" selected>15.0</option>';}else{$tabla = $tabla.'<option value="15.0">15.0</option>';}
						if($fila['r_valor_texto']=='25.0'){$tabla = $tabla.'<option value="25.0" selected>25.0</option>';}else{$tabla = $tabla.'<option value="25.0">25.0</option>';}
						if($fila['r_valor_texto']=='70.0'){$tabla = $tabla.'<option value="70.0" selected>70.0</option>';}else{$tabla = $tabla.'<option value="70.0">70.0</option>';}
						if($fila['r_valor_texto']=='125.0'){$tabla = $tabla.'<option value="125.0" selected>125.0</option>';}else{$tabla = $tabla.'<option value="125.0">125.0</option>';}
						if($fila['r_valor_texto']=='500.0'){$tabla = $tabla.'<option value="500.0" selected>500.0</option>';}else{$tabla = $tabla.'<option value="500.0">500.0</option>';}					
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='SEDIMENTO'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NULO'){$tabla = $tabla.'<option value="NULO" selected>NULO</option>';}else{$tabla = $tabla.'<option value="NULO">NULO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='CELULAS EPITELIALES'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='CELULAS RENALES'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
				  		if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='FILAMENTO DE MUCINA'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
				  		if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='LEVADURAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
				  		if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='CILINDROS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='0 - 1'){$tabla = $tabla.'<option value="0 - 1" selected>0 - 1</option>';}else{$tabla = $tabla.'<option value="0 - 1">0 - 1</option>';}
						if($fila['r_valor_texto']=='0 - 2'){$tabla = $tabla.'<option value="0 - 2" selected>0 - 2</option>';}else{$tabla = $tabla.'<option value="0 - 2">0 - 2</option>';}
						if($fila['r_valor_texto']=='1 - 3'){$tabla = $tabla.'<option value="1 - 3" selected>1 - 3</option>';}else{$tabla = $tabla.'<option value="1 - 3">1 - 3</option>';}
						if($fila['r_valor_texto']=='3- 5'){$tabla = $tabla.'<option value="3- 5" selected>3- 5</option>';}else{$tabla = $tabla.'<option value="3- 5">3- 5</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='ERITROCITOS'){
				$tabla = $tabla.'<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required style="text-align:center;" value="'.$fila['r_valor_texto'].'"onKeyUp="conMayusculas(this);">';
			}
			else if($name1[0]=='BACTERIAS'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
				  		if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else if($name1[0]=='LEUCOCITOS'){
				$tabla = $tabla.'<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required style="text-align:center;" value="'.$fila['r_valor_texto'].'"onKeyUp="conMayusculas(this);">';
			}
			else if($name1[0]=='CRISTALES'){
				$tabla = $tabla.'
					<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
				  		if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='ESCASO'){$tabla = $tabla.'<option value="ESCASO" selected>ESCASO</option>';}else{$tabla = $tabla.'<option value="ESCASO">ESCASO</option>';}
						if($fila['r_valor_texto']=='MODERADO'){$tabla = $tabla.'<option value="MODERADO" selected>MODERADO</option>';}else{$tabla = $tabla.'<option value="MODERADO">MODERADO</option>';}
						if($fila['r_valor_texto']=='ABUNDANTE'){$tabla = $tabla.'<option value="ABUNDANTE" selected>ABUNDANTE</option>';}else{$tabla = $tabla.'<option value="ABUNDANTE">ABUNDANTE</option>';}
						if($fila['r_valor_texto']=='+'){$tabla = $tabla.'<option value="+" selected>+</option>';}else{$tabla = $tabla.'<option value="+">+</option>';}
						if($fila['r_valor_texto']=='++'){$tabla = $tabla.'<option value="++" selected>++</option>';}else{$tabla = $tabla.'<option value="++">++</option>';}
						if($fila['r_valor_texto']=='+++'){$tabla = $tabla.'<option value="+++" selected>+++</option>';}else{$tabla = $tabla.'<option value="+++">+++</option>';}
						if($fila['r_valor_texto']=='++++'){$tabla = $tabla.'<option value="++++" selected>++++</option>';}else{$tabla = $tabla.'<option value="++++">++++</option>';}
					$tabla = $tabla.'</select></select>
				';
			}
			else{
				$tabla = $tabla.'
					<input name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" type="text" class="form-control input-sm" required style="text-align:center;" value="'.$fila['r_valor_texto'].'"onKeyUp="conMayusculas(this);">
				';
			}
		$tabla = $tabla.'</td>
		<td align="center">'.$fila['valor_texto_rl'].'</td>
		<td align="right"> '.$fila['abreviacion_un'].' </td> </tr>
		';
	}
	//Fin para el tipo TEXTO
	
	/*
	ERITROCITOS
	
	<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='0 - 2'){$tabla = $tabla.'<option value="0 - 2" selected>0 - 2</option>';}else{$tabla = $tabla.'<option value="0 - 2">0 - 2</option>';}
						if($fila['r_valor_texto']=='1 - 2'){$tabla = $tabla.'<option value="1 - 2" selected>1 - 2</option>';}else{$tabla = $tabla.'<option value="1 - 2">1 - 2</option>';}
						if($fila['r_valor_texto']=='1 - 3'){$tabla = $tabla.'<option value="1 - 3" selected>1 - 3</option>';}else{$tabla = $tabla.'<option value="1 - 3">1 - 3</option>';}
						if($fila['r_valor_texto']=='3 - 5'){$tabla = $tabla.'<option value="3 - 5" selected>3 - 5</option>';}else{$tabla = $tabla.'<option value="3 - 5">3 - 5</option>';}
						if($fila['r_valor_texto']=='5- 10'){$tabla = $tabla.'<option value="5- 10" selected>5- 10</option>';}else{$tabla = $tabla.'<option value="5- 10">5- 10</option>';}
						if($fila['r_valor_texto']=='10- 15'){$tabla = $tabla.'<option value="10- 15" selected>10- 15</option>';}else{$tabla = $tabla.'<option value="10- 15">10- 15</option>';}
						if($fila['r_valor_texto']=='15- 20'){$tabla = $tabla.'<option value="15- 20" selected>15- 20</option>';}else{$tabla = $tabla.'<option value="15- 20">15- 20</option>';}
						if($fila['r_valor_texto']=='20- 25'){$tabla = $tabla.'<option value="20- 25" selected>20- 25</option>';}else{$tabla = $tabla.'<option value="20- 25">20- 25</option>';}
						if($fila['r_valor_texto']=='25- 30'){$tabla = $tabla.'<option value="25- 30" selected>25- 30</option>';}else{$tabla = $tabla.'<option value="25- 30">25- 30</option>';}
						if($fila['r_valor_texto']=='INCONTABLES'){$tabla = $tabla.'<option value="INCONTABLES" selected>INCONTABLES</option>';}else{$tabla = $tabla.'<option value="INCONTABLES">INCONTABLES</option>';}
					$tabla = $tabla.'</select></select>
	
	LEUCOCITOS
	
	<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
				  		<option value="">-SELECCIONAR</option>';
						if($fila['r_valor_texto']=='NEGATIVO'){$tabla = $tabla.'<option value="NEGATIVO" selected>NEGATIVO</option>';}else{$tabla = $tabla.'<option value="NEGATIVO">NEGATIVO</option>';}
						if($fila['r_valor_texto']=='0 - 2'){$tabla = $tabla.'<option value="0 - 2" selected>0 - 2</option>';}else{$tabla = $tabla.'<option value="0 - 2">0 - 2</option>';}
						if($fila['r_valor_texto']=='1 - 3'){$tabla = $tabla.'<option value="1 - 3" selected>1 - 3</option>';}else{$tabla = $tabla.'<option value="1 - 3">1 - 3</option>';}
						if($fila['r_valor_texto']=='3 - 5'){$tabla = $tabla.'<option value="3 - 5" selected>3 - 5</option>';}else{$tabla = $tabla.'<option value="3 - 5">3 - 5</option>';}
						if($fila['r_valor_texto']=='4 - 6'){$tabla = $tabla.'<option value="4 - 6" selected>4 - 6</option>';}else{$tabla = $tabla.'<option value="4 - 6">4 - 6</option>';}
						if($fila['r_valor_texto']=='5- 10'){$tabla = $tabla.'<option value="5- 10" selected>5- 10</option>';}else{$tabla = $tabla.'<option value="5- 10">5- 10</option>';}
						if($fila['r_valor_texto']=='10- 15'){$tabla = $tabla.'<option value="10- 15" selected>10- 15</option>';}else{$tabla = $tabla.'<option value="10- 15">10- 15</option>';}
						if($fila['r_valor_texto']=='15- 20'){$tabla = $tabla.'<option value="15- 20" selected>15- 20</option>';}else{$tabla = $tabla.'<option value="15- 20">15- 20</option>';}
						if($fila['r_valor_texto']=='20- 25'){$tabla = $tabla.'<option value="20- 25" selected>20- 25</option>';}else{$tabla = $tabla.'<option value="20- 25">20- 25</option>';}
						if($fila['r_valor_texto']=='25- 30'){$tabla = $tabla.'<option value="25- 30" selected>25- 30</option>';}else{$tabla = $tabla.'<option value="25- 30">25- 30</option>';}
						if($fila['r_valor_texto']=='INCONTABLES'){$tabla = $tabla.'<option value="INCONTABLES" selected>INCONTABLES</option>';}else{$tabla = $tabla.'<option value="INCONTABLES">INCONTABLES</option>';}
					$tabla = $tabla.'</select></select>
	*/
	
	//Para el tipo POSITIVO-NEGATIVO
	if($fila['id_cvr']==2){
		if($fila['boleano_rl']==1){
			$bol = 'POSITIVO';
		}else{
			$bol = 'NEGATIVO';
		}
		if($fila['r_boleano_rl']==1){
			$filita = '<option value="1" selected>POSITIVO</option><option value="0">NEGATIVO</option>';
		}else{
			$filita = '<option value="1">POSITIVO</option><option value="0" selected>NEGATIVO</option>';
		}
		$tabla = $tabla.'
		<tr> 
		<td>'.$name1[0].'</td>
		<td align="">'.$fila['tipo_cvr'].'</td>
		<td align="center">
			<select name="'.$fila['id_rl'].'" id="'.$fila['id_rl'].'" lang ="'.$fila['id_cvr'].'" class="form-control input-sm" required>
			  <option value="">-SELECCIONAR</option>
			  '.$filita.'
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
