@extends('_layouts.app')
@section('title', 'View Specialization '.$specialization->name)


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$specialization->name}}</strong> Specialization</h3>
    @if (canUpdate('Specialization'))
        <a href="{{ route('specialization.edit',$specialization->id)}}">
            <span class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Edit this Specialization"></span>
        </a>
    @endif
</div>
<div class="row">
    <table class="table">
        <tbody>
			<tr>
                <td>Specialization Courses</td>
                <td><a href="{{route('specialization.courses', $specialization->id)}}">View Courses</a></td>
            </tr>
            <tr>
                <td>Specialization Departments</td>
                <td><a href="{{route('specialization.departments', $specialization->id)}}">View Departments</a></td>

            </tr>
        </tbody>
    </table>
</div>
@endsection
