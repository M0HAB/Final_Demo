@extends('_layouts.app')
@section('title', 'Assignments')
@section('content')
    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-4">
        <div class="container">
            <h1>Assignments
                @if (Auth::user()->isInstructor())
                    <a href="{{ route('assignments.create', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="btn btn-info" role="button">Create</a>
                    <a href="{{ route('assignment.delivered', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="btn btn-success" role="button">Delivered </a>
                @endif
            </h1>
            <div class="row justify-content-center">
                @if (count($assignments)>0)
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>File</th>
                            <th>Deadline</th>
                            <th>Full Mark</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($assignments as $ass)
                            <tr>

                                <td>
                                    {{$ass->title}}
                                </td>
                                <td>
                                    {{$ass->description}}
                                </td>
                                <td>
                                    {{--{{$ass->file ?  $ass->file :"No file attached"}}--}}
                                    @if(is_null($ass->file))
                                        No File Attached
                                    @else
                                        <a href=" {{ asset("uploads\assignments") }}\{{$ass->file}}" download="{{$ass->file}}">
                                            <button type="button" class="btn btn-primary btn-block">
                                                <i class="fas fa-cloud-download-alt "></i>
                                                Download
                                            </button>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{{date('d-m-Y', strtotime($ass->deadline))}}}
                                </td>
                                <td>
                                    {{$ass->full_mark}}
                                </td>

                                @if (Auth::user()->isInstructor())
                                    <td>
                                        <button  class="btn btn-group-sm btn-link"><a href="{{route('assignments.edit', ['course_id' => $course->id, 'module_id' => $module->id, 'ass_id' => $ass->id])}}"><i class="far fa-edit fa-lg fam-mod"></i> </a> </button>

                                        <form action="{{ route('assignments.destroy', ['course_id' => $course->id, 'module_id' => $module->id, 'ass_id' => $ass->id])}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-group-sm btn-link" type="submit" onclick="return ConfirmDelete()">
                                                <span class="far fa-trash-alt fa-lg fam-mod"></span>
                                            </button>
                                        </form>
                                    </td>
                                    @elseif(!Auth::user()->isInstructor())
                                    <td>
                                        @if(!Auth::User()->checkIfStudentDeliveredAss($ass))
                                            <button  class="btn btn-group btn-link">
                                                <a href="{{ route('assignment.deliver', ['course_id' => $course->id, 'module_id' => $module->id, 'id' => $ass->id]) }}" class="text-info"><i class="far fa-envelope-open"> </i> Deliver</a>
                                            </button>
                                        @else
                                            <span class="text-success"><i class="fas fa-check mr-1"></i>Delivered</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <script>

                        function ConfirmDelete(){
                            return confirm('Are you sure you ? THIS CANNOT BE UNDONE');
                        }

                    </script>
                @endif

            </div>
        </div>
    </div> <!-- End: Content -->

    @stop
