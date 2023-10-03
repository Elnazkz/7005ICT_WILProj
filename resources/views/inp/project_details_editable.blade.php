@extends('inp.layout')
@section('inp_content')
    <div class="w-100">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('error'))
            <span class="text-danger">{{  session('error') }}</span>
        @endif
        @if(session('success'))
            <span style="color: forestgreen">{{  session('success') }}</span>
        @endif
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
                    <label for="title" class="form-label">Contact Name</label>
                    <input type="text" class="form-control" id="contact_name" name="contact_name"
                           value="{{ @old('contact_name', $project->contact_name) }}">
                    @if ($errors->has('contact_name'))
                        <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                    @endif
                </div>
                <div class="mb-1">
                    <label for="title" class="form-label">Contact Email</label>
                    <input type="text" class="form-control" id="contact_email" name="contact_email"
                           value="{{ @old('contact_email', $project->contact_email) }}">
                    @if ($errors->has('contact_email'))
                        <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                    @endif
                </div>
                <div class="mb-1">
                    <label for="title" class="form-label">Project Title</label>
                    <input type="text" class="form-control" id="title" name="title" autofocus
                           value="{{ @old('title', $project->title) }}">
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="mb-1">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    {{-- don't break textarea line--}}
                    <textarea class="form-control" id="description" name="description"
                              rows="3">{{ @old('description', $project->description) }}</textarea>
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
                               value="{{ @old('year', $project->year) }}">
                        @if ($errors->has('year'))
                            <span class="text-danger">{{ $errors->first('year') }}</span>
                        @endif
                    </div>
                    <div class="mb-1">
                        <label for="trimester" class="form-label">Trimester</label>
                        <div class="dropdown">
                            <select class="btn btn-info" id="trimester" name="trimester">
                                <option class="dropdown-item" selected>-- Select one --</option>
                                <option class="dropdown-item" value="1"
                                    {{ old('trimester', $project->trimester) == '1' ? 'selected' : '' }}>1
                                </option>
                                <option class="dropdown-item" value="2"
                                    {{ old('trimester', $project->trimester) == '2' ? 'selected' : '' }}>2
                                </option>
                                <option class="dropdown-item" value="3"
                                    {{ old('trimester', $project->trimester) == '3' ? 'selected' : '' }}>3
                                </option>
                            </select>
                        </div>
                        @if ($errors->has('trimester'))
                            <span class="text-danger">{{ $errors->first('trimester') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mb-1">
                    <label for="description" class="col-sm-2 col-form-label">Students</label>
                    @forelse($project->project_users as $project_application)
                        <ul>
                            <li>{{ 'Name: ' .$project_application->user->name}}
                                <br> {{'Note: '.$project_application->justification_note }}</li>
                        </ul>
                    @empty
                        No Students have applied yet!
                    @endforelse
                </div>
                <div class="mb-1">
                    <label class="col-sm-2 col-form-label">Pictures</label>
                    <br>
                    @forelse($project->project_images as $image)
                        <img src="{{ asset('storage/images/'.$image->name) }}" alt="{{$image->name}}" width="200px">
                    @empty
                        No Images!
                    @endforelse
                </div>
                <div class="mb-1">
                    <label class="col-sm-2 col-form-label">Files</label>
                    <br>
                    @forelse($project->project_files as $file)
                        <a href="{{ asset('storage/files/'.$file->name) }}" download="">{{ $file->name }}</a>
                    @empty
                        No Files!
                    @endforelse
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
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <label>
                    <span>Choose Image Files</span>
                    <input type="file" name="images[]" multiple/>
                    @if ($errors->has('images'))
                        <span class="text-danger">{{ $errors->first('images') }}</span>
                    @endif
                </label>
                <button type="submit">Submit</button>
            </form>
        </div>

        <br>

        <div>
            <form action="/project_file" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <label>
                    <span>Choose PDF Files</span>
                    <input type="file" name="pdfs[]"/>
                    @if ($errors->has('pdfs'))
                        <span class="text-danger">{{ $errors->first('pdfs') }}</span>
                    @endif
                </label>
                <button type="submit" >Submit</button>
            </form>
        </div>

    </div>
@endsection
