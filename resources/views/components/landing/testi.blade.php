@if (count($comments) > 0)
    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="mb-5">Our Students Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                @foreach ($comments as $key => $item)
                    <div class="testimonial-item text-center">
                        <img class="border rounded-circle p-2 mx-auto mb-3"
                            src="{{ asset('landing/img/testimonial-' . $key + 1 . '.jpg') }}"
                            style="width: 80px; height: 80px;">
                        <h5 class="mb-0">{{ $item->user->name ?? 'xxx' }}</h5>
                        {{-- <p>Profession</p> --}}
                        <div class="testimonial-text bg-light text-center p-4">
                            <p class="mb-0">{{ $item->value }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Testimonial End -->
@endif
