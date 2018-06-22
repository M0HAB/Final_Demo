@include('_partials._head')

<!-- yield additional css styles inside <style> tag(If Required) -->
@yield('styles')

<body id="my-body" class="no-selection">
    <a id="top"></a>
    {{--  Navbar  --}}
    @if(isset($admin))
        @include('_partials.admin_navbar')
    @else
        @include('_partials._navbar')
        @if(Auth::check())
            @include('_partials._sidebar')
        @endif
    @endif
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
    <script>
        $(document).ready(function () {
            var menu = $('#sidebar');
            var menuBtn = $('#sidebarCollapse');
            $('html').mouseup(function (e) {
                if (!menu.is(e.target) && menu.has(e.target).length === 0 && !menuBtn.is(e.target) && menuBtn.has(e.target).length === 0)
                {
                    $('#sidebar').addClass('active');
                }
            });

            $('#sidebarCollapse').on('click', function (e) {
                $('#sidebar').toggleClass('active');
            });


        });
    </script>
</body>
</html>
