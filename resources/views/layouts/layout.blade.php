@extends('layouts.main')

@section('content')
    <div class="container d-flex h-100">
        <div class="mr-auto p-2 align-self-stretch">
            @yield('sidebar')
        </div>
        @yield('sub_content')
    </div>
@endsection
