@extends('_layouts.app')
@section('title', 'Permissions')


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
        <h1>Permissions</h1>
			<div class="row justify-content-center">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pIndex as $x)
                        <tr>
                            <td>
                                {{$x->index}}
                            </td>
                            <td>
                                {{$x->name}}
                            </td>
                            <td>
                                <a href="{{ route('permission.edit',$x->index)}}">
                                    <span class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></span>
                                </a>                             
                            </td>
                                
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
			</div>
		</div>
	</div> <!-- End: Content -->
@endsection