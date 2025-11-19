<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    mysql_select_db($database_horizonte, $horizonte); 
    $qry_mod = mysql_query("SELECT COUNT(*) FROM modificaciones_sigma WHERE nombre = 'dateNoView' AND habilitado = 1 ", $horizonte) or die(mysql_error()); 
    $result_qry_mod = mysql_fetch_row($qry_mod);
    $mod_sigma = $result_qry_mod[0];

    echo $mod_sigma;

    mysql_close($horizonte);
?>