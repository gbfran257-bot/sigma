<?php
require("../../funciones/php/values.php");
$e = $_POST["encL"];
$p = $_POST["pieL"];
$id_c = $_POST["id_c"];
$id_s = $_POST["id_s"];
?>
<iframe width="100%" height="100%" src="pdf/php/pdf/mi_pdf_receta_medica.php?encL=<?php echo $e; ?>&pieL=<?php echo $p; ?>&id_c=<?php echo $id_c; ?>&id_s=<?php echo $id_s; ?>"></iframe>