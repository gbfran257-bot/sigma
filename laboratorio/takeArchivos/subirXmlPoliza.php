<?php require_once('../../Connections/ric.php'); ?>
<?php
mysql_select_db($database_ric, $ric);

$nameF = $_GET['key'];
$x = md5(time());
if(!isset($_GET['key']) or $_GET['key']==""){
	echo "<span style='color:red'>Por favor inténtalo en un navegador que no sea FIREFOX</span><br>";
}
 
if($_GET['action'] == 'listFotos'){
 
    $query = mysql_query("SELECT * FROM imagenes where tipo_im = 'XML_POLIZA' and idDe_im = $nameF");
    while($row = mysql_fetch_array($query))
    {
        echo  '<li>
				<span name="'.$row['id_im'].'" class="eliminame" style="cursor:pointer; text-decoration:underline;">Eliminar</span>
                <embed src="xml/'.$row['nombre_im'].'?'.$x.'" />
                <span style="display:none">'.$row['nombre_im'].'</span>
            </li>';
    }
 
}elseif($_GET['action'] == 'eliminar'){
	$id_foto=$_GET['id'];
	$consultar = mysql_query("SELECT * FROM imagenes WHERE tipo_im = 'XML_POLIZA' and id_im=$id_foto");
	$row2 = mysql_fetch_array($consultar);

	$query = mysql_query("DELETE FROM imagenes WHERE tipo_im = 'XML_POLIZA' and id_im = '".$_GET['id']."'");
	unlink("xml/".$row2['nombre_im']);
}

else
{
	mysql_select_db($database_ric, $ric);
	$queryT = mysql_query("SELECT COUNT(id_im) FROM imagenes where tipo_im = 'XML_POLIZA' and idDe_im = $nameF", $ric) or die (mysql_error());
    $rowT = mysql_fetch_row($queryT);
	
	if ($rowT[0]>0){
		echo ""; 
	}else{
	
    $destino = "xml/";
    if(isset($_FILES['image'])){
 		$nombre = $nameF.".xml";
        //$nombre = $_FILES['image']['name'];
        $temp   = $_FILES['image']['tmp_name'];
		//$temp   = $nameF.".jpg";
 
        // subir imagen al servidor
        if(move_uploaded_file($temp, $destino.$nombre))
        {
			mysql_select_db($database_ric, $ric);
            $query = mysql_query("INSERT INTO imagenes VALUES('','".$nombre."','XML_POLIZA','".$nameF."')");
			$query1 = mysql_query("SELECT id_im, nombre_im FROM imagenes where tipo_im = 'XML_POLIZA' ORDER BY id_im DESC limit 1");
    		$row1 = mysql_fetch_row($query1);
        }
 
        echo  '<li>
				<span name="'.$row1[0].'" class="eliminame" style="cursor:pointer; text-decoration:underline">Eliminar</span>
                <embed src="xml/'.$row1[1].'?'.$x.'" />
                <span style="display:">'.''.'</span>
            </li>';
    }
	
	}
}
?>