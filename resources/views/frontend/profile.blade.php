@extends('layouts.frontend_app')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #f7f7ff;
            margin-top: 20px;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid transparent;
            border-radius: .25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
        }

        .me-2 {
            margin-right: .5rem !important;
        }
    </style>
@endpush

@section('content')
    @php
        $keys = $user->available_keys;
    @endphp
    <div class="container mt-3">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ $user->image }}" alt="Admin" class="rounded-circle p-1 bg-primary"
                                    width="110">
                                <div class="mt-3">
                                    <h4>{{ $user->name }}</h4>
                                    <p class="text-secondary mb-2">{{ $user->email }}</p>
                                    <p class="text-muted font-size-sm">
                                        <img src="{{ asset('images/dollar.png') }}" alt="" width="20">
                                        <b>{{ $user->point }}</b>
                                    </p>
                                    <p class="text-muted font-size-sm">
                                        <b>{{ count($keys) }} <i class="fas fa-key"></i> </b>
                                    </p>
                                </div>
                            </div>
                            <hr class="my-4">
                            <a href="{{ route('index.chat') }}" class="btn btn-block btn-primary">Open Chat</a>
                            <a href="{{ route('index.topup') }}" class="btn btn-block btn-primary">Topup Point</a>
                            @if ($user->role == 'user')
                                <a href="{{ route('index.upgrade') }}" class="btn btn-block btn-primary">Upgrade to
                                    Mentor</a>
                            @endif
                            @if ($user->role == 'mentor')
                                <a href="{{ route('home') }}" class="btn btn-block btn-primary">Open Dashboard</a>
                            @endif
                            {{-- <hr class="my-4"> --}}
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center mb-3">My Keys</h5>
                            <div style="overflow-y: auto; max-height: 200px;">
                                <ul class="list-group list-group-flush">
                                    @forelse ($keys as $item)
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">{{ $item->value }}</h6>
                                        </li>
                                    @empty
                                        <div class="alert alert-danger" role="alert">
                                            No Available Keys
                                        </div>
                                    @endforelse
                                </ul>
                            </div>

                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('index.profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $user->name }}" required autofocus>
                                        @error('name')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $user->email }}" required disabled readonly>
                                        @error('email')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="tel" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ $user->phone }}" required>
                                        @error('phone')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select name="gender" class="form-control @error('gender') is-invalid @enderror"
                                            id="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ $user->gender === 'Female' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                        </select>
                                        @error('gender')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Date Of Birth </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="date" name="dob"
                                            class="form-control @error('dob') is-invalid @enderror"
                                            value="{{ $user->dob }}" required>
                                        @error('dob')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Image </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center mb-3">My Course</h5>
                            <div style="overflow-y: auto; max-height: 340px;">
                                @forelse ($user->courses as $item)
                                    <p class="d-flex justify-content-between">
                                        <span>{{ $item->course->name }}</span>
                                        <span><a href="{{ route('index.course.open', $item->course->slug) }}"
                                                class="btn btn-sm">Open</a>
                                            <a href="{{ route('index.course.detail', $item->course->slug) }}"
                                                class="btn btn-sm">Detail</a></span>
                                    </p>

                                    @php
                                        $value = $item->course->userProgres() ?? 0;
                                    @endphp
                                    <div class="progress mb-3" style="height: 15px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $value }}%" aria-valuenow="{{ $value }}"
                                            aria-valuemin="0" aria-valuemax="100">{{ $value }}%</div>
                                    </div>
                                @empty
                                    <div class="alert alert-danger" role="alert">
                                        Empty Course!
                                    </div>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
