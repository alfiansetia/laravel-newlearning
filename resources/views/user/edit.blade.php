@extends('layouts.template')

@push('csslib')
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/select.dataTables.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Default form</h4>
                    <form class="forms-sample" id="form" action="{{ route('user.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Name" value="{{ $data->name }}" required autofocus>
                            @error('name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder="Email" value="{{ $data->email }}" required>
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" placeholder="Phone" value="{{ $data->phone }}" required>
                            @error('phone')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dob">Date OF Birth</label>
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                                id="dob" placeholder="Date OF Birth" value="{{ $data->dob ?? date('Y-m-d') }}"
                                required>
                            @error('dob')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                placeholder="Password" autocomplete="off">
                            @error('password')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror"
                                required>
                                <option value="">Select Role</option>
                                <option value="user" {{ $data->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="mentor" {{ $data->role == 'mentor' ? 'selected' : '' }}>mentor</option>
                                <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>admin</option>
                            </select>
                            @error('role')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select name="country" id="country"
                                class="form-control @error('country') is-invalid @enderror" required>
                                <option value="">Select Country</option>
                                <option value="user" {{ $data->country == 'Indonesia' ? 'selected' : '' }}>Indonesia
                                </option>
                            </select>
                            @error('country')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('jslib')
    <script src="{{ asset('backend/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('backend/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('backend/js/dataTables.select.min.js') }}"></script>
@endpush

@push('js')
@endpush
