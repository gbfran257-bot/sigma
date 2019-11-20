<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idEstudio = sqlValue($_POST["idEstudio"], "int");
 $noImgen = sqlValue($_POST["noImgen"], "int");

	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE img_endoscopia SET editada_ie = 0 where id_estudio_vc_ie = $idEstudio and imagen_ie = $noImgen limit 2";
  
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
	if (!$update) {
		echo $sql;
	 }else {
		 echo 1;
		 //Regresamos la imagen original del directorio img_restaurar_endo al directorio de la imagen original reemplezandola por la cortada
		 $srcfile = '../img_restaurar_endo/'.$idEstudio.'/'.$noImgen.'.png';
		 $dstfile = '../img_endo/'.$idEstudio.'/'.$noImgen.'.png';
		 $carpeta = '../img_endo/'.$idEstudio;
		 /*if (!file_exists($carpeta)) { */mkdir($carpeta); chmod($carpeta,  0777); //}
		 /*if (!file_exists($dstfile)) { */copy($srcfile, $dstfile); chmod($dstfile,  0777); //}
		 
		 //Regresamos la imagen miniatura original del directorio img_restaurar_endo al directorio de la imagen original reemplezandola por la cortada
		 $srcfile1 = '../img_restaurar_endo/'.$idEstudio.'/'.$noImgen.'_1.png';
		 $dstfile1 = '../img_endo/'.$idEstudio.'/'.$noImgen.'_1.png';
		 $carpeta1 = '../img_endo/'.$idEstudio;
		 /*if (!file_exists($carpeta1)) { */mkdir($carpeta1); chmod($carpeta1,  0777); //}
		 /*if (!file_exists($dstfile1)) { */copy($srcfile1, $dstfile1); chmod($dstfile1,  0777); //}
	}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>