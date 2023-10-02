@extends('teacher.layout')
@section('teacher_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100 overflow-auto">
            <div class="row justify-content-center">
                    <ul class="list-group">
                        @forelse($students as $student)
                            <li class="list-group-item mb-2 {{ $student->approved ? 'list-group-item-primary' : 'list-group-item-danger' }}">
                                name: <a href="/profile/{{$student->id}}">{{ $student->name }}</a> ,
                                @if (isset($student->profile->gpa))
                                    GPA: {{ $student->profile->gpa }}
                                @else
                                    No GPA defined !
                                @endif

                                <ul class="list-group">
                                    @forelse($student->user_roles as $role)
                                        <li class="list-group-item"> {{ $role->role->title }} </li>
                                    @empty
                                        <li class="list-group-item"> No role yet ! </li>
                                    @endforelse
                                </ul>

                            </li>
                        @empty
                            <h2>No profile defined yet !</h2>
                        @endforelse
                    </ul>
                    <div class="d-flex justify-content-center">
                        {!! $students->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
            </div>
        </div>
    </div>
@endsection
