@extends('_layouts.app')
@section('title', 'Sign up')

@section('content')
    <!-- Start: Register-User -->
    <div class="content mt-5 mb-5">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                @include('_partials.errors')
                @include('_partials.messages')
                <div class="reg-log-form p-3 my-2">
                    <fildset>
                        <legend>Create new user</legend>
                        <form id="reg-form" class="mt-2">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control {{ $errors->has('fname') ? ' is_invalid' : '' }}" id="fname" name="fname" placeholder="at least 3 chars." value="{{ old('fname') }}" data-toggle="popover"  data-trigger="hover" data-placement="left">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control {{ $errors->has('lname') ? ' is_invalid' : '' }}" id="lname" name="lname" placeholder="at least 3 chars." value="{{ old('lname') }}" data-toggle="popover" data-trigger="hover" data-placement="right">
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
                                        <input type="password" class="form-control {{ $errors->has('password') ? ' is_invalid' : '' }}" id="password" name="password" placeholder="at least 6 chars.">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Confrim Password</label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Department</label>
                                        <select class="form-control {{ $errors->has('department') ? ' is_invalid' : '' }}" id="department" name="department" class="list" value="{{ old('department') }}">
                                        <option value="">Select</option>
                                        @foreach ($deps as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="sel1">Gender</label>
                                        <select class="form-control {{ $errors->has('gender') ? ' is_invalid' : '' }}" id="gender" name="gender" class="list" value="{{ old('gender') }}">
                                        <option value="">Select</option>
                                        <option value="1">Male</option>
                                        <option value="0">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="sel1">Role</label>
                                        <select class="form-control {{ $errors->has('role') ? ' is_invalid' : '' }}" id="role" name="role" class="list" value="{{ old('role') }}">
                                        <option value="">Select</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                        {{--  <option value="student">Student</option>
                                        <option value="instructor">Instructor</option>
                                        <option value="admin">Admin</option>  --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Location</label>
                                        <input type="text" class="form-control {{ $errors->has('location') ? ' is_invalid' : '' }}" id="location" name="location" value="{{ old('location') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12" id="levelGrp">
                                    <div class="form-group">
                                        <label for="sel1">Level</label>
                                        <select class="form-control {{ $errors->has('level') ? ' is_invalid' : '' }}" id="level" name="level" id="list" value="{{ old('level') }}">
                                        <option value="">Select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12" id="gpaGrp">
                                    <div class="form-group {{ $errors->has('gpa') ? ' is_invalid' : '' }}">
                                        <label for="">GPA</label>
                                        <input type="text" class="form-control" id="gpa" name="gpa" value="{{ old('gpa') }}">
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
        </div>
    </div> <!-- End: Register-User -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var instructorId = {{('App\Role')::where('name', 'instructor')->first()->id}}
        $('#role').change(function(){
          if($(this).val()== instructorId){
            $('#levelGrp').hide();
            $('#gpaGrp').hide();
            $('#level').val('');
            $('#gpa').val('');
          }else{
            $('#levelGrp').show();
            $('#gpaGrp').show();
          }
        });
        $('#reg-form').submit(function(e) {
            e.preventDefault();           
            $.ajax({
                type : "POST",
                url : "{{ route('user.create') }}",
                dataType: 'JSON',
                data: $('#reg-form').serialize(),
                async: true,
                success: function(data) {
                    console.log(data);
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
