<?php

$dbh = mysql_connect("localhost", "root", "garbage20");
$db = mysql_select_db("sigma");

$x=str_replace("%20"," ",$_GET['id']);
$_GET['id']=$x;

$consulta = "SELECT DISTINCT localidad, cp, id_cp from cat_postal WHERE nom_mun like '%".$_GET['id']."%' and entidad_cve= ".$_GET['id1']." order by localidad asc";
$query = mysql_query($consulta);
while ($fila = mysql_fetch_array($query)) {
    echo '<option value="'.$fila['id_cp'].'">'.$fila['localidad'].'</option>';
};

?>