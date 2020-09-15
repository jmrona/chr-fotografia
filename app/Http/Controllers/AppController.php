<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AppController extends Controller
{
    public function init()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)){
            return response()->json(Auth::user(), 200);
        }else{
            return response()->json(['error' => 'Could not log you in.'], 401);
        }
    }

    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (isset($user->id)){
            return response()->json(['error' => 'E-mail already exists'], 401);
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        Auth::login($user);

        return response()->json($user, 200);
    }


    public function logout()
    {
        Auth::logout();
    }
}
