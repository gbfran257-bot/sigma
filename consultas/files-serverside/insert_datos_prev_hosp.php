<?php

require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

$id_paciente = sqlValue($_POST["idP"], "int");
$id_usuario = sqlValue($_POST["idU"], "int");
$id_venta_c = sqlValue($_POST["id_vc"], "int");
$motivo = sqlValue($_POST["motivo_h"], "text");
$fecha_registro =  sqlValue(date('Y-m-d H:i:s'), "date");

mysql_select_db($database_horizonte, $horizonte); 
$verif_peticion_existe= mysql_query("SELECT COUNT(id_dph) FROM datos_previos_hospitalizacion WHERE id_p_dph = $id_paciente AND id_vc_dph = $id_venta_c", $horizonte) or die (mysql_error());
$numero_peticiones = mysql_fetch_row($verif_peticion_existe);

if($numero_peticiones[0]<=0){
    mysql_select_db($database_horizonte, $horizonte);
    $sql = "INSERT INTO datos_previos_hospitalizacion (id_dph, id_p_dph, id_u_dph, id_vc_dph, motivo_dph, fecha_registro_dph) VALUES (NULL, $id_paciente, $id_usuario, $id_venta_c, $motivo, $fecha_registro)";
    $ejecutar = mysql_query($sql, $horizonte) or die (mysql_error());

    if(!$ejecutar){
        echo "Ocurrio un problema al insertar datos previos " . $ejecutar;
    }else{
        echo 1;
    }
}else{
    echo 2;
}




?>