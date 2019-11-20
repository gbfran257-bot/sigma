<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $img = $_POST['imgBase64'];
 $img = str_replace('data:image/png;base64,', '', $img);
 $img = str_replace(' ', '+', $img);
 $fileData = base64_decode($img);
 
 //Para el directorio del estudio
 if (!file_exists("../img_usg/filemanager/source/".$_POST['id'])){ mkdir("../img_usg/filemanager/source/".$_POST['id']); }
 chmod("../img_usg/filemanager/source/".$_POST['id'],  0777);
 //Para el directorio de los thumbs
 if (!file_exists("../img_usg/filemanager/source/".$_POST['id']."/thumbs")){ mkdir("../img_usg/filemanager/source/".$_POST['id']."/thumbs/"); }
 chmod("../img_usg/filemanager/source/".$_POST['id']."/thumbs/",  0777);
  //Para el directorio de las seleccionadas
 if (!file_exists("../img_usg/filemanager/source/".$_POST['id']."/seleccionadas")){ mkdir("../img_usg/filemanager/source/".$_POST['id']."/seleccionadas/"); }
 chmod("../img_usg/filemanager/source/".$_POST['id']."/seleccionadas/",  0777);
 
 $fileName = '../img_usg/filemanager/source/'.$_POST['id'].'/thumbs/'.$_POST['cont'].'.png';
 file_put_contents($fileName, $fileData);
 chmod($fileName,  0777);
 
 $nombre_img = '"'.$_POST['cont'].'.png'.'"';
 $idEstudio = $_POST['id'];
 $imagen = $_POST['cont']; $imagen = '"'.$imagen.'"';
 
 //guardamos un registro en la table de imágenes de endoscopía por cada imagen que guardemos
 mysql_select_db($database_horizonte, $horizonte);
 $sql = "INSERT INTO img_ultrasonido (nombre_ie, id_estudio_vc_ie, imagen_ie, a_reporte_ie, tumb_ie) VALUES ($nombre_img, $idEstudio, $imagen, 0, 1)";
  
$inserta = mysql_query($sql, $horizonte) or die (mysql_error());

if (!$inserta) { echo $sql; }else{ echo 1; }
 
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>