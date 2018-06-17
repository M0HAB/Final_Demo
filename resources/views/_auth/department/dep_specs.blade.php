@extends('_layouts.app')
@section('title', $department->name.' - Specializations')


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$department->name}}</strong> department Specializations</h3>
</div>
<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">No. of Courses in this department</th>
                @if (canUpdate('Department'))
                    <th></th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($department->specializations->sortBy('id') as $specialization)
                <tr id="depspec_container_{{$specialization->id}}">
                    <td>{{$specialization->id}}</td>
                    <td><a href="{{route('specialization.show', $specialization->id)}}">{{ucfirst($specialization->name)}}</a></td>
                    <td>{{count($specialization->courses->where('course_department', $department->id))}}</td>
                    @if (canUpdate('Department'))
                        <td>
                            <button class="btn btn-danger" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$specialization->id}}" data-depid="{{$department->id}}" data-type="depspec">
                                    <span class="far fa-trash-alt fa-lg "></span>
                            </button>
                        </td>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
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
