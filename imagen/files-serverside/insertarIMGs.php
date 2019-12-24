<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 	$idE = sqlValue($_POST["idVC"], "int"); $xo = date("Ymdhis");

	mysql_select_db($database_horizonte, $horizonte);
	$result=mysql_query("SELECT count(id_ie) from img_endoscopia where id_estudio_vc_ie = $idE and a_reporte_ie = 1",$horizonte) or die (mysql_error());
 	$row = mysql_fetch_row($result);
	
	if($row[0]<1){
		$tablita = ''; $piecito = '';
	}else{
		$tablita = '<table width="100%" border="0" cellspacing="5" cellpadding="2" style="width:100%;"> <tr>';
		$piecito = '</tr> </table>';
	}
	if($row[0]==0){ $wi = ''; }
	elseif($row[0]==1){ $wi = 110; } elseif($row[0]==2){ $wi = 110; } elseif($row[0]==3){ $wi = 110; } elseif($row[0]==4){ $wi = 110; }
	elseif($row[0]==5){ $wi = 110; } elseif($row[0]==6){ $wi = 110; } elseif($row[0]==7){ $wi = 110; } elseif($row[0]==8){ $wi = 110; }
	//$wi = 100;
	
	mysql_select_db($database_horizonte, $horizonte); $i=0; $co = 1; $co2 = 0;
	$consulta = "SELECT nombre_ie from img_endoscopia where id_estudio_vc_ie = $idE and a_reporte_ie = 1 ";
	$query = mysql_query($consulta) or die (mysql_error());
	$num = mysql_num_rows($query);
	while($fila = mysql_fetch_array($query)) {
		if($row[0]>0){ $i++;
			if($i<=4){ 
				$cuerpo = $cuerpo.'<td align="center"><img src="imagen/img_endo/filemanager/source/'.$idE.'/seleccionadas/'.$fila['nombre_ie'].'?'.$xo.'" height="'.$wi.'"</td>'; }
			if($i>=5){
				if($i==5){ $cuerpo = $cuerpo.'</tr><tr>';}
				if($num>=5){
					$co1 = $i-($co+$co2);
					if($i==$num){
						$cuerpo = $cuerpo.'<td align="center" colspan="'.$co1.'"><img src="imagen/img_endo/filemanager/source/'.$idE.'/seleccionadas/'.$fila['nombre_ie'].'?'.$xo.'" height="'.$wi.'"</td>';
					}
					else{
						$cuerpo = $cuerpo.'<td align="center"><img src="imagen/img_endo/filemanager/source/'.$idE.'/seleccionadas/'.$fila['nombre_ie'].'?'.$xo.'" height="'.$wi.'"</td>';
					}
					$co2 = $co2+2;
				}
			}
		}else{$cuerpo = '';}
	}
	
	$tablita = $tablita.$cuerpo.$piecito;
	
	echo $tablita;
 	//Cerrar conexión a la Base de Datos
 	mysql_close($horizonte);
?>