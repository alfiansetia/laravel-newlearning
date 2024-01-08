@extends('layouts.template', ['title' => 'Chat'])
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
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

@push('js')
    <script src="{{ asset('backend/vendors/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
        $('#to').select2({
            // dropdownParent: $('#createChat')
        })
    </script>
@endpush

@section('content')
    @php
        $usr = auth()->user();
    @endphp
    <main class="content">
        {{-- <div class="container p-0"> --}}

        <h1 class="h3 mb-3">Messages</h1>

        <div class="card">
            <div class="row g-0">
                <div class="col-12 col-lg-5 col-xl-3 border-right">

                    <div class="px-4 d-none d-md-block mt-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <button class="btn btn-block btn-primary" data-toggle="modal"
                                    data-target="#createChat">Create
                                    Chat</button>
                            </div>
                        </div>
                    </div>
                    <div style="overflow-y: auto; max-height: 500px;">
                        @forelse ($data as $item)
                            <a href="{{ route('chat.show', $item->id) }}"
                                class="list-group-item list-group-item-action border-0 mt-2 {{ !empty($detail) && $item->id == $detail->id ? 'bg-secondary' : '' }}">
                                <div class="badge bg-success float-right">{{ $item->messages_count }}</div>
                                <div class="d-flex align-items-start">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar5.png"
                                        class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                    <div class="flex-grow-1 ml-3">
                                        {{ $item->from_id == $usr->id ? $item->to->name : $item->from->name }}
                                        <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                                    </div>
                                </div>
                            </a>
                            <hr class="d-block d-lg-none mt-1 mb-0">
                        @empty
                            <div class="alert alert-danger mt-3" role="alert">
                                Empty Chat
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-xl-9">
                    @if ($detail)
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong>{{ $detail->from_id == $usr->id ? $detail->to->name : $detail->from->name }}</strong>
                                    <div class="text-muted small"><em>Typing...</em></div>
                                </div>
                                <div>
                                    <form action="{{ route('chat.destroy', $detail->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-lg mr-1 px-3">
                                            <i data-feather="trash"></i>
                                        </button>

                                        <button type="button" class="btn btn-light border btn-lg px-3">
                                            <i data-feather="more-horizontal"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="position-relative">
                            <div class="chat-messages p-4" style="overflow-y: auto; max-height: 500px;">
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
                                    <div class="alert alert-danger mt-3" role="alert">
                                        Empty Message
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="flex-grow-0 py-3 px-4 border-top">
                            <form action="{{ route('chat.update', $detail->id) }}" method="POST">
                                @csrf
                                @method('PUT')
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
        {{-- </div> --}}
    </main>

    <div class="modal fade" id="createChat" tabindex="-1" aria-labelledby="createChatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createChatModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('chat.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="to">To </label>
                            <select name="to" id="to" class="js-example-basic-single w-100" required
                                style="width: 100%">
                                <option value="">Select User</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message </label>
                            <textarea name="message" id="message" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
