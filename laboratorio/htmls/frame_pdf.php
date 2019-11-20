<?php 
	require("../../funciones/php/values.php"); 
	$x = $_POST["encL"]; $y = $_POST["pieL"]; $c = $_POST["iduL"]; $f = $_POST["firmaL"]; $s = $_POST["id_s"];
?>
<iframe width="100%" height="100%" src="pdf/php/pdf/mi_pdf.php?encL=<?php echo $x; ?>&pieL=<?php echo $y; ?>&iduL=<?php echo $c; ?>&id_s=<?php echo $s; ?>"></iframe>