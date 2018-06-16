@extends('_layouts.app')
@section('title', 'Admin Login')

@section('content')
		<!-- Start: Home-Content -->
		<div class="row">

			<div class="offset-lg-3 col-lg-6 col-sm-12">
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

						<div class="form-group mt-4">
							<button id="signupSubmit" type="submit" class="btn btn-primary btn-block">Sign in</button>
						</div>
						</form>
					</fildset>
				</div>
			</div>
		</div> <!-- End: Home-Content -->
@endsection
