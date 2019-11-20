<?php require_once('../Connections/productores.php'); ?>
<?php
mysql_select_db($database_productores, $productores);

$nameF = $_GET['key'];
$x = md5(time());
if(!isset($_GET['key']) or $_GET['key']==""){
	echo "<span style='color:red'>Por favor inténtalo en un navegador que no sea FIREFOX</span><br>";
}
 
if($_GET['action'] == 'listFotos'){
 
    $query = mysql_query("SELECT * FROM fotos where tipo_foto = 'FOTO_IDENTIFICACION' and idDe_foto = $nameF");
    while($row = mysql_fetch_array($query))
    {
        echo  '<li>
				<span name="'.$row['id_foto'].'" class="eliminame" style="cursor:pointer; text-decoration:underline;">Eliminar</span>
                <img src="identificaciones/'.$nameF.'/'.$row['nombre_foto'].'?'.$x.'" />
                <span style="display:none">'.$row['nombre_foto'].'</span>
            </li>';
    }
 
}elseif($_GET['action'] == 'eliminar'){
	$id_foto=$_GET['id'];
	$consultar = mysql_query("SELECT * FROM fotos WHERE id_foto=$id_foto");
	$row2 = mysql_fetch_array($consultar);

	$query = mysql_query("DELETE FROM fotos WHERE id_foto = '".$_GET['id']."'");
	unlink("identificaciones/".$nameF."/".$row2['nombre_foto']);
}

else
{
	mysql_select_db($database_productores, $productores);
	$queryT = mysql_query("SELECT COUNT(id_foto), nombre_foto FROM fotos where tipo_foto = 'FOTO_IDENTIFICACION' and idDe_foto = $nameF", $productores) or die (mysql_error());
    $rowT = mysql_fetch_row($queryT);
	
	if ($rowT[0]>1){
		echo ""; 
	}else{
		
	$serv = "identificaciones/";

	$ruta = $serv . $nameF;
	if(!file_exists($ruta))
	{
		mkdir ($ruta);
		//echo "Se ha creado el directorio: " . $ruta;
	} else {
		//echo "la ruta: " . $ruta . " ya existe ";
	}
	
    $destino = "identificaciones/".$nameF."/";
    if(isset($_FILES['image'])){
		if($rowT[0]==0){
			$nombre = "1.jpg";
		}
		if($rowT[0]==1){
			if($rowT[1]=='1.jpg'){
				$nombre = "2.jpg";
			}else{$nombre = "1.jpg";}
		}
 		//$nombre = $nameF.".jpg";
        //$nombre = $_FILES['image']['name'];
        $temp   = $_FILES['image']['tmp_name'];
		//$temp   = $nameF.".jpg";
 
        // subir imagen al servidor
        if(move_uploaded_file($temp, $destino.$nombre))
        {
			mysql_select_db($database_productores, $productores);
            $query = mysql_query("INSERT INTO fotos VALUES('','".$nombre."','FOTO_IDENTIFICACION','".$nameF."')");
			$query1 = mysql_query("SELECT id_foto, nombre_foto FROM fotos ORDER BY id_foto DESC limit 1");
    		$row1 = mysql_fetch_row($query1);
        }
 
        echo  '<li>
				<span name="'.$row1[0].'" class="eliminame" style="cursor:pointer; text-decoration:underline">Eliminar</span>
                <img src="identificaciones/'.$nameF."/".$row1[1].'?'.$x.'" />
                <span style="display:">'.''.'</span>
            </li>';
    }
	
	}
}
?>