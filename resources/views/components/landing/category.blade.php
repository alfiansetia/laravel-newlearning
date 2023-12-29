@if (count($categories) > 0)
    <!-- Categories Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
                <h1 class="mb-5">Courses Categories</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        @foreach ($categories as $key => $item)
                            @if ($key < 1)
                                <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                                    <a class="position-relative d-block overflow-hidden" href="">
                                        <img class="img-fluid" src="{{ $item->image }}" alt="">
                                        <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                            style="margin: 1px;">
                                            <h5 class="m-0">{{ $item->name }}</h5>
                                            <small class="text-primary">{{ $item->total_courses }}
                                                Courses</small>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @if ($key > 0 && $key < 3)
                                <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                                    <a class="position-relative d-block overflow-hidden" href="">
                                        <img class="img-fluid" src="{{ asset('landing/img/cat-3.jpg') }}"
                                            alt="">
                                        <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                            style="margin: 1px;">
                                            <h5 class="m-0">{{ $item->name }}</h5>
                                            <small class="text-primary">{{ $item->total_courses }}
                                                Courses</small>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if (count($categories) > 3)
                    <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                        <a class="position-relative d-block h-100 overflow-hidden" href="">
                            <img class="img-fluid position-absolute w-100 h-100"
                                src="{{ asset('landing/img/cat-4.jpg') }}" alt="" style="object-fit: cover;">
                            <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                style="margin:  1px;">
                                <h5 class="m-0">{{ $categories[3]->name }}</h5>
                                <small class="text-primary">{{ $categories[3]->total_courses }}
                                    Courses</small>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Categories Start -->
@endif
