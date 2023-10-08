<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function auto_assign_page()
    {
        $proj_users = ProjectUser::where('assigned', false)->orderBy('project_id');
        if ($proj_users->count() <= 0) {
            return view('teacher.auto_assign_page')->with('error', 'Empty list');
        }

        $projs_range = DB::table('project_users as pu')
            ->select('pu.id as puid', 'pu.user_id', 'pu.project_id', 'pu.assigned',
                'p.id as pid', 'p.year', 'p.trimester')
            ->leftJoin('projects as p', 'p.id', '=', 'pu.project_id')
            ->where('pu.assigned', '=', false)
            ->groupBy('p.year')
            ->groupBy('p.trimester')
            ->orderBy('p.year')
            ->orderBy('p.trimester')->get();

        return view('teacher.auto_assign_page')->with(['projs_range' => $projs_range ]);
    }

    public function auto_assign() {
        if (UserRole::all()->count() <= 0) {
            return redirect()->back()->withErrors(['No user with a taken role !']);
        }

        // get from and to range of year and trimester
        $from_range = $_POST['from_range'];
        $to_range= $_POST['to_range'];

        $from_year = explode('-', $from_range)[0];
        $from_trimester = explode('-', $from_range)[1];

        $to_year = explode('-', $to_range)[0];
        $to_trimester = explode('-', $to_range)[1];

        if ($from_year > $to_year ) {
            return redirect()->back()->withErrors(['"From" must be before "To" !']);
        }

        $projects = DB::select(
            "select id from projects where " .
            "cast(year as varchar) || '-' || cast(trimester as varchar) between ? and ? " .
            "order by id",
            array($from_range, $to_range));
        $projects_id = [];
        foreach ($projects as $project) {
            $projects_id[] = $project->id;
        }

        do {
//            $proj_users = ProjectUser::where('assigned', false)->orderBy('project_id')->get();

            // this sentence will select records that are in the range
            $proj_users = ProjectUser::whereIn('project_id', $projects_id)
                ->where('assigned', false)->orderBy('project_id')->get();

            // this check if there is any unassigned user
            // this may happen at:
            // 1- the very first iteration, where there is no new assignment to be checked.
            // 2- in the midst of the process where all the records has been assigned.
            if ($proj_users->count() === 0) {
                return redirect()->back()->withErrors(['Assign list empty !']);
            }

            // initialise the main loop for each new investigated record.
            $prev_proj_user = null;
            $min_range = null;
            $max_range = null;
            $assigned_student = null;
            $needed_students = null;
            $assignment_found = false;
            $skip = false;
            foreach ($proj_users as $proj_user) {
                // this if skips records to reach to a different project_id than the current one.
                if ($skip) {
                    if ($proj_user->project_id === $prev_proj_user->project_id)
                        continue;
                    $skip = false;
                }
                $gpa = $proj_user->user()->first()->profile()->first()->gpa;
                // if this is the first iteration ($prev_proj_user === null)
                // or a new project has reached it is needed to compute some values
                if (($prev_proj_user === null) || ($proj_user->project_id !== $prev_proj_user->project_id)) {
                    // if this is not the first iteration and we have unsaved data
                    // before starting with new project_id, save the previous one.
                    if ($assigned_student !== null) {
                        $prj = $prev_proj_user->project()->first();
                        $prj->assigned_students = $assigned_student;
                        $prj->update();
                    }

                    // initialize values to be used while the new project_id is dealt with.
                    $prev_proj_user = $proj_user;
                    $min_range = max(0, $gpa - 1);
                    $max_range = min(7, $gpa + 1);

                    $assigned_student = $proj_user->project()->first()->assigned_students;
                    $needed_students = $proj_user->project()->first()->needed_students;
                }
                // if current user's GPA fell inside the computed range
                // it can be assigned to the current project_id
                if (($min_range <= $gpa) && ($gpa <= $max_range)) {
                    // but check before adding the current user,
                    // if there is room to add it to current project_id
                    if ($assigned_student >= $needed_students) {
                        $skip = true;
                        continue;
                    }
                    // if there is room then add it
                    $assignment_found= true;
                    $proj_user->assigned = true;
                    $proj_user->update();
                    $assigned_list[] = [$proj_user];
                    $assigned_student++;
                    // if the current project need more student,
                    // try the next unassigned user that is applied to this project
                    if ($assigned_student < $needed_students)
                        continue;
                    else { // skip to next project of proj_user
                        $skip = true;
                        continue;
                    }
                }
                // but if this student is not suitable for this group
                // (because of its GPA) try the next student
                else
                    continue;
            }
            // here check if there was no assignment found for a complete iteration
            // then there is no more things left to check, so break out of the process
            if (!$assignment_found)
                break;

            // as current $assigned_student may have been changed but not saved
            // so save it before trying the next iteration
            $prj = $proj_user->project()->first();
            $prj->assigned_students = $assigned_student;
            $prj->update();

            $cnt = ProjectUser::where('assigned', false)->count();
        } while ($cnt > 0);

        return redirect()->back()->withInput(['success' =>'Auto assignment completed successfully !', 'assigned_list' => $assigned_list]);
    }
}
