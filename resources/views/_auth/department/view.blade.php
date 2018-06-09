@extends('_layouts.app')
@section('title', 'View Department '.$department->name)


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
            <div class="row">
                <h1>{{$department->name}}</h1>
                @if (canUpdate('Department'))
                    <a href="{{ route('departments.edit',$department->id)}}">
                        <span class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Edit this Department"></span>
                    </a>
                @endif
            </div>

            <div class="row">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Department Head</td>
                            <td>{{$department->head_name}}</td>
                        </tr>
                        @if (canUpdate('Department'))
                            <tr>
                                <td>Number of Students</td>
                                <td>{{$department->student_count}}</td>
                            </tr>
                         @endif

                    </tbody>
                </table>


            </div>


		</div>
	</div> <!-- End: Content -->
@endsection
