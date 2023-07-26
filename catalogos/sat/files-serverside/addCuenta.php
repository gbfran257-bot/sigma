<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

// Obtenemos los datos del formulario
$id_tipo = sqlValue($_POST['select_tipo'], 'int');
if ($id_tipo != 1 && $id_tipo != 2) die(Error('Error en el tipo de impuesto.'));

$id_impuesto = sqlValue($_POST['select_impuesto'], 'int');
if ($id_impuesto != 1 && $id_impuesto != 2 && $id_impuesto != 3) die(Error('Error en el impuesto.'));

$id_factor = sqlValue($_POST['select_factor'], 'int');
if ($id_factor != 1 && $id_factor != 2 && $id_factor != 3) die(Error('Error en el factor.'));

$id_tasa_cuota_fijo = sqlValue($_POST['select_tasa_cuota'], 'int');
$tasa_cuota_libre = doubleval(htmlentities($_POST['monto_impuesto'], ENT_QUOTES, 'utf-8'));

$clave = sqlValue(trim(mb_strtoupper($_POST["clave"])), "text");
$descripcion = sqlValue(trim(mb_strtoupper($_POST["descripcion"])), "text");
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

if ($_POST["iva"] == 'excento') {
    $excento = 1;
    $iva = 0;
} else {
    $excento = 0;
    $iva = sqlValue($_POST["iva"], "int");
}

// Abrimos la conexión con la base de datos
mysql_select_db($database_horizonte, $horizonte);

// Insertamos el registro de catalogo_sat
$sql = "INSERT INTO catalogo_sat (clave_sat,descripcion_sat,iva,excento,id_usuario_sat,fecha_sat) VALUES ($clave,$descripcion,$iva,$excento,$idU,$now)";
$insert = mysql_query($sql, $horizonte) or die(mysql_error());
$sql = "SELECT id_sat FROM catalogo_sat WHERE clave_sat = $clave";
$id_sat = mysql_fetch_assoc(mysql_query($sql, $horizonte))['id_sat'];

// Insertamos el nuevo impuesto impuesto aplicado
if ($id_tasa_cuota_fijo >= 1 && $id_tasa_cuota_fijo <= 14 && $tasa_cuota_libre == 0) {
    $sql = "INSERT INTO impuesto_catalogo(id_sat,id_impuesto,id_impuesto_fijo,impuesto_libre,id_factor,id_tipo) VALUES ($id_sat,$id_impuesto,$id_tasa_cuota_fijo,NULL,$id_factor,$id_tipo)";
} elseif ($id_tasa_cuota_fijo == 0 && $tasa_cuota_libre >= 0.01) {
    $sql = "INSERT INTO impuesto_catalogo(id_sat,id_impuesto,id_impuesto_fijo,impuesto_libre,id_factor,id_tipo) VALUES ($id_sat,$id_impuesto,NULL,$tasa_cuota_libre,$id_factor,$id_tipo)";
} elseif ($id_tasa_cuota_fijo == 0 && $tasa_cuota_libre == 0) {
    $sql = "INSERT INTO impuesto_catalogo(id_sat,id_impuesto,id_impuesto_fijo,impuesto_libre,id_factor,id_tipo) VALUES ($id_sat,$id_impuesto,NULL,NULL,$id_factor,$id_tipo)";
}
$insert = mysql_query($sql, $horizonte);

echo 1;

// Cerramos la conexión con la base de datos
mysql_close($horizonte);
