<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="{{ route('index') }}"><img src="{{ asset('frontend/img/logo.png') }}" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            @auth
                <li>
                    <a href="{{ route('cart.index') }}">
                        <i class="fa fa-shopping-bag"></i><span>{{ $user->carts_count }}</span></a>
                </li>
                <li>
                    <a href="{{ route('index.profile') }}">
                        <img src="{{ asset('images/dollar.png') }}" alt=""
                            width="18"><span>{{ $user->point }}</span>
                    </a>
                </li>
                <li>
                    <button class="btn" onclick="logout()"><i class="fa fa-sign-out"></i></button>
                </li>
            @endauth
        </ul>
        {{-- <div class="header__cart__price">item: <span>$150.00</span></div> --}}
    </div>
    <div class="humberger__menu__widget">
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
            <a href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="{{ route('index') }}">Home</a></li>
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
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->
