<?php 

namespace App\Http\Helpers;

use DOMDocument;
use Exception;
use XSLTProcessor;

class XSLTTransformer {
    private $xsltProcessor;

    public function __construct() {
        $mainXSLPathOrUrl = 'http://www.sat.gob.mx/sitio_internet/cfd/4/cadenaoriginal_4_0/cadenaoriginal_4_0.xslt';
        $resourcesPath = __DIR__ . '/recursos/';

        $mainXSLFile = $resourcesPath . 'cadenaoriginal_4_0.xslt';
        if (!file_exists($mainXSLFile)) {
            $this->downloadXSL($mainXSLPathOrUrl, $mainXSLFile);
        }

        $xsl = new DOMDocument();
        if ($this->loadXSLFromFile($mainXSLFile, $xsl)) {
            $this->xsltProcessor = new XSLTProcessor();
            $this->xsltProcessor->importStylesheet($xsl);

            $this->loadAndImportAdditionalXSL($xsl, $resourcesPath);
        } else {
            throw new Exception("No se pudo cargar el archivo XSL.");
        }
    }

    public function transform($xmlPath) {
        $xml = new DOMDocument();
        $xml->load($xmlPath);

        return $this->xsltProcessor->transformToXML($xml);
    }

    private function downloadXSL($url, $targetPath) {
        $xslContent = file_get_contents($url);
        file_put_contents($targetPath, $xslContent);
    }

    private function loadXSLFromFile($filePath, &$xslDocument) {
        return $xslDocument->load($filePath);
    }

    public function transformFromString($xmlString) {
        $xml = new DOMDocument();
        $xml->loadXML($xmlString);

        return $this->xsltProcessor->transformToXML($xml);
    }

    private function loadAndImportAdditionalXSL(&$xslDocument, $resourcesPath) {
        $xslIncludes = $xslDocument->getElementsByTagName('include');
        
        foreach ($xslIncludes as $include) {
            $href = $include->getAttribute('href');
            $additionalXslPath = $resourcesPath . $href;
            
            if (!file_exists($additionalXslPath)) {
                $this->downloadXSL($href, $additionalXslPath);
            }
            
            $additionalXsl = new DOMDocument();
            if ($this->loadXSLFromFile($additionalXslPath, $additionalXsl)) {
                $this->xsltProcessor->importStylesheet($additionalXsl);
            }
        }
    }
}
