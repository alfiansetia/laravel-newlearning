<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skydash Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('backend/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    @stack('csslib')
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}" />
    @stack('css')
    <style>
        /*--thank you pop starts here--*/
        .thank-you-pop {
            width: 100%;
            padding: 20px;
            text-align: center;
        }

        .thank-you-pop img {
            width: 76px;
            height: auto;
            margin: 0 auto;
            display: block;
            margin-bottom: 25px;
        }

        .thank-you-pop h1 {
            font-size: 42px;
            margin-bottom: 25px;
            color: #5C5C5C;
        }

        .thank-you-pop p {
            font-size: 20px;
            margin-bottom: 27px;
            color: #5C5C5C;
        }

        .thank-you-pop h3.cupon-pop {
            font-size: 25px;
            margin-bottom: 40px;
            color: #222;
            display: inline-block;
            text-align: center;
            padding: 10px 20px;
            border: 2px dashed #222;
            clear: both;
            font-weight: normal;
        }

        .thank-you-pop h3.cupon-pop span {
            color: #03A9F4;
        }

        .thank-you-pop a {
            display: inline-block;
            margin: 0 auto;
            padding: 9px 20px;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            background-color: #8BC34A;
            border-radius: 17px;
        }

        .thank-you-pop a i {
            margin-right: 5px;
            color: #fff;
        }

        #ignismyModal .modal-header {
            border: 0px;
        }

        /*--thank you pop ends here--*/
    </style>
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



    <div class="modal fade" id="popupmodal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                </div>

                <div class="modal-body">

                    <div class="thank-you-pop" id="pop_content">
                        <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png"
                            alt="">
                        <h1>Thank You!</h1>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('logout') }}" method="POST" id="logout">
        @csrf
    </form>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('backend/vendors/js/vendor.bundle.base.js') }}"></script>
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
        function pop(message = 'Success') {
            $('#pop_content').html(`
                <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
                <h1>Success!</h1>
                <p>${message}</p>
            `)
            $('#popupmodal').modal('show')
        }

        function logout() {
            $('#logout').submit()
        }
    </script>

    @stack('js')

    @if (session()->has('success'))
        <script>
            pop("{{ session('success') }}")
        </script>
    @elseif (session()->has('error'))
        <script>
            pop("{{ session('error') }}")
        </script>
    @endif


</body>



</html>
