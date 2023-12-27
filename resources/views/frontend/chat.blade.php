@extends('layouts.frontend_app')
@push('css')
    <style>
        body {
            margin-top: 20px;
        }

        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            max-height: 800px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="container p-0">

            <h1 class="h3 mb-3">Messages</h1>

            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-right">

                        <div class="px-4 d-none d-md-block mt-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <button class="btn btn-block btn-primary">Create Chat</button>
                                </div>
                            </div>
                        </div>
                        @forelse ($data as $item)
                            <a href="{{ route('index.chat.detail', $item->id) }}"
                                class="list-group-item list-group-item-action border-0">
                                <div class="badge bg-success float-right">{{ $item->messages_count }}</div>
                                <div class="d-flex align-items-start">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar5.png"
                                        class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                    <div class="flex-grow-1 ml-3">
                                        {{ $item->from->name ?? $item->to->name }}
                                        <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                                    </div>
                                </div>
                            </a>
                            <hr class="d-block d-lg-none mt-1 mb-0">
                        @empty
                        @endforelse
                    </div>
                    <div class="col-12 col-lg-7 col-xl-9">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                {{-- <div class="position-relative">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong>Sharon Lessman</strong>
                                    <div class="text-muted small"><em>Typing...</em></div>
                                </div> --}}
                                {{-- <div>
                                    <button class="btn btn-primary btn-lg mr-1 px-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-phone feather-lg">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                            </path>
                                        </svg></button>
                                    <button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-video feather-lg">
                                            <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2">
                                            </rect>
                                        </svg></button>
                                    <button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-more-horizontal feather-lg">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg></button>
                                </div> --}}
                            </div>
                        </div>
                        @if ($detail)
                            <div class="position-relative">
                                <div class="chat-messages p-4">
                                    @forelse ($detail->messages ?? [] as $item)
                                        @if ($item->sender_id == auth()->user()->id)
                                            <div class="chat-message-right pb-4">
                                                <div>
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                        class="rounded-circle mr-1" alt="Chris Wood" width="40"
                                                        height="40">
                                                    <div class="text-muted small text-nowrap mt-2">{{ $item->date }}</div>
                                                </div>
                                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                    <div class="font-weight-bold mb-1">You</div>
                                                    {{ $item->message }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="chat-message-left pb-4">
                                                <div>
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40"
                                                        height="40">
                                                    <div class="text-muted small text-nowrap mt-2">{{ $item->date }}</div>
                                                </div>
                                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                                    <div class="font-weight-bold mb-1">{{ $item->sender->name }}</div>
                                                    {{ $item->message }}
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="flex-grow-0 py-3 px-4 border-top">
                                <form action="{{ route('index.chat.save', $detail->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="message" class="form-control"
                                            placeholder="Type your message" required autofocus>
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection