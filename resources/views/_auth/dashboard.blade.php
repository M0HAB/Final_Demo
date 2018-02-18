@extends('_layouts.app')
@section('title', Auth::user()->fname)


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-sm-12 mb-4">
                    <div class="user-dashboard-diss-fourm-prev">
                        <h1 class="display-4">{{ Auth::user()->fname }}</h1>
                        <div class="bbp-breadcrumb pb-4">
                            <p>
                                <a href="http://demo.vellumwp.com/" class="bbp-breadcrumb-home">Home</a> 
                                <span class="bbp-breadcrumb-sep">&rsaquo;</span> 
                                <span class="bbp-breadcrumb-current">Dashboard</span>
                            </p>
                        </div>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Discussion Forum</th>
									<th>Topics</th>
									<th>Posts</th>                                             
									<th>Recent Post</th>
								</tr>
							</thead>
							<tbody>
								<tr>
                                    <td>
                                        <a href="#" class="font-weight-bold forum-nav">Artificial Intelligence</a>
                                        <p class="text-muted pt-1 forum-p">If it is football, hiking or whatever: Activities go here</p>
                                    </td>
                                    <td>
                                        <i class="far fa-comment fa-lg fam-mod"></i> <span class="forum-lbl">3</span>
                                    </td>
                                    <td>
                                        <i class="far fa-comments fa-lg fam-mod"></i> <span class="forum-lbl">7</span>
                                    </td>
                                    <td>
                                        <span class="text-muted forum-recent-time">4 years, 1 month ago</span>
                                    </td>
								</tr>
								<tr>
                                    <td>
                                        <a href="#" class="font-weight-bold forum-nav">Computer Modelling And Simulation</a>
                                        <p class="text-muted pt-1 forum-p">If it is football, hiking or whatever: Activities go here</p>
                                    </td>
                                    <td>
                                        <i class="far fa-comment fa-lg fam-mod"></i> <span class="forum-lbl">3</span>
                                    </td>
                                    <td>
                                        <i class="far fa-comments fa-lg fam-mod"></i> <span class="forum-lbl">7</span>
                                    </td>
                                    <td>
                                        <span class="text-muted forum-recent-time">4 years, 1 month ago</span>
                                    </td>
								</tr>
								<tr>
                                    <td>
                                        <a href="#" class="font-weight-bold forum-nav">Digital Signal Processing</a>
                                        <p class="text-muted pt-1 forum-p">If it is football, hiking or whatever: Activities go here</p>
                                    </td>
                                    <td>
                                        <i class="far fa-comment fa-lg fam-mod"></i> <span class="forum-lbl">3</span>
                                    </td>
                                    <td>
                                        <i class="far fa-comments fa-lg fam-mod"></i> <span class="forum-lbl">7</span>
                                    </td>
                                    <td>
                                        <span class="text-muted forum-recent-time">4 years, 1 month ago</span>
                                    </td>
								</tr>
								<tr>
                                    <td>
                                        <a href="#" class="font-weight-bold forum-nav">Pattern Recognition</a>
                                        <p class="text-muted pt-1 forum-p">If it is football, hiking or whatever: Activities go here</p>
                                    </td>
                                    <td>
                                        <i class="far fa-comment fa-lg fam-mod"></i> <span class="forum-lbl">3</span>
                                    </td>
                                    <td>
                                        <i class="far fa-comments fa-lg fam-mod"></i> <span class="forum-lbl">7</span>
                                    </td>
                                    <td>
                                        <span class="text-muted forum-recent-time">4 years, 1 month ago</span>
                                    </td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<h4 class="mb-4 pl-2">Recent Topics</h4>
					<div class="list-group">
						<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-2">Lorem ipsum dolor sit amet.</h5>
								<small class="text-muted txt-lbl">3 days ago</small>
							</div>
							<p class="mb-1 recent-p-mod">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae, quia.</p>
							<small class="text-muted txt-lbl">Posted by: <span class="font-weight-bold">Mohab Hamdy</span></small>
						</a>
						<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-2">Lorem ipsum dolor sit amet.</h5>
								<small class="text-muted txt-lbl">3 days ago</small>
							</div>
							<p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae, sit!</p>
							<small class="text-muted txt-lbl">Posted by: <span class="font-weight-bold">Mohab Hamdy</span></small>
						</a>
						<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-2">Lorem ipsum dolor sit amet.</h5>
								<small class="text-muted txt-lbl">3 days ago</small>
							</div>
							<p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, temporibus.</p>
							<small class="text-muted txt-lbl">Posted by: <span class="font-weight-bold">Mohab Hamdy</span></small>
						</a>
						<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-2">Lorem ipsum dolor sit amet.</h5>
								<small class="text-muted txt-lbl">3 days ago</small>
							</div>
							<p class="mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, temporibus.</p>
							<small class="text-muted txt-lbl">Posted by: <span class="font-weight-bold">Mohab Hamdy</span></small>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End: Content -->
@endsection