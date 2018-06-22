@extends('_layouts.app')
@section('title', '404 | Page Not Found')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center" style="margin-top: 60px;">
                <h1 class="f-rw text-primary" style="font-size: 150px;">404</h1>
                <p class="text-muted" style="font-size: 18px;">The page you're looking for was moved, removed <br> renamed or may have never existed.</p>
                <div style="border: 1px solid #f5f5f5;margin-top: 25px;"></div>
                <div class="mt-4">
                    <a href="" class="btn btn btn-primary text-uppercase mr-4">back to homepage</a>
                    <a href="" class="btn btn btn-outline-primary text-uppercase">contact with admin</a>
                </div>
            </div>
        </div>
    </div>
@endsection