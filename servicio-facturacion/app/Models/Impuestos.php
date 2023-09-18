<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impuestos extends Model
{
    use HasFactory;

    protected $fillable = [
        // campos relacionados a impuestos
    ];

    public function cfdi()
    {
        return $this->belongsTo(Cfdi::class);
    }
}
