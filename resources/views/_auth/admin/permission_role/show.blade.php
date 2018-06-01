@extends('_layouts.app')
@section('title', 'Roles-Permissions')


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
        <h1>Permissions <a href="{{ route('prole.create')}}">
            <button class="btn btn-primary" href="{{ route('prole.create')}}" data-toggle="tooltip" data-placement="top" title="Create">
                <span class="fas fa-plus" ></span>
            </button>
        </a> </h1>
        
			<div class="row justify-content-center">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permission</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perRole as $x)
                        <tr>
                            <td>
                                {{$x->id}}
                            </td>
                            <td>
                                {{$x->name}}
                            </td>
                            <td>
                                <a href={{ route('prole.show',$x->id)}}>View Permissions for this role</a>
                            </td>
                            <td>
                                
                                <a href="{{ route('prole.edit',$x->id)}}">
                                    <button class="btn btn-success" href="{{ route('prole.edit',$x->id)}}">
                                        <span class="far fa-edit"></span>
                                    </button>
                                </a>                             
                            </td>
                            <td>
                                <form action="{{ route('prole.destroy',$x->id)}}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger" type="submit" onclick="confirm('Are you sure you want to Delete this?')">
                                        <span class="far fa-trash-alt fa-lg fam-mod"></span>
                                    </button>
                                </form>                                
                            </td>
                                
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
			</div>
		</div>
	</div> <!-- End: Content -->
@endsection