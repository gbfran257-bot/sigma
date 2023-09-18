<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoImpuestos extends Model
{
    use HasFactory;

    protected $fillable = [
        // campos relacionados a impuestos para el concepto
    ];

    public function concepto()
    {
        return $this->belongsTo(Concepto::class);
    }
}
