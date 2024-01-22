@extends('layouts.auth')
@section('content')
    <h6 class="font-weight-light">Sign in to continue.</h6>
    <form class="pt-3" action="{{ route('password.confirm') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password"
                required>
            @error('password')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mt-3">
            <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">Confirm
                Password</button>
        </div>
        <div class="text-center mt-4 font-weight-light">
            Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
        </div>
    </form>
@endsection
