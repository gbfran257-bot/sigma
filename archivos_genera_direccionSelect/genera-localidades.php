<?php

$dbh = mysql_connect("localhost", "root", "garbage20");
$db = mysql_select_db("sigma");

$consulta = "SELECT DISTINCT localidad_nombre, localidad_cve from cat_localidades WHERE municipio_cve = ".$_GET['id']." and entidad_cve= ".$_GET['id1']." order by localidad_nombre asc";
$query = mysql_query($consulta);
while ($fila = mysql_fetch_array($query)) {
    echo '<option value="'.$fila['localidad_cve'].'">'.$fila['localidad_nombre'].'</option>';
};

?>