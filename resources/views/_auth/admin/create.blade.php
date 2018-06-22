@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Create Admin')
@section('admin_content')
<div class="card">
  <div class="card-body">
      @include('_partials.errors')
      @include('_partials.messages')
      <fildset>
          <legend>Create New Admin</legend>
          <form id="reg-form" class="mt-2">
              {{ csrf_field() }}
              <div class="row">
                  <div class="col-lg-6 col-sm-12">
                      <div class="form-group">
                          <label for="">First Name</label>
                          <input type="text" class="form-control {{ $errors->has('fname') ? ' is_invalid' : '' }}" id="fname" name="fname" placeholder="at least 3 chars." value="{{ old('fname') }}" data-toggle="popover"  data-trigger="hover" data-placement="left" required>
                      </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                      <div class="form-group">
                          <label for="">Last Name</label>
                          <input type="text" class="form-control {{ $errors->has('lname') ? ' is_invalid' : '' }}" id="lname" name="lname" placeholder="at least 3 chars." value="{{ old('lname') }}" data-toggle="popover" data-trigger="hover" data-placement="right" required>
                      </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                      <div class="form-group">
                          <label for="">Email</label>
                          <input type="email" class="form-control {{ $errors->has('email') ? ' is_invalid' : '' }}" id="email" name="email" placeholder="test@example.com" value="{{ old('email') }}" required>
                      </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                      <div class="form-group">
                          <label for="">Confirm Email</label>
                          <input type="email" class="form-control" id="confirm-email" name="email_confirmation" required>
                      </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                      <div class="form-group">
                          <label for="">Password</label>
                          <input type="password" class="form-control {{ $errors->has('password') ? ' is_invalid' : '' }}" id="password" name="password" placeholder="at least 6 chars." required>
                      </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                      <div class="form-group">
                          <label for="">Confrim Password</label>
                          <input type="password" class="form-control" name="password_confirmation" required>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <button type="submit" id="registerBtn" class="btn btn-primary">Create an account</button>
              </div>
          </form>
      </fildset>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#reg-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "{{ route('admin.store') }}",
                dataType: 'JSON',
                data: $('#reg-form').serialize(),
                async: true,
                success: function(data) {
                    // console.log(data);
                }
            }).done(function(data) {
                if ($.isEmptyObject(data.error)) {
                    toastr.success(data.success);
                    $('#reg-form')[0].reset();
                }
                else {
                    $.each(data.error, function(i, val)
                    {
                        toastr.error(val);
                    });
                }
            });
        });
    });
</script>
@endsection
