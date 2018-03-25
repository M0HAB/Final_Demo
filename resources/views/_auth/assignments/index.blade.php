@extends('_layouts.app')
@section('title', 'Assignments')
@section('content')

    <!-- Start: Content -->
    <div class="content mt-5 mb-4">
        <div class="container">
            <h1>Assignments
                @if (Auth::user()->role == 'Instructor')
                    <a href="{{ route('assignments.create') }}" class="btn btn-info" role="button">Create</a>
            </h1>
                @endif
            <div class="row justify-content-center">
                @if (count($assignments)>0)
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Module</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>File</th>
                            <th>Deadline</th>
                            @if (Auth::user()->role == 'Instructor')
                                <th>Actions</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($assignments as $ass)
                            <tr>
                                <td>
                                    {{$ass->module_id}} {{--module name--}}
                                </td>
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
                                        <a href="uploads\{{$ass->file}}" download="{{$ass->file}}">
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

                                @if (Auth::user()->role == 'Instructor')
                                    <td>



                                        <button  class="btn btn-group-sm btn-link"><a href="{{route('assignments.edit', $ass->id)}}"><i class="far fa-edit fa-lg fam-mod"></i> </a> </button>

                                        <form action="{{ route('assignments.destroy',$ass->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-group-sm btn-link" type="submit" onclick="alert('Confirm Delete')">
                                                <span class="far fa-trash-alt fa-lg fam-mod"></span>
                                            </button>
                                        </form>




                                    </td>
                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="col-md-12 col-sm-12">
                        <br>
                        @if (Auth::user()->role == 'Instructor')
                            <a href="{{ route('assignments.create') }}" class="btn btn-success">
                                No Departments . Create Department Here !
                            </a>
                        @else
                            No Departments Found
                        @endif

                    </div>
                @endif

            </div>
        </div>
    </div> <!-- End: Content -->

    @stop
