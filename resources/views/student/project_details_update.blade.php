@extends('student.layout')

@section('student_content')
    <div class="w-100">

        <div class="w-100">
            <div class="d-flex w-100">
                <div class="card border-primary mb-3 w-100">
                    <div class="card-body text-primary">
                        <h5 class="card-title">{{ $student->name }}</h5>
                    </div>
                </div>
            </div>

            <div class="d-flex w-100">
                <form class="w-100" action="{{ '/project_update/' . $project->id }}" method="post">
                    @csrf
                    <div class="mb-1">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="title" name="title" autofocus
                               value="{{ $project->title }}" disabled>
                    </div>
                    <div class="mb-1">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        {{-- don't break textarea line--}}
                        <textarea class="form-control" id="description" name="description" rows="3" disabled>{{ $project->description }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between align-self-end">
                        <div class="mb-1">
                            <label for="needed_students" class="form-label">Needed students</label>
                            <input type="text" class="form-control" id="needed_students" name="needed_students"
                                   value="{{ $project->needed_students }}" disabled>
                        </div>
                        <div class="mb-1">
                            <label for="year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="year" name="year"
                                   value="{{ $project->year }}" disabled>
                        </div>
                        <div class="mb-1">
                            <label for="trimester" class="form-label">Trimester</label>
                            <div class="dropdown">
                                <select class="btn btn-info" id="trimester" name="trimester" disabled>
                                    <option class="dropdown-item" value="1"
                                        {{ $project->trimester == '1' ? 'selected' : '' }}>1</option>
                                    <option class="dropdown-item" value="2"
                                        {{ $project->trimester == '2' ? 'selected' : '' }}>2</option>
                                    <option class="dropdown-item" value="3"
                                        {{ $project->trimester == '3' ? 'selected' : '' }}>3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label for="description" class="col-sm-2 col-form-label">Students</label>
                        @forelse($project->project_users as $project_application)
                            <ul>
                                <li>{{ 'Name: ' .$project_application->user->name}} <br> {{'Note: '.$project_application->justification_note }}</li>
                            </ul>
                        @empty
                            No Students have applied yet!
                        @endforelse
                    </div>
                    <div class="mb-1">
                        <label class="col-sm-2 col-form-label">Pictures</label>
                        <br>
                        @forelse($project->project_images as $image)
                            <img src="{{ url($image->file_path) }}" alt="{{$image->name}}" width="200px">
                        @empty
                            No Images!
                        @endforelse
                    </div>
                    <div class="mb-1">
                        <label class="col-sm-2 col-form-label">Files</label>
                        <br>
                        @forelse($project->project_files as $file)
                            <a href="{{ url($file->file_path) }}" download="">{{ $file->name }}</a>
                        @empty
                            No Files!
                        @endforelse
                    </div>
                </form>
            </div>
        </div>


        <br>
        <div>
            <form method="post" action="/project_user_update">
                @csrf
                <input type="text" name="user_id" value="{{ $student->id }}" hidden>
                <input type="text" name="project_id" value="{{ $project->id }}" hidden>
                @if ($project_user !== null)
                    <input type="text" name="project_user_id" value="{{ $project_user->id }}" hidden>
                @endif
                <label for="needed_students" class="form-label">Justification</label>
                <textarea type="text" class="form-control" id="justification" name="justification" rows="3" autofocus>{{ $project_user !== null ? $project_user->justification_note : '' }}</textarea>
                @if ($errors->has('justification'))
                    <span class="text-danger">{{ $errors->first('justification') }}</span>
                @endif
                <br>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection
