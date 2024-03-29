<!-- Header Section Begin -->
<header class="header">
    {{-- <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                            <li>Free Shipping for all Order of $99</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <div class="header__top__right__language">
                            <img src="{{ asset('frontend/img/language.png') }}" alt="">
                            <div>English</div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="#">Spanis</a></li>
                                <li><a href="#">English</a></li>
                            </ul>
                        </div>
                        <div class="header__top__right__auth">
                            <a href="#"><i class="fa fa-user"></i> Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{ route('index.category') }}"><img src="{{ $company->logo }}" alt=""
                            style="max-height: 40px; max-width: 40px;">
                        <font color="#27367f" size="5"><strong>{{ $company->name }}</strong></font>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                {{-- <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="{{ route('index.category') }}">Home</a></li>
                        <li><a href="{{ route('index.course.list') }}">Course</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="./shop-details.html">Shop Details</a></li>
                                <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                <li><a href="./checkout.html">Check Out</a></li>
                                <li><a href="./blog-details.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="./blog.html">Blog</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                    </ul>
                </nav> --}}
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        @auth
                            <li>
                                <a href="{{ route('index.profile') }}">
                                    <img src="{{ asset('images/dollar.png') }}" alt="" width="18">
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cart.index') }}">
                                    <i class="fa fa-shopping-bag"></i><span>{{ $user->carts_count }}</span></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ $user->image }}" width="40" height="40" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    {{-- <a class="dropdown-item" href="#">Dashboard</a> --}}
                                    <a class="dropdown-item" href="{{ route('index.profile') }}">Profile</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="logout()">Log Out</a>
                                </div>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}"><i class="fa fa-sign-in"></i></a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->
