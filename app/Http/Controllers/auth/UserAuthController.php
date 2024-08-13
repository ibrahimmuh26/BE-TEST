<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\employee;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    //
    public function login(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = admin::where('username', $validated['username'])->first();
        if ($user && $user->tokens()->count() > 0) {
            return response()->json([
                'message' => 'Already logged in',
                401
            ]);
        } else {
            if (!Auth::attempt($validated)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid username or password',
                ], 401);
            } else {

                $user = Auth::user();

                $create_token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'data' => [
                        'token' => $create_token,
                        'admin' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'username' => $user->username,
                            'phone' => $user->phone,
                            'email' => $user->email,
                        ],
                    ],
                ]);
            }
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'username' => 'required|string|unique:admins',
                'email' => 'required|string|email|unique:admins',
                'password' => 'required|string',
                'phone' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
        $employee = new admin();
        $employee->username = $request->username;
        $employee->password = Hash::make($request->password);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful',
            'admin' => $employee,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful',
        ]);
    }
}
