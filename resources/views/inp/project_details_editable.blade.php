@extends('inp.layout')
@section('inp_content')
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
                           value="{{ @old('title', $project->title) }}" disabled>
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="mb-1">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    {{-- don't break textarea line--}}
                    <textarea class="form-control" id="description" name="description" rows="3">{{ @old('description', $project->description) }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-self-end">
                    <div class="mb-1">
                        <label for="needed_students" class="form-label">Needed students</label>
                        <input type="text" class="form-control" id="needed_students" name="needed_students"
                               value="{{ @old('needed_students', $project->needed_students) }}">
                        @if ($errors->has('needed_students'))
                            <span class="text-danger">{{ $errors->first('needed_students') }}</span>
                        @endif
                    </div>
                    <div class="mb-1">
                        <label for="year" class="form-label">Year</label>
                        <input type="text" class="form-control" id="year" name="year"
                               value="{{ @old('year', $project->year) }}" disabled>
                        @if ($errors->has('year'))
                            <span class="text-danger">{{ $errors->first('year') }}</span>
                        @endif
                    </div>
                    <div class="mb-1">
                        <label for="trimester" class="form-label">Trimester</label>
                        <div class="dropdown">
                            <select class="btn btn-info" id="trimester" name="trimester" disabled>
                                <option class="dropdown-item" disabled selected>-- Select one --</option>
                                <option class="dropdown-item" value="1"
                                    {{ old('trimester', $project->trimester) == '1' ? 'selected' : '' }}>1</option>
                                <option class="dropdown-item" value="2"
                                    {{ old('trimester', $project->trimester) == '2' ? 'selected' : '' }}>2</option>
                                <option class="dropdown-item" value="3"
                                    {{ old('trimester', $project->trimester) == '3' ? 'selected' : '' }}>3</option>
                            </select>
                        </div>
                        @if ($errors->has('trimester'))
                            <span class="text-danger">{{ $errors->first('trimester') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-warning mt-3 w-100">Update</button>
                </div>
            </form>
        </div>
        <form method="get" action="{{ '/project_del/' . $project->id }}">
            @method('DELETE')
            @csrf
            <div class="col-auto">
                <button type="submit" class="btn btn-danger mt-3 w-100">Delete</button>
            </div>
        </form>

        <br>

        <div>
            <form action="/project_image" method="POST" enctype="multipart/form-data">
                @csrf
                <label>
                    <span>Choose Image File</span>
                    <input type="file" name="image"/>
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </label>
                <button type="submit" >Submit</button>
            </form>
        </div>

        <br>

        <div>
            <form action="/project_file" method="POST" enctype="multipart/form-data">
                @csrf
                <label>
                    <span>Choose PDF File</span>
                    <input type="file" name="pdf"/>
                    @if ($errors->has('pdf'))
                        <span class="text-danger">{{ $errors->first('pdf') }}</span>
                    @endif
                </label>
                <button type="submit" >Submit</button>
            </form>
        </div>
    </div>
@endsection
