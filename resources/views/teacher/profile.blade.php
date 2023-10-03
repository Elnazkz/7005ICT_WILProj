@extends('teacher.layout')
@section('teacher_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center w-100">
                <div class="col-8">
                    <div class="card">
                        <h3 class="card-header text-center">Profile</h3>
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
                                           value="{{ $user->email }}">
                                </div>
                                <!-- gpa -->
                                <div class="form-group mb-3">
                                    <span>GPA : {{ $user->profile()->first() !== null ? $user->profile()->first()->gpa : ''}}</span>
                                </div>

                                <!-- roles -->
                                @forelse($roles as $role)
                                    <ul>
                                        @if($user->has_role($user_roles, $role->id))
                                            <li>{{ $role->title }}</li>
                                        @endif
                                    </ul>
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
{{--                                <div class="d-grid mx-auto">--}}
{{--                                    <button type="submit" class="btn btn-dark btn-block">Apply</button>--}}
{{--                                </div>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
