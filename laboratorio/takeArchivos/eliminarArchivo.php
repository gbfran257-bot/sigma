<?php require_once('../../Connections/horizonte.php'); ?>
<?php
require("../../funciones/php/values.php");
mysql_select_db($database_horizonte, $horizonte);

if(isset($_POST["idPDF"])){
	$nombre_foto=sqlValue($_POST["idPDF"], "text"); 
	$idU=sqlValue($_POST["idU"], "int"); 
	$idE=sqlValue($_POST["idE"], "int"); 
	$now = sqlValue(date('Y-m-d H:i:s'), "date");

	$consultar = mysql_query("SELECT * FROM imagenes WHERE tipo_im = 'PDF_RESULTADO' and nombre_im = $nombre_foto");
	$row2 = mysql_fetch_array($consultar);
	
	$query = mysql_query("DELETE FROM imagenes WHERE tipo_im = 'PDF_RESULTADO' and nombre_im = $nombre_foto");
	unlink("pdf/".$row2['nombre_im']);
	
	mysql_select_db($database_horizonte, $horizonte);
	$sql = "UPDATE venta_conceptos SET estatus_vc = 2, usuarioEdo4_e = $idU, fechaEdo4_e = $now where id_vc = $idE limit 1";
	  
	$update = mysql_query($sql, $horizonte) or die (mysql_error());
		
	if (!$update) { echo $sql; }
	else { echo 1; }
	
	//echo 1;
}
?>