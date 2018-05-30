@extends('_layouts.app')
@section('title', 'Assignments Delivered')
@section('content')
    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-4">
        <div class="container">
            <h1>Assignments Delivered </h1>
            <br>
            @if (count($assdelivered)>0)
                <div class="row justify-content-center">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Module</th>
                            <th>Title</th>
                            <th>Student Name</th>
                            <th>Answer</th>
                            <th>File</th>
                            <th>Submitted Date</th>
                            <th>Status</th>
                            <th>Grade</th>

                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($assdelivered as $delivered)
                                <tr>
                                    <td>
                                        {{$delivered->module_id}} {{--module name--}}
                                    </td>
                                    <td>
                                        {{$delivered->title}}
                                    </td>
                                    <td>
                                        {{$delivered->fname}}
                                    </td>
                                    <td>
                                        {{$delivered->answer ? $delivered->answer : 'No Answer'}}
                                    </td>
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
                                        {{{date('d-m-Y', strtotime($delivered->created_at))}}}
                                    </td>


                                    <td>

                                        @if($delivered->created_at >= $delivered->deadline)
                                            <p class="text-danger">LATE </p>

                                       @else
                                            <p class="text-success">ON TIME</p>

                                        @endif

                                    </td>
                                    <td>


                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                <div>
            @else
                <p class="text-left"><i class="fa fa-info-circle mr-2"></i>The module has no assignment delivered yet</p>
            @endif

        </div>
    </div> <!-- End: Content -->

@stop
