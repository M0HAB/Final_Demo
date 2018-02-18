@extends('_layouts.app')
@section('title', Auth::user()->fname)


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mb-4">
                    <div class="user-dashboard-diss-fourm-prev">
                        <h1 class="display-4">{{ Auth::user()->fname . ' ' . Auth::user()->lname }}</h1>
                        <div class="bbp-breadcrumb pb-4">
                            <p>
                                <a href="http://demo.vellumwp.com/" class="bbp-breadcrumb-home">Home</a> 
                                <span class="bbp-breadcrumb-sep">&rsaquo;</span> 
                                <span class="bbp-breadcrumb-current">Forums</span>
                            </p>
                        </div>
					
					    <form action="">
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
					    </form>
					</div>
				</div>
				<div class="col-lg-4">
					<h4 class="mb-4 pl-2">Recent Topics</h4>
					<div class="row mb-2 pl-2">
						<div class="col-lg-1">
							<i class="fas fa-angle-right d-none d-lg-block"></i>
						</div>
						<div class="col-lg-11 mb-2" style="border-bottom: 1px solid #DEE2E6">
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta, nam.</p>
						</div>
					</div>
					<div class="row mb-2 pl-2">
						<div class="col-lg-1">
							<i class="fas fa-angle-right d-none d-lg-block"></i>
						</div>
						<div class="col-lg-11 mb-2" style="border-bottom: 1px solid #DEE2E6">
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta, nam.</p>
						</div>
					</div>
					<div class="row mb-2 pl-2">
						<div class="col-lg-1">
							<i class="fas fa-angle-right d-none d-lg-block"></i>
						</div>
						<div class="col-lg-11 mb-2" style="border-bottom: 1px solid #DEE2E6">
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta, nam.</p>
						</div>
					</div>
					<div class="row mb-2 pl-2">
						<div class="col-lg-1">
							<i class="fas fa-angle-right d-none d-lg-block"></i>
						</div>
						<div class="col-lg-11 mb-2" style="border-bottom: 1px solid #DEE2E6">
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta, nam.</p>
						</div>
					</div>
					<div class="row mb-2 pl-2">
						<div class="col-lg-1">
							<i class="fas fa-angle-right d-none d-lg-block"></i>
						</div>
						<div class="col-lg-11 mb-2" style="border-bottom: 1px solid #DEE2E6">
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta, nam.</p>
						</div>
					</div>
					<div class="row mb-2 pl-2">
						<div class="col-lg-1">
							<i class="fas fa-angle-right d-none d-lg-block"></i>
						</div>
						<div class="col-lg-11 mb-2" style="border-bottom: 1px solid #DEE2E6">
							<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta, nam.</p>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div> <!-- End: Content -->
@endsection