@extends('_layouts.app')
@section('title', 'Roles-Permissions')


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
        <h1>Permissions</h1>
			<div class="row justify-content-center">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Section Name</th>
                            <th>Create</th>
                            <th>Read</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($envelope as $x)
                        <tr>
                            <td>
                                {{$x['name']}}
                            </td>
                            <td>
                                <?php
                                    if ($x['create']==1){
                                ?>
                                    <strong class="f-rw" style="color: #1EBA9C">Yes</strong>
                                <?php }else{ ?>
                                    <strong class="f-rw" style="color: #E74C3C">No</strong>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                    if ($x['read']==1){
                                ?>
                                    <strong class="f-rw" style="color: #1EBA9C">Yes</strong>
                                <?php }else{ ?>
                                    <strong class="f-rw" style="color: #E74C3C">No</strong>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                    if ($x['update']==1){
                                ?>
                                    <strong class="f-rw" style="color: #1EBA9C">Yes</strong>
                                <?php }else{ ?>
                                    <strong class="f-rw" style="color: #E74C3C">No</strong>
                                <?php } ?>
                            </td>  
                            <td>
                                <?php
                                    if ($x['delete']==1){
                                ?>
                                    <strong class="f-rw" style="color: #1EBA9C">Yes</strong>
                                <?php }else{ ?>
                                    <strong class="f-rw" style="color: #E74C3C">No</strong>
                                <?php } ?>
                            </td>                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
			</div>
		</div>
	</div> <!-- End: Content -->
@endsection