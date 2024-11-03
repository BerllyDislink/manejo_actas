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
        try{
            $validationRequest = $request->validated();

            if(isset($validationRequest["dependencia"])){
                if($validationRequest["rol"] == "invitado" || $validationRequest["rol"] == "estudiante"){

                    DB::transaction(function () use ($validationRequest) {
                        $user = new User();
                        $user->name = $validationRequest["nombre"];
                        $user->email = $validationRequest["email"];
                        $user->password = Hash::make($validationRequest["password"]);
                        $user->save();
                        $idNewUser = $user->id;

                        $invitado = new Invitado();
                        $invitado->NOMBRE = $validationRequest["nombre"];
                        $invitado->CARGO = $validationRequest["cargo"];
                        $invitado->DEPENDENCIA = $validationRequest["dependencia"];
                        $invitado->user_id = $idNewUser;
                        $invitado->save();
                    });

                    return response()->json("Invitado creado", 201);
                }{
                    return response()->json("No se puede crear el usuario con este rol", 422);
                }
            }

            if($validationRequest["rol"] != "estudiante" && $validationRequest["rol"] != "invitado"){

                DB::transaction(function () use ($validationRequest) {
                    $user = new User();
                    $user->name = $validationRequest["nombre"];
                    $user->email = $validationRequest["email"];
                    $user->password = Hash::make($validationRequest["password"]);
                    $user->save();
                    $user->assignRole($validationRequest["rol"]);
                    $idNewUser = $user->id;

                    $miembro = new Miembro();
                    $miembro->NOMBRE = $validationRequest["nombre"];
                    $miembro->CARGO = $validationRequest["cargo"];
                    $miembro->user_id = $idNewUser;
                    $miembro->save();
                });

                return response()->json('miembro creado', 201);
            }else{
                return response()->json("No puede crear un usuario con este rol", 422);
            }


        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], 422);
        }

    }

    public function login(LoginRequest $request)
    {
        try{
            $validationRequest = $request->validated();
            if(Auth::attempt($validationRequest)){
               $user = Auth::user();
               $token = $user->createToken('token')->plainTextToken;
               return response()->json(["token" => $token], 200);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], 422);
        }



    }

    public function userProfile(Request $request)
    {
        return response()->json(["data" => Auth::user()], 200);
    }

    public function logout(Request $request)
    {

    }
}
