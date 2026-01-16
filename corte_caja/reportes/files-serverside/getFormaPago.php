<?php
    require("../../../Connections/horizonte.php");
    require("../../../funciones/php/values.php");

    //obtenemos lista de metodos de pago
    mysql_select_db($database_horizonte, $horizonte);
    $consultaS2 = "SELECT id_fp as id, forma_pago_fp as nombre from catalogo_forma_pago order by nombre asc ";
    $queryS2 = mysql_query($consultaS2) or die (mysql_error());
    $sucs2 = '<option value="0">'.'-SELECCIONAR-'.'</option>';
    while ($fila2 = mysql_fetch_array($queryS2)){
        $sucs2 = $sucs2.'<option value="'.$fila2['id'].'">'.$fila2['nombre'].'</option>';
    };
    
    echo $sucs2;

    //Cerrar conexión a la Base de Datos
    mysql_close($horizonte);
?>