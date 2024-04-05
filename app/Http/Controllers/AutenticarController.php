<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccesoRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AutenticarController extends Controller
{
    public function registro(RegistroRequest $request)
    {
        $user =  new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->attach($request -> roles);

        return response()->json([
            'res' => true,
            'msg' => 'usuario registrado correctamente'
        ]);
    }

    public function acceso(AccesoRequest $request)
    {

        $user = User::with('roles')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'msg' => ['Credenciales incorrectas.'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            "res" => true,
            "token" => $token,
            "usuario" => $user
        ],200);
    }

    public function cerrarSesion(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "res" => true,
            "msg" => 'Se ha eliminado el token'
        ],200);

    }
}
