@extends('student.layout')

@section('student_content')
    <div class="p-2 align-self-stretch w-100">
        <div class="d-flex flex-column p-3 h-100">
            <div class="row justify-content-center">
                @if (isset($projects))

                    @if ($errors->unapply->first() !== "")
                        <!-- Button trigger modal -->
                        <button hidden id="modal_button2" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal2">
                            click me! {{ $errors->unapply->first() }}
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal2" tabindex="-1"
                             aria-labelledby="exampleModalLabel2"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel2">Cannot Unapply !</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p> This project is assigned to use. </p>
                                        <p> Cannot unapply it ! </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @error('count')
                    <!-- Button trigger modal -->
                    <button hidden id="modal_button" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Max project limit reached !</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p> A student max limit to apply for projects is 3. </p>
                                    <p> You have reached it ! </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @enderror
                    <script>
                        window.onload = function () {
                            var b1 = document.getElementById('modal_button')
                            var b2 = document.getElementById('modal_button2')
                            if (b1 != null) {
                                b1.click()
                            }
                            if (b2 != null) {
                                b2.click()
                            }
                        }
                    </script>

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Year</th>
                            <th scope="col">Trimester</th>
                            <th scope="col">Project title</th>
                            <th class="text-center" scope="col">Taken</th>
                            <th class="text-center" scope="col">Apply</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($year = '')
                        @php($trimester = '')
                        @foreach($projects as $project)
                            <tr>
                                @if ($project->year !== $year)
                                    <th scope="row">{{ $project->year }}</th>
                                    @php($year = $project->year)
                                @else
                                    <th scope="row">{{ " " }}</th>
                                @endif
                                <th scope="row">{{ $project->trimester }}</th>

                                <th scope="row">
                                    <a href="{{ '/project_page/' . $project->id }}">{{ $project->title }}</a>
                                </th>
                                <form method="get" action="{{ '/unapply_to_project/' . $project->id }}">
                                    @csrf
                                    {{--                            TODO not needed can be deleted --}}
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <td class="text-center">
                                        @if (\App\Models\ProjectUser::project_isapplied($user->id, $project->id))
                                            <button type="submit" class="btn btn-transparent mt-0 pt-0">
                                                <img class="bi" width="24" height="24"
                                                     src="{{ asset('svgs/check-circle.svg') }}"
                                                     alt="Apply"/>
                                            </button>
                                        @endif
                                    </td>
                                </form>
                                <form method="get" action="{{ '/apply_to_project/' . $project->id }}">
                                    @csrf
                                    {{--                            TODO not needed can be deleted --}}
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <td class="text-center">
                                        <button type="submit"
                                                class="btn btn-transparent mt-0 pt-0" {{($user->approved) ? '' : 'disabled'}}>
                                            <img class="bi" width="24" height="24"
                                                 src="{{ asset('svgs/box-arrow-right.svg') }}"
                                                 alt="Apply"/>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $projects->links('pagination::bootstrap-5') !!}
                    </div>
                @else
                    <h2>No Projects defined yet !</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
