<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-LMS | @yield('title')</title>
	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
    {{--  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">  --}}
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <!-- Font-awesome Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_app.css') }}">
    <!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- yield additional css styles inside <style> tag(If Required) -->
    @yield('styles')

</head>
<body class="no-selection">
    
    @include('_inc.navbar')
    <div class="container">
        @section('content')
            @show
    </div>
    
    <!-- ===============/ Scripts /=============== -->
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Font-awesome -->
    <script src="{{ asset('js/fontawesome-all.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
    <!-- yield additional scripts inside <script> tag(If Required) -->
    @yield('scripts')
</body>
</html>