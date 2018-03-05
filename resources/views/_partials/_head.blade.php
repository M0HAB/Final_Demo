<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-LMS | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <!-- Font-awesome Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    @yield('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/_app.css') }}">
    <!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>