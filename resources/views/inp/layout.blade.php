@extends('layouts.main')
@section('title', 'InP Dashboard')
@section('content')
    <div class="container d-flex h-100">
        <div class="mr-auto p-2 align-self-stretch">
            @include('inp.sidebar')
        </div>
        @yield('inp_content')
    </div>
@endsection
