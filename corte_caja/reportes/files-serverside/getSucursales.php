<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    mysql_select_db($database_horizonte, $horizonte);
    $consultaS = "SELECT id_su as id, nombre_su as nombre from sucursales order by nombre asc ";
    $queryS = mysql_query($consultaS) or die (mysql_error());
    $sucs = '<option value="0">'.'-TODOS-'.'</option>';
    while ($fila = mysql_fetch_array($queryS)){
        $sucs = $sucs.'<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
    };

    echo $sucs;

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>