<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $ref = sqlValue($_POST['ref'], "text");

    mysql_select_db($database_horizonte, $horizonte);
    $buscarEnc = mysql_query("SELECT count(*) from respuestas_encuesta where ref_re = $ref", $horizonte) or die (mysql_error());
    $enc = mysql_fetch_row($buscarEnc);

    if($enc[0] > 0){
        echo 1;
    }else{
        echo 0;
    }

    mysql_close($horizonte);

?>