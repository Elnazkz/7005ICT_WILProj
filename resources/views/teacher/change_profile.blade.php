@extends('teacher.layout')
@section('teacher_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center w-100">
                <div class="col-8">
                    <div class="card">
                        <h3 class="card-header text-center">Profile Editing</h3>
                        <div class="card-body">
                            <form action="{{ url('profile-changing') }}" method="POST">
                                @csrf
                                <!-- name -->
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Name" class="form-control" readonly
                                           id="name" name="name"
                                           value={{ $name }}>
                                </div>
                                <!-- old password -->
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Prev Password" class="form-control"
                                           id="prev_password" name="prev_password">
                                    @if ($errors->has('prev_password'))
                                        <span class="text-danger">{{ $errors->first('prev_password') }}</span>
                                    @endif
                                </div>
                                <!-- new password -->
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="New Password" class="form-control"
                                           id="password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <!-- confirm password -->
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" class="form-control"
                                           id="password_confirmation" name="password_confirmation">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

