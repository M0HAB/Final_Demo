@extends('_layouts.app')
@section('title', 'Admin Login')

@section('content')
		<!-- Start: Home-Content -->
		<div class="row">
			<div class="col-lg-8 d-none d-lg-block my-3">
				<div>
					<h1 class="display-4 f-rw mb-2">Learning made <strong class="f-rw" style="color: #1EBA9C">easy</strong> via the <strong class="f-rw" style="color: #1EBA9C">internet</strong></h1>
					<div class="d-flex flex-row">
						<div class="p-4 align-self-start mt-1">
							<i class="fa fa-check fa-lg check-bg"></i>
						</div>
						<div class="p-4 text-justify align-self-end f-size">
							<p class="f-rw">
								Learning management system (LMS) is a software application for the administration, documentation, tracking, reporting and delivery of educational courses or training programs.
							</p>
						</div>
					</div>

					<div class="d-flex flex-row">
						<div class="p-4 align-self-start mt-1">
							<i class="fa fa-check fa-lg check-bg"></i>
						</div>
						<div class="p-4 text-justify align-self-end f-size">
							<p class="f-rw">
								They help the instructor deliver material to the students, administer tests and other assignments, track student progress, and manage record-keeping.
							</p>
						</div>
					</div>

					<div class="d-flex flex-row">
						<div class="p-4 align-self-start mt-1">
							<i class="fa fa-check fa-lg check-bg"></i>
						</div>
						<div class="p-4 text-justify align-self-end f-size">
							<p class="f-rw">
								LMSs can be complemented by other learning technologies such as a training management system to manage instructor-led training or a Learning Record Store to store and track learning data.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-sm-12">
				<div class="reg-log-form p-3 my-3">
				@include('_partials.errors')
				@include('_partials.messages')
				<fildset>
					<legend>Admin Sign into LMS</legend>
					<form action="{{ route('admin.login') }}" method="POST" role="form" autocomplete="off">
						{{ csrf_field() }}
						<div class="form-group mt-2">
							<label class="control-label" for="signupEmail">Email</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input id="signupEmail" type="email" name="email" maxlength="50" class="form-control" value="{{ old('email') }}" placeholder="test@example.com">
							</div>
						</div>
						<div class="form-group mt-2">
							<label class="control-label" for="signupPassword">Password</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
								</div>
								<input id="signupPassword" type="password" name="password" maxlength="25" class="form-control" length="40">
							</div>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck1">
							<label class="custom-control-label" for="customCheck1">Remember me</label>
						</div>
						<div class="form-group mt-4">
							<button id="signupSubmit" type="submit" class="btn btn-primary btn-block">Sign in</button>
						</div>
						</form>
					</fildset>
				</div>
			</div>
		</div> <!-- End: Home-Content -->
@endsection
