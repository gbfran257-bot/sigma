<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Cancelation\CancelationController;
use App\Http\Controllers\Certificates\CertificatesController;
use App\Http\Controllers\Stamp\CfdiController;
use App\Http\Controllers\Valida\VerifyController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/authentication', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Rutas para cfdi
    Route::prefix('cfdi')->group(function () {
        Route::post('/stamp', [CfdiController::class, 'stamp']);
        Route::get('/get', [CfdiController::class, 'get']);
        // Rutas para prefactura
        // Route::post('precfdi', function (Request $request) {
        //     return app()->call([CfdiController::class, 'stamp'], ['request' => $request, 'productivo' => false]);
        // });
    });

    // Rutas para certificates
    Route::prefix('certificates')->group(function () {
        Route::get('/store', [CertificatesController::class, 'store']);
    });

    // Rutas para cancel
    Route::prefix('cancelation')->group(function () {
        Route::post('/pfx', [CancelationController::class, 'pfx']);
    });

    // Rutas para verify
    Route::prefix('verify')->group(function () {
        Route::get('/cfdi', [VerifyController::class, 'consultarCfdiPorUUID']);
    });  

    // Ruta para crear usuarios
    Route::post('/register', [UserController::class, 'register']);

});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'
    ], 404);
});


//Prueba autenticado por la URL token
Route::get('/url-auth', function (Request $request) {
    $tokenBase64 = $request->input('token');

    if (!$tokenBase64) {
        return response()->json(['message' => 'Token missing.'], 401);
    }

    $token = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenBase64));

    $user = User::where('api_token', $token)->first();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    return response()->json(['message' => 'Authenticated']);

});


// Route::middleware('auth:sanctum')->any('{any}', function () {
//     return response()->json(['error' => 'Ruta no encontrada'], Response::HTTP_NOT_FOUND);
// })->where('any', '.*');
