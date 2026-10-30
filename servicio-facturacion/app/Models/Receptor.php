<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receptor extends Model
{
    protected $fillable = [
        'Nombre',
        'Rfc',
        'UsoCFDI',
        'DomicilioFiscalReceptor',
        'RegimenFiscalReceptor',
    ];

    public function cfdi()
    {
        return $this->belongsTo(Cfdi::class);
    }
}
