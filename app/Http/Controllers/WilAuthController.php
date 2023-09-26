<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WilAuthController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Signed in');
        }

        //return redirect('login')->with('success', 'Login details are not valid');
        return back()->withErrors(['email' => 'Credentials are invalid.'])->onlyInput('email');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'username' => 'min:5',
            'user_type' => ['required', Rule::in(['INP', 'STD'])]
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect('dashboard')->with('success', 'You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['name'],
            'approved' => false,
            'user_type' => $data['user_type'],
        ]);
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }

        return redirect('login')->withErrors('You are not allowed to access');
    }

    public function signOut(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        return Redirect('/');
    }

    public static function getUserType(User $user) {
        if ($user->name === 'Teacher')
            return 'Teacher';

        switch ($user->user_type) {
            case 'INP': return 'InP';
            case 'STD': return 'Student';
            default: return 'NAU'; // Not Applicable
        }
    }
}
