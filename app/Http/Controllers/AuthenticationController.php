<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create(request(['name', 'email', 'password']));

        if (!$user) {
            $status = "failed";
            $message = "User creation failed";
        } else {
            $status = "success";
            $message = "User created successfully";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Your password or email is incorrect'
            ]);
        }

        $token = $user->createToken('Login')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'You have been logged in successfully',
            'data' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $data = $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'You have been logged out'
        ]);
    }
}
