<?php
/*
    Tomar una fotografía y guardarla en un archivo
    @date @date 2018-10-22
    @author parzibyte
    @web parzibyte.me/blog
*/

require("../Connections/horizonte.php");
require("../funciones/php/values.php");

$now = sqlValue(date('Y-m-d H:i:s'), "date");

//guardamos el registro en bd
mysql_select_db($database_horizonte, $horizonte);
$sql = "INSERT INTO documentos (nombre_do, ext_do, aleatorio_do, tipo_quien_do, usuario_do, fecha_do, que_es_do)";
$sql.= "VALUES ('".$_GET['name']."', 'png', ".$_GET['id'].", 1, 1, $now, 'IMAGEN')";
$update = mysql_query($sql, $horizonte) or die (mysql_error());

//obtenemos el ultimo id guardado para nombrar la imagen como id.png
mysql_select_db($database_horizonte, $horizonte);
$resultF = mysql_query("SELECT MAX(id_do) from documentos limit 1 ", $horizonte) or die (mysql_error());
$rowF = mysql_fetch_row($resultF);
$nombreimg = $rowF[0].".png";

$imagenCodificada = file_get_contents("php://input"); //Obtener la imagen
if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");
//La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));

//Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
//todo el contenido lo guardamos en un archivo
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);

//Calcular un nombre único
//$nombreImagenGuardada = "../pacientes/imagenes/firmas/foto_" . uniqid() . ".png";
$nombreImagenGuardada = "../pacientes/documentos/fotos/" . $nombreimg;

//Escribir el archivo
file_put_contents($nombreImagenGuardada, $imagenDecodificada);

//Terminar y regresar el nombre de la foto
exit($nombreImagenGuardada);
?>