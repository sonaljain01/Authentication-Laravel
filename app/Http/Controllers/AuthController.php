<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use validator;
use App\Jobs\SendEmailJob;
use Storage;
use App\Models\GalleryImage;
class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function profileview()
    {
        return view('auth.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $user = Auth::user();
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
            $user->save();
        }

        return redirect('home')->withSuccess('Profile updated successfully');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        //login code
        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Check if the user's email is verified
            if (!$user->hasVerifiedEmail()) {
                // Log out the user and redirect them to the verification notice
                Auth::logout();
                return redirect()->route('verification.notice')->with('error', 'You need to verify your email address before logging in.');
            }

            session()->put('custom_message', 'You have logged in successfully!');
            return redirect('home');
        }
        return redirect('login')->withError('Invalid Credentials');
    }
    public function register_view()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
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

        $user->sendEmailVerificationNotification();

        $emailData = [
            'email' => $request->email,
            'subject' => 'Welcome to Our Platform',
            'message' => 'Thank you for registering!'
        ];

        SendEmailJob::dispatch($emailData);

        Auth::logout();

        return redirect('login')->withSuccess('Registration successful. Please check your email to verify your account.');
    
        // if (Auth::attempt($request->only('email', 'password'))) {

        //     session()->put('custom_message', 'Welcome! Your account has been created successfully.');

        //     Auth::login($user);
        //     return redirect('home')->withSuccess('Registration successful. Logged in!');
        // }

        // return redirect('register')->withError('Login Failed');
    }

    public function home()
    {
        return view('home');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('');
    }



}
