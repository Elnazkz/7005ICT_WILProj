@extends('student.layout')

@section('student_content')
    <div class="p-2 align-self-stretch w-100">
        @if(session('success'))
            <div style="color: forestgreen;">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center">
                @if (isset($inps))

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">InP name</th>
                            <th class="text-center" scope="col">Approval state</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inps as $inp)
                            <tr>
                                <th scope="row">
                                    @if ($inp->approved)
                                        <a href=" {{ '/inp-details/' . $inp->id }} "> {{ $inp->name }} </a>
                                    @else
                                        {{ $inp->name }}
                                    @endif
                                </th>
                                <td class="text-center">
                                    <img class="bi pe-none me-2" width="22" height="22"
                                         src="{{ $inp->approved ? asset('svgs/cart-check.svg') : asset('svgs/cart.svg') }}" alt="Not Approved" />
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
