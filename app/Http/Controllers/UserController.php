<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function validate_user(Request $request)
    {
        $validatedData = $request->validate([
            'email' =>'required|email',
            'password' => 'required|min:6'
        ]);

        $user = new User();
        $user_valid = $user->check_for_users($validatedData);
        return response()->json($user_valid);
    }
}
