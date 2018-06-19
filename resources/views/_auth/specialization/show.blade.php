@extends('_layouts.app')
@section('title', 'Specializations')


@section('content')
<!-- Start: Content -->
<div class="content mt-5 mb-4">
	<h3>Specializations</h3>
	<div class="row justify-content-center">
        @if (count($specializations)>0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Specialization Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($specializations as $spec)
                    <tr id="specialization_container_{{$spec->id}}">
                        <td>
                            <a href="{{ route('user.specialization.show',$spec->id)}}" class="font-weight-bold forum-nav">{{$spec->name}}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="col-md-12 col-sm-12">
                <br>
                    No Specializations Found
            </div>
        @endif
	</div>
</div> <!-- End: Content -->
@endsection
