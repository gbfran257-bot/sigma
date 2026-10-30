<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificados extends Model
{
    protected $fillable = [
        'user_id', 'numero_certificado', 'pfx', 'password',
        'fecha_inicio', 'fecha_fin', 'rfc', 'razon_social',
        'codigo_postal', 'activo',
    ];
}
