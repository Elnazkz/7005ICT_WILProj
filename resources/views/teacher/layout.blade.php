@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container d-flex h-100">
        <div class="mr-auto p-2 align-self-stretch">
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
                <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                    <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                    <span class="fs-4">Sidebar</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link link-body-emphasis" aria-current="page">
                            <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/person-lines-fill.svg') }}" alt="student profile" />
                            Student's Profiles
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/building-check.svg') }}" alt="student profile" />
                            Approve InPs
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/filetype-exe.svg') }}" alt="student profile" />
                            Trigger Automatic Assignment
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/building-check.svg') }}" alt="student profile" />
                            Define Roles
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @yield('teacher_content')
    </div>
@endsection
