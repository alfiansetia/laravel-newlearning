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

    @forelse ($data->subcategories as $item)
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

                        @forelse ($item->courses as $c)
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="categories__item set-bg" data-setbg="{{ $c->image }}">
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="card-title">
                                            <a href="{{ route('index.course.detail', $c->slug) }}">
                                                <b>
                                                    <font color="grey">{{ $c->name }}</font>
                                                </b>
                                            </a>
                                        </h6>
                                        @if (!$c->isPurchasedByUser())
                                            <h6>
                                                <img src="{{ asset('images/dollar.png') }}" alt="" class="d-inline"
                                                    style="max-width: 18px; max-height: 18px">
                                                <span class="d-inline"><strong>{{ $c->price }}</strong></span>
                                            </h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-3">
                                <div class="alert alert-danger" role="alert">
                                    Empty Course!
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
        <!-- Categories Section End -->
    @empty
        <div class="container">
            <div class="alert alert-danger" role="alert">
                Empty Course!
            </div>
        </div>
    @endforelse
@endsection
