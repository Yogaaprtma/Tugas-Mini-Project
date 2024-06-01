<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('registerPage')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('user');

        if ($user) {
            Auth::login($user);
            return redirect()->route('loginPage')->with('success', 'Register berhasil! Please login');
        } else {
            return redirect()->route('registerPage')->with('error', 'Register failed');;
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('loginPage')
                    ->withErrors($validator)
                    ->withInput();
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('halamanBeranda')->with('success', 'Login success');
        } else {
            return redirect()->route('loginPage')->with('error', 'Login failed email or password is incorrect');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('halamanBeranda');
    }
}
