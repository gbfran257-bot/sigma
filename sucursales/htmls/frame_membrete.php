<?php
require("../../funciones/php/values.php");
$e = $_POST["encL"];
$p = $_POST["pieL"];
$id_s = $_POST["id_s"];
$tipo_membrete = $_POST["tipoMembrete"];
?>
<iframe width="100%" height="100%" src="pdf/php/pdf/mi_pdf_sucursal_membrete.php?encL=<?php echo $e; ?>&pieL=<?php echo $p; ?>&id_s=<?php echo $id_s; ?>&tipo_membrete=<?php echo $tipo_membrete;?>"></iframe>