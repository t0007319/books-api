<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use http\Env\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticate user and generate token.
     * Throw 401 response on fail
     *
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // edge case, if null pointer exception occurs here
            if ($user) {
                $token = $user->createToken('api_token')->plainTextToken;
                return response()->json(['token' => $token], 200);
            }
        }

        // login failed, throw error
        return response()->json(['message' => 'Unauthorised'], 401);
    }

    public function register(AuthRegisterRequest $request)
    {
        return response()->json(['message' => 'works']);
    }
}
