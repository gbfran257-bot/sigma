<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

if(isset($_GET["id_u"])){
    $id_u = sqlValue($_GET["id_u"], "int");

    mysql_select_db($database_horizonte, $horizonte);
    $multisucursal = mysql_query("SELECT multisucursal_u FROM usuarios WHERE id_u = ".$_GET['id_u'], $horizonte) or die (mysql_error());
    $revisar_multisucursal = mysql_fetch_row($multisucursal);

    if($revisar_multisucursal[0]==1){
        $consulta = "select s.id_su as id, s.nombre_su as text from sucursales s where 1=1 ";
    }else{
        $consulta = "select s.id_su as id, s.nombre_su as text from sucursales s LEFT JOIN sucursales_usuarios su ON su.id_sucursal_su = s.id_su WHERE su.id_usuario_su = ".$_GET['id_u']." GROUP BY su.id_sucursal_su ";
    }

    $query = mysql_query($consulta) or die (mysql_error());
    echo '<option value="">'.'-Selecciona sucursal-'.'</option>';
    while ($fila = mysql_fetch_array($query)) {
        echo '<option value="'.$fila['id'].'">'.$fila['text'].'</option>';
    };


 }

 
/* mysql_select_db($database_horizonte, $horizonte);
 $sql = "UPDATE venta_conceptos SET estatus_vc = 9, usuarioEdo6_e = $idU, fechaEdo6_e = $now where id_vc = $idVC limit 1";
  
$update = mysql_query($sql, $horizonte) or die (mysql_error());
	
if (!$update) {
 	echo $sql;
 }else {
	 echo 1;
} */
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>