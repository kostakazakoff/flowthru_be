<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    const SUCCESS = 'success';


    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => self::SUCCESS, 'user' => $user]);
    }


    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => AppException::invalidCredentials()->getMessage(),
                'status' => AppException::invalidCredentials()->getCode()
            ]);
        }

        $user = $request->user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 8 * 60);

        return response()->json([
            'message' => self::SUCCESS,
            'user' => $user,
            'jwt' => $token,
        ])->withCookie($cookie);
    }


    public function logout(Request $request): JsonResponse
    {
        $cookie = Cookie::forget('jwt');

        $request->user()->tokens()->delete();

        return response()->json(['message' => self::SUCCESS])->withCookie($cookie);
    }
}
