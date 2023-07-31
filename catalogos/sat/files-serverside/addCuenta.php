<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

// Obtenemos los datos del formulario
$clave = sqlValue(trim(mb_strtoupper($_POST["clave"])), "text");
$descripcion = sqlValue(trim(mb_strtoupper($_POST["descripcion"])), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

// Abrimos la conexión con la base de datos
mysql_select_db($database_horizonte, $horizonte);

// Insertamos el registro de catalogo_sat
$sql = "INSERT INTO catalogo_sat (clave_sat,descripcion_sat,id_usuario_sat,fecha_sat) VALUES ($clave,$descripcion,$idU,$now)";
$insert = mysql_query($sql, $horizonte) or die(mysql_error());

if (!$insert) {
    echo $insert;
} else {
    echo 1;
}

// Cerramos la conexión con la base de datos
mysql_close($horizonte);
