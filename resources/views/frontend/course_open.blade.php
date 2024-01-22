@extends('layouts.frontend_app')
@push('css')
    <style>
        body {
            background: url("{{ asset('/images/bg.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .header {
            background-color: aliceblue;
        }
    </style>
@endpush

@section('content')
    @php
        $contents = $data->contents ?? [];
        $empty_contents = count($contents) < 1;
        $quizzes = $data->quizzes ?? [];
        $score = $data->userScore();
        $progres = $data->userProgres();
    @endphp
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 mb-3" style="background-color: aliceblue">
                    <div class="tab-content mb-3 mt-2" id="nav-tabContent">
                        @foreach ($contents ?? [] as $key => $item)
                            <div class="tab-pane {{ $key === 0 ? 'fade show active' : '' }}" id="list-home{{ $item->id }}"
                                role="tabpanel" aria-labelledby="list-video{{ $item->id }}">
                                <video height="400" controls style="width: 100%;">
                                    <source src="{{ $item->file }}" type="video/mp4"
                                        id="{{ 'vid' . $item->id . $loop->iteration }}">
                                    Your browser does not support the video tag.
                                </video>
                                <br>
                                @if (!$data->isContentDoneUser($item->id))
                                    <form action="{{ route('index.save.progres') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="content">
                                        <input type="hidden" name="content" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-sm primary-btn">Set Done</button>
                                    </form>
                                @else
                                    <div class="alert alert-success" role="alert">
                                        You have completed this session!
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <div class="tab-pane fade {{ $empty_contents ? 'fade show active' : '' }}" id="list-profile"
                            role="tabpanel" aria-labelledby="list-profile-list">
                            <br>
                            <center>
                                <img src="{{ $data->image_materi }}" alt="">
                            </center>
                            <br>
                            <h3 class="pt-2 mb-2">{!! $data->header_materi !!}</h3>
                            <p style="background-color: aliceblue">{!! $data->detail_materi !!}
                                <br>
                            </p>
                            @if (!$data->isCourseDoneUser($data->id))
                                <form action="{{ route('index.save.progres') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="course">
                                    <input type="hidden" name="course" value="{{ $data->id }}">
                                    <button type="submit" class="btn btn-sm primary-btn">Set Done</button>
                                </form>
                            @else
                                <div class="alert alert-success" role="alert">
                                    You have completed this session!
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                            <div class="alert alert-{{ $score > 50 ? 'success' : 'danger' }}" role="alert">
                                Your Score <b>{{ $score }}</b>
                            </div>
                            <form action="{{ route('index.save.answer', $data->id) }}" method="POST">
                                @csrf
                                <div id="accordion">
                                    @foreach ($quizzes as $key => $item)
                                        <div class="card">
                                            <div class="card-header" id="headingOne{{ $item->id }}">
                                                <h5 class="mb-0">
                                                    <button type="button" class="btn btn-link" style="text-align: left"
                                                        data-toggle="collapse"
                                                        data-target="#collapseOne{{ $item->id }}"
                                                        aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                                        aria-controls="collapseOne{{ $item->id }}">
                                                        {{ $key + 1 }}. {!! $item->question !!}
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseOne{{ $item->id }}"
                                                class="collapse {{ $key === 0 ? 'show' : '' }}"
                                                aria-labelledby="headingOne{{ $item->id }}" data-parent="#accordion">
                                                <div class="card-body">
                                                    {{-- {{ $item->question }}
                                                    <br> --}}

                                                    @php
                                                        $old = $item->options ?? [];
                                                        $options = $old->shuffle();
                                                    @endphp
                                                    @foreach ($options as $option)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="answer[{{ $item->id }}]"
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
                                @if ($score < 100)
                                    <button class="btn primary-btn mt-3 mb-2">SAVE ANSWER</button>
                                @endif
                            </form>
                            @if (!$data->isQuizDoneUser($data->id))
                                @if ($score >= 100)
                                    <form action="{{ route('index.save.progres') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="quiz">
                                        <input type="hidden" name="quiz" value="{{ $data->id }}">
                                        <button type="submit" class="btn btn-sm primary-btn">Set Done</button>
                                    </form>
                                @endif
                            @else
                                <div class="alert alert-success" role="alert">
                                    You have completed this session!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h4 class="mb-2">{{ $data->name }}</h4>
                    <div class="list-group" id="list-tab" role="tablist">
                        @foreach ($contents ?? [] as $key => $item)
                            <a class="list-group-item list-group-item-action {{ $key === 0 ? 'active' : '' }}"
                                id="list-video{{ $item->id }}" data-toggle="list"
                                href="#list-home{{ $item->id }}" role="tab" aria-controls="home">Video
                                {{ $key + 1 }} {{ $item->title }}
                            </a>
                        @endforeach
                        <a class="list-group-item list-group-item-action {{ $empty_contents ? 'active' : '' }}"
                            id="list-profile-list" data-toggle="list" href="#list-profile" role="tab"
                            aria-controls="profile">Materi</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                            href="#list-messages" role="tab" aria-controls="messages">Quest
                            ({{ $data->quizzes_count }})</a>
                    </div>
                    <div class="progress mt-4" style="height: 30px;">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                            style="width: {{ $progres }}%" aria-valuenow="{{ $progres }}" aria-valuemin="0"
                            aria-valuemax="100">{{ $progres }}%</div>
                    </div>
                    {{-- <p class="mt-3" style="background-color: aliceblue">{!! $data->subtitle !!}</p> --}}
                </div>
            </div>

        </div>
    </section>
    <!-- Product Details Section End -->
@endsection
