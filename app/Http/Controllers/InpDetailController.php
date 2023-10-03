<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InpDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        switch (Auth::user()['user_type']) {
            case config('_global.teacher'):
                $user = User::find($id);
                $projects = $user->project;
                return view('teacher.inp_details', compact(['user', 'projects']));
            case config('_global.inp'):
                $user = User::find($id);
                $projects = $user->project;
                return view('inp.inp_details', compact(['user', 'projects']));
            case config('_global.student'):
                $user = User::find($id);
                $projects = $user->project;
                return view('student.inp_details', compact(['user', 'projects']));
            default:
                return $this->signout(); //view('dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
