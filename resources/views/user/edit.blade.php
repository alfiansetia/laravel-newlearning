@extends('layouts.template', ['title' => 'User'])

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit User</h4>
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
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror"
                                required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ $data->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $data->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dob">Date OF Birth</label>
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                                id="dob" placeholder="Date OF Birth" value="{{ $data->dob }}" required>
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
                        <div class="form-group row">
                            <div class="col">
                                <label for="status">Status</label>
                                <select class="form-control @error('country') is-invalid @enderror" name="status"
                                    id="status" required>
                                    <option value="active" {{ $data->status == 'active' ? 'selected' : '' }}>active
                                    </option>
                                    <option value="nonactive" {{ $data->status == 'nonactive' ? 'selected' : '' }}>
                                        nonactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="verify">Verified</label>
                                <select class="form-control @error('country') is-invalid @enderror" name="verify"
                                    id="verify" required>
                                    <option value="no">no </option>
                                    <option value="yes" {{ !empty($data->email_verified_at) ? 'selected' : '' }}>yes
                                    </option>
                                </select>
                                @error('verify')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('user.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
