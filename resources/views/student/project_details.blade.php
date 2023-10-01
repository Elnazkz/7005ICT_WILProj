@extends('student.layout')
@section('student_content')
    <div class="w-100">
        <div class="d-flex w-100">
            <div class="card border-primary mb-3 w-100">
                <div class="card-body text-primary">
                    <h5 class="card-title">{{ $project->user()->first()->name }}</h5>
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
            </form>
        </div>
        <br>
        <div>
            <form method="post" action="">
                <label for="needed_students" class="form-label">Justification</label>
                <textarea type="text" class="form-control" id="justification" name="justification" rows="3"></textarea>
                <br>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection
