<?php require_once('../../Connections/horizonte.php'); ?>
<?php
require("../../funciones/php/values.php");
$x = md5(time());
mysql_select_db($database_horizonte, $horizonte);
 
if($_GET['action'] == 'listFotos1'){
 	
	$carpeta = $_GET['carpeta'];
    $query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie, a_reporte_ie, id_estudio_vc_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc; ");
	while($rows = mysql_fetch_assoc($query))
    {
		$fotillo = explode('_1', $rows['nombre_ie']);

		$img = "'../imagen/img_usg/".$rows['id_estudio_vc_ie']."/".$fotillo[0].".png'";
		if($rows['a_reporte_ie']==1){
			$resultO = mysql_query("SELECT estatus_vc from venta_conceptos where id_vc = ".$carpeta." limit 1", $horizonte) or die (mysql_error());
 			$rowO = mysql_fetch_row($resultO);
	
			if($rowO[0]>2){
        	echo  '
			<table width="" border="0" cellspacing="0" cellpadding="2" style="float:left"> <tr> <td>
			<table width="" border="0" cellspacing="0" cellpadding="2"> <tr>
			<td width="" align="center" style="display:none;">
			
			<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" checked id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">R</label>
			
			</td>
			</tr> </table>
			</td> </tr> <tr> <td>
			<img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="../imagen/img_usg/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" />
			</td> </tr> </table>
            ';
			}else{
				echo  '
			<table width="" border="0" cellspacing="0" cellpadding="2" style="float:left"> <tr> <td>
			<table width="" border="0" cellspacing="0" cellpadding="2"> <tr>
			<td width="50%" align="center" style="display:none;">
			
			<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" checked id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">R</label>
			
			</td>
			<td align="right" style="display:none;">
				<button name="'.$rows['id_ie'].'" id="'.$rows['nombre_ie'].'" class="eliminame1" onClick="eliminarFoto(this.name, this.id);" >Eliminar imagen</button>
			</td>
			</tr> </table>
			</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="../imagen/img_usg/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
            ';
			}
		}else{
			$resultO = mysql_query("SELECT estatus_vc from venta_conceptos where id_vc = ".$carpeta." limit 1", $horizonte) or die (mysql_error());
 			$rowO = mysql_fetch_row($resultO);
			
			if($rowO[0]>2){
			echo '
			<table width="" border="0" cellspacing="0" cellpadding="2" style="float:left"> <tr> <td>
			<table width="" border="0" cellspacing="0" cellpadding="2"> <tr>
			<td width="" align="center" style="display:none;">
			
			<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">NR</label>
			
			</td>
			</tr> </table>
			</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="../imagen/img_usg/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
            ';
			}else{
				echo '
			<table width="" border="0" cellspacing="0" cellpadding="2" style="float:left"> <tr> <td>
			<table width="" border="0" cellspacing="0" cellpadding="2"> <tr>
			<td width="50%" align="center" style="display:none;">
			
			<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">NR</label>
			
			</td>
			<td align="right" style="display:none;">
				<button name="'.$rows['id_ie'].'" id="'.$rows['nombre_ie'].'" class="eliminame1" onClick="eliminarFoto(this.name, this.id);" >Eliminar imagen</button>
			</td>
			</tr> </table>
			</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="../imagen/img_usg/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
            ';
			}
		}
    }
 
}elseif($_GET['action'] == 'listFotos2'){ //a reporte	
	$carpeta = $_GET['carpeta'];
	
	mysql_select_db($database_horizonte, $horizonte);
	$queryG1 = mysql_query("SELECT count(id_ie) FROM img_endoscopia where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 ", $horizonte) or die (mysql_error()); $rowG1 = mysql_fetch_row($queryG1);
	switch($rowG1[0]){
		case 1:
			mysql_select_db($database_horizonte, $horizonte);
			$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
			$rowK = mysql_fetch_row($queryK);
			$img1 = explode('_1.png', $rowK[1]);
			echo  '
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style=""><tr> 
			<td nowrap valign="middle" align="center">
			<img id="myImg1" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img1[0].'.png?'.$x.'" />
			</td> 
			</tr> </table>
			';
		break;
		case 2:
			mysql_select_db($database_horizonte, $horizonte);
			$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
			$rowK = mysql_fetch_row($queryK);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
			$rowK2 = mysql_fetch_row($queryK2);
			$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]);
			echo '
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style=""> 
			<tr> 
			<td height="50%" valign="bottom" align="center">
				<img id="myImg2" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img1[0].'.png?'.$x.'" />
			</td> 
			</tr>
			<tr> 
			<td height="50%" valign="top" align="center">
				<img id="myImg3" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img2[0].'.png?'.$x.'" />
			</td> 
			</tr> 
			</table>
			';
		break;
		case 3:
			mysql_select_db($database_horizonte, $horizonte);
			$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
			$rowK = mysql_fetch_row($queryK);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
			$rowK2 = mysql_fetch_row($queryK2);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK3 = mysql_fetch_row($queryK3);
			$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
			echo  '
			<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="2" style="float:left"> 
			<tr> 
			<td align="center" valign="bottom" height="33.3%"><img id="myImg4" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img1[0].'.png?'.$x.'" /></td> </tr>
			<tr> 
			<td align="center" height="3%"><img id="myImg5" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img2[0].'.png?'.$x.'" /></td> </tr> 
			<tr> 
			<td align="center" valign="top" height="33.3%"><img id="myImg6" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img3[0].'.png?'.$x.'" /></td> </tr> 
			</table>
			';
		break;
		case 4:
			mysql_select_db($database_horizonte, $horizonte);
			$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
			$rowK = mysql_fetch_row($queryK);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
			$rowK2 = mysql_fetch_row($queryK2);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK3 = mysql_fetch_row($queryK3);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK4 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK4 = mysql_fetch_row($queryK4);
			$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
			$img4 = explode('_1.png', $rowK4[1]);
			echo  '
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style="float:left"> 
			<tr> 
				<td width="50%" height="50%" align="center" valign="bottom"><img id="myImg7" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img1[0].'.png?'.$x.'" /></td>
				<td height="" align="center" valign="bottom"><img id="myImg8" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img2[0].'.png?'.$x.'" /></td> 
			</tr> 
			<tr> 
				<td height="" align="center" valign="top"><img id="myImg9" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img3[0].'.png?'.$x.'" /></td>
				<td height="" align="center" valign="top"><img id="myImg10" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img4[0].'.png?'.$x.'" /></td> 
			</tr> 
			</table>
			';
		break;
		case 5:
			mysql_select_db($database_horizonte, $horizonte);
			$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
			$rowK = mysql_fetch_row($queryK);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
			$rowK2 = mysql_fetch_row($queryK2);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK3 = mysql_fetch_row($queryK3);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK4 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK4 = mysql_fetch_row($queryK4);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK5 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0],$rowK4[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK5 = mysql_fetch_row($queryK5);
			$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
			$img4 = explode('_1.png', $rowK4[1]); $img5 = explode('_1.png', $rowK5[1]);
			echo  '
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="float:left"> 
			<tr> 
				<td height="33.3%" align="right" valign="bottom"><img id="myImg11" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img1[0].'.png?'.$x.'" /></td>
				<td height="33.3%" align="left" valign="bottom"><img id="myImg12" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img2[0].'.png?'.$x.'" /></td> 
			</tr> 
			<tr> 
				<td height="1%" align="right" valign="middle"><img id="myImg13" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img3[0].'.png?'.$x.'" /></td>
				<td height="1% align="left" valign="middle">
				<img id="myImg14" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img4[0].'.png?'.$x.'" /></td> 
			</tr> 
			<tr> 
				<td height="33.3%" align="center" valign="top" colspan="2"><img id="myImg15" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img5[0].'.png?'.$x.'" /></td>
			</tr> 
			</table>
			';
		break;
		case 6:
			mysql_select_db($database_horizonte, $horizonte);
			$queryK = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc limit 1; ", $horizonte) or die (mysql_error());
			$rowK = mysql_fetch_row($queryK);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK2 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0]) order by id_ie desc limit 2; ", $horizonte) or die (mysql_error());
			$rowK2 = mysql_fetch_row($queryK2);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK3 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK3 = mysql_fetch_row($queryK3);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK4 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK4 = mysql_fetch_row($queryK4);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK5 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0],$rowK4[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK5 = mysql_fetch_row($queryK5);
			mysql_select_db($database_horizonte, $horizonte);
			$queryK6 = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' and id_ie not in ($rowK[0],$rowK2[0],$rowK3[0],$rowK4[0],$rowK5[0]) order by id_ie desc limit 3; ", $horizonte) or die (mysql_error());
			$rowK6 = mysql_fetch_row($queryK6);
			$img1 = explode('_1.png', $rowK[1]); $img2 = explode('_1.png', $rowK2[1]); $img3 = explode('_1.png', $rowK3[1]);
			$img4 = explode('_1.png', $rowK4[1]); $img5 = explode('_1.png', $rowK5[1]); $img6 = explode('_1.png', $rowK6[1]);
			echo  '
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="2" style=""> 
			<tr> 
				<td height="33.3%" width="50%" align="right" valign="bottom"><img id="myImg16" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img1[0].'.png?'.$x.'" /></td>
				<td height="33.3%" align="left" valign="bottom"><img id="myImg17" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img2[0].'.png?'.$x.'" /></td> 
			</tr> 
			<tr> 
				<td height="1%" align="right" valign="middle"><img id="myImg18" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img3[0].'.png?'.$x.'" /></td>
				<td height="" align="left" valign="middle"><img id="myImg19" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img4[0].'.png?'.$x.'" /></td> 
			</tr> 
			<tr> 
				<td height="33.3%" align="right" valign="top"><img id="myImg20" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img5[0].'.png?'.$x.'" /></td>
				<td height="33.3%" align="left" valign="top"><img id="myImg21" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$img6[0].'.png?'.$x.'" /></td>
			</tr> 
			</table>
			';
		break;
		default:
			echo 'EL ESTUDIO NO CUENTA CON IMÁGENES';
	};
    /*$query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie asc; ");
	while($rows = mysql_fetch_assoc($query))
    {
        echo  '
		<table width="" border="0" cellspacing="0" cellpadding="2" style="float:left"> 
		<tr> <td><img width="140" height="" style="border:1px solid black;" src="img_usg/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
		';
    }*/
 
}elseif($_GET['action'] == 'listFotos3'){
 	
	$carpeta = $_GET['carpeta'];
    $query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_ultrasonido where id_estudio_vc_ie = $carpeta and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie asc; ");
	while($rows = mysql_fetch_assoc($query))
    {
        echo  '
			<img src="img_usg/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" data-image="img_usg/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" />
            ';
    }
 
} elseif($_GET['action'] == 'eliminar'){
	
	$id_foto=$_POST['id'];
	$nombre_foto=$_POST['nombre'];
	
	$consultar = mysql_query("SELECT id_estudio_vc_ie, imagen_ie FROM img_ultrasonido WHERE id_ie = $id_foto limit 1");
	$row2 = mysql_fetch_array($consultar);
		
	$query = mysql_query("DELETE FROM img_ultrasonido WHERE id_ie = '".$_POST['id']."' limit 1");
	unlink($row2['id_estudio_vc_ie']."/".$nombre_foto);
		
	//borramos la normal
	$idT = $_POST['id']+1;
	$consultarZ = mysql_query("SELECT nombre_ie FROM img_ultrasonido WHERE id_ie = $idT limit 1");
	$row2Z = mysql_fetch_array($consultarZ);
	$queryT = mysql_query("DELETE FROM img_ultrasonido WHERE id_ie = '".$idT."' limit 1");
	
	//borramos las malas
	$queryD = mysql_query("DELETE FROM img_ultrasonido WHERE imagen_ie like 'NaN%' ");
	unlink($row2['id_estudio_vc_ie']."/"."NaN_1.png");
	unlink($row2['id_estudio_vc_ie']."/"."NaN.png");
	
	unlink($row2['id_estudio_vc_ie']."/".$row2Z['nombre_ie']);
	
	echo $row2['id_estudio_vc_ie'];
	
}elseif($_GET['action'] == 'reporte'){
	$id_foto=$_POST['id'];
	$reportar=$_POST['reportar'];
	
	mysql_select_db($database_horizonte, $horizonte);
	$queryG = mysql_query("SELECT id_estudio_vc_ie FROM img_ultrasonido where id_ie = '".$_POST['id']."' limit 1", $horizonte) or die (mysql_error()); $rowG = mysql_fetch_row($queryG);
	
	mysql_select_db($database_horizonte, $horizonte);
	$queryG1 = mysql_query("SELECT count(id_ie) FROM img_ultrasonido where id_estudio_vc_ie = $rowG[0] and a_reporte_ie = 1 ", $horizonte) or die (mysql_error()); $rowG1 = mysql_fetch_row($queryG1);
	
		$query = mysql_query("UPDATE img_ultrasonido SET a_reporte_ie = $reportar WHERE id_ie = '".$_POST['id']."' limit 1");
		$consultar = mysql_query("SELECT id_estudio_vc_ie FROM img_ultrasonido WHERE id_ie = '".$_POST['id']."' limit 1");
		$row2 = mysql_fetch_array($consultar);
				
		echo $row2['id_estudio_vc_ie'];
}elseif($_GET['action'] == 'checar'){//checa que no nos pasemos de 6 imagenes en el reporte
	$id_foto=$_POST['id'];
	
	mysql_select_db($database_horizonte, $horizonte);
	$queryG = mysql_query("SELECT id_estudio_vc_ie FROM img_ultrasonido where id_ie = '".$_POST['id']."' limit 1", $horizonte) or die (mysql_error()); $rowG = mysql_fetch_row($queryG);
	
	mysql_select_db($database_horizonte, $horizonte);
	$queryG1 = mysql_query("SELECT count(id_ie) FROM img_ultrasonido where id_estudio_vc_ie = $rowG[0] and a_reporte_ie = 1 ", $horizonte) or die (mysql_error()); $rowG1 = mysql_fetch_row($queryG1);
	
	if($rowG1[0]>=6){
		echo 0;//Ya esta lleno
	}else{echo 1;}
}

else //simplemente cuando se va a subir una foto
{
	if(!isset($_GET['idP'])){ $idP = 'koby'; }else{$idP = sqlValue($_GET['idP'], "int");}
	if (substr_count($_GET['action'], '.') >= 1) {
		$miNombre = $_GET['action'];
		list($nombreSimple) = explode('.', $miNombre);
		$_GET['action'] = $nombreSimple.'.jpg';
	}else{$_GET['action'] = $_GET['action'].'.jpg';}
	
	$nombreF = $_GET['action'];
	$nombreF = sqlValue($nombreF, "text");
	mysql_select_db($database_horizonte, $horizonte);
	$queryT = mysql_query("SELECT COUNT(id_im) FROM imagenes where nombre_im = $nombreF", $horizonte) or die (mysql_error());
    $rowT = mysql_fetch_row($queryT);
	
	if ($rowT[0]>0){ echo "";  }else{
		
		$destino = "perfil/";
		if(isset($_FILES['image'])){
			
			$nombre = $_FILES['image']['name'];
			$temp   = $_FILES['image']['tmp_name'];
			$nombre1 = $_GET['action']; //es el nombre que paso en una variable de explorador llamada action al archivo que procesa y sube la imagen.
	 
			// subir imagen al servidor
			if(move_uploaded_file($temp, $destino.$nombre1))
			{
				$queryX1 = mysql_query("update pacientes set foto_p = 1, nombreFoto_p = $nombreF WHERE id_p = $idP limit 1");//Actualizamos al paciente si es q existe el id del paciente
				$query = mysql_query("INSERT INTO imagenes VALUES('','".$nombre1."','1','1')");
				$query1 = mysql_query("SELECT id_im FROM imagenes ORDER BY id_im DESC limit 1");
				$row1 = mysql_fetch_array($query1); 
			}
	
			echo  '<li>
					<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td> <img src="imagenes/perfil/'.$nombre1.'?'.$x.'" /> </td>
					  </tr>
					  <tr height="1%">
						<td id="miGaleri"> <button id="eliminaNFoto" name="'.$row1['id_im'].'" class="eliminame" >Eliminar la imagen</button> </td>
					  </tr>
					</table>
				</li>';
		}
	}
}
?>