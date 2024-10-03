<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use validator;
use App\Jobs\SendEmailJob;
class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
         //login code
         if(Auth::attempt($credentials)){
            session()->put('custom_message', 'You have logged in successfully!');
            return redirect('home');
        }
        return redirect('login')->withError('Invalid Credentials');
    }
    public function register_view()
    {
        return view('auth.register');
    }

    public function register(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed|string|min:8|',
        ]);

        // //Save in users table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),

        ]);

        $emailData = [
            'email' => $request->email,
            'subject' => 'Welcome to Our Platform',
            'message' => 'Thank you for registering!'
        ];

        SendEmailJob::dispatch($emailData);

        // // login user 
        if (Auth::attempt($request->only('email', 'password'))) {
            // $request->session()->regenerate();
            session()->put('custom_message', 'Welcome! Your account has been created successfully.');

            Auth::login($user);
            return redirect('home')->withSuccess('Registration successful. Logged in!');
        }

        return redirect('register')->withError('Login Failed');
    }

    public function home(){
        return view('home');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('');
    }
}
