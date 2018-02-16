@extends('_layouts.app')
@section('title', 'Sign up')

@section('content')

<!-- Start: Content -->
<div class="content mt-5 mb-5">
    <div class="container">
        <div class="row">
        
            <div class="col-md-10 offset-md-1">
                @include('_inc.errors')
                @include('_inc.messages')
                <div class="reg-log-form p-3 my-3">
                    <fildset>
                        <legend>Create new user</legend>
                        <form action="{{ route('user.create') }}" method="POST" class="mt-2">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control {{ $errors->has('fname') ? ' is_invalid' : '' }}" name="fname" placeholder="at least 3 chars." value="{{ old('fname') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control {{ $errors->has('lname') ? ' is_invalid' : '' }}" name="lname" placeholder="at least 3 chars." value="{{ old('lname') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control {{ $errors->has('email') ? ' is_invalid' : '' }}" name="email" placeholder="test@example.com" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Confirm Email</label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? ' is_invalid' : '' }}" name="password" placeholder="at least 6 chars.">
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
                                        <select class="form-control {{ $errors->has('department') ? ' is_invalid' : '' }}" name="department" class="list" value="{{ old('department') }}">
                                        <option class="sel-edit" value="null">Select the department</option>
                                        <option class="sel-edit" value="student">Student</option>
                                        <option class="sel-edit" value="instractor">Instractor</option>
                                        <option class="sel-edit" value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="sel1">Gender</label>
                                        <select class="form-control {{ $errors->has('gender') ? ' is_invalid' : '' }}" name="gender" class="list" value="{{ old('gender') }}">
                                        <option value="null">Select</option>
                                        <option value="1">Male</option>
                                        <option value="0">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="sel1">Role</label>
                                        <select class="form-control {{ $errors->has('role') ? ' is_invalid' : '' }}" name="role" class="list" value="{{ old('role') }}">
                                        <option class="sel-edit" value="null">Select</option>
                                        <option class="sel-edit" value="student">Student</option>
                                        <option class="sel-edit" value="instractor">Instractor</option>
                                        <option class="sel-edit" value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Location</label>
                                        <input type="text" class="form-control {{ $errors->has('location') ? ' is_invalid' : '' }}" name="location" value="{{ old('location') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="sel1">Level</label>
                                        <select class="form-control {{ $errors->has('level') ? ' is_invalid' : '' }}" name="level" id="list" value="{{ old('level') }}">
                                        <option class="sel-edit">Select</option>
                                        <option class="sel-edit" value="1">1</option>
                                        <option class="sel-edit" value="2">2</option>
                                        <option class="sel-edit" value="3">3</option>
                                        <option class="sel-edit" value="4">4</option>
                                        <option class="sel-edit" value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="form-group {{ $errors->has('gpa') ? ' is_invalid' : '' }}">
                                        <label for="">GPA</label>
                                        <input type="text" class="form-control" name="gpa" value="{{ old('gpa') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create an account</button>
                            </div>
                        </form>
                    </fildset>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End: Content -->
@endsection