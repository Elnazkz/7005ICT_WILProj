@extends('teacher.layout')
@section('teacher_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center">
                @if (isset($inps))
                    <ul>
                    @foreach($inps as $inp)
                        <li>{{ $inp->name }} {{ $inp->approved ? 'approved' : 'not approved'}}</li>
                    @endforeach
                    </ul>
                    <div class="d-flex justify-content-center">
                        {!! $inps->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                @else
                    <h2>No Inps defined yet !</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
