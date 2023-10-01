@extends('layouts.layout')
@section('title', 'Teacher Dashboard')
@section('sidebar')
    @include('teacher.sidebar')
@endsection
@section('sub_content')
    @yield('teacher_content')
@endsection

