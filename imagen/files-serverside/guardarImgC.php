<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $img = $_POST['imgBase64'];
 $img = str_replace('data:image/png;base64,', '', $img);
 $img = str_replace(' ', '+', $img);
 $fileData = base64_decode($img);
 //saving mkdir("../img_colpo/filemanager/source/".$_POST['id'], 0777);
 if (!file_exists("../img_colpo/filemanager/source/".$_POST['id'])){ mkdir("../img_colpo/filemanager/source/".$_POST['id']); }
 chmod("../img_colpo/filemanager/source/".$_POST['id'],  0777);
 $fileName = '../img_colpo/filemanager/source/'.$_POST['id'].'/'.$_POST['cont'].'.png';
 file_put_contents($fileName, $fileData);
 chmod($fileName,  0777);
 
 $nombre_img = '"'.$_POST['cont'].'.png'.'"';
 $idEstudio = $_POST['id'];
 $imagen = $_POST['cont'];
 
 //guardamos un registro en la table de imágenes de endoscopía por cada imagen que guardemos
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO img_ultrasonido (nombre_ie, id_estudio_vc_ie, imagen_ie, a_reporte_ie) VALUES ($nombre_img, $idEstudio, $imagen, 0)";
  
$inserta = mysql_query($sql, $horizonte) or die (mysql_error());

if (!$inserta) { echo $sql; }else{ echo 1; }
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>