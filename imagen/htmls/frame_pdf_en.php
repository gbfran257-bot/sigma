<?php 
	require("../../funciones/php/values.php"); 
	$c = $_POST["iduL"]; $idVC = $_POST["idVC"]; $mems = $_POST["mems"]; $s = $_POST["id_s"];
?>
<iframe width="100%" height="100%" src="pdf/php/pdf/mi_pdf_endo.php?iduL=<?php echo $c; ?>&idVC=<?php echo $idVC; ?>&mems=<?php echo $mems; ?>&id_s=<?php echo $s; ?>"></iframe>