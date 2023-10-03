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
            <span class="text-danger">{{  session('success') }}</span>
        @endif
        <div class="d-flex w-100">
            <form class="w-100" action="/project_creation" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-1">
                    <label for="title" class="form-label">Contact Name</label>
                    <input type="text" class="form-control" id="contact_name" name="contact_name"
                           value="{{ @old('contact_name', $user->name) }}">
                    @if ($errors->has('contact_name'))
                        <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                    @endif
                </div>
                <div class="mb-1">
                    <label for="title" class="form-label">Contact Email</label>
                    <input type="text" class="form-control" id="contact_email" name="contact_email"
                           value="{{ @old('contact_email', $user->email) }}">
                    @if ($errors->has('contact_email'))
                        <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                    @endif
                </div>
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
                    <textarea class="form-control" id="description" name="description"
                              rows="3">{{ @old('description') }}</textarea>
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
                                    {{ old('trimester') == '1' ? 'selected' : '' }}>1
                                </option>
                                <option class="dropdown-item" value="2"
                                    {{ old('trimester') == '2' ? 'selected' : '' }}>2
                                </option>
                                <option class="dropdown-item" value="3"
                                    {{ old('trimester') == '3' ? 'selected' : '' }}>3
                                </option>
                            </select>
                        </div>
                        @if ($errors->has('trimester'))
                            <span class="text-danger">{{ $errors->first('trimester') }}</span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 w-100">Create</button>
                <br>
                <br>

                <div class="mb-1">
                    <label>
                        <span>Choose Image Files</span>
                        <input type="file" name="images[]" multiple/>
                        @if ($errors->has('images'))
                            <span class="text-danger">{{ $errors->first('images') }}</span>
                        @endif
                    </label>
                </div>
                <br>

                <div class="mb-1">
                    <label>
                        <span>Choose PDF Files</span>
                        <input type="file" name="pdfs[]" multiple/>
                        @if ($errors->has('pdfs'))
                            <span class="text-danger">{{ $errors->first('pdfs') }}</span>
                        @endif
                    </label>
                </div>

            </form>
        </div>
    </div>
@endsection
