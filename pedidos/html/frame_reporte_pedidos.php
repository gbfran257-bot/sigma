<?php $id_usuario = intval($_POST['id_usuario']); ?>
<?php $sucursal = htmlentities($_POST['sucursal'], ENT_QUOTES, "utf-8"); ?>
<?php $fecha_impresion = htmlentities($_POST['fecha_impresion'], ENT_QUOTES, "utf-8"); ?>
<?php $pedidos = urlencode(base64_encode(serialize(json_decode($_POST['pedidos'])))); ?>

<iframe lang="es" width="100%" height="100%" src="pdf/php/pdf/mi_pdf_reporte_pedidos.php?idu=<?php echo $id_usuario; ?>&s=<?php echo $sucursal; ?>&fi=<?php echo $fecha_impresion; ?>&p=<?php echo $pedidos; ?>"></iframe>