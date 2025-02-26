<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT variable_temporal_u, variable_temporal1_u, variable_temporal2_u, variable_temporal5_u FROM usuarios WHERE id_u = %s", $_GET["iduL"]);
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$id_s = sqlValue($_GET["id_s"], "int");

mysql_select_db($database_horizonte, $horizonte);
$resultR = mysql_query("SELECT margen_e_la, margen_p_la from sucursales where id_su = $id_s", $horizonte) or die (mysql_error());
$rowR = mysql_fetch_row($resultR);

//Guardamos la informacion del estudio en la tabla estudios_sistema_externo para usar con la aplicacion que lista los estudios al paciente
$id_vc = sqlValue($_GET['id_vc'], "int");
$vt = sqlValue($row_usuario['variable_temporal_u'], "text");
$vt1 = sqlValue($row_usuario['variable_temporal1_u'], "text");
$vt5 = sqlValue($row_usuario['variable_temporal5_u'], "text");

mysql_select_db($database_horizonte, $horizonte);
$contar_registros = mysql_query("SELECT COUNT(id_vc_ese) FROM estudios_sistema_externo WHERE id_vc_ese = $id_vc", $horizonte) or die (mysql_error());
$registros = mysql_fetch_row($contar_registros);

if($registros[0] == 0){
    mysql_select_db($database_horizonte, $horizonte);
    $sqlAddreg = "INSERT INTO estudios_sistema_externo (id_vc_ese, id_su_ese, variable_temporal_u_ese, variable_temporal1_u_ese, variable_temporal5_u_ese) VALUES ($id_vc, $id_s, $vt, $vt1, $vt5);";
    $agregarReg = mysql_query($sqlAddreg, $horizonte) or die (mysql_error());
}else if($registros[0] == 1){
    mysql_select_db($database_horizonte, $horizonte);
    $sqlActualizarReg = "UPDATE estudios_sistema_externo SET id_su_ese = $id_s, variable_temporal_u_ese = $vt, variable_temporal1_u_ese = $vt1, variable_temporal5_u_ese = $vt5 WHERE id_vc_ese = $id_vc LIMIT 1";
    $actualizarReg = mysql_query($sqlActualizarReg, $horizonte) or die (mysql_error());   
}
//
 
?>

<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
#p_header {padding:10px 0; border-top: 0px none; border-bottom: 0px none; width:100%;}
#p_header .fila #col_1 {width: 100%}

#p_footer {padding-top:5px 0; border-top: 2px none #46d; width:100%;}
#p_footer .fila td {text-align:center; width:100%;}
#p_footer .fila td span {font-size: 10px; color: #000;}

#p_contenido {margin-top:0px; width:100% !important;} #p_contenido tr td {padding-top: 0px; text-align: justify; width:;}

#p_contenido1 {margin-top:0px; width:10cm; bottom:0px;} 
#p_contenido1 tr td {padding-top: 0px; text-align: justify; width:;}
#p_contenido2 {margin-top:0px; width:100%;} #p_contenido2 tr td {padding-top: 0px; text-align: justify; width:;}

#tabla1 .fila4 #col_14 {width: 100%; border:1px solid red;}
#firmaDR img{ display:none;}
-->
</style>
<!-- page define la hoja con los márgenes señalados -->
<!--<page backtop="30mm" backbottom="22mm" backleft="3mm" backright="3mm"> -->
<page backtop="<?php echo $rowR[0]*10; ?>mm" backbottom="<?php echo $rowR[1]*10; ?>mm" backleft="3mm" backright="3mm">
    <page_header> <!-- Define el header de la hoja -->
	<table id="p_header"><tr class="fila"><td id="col_1"><?php echo $_GET["encL"]; ?></td></tr></table>
    </page_header>
        
    <page_footer> <!-- Define el footer de la hoja -->
	<table id="p_footer"><tr class="fila"><td id="col_2" ><?php echo $_GET["pieL"]; ?></td></tr></table>
    </page_footer>
    <!-- Define el cuerpo de la hoja -->
    <?php echo $row_usuario['variable_temporal1_u']; ?><hr style="height:1px;">
	<?php echo $row_usuario['variable_temporal_u']; ?> 
    <?php echo $row_usuario['variable_temporal5_u']; ?>
    <!-- Fin del cuerpo de la hoja -->
</page>
<?php mysql_free_result($usuario);?>
