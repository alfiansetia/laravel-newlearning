@if (count($categories) > 0)
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            @foreach ($sliders as $item)
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="{{ $item->image }}" alt="" style="max-height: 768px">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                        style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    {{-- <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online
                                    Courses
                                </h5> --}}
                                    <h1 class="display-3 text-white animated slideInDown">{{ $item->title }} </h1>
                                    @if (!empty($item->subtitle))
                                        <p class="fs-5 text-white mb-4 pb-2">{!! $item->subtitle !!}</p>
                                    @endif
                                    @if (!empty($item->link))
                                        <a href="{{ $item->link }}"
                                            class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read
                                            More</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Carousel End -->
@endif
