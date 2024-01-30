<?php
require("Connections/horizonte.php");
require("funciones/php/values.php");

//recibimos id_h de la tabla hospitalizacion
$id_h = sqlValue($_POST["id_h"],"int");
 
//obtenemos los datos que necesitamos
mysql_select_db($database_horizonte, $horizonte);
$consulta = mysql_query("SELECT id_paciente_h, id_consulta_vc_h FROM hospitalizacion WHERE id_h = $id_h", $horizonte) or die (mysql_error());
$datos = mysql_fetch_row($consulta);

//eliminamos el registro que contenga dichos datos
mysql_select_db($database_horizonte, $horizonte);
$sql = "DELETE FROM datos_previos_hospitalizacion WHERE id_p_dph = ".$datos[0]." AND id_vc_dph = ".$datos[1]." LIMIT 1";
$update = mysql_query($sql, $horizonte);

if($update){
    echo 1;
}

?>