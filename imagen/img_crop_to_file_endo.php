<?php
/*
*	!!! THIS IS JUST AN EXAMPLE !!!, PLEASE USE ImageMagick or some other quality image processing libraries
*/
//Borrando los archivos que tengan mñas de 3 dias
$dir = opendir('temp/');
while($f = readdir($dir)) {
	if((time()-filemtime('temp/'.$f) > 3600*24*3) and !(is_dir('temp/'.$f)))
	unlink('temp/'.$f);
}
closedir($dir);
//Fin borrando los archivos que tengan mñas de 3 dias

$imgX = explode('?',$_POST['imgUrl']);
//$imgUrl = $_POST['imgUrl'];
$imgUrl = $imgX[0];
// original sizes
$imgInitW = $_POST['imgInitW'];
$imgInitH = $_POST['imgInitH'];
// resized sizes
$imgW = $_POST['imgW'];
$imgH = $_POST['imgH'];
// offsets
$imgY1 = $_POST['imgY1'];
$imgX1 = $_POST['imgX1'];
// crop box
$cropW = $_POST['cropW'];
$cropH = $_POST['cropH'];
// rotation angle
$angle = $_POST['rotation'];

$jpeg_quality = 100;
//$png_quality = 1;

//Mis datos
$idEst = $_POST['idEst'];
$noImg = $_POST['noImg'];

$carpeta = 'temp/'.$idEst;
/*if (!file_exists($carpeta)){ */mkdir($carpeta); //}
chmod($carpeta,  0777);

$output_filename = "temp/".$idEst."/".$noImg;
$x = md5(time());

// uncomment line below to save the cropped image in the same location as the original image.
//$output_filename = dirname($imgUrl). "/croppedImg_".rand();

$what = getimagesize($imgUrl);

switch(strtolower($what['mime']))
{
    case 'image/png':
        $img_r = imagecreatefrompng($imgUrl);
		$source_image = imagecreatefrompng($imgUrl);
		$type = '.png';
        break;
    case 'image/jpeg':
        $img_r = imagecreatefromjpeg($imgUrl);
		$source_image = imagecreatefromjpeg($imgUrl);
		error_log("jpg");
		$type = '.png';
        break;
    case 'image/gif':
        $img_r = imagecreatefromgif($imgUrl);
		$source_image = imagecreatefromgif($imgUrl);
		$type = '.png';
        break;
    default: die('image type not supported');
}


//Check write Access to Directory

if(!is_writable(dirname($output_filename))){
	$response = Array(
	    "status" => 'error',
	    "message" => 'Can`t write cropped File'
    );	
}else{

    // resize the original image to size of editor
    $resizedImage = imagecreatetruecolor($imgW, $imgH);
	imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
    // rotate the rezized image
    $rotated_image = imagerotate($resizedImage, -$angle, 0);
    // find new width & height of rotated image
    $rotated_width = imagesx($rotated_image);
    $rotated_height = imagesy($rotated_image);
    // diff between rotated & original sizes
    $dx = $rotated_width - $imgW;
    $dy = $rotated_height - $imgH;
    // crop rotated image to fit into original rezized rectangle
	$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
	$cropped_rotated_image1 = imagecreatetruecolor(200, 150);
	imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
	imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
	// crop image into selected area
	$final_image = imagecreatetruecolor($cropW, $cropH);
	imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
	imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
	// finally output png image
	//imagepng($final_image, $output_filename.$type, $png_quality);
	imagejpeg($final_image, $output_filename.$type, $jpeg_quality);

	 $image_p = imagecreatetruecolor(200, 150);
	 //$image = imagecreatefromjpeg($nombre_archivo);
	 $imagen = imagecreatefromjpeg( $output_filename.$type );
	 imagecopyresampled($image_p, $imagen, 0, 0, 0, 0, 200, 150, $cropW, $cropH);
	//imagecopyresampled($final_image, $cropped_rotated_image1, 0, 0, 0, 0, 200, 150, $imgW, $imgH);
	// finally output png image
	//imagepng($final_image, $output_filename.$type, $png_quality);
	imagejpeg($image_p, $output_filename.'_1'.$type, $jpeg_quality);
	chmod($output_filename.'_1'.$type,  0777);
	
	$response = Array(
	    "status" => 'success',
	    "url" => $output_filename.$type.'?'.$x
    );
}
print json_encode($response);