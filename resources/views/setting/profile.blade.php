@extends('layouts.template', ['title' => 'Setting Profile'])

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Default form</h4>
                    <form class="forms-sample" id="form" action="{{ route('setting.profile.update') }}" method="POST">
                        @csrf
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
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                value="{{ $data->email }}" readonly disabled>
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
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
