<?php
namespace App\Services;

use App\Models\Certificados;
use Illuminate\Support\Facades\DB;

class CertificadosService{

    public function getCertificadosByUserId($user_id)
    {
        $certificados = Certificados::where('user_id', $user_id)->first();
        return $certificados;
    }
}
