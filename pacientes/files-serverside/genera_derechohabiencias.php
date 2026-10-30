<?php
    require_once('../../Connections/horizonte.php');

    mysql_select_db($database_horizonte, $horizonte);
    $consulta = "SELECT id_d, nombre_d from catalogo_nuevas_derechohabiencias";
    $query = mysql_query($consulta) or die (mysql_error());
    echo '<option value="">'.'-SELECCIONA-'.'</option>';
    while ($fila = mysql_fetch_array($query)) {
        echo '<option value="'.$fila['id_d'].'">'.$fila['nombre_d'].'</option>';
    };

?>