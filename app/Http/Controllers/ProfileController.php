<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->only(['create', 'edit', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('user_type', config('_global.student'))
            ->with('profile', 'user_roles.role')
            ->paginate(config('_global.items_per_page'));
        return view('teacher.students_profile', compact(['students']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(String $user_id)
    {
        $student = User::where('id', $user_id)
            ->with('user_roles')
            ->get();
        $user = $student[0];
        $user_roles = $user->user_roles()->get();
        $roles = Role::get();
        return view('teacher.profile', compact('user', 'user_roles', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
