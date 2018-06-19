@extends('_Auth.admin.admin_layout.admin')
@section('title', $specialization->name.' - Courses')


@section('admin_content')
<div class="card">
  	<div class="card-body">
        <h3 class="f-rw"><a href="{{ route('specialization.show',$specialization->id)}}"><strong>{{$specialization->name}}</strong></a> Specialization Courses</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Instructor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($specialization->courses as $course)
                <tr>
                    <td>{{$course->id}}</td>
                    <td>{{ucfirst($course->title)}}</td>
                    <td>{{$course->code}}</td>
                    <td><a href="{{route('admin.user.profile', ['id' => $course->instructor->id])}}">{{$course->instructor->fname.' '.$course->instructor->lname}}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
	</div>
</div>
@endsection
