@extends('_layouts.app')
@section('title', 'Home')

@section('content')

	<!-- Start: Content -->
	<div class="content mt-5 mb-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 d-none d-lg-block my-3">
                    <div>
						<h1 class="display-4">Learning made <strong>easy</strong> via the <strong>internet</strong></h1>

                    	<div class="d-flex flex-row">
	                        <div class="p-4 align-self-start mt-1">
	                            <i class="fa fa-check fa-lg check-bg"></i>
							</div>
	                        <div class="p-4 text-justify align-self-end f-size">
								Learning management system (LMS) is a software application for the administration, documentation, tracking, reporting and delivery of educational courses or training programs.
	                        </div>
						</div>
						
						<div class="d-flex flex-row">
							<div class="p-4 align-self-start mt-1">
								<i class="fa fa-check fa-lg check-bg"></i>
							</div>
							<div class="p-4 text-justify align-self-end f-size">
								They help the instructor deliver material to the students, administer tests and other assignments, track student progress, and manage record-keeping.
							</div>
						</div>

						<div class="d-flex flex-row">
							<div class="p-4 align-self-start mt-1">
								<i class="fa fa-check fa-lg check-bg"></i>
							</div>
							<div class="p-4 text-justify align-self-end f-size">
								LMSs can be complemented by other learning technologies such as a training management system to manage instructor-led training or a Learning Record Store to store and track learning data.
							</div>
						</div>
                    </div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="reg-log-form p-3 my-3">
					@include('_inc.errors')
					<fildset>
					    <legend>Sign into LMS</legend>
						<form id = "regForm" action="{{ route('user.login') }}" method="POST" role="form" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="form-group mt-2">
                                <label class="control-label" for="signupEmail">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input id="signupEmail" type="email" name="email" maxlength="50" class="form-control" placeholder="test@example.com" required>
								</div>
                            </div>
                            <div class="form-group mt-2">
                                <label class="control-label" for="signupPassword">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                                    </div>
                                    <input id="signupPassword" type="password" name="password" maxlength="25" class="form-control" length="40" required>
								</div>
                            </div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customCheck1">
								<label class="custom-control-label" for="customCheck1">Remember me</label>
							</div>
                                <div class="form-group mt-3">
                                    <button id="signupSubmit" type="submit" class="btn btn-primary btn-block">Sign in</button>
                                </div>
                            </form>
                        </fildset>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End: Content -->
	
@endsection
	
