<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $idEstudio = sqlValue($_POST["idEstudio"], "int");
 $noImgen = sqlValue($_POST["noImgen"], "int");
 $x = md5(time());

	mysql_select_db($database_horizonte, $horizonte);
 	$sql = "UPDATE img_endoscopia SET editada_ie = 1 where id_estudio_vc_ie = $idEstudio and imagen_ie = $noImgen limit 2";
  
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
	if (!$update) { echo $sql;
	 }else {
		 echo 1;
		 //Hacemos que la imagen original se guarde en la carpeta img_restaurar_endo y la imagen cortada la guardamos en el directorio de la imagen original con el nombre d ela imagen original
		 $srcfile = '../img_endo/'.$idEstudio.'/'.$noImgen.'.png';
		 $dstfile = '../img_restaurar_endo/'.$idEstudio.'/'.$noImgen.'.png';
		 $carpeta = '../img_restaurar_endo/'.$idEstudio;
		 /*if (!file_exists($carpeta)) { */mkdir($carpeta); chmod($carpeta,  0777);//}
		 /*if (!file_exists($dstfile)) { */copy($srcfile, $dstfile); chmod($dstfile,  0777);//}
		 
		 //Su miniatura guardamos la original
		 $srcfile2 = '../img_endo/'.$idEstudio.'/'.$noImgen.'_1.png';
		 $dstfile2 = '../img_restaurar_endo/'.$idEstudio.'/'.$noImgen.'_1.png';
		 $carpeta2 = '../img_restaurar_endo/'.$idEstudio;
		 /*if (!file_exists($carpeta2)) { */mkdir($carpeta2); chmod($carpeta2,  0777); //}
		 /*if (!file_exists($dstfile2)) { */copy($srcfile2, $dstfile2); chmod($dstfile2,  0777); //}
		 
		 $srcfile1 = '../temp/'.$idEstudio.'/'.$noImgen.'.png';
		 $dstfile1 = '../img_endo/'.$idEstudio.'/'.$noImgen.'.png';
		 $carpeta1 = '../img_endo/'.$idEstudio;
		 /*if (!file_exists($carpeta1)) { */mkdir($carpeta1); chmod($carpeta1,  0777); //}
		 /*if (!file_exists($dstfile1)) { */copy($srcfile1, $dstfile1); chmod($dstfile1,  0777); //}
		 
		 $srcfile3 = '../temp/'.$idEstudio.'/'.$noImgen.'_1.png';
		 $dstfile3 = '../img_endo/'.$idEstudio.'/'.$noImgen.'_1.png';
		 $carpeta3 = '../img_endo/'.$idEstudio;
		 /*if (!file_exists($carpeta3)) { */mkdir($carpeta3); chmod($carpeta3,  0777); //}
		 /*if (!file_exists($dstfile3)) { */copy($srcfile3, $dstfile3); chmod($dstfile3,  0777); //}
	}

 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>