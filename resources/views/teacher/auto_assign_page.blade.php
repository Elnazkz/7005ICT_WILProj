@extends('teacher.layout')

@section('teacher_content')

    <div class="w-100">
        @if (isset($error))
            <div class="card border-danger text-center mb-3">
                <div class="card-header p-2">
                    <h2 class="card-title">There is no project to work on !</h2>
                </div>
                <div class="card-body text-danger">
                    <p class="card-text">There is no unassigned project to work on !</p>
                </div>
            </div>
        @else
            <div class="card border-primary text-center mb-3">
                <div class="card-header p-2">
                    <h2 class="card-title">This may take a while!</h2>
                </div>
                <div class="card-body text-primary">
                    <p class="card-text">if you are ready, select a range and then</p>
                    <p class="card-text">click on the button to start the assignment process</p>
                    <form method="post" action="/start_auto_assignment">
                        @csrf
                        <input type="hidden" name="errors_list" value="{{ $errors }}"/>

                        <div class="container mb-2">
                            <div class="row">
                                <div class="col">From:</div>
                                <div class="col">
                                    <select name="from_range" class="form-select" aria-label="From:">
                                        @foreach($projs_range as $proj_range)
                                            <option
                                                value="{{ $proj_range->year . '-' . $proj_range->trimester }}">{{ $proj_range->year . '-' . $proj_range->trimester }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">To:</div>
                                <div class="col">
                                    <select name="to_range" class="form-select" aria-label="To:">
                                        @foreach($projs_range as $proj_range)
                                            <option
                                                value="{{ $proj_range->year . '-' . $proj_range->trimester }}">{{ $proj_range->year . '-' . $proj_range->trimester }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Start auto-assignment</button>
                    </form>
                </div>
            </div>
        @endif
        <div class="list-group list-group-flush mb-3 w-100">
            @if (isset($errors))
                @foreach($errors->all() as $error)
                    <li class="list-group-item list-group-item-warning">
                        {{ $error }}
                    </li>
                @endforeach
            @endif
        </div>
        <div class="list-group list-group-flush mb-3 w-100">
            @if (old('success') !== null)
                <li class="list-group-item list-group-item-success">
                    {{ old('success') }}
                </li>
            @endif
        </div>
        <div class="list-group list-group-flush mb-3 w-100">
            @if (old('assigned_list') !== null)
                @foreach(old('assigned_list') as $list)
                    @foreach($list as $project_user)
                        <li class="list-group-item list-group-item-info">
                            {{ $project_user->id }},
                            {{ $project_user->user_id }},
                            {{ $project_user->project_id }}
                        </li>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
@endsection
