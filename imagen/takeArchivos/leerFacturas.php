<?php
require("../../funciones/php/values.php");
 $URL = $_POST["URL"]; 
// Herramienta util para probar las expresiones regulares
// http://regex.larsolavtorvik.com/

// Expresiones regulares (RegEx) para extraer rfc de cfd ===========

// <cfdi:Receptor rfc="XXXXXXXXXXXXX" o <Receptor rfc="XXXXXXXXXXXXX"
// obtiene XXXXXXX en arreglo[1]
$RE_receptor='<.*?Receptor.*?"(.*?)"';

// <cfdi:Emisor rfc="XXXXXXXXXXXXX" o <Emisor rfc="XXXXXXXXXXXXX"
// obtiene XXXXXXX en arreglo[1]
$RE_emisor='<.*?Emisor.*?"(.*?)"';

// <cfdi:Emisor rfc="XXXXXXXXXXXXX" o <Emisor rfc="XXXXXXXXXXXXX"
// obtiene XXXXXXX en arreglo[1]
$NO_emisor='<.*?Receptor.*?nombre="(.*?)".*?>';

$Total='<.*?Comprobante.*?total="(.*?)".*?>';

// fecha="2012-07-25T11:37:25"
// Obtiene XXXX-XX-XXTXX:XX:XX en arreglo[1]
$RE_fecha='.*?((?:2|1)\d{3}(?:-|\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';

// <Concepto descripcion="XXXXXXXXXXX" o <cfdi:Concepto descripcion="XXXXXXXXXXXXXX"
// Obtiene XXXXXXXXX en arreglo[1]
$RE_concepto='<.*?Concepto.*?descripcion="(.*?)".*?>';
// ==================================================================

// Leer XML completo a una cadena de caracteres
// (la factura de ejemplo no tiene informacion real,
// y probablemente no sea valida por no tener sello etc.,
// pero por motivos practicos contiene la informacion que
// le interesa a nuestro algoritmo de extraccion)
$xmlCont=file_get_contents($URL);

//Extraer fecha del xml
preg_match_all("/".$RE_fecha."/is",$xmlCont, $matches);
$fechaxmlunix=strtotime($matches[1][0]);
$fechaxmlorig=$matches[1][0];
unset($matches);

//Extraer rfc del receptor
preg_match_all('/'.$RE_receptor.'/is',$xmlCont, $matches);
$rfcxmlre=$matches[1][0]; // RFC del receptor
unset($matches);

//Extraer rfc del emisor
preg_match_all('/'.$RE_emisor.'/is',$xmlCont, $matches);
$rfcxmlem=$matches[1][0]; // RFC del receptor
unset($matches);

//Extraer nombre del emisor
preg_match_all('/'.$NO_emisor.'/is',$xmlCont, $matches);
$NOemisor=$matches[1][0]; // RFC del receptor
unset($matches);

//Extraer el total
preg_match_all('/'.$Total.'/is',$xmlCont, $matches);
$miTotal=$matches[1][0]; // RFC del receptor
unset($matches);

//Extraer descripcion
preg_match_all('/'.$RE_concepto.'/is',$xmlCont, $matches);
$desxml=implode(", ",$matches[1]); // Descripciones de los conceptos separadas por comas
unset($matches);
//echo "Fecha UNIX es: ".$fechaxmlunix."<br />";
echo $fechaxmlorig.";}{".$rfcxmlre.";}{".$rfcxmlem.";}{".$NOemisor.";}{".$desxml.";}{".$miTotal.";}{";

?>