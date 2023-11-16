<?php $id_usuario = $_POST['id_usuario']; ?>
<?php $folio_transferencia = $_POST['folio_transferencia']; ?>
<?php $fecha_movimiento = $_POST['fecha_movimiento']; ?>
<?php $sucursal_origen = $_POST['sucursal_origen']; ?>
<?php $sucursal_destino = $_POST['sucursal_destino']; ?>
<?php $productos_seleccionados = urlencode(base64_encode(serialize(json_decode($_POST['productos_seleccionados'])))); ?>

<iframe width="100%" height="100%" src="pdf/php/pdf/mi_pdf_hoja_entrega.php?idu=<?php echo $id_usuario; ?>&ft=<?php echo $folio_transferencia; ?>&fm=<?php echo $fecha_movimiento; ?>&so=<?php echo $sucursal_origen; ?>&sd=<?php echo $sucursal_destino; ?>&ps=<?php echo $productos_seleccionados; ?>"></iframe>