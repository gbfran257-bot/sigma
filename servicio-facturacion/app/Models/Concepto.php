<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'Cantidad',
        'ClaveProdServ',
        'ClaveUnidad',
        'Descripcion',
        'Importe',
        'Unidad',
        'ValorUnitario',
    ];

    public function cfdi()
    {
        return $this->belongsTo(Cfdi::class);
    }

    public function impuestos()
    {
        return $this->hasOne(ConceptoImpuestos::class);
    }
}
