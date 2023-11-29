<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$idC = sqlValue($_POST['idC'],"int");

mysql_select_db($database_horizonte, $horizonte);
$resultR = mysql_query("SELECT referencia_compra from stock_has_bach where id = $idC ", $horizonte) or die(mysql_error());
$referencia = mysql_fetch_row($resultR);
$noRef = $referencia[0];

mysql_select_db($database_horizonte, $horizonte);
$compras = mysql_query("SELECT * from stock_has_bach s left join stock s1 on s1.id = s.id_stock left join conceptos c on c.id_to = s.id_Producto where referencia_compra = '$noRef'  ", $horizonte) or die(mysql_error());

$salida ="";
$hh = 0 ;
$tt = 0;
while ($fila = mysql_fetch_assoc($compras)) {
    $costoT =   $fila["cantidad"] * $fila["costo_unitario"];
    $tt = $tt +  $costoT;
    $salida .="	<tr> ".
    "		<td>".
                (++$hh) .
    "		</td>".
    "		<td>".
                $fila["concepto_to"].
    "		</td>".
    "		<td>".
                $fila["cantidad"].
    "		</td>".
    "		<td>";
if( $fila["estatus"] == 1){
                $salida .= "PENDIENTE";
}else if( $fila["estatus"]== 9){
                $salida .= "ENTREGADO";
}else if( $fila["estatus"]== 17){
                 $salida .= "TRANSFERIDO";
}			
$salida .="	</td>".
    "		<td>".
                $fila["costo_unitario"].
    "		</td>".
    "		<td>".
                $costoT.
    "		</td>".
    "	</tr>";

//    $salida .= "hola ".$fila["id"] . $fila["referencia_compra"] . $fila["id_Producto"];
}
$salida .="	<tr> ".
        "		<td></td>".
        "		<td></td>".
        "		<td></td>".
        "		<td></td>".
        "		<td></td>".
        "		<td>$". $tt ."</td>".
        "	</tr> ";

echo $salida;
?>
