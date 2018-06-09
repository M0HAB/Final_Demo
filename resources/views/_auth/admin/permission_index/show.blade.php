@extends('_layouts.app')
@section('title', 'Permission Indexes')


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
        <h1>Permission Indexes</h1>
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
                        @foreach ($pindex as $x)
                        <tr>
                            <td>
                                {{$x->index}}
                            </td>
                            <td>
                                {{$x->name}}
                            </td>
                            <td>
                                <a href="{{ route('pindex.edit',$x->index)}}">
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
