<?php $folio = $_POST['folio']; ?>
<?php $receptor = $_POST['receptor']; ?>
<?php $idu = $_POST['idU']; ?>
<?php $e = $_POST['emisor']; ?>
<iframe width="100%" height="100%" src="pdf/php/pdf/mi_pdf_reporte_entrega_transferencias.php?f=<?php echo $folio; ?>&r=<?php echo $receptor; ?>&idu=<?php echo $idu; ?>&e=<?php echo $e; ?>"></iframe>