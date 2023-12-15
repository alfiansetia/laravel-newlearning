@extends('layouts.frontend_app')

@section('content')
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                            <img class="product__details__pic__item--large" src="{{ $data->image }}" alt=""
                                style="max-height: 400px; width: 100%">
                        </div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                            {!! $data->desc !!} Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eum dicta
                            accusantium ipsa. Fugit, nam quia ab tenetur quasi, libero impedit sequi incidunt vero optio
                            iure dolorum quis, voluptas atque beatae!
                        </div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                            Quest
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <h4 class="mb-2">{{ $data->name }}</h4>
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list"
                            href="#list-home" role="tab" aria-controls="home">Video ({{ $data->contents_count }})
                        </a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                            href="#list-profile" role="tab" aria-controls="profile">Materi</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                            href="#list-messages" role="tab" aria-controls="messages">Quest
                            ({{ $data->quizzes_count }})</a>
                    </div>
                    @php
                        $value = $data->progres->value ?? 0;
                    @endphp
                    <div class="progress mt-4" style="height: 30px;">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                            style="width: {{ $value }}%" aria-valuenow="{{ $value }}" aria-valuemin="0"
                            aria-valuemax="100">{{ $value }}%</div>
                    </div>
                    <p class="mt-3">{{ $data->subtitle }}</p>
                </div>
            </div>

        </div>
    </section>
    <!-- Product Details Section End -->
@endsection
