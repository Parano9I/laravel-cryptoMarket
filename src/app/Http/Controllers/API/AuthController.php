<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            $user = Auth::user();
            $token = $user
                ->createToken($request->email)
                ->plainTextToken;

            return response()->json([
                'status' => 'success',
                'user' => new UserResource($user),
                'authorization' => [
                    'token' => $token,
                    'type' => 'Bearer',
                ]
            ]);
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401
            );
        }
    }

    public function registration(AuthRegistrationRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ])->first();

        $token = $user
            ->createToken($request->email)
            ->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer',
            ]
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        Auth::guard('web')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function check()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Token is valid',
        ]);
    }

}
