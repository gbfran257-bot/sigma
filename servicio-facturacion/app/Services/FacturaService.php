<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Summary of FacturaService
 */
class FacturaService
{
    /**
     * Summary of searchXmls
     * @param mixed $clienteId
     * @param mixed $filtros
     * @return mixed
     */
    public function searchXmls($clienteId, $filtros)
    {
        list($query, $bindings) = $this->prepararConsultaInicial($clienteId);

        $result = $this->buscarFacturasConFiltros($query, $bindings, $filtros);

        return $result;
    }

    /**
     * Summary of buscarFacturaPorId
     * @param mixed $facturaId
     * @return array
     */
    public function buscarFacturaPorId($facturaId)
    {
        list($query, $bindings) = $this->prepararConsultaPorId($facturaId);

        $result = $this->buscarFacturasPorId($query, $bindings);

        return $result;
    }

    /**
     * Summary of prepararConsultaInicial
     * @param mixed $clienteId
     * @throws \Exception
     * @return array
     */
    private function prepararConsultaInicial($clienteId)
    {
        if (!Schema::hasTable('facturas')) {
            throw new Exception('La tabla "facturas" no existe.');
        }

        $query = "SELECT *, ExtractValue(xml, '//tfd:TimbreFiscalDigital/@UUID') AS uuid
                  FROM facturas
                  WHERE cliente_id = :clienteId";

        $bindings = ['clienteId' => $clienteId];

        return [$query, $bindings];
    }

    /**
     * Summary of buscarFacturasConFiltros
     * @param mixed $query
     * @param mixed $bindings
     * @param mixed $filtros
     * @return array
     */
    private function buscarFacturasConFiltros($query, $bindings, $filtros)
    {
        if (isset($filtros['emisorNombre']) && $filtros['emisorNombre'] !== null) {
            $query .= " AND ExtractValue(xml, '//cfdi:Comprobante/cfdi:Emisor/@Nombre') = :emisorNombre";
            $bindings['emisorNombre'] = $filtros['emisorNombre'];
        }

        if (isset($filtros['emisorRfc']) && $filtros['emisorRfc'] !== null) {
            $query .= " AND ExtractValue(xml, '//cfdi:Comprobante/cfdi:Emisor/@Rfc') = :emisorRfc";
            $bindings['emisorRfc'] = $filtros['emisorRfc'];
        }

        if (isset($filtros['total']) && $filtros['total'] !== null) {
            $query .= " AND ExtractValue(xml, '//cfdi:Comprobante/@Total') = :total";
            $bindings['total'] = $filtros['total'];
        }

        if (isset($filtros['receptorNombre']) && $filtros['receptorNombre'] !== null) {
            $query .= " AND ExtractValue(xml, '//cfdi:Comprobante/cfdi:Receptor/@Nombre') = :receptorNombre";
            $bindings['receptorNombre'] = $filtros['receptorNombre'];
        }

        if (isset($filtros['receptorRfc']) && $filtros['receptorRfc'] !== null) {
            $query .= " AND ExtractValue(xml, '//cfdi:Comprobante/cfdi:Receptor/@Rfc') = :receptorRfc";
            $bindings['receptorRfc'] = $filtros['receptorRfc'];
        }

        if (isset($filtros['tipoDeComprobante']) && $filtros['tipoDeComprobante'] !== null) {
            $query .= " AND ExtractValue(xml, '//cfdi:Comprobante/@TipoDeComprobante') = :tipoDeComprobante";
            $bindings['tipoDeComprobante'] = $filtros['tipoDeComprobante'];
        }

        if (isset($filtros['activa']) && $filtros['activa'] !== null) {
            $query .= " AND activa = :activa";
            $bindings['activa'] = $filtros['activa'];
        }

        if (isset($filtros['fechaInicial']) && isset($filtros['fechaFinal']) && $filtros['fechaInicial'] !== null && $filtros['fechaFinal'] !== null) {
            $query .= " AND ExtractValue(xml, '//cfdi:Comprobante/@Fecha') BETWEEN :fechaInicial AND :fechaFinal";
            $bindings['fechaInicial'] = $filtros['fechaInicial'];
            $bindings['fechaFinal'] = $filtros['fechaFinal'];
        }

        if (isset($filtros['uuid']) && $filtros['uuid'] !== null) {
            $query .= " AND ExtractValue(xml, '//tfd:TimbreFiscalDigital/@UUID') = :uuid";
            $bindings['uuid'] = $filtros['uuid'];
        }

        $result = DB::select($query, $bindings);

        return $result;
    }


    /**
     * Summary of prepararConsultaPorId
     * @param mixed $facturaId
     * @return array
     */
    private function prepararConsultaPorId($facturaId)
    {
        $query = "SELECT
                        ExtractValue(xml, '//cfdi:Comprobante/@Version') AS version,
                        ExtractValue(xml, '//cfdi:Comprobante/@Fecha') AS comprobante_fecha,
                        ExtractValue(xml, '//cfdi:Comprobante/@TipoDeComprobante') AS tipo_de_comprobante,
                        ExtractValue(xml, '//cfdi:Comprobante/@LugarExpedicion') AS lugar_expedicion,
                        ExtractValue(xml, '//cfdi:Comprobante/@Moneda') AS moneda,
                        ExtractValue(xml, '//cfdi:Comprobante/@Serie') AS serie,
                        ExtractValue(xml, '//cfdi:Comprobante/@Folio') AS folio,
                        ExtractValue(xml, '//cfdi:Comprobante/@FormaPago') AS forma_pago,
                        ExtractValue(xml, '//cfdi:Comprobante/@MetodoPago') AS metodo_pago,
                        ExtractValue(xml, '//cfdi:Comprobante/@SubTotal') AS sub_total,
                        ExtractValue(xml, '//cfdi:Comprobante/@Total') AS total,
                        ExtractValue(xml, '//cfdi:Comprobante/cfdi:Emisor/@Rfc') AS emisor_rfc,
                        ExtractValue(xml, '//cfdi:Comprobante/cfdi:Emisor/@Nombre') AS emisor_nombre,
                        ExtractValue(xml, '//cfdi:Comprobante/cfdi:Receptor/@Rfc') AS receptor_rfc,
                        ExtractValue(xml, '//cfdi:Comprobante/cfdi:Receptor/@Nombre') AS receptor_nombre,
                        ExtractValue(xml, '//cfdi:Comprobante/cfdi:Receptor/@UsoCFDI') AS receptor_uso_cfdi,
                        ExtractValue(xml, '//tfd:TimbreFiscalDigital/@UUID') AS uuid,
                        ExtractValue(xml, '//tfd:TimbreFiscalDigital/@FechaTimbrado') AS fecha_timbrado,
                        xml,
                        pdf,
                        activa
                    FROM facturas
                    WHERE id = :facturaId";

        $bindings = ['facturaId' => $facturaId];

        return [$query, $bindings];
    }

    /**
     * Summary of buscarFacturasPorId
     * @param mixed $query
     * @param mixed $bindings
     * @return array
     */
    private function buscarFacturasPorId($query, $bindings)
    {
        $result = DB::select($query, $bindings);

        return $result;
    }
}
