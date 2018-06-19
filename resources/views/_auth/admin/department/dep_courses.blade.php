@extends('_Auth.admin.admin_layout.admin')
@section('title', $department->name.' - Courses')

@section('admin_content')
<!-- Start: Content -->

<div class="card">
  	<div class="card-body">
        <h3 class="f-rw"><a href="{{ route('department.show',$department->id)}}"><strong>{{$department->name}}</strong></a> department Courses</h3>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Instructor</th>
                        <th scope="col">Specialization</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($department->courses as $course)
                    <tr>
                        <td>{{$course->id}}</td>
                        <td>{{ucfirst($course->title)}}</td>
                        <td>{{$course->code}}</td>
                        <td><a href="{{route('admin.user.profile', ['id' => $course->instructor->id])}}">{{$course->instructor->fname.' '.$course->instructor->lname}}</a></td>
                        <td><a href="{{route('specialization.show', $course->specialization->id)}}">{{$course->specialization->name}}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
  	</div>
</div>


@endsection
