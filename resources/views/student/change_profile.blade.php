@extends('student.layout')
@section('student_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center w-100">
                <div class="col-8">
                    <div class="card">
                        <h3 class="card-header text-center">Profile Editing</h3>
                        <div class="card-body">
                            <form action="{{ url('user_profile_changing') }}" method="POST">
                                @csrf
                                <div class="d-flex ">
                                    <!-- name -->
                                    <div class="mb-3">
                                        <input type="text" placeholder="Name" class="form-control-plaintext" readonly
                                               value=" {{ $user->name }} ">
                                    </div>
                                    <!-- user type -->
                                    <div class="ms-auto mb-3">
                                        <input type="text" placeholder="User Type"
                                               class="form-control-plaintext text-end" readonly
                                               value=" {{ $user->user_type }} ">
                                    </div>
                                </div>
                                <!-- email -->
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" class="form-control-plaintext"
                                           id="email" name="email" readonly
                                           value="{{ $user->email}}">
                                </div>
                                <!-- old password -->
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Prev Password" class="form-control"
                                           id="prev_password" name="prev_password" autofocus>
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

                                <!-- gpa -->
                                <div class="form-group mb-3">
                                    <input type="number" placeholder="GPA" class="form-control"
                                           id="gpa" name="gpa" value="{{ $user->profile()->first() !== null ? $user->profile()->first()->gpa : ''}}">
                                    @if ($errors->has('gpa'))
                                        <span class="text-danger">{{ $errors->first('gpa') }}</span>
                                    @endif
                                </div>

                                <!-- roles -->
                                @forelse($roles as $role)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="{{ $role->id }}" name="new_roles[]"
                                               value="{{ $role->id }}"
                                               {{ $user->has_role($user_roles, $role->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $role->id }}">{{ $role->title }}</label>

                                         @if ($errors->has($role->id))
                                            <span class="text-danger">{{ $errors->first($role->id) }}</span>
                                         @endif
                                    </div>
                                @empty
                                    <h2>Database error !!!</h2>
                                @endforelse
                                @if ($errors->has('new_roles'))
                                    <span class="text-danger">{{ $errors->first('new_roles') }}</span>
                                @endif
{{--                                <div class="form-check mb-3">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="1" name="1" value="">--}}
{{--                                    <label class="form-check-label" for="1">software developer</label>--}}

{{--                                    --}}{{-- @if ($errors->has(''))--}}
{{--                                    --}}{{--    <span class="text-danger">{{ $errors->first('') }}</span>--}}
{{--                                    --}}{{-- @endif--}}
{{--                                </div>--}}

{{--                                <div class="form-check mb-3">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="2" name="2" value="">--}}
{{--                                    <label class="form-check-label" for="2">project manager</label>--}}

{{--                                    --}}{{-- @if ($errors->has(''))--}}
{{--                                    --}}{{--    <span class="text-danger">{{ $errors->first('') }}</span>--}}
{{--                                    --}}{{-- @endif--}}
{{--                                </div>--}}

{{--                                <div class="form-check mb-3">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="3" name="3" value="">--}}
{{--                                    <label class="form-check-label" for="3">business analyst</label>--}}

{{--                                    --}}{{-- @if ($errors->has(''))--}}
{{--                                    --}}{{--    <span class="text-danger">{{ $errors->first('') }}</span>--}}
{{--                                    --}}{{-- @endif--}}
{{--                                </div>--}}

{{--                                <div class="form-check mb-3">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="4" name="4" value="">--}}
{{--                                    <label class="form-check-label" for="4">tester</label>--}}

{{--                                    --}}{{-- @if ($errors->has(''))--}}
{{--                                    --}}{{--    <span class="text-danger">{{ $errors->first('') }}</span>--}}
{{--                                    --}}{{-- @endif--}}
{{--                                </div>--}}

{{--                                <div class="form-check mb-3">--}}
{{--                                    <input class="form-check-input" type="checkbox" id="5" name="5" value="">--}}
{{--                                    <label class="form-check-label" for="5">client liaison</label>--}}

{{--                                    --}}{{-- @if ($errors->has(''))--}}
{{--                                    --}}{{--    <span class="text-danger">{{ $errors->first('') }}</span>--}}
{{--                                    --}}{{-- @endif--}}
{{--                                </div>--}}

                                <!-- button -->
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
