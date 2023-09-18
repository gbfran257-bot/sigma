<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'RegimenFiscal',
    ];

    public function cfdi()
    {
        return $this->belongsTo(Cfdi::class);
    }
}
