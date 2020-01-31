<?php require_once('../../Connections/horizonte.php'); ?>
<?php
require("../../funciones/php/values.php");
$x = md5(time());
mysql_select_db($database_horizonte, $horizonte);
 
if($_GET['action'] == 'listFotos1'){
 	
	$carpeta = $_GET['carpeta']; $contador = 0;
    $query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie, a_reporte_ie, id_estudio_vc_ie FROM img_endoscopia where id_estudio_vc_ie = $carpeta and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie desc; ");
	while($rows = mysql_fetch_assoc($query)){ $contador++;
		$fotillo = explode('_1', $rows['nombre_ie']);

		$img = "'imagen/img_endo/filemanager/source/".$rows['id_estudio_vc_ie']."/".$fotillo[0]."'";
		if($rows['a_reporte_ie']==1){
			$resultO = mysql_query("SELECT estatus_vc from venta_conceptos where id_vc = ".$rows['id_estudio_vc_ie']." limit 1", $horizonte) or die (mysql_error());
 			$rowO = mysql_fetch_row($resultO);
	
			if($rowO[0]>2){
				echo  '
					<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left"> <tr> <td>
					<table width="100%" border="0" cellspacing="0" cellpadding="2"> <tr>
					<td width="99%" align="center">
					
					<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" checked id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">R</label>
					
					</td>
					<td nowrap><span class="small text-info">'.$contador.'</span></td>
					</tr> </table>
					</td> </tr> <tr> <td>
					<img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="imagen/img_endo/filemanager/source/'.$carpeta.'/thumbs/'.$rows['nombre_ie'].'?'.$x.'" />
					</td> </tr> </table>
					';
			}else{
				echo  '
				<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left"> <tr> <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="2"> <tr>
				<td width="99%" align="center">
				
				<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" checked id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">R</label>
				
				</td>
				<td nowrap><span class="small text-info">'.$contador.'</span></td>
				<td align="right" style="display:none;">
					<button name="'.$rows['id_ie'].'" id="'.$rows['nombre_ie'].'" class="eliminame1" onClick="eliminarFoto(this.name, this.id);" >Eliminar imagen</button>
				</td>
				</tr> </table>
				</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="imagen/img_endo/filemanager/source/'.$carpeta.'/thumbs/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
				';
			}
		}else{
			$resultO = mysql_query("SELECT estatus_vc from venta_conceptos where id_vc = ".$rows['id_estudio_vc_ie']." limit 1", $horizonte) or die (mysql_error());
 			$rowO = mysql_fetch_row($resultO);
			
			if($rowO[0]>=3){
				echo  '
				<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left"> <tr> <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="2"> <tr>
				<td width="99%" align="center">
				
				<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">NR</label>
				
				</td>
				<td nowrap><span class="small text-info">'.$contador.'</span></td>
				</tr> </table>
				</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="imagen/img_endo/filemanager/source/'.$carpeta.'/thumbs/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
				';
			}else{
					echo  '
				<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left"> <tr> <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="2"> <tr>
				<td width="99%" align="center">
				
				<input class="en_reporte" id="r-'.$rows['imagen_ie'].'" type="checkbox" id="checkR" onClick="reporteFoto('.$rows['id_ie'].', this.id);"><label for="r-'.$rows['imagen_ie'].'">NR</label>
				
				</td>
				<td nowrap><span class="small text-info">'.$contador.'</span></td>
				<td align="right" style="display:none;">
					<button name="'.$rows['id_ie'].'" id="'.$rows['nombre_ie'].'" class="eliminame1" onClick="eliminarFoto(this.name, this.id);" >Eliminar imagen</button>
				</td>
				</tr> </table>
				</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.')" style="border:1px solid black;cursor:pointer;" src="imagen/img_endo/filemanager/source/'.$carpeta.'/thumbs/'.$rows['nombre_ie'].'?'.$x.'" /></td> </tr> </table>
				';
			}
		}
    }
 
}elseif($_GET['action'] == 'listFotos2'){
	$carpeta = $_GET['carpeta'];
	mysql_select_db($database_horizonte, $horizonte);
    $query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_endoscopia where id_estudio_vc_ie = $carpeta and a_reporte_ie = 1 and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie asc; ");
	while($rows = mysql_fetch_assoc($query))
    {//echo $idPac;
		$nombreD = explode('_',$rows['nombre_ie']);
		$nombreD1 = $nombreD[0];
        echo  '
			<table width="" border="0" cellspacing="0" cellpadding="2" style="float:left"> 
			<tr> <td><img width="164" height="" style="border:1px solid black;" src="imagen/img_endo/filemanager/source/'.$carpeta.'/'.$nombreD1.'?'.$x.'" /></td> </tr> </table>
            ';
    } 
 
}elseif($_GET['action'] == 'listFotos3'){
 	
	$carpeta = $_GET['carpeta'];
    $query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie FROM img_endoscopia where id_estudio_vc_ie = $carpeta and tumb_ie = 1 and imagen_ie != 'NaN_1' order by id_ie asc; ");
	while($rows = mysql_fetch_assoc($query))
    {
        echo  '
			<img src="img_endo/filemanager/source/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" data-image="img_endo/filemanager/source/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" />
            ';
    }
 
} elseif($_GET['action'] == 'eliminar'){
	
	$id_foto=$_POST['id'];
	$nombre_foto=$_POST['nombre'];
	
	$consultar = mysql_query("SELECT id_estudio_vc_ie, imagen_ie FROM img_endoscopia WHERE id_ie = $id_foto limit 1");
	$row2 = mysql_fetch_array($consultar);
		
	$query = mysql_query("DELETE FROM img_endoscopia WHERE id_ie = '".$_POST['id']."' limit 1");
	unlink($row2['id_estudio_vc_ie']."/".$nombre_foto);
		
	//borramos la normal
	$idT = $_POST['id']+1;
	$consultarZ = mysql_query("SELECT nombre_ie FROM img_endoscopia WHERE id_ie = $idT limit 1");
	$row2Z = mysql_fetch_array($consultarZ);
	$queryT = mysql_query("DELETE FROM img_endoscopia WHERE id_ie = '".$idT."' limit 1");
	
	//borramos las malas
	$queryD = mysql_query("DELETE FROM img_endoscopia WHERE imagen_ie like 'NaN%' ");
	unlink($row2['id_estudio_vc_ie']."/"."NaN_1.png");
	unlink($row2['id_estudio_vc_ie']."/"."NaN.png");
	
	unlink($row2['id_estudio_vc_ie']."/".$row2Z['nombre_ie']);
	
	echo $row2['id_estudio_vc_ie'];
	
}elseif($_GET['action'] == 'reporte'){
	$id_foto=$_POST['id'];
	$reportar=$_POST['reportar'];
	
	if($reportar==1){
		mysql_select_db($database_horizonte, $horizonte);
		$resultJ = mysql_query("SELECT id_estudio_vc_ie, nombre_ie FROM img_endoscopia WHERE id_ie = '".$_POST['id']."' limit 1", $horizonte) or die (mysql_error());
		$rowJ = mysql_fetch_row($resultJ);
		
		$resultJ1 = mysql_query("SELECT count(id_ie) FROM img_endoscopia WHERE id_estudio_vc_ie = '".$rowJ[0]."' and a_reporte_ie = 1 ", $horizonte) or die (mysql_error());
		$rowJ1 = mysql_fetch_row($resultJ1);
		
		if($rowJ1[0]<8){
			$query = mysql_query("UPDATE img_endoscopia SET a_reporte_ie = $reportar WHERE id_ie = '".$_POST['id']."' limit 1");
			$update=1;
			//Copiamos la imagen al directorio de seleccionadas
			if (file_exists('filemanager/source/'.$rowJ[0].'/'.$rowJ[1].'')) { //realizamos la copia
				if(copy('filemanager/source/'.$rowJ[0].'/'.$rowJ[1].'','filemanager/source/'.$rowJ[0].'/seleccionadas/'.$rowJ[1].'')){}
				else {}
			}else{}
		}else{$update=0;}
	}else{  
		$query = mysql_query("UPDATE img_endoscopia SET a_reporte_ie = $reportar WHERE id_ie = '".$_POST['id']."' limit 1");
		$update=1;
		//eliminamos la imagen del directorio de seleccionadas
		mysql_select_db($database_horizonte, $horizonte);
		$resultJ = mysql_query("SELECT id_estudio_vc_ie, nombre_ie FROM img_endoscopia WHERE id_ie = '".$_POST['id']."' limit 1", $horizonte) or die (mysql_error());
		$rowJ = mysql_fetch_row($resultJ);
		unlink('filemanager/source/'.$rowJ[0].'/seleccionadas/'.$rowJ[1].'');
	}
	
	$consultar = mysql_query("SELECT id_estudio_vc_ie FROM img_endoscopia WHERE id_ie = '".$_POST['id']."' limit 1");
	$row2 = mysql_fetch_array($consultar);
			
	echo $update.';'.$row2['id_estudio_vc_ie'];
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
				chmod($destino.$nombre1,  0777);
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
