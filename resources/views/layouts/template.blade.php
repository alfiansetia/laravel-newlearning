<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <title>{{ $title }} || {{ $company->name }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    @stack('csslib')
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}" />
    @stack('css')

</head>

<body>
    <div class="container-scroller">
        @include('components.navbar')

        <div class="container-fluid page-body-wrapper">

            @include('components.sidebar')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                @include('components.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <form action="{{ route('logout') }}" method="POST" id="form_logout">
        @csrf
    </form>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('backend/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- endinject -->
    <!-- Plugin js for this page -->
    @stack('jslib')
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('backend/js/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('backend/js/template.js') }}"></script>
    <script src="{{ asset('backend/js/settings.js') }}"></script>
    <script src="{{ asset('backend/js/todolist.js') }}"></script>
    <!-- endinject -->

    <script>
        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logout!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="ti-thumb-up"></i> Yes!',
                confirmButtonAriaLabel: 'Thumbs up, Yes!',
                cancelButtonText: '<i class="ti-thumb-down"></i> No',
                cancelButtonAriaLabel: 'Thumbs down',
                customClass: 'animated tada',
                showClass: {
                    popup: 'animate__animated animate__tada'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_logout').submit();
                    block()
                }
            })
        }
    </script>


    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
            })
        </script>
    @elseif (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            })
        </script>
    @endif

    @stack('js')

</body>

</html>
