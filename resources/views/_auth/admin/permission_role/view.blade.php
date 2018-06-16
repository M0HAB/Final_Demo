@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Permissions - '.$envelope['name'])
@section('admin_content')
<!-- Start: Content -->
<div class="card">
	<div class="card-body">
		<h3 class="pb-2 f-rw">Permissions of <strong>{{$envelope['name']}}</strong></h3>
			<div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Index Name</th>
                            <th>Create</th>
                            <th>Read</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pindexes as $pindex)
                        <tr>
                            <td>
                                {{$pindex->name}}
                            </td>
                            <td>
								@if(isset($envelope['create'.$pindex->index]))
								<p class="f-rw text-success font-weight-bold"><i class="fas fa-check"></i></p>
								@else
								<p class="f-rw text-danger font-weight-bold"><i class="fas fa-times"></i></p>
								@endif
                            </td>
							<td>
								@if(isset($envelope['read'.$pindex->index]))
								<p class="f-rw text-success font-weight-bold"><i class="fas fa-check"></i></p>
								@else
								<p class="f-rw text-danger font-weight-bold"><i class="fas fa-times"></i></p>
								@endif
                            </td>
                            <td>
								@if(isset($envelope['update'.$pindex->index]))
								<p class="f-rw text-success font-weight-bold"><i class="fas fa-check"></i></p>
								@else
								<p class="f-rw text-danger font-weight-bold"><i class="fas fa-times"></i></p>
								@endif
                            </td>
                            <td>
								@if(isset($envelope['delete'.$pindex->index]))
								<p class="f-rw text-success font-weight-bold"><i class="fas fa-check"></i></p>
								@else
								<p class="f-rw text-danger font-weight-bold"><i class="fas fa-times"></i></p>
								@endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

			</div>
	</div>
</div>
@endsection
