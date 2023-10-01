@extends('layouts.main')
@section('title', 'Teacher Dashboard')
@section('content')
    <div class="container d-flex h-100">
        <div class="mr-auto p-2 align-self-stretch">
            @include('teacher.sidebar')
        </div>
        @yield('teacher_content')
    </div>
@endsection