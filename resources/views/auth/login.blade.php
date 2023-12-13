@extends('layouts.auth')
@section('content')
    <h4>Hello! let's get started</h4>
    <h6 class="font-weight-light">Sign in to continue.</h6>
    <form class="pt-3" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                id="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-lg" id="password"
                placeholder="Password" required>
        </div>
        <div class="mt-3">
            <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">SIGN
                IN</button>
        </div>
        <div class="my-2 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <label class="form-check-label text-muted">
                    <input type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                    Keep me signed in
                </label>
            </div>
            {{-- <a href="#" class="auth-link text-black">Forgot password?</a> --}}
        </div>
        <div class="mb-2">
            <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                <i class="ti-facebook mr-2"></i>Connect using facebook
            </button>
        </div>
        <div class="text-center mt-4 font-weight-light">
            Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
        </div>
    </form>
@endsection
