<?php require_once('../Connections/horizonte.php'); ?>
<?php
mysql_select_db($database_horizonte, $horizonte);

$nameF = $_GET['key'];
$x = md5(time());
if(!isset($_GET['key']) or $_GET['key']==""){
	echo "<span style='color:red'>Por favor inténtalo en un navegador que no sea FIREFOX</span><br>";
}
 
if($_GET['action'] == 'listFotos'){
 
    $query = mysql_query("SELECT * FROM fotos where tipo_foto = 'FOTO_PERFIL' and idDe_foto = $nameF");
    while($row = mysql_fetch_array($query))
    {
        echo  '<li>
				<span name="'.$row['id_foto'].'" class="eliminame" style="cursor:pointer; text-decoration:underline;">Eliminar</span>
                <img src="fotoPacientes/'.$row['nombre_foto'].'?'.$x.'" />
                <span style="display:none">'.$row['nombre_foto'].'</span>
            </li>';
    }
 
}elseif($_GET['action'] == 'eliminar'){
	$id_foto=$_GET['id'];
	$consultar = mysql_query("SELECT * FROM fotos WHERE id_foto=$id_foto");
	$row2 = mysql_fetch_array($consultar);

	$query = mysql_query("DELETE FROM fotos WHERE id_foto = '".$_GET['id']."'");
	unlink("fotoPacientes/".$row2['nombre_foto']);
}

else
{
	mysql_select_db($database_horizonte, $horizonte);
	$queryT = mysql_query("SELECT COUNT(id_foto) FROM fotos where tipo_foto = 'FOTO_PERFIL' and idDe_foto = $nameF", $horizonte) or die (mysql_error());
    $rowT = mysql_fetch_row($queryT);
	
	if ($rowT[0]>0){
		echo ""; 
	}else{
	
//Script que sube la foto al servidor e Inserta en la DB los datos d ela misma	
    $destino = "fotoPacientes/";
    if(isset($_FILES['image'])){
 		$nombre = $nameF.".jpg";
        //$nombre = $_FILES['image']['name'];
        $temp   = $_FILES['image']['tmp_name'];
		//$temp   = $nameF.".jpg";
 
        // subir imagen al servidor
        if(move_uploaded_file($temp, $destino.$nombre))
        {
			mysql_select_db($database_horizonte, $horizonte);
            $query = mysql_query("INSERT INTO fotos VALUES('','".$nombre."','FOTO_PERFIL','".$nameF."')");
			$query1 = mysql_query("SELECT id_foto, nombre_foto FROM fotos ORDER BY id_foto DESC limit 1");
    		$row1 = mysql_fetch_row($query1);
        }
 
        echo  '<li>
				<span name="'.$row1[0].'" class="eliminame" style="cursor:pointer; text-decoration:underline">Eliminar</span>
                <img src="fotoPacientes/'.$row1[1].'?'.$x.'" />
                <span style="display:">'.''.'</span>
            </li>';
    }
	
	}
}
?>