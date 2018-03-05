@extends('_layouts.app')
@section('title', 'Reset Password')

@section('content')
    <div class="row">
        <div class="offset-lg-2 col-lg-8 my-5">
                @if ($user->count() > 0)
                @foreach ($user as $prop)
                    <div class="card border-light mb-3">
                        <div class="card-header">{{ $prop->email }}</div>
                        <div class="card-body">
                            <form action="{{ route('user.reset.password', ['id' => $prop->id]) }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Reset">
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection