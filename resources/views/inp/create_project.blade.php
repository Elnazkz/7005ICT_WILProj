@extends('inp.layout')
@section('inp_content')
    <div class="w-100">
        <div class="d-flex w-100">
            <div class="card border-primary mb-3 w-100">
                <div class="card-body text-primary">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="d-flex w-100">
            <form class="w-100" action="/project_creation" method="post">
                @csrf
                <div class="mb-1">
                    <label for="title" class="form-label">Project Title</label>
                    <input type="text" class="form-control" id="title" name="title" autofocus
                           value="{{ @old('title') }}">
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="mb-1">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ @old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-self-end">
                    <div class="mb-1">
                        <label for="needed_students" class="form-label">Needed students</label>
                        <input type="text" class="form-control" id="needed_students" name="needed_students"
                               value="{{ @old('needed_students') }}">
                        @if ($errors->has('needed_students'))
                            <span class="text-danger">{{ $errors->first('needed_students') }}</span>
                        @endif
                    </div>
                    <div class="mb-1">
                        <label for="year" class="form-label">Year</label>
                        <input type="text" class="form-control" id="year" name="year"
                               value="{{ @old('year') }}">
                        @if ($errors->has('year'))
                            <span class="text-danger">{{ $errors->first('year') }}</span>
                        @endif
                    </div>
                    <div class="mb-1">
                        <label for="trimester" class="form-label">Trimester</label>
                        <div class="dropdown">
                            <select class="btn btn-info" id="trimester" name="trimester">
                                <option class="dropdown-item" disabled selected>-- Select one --</option>
                                <option class="dropdown-item" value="1"
                                    {{ old('trimester') == '1' ? 'selected' : '' }}>1</option>
                                <option class="dropdown-item" value="2"
                                    {{ old('trimester') == '2' ? 'selected' : '' }}>2</option>
                                <option class="dropdown-item" value="3"
                                    {{ old('trimester') == '3' ? 'selected' : '' }}>3</option>
                            </select>
                        </div>
                        @if ($errors->has('trimester'))
                            <span class="text-danger">{{ $errors->first('trimester') }}</span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 w-100">Create</button>
            </form>
        </div>
    </div>
@endsection
