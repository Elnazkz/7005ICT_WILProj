<?php

namespace App\Http\Controllers;

use App\Rules\CheckOldPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
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
            'user_type' => ['required', Rule::in([config('_global.inp'), config('_global.student')])]
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
                case config('_global.teacher'):
                    $inps = User::where('user_type', config('_global.inp'))->paginate(config('_global.items_per_page'));
                    return view('teacher.dashboard', compact('inps'));
                case config('_global.inp'):
                    $inps = User::where('user_type', config('_global.inp'))->paginate(config('_global.items_per_page'));
                    return view('inp.dashboard', compact('inps'));
                case config('_global.student'):
                    $student = User::where('user_type', config('_global.student'))->get();
                    return view('student.dashboard', compact('student'));
                default: return view('dashboard');
            }
        }

        return redirect('login')->withErrors('You are not allowed to access');
    }

    public function changeProfile() {
        if(Auth::check()){
            $user = Auth::user();
            switch ($user->user_type) {
                case config('_global.teacher'):
                    $name = $user->name;
                    return view ('teacher.change_profile', compact('name'));
                case config('_global.inp'):
                    return view ('inp.change_profile', compact('user'));
                case config('_global.student'):
                    break;
                default: return view('dashboard');
            }
        }

        return redirect('login')->withErrors('You are not allowed to access');
    }

    public function profileChanging(Request $request) {
        $request->validate([
            'email' => ['email'],
            'prev-password' => ['required', new CheckOldPassword()],
            'password' => 'required|min:6',
            'password_confirmation' => 'same:password',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->save();

        //return redirect('/dispatch')->with('success', 'Change profile successfully');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        return Redirect('/');
    }

    public function signOut(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        return Redirect('/');
    }

    public static function getUserType(User $user) {
        if ($user->name === config('_global.teacher'))
            return config('_global.teacher');

        switch ($user->user_type) {
            case config('_global.inp'): return config('_global.inp');
            case config('_global.student'): return config('_global.student');
            default: return config('_global.nau'); // Not Applicable
        }
    }

    public static function approveInps() {
        $inps = User::where('user_type', config('_global.inp'))->where('approved', false)->paginate(config('_global.items_per_page'));
        if ($inps->currentPage() > $inps->lastPage()) {
            $url = $inps->path() . '?page=' . $inps->lastPage();
            return redirect($url);
        }
        return view('teacher.approve_inps', compact('inps'));
    }

    public static function approveInp(Request $request) {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $user->approved = true;
        $user->save();

        return Redirect::back()->with('success', 'op successful');
    }
}
