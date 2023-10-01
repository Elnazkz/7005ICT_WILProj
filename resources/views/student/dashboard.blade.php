@extends('student.layout')

@section('student_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center">
                @if (isset($inps))
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">InP name</th>
                            <th class="text-left" scope="col">Email</th>
                            <th class="text-center" scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inps as $inp)
                            <form method="get" action="/apply_to_project/" {{ .  }}>
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $inp->id }}">
                                <tr>
                                    <th scope="row">{{ $inp->name }}</th>
                                    <td class="text-left">{{ $inp->email }}</td>
                                    <td class="text-center">
                                        @if ($student->approved)
                                            <button type="submit" class="btn btn-primary">Apply</button>
                                        @else
{{--                                            <button type="submit" class="btn btn-primary" disabled>Apply</button>--}}
                                        @endif
                                    </td>

                                </tr>
                            </form>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $inps->links('pagination::bootstrap-5') !!}
                    </div>
                @else
                    <h2>No Inps defined yet !</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
