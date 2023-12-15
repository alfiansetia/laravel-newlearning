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

                        @forelse ($item->courses as $c)
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="categories__item set-bg" data-setbg="{{ $c->image }}">
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            <a href="{{ route('index.course.detail', $c->slug) }}">{{ $c->name }}</a>
                                        </h5>
                                        <h5>
                                            <img src="{{ asset('images/dollar.png') }}" alt="" class="d-inline"
                                                style="max-width: 18px; max-height: 18px">
                                            <span class="d-inline">{{ $c->price }}</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-danger" role="alert">
                                Empty Course!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
        <!-- Categories Section End -->
    @endforeach
@endsection
