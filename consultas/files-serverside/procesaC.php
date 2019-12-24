<?php require_once('../../Connections/horizonte.php'); ?>
<?php
require("../../funciones/php/values.php");
$x = md5(time());
mysql_select_db($database_horizonte, $horizonte);
 
if($_GET['action'] == 'listFotos1'){
 	
	$carpeta = $_GET['carpeta'];
    $query = mysql_query("SELECT id_ie, nombre_ie, imagen_ie, a_reporte_ie, id_estudio_vc_ie FROM img_consulta where id_estudio_vc_ie = $carpeta and tumb_ie = 0 and imagen_ie != 'NaN_1' order by id_ie desc; ");
	while($rows = mysql_fetch_assoc($query))
    {
		$fotillo = explode('_1', $rows['nombre_ie']);

		$img = "'consultas/img_cslta/".$rows['id_estudio_vc_ie']."/".$rows['nombre_ie']."'";

		echo '
		<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left">
		<tr> <td>
		<img width="140" height="" onClick="miImg('.$img.',3)" style="border:1px solid black;cursor:pointer;" src="consultas/img_cslta/'.$carpeta.'/'.$rows['nombre_ie'].'?'.$x.'" />
		</td> </tr> </table>
		';
    }
}
?>