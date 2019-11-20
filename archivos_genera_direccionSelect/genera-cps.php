<?php

$dbh = mysql_connect("localhost", "root", "garbage20");
$db = mysql_select_db("sigma");

$x=str_replace("%20"," ",$_GET['id1']);
$_GET['id1']=$x;

$consulta = "SELECT cp, id_cp from cat_postal WHERE id_cp = ".$_GET['id']." and nom_mun like '%".$_GET['id1']."%' and entidad_cve = ".$_GET['id2'];
$query = mysql_query($consulta);
while ($fila = mysql_fetch_array($query)) {
    echo '<option value="'.$fila['id_cp'].'">'.$fila['cp'].'</option>';
};

?>