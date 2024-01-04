@extends('layouts.frontend_app')

@section('content')
    @php
        $average_rating = $data->averageRating();
        $user_review = $data->userComment();
    @endphp
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="{{ $data->image }}" alt=""
                                style="max-height: 400px;max-width: 400px;">
                        </div>
                        {{-- <div class="product__details__pic__slider owl-carousel">
                            <img data-imgbigurl="{{ asset('frontend/img/product/details/product-details-2.jpg') }}"
                                src="{{ asset('frontend/img/product/details/thumb-1.jpg') }}" alt="">
                            <img data-imgbigurl="{{ asset('frontend/img/product/details/product-details-3.jpg') }}"
                                src="{{ asset('frontend/img/product/details/thumb-2.jpg') }}" alt="">
                            <img data-imgbigurl="{{ asset('frontend/img/product/details/product-details-5.jpg') }}"
                                src="{{ asset('frontend/img/product/details/thumb-3.jpg') }}" alt="">
                            <img data-imgbigurl="{{ asset('frontend/img/product/details/product-details-4.jpg') }}"
                                src="{{ asset('frontend/img/product/details/thumb-4.jpg') }}" alt="">
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{ $data->name }} </h3>
                        <div class="product__details__rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $average_rating)
                                    <i class="fa fa-star"></i>
                                @elseif ($i - 0.5 <= $average_rating)
                                    <i class="fa fa-star-half-o"></i>
                                @else
                                    <i class="fa fa-star-o"></i>
                                @endif
                            @endfor
                            <span>({{ $data->comments_count }} Reviews)</span>
                        </div>
                        <div class="product__details__price"><img src="{{ asset('images/dollar.png') }}" alt=""
                                class="d-inline" style="max-width: 30px; max-height: 30px">
                            <span class="d-inline">{{ $data->price }}</span>
                        </div>
                        <p>{!! $data->subtitle !!}</p>
                        {{-- <div class="product__details__quantity mb-3">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="" placeholder="KEY">
                                </div>
                            </div>
                        </div> --}}
                        @if ($data->isPurchasedByUser())
                            <a href="{{ route('index.course.open', $data->slug) }}" class="primary-btn">OPEN COURSE</a>
                            @if (!$user_review)
                                <button type="button" class="btn primary-btn" data-toggle="modal"
                                    data-target="#reviewModal">REVIEW</button>
                            @endif
                        @else
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course" value="{{ $data->id }}">
                                <button class="btn primary-btn">ADD TO CARD</button>
                                @auth
                                    <button type="button" class="btn primary-btn" data-toggle="modal"
                                        data-target="#exampleModal">REDEEM</button>
                                @endauth
                            </form>
                        @endif
                        {{-- <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a> --}}
                        <ul>
                            {{-- <li><b>Availability</b> <span>In Stock</span></li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            <li><b>Weight</b> <span>0.5 kg</span></li> --}}
                            {{-- <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Reviews <span>({{ $data->comments_count }})</span></a>
                            </li>
                            @if ($user_review)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                        aria-selected="false">Your Review</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active mt-3" id="tabs-1" role="tabpanel">
                                @forelse ($data->comments as $item)
                                    <div class="product__details__tab__desc">
                                        <h6>{{ $item->user->name ?? '-' }}</h6>
                                        <p>{{ $item->value }} </p>
                                    </div>
                                @empty
                                    <div class="alert alert-danger" role="alert">
                                        Empty Comment
                                    </div>
                                @endforelse
                            </div>
                            @if ($user_review)
                                <div class="tab-pane" id="tabs-2" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>{{ $user_review->user->name }}</h6>
                                        <p>{{ $user_review->value }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
    <form action="{{ route('index.save.transaction.key', $data->id) }}" method="POST">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Redeem <b>{{ $data->name }}</b> With KEY</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <select name="key" id="key" class="form-control form-control-lg" required>
                            <option value="">Select Key</option>
                            @foreach ($user->available_keys ?? [] as $item)
                                <option value="{{ $item->id }}">{{ $item->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn primary-btn">Redeem Now</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('index.save.review', $data->id) }}" method="POST">
        @csrf
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Rate and Comment <b>{{ $data->name }}</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="rate" id="rate" class="form-control form-control-lg" required>
                                <option value="">Select Rates</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea name="comment" id="comment" class="form-control" required>{{ old('comment') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn primary-btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
