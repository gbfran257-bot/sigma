<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $img = $_POST['imgBase64'];
 $img = str_replace('data:image/png;base64,', '', $img);
 $img = str_replace(' ', '+', $img);
 $fileData = base64_decode($img);
 //saving
 mkdir("../img_cslta/".$_POST['id'], 0777);
 $fileName = '../img_cslta/'.$_POST['id'].'/'.$_POST['cont'].'_1.png';
 file_put_contents($fileName, $fileData);
 
 $nombre_img = '"'.$_POST['cont'].'_1.png'.'"';
 $idEstudio = $_POST['id'];
 $imagen = $_POST['cont']; $imagen = '"'.$imagen.'_1"';
 
 //guardamos un registro en la table de imágenes de endoscopía por cada imagen que guardemos
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO img_consulta (nombre_ie, id_estudio_vc_ie, imagen_ie, a_reporte_ie, tumb_ie) VALUES ($nombre_img, $idEstudio, $imagen, 0, 1)";
  
$inserta = mysql_query($sql, $horizonte) or die (mysql_error());

if (!$inserta) { echo $sql; }else{ echo 1; }
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>