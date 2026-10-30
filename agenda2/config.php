<?php

/** https://github.com/icodeart/Calendario-Bootstrap-php-mysql **/

// Datos de conexion a la base de datos
$servidor='localhost';
$usuario='root';
$pass='';
$bd='csa_sigma24';

// Nos conectamos a la base de datos
$conexion = new mysqli($servidor, $usuario, $pass, $bd);	

// Definimos que nuestros datos vengan en utf8
$conexion->set_charset('utf8');

// verificamos si hubo algun error y lo mostramos
if ($conexion->connect_errno) {
	echo "Error al conectar la base de datos {$conexion->connect_errno}";
}

// Url donde estara el proyecto, debe terminar con un "/" al final
//si no funciona la agenda, intenta reemplazar el codigo de abajo por la linea comentada y modificar manualmente los valores.
//$base_url="http://localhost/sigmacadit/agenda2/";
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/agenda2/';
$base_url = $protocolo . $host . $path;

?>

