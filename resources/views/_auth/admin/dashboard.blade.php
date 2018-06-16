@extends('_Auth.admin.admin_layout.admin')
@section('title', Auth::user()->fname)

@section('admin_content')
<div class="jumbotron text-center bg-transparent border rounded-0 border-secondary">
    <h1 class="display-4">Hello, {{ Auth::user()->fname }}</h1>
    <div class="bbp-breadcrumb pb-4">
        <p>
            <a href="#" class="bbp-breadcrumb-home forum-nav">Home</a>
            <span class="bbp-breadcrumb-sep">&rsaquo;</span>
            <span class="bbp-breadcrumb-current">{{ getEndPoint() }}</span>
        </p>
    </div>
    <h5 class="card-title">Welcome to your dashboard you can navigate anywere using the left bar</h5>
    <hr class="my-4">
    <p class="card-text">Treat it with cautious you are the <strong>Admin</strong> after all</p>
</div>
@endsection
