<?php

namespace App\Service;

use App\Models\Invitado;
use App\Models\Miembro;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mockery\Exception;
use Illuminate\Http\Request;

class AuthService
{


    public function register (Array $newUserInf): \Illuminate\Http\JsonResponse
    {
        try{
            DB::transaction(function () use ($newUserInf){
                $user = new User();
                $user->name = $newUserInf["nombre"];
                $user->email = $newUserInf["email"];
                $user->password = Hash::make($newUserInf["password"]);
                $user->save();
                $user->assignRole($newUserInf["rol"]);
                $idNewUser = $user->id;

                $this->createProfile($newUserInf, $idNewUser);
            });
        }catch (Exception $e){
            return response()->json([
                "message" => "no fue posible crear un nuevo usuario",
                "error" => $e->getMessage()
                ], 500);
        }

        return response()->json(["message" => "usuario creado"], 201);
    }

    /**
     * @throws ValidationException
     */
    public function userLogin (Array $credentials){
        if(!Auth::attempt($credentials)){
            Throw ValidationException::withMessages(
                [
                    "message" => "Las credenciales de inicio de sesion no son validas"
                ]
            );
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token], 200);

    }

    public function getProfile () {
        $profile = collect([]);

        if(!Auth::user()->has('miembros')->get()->isEmpty()){
            $userProfile = Auth::user()->load('miembros', 'roles');
            $profile = collect([[
                "id_user" => $userProfile->id,
                "id_miembro" => $userProfile->miembros->IDMIEMBRO,
                "email" => $userProfile->email,
                "nombre" => $userProfile->miembros->NOMBRE,
                "cargo" => $userProfile->miembros->CARGO,
                'rol' => $userProfile->roles->pluck('name')->implode(',') ?? null
            ]]);

        }elseif (!Auth::user()->has('invitados')->get()->isEmpty()){
            $userProfile = Auth::user()->load('invitados', 'roles');
            $profile = collect([
                "id_user" => $userProfile->id,
                "id_invitado" => $userProfile->invitados->IDINVITADO,
                "email" => $userProfile->email,
                "nombre" => $userProfile->invitados->NOMBRE,
                "cargo" => $userProfile->invitados->CARGO,
                'rol' => $userProfile->roles->pluck('name')->implode(',') ?? null
            ]);
        }

        return response()->json(['data' => $profile], 200);
    }

    public function userLogout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json(["message" => "sesion cerrada exitosamente!"],200);
    }

    private function createProfile (Array $newUserInf, int $idNewUser): void
    {

        if($newUserInf["rol"] == "invitado" || $newUserInf["rol"] == "estudiante"){
            $invitado = new Invitado();
            $invitado->NOMBRE = $newUserInf["nombre"];
            $invitado->CARGO = $newUserInf["cargo"];
            $invitado->DEPENDENCIA = $newUserInf["dependencia"] == "" ? "N/A" : $newUserInf["dependencia"];
            $invitado->user_id = $idNewUser;
            $invitado->save();
        }else{
            $miembro = new Miembro();
            $miembro->NOMBRE = $newUserInf["nombre"];
            $miembro->CARGO = $newUserInf["cargo"];
            $miembro->user_id = $idNewUser;
            $miembro->save();
        }
    }

}
