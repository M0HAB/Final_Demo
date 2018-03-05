@extends('_layouts.app')
@section('title', 'Forgot Password')

@section('content')
    <div class="row">
        <!-- Forgot-Passwword -->
        <div class="offset-lg-2 col-lg-8 my-5">
            <form action="{{ route('user.checkreset.email') }}" method="post">
                @csrf
                <div class="card border-light mb-3">
                    <div class="card-header">Forgot Password</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Registered Email">
                        </div>
                        <div class="from-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- End: Forgot-Passwword -->
@endsection