<?php 
	require("../../funciones/php/values.php"); 
	$c=$_POST["iduL"]; $idVC=$_POST["idVC"]; $pNM=$_POST["pNM"]; $pmNM=$_POST["pmNM"]; $pRM=$_POST["pRM"]; $pmRM=$_POST["pmRM"];
	$s = $_POST["id_s"];
?>
<iframe width="100%" height="100%" src="../sigma/pdf/php/pdf/mi_pdf_consulta.php?iduL=<?php echo $c; ?>&idVC=<?php echo $idVC; ?>&pNM=<?php echo $pNM; ?>&pmNM=<?php echo $pmNM; ?>&pRM=<?php echo $pRM; ?>&pmRM=<?php echo $pmRM; ?>&id_s=<?php echo $s; ?>"></iframe>