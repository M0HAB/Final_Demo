@extends('_layouts.app')
@section('title', 'Assignments Delivered')
@section('content')
    {{-- Start Breadcrumbs--}}
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item text-success"><a href="/Courses/">Courses</a></li>
                <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id}}">{{ $course->title }}</a></li>
                <li class="breadcrumb-item text-success">Module</li>
                <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id. "/Modules/" .$module->id}}">{{ $module->title }}</a></li>
                <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id. "/Modules/" .$module->id. "/assignments"}}">Assignments</a></li>
                <li class="breadcrumb-item active"><a href="/Courses/{{$course->id. "/Modules/" .$module->id. "/assignmentDelivered"}}">Delivered</a></li>
            </ol>
        </div>
        <div class="col-lg-12">
            <h1 class="f-rw my-4">Assignments Delivered</h1>
            <h4 class="f-rw my-4">Student Name:{{Auth::user()->fname}}</h4>
            <h4 class="f-rw my-4">Course Name:{{$course->title}}</h4>
        </div>
    </div>
    {{-- End Breadcrumbs--}}

    <!-- Start: Content -->



    <br>
    @if (count($assdelivered)>0)

        <div class="row justify-content-center">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>File</th>
                    <th>Deadline</th>
                    <th>comment</th>
                    <th>grade</th>
                    <th>submitted on</th>
                    <th>Feedback</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($assdelivered as $delivered)

                    <tr>

                       <td>{{$delivered->title}} </td>
                        <td>

                            @if(is_null($delivered->file))

                                No File Attached

                            @else
                                <a href="{{asset("uploads\assignments\delivered") }}\{{$delivered->file}}" download="{{$delivered->file}}">
                                    <button type="button" class="btn btn-primary btn-block">
                                        <i class="fas fa-cloud-download-alt "></i>
                                        Download
                                    </button>
                                </a>

                            @endif
                        </td>
                        <td>
                            {{{date('d-m-Y', strtotime($delivered->deadline))}}}
                        </td>
                        <td>
                            {{{$delivered->answer}}}
                        </td>
                        <td>
                            <p> {{$delivered->grade ? $delivered->grade : "-"}} / {{$delivered->full_mark}} </p>
                        </td>

                        <td>
                            {{{date('d-m-Y', strtotime($delivered->created_at))}}}
                        </td>

                        <td>
                            <p> {{$delivered->comment ? $delivered->comment : "No Comment "}} </p>
                        </td>



                    </tr>



                @endforeach

                </tbody>
            </table>
            </div>




    @else


        <p class="text-left"><i class="fa fa-info-circle mr-2"></i>No assignment delivered yet</p>

    @endif


@stop