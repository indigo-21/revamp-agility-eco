<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // return "Login API is disabled for now";

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->where('user_type_id', 4)
            ->with('accountLevel')
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The account you are trying to access does not exist or not a Property Inspector.'],
            ]);
        }

        if ($user->propertyInspector->is_active == 0) {
            throw ValidationException::withMessages([
                'email' => ['Your account is not active. Please contact the administrator.'],
            ]);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            // return response()->json([
            //     'message' => 'Invalid credentials'
            // ], 401);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $user = User::find($request->id);

        $user->tokens()->delete();

        $user->otp_verified_at = null;
        $user->otp = null;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful',
        ]);

    }
}
