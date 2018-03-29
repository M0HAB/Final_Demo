@extends('_layouts.app')
@section('title', 'Assignments Delivered')
@section('content')

    <!-- Start: Content -->
    <div class="content mt-5 mb-4">
        <div class="container">
            <h1>Assignments Delivered </h1>
            <div class="row justify-content-center">
                @if (count($assdelivered)>0)
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

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($assdelivered as $delivered)
                            <tr>
                                <td>
                                    {{$delivered->assignment->module_id}} {{--module name--}}
                                </td>
                                <td>
                                    {{$delivered->assignment->title}}
                                </td>
                                <td>
                                    {{$delivered->student->fname}}
                                </td>
                                <td>
                                    {{$delivered->answer ? $delivered->answer : 'No Answer'}}
                                </td>
                                <td>

                                    @if(is_null($delivered->file))

                                        No File Attached

                                    @else
                                        <a href="uploads\assignments\delivered\{{$delivered->file}}" download="{{$delivered->file}}">
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

                                        @if($delivered->created_at >= $delivered->assignment->deadline)
                                            <p class="text-danger">LATE </p>

                                       @else
                                            <p class="text-success">ON TIME</p>

                                        @endif

                                    </td>



                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                @endif

            </div>
        </div>
    </div> <!-- End: Content -->

@stop
