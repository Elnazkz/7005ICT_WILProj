@extends('layouts.layout')
@section('title', 'InP Dashboard')
@section('sidebar')
    @include('inp.sidebar')
@endsection

@section('sub_content')
    @yield('inp_content')
@endsection
