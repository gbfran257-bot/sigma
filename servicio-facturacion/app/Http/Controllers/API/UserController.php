<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{ // Agrega la excepción específica que deseas capturar

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                $customErrors = [];
                $errors = $validator->errors();

                foreach ($errors->all() as $message) {
                    $customErrors[] = $message;
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Sucedio un error al intentar crear el usuario',
                    'messageDetail' => $customErrors,
                ], 400);
            }

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario creado con éxito',
                'messageDetail' => $user,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sucedio un error al intentar crear el usuario',
                'messageDetail' => $e->getMessage(),
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sucedio un error al intentar crear el usuario',
                'messageDetail' => $e->getMessage(),
            ], 500);
        }
    }

}
