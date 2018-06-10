@include('_partials._head')

<body id="my-body" class="no-selection">
    <a id="top"></a>
    {{--  Navbar  --}}
    @include('_partials._navbar')

    <div class="container my-5"> 
        <div class="content" id="content">
            @yield('content')
        </div> {{--  End: Content  --}}
    </div>
    <a href="#top" id="btn-scroll" class="btn-scroll-custom"><i class="fas fa-arrow-up"></i></a>            
    
    
    <!-- ===============/ Scripts /=============== -->
    <!-- jQuery library -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!--  Popper-js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <!-- Latest compiled JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Font-awesome -->
    <script src="{{ asset('js/fontawesome-all.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.min.js') }}"></script>
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