@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Edit User - '.$user->fname.' '.$user->lname)
@section('admin_content')

<div class="card">
  	<div class="card-body">


    @include('_partials.errors')
    @include('_partials.messages')
        <fildset>
            <legend class="f-rw">
                Edit <strong><a href="{{route('admin.user.profile', ['id'=>$user->id])}}">{{$user->fname.' '.$user->lname}}</a></strong> <span class="badge badge-light">{{$user->role->name}}</span>
                @if($user->trashed())
                    <span class="badge badge-danger">Deleted</span>
                @endif
            </legend>
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
                            <input type="email" class="form-control {{ $errors->has('email') ? ' is_invalid' : '' }}" id="email" name="email" placeholder="test@example.com" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="">Confirm Email</label>
                            <input type="email" value = "{{old('email_confirmation')}}" class="form-control" name="email_confirmation">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="">Department</label>
                            <select class="form-control {{ $errors->has('department') ? ' is_invalid' : '' }}" id="department" name="department" class="list" value="{{ old('department') }}">
                            <option value="">Select</option>
                            @foreach ($deps as $dep)
                                <option value="{{ $dep->id }}" {{ (old('department') == $dep->id)? 'selected':'' }}>{{ $dep->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="sel1">Gender</label>
                            <select class="form-control {{ $errors->has('gender') ? ' is_invalid' : '' }}" id="gender" name="gender" class="list" value="{{ old('gender') }}">
                            <option value="">Select</option>
                            <option value="1" {{ (old('gender') == 1)?'selected':'' }}>Male</option>
                            <option value="0" {{ (old('gender') == 0)?'selected':'' }}>Female</option>
                            </select>
                        </div>
                    </div>
                    @if($user->isStudent())
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
                            <option value="1" {{ (old('level') == 1)?'selected':'' }}>1</option>
                            <option value="2" {{ (old('level') == 2)?'selected':'' }}>2</option>
                            <option value="3" {{ (old('level') == 3)?'selected':'' }}>3</option>
                            <option value="4" {{ (old('level') == 4)?'selected':'' }}>4</option>
                            <option value="5" {{ (old('level') == 5)?'selected':'' }}>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12" id="gpaGrp">
                        <div class="form-group {{ $errors->has('gpa') ? ' is_invalid' : '' }}">
                            <label for="">GPA</label>
                            <input type="text" class="form-control" id="gpa" name="gpa" value="{{ old('gpa') }}">
                        </div>
                    </div>
                    @else
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" class="form-control {{ $errors->has('location') ? ' is_invalid' : '' }}" id="location" name="location" value="{{ old('location') }}">
                        </div>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" id="registerBtn" class="btn btn-primary">Confirm Edit</button>
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
                url : "{{ route('admin.user.update',['id'=>$user->id]) }}",
                dataType: 'JSON',
                data: $('#reg-form').serialize(),
                async: true,
                success: function(data) {
                    console.log(data);
                }
            }).done(function(data) {
                if ($.isEmptyObject(data.error)) {
                    toastr.success(data.success);
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
