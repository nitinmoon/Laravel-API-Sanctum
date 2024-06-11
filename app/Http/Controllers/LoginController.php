<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class LoginController extends Controller
{
    /**
     * Login method
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);
        
        try {
            
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
               
                $token = $user->createToken('mytoken')->plainTextToken;

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'User registered',
                        'user' => $user,
                        'token' => $token
                    ],
                    200
                );
            } else {
                 
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Credentials are not matched',
                    ],
                    401
                );

            }

           
            
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

     /**
     * Login method
     */
    public function register(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('mytoken')->plainTextToken;

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User registered',
                    'user' => $user,
                    'token' => $token
                ],
                201
            );
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    
     /**
     * Logout method
     */
    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'User logout'
                ],
                200
            );
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
