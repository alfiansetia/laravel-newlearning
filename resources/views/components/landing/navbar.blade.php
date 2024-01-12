 <!-- Navbar Start -->
 <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
     <a href="{{ route('index') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
         <h2 class="m-0 text-primary">
             {{-- <i class="fa fa-book me-3"></i> --}}
             <img src="{{ $company->logo }}" alt="" height="40" width="40">
             <font color="black">{{ $company->name }}</font>
         </h2>
     </a>
     <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
         <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="navbarCollapse">
         <div class="navbar-nav ms-auto p-4 p-lg-0">
             {{-- <a href="{{ route('index') }}" class="nav-item nav-link {{ $title == 'Home' ? 'active' : '' }}">Home</a>
             <a href="{{ route('index.landing.about') }}"
                 class="nav-item nav-link {{ $title == 'About' ? 'active' : '' }}">About</a>
             <a href="{{ route('index.landing.course') }}"
                 class="nav-item nav-link {{ $title == 'Courses' ? 'active' : '' }}">Courses</a>
             <div class="nav-item dropdown">
                 <a href="#"
                     class="nav-link dropdown-toggle {{ $title == 'Team' || $title == 'Testi' ? 'active' : '' }}"
                     data-bs-toggle="dropdown">Pages</a>
                 <div class="dropdown-menu fade-down m-0">
                     <a href="{{ route('index.landing.team') }}"
                         class="dropdown-item {{ $title == 'Team' ? 'active' : '' }}">Our Team</a>
                     <a href="{{ route('index.landing.testi') }}"
                         class="dropdown-item {{ $title == 'Testi' ? 'active' : '' }}">Testimonial</a>
                     <a href="404.html" class="dropdown-item">404 Page</a>
                 </div>
             </div>
             <a href="{{ route('index.landing.contact') }}"
                 class="nav-item nav-link {{ $title == 'Contact' ? 'active' : '' }}">Contact</a> --}}
         </div>
         @auth
             <a href="{{ route('index.profile') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Profile<i
                     class="fa fa-arrow-right ms-3"></i></a>
         @else
             <a href="{{ route('login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i
                     class="fa fa-arrow-right ms-3"></i></a>
         @endauth
     </div>
 </nav>
 <!-- Navbar End -->
