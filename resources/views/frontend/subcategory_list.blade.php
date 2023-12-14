@extends('layouts.frontend_app')


@section('content')
    <div class="container">
        <div class="row mb-1">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>{{ $data->name }}</h2>
                </div>
            </div>
        </div>

    </div>
    @foreach ($data->subcategories as $item)
        <!-- Categories Section Begin -->
        <section class="categories mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title float-left">
                            <h2>{{ $item->name }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="categories__slider owl-carousel">
                        @foreach ($item->courses as $c)
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="categories__item set-bg" data-setbg="{{ $c->image }}">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('index.course.detail', $c->slug) }}">{{ $c->name }}</a>
                                        </h5>
                                        {{-- <p class="card-text">Some quick example text to build on the card title and make up
                                            the bulk of the card's content.</p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- Categories Section End -->
    @endforeach
@endsection
