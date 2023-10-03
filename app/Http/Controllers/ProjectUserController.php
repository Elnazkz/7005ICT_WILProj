<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->only(['create', 'edit', 'destroy']);
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
    public function show(ProjectUser $projectUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectUser $projectUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectUser $projectUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectUser $projectUser)
    {
        //
    }

    public function apply(Request $request) {
        $request->validate([
            'justification' => 'required',
        ]);

        if (!isset($request->project_user_id)) {
            $project_user = new ProjectUser();
            $project_user->user_id = $request->user_id;
            $project_user->project_id = $request->project_id;
            $project_user->justification_note = $request->justification;
            $project_user->assigned = false;
            $project_user->save();
        } else {
            $project_user = ProjectUser::find($request->project_user_id)->first();
            $project_user->justification_note = $request->justification;
            $project_user->update();
        }
        return redirect('/projects');
    }
}
