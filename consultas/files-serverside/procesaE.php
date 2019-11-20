<?php require_once('../../Connections/horizonte.php'); ?>
<?php
require("../../funciones/php/values.php");
$x = md5(time());
mysql_select_db($database_horizonte, $horizonte);
 
if($_GET['action'] == 'listFotos1'){
 	
	$carpeta = $_GET['carpeta'];
    $query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie, a_reporte_ie, id_estudio_vc_ie FROM img_endoscopia where id_estudio_vc_ie = $carpeta and tumb_ie = 1 and imagen_ie != 'NaN_1' and a_reporte_ie = 1 order by id_ie desc; ");
	while($rows = mysql_fetch_assoc($query))
    {
		$fotillo = explode('_1', $rows['nombre_ie']);

		$img = "'imagen/img_endo/filemanager/source/".$rows['id_estudio_vc_ie']."/".$fotillo[0]."'";
		if($rows['a_reporte_ie']==1){
			$resultO = mysql_query("SELECT estatus_vc from venta_conceptos where id_vc = ".$carpeta." limit 1", $horizonte) or die (mysql_error());
 			$rowO = mysql_fetch_row($resultO);
	
			if($rowO[0]>2){
        	echo  '
			<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left">
			<tr> <td>
			<img width="140" height="" onClick="miImg('.$img.',3)" style="border:1px solid black;cursor:pointer;" src="imagen/img_endo/filemanager/source/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" />
			</td> </tr> </table>
            ';
			}else{
				echo  '
			<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left"> <tr> <td>
			<table width="140" border="0" cellspacing="0" cellpadding="2"> <tr>
			<td width="50%" align="center" style="display:none;">
			
			<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" checked id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">R</label>
			
			</td>
			<td align="right" style="display:none;">
				<button name="'.$rows['id_ie'].'" id="'.$rows['nombre_ie'].'" class="eliminame1" onClick="eliminarFoto(this.name, this.id);" >Eliminar imagen</button>
			</td>
			</tr> </table>
			</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="imagen/img_endo/filemanager/source/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
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
			</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="../imagen/img_endo/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
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
			</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="../imagen/img_endo/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
            ';
			}
		}
    }
 
}
?>