<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        // Validating the incoming request using the RegisterRequest class
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->syncRoles(['buyer']);
        return response()->json(['user'=>new UserResource($user),'message'=>'User Registration successful!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            $userResource = new UserResource($user);
            $roles = $user->getRoleNames(); // Returns an array of role names associated with the user

            // UserResource to format the user data
            return response()->json([
                'token' => $token,
                'user' => $userResource,
                'roles'=>$roles
            ], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
