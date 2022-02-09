<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$idEvc = sqlValue($_GET["idE"], "int");
  
$tabla = '<table id="p_contenido" width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;" class="table-condensed table-bordered">
		<tr align="" class="">
			<td colspan="5">MICROORGANISMO AISLADO:</td>
		</tr>
		<tr align="" class="">
			<td colspan="5">
				<table width="100%" class="table-condensed table-bordered" id="datatableMOA">
					<thead>
					  <tr role="row" class="bg-info">
						<th id="clickmeMOA" align="center" width="1%">#</th>
						<th align="center">MICROORGANISMO</th>
						<th align="center">CANTIDAD</th>
					  </tr>
					</thead> <tbody> <tr> <td class="dataTables_empty">Cargando datos del servidor</td> </tr> </tbody> 
				</table>
			</td>
		</tr>
		<tr align="left" class="bg-default">
			<td colspan="5">ANTIBIOGRAMA:</td>
		</tr>
		<tr align="center" class="bg-primary">
			<td>ANTIBIÓTICO</td> <td colspan="4" width="">CANTIDAD</td>
		</tr>
		';

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT r.id_rl, t.id_cvr, t.tipo_cvr, r.numero1_rango_rl, r.numero2_rango_rl, r.valor_maximo_rl, r.valor_minimo_rl, r.valor_estable_rl, r.valor_variable_rl, r.valor_texto_rl, r.boleano_rl, u.abreviacion_un, u.unidad_un, b.base_b, r.r_valor_normal, r.r_valor_r1_moderado, r.r_valor_r2_moderado, r.r_valor_alto, r.r_valor_normal_i, r.r_valor_r1_moderado_i, r.r_valor_r2_moderado_i, r.r_valor_alto_i, r.r_valor_texto from resultados_laboratorio r left join catalogo_valores_referencia t on t.id_cvr = r.id_valor_referencia_rl left join bases b on b.id_b = r.id_base_rl left join unidades u on u.id_un = b.unidad_medida_r_b where r.id_estudio_vc_rl = $idEvc and b.base_b like '%_MIANTI' and r.r_valor_texto is not null order by r.id_rl asc ";
$query = mysql_query($consulta) or die (mysql_error());
while ($fila = mysql_fetch_array($query)) {//$fila['convenio_cv'];
	//Para el tipo TEXTO
	
	$nameMi = explode("_MIANTI", $fila['base_b']);
	if($fila['id_cvr']==1){
		$mi_val = sqlValue($fila['id_rl'], "int");
		$opcion1 = ''; $opcion2 = ''; $opcion3 = ''; $opcion4 = '';
		if($fila['r_valor_texto']==''){$opcion1 = 'selected';}
		else if($fila['r_valor_texto']=='SENSIBLE'){$opcion2 = 'selected';}
		else if($fila['r_valor_texto']=='MEDIANAMENTE SENSIBLE'){$opcion3 = 'selected';}
		else if($fila['r_valor_texto']=='ALTAMENTE SENSIBLE'){$opcion4 = 'selected';}
		else{$opcion1 = 'selected';}
		
		$tabla = $tabla.'
		<tr> 
		<td>'.$nameMi[0].'</td>
		<td align="left" colspan="4">'.$fila['r_valor_texto'].'</td>
		';
	}
	//Fin para el tipo TEXTO
};

$tabla = $tabla.'</table>';

echo $tabla;
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>
