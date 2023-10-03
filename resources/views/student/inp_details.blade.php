@extends('student.layout')
@section('student_content')
    <div class="w-100">
        <div class="card border-primary mb-3">
            <div class="card-header">Industry partner (InP)</div>
            <div class="card-body text-primary">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text">{{ $user->email }}</p>
            </div>
        </div>

        <div>
            <h3>List of projects</h3>
            <ul class="list-group list-group-flush">
                @forelse($projects as $project)
                    <li class="list-group-item"><a href="{{ '/project_page/' . $project->id }}"> {{ $project->title }} </a></li>
                @empty
                    No project defined.
                @endforelse
            </ul>
        </div>
    </div>
@endsection
