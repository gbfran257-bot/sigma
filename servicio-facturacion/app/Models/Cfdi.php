<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cfdi extends Model
{
    use HasFactory;

    public static $validationRules = [
        'Certificado' => 'nullable',
        'CondicionesDePago' => 'nullable|string',
        'Fecha' => 'required|date',
        'Folio' => 'required|string',
        'FormaPago' => 'nullable',
        'LugarExpedicion' => 'required|string',
        'MetodoPago' => 'nullable',
        'Moneda' => 'required|string',
        'Serie' => 'required|string',
        'SubTotal' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'TipoDeComprobante' => 'required|string',
        // 'Emisor.RegimenFiscal' => 'required|string',
        // 'Receptor.Nombre' => 'required|string',
        // 'Receptor.Rfc' => 'required|string',
        // 'Receptor.UsoCFDI' => 'required|string',
        // 'Receptor.DomicilioFiscalReceptor' => 'required|string',
        // 'Receptor.RegimenFiscalReceptor' => 'required|string',
    ];

    protected $fillable = [
        'Certificado',
        'CondicionesDePago',
        'Fecha',
        'Folio',
        'FormaPago',
        'LugarExpedicion',
        'MetodoPago',
        'Moneda',
        'NoCertificado',
        'Sello',
        'Serie',
        'SubTotal',
        'TipoDeComprobante',
        'Total',
    ];

    public function emisor()
    {
        return $this->hasOne(Emisor::class);
    }

    public function receptor()
    {
        return $this->hasOne(Receptor::class);
    }

    public function conceptos()
    {
        return $this->hasMany(Concepto::class);
    }

    public function impuestos()
    {
        return $this->hasOne(Impuestos::class);
    }
}
