@include('_partials._head')

<body class="no-selection">
    {{--  Navbar  --}}
    @include('_partials._navbar')

    <div class="container my-5"> 
        <div class="content" id="content">
            @yield('content')
        </div> {{--  End: Content  --}}
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
    @yield('scripts')
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
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
</html>