@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ 'Dashboard' }}</div>
                    <div class="card-body">
                        @if (session('success'))
                            {{ $student[0]->name }}
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        You are Logged In
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection