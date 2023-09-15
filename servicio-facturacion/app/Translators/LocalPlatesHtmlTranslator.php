<?php

declare(strict_types=1);

namespace App\Services\Translators;

use Exception;
use League\Plates\Engine as PlatesEngine;
use NumberFormatter;
use PhpCfdi\CfdiToPdf\Builders\HtmlTranslators\HtmlTranslatorInterface as HtmlTranslatorInterface;
use PhpCfdi\CfdiToPdf\CfdiData;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

/**
 * Summary of LocalPlatesHtmlTranslator
 */
class LocalPlatesHtmlTranslator implements HtmlTranslatorInterface
{
    /** @var string */
    private $directory;

    /** @var string */
    private $template;
    /**
     * Summary of extras
     * @var
     */
    private $extras;

    /**
     * PlatesHtmlTranslator constructor.
     *
     * @param string $directory
     * @param string $template
     */
    public function __construct(string $directory, string $template, $extras = null)
    {
        $this->directory = $directory;
        $this->template = $template;
        $this->extras = $extras;
    }

    /**
     * Summary of translate
     * @param \PhpCfdi\CfdiToPdf\CfdiData $cfdiData
     * @return string
     */
    public function translate(CfdiData $cfdiData): string
    {
        $plates = new PlatesEngine($this->directory());
        $comprobanteCats = $this->getStringFromCat($cfdiData);
        $TotalLetra = $this->getTotalLetra($cfdiData);
        $impuestos = new Impuestos();
        $extras = $this->extras;

        return $plates->render(
            $this->template(),
            compact('cfdiData', 'comprobanteCats', 'impuestos', 'TotalLetra', 'extras')
        );
    }

    /**
     * Summary of directory
     * @return string
     */
    public function directory(): string
    {
        return $this->directory;
    }

    /**
     * Summary of template
     * @return string
     */
    public function template(): string
    {
        return $this->template;
    }

    /**
     * Summary of build
     * @param \PhpCfdi\CfdiToPdf\CfdiData $data
     * @param string $destination
     * @return void
     */
    public function build(CfdiData $data, string $destination)
    {
        file_put_contents($destination, $this->buildPdf($data));
    }

    /**
     * Transforms CfdiData to Pdf string
     *
     * @param CfdiData $data
     * @return string
     */
    public function buildPdf(CfdiData $data): string
    {
        $html = $this->convertNodeToHtml($data);
        $output = $this->convertHtmlToPdf($html);
        return $output;
    }

    /**
     * Summary of convertHtmlToPdf
     * @param string $html
     * @throws \Exception
     * @return string
     */
    public function convertHtmlToPdf(string $html): string
    {
        try {
            $pageFormat = array(215.9, 279.4);
            $pdf = new Html2Pdf('P', $pageFormat, 'es', true, null, [2, 2, 2, 2], false);
            $pdf->writeHTML($html);
            return $pdf->output('', 'S');
        } catch (Html2PdfException $exception) {
            throw new Exception('No se pudo generar el PDF: ' . $exception->getMessage(), 500, $exception);
        }
    }

    /**
     * Summary of convertNodeToHtml
     * @param \PhpCfdi\CfdiToPdf\CfdiData $cfdiData
     * @return string
     */
    public function convertNodeToHtml(CfdiData $cfdiData): string
    {
        return $this->translate($cfdiData);
    }

    /**
     * Summary of getStringFromCat
     * @param \PhpCfdi\CfdiToPdf\CfdiData $cfdiData
     * @return \stdClass
     */
    public function getStringFromCat(CfdiData $cfdiData)
    {
        $comprobanteCats = new \stdClass();
        $emisor = $cfdiData->emisor();
        $comprobante = $cfdiData->comprobante();
        $receptor = $cfdiData->receptor();
        $relacionados = $comprobante->searchNode('cfdi:CfdiRelacionados');
        $comprobanteCats->regimenFiscal = $this->getRegimenFiscalString($emisor['RegimenFiscal']);
        $comprobanteCats->regimenFiscalReceptor = $this->getRegimenFiscalString($receptor['RegimenFiscalReceptor']);
        $comprobanteCats->tipoComprobante = $this->getTipoComprobanteString($comprobante['TipoDeComprobante']);
        $comprobanteCats->metodoPago = $this->getMetodoPagoString($comprobante['MetodoPago']);
        $comprobanteCats->formaPago = $this->getFormaPagoString($comprobante['FormaPago']);
        $comprobanteCats->usoCfdi = $this->getUsoCfdiString($receptor['UsoCFDI']);
        if((null !== $relacionados)) {
            $comprobanteCats->tipoRelacion = $this->getTipoRelacionString($relacionados['TipoRelacion']);
        }
        return $comprobanteCats;
    }

    /**
     * Summary of getTotalLetra
     * @param \PhpCfdi\CfdiToPdf\CfdiData $cfdiData
     * @return string
     */
    public function getTotalLetra(CfdiData $cfdiData)
    {
        $comprobante = $cfdiData->comprobante();
        $formatterES =  new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
        $n = $comprobante['Total'];
        $izquierda = intval(floor($n));
        $derecha = intval(($n - floor($n)) * 100);

        if ($comprobante['Moneda'] == "MXN") {
            $moneda = "Pesos";
        } elseif ($comprobante['Moneda'] == "USD") {
            $moneda = "Dólares";
        } elseif ($comprobante['Moneda'] == "EUR") {
            $moneda = "Euros";
        }

        return strtoupper(ucwords($formatterES->format($izquierda)) . " ".$moneda.", ". str_pad($derecha."", 2, '0', STR_PAD_LEFT) . "/100");
    }

    /**
     * Summary of getRegimenFiscalString
     * @param string $regimenFiscal
     * @return string
     */
    public function getRegimenFiscalString(string $regimenFiscal)
    {
        $regimenFiscalDescriptions = [
            '601' => 'General de Ley Personas Morales',
            '603' => 'Personas Morales con Fines no Lucrativos',
            '605' => 'Sueldos y Salarios e Ingresos Asimilados a Salarios',
            '606' => 'Arrendamiento',
            '607' => 'Régimen de Enajenación o Adquisición de Bienes',
            '608' => 'Demás ingresos',
            '610' => 'Residentes en el Extranjero sin Establecimiento Permanente en México',
            '611' => 'Ingresos por Dividendos (socios y accionistas)',
            '612' => 'Personas Físicas con Actividades Empresariales y Profesionales',
            '614' => 'Ingresos por intereses',
            '615' => 'Régimen de los ingresos por obtención de premios',
            '616' => 'Sin obligaciones fiscales',
            '620' => 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos',
            '621' => 'Incorporación Fiscal',
            '622' => 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',
            '623' => 'Opcional para Grupos de Sociedades',
            '624' => 'Coordinados',
            '625' => 'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas',
            '626' => 'Régimen Simplificado de Confianza',
        ];

        return isset($regimenFiscalDescriptions[$regimenFiscal]) ? $regimenFiscalDescriptions[$regimenFiscal] : '';
    }

    /**
     * Summary of getTipoComprobanteString
     * @param string $tipoComprobante
     * @return string
     */
    public function getTipoComprobanteString(string $tipoComprobante)
    {
        $tipoComprobanteDescriptions = [
            'I' => 'Ingreso',
            'E' => 'Egreso',
            'T' => 'Traslado',
            'N' => 'Nómina',
            'P' => 'Pago',
        ];

        return isset($tipoComprobanteDescriptions[$tipoComprobante]) ? $tipoComprobanteDescriptions[$tipoComprobante] : '';
    }

    /**
     * Summary of getMetodoPagoString
     * @param string $metodoPago
     * @return string
     */
    public function getMetodoPagoString(string $metodoPago)
    {
        $metodoPagoDescriptions = [
            'PUE' => 'Pago en una sola exhibición',
            'PPD' => 'Pago en parcialidades o diferido',
        ];

        return isset($metodoPagoDescriptions[$metodoPago]) ? $metodoPagoDescriptions[$metodoPago] : '';
    }

    /**
     * Summary of getFormaPagoString
     * @param string $formaPago
     * @return string
     */
    public function getFormaPagoString(string $formaPago)
    {
        $formaPagoDescriptions = [
            '01' => 'Efectivo',
            '02' => 'Cheque nominativo',
            '03' => 'Transferencia electrónica de fondos',
            '04' => 'Tarjeta de crédito',
            '05' => 'Monedero electrónico',
            '06' => 'Dinero electrónico',
            '08' => 'Vales de despensa',
            '12' => 'Dación en pago',
            '13' => 'Pago por subrogación',
            '14' => 'Pago por consignación',
            '15' => 'Condonación',
            '17' => 'Compensación',
            '23' => 'Novación',
            '24' => 'Confusión',
            '25' => 'Remisión de deuda',
            '26' => 'Prescripción o caducidad',
            '27' => 'A satisfacción del acreedor',
            '28' => 'Tarjeta de débito',
            '29' => 'Tarjeta de servicios',
            '30' => 'Aplicación de anticipos',
            '31' => 'Intermediario pagos',
            '99' => 'Por definir',
        ];

        return isset($formaPagoDescriptions[$formaPago]) ? $formaPagoDescriptions[$formaPago] : '';
    }

    /**
     * Summary of getUsoCfdiString
     * @param string $usoCfdi
     * @return string
     */
    public function getUsoCfdiString(string $usoCfdi)
    {
        $usoCfdiDescriptions = [
            'G01' => 'Adquisición de mercancias',
            'G02' => 'Devoluciones, descuentos o bonificaciones',
            'G03' => 'Gastos en general',
            'I01' => 'Construcciones',
            'I02' => 'Mobilario y equipo de oficina por inversiones',
            'I03' => 'Equipo de transporte',
            'I04' => 'Equipo de computo y accesorios',
            'I05' => 'Dados, troqueles, moldes, matrices y herramental',
            'I06' => 'Comunicaciones telefónicas',
            'I07' => 'Comunicaciones satelitales',
            'I08' => 'Otra maquinaria y equipo',
            'D01' => 'Honorarios médicos, dentales y gastos hospitalarios',
            'D02' => 'Gastos médicos por incapacidad o discapacidad',
            'D03' => 'Gastos funerales',
            'D04' => 'Donativos',
            'D05' => 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación)',
            'D06' => 'Aportaciones voluntarias al SAR',
            'D07' => 'Primas por seguros de gastos médicos',
            'D08' => 'Gastos de transportación escolar obligatoria',
            'D09' => 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones',
            'D10' => 'Pagos por servicios educativos (colegiaturas)',
            'S01' => 'Sin efectos fiscales',
        ];

        return isset($usoCfdiDescriptions[$usoCfdi]) ? $usoCfdiDescriptions[$usoCfdi] : '';
    }

    /**
     * Summary of getTipoRelacionString
     * @param string $tipoRelacion
     * @return string
     */
    public function getTipoRelacionString(string $tipoRelacion)
    {
        $tipoRelacionDescriptions = [
            '01' => 'Nota de crédito de los documentos relacionados',
            '02' => 'Nota de débito de los documentos relacionados',
            '03' => 'Devolución de mercancía sobre facturas o traslados previos',
            '04' => 'Sustitución de los CFDI previos',
            '05' => 'Traslados de mercancías facturados previamente',
            '06' => 'Factura generada por los traslados previos',
            '07' => 'CFDI por aplicación de anticipo',
        ];

        return isset($tipoRelacionDescriptions[$tipoRelacion]) ? $tipoRelacionDescriptions[$tipoRelacion] : '';
    }
}

/**
 * Summary of Impuestos
 */
class Impuestos
{
    /**
     * Summary of impuestosString
     * @param string $var
     * @return string
     */
    public function impuestosString(string $var)
    {
        $impuestosDescriptions = [
            '001' => 'ISR',
            '002' => 'IVA',
            '003' => 'IEPS',
        ];

        return isset($impuestosDescriptions[$var]) ? $impuestosDescriptions[$var] : '';
    }

    /**
     * Summary of getMetodoPagoString
     * @param string $metodoPago
     * @return string
     */
    public function getMetodoPagoString(string $metodoPago)
    {
        $metodoPagoDescriptions = [
            'PUE' => 'Pago en una sola exhibición',
            'PPD' => 'Pago en parcialidades o diferido',
        ];

        return $metodoPagoDescriptions[$metodoPago] ?? '';
    }

    /**
     * Summary of getFormaPagoString
     * @param string $formaPago
     * @return string
     */
    public function getFormaPagoString(string $formaPago)
    {
        $formaPagoDescriptions = [
            '01' => 'Efectivo',
            '02' => 'Cheque nominativo',
            '03' => 'Transferencia electrónica de fondos',
            '04' => 'Tarjeta de crédito',
            '05' => 'Monedero electrónico',
            '06' => 'Dinero electrónico',
            '08' => 'Vales de despensa',
            '12' => 'Dación en pago',
            '13' => 'Pago por subrogación',
            '14' => 'Pago por consignación',
            '15' => 'Condonación',
            '17' => 'Compensación',
            '23' => 'Novación',
            '24' => 'Confusión',
            '25' => 'Remisión de deuda',
            '26' => 'Prescripción o caducidad',
            '27' => 'A satisfacción del acreedor',
            '28' => 'Tarjeta de débito',
            '29' => 'Tarjeta de servicios',
            '30' => 'Aplicación de anticipos',
            '31' => 'Intermediario pagos',
            '99' => 'Por definir',
        ];

        return $formaPagoDescriptions[$formaPago] ?? '';
    }

    /**
     * Summary of getStringMoneda
     * @param string $moneda
     * @return string
     */
    public function getStringMoneda(string $moneda)
    {
        $monedaDescriptions = [
            'MXN' => 'Pesos Mexicanos',
            'USD' => 'Dólares',
            'EUR' => 'Euros',
        ];

        return $monedaDescriptions[$moneda] ?? '';
    }
}
