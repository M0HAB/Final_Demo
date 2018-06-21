@extends('_Auth.admin.admin_layout.admin')
@section('title', $department->name.' - Specializations')


@section('admin_content')

<div class="card">
  	<div class="card-body">
        <h3 class="f-rw"><a href="{{ route('department.show',$department->id)}}"><strong>{{$department->name}}</strong></a> department Specializations</h3>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">No. of Courses in this Specialization</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($department->specializations->sortBy('id') as $specialization)
                        <tr id="depspec_container_{{$specialization->id}}">
                            <td>{{$specialization->id}}</td>
                            <td><a href="{{route('specialization.show', $specialization->id)}}">{{ucfirst($specialization->name)}}</a></td>
                            <td>{{count($specialization->courses->where('course_department', $department->id))}}</td>
                            <td>
                                <button class="btn btn-link text-primary p-0" type="submit" title="Delete" data-toggle="modal" data-target="#confirm" data-id="{{$specialization->id}}" data-depid="{{$department->id}}" data-type="depspec">
                                        <span class="fas fa-trash fa-lg "></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
  	</div>
</div>

@include('_partials.modal_confirm')
@endsection
@section('scripts')
<script src="{{asset('js/axios.min.js')}}"></script>
<script>
  var api_token = "{{ Auth::user()->api_token}}";
</script>
<script src="{{asset('js/modal_confirm.js')}}" charset="utf-8"></script>
@endsection
