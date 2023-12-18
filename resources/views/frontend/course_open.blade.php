@extends('layouts.frontend_app')

@section('content')
    @php
        $contents = $data->contents ?? [];
        $empty_contents = count($contents) < 1;
        $quizzes = $data->quizzes ?? [];
    @endphp
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($contents ?? [] as $key => $item)
                            <div class="tab-pane {{ $key === 0 ? 'fade show active' : '' }}" id="list-home{{ $item->id }}"
                                role="tabpanel" aria-labelledby="list-video{{ $item->id }}">
                                <video width="400" height="400" controls>
                                    <source src="{{ asset('videos/content/') }}/{{ $item->file }}" type="video/mp4"
                                        id="{{ 'vid' . $item->id . $loop->iteration }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endforeach

                        <div class="tab-pane fade {{ $empty_contents ? 'fade show active' : '' }}" id="list-profile"
                            role="tabpanel" aria-labelledby="list-profile-list">
                            <br>
                            <img src="{{ $data->image_materi }}" alt="">
                            <br>
                            <h3 class="pt-2">{!! $data->header_materi !!}</h3>
                            {!! $data->materi_detail !!}
                            <br>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eum dicta
                            accusantium ipsa. Fugit, nam quia ab tenetur quasi, libero impedit sequi incidunt vero optio
                            iure dolorum quis, voluptas atque beatae!
                        </div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                            <div id="accordion">
                                @foreach ($quizzes as $key => $item)
                                    <div class="card">
                                        <div class="card-header" id="headingOne{{ $item->id }}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                    data-target="#collapseOne{{ $item->id }}"
                                                    aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                                    aria-controls="collapseOne{{ $item->id }}">
                                                    {{ $key + 1 }}. {{ $item->title }}
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne{{ $item->id }}"
                                            class="collapse {{ $key === 0 ? 'show' : '' }}"
                                            aria-labelledby="headingOne{{ $item->id }}" data-parent="#accordion">
                                            <div class="card-body">
                                                {{ $item->question }}
                                                @php
                                                    $options = $item->options ?? [];
                                                @endphp
                                                <br>
                                                @foreach ($options as $option)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="{{ $item->id }}"
                                                            id="exampleRadios{{ $option->id }}"
                                                            value="{{ $option->id }}">
                                                        <label class="form-check-label"
                                                            for="exampleRadios{{ $option->id }}">
                                                            {{ $option->value }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="btn primary-btn mt-3">SAVE ANSWER</button>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <h4 class="mb-2">{{ $data->name }}</h4>
                    <div class="list-group" id="list-tab" role="tablist">
                        @foreach ($contents ?? [] as $key => $item)
                            <a class="list-group-item list-group-item-action {{ $key === 0 ? 'active' : '' }}"
                                id="list-video{{ $item->id }}" data-toggle="list" href="#list-home{{ $item->id }}"
                                role="tab" aria-controls="home">Video {{ $key + 1 }} {{ $item->title }}
                            </a>
                        @endforeach
                        <a class="list-group-item list-group-item-action {{ $empty_contents ? 'active' : '' }}"
                            id="list-profile-list" data-toggle="list" href="#list-profile" role="tab"
                            aria-controls="profile">Materi</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                            href="#list-messages" role="tab" aria-controls="messages">Quest
                            ({{ $data->quizzes_count }})</a>
                    </div>
                    @php
                        $value = $data->progres->value ?? 0;
                    @endphp
                    <div class="progress mt-4" style="height: 30px;">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                            style="width: {{ $value + 10 }}%" aria-valuenow="{{ $value + 10 }}" aria-valuemin="0"
                            aria-valuemax="100">{{ $value + 10 }}%</div>
                    </div>
                    <p class="mt-3">{{ $data->subtitle }}</p>
                </div>
            </div>

        </div>
    </section>
    <!-- Product Details Section End -->
@endsection
