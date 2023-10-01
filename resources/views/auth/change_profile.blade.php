@extends('layout')
@section('content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center">

                <div class="col-6">
                    <div class="card">
                        <h3 class="card-header text-center">Profile Editing</h3>
                        <div class="card-body">
                            <form action="{{ url('profile-changing') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="user_id">
                                <!-- name -->
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Name" class="form-control" readonly
                                           id="name" name="name"
                                           value={{ $user->name }}>
                                </div>
                                <!-- email -->
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" class="form-control"
                                           id="email" name="email"
                                           value="{{ old('email') !== null ? old('email') : $user->email }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <!-- password -->
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" class="form-control"
                                           id="password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <!-- user type -->
                                <div class="form-group mb-3">
                                    <select class="form-select" id="user_type" name="user_type">
                                        <option value="" disabled selected hidden style="color: lightgray;">Choose a
                                            user type
                                        </option>
                                        <option {{ old('user_type') == config('_global.inp') ? "selected" : "" }}
                                                value="InP">InP
                                        </option>
                                        <option {{ old('user_type') == config('_global.student') ? "selected" : "" }}
                                                value="Student">Student
                                        </option>
                                    </select>
                                    @if ($errors->has('user_type'))
                                        <span class="text-danger">{{ $errors->first('user_type') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

