<?php


namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\Certificados;

/**
 * Summary of Helper
 */
class Helper
{
    /**
     * Summary of userInfo
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function userInfo()
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * Summary of getCertificadosPorUsuario
     * @param mixed $userId
     * @throws \Exception
     * @return mixed
     */
    public static function getCertificadosPorUsuario($userId)
    {
        $certificados = Certificados::where('user_id', $userId)->get();

        if ($certificados->isEmpty()) {
            throw new \Exception('Los certificados no han sido cargados aún.', 404);
        }

        return $certificados[0];
    }

}
