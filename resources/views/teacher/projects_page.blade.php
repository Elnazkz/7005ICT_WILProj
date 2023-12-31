@extends('teacher.layout')

@section('teacher_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center">
                @if (isset($projects))
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Year</th>
                            <th scope="col">Trimester</th>
                            <th scope="col">Project title</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($year = '')
                        @php($trimester = '')
                        @foreach($projects as $project)
                            <form method="get" action="{{ '/apply_to_project/' . $project->id }}" >
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <tr>
                                    @if ($project->year !== $year)
                                        <th scope="row">{{ $project->year }}</th>
                                        @php($year = $project->year)
                                    @else
                                        <th scope="row">{{ " " }}</th>
                                    @endif
                                        <th scope="row">{{ $project->trimester }}</th>

                                        <th scope="row">
                                        <a href="{{ '/project_page/' . $project->id }}">{{ $project->title }}</a>
                                    </th>
                                </tr>
                            </form>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $projects->links('pagination::bootstrap-5') !!}
                    </div>
                @else
                    <h2>No Projects defined yet !</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
