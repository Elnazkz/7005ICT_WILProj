<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Rules\MinWordsCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy', 'show']);
        $this->middleware('auth')->except(['index', 'store_image', 'store_file']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        User::user_approve();

        $projects = Project::selectRaw('*')->orderBy('year', 'desc')->orderBy('trimester', 'desc')
            ->groupBy('year')->groupBy('trimester')
            ->paginate(config('_global.items_per_page'));

        $user = Auth::user();
        $is_student = WilAuthController::get_usertype($user) == config('_global.student');
        switch (WilAuthController::get_usertype($user)) {
            case config('_global.teacher'):
                return view('teacher.projects_page', compact('projects', 'user', 'is_student'));
            case config('_global.student'):
                return view('student.projects_page', compact('projects', 'user', 'is_student'));
            case config('_global.inp'):
                return view('inp.projects_page', compact('projects', 'user', 'is_student'));

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('inp.create_project', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required',
                'min:5',
                Rule::unique('projects')
                    ->where('title', $request->title)
                    ->where('year', $request->year)
                    ->where('trimester', $request->trimester),
            ],
            'description' => ['required', new MinWordsCount(3)],
            'needed_students' => 'required|numeric|between:3,6',
            'year' => 'required',
            'trimester' => 'required|between:1,3',
        ]);

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->needed_students = $request->needed_students;
        $project->year = $request->year;
        $project->trimester = $request->trimester;
        $project->user_id = Auth::user()->id;
        $project->save();

        return redirect('/dispatch')->with('success', 'Project created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //$project = Project::where('projects.id', '=', $project_id)->first();
        if (Auth::user()->id === $project->user_id)
            return view('inp.project_details_editable', compact(['project']));
        else
            return view('inp.project_details', compact(['project']));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'description' => ['required', new MinWordsCount(3)],
            'needed_students' => 'required|numeric|between:3,6',
        ]);

        $project->description = $request->description;
        $project->needed_students = $request->needed_students;
        $project->update();

        return redirect('/dispatch')->with('success', 'Project created successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
        $project_id = $project->id;
        return redirect('/dispatch')->with('success', 'Project created successfully');
    }

    public function store_image(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $image_path = $request->file('image')->store('image', 'public');

//        $data = Image::create([
//            'image' => $image_path,
//        ]);
//
//        session()->flash('success', 'Image Upload successfully');

        return redirect('/dispatch')->with('success', 'Project created successfully');
    }

    public function store_file(Request $request)
    {
        $this->validate($request, [
            'pdf' => 'required|mimetypes:application/pdf|max:10000',
        ]);

        $pdf_path = $request->file('pdf')->store('pdf', 'public');

//        $data = Image::create([
//            'image' => $pdf_path,
//        ]);
//
//        session()->flash('success', 'PDF Upload successfully');

        return redirect('/dispatch')->with('success', 'Project created successfully');
    }

    public function apply_to_project(Project $project) {
        $student = Auth::user();
        $project_user = ProjectUser::where('user_id', $student->id)->first();
        return view('/student.project_details', compact('project', 'project_user', 'student'));
    }
}
