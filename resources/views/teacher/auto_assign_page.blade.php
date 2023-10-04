@extends('teacher.layout')

@section('teacher_content')

    <div class="w-100">
        <div class="card border-primary text-center mb-3">
            <div class="card-header p-2">
                <h2 class="card-title">This may take a while!</h2>
            </div>
            <div class="card-body text-primary">
                <p class="card-text">if you are ready, click on the button to start the assignment process</p>
                <form method="post" action="/start_auto_assignment">
                    @csrf
                    <input type="hidden" name="errors_list" value="{{ $errors }}"/>

                    <button class="btn btn-primary" type="submit">Start auto-assignment</button>
                </form>
            </div>
        </div>
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
