@extends('layouts.auth')
@section('content')
    <h4>New here?</h4>
    <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
    <form class="pt-3" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                id="name" placeholder="Name" value="{{ old('name') }}" required>
            @error('name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                id="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="tel" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                id="phone" placeholder="Phone" value="{{ old('phone') }}" required>
            @error('phone')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <select name="country" class="form-control form-control-lg @error('country') is-invalid @enderror"
                id="country" required>
                <option value="">Select Country</option>
                <option value="Indonesia" {{ old('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                <option value="Argentina" {{ old('country') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
            </select>
            @error('country')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password"
                class="form-control form-control-lg @error('password') is-invalid @enderror" id="password"
                placeholder="Password" required>
            @error('password')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password_confirmation"
                class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                id="password_confirmation" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}"
                required>
            @error('password_confirmation')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <div class="form-check">
                <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input" required>
                    I agree to all Terms & Conditions
                </label>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                UP</button>
        </div>
        <div class="text-center mt-4 font-weight-light">
            Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
        </div>
    </form>
@endsection
