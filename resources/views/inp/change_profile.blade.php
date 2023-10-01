@extends('inp.layout')
@section('inp_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center w-100">
                <div class="col-8">
                    <div class="card">
                        <h3 class="card-header text-center">Profile Editing</h3>
                        <div class="card-body">
                            <form action="{{ url('profile-changing') }}" method="POST">
                                @csrf
                                <div class="d-flex ">
                                    <!-- name -->
                                    <div class="mb-3">
                                        <input type="text" placeholder="Name" class="form-control-plaintext" readonly
                                               value=" {{ $user->name }} ">
                                    </div>
                                    <!-- user type -->
                                    <div class="ms-auto mb-3">
                                        <input type="text" placeholder="User Type" class="form-control-plaintext text-end" readonly
                                               value=" {{ $user->user_type }} ">
                                    </div>
                                </div>
                                <!-- email -->
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" class="form-control-plaintext"
                                           id="email" name="email" readonly
                                           value="{{ $user->email}}" >
                                </div>
                                <!-- old password -->
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Prev Password" class="form-control"
                                           id="prev-password" name="prev-password" autofocus>
                                    @if ($errors->has('prev-password'))
                                        <span class="text-danger">{{ $errors->first('prev-password') }}</span>
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
