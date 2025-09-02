<?php
    require("../../Connections/horizonte.php");
    require("../../funciones/php/values.php");

    $ref = sqlValue($_POST["ref"], "text");
    
    mysql_select_db($database_horizonte, $horizonte); 
    $qryNombreF = mysql_query("SELECT id_do FROM documentos WHERE nombre_do = $ref order by id_do DESC LIMIT 1", $horizonte) or die (mysql_error());
    $nombreF = mysql_fetch_row($qryNombreF);

    echo $nombreF[0];
    
    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>