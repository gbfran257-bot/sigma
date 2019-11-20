<?php
$dbh = mysql_connect("localhost", "root", "garbage20");
$db = mysql_select_db("sigma");

$consulta = "SELECT DISTINCT nom_mun, cve_mun from cat_municipios WHERE cve_ent = ".$_GET['id'];
$query = mysql_query($consulta);
while ($fila = mysql_fetch_array($query)) {
    echo '<option value="'.$fila['cve_mun'].'">'.$fila['nom_mun'].'</option>'." order by nom_mun asc ";
};

?>