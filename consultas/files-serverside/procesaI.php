<?php require_once('../../Connections/horizonte.php'); ?>
<?php
require("../../funciones/php/values.php");
$x = md5(time()); mysql_select_db($database_horizonte, $horizonte);
 
if($_GET['action'] == 'listFotos1'){
	$carpeta = $_GET['carpeta'];
    $query = mysql_query("SELECT id_do, nombre_do, id_quien_do, ext_do FROM documentos where id_quien_do = $carpeta and que_es_do = 'FOTOGRAFIA' and tipo_quien_do = 4 order by id_do desc; ");
	while($rows = mysql_fetch_assoc($query))
    {
		$fotillo = explode('_1', $rows['id_do']);

		$img = "'imagen/fotografias/files/".$fotillo[0].".".$rows['ext_do']."'";
	
		echo '
		<table class="table-condensed table-bordered" border="0" cellspacing="0" cellpadding="0" style="float:left"> <tr> <td>
		<table width="" border="0" cellspacing="0" cellpadding="2"> <tr>
		<td width="50%" align="center" style="display:;">'.$rows['nombre_do'].'</td>
		<td align="right" style="display:none;">kola</td>
		</tr> </table>
		</td> </tr> <tr> <td><img width="140" height="" onClick="miImg('.$img.',2)" style="border:1px solid black;cursor:pointer;" src="imagen/fotografias/files/'.$rows['id_do'].'.'.$rows['ext_do'].'?'.$x.'" /></td> </tr> </table>
		';
    }
}
?>