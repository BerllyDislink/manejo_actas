<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateUserCredential;
use App\Http\Requests\Api\LoginRequest;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    public function __construct(public AuthService $authService){}

    public function register(CreateUserCredential $request): \Illuminate\Http\JsonResponse
    {
        $newUserInf = $request->validated();
        return $this->authService->register($newUserInf);
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $validationRequest = $request->validated();
        return $this->authService->userLogin($validationRequest);
    }

    public function userProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->getProfile();
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->userLogout($request);
    }
}
