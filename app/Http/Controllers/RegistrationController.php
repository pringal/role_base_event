<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->syncRoles(['buyer']);
        return redirect('/')->with('success', 'Registration successful!');
    }
}
