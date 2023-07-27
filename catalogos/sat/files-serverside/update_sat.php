<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id = sqlValue($_POST["id_sat"], "int");
$clave = trim(sqlValue(mb_strtoupper($_POST["clave"]), "text"));
$descripcion = trim(sqlValue(mb_strtoupper($_POST["descripcion"]), "text"));
$idU = sqlValue($_POST["idU"], "int");
$now = sqlValue(date('Y-m-d H:i:s'), "date");

// Obtenemos los campos del formulario correspondientes al impuesto
$id_impuesto_catalogo = intval(htmlentities($_POST['id_impuesto_catalogo'], ENT_QUOTES, 'utf-8'));
$id_impuesto = intval(htmlentities($_POST['select_impuesto'], ENT_QUOTES, 'utf-8'));
$id_impuesto_fijo = htmlentities($_POST['select_tasa_cuota'], ENT_QUOTES, 'utf-8');
$id_impuesto_fijo =  $id_impuesto_fijo == 'otro' || $id_impuesto_fijo == NULL ? 'NULL' : intval(htmlentities($_POST['select_tasa_cuota'], ENT_QUOTES, 'utf-8'));
$impuesto_libre = htmlentities($_POST['monto_impuesto'], ENT_QUOTES, 'utf-8');
$impuesto_libre = $impuesto_libre == NULL || $impuesto_libre == '0' ? 'NULL' : doubleval($impuesto_libre);
$id_factor = intval(htmlentities($_POST['select_factor'], ENT_QUOTES, 'utf-8'));
$id_tipo = intval(htmlentities($_POST['select_tipo'], ENT_QUOTES, 'utf-8'));

if ($_POST["iva"] == 'excento') {
   $excento = 1;
   $iva = 0;
} else {
   $excento = 0;
   $iva = sqlValue($_POST["iva"], "int");
}

mysql_select_db($database_horizonte, $horizonte);
$sql = "UPDATE catalogo_sat set clave_sat = $clave, descripcion_sat = $descripcion, iva= $iva, excento = $excento, id_usuario_sat = $idU, fecha_sat = $now where id_sat = $id limit 1";

$update = mysql_query($sql, $horizonte) or die(mysql_error());

if (!$update) {
   echo $sql;
} else {
   echo 1;
}

$sql2 = "UPDATE impuesto_catalogo
         SET id_impuesto = $id_impuesto, id_impuesto_fijo = $id_impuesto_fijo, impuesto_libre = $impuesto_libre, id_factor = $id_factor, id_tipo = $id_tipo
         WHERE id_sat = $id AND id = $id_impuesto_catalogo";
$insert = mysql_query($sql2, $horizonte) or die(mysql_error());

//Cerrar conexión a la Base de Datos
mysql_close($horizonte);
