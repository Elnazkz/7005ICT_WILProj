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

        $input = $request->only('email', 'password');
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = array($fieldType => $input['email'], 'password' => $input['password']);
        if(auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dispatch')->with('success', 'Signed in');
        }

        return back()->withErrors(['email' => 'Credentials are invalid.'])->onlyInput('email');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|unique:users|not_regex:/^(teacher)$/i',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'user_type' => ['required', Rule::in(['InP', 'Student'])]
        ]);

        $data = $request->all();
        $check = $this->create($data);
        Auth::login($check);

        return redirect('/dispatch')->with('success', 'You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'approved' => false,
            'user_type' => $data['user_type'],
        ]);
    }

    public function dispatch()
    {
        if(Auth::check()){
            switch (Auth::user()['user_type']) {
                case 'Teacher':
                    $inps = User::where('user_type', 'InP')->paginate(5);
                    return view('teacher.dashboard', compact('inps'));
                case 'InP':
                    return view('inp.dashboard');
                case 'Student':
                    return view('student.dashboard');
                default: return view('dashboard');
            }
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
            case 'InP': return 'InP';
            case 'Student': return 'Student';
            default: return 'NAU'; // Not Applicable
        }
    }
}
