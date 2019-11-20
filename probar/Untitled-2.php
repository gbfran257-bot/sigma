
<?php 
$now1 = date('Ymd');
echo $now1;
?>
<?php
ob_start();
    $content = "
<page>
    <h1>Exemple d'utilisation</h1>
    <br>
    Ceci est un <b>exemple d'utilisation</b>
    de <a href='http://html2pdf.fr/'>HTML2PDF</a>.<br>
</page>";

    //require_once(dirname(__FILE__).'../pdf/php/html2pdf.class.php');
	require_once(dirname(__FILE__).'../pdf/php/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');
?>
