@extends('_layouts.app')
@section('title', 'Assignments')
@section('content')

    <!-- Start: Content -->

    {{-- Start Breadcrumbs--}}
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item text-success"><a href="/Courses/">Courses</a></li>
                <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id}}">{{ $course->title }}</a></li>
                <li class="breadcrumb-item text-success">Module</li>
                <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id. "/Modules/" .$module->id}}">{{ $module->title }}</a></li>
                <li class="breadcrumb-item active"><a href="/Courses/{{$course->id. "/Modules/" .$module->id. "/assignments"}}">Assignments</a></li>

            </ol>
        </div>

        <div class="col-lg-12 my-4">
            <div class="row">
                <div class="col-lg-4">
                    <h1 class="f-rw">Assignments</h1>
                </div>
                <div class="col-lg-8">
                    @if (Auth::user()->isInstructor())
                        <div class="float-right" style="position:relative;top:10px">
                            @if(canCreate('Assignment'))
                                <a href="{{ route('assignments.create', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="btn btn-info" role="button">Create</a>
                            @endif
                            <a href="{{ route('assignment.delivered', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="btn btn-success" role="button">Delivered </a>
                        </div>
                    @elseif(!Auth::user()->isInstructor())
                        <div class="float-right" style="position:relative;top:10px">
                        <a href="{{ route('assignments.show', ['course_id' => $course->id, 'module_id' => $module->id,'student_id' => Auth::user()->id]) }}" class="btn btn-success" role="button">My delivered assginments </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
                @if (count($assignments)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>File</th>
                        <th>Deadline</th>
                        <th>Full Mark</th>
                        <th colspan="2">Actions</th>

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
                                    {{--  <button  class="btn btn-group-sm btn-link pl-0"><a href="{{route('assignments.edit', ['course_id' => $course->id, 'module_id' => $module->id, 'ass_id' => $ass->id])}}"><i class="far fa-edit fa-lg fam-mod"></i> </a> </button>  --}}
                                    @if(canUpdate('Assignment'))
                                        <a href="{{route('assignments.edit', ['course_id' => $course->id, 'module_id' => $module->id, 'ass_id' => $ass->id])}}" class="btn btn-link pl-0"><i class="far fa-edit fa-lg text-primary"></i> </a>
                                    @endif
                                    @if(canDelete('Assignment'))
                                        <form class="d-inline-block" action="{{ route('assignments.destroy', ['course_id' => $course->id, 'module_id' => $module->id, 'ass_id' => $ass->id])}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <a href="" class="btn btn-link pl-0" onclick="ConfirmDelete();"><span class="far fa-trash-alt fa-lg text-primary"></span></a>
                                            {{--  <button class="btn btn-primary pl-0" type="submit" onclick="return ConfirmDelete()">
                                                <span class="far fa-trash-alt fa-lg fam-mod"></span>
                                            </button>  --}}
                                        </form>
                                    @endif
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

    @stop
