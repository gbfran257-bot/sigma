<?php ob_start(); ?>
<?php
  $id_sucursal = intval(htmlspecialchars($_GET['id_s']));
  $query_tamaño_impresion = "SELECT tamano_h_cm FROM sucursales WHERE id_su = {$id_sucursal}";
  require_once "../../../Connections/horizonte2.php";
  $resultado = mysqli_query($horizonte, $query_tamaño_impresion) or die(mysqli_error($horizonte));
  $print_size = mysqli_fetch_object($resultado)->tamano_h_cm == 1 ? "Letter" : "A5";
  define("LETTER_SIZE_HEADER_FOOTER_WIDTH", 785); // Width del header y del footer para una impresión tamaño carta
  define("HALF_LETTER_SIZE_HEADER_FOOTER_WIDTH", 525); // Width del header y del footer para una impresión tamaño carta
  define("HEADER_FOOTER_HEIGHT", 80);
	//ob_start guardará en un búfer lo que esté en la ruta del include.
  include(dirname(__FILE__).'/vistas/mi_pdf_nota_medica.php');
  //echo $_POST["cuerpoL"];
    //En una variable llamada $content se obtiene lo que tenga la ruta especificada
    //NOTA: Se usa ob_get_clean porque trae SOLO el contenido
    //Evitará este error tan común en FPDF: FPDF error: Some data has already been output, can't send PDF
    $content = ob_get_clean();
    //Se obtiene la librería
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    /* Las lineas siguientes siempre serán las mismas A mi parecer no hay mucho que explicar. Se explican por sí solas :D */
    try{
        $html2pdf = new HTML2PDF('P', $print_size, 'es', true, 'UTF-8', 3); //Configura la hoja
        $html2pdf->pdf->SetDisplayMode('fullwidth'); //Ver otros parámetros para SetDisplaMode
        $html2pdf->writeHTML($content); //Se escribe el contenido 
        $html2pdf->Output('estudio '.date('H:i:s').'.pdf'); //Nombre default del PDF
        ob_end_clean();

    }
    catch(HTML2PDF_exception $e) { echo $e; exit; }
?>
