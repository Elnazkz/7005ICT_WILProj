<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use App\Models\UserRole;
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

    public function auto_assign() {
        if (UserRole::all()->count() <= 0) {
            return redirect()->back()->withErrors(['No user with a taken role !']);
        }

        $assigned_list = [];

        do {
            $proj_users = ProjectUser::where('assigned', false)->orderBy('project_id')->get();
            if ($proj_users->count() === 0) {
                return redirect()->back()->withErrors(['Assign list empty !']);
            }

            $prev_proj_user = null;
            $min_range = null;
            $max_range = null;
            $assigned_student = null;
            $needed_students = null;
            $assignment_found = false;
            $skip = false;
            foreach ($proj_users as $proj_user) {
                if ($skip) {
                    if ($proj_user->project_id === $prev_proj_user->project_id)
                        continue;
                    $skip = false;
                }
                $gpa = $proj_user->user()->first()->profile()->first()->gpa;
                if (($prev_proj_user === null) || ($proj_user->project_id !== $prev_proj_user->project_id)) {
                    if ($assigned_student !== null) {
                        $prj = $prev_proj_user->project()->first();
                        $prj->assigned_students = $assigned_student;
                        $prj->update();
                    }

                    $prev_proj_user = $proj_user;
                    $min_range = max(0, $gpa - 1);
                    $max_range = min(7, $gpa + 1);

                    $assigned_student = $proj_user->project()->first()->assigned_students;
                    $needed_students = $proj_user->project()->first()->needed_students;
                }
                if (($min_range <= $gpa) && ($gpa <= $max_range)) {
                    if ($assigned_student >= $needed_students) {
                        $skip = true;
                        continue;
                    }
                    $assignment_found= true;
                    $proj_user->assigned = true;
                    $proj_user->update();
                    $assigned_list[] = [$proj_user];
                    $assigned_student++;
                    if ($assigned_student < $needed_students)
                        continue;
                    else { // skip to next project of proj_user
                        $skip = true;
                        continue;
                    }
                } else
                    continue;
            }
            if (!$assignment_found)
                break;

            $prj = $proj_user->project()->first();
            $prj->assigned_students = $assigned_student;
            $prj->update();

            $cnt = ProjectUser::where('assigned', false)->count();
        } while ($cnt > 0);

        return redirect()->back()->withInput(['success' =>'Auto assignment completed successfully !', 'assigned_list' => $assigned_list]);
    }
}
