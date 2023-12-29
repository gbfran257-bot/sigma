<?php 
require('../Connections/horizonte.php');
require("../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$consulta = "SELECT id_fp, forma_pago_fp FROM catalogo_forma_pago"; 
$query = mysql_query($consulta) or die (mysql_error());

while ($fila = mysql_fetch_array($query)) {
    // echo '<option clave="'.$fila['clave_su'].'" tipo="'.$fila['tipo_tabulador_su'].'" value="'.$fila['id_su'].'">'.$fila['nombre_su'].'</option>'; 
    echo '<option value="'.$fila['id_fp'].'">'.$fila['forma_pago_fp'].'</option>'; 
};

?>