<?php
require("../../../Connections/horizonte.php");
require("../../../funciones/php/values.php");

$id_s = sqlValue($_GET["id_s"], "int");

mysql_select_db($database_horizonte, $horizonte);
$resultR = mysql_query("SELECT margen_e_im, margen_p_im, no_temp_su from sucursales where id_su = $id_s", $horizonte) or die (mysql_error());
$rowR = mysql_fetch_row($resultR); $idSuc = sqlValue($rowR[2], "text");

mysql_select_db($database_horizonte, $horizonte); //Membrete encabezado estudios img
 $resultMNE = mysql_query("SELECT id_do, ext_do from documentos where aleatorio_do = $idSuc and que_es_do = 'MEMBRETE RESULTADOS IMAGENOLOGIA' and tipo_quien_do = 2 and nombre_do = 'ENCABEZADO'", $horizonte) or die (mysql_error());
 $rowMNE = mysql_fetch_row($resultMNE); $encaNM = '../../../sucursales/membretes/files/'.$rowMNE[0].'.'.$rowMNE[1];
 
 mysql_select_db($database_horizonte, $horizonte); //Membrete pie estudios img
 $resultMNP = mysql_query("SELECT id_do, ext_do from documentos where aleatorio_do = $idSuc and que_es_do = 'MEMBRETE RESULTADOS IMAGENOLOGIA' and tipo_quien_do = 2 and nombre_do = 'PIE'", $horizonte) or die (mysql_error());
 $rowMNP = mysql_fetch_row($resultMNP); $pieNM = '../../../sucursales/membretes/files/'.$rowMNP[0].'.'.$rowMNP[1];

mysql_select_db($database_horizonte, $horizonte);
$query_usuario = sprintf("SELECT variable_temporal_u, variable_temporal1_u, variable_temporal2_u, variable_temporal3_u, variable_temporal4_u FROM usuarios WHERE id_u = %s", $_GET["iduL"]);
$usuario = mysql_query($query_usuario, $horizonte) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_horizonte, $horizonte);
$query_usuario1 = sprintf("SELECT interpretacion_vc FROM venta_conceptos WHERE id_vc = %s", $_GET["idVC"]);
//SELECT REPLACE('www.mysql.com', 'w', 'Ww');
$usuario1 = mysql_query($query_usuario1, $horizonte) or die(mysql_error());
$row_usuario1 = mysql_fetch_assoc($usuario1);
$totalRows_usuario1 = mysql_num_rows($usuario1);
?>

<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--
#p_header {padding:0px 0; border-top: 0px none; border-bottom: 0px none; width:100%;}
#p_header .fila #col_1 {width: 100%;}

#p_footer {padding-top:5px 0; border-top: 2px none #46d; width:100%;}
#p_footer .fila td {text-align:center; width:100%;}
#p_footer .fila td span {font-size: 10px; color: #000;}

#p_contenido {margin-top:0px; width:595pt; height:1000pt;} 
#p_contenido .mceNonEditable td {padding-top: 0px; text-align: justify; width:255pt;}

#p_contenido1 {margin-top:0px; width:10cm; bottom:0px;} 
#p_contenido1 tr td {padding-top: 0px; text-align: justify; width:;}
#p_contenido2 {margin-top:0px; width:100%;} #p_contenido2 tr td {padding-top: 0px; text-align: justify; width:;}

#tabla1 .fila4 #col_14 {width: 100%; border:1px solid red;}
#firmaDR img{ display:none;}
-->
</style>
<!-- page define la hoja con los márgenes señalados -->
<!-- <page backtop="27mm" backbottom="22mm" backleft="8mm" backright="7mm"> PARA TDI-->
<!-- <page backtop="42mm" backbottom="24mm" backleft="8mm" backright="7mm"> PARA COVADONGA-->
<page backtop="<?php echo $rowR[0]*10; ?>mm" backbottom="<?php echo $rowR[1]*10; ?>mm" backleft="3mm" backright="3mm">

    <page_header> <!-- Define el header de la hoja -->
	<table id="p_header"><tr class="fila"><td id="col_1"><?php if($_GET["mems"]==1){ ?><img src="<?php } ?>
	  <?php if($_GET["mems"]==1){echo $encaNM;} ?><?php if($_GET["mems"]==1){ ?>" width="770"><?php } ?></td></tr></table>
    </page_header>
        
    <page_footer> <!-- Define el footer de la hoja -->
	<table id="p_footer"><tr class="fila"><td id="col_2"><?php if($_GET["mems"]==1){ ?><img src="<?php } ?><?php if($_GET["mems"]==1){echo $pieNM;} ?><?php if($_GET["mems"]==1){ ?>" width="760"><?php } ?></td></tr></table>
    </page_footer>
    <!-- Define el cuerpo de la hoja -->
    <?php //echo $row_usuario['variable_temporal1_u']; ?><!--<hr style="height:1px;"> -->
	<?php //echo $row_usuario1['interpretacion_vc']; ?>
    <?php echo str_replace("</p>","<br>",str_replace("<p>", "",$row_usuario1['interpretacion_vc'])); ?>
    <?php //echo $row_usuario['variable_temporal2_u']; ?>
    <!-- Fin del cuerpo de la hoja -->
</page>
<?php mysql_free_result($usuario);?>
<?php mysql_free_result($usuario1);?>
