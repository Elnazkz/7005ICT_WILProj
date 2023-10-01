@extends('layouts.layout')
@section('title', 'Student Dashboard')
@section('sidebar')
    @include('student.sidebar')
@endsection

@section('sub_content')
    @yield('student_content')
@endsection
