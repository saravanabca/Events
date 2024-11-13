<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

 

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)
                    ->where('password', $request->password)
                    ->first();
    
        if ($user) {
        
            Auth::login($user);

            return response()->json([
                'status' => true,
                'message' => 'Welcome! You have logged in successfully.',
            ]);
            // return Redirect::to('product');
        }
       
        else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password.',
            ]);
        }
    }
    
    

    
}