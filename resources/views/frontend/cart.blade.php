@extends('layouts.frontend_app')

@section('content')
    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        @if (count($carts) < 1)
                            <div class="alert alert-danger" role="alert">
                                Empty Cart!
                            </div>
                        @endif
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Course</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $item)
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <img src="{{ $item->course->image }}" alt="{{ $item->course->name }}"
                                                width="100">
                                            <h5>{{ $item->course->name }}</h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            <img src="{{ asset('images/dollar.png') }}" alt="" width="20">
                                            {{ $item->course->price }}
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn"><span class="icon_close"></span></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{ route('index') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="{{ route('cart.index') }}" class="primary-btn cart-btn cart-btn-right"><span
                                class="icon_loading"></span>
                            Update Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    {{-- <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div> --}}
                </div>
                @php
                    $total = 0;
                    foreach ($carts as $item) {
                        $total += $item->course->price;
                    }
                    $enough = $total < auth()->user()->point;
                    $empty = count($carts) < 1;
                @endphp
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        @if (!$enough)
                            <div class="alert alert-danger" role="alert">
                                Not Enough Point!
                            </div>
                        @endif
                        @if ($empty)
                            <div class="alert alert-danger" role="alert">
                                Empty Cart
                            </div>
                        @endif
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Total <span>
                                    <img src="{{ asset('images/dollar.png') }}" alt=""
                                        width="20">{{ $total }}
                                </span>
                            </li>
                        </ul>
                        <form action="{{ route('index.save.transaction') }}" method="POST">
                            @csrf
                            <button {{ !$enough || $empty ? 'disabled' : '' }} type="submit"
                                class="btn primary-btn">PROCEED TO
                                CHECKOUT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
