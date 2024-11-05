<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateUserCredential;
use App\Http\Requests\Api\LoginRequest;
use App\Models\Invitado;
use App\Models\Miembro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\MockObject\Exception;

class AuthController extends Controller
{
    public function register(CreateUserCredential $request)
    {
            $validationRequest = $request->validated();

                    DB::transaction(function () use ($validationRequest) {
                        $user = new User();
                        $user->name = $validationRequest["nombre"];
                        $user->email = $validationRequest["email"];
                        $user->password = Hash::make($validationRequest["password"]);
                        $user->save();
                        $user->assignRole($validationRequest["rol"]);
                        $idNewUser = $user->id;

                        if($validationRequest["rol"] == "invitado" || $validationRequest["rol"] == "estudiante"){
                            $invitado = new Invitado();
                            $invitado->NOMBRE = $validationRequest["nombre"];
                            $invitado->CARGO = $validationRequest["cargo"];
                            $invitado->DEPENDENCIA = $validationRequest["dependencia"] == "" ? "N/A" : $validationRequest["dependencia"];
                            $invitado->user_id = $idNewUser;
                            $invitado->save();
                        }else{
                            $miembro = new Miembro();
                            $miembro->NOMBRE = $validationRequest["nombre"];
                            $miembro->CARGO = $validationRequest["cargo"];
                            $miembro->user_id = $idNewUser;
                            $miembro->save();
                        }
                    });
                    return response()->json(['message' => "Registro exitoso"], 201);

    }

    public function login(LoginRequest $request)
    {

            $validationRequest = $request->validated();
            if(Auth::attempt($validationRequest)){
               $user = Auth::user();
               $token = $user->createToken('token')->plainTextToken;
               return response()->json(["token" => $token], 200);
            }

            return response()->json(['message' => 'Las credenciales de inicio de sesion no son validas'], 401);

    }

    public function userProfile(Request $request)
    {
        return response()->json(["data" => Auth::user()], 200);
    }

    public function logout(Request $request)
    {

    }
}
