<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Role;
use App\Models\UserRole;
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
    public function __construct()
    {
        $this->middleware('auth')->only(['dispatch', 'changeProfile']);
    }

    //
    public function index()
    {
        return view('auth.login');
    }

    public function custom_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $input = $request->only('email', 'password');
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = array($fieldType => $input['email'], 'password' => $input['password']);
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dispatch')->with('success', 'Signed in');
        }

        return back()->withErrors(['email' => 'Credentials are invalid.'])->onlyInput('email');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function custom_registration(Request $request)
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
        switch (Auth::user()['user_type']) {
            case config('_global.teacher'):
                $inps = User::where('user_type', config('_global.inp'))->paginate(config('_global.items_per_page'));
                return view('teacher.dashboard', compact('inps'));
            case config('_global.inp'):
                $inps = User::where('user_type', config('_global.inp'))->paginate(config('_global.items_per_page'));
                return view('inp.dashboard', compact('inps'));
            case config('_global.student'):
                $inps = User::where('user_type', config('_global.inp'))->paginate(config('_global.items_per_page'));
                return view('student.dashboard', compact('inps'));
            default:
                return $this->signout(); //view('dashboard');
        }
    }

    public function change_profile()
    {
        $user = Auth::user();
        switch ($user->user_type) {
            case config('_global.teacher'):
                $name = $user->name;
                return view('teacher.change_profile', compact('name'));
            case config('_global.inp'):
                return view('inp.change_profile', compact('user'));
            case config('_global.student'):
                $user_roles = $user->user_roles()->get();
                $roles = Role::get();
                return view('student.profile', compact('user', 'user_roles', 'roles'));
            default:
                return $this->signout(); //view('dashboard');
        }
    }

    public function user_profile_changing(Request $request) {
        $request->validate([
            'prev_password' => ['exclude_without:prev_password', 'required', new CheckOldPassword()],
            'password' => ['exclude_without:prev_password', 'required', 'min:6'],
            'password_confirmation' => ['exclude_without:prev_password', 'same:password'],
            'gpa' => ['exclude_without:gpa', 'required', 'integer', 'between:0,7'],
            'new_roles' => ['required', 'min:1']
        ]);

        $user = Auth::user();
        $password_changed = false;
        if (isset($request->prev_password) and ($request->prev_password !== null)) {
            $user->password = Hash::make($request->password);
            $user->save();
            $password_changed = true;
        }

        $gpa_changed = false;
        $profile = $user->profile;
        if ($profile !== null) {
            if (isset($request->gpa) and ($request->gpa !== null) and ($request->gpa !== $profile->gpa)) {
                $profile->gpa = $request->gpa;
                $profile->save();
                $gpa_changed = true;
            }
        } else {
            if (isset($request->gpa) and ($request->gpa !== null)) {
                $profile = new Profile();
                $profile->gpa = $request->gpa;
                $profile->user_id = $user->id;
                $profile->save();
                $gpa_changed = true;
            }
        }

        $roles_changed = false;
        $user_roles = $user->user_roles;
        foreach($user_roles as $user_role) {
            $user_role->delete();
        }
        if ($request->new_roles !== null) {
            foreach ($request->new_roles as $new_role) {
                $user_role = new UserRole();
                $user_role->user_id = $user->id;
                $user_role->role_id = $new_role;
                $user_role->save();
            }
        }

        if ($password_changed) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flush();

            return Redirect('/');
        }

        return redirect('/dispatch');
    }

    public function profile_changing(Request $request)
    {
        $request->validate([
            'prev_password' => ['exclude_without:prev_password', 'required', new CheckOldPassword()],
            'password' => ['exclude_without:prev_password', 'required', 'min:6'],
            'password_confirmation' => ['exclude_without:prev_password', 'same:password'],
        ]);

        $user = Auth::user();
        $password_changed = false;
        if (isset($request->prev_password) and ($request->prev_password !== null)) {
            $user->password = Hash::make($request->password);
            $password_changed = true;
        }
        if ($password_changed) {
            $user->save();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flush();

            return Redirect('/');
        }
        else
            return redirect('/dispatch');
    }

    public function signout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        return Redirect('/');
    }

    public static function get_usertype(User $user)
    {
        if ($user->name === config('_global.teacher'))
            return config('_global.teacher');

        switch ($user->user_type) {
            case config('_global.inp'):
                return config('_global.inp');
            case config('_global.student'):
                return config('_global.student');
            default:
                return config('_global.nau'); // Not Applicable
        }
    }

    public static function approve_inps()
    {
        $inps = User::where('user_type', config('_global.inp'))->where('approved', false)->paginate(config('_global.items_per_page'));
        if ($inps->currentPage() > $inps->lastPage()) {
            $url = $inps->path() . '?page=' . $inps->lastPage();
            return redirect($url);
        }
        return view('teacher.approve_inps', compact('inps'));
    }

    public static function approve_inp(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $user->approved = true;
        $user->save();

        return Redirect::back()->with('success', 'op successful');
    }
}
