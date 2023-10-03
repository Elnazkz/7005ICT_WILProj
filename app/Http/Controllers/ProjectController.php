<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectImage;
use App\Models\ProjectUser;
use App\Models\User;
use App\Rules\MinWordsCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isEmpty;

class ProjectController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy', 'show']);
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::selectRaw('*')->orderBy('year', 'desc')->orderBy('trimester', 'desc')
//            ->groupBy('year')->groupBy('trimester')
            ->paginate(config('_global.items_per_page'));

        $user = Auth::user();
        switch (WilAuthController::get_usertype($user)) {
            case config('_global.teacher'):
                return view('teacher.projects_page', compact('projects', 'user'));
            case config('_global.student'):
                return view('student.projects_page', compact('projects', 'user'));
            case config('_global.inp'):
                return view('inp.projects_page', compact('projects', 'user'));

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
            'contact_name' => 'required|min:5',
            'contact_email' => 'required|email:rfc,dns',
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
        $project->contact_name = $request->contact_name;
        $project->contact_email = $request->contact_email;
        $project->save();

        $images = $request->file('images');

        if ($images) {
            $validator = Validator::make($request->all(), [
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            foreach ($images as $image) {
                $name = $request->project_id . $image->getClientOriginalName();
                $image_path = $image->storeAs('public/images', $name);

                $projectImage = new ProjectImage();
                $projectImage->file_path = $image_path;
                $projectImage->project_id = $project->id;
                $projectImage->name = $name;
                $projectImage->save();
            }
        }

        $files = $request->file('pdfs');

        if ($files) {
            $validator = Validator::make($request->all(), [
                'pdfs.*' => 'mimetypes:application/pdf|max:10000'
            ]);


            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            foreach ($files as $file) {
                $name = $request->project_id . $file->getClientOriginalName();
                $pdf_path = $file->storeAs('public/files', $name);

                $projectPdf = new ProjectFile();
                $projectPdf->file_path = $pdf_path;
                $projectPdf->project_id = $project->id;
                $projectPdf->name = $name;
                $projectPdf->save();
            }
        }

        return redirect('/dispatch')->with('success', 'Project created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //$project = Project::where('projects.id', '=', $project_id)->first();

        $user = Auth::user();
        switch ($user->user_type) {
            case config('_global.teacher'):
                $student = Auth::user();
                $project_user = ProjectUser::where('project_id', $project->id)->where('user_id', $student->id)->first();
                return view('teacher.project_details', compact(['project', 'student', 'project_user']));
            case config('_global.inp'):
                if (Auth::user()->id === $project->user_id)
                    return view('inp.project_details_editable', compact(['project']));
                else
                    return view('inp.project_details', compact(['project']));
            case config('_global.student'):
                $student = Auth::user();
                $project_user = ProjectUser::where('project_id', $project->id)->where('user_id', $student->id)->first();
                return view('student.project_details', compact(['project', 'student', 'project_user',]));
            default:
                // TODO I'm not sure this will work
                return $this->signout(); //view('dashboard');
        }
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
            'contact_name' => 'required|min:5',
            'contact_email' => 'required|email:rfc,dns',
            'title' => ['required',
                'min:5',
                Rule::unique('projects')
                    ->where('title', $request->title)
                    ->where('year', $request->year)
                    ->where('trimester', $request->trimester)
                    ->ignore($project->id), // Ignore the current project when checking uniqueness
            ],
            'description' => ['required', new MinWordsCount(3)],
            'needed_students' => 'required|numeric|between:3,6',
            'year' => 'required',
            'trimester' => 'required|between:1,3',
        ]);

        $project->title = $request->title;
        $project->year = $request->year;
        $project->trimester = $request->trimester;
        $project->description = $request->description;
        $project->needed_students = $request->needed_students;
        $project->contact_name = $request->contact_name;
        $project->contact_email = $request->contact_email;
        $project->update();

        return redirect('/dispatch')->with('success', 'Project created successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project_id = $project->id;
        if ($project->project_users()->where('project_id', $project_id)->get()->isEmpty()) {
            Project::find($project_id)->delete();
            return redirect('/dispatch')->with('success', 'Project created successfully');
        } else {
            return redirect('/project_show/' . $project_id)->with('error', 'Project can not be deleted. Students have applied on this project.');
        }
    }

    public function store_image(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $images = $request->file('images');

        foreach ($images as $image) {
            $name = $request->project_id . $image->getClientOriginalName();
            $image_path = $image->storeAs('public/images', $name);

            $projectImage = new ProjectImage();
            $projectImage->file_path = $image_path;
            $projectImage->project_id = $request->project_id;
            $projectImage->name = $name;
            $projectImage->save();
        }

        return redirect()->back()->with('success', 'Image uploaded successfully');
    }

    public function store_file(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pdfs.*' => 'mimetypes:application/pdf|max:10000'
        ]);


        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $files = $request->file('pdfs');

        foreach ($files as $file) {
            $name = $request->project_id . $file->getClientOriginalName();
            $pdf_path = $file->storeAs('public/files', $name);

            $projectPdf = new ProjectFile();
            $projectPdf->file_path = $pdf_path;
            $projectPdf->project_id = $request->project_id;
            $projectPdf->name = $name;
            $projectPdf->save();
        }

        return redirect()->back()->with(['success' => 'File uploaded successfully']);
    }

    public function apply_to_project(Request $request, Project $project)
    {
        $student = Auth::user();
        $inp = $project->user()->first();
        $project_user = ProjectUser::where('user_id', $student->id)->where('project_id', $project->id)->first();

        if ($project_user !== null) {
            return view('/student.project_details_update', compact('project', 'project_user', 'student', 'inp'));
        } else {
            $data = $request->all();
            $data['count'] = ProjectUser::where('user_id', $student->id)->get()->count();
            Validator::make($data, [
                'count' => 'integer|max:2',
            ])->validate();

            return view('/student.project_details', compact('project', 'project_user', 'student', 'inp'));
        }
    }

    public function unapply_to_project(Project $project)
    {
        $student = Auth::user();
        $project_user = ProjectUser::where('user_id', $student->id)->where('project_id', $project->id)->first();

        $project_user?->delete();
        return $this->index();
    }

    public function show_page(Project $project)
    {
        $user = Auth::user();
        switch ($user->user_type) {
            case config('_global.teacher'):
                $student = Auth::user();
                $inp = $project->user()->first();
                $project_user = ProjectUser::where('project_id', $project->id)->where('user_id', $student->id)->first();
                return view('teacher.project_page', compact(['project', 'student', 'project_user', 'inp']));
            case config('_global.inp'):
                $student = Auth::user();
                $inp = $project->user()->first();
                $project_user = ProjectUser::where('project_id', $project->id)->where('user_id', $student->id)->first();
                return view('inp.project_page', compact(['project', 'student', 'project_user', 'inp']));
            case config('_global.student'):
                $student = Auth::user();
                $inp = $project->user()->first();
                $project_user = ProjectUser::where('project_id', $project->id)->where('user_id', $student->id)->first();
                return view('student.project_page', compact(['project', 'student', 'project_user', 'inp']));
            default:
                // TODO I'm not sure this will work
                return $this->signout(); //view('dashboard');
        }
    }
}
