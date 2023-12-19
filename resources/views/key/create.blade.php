@extends('layouts.template', ['title' => 'Key'])

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Key</h4>
                    <form class="forms-sample" id="form" action="{{ route('key.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user">User</label>
                            <select name="user" id="user" class="form-control @error('user') is-invalid @enderror"
                                required>
                                <option value="">Select user</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}" {{ old('user') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} - {{ $item->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror"
                                id="qty" placeholder="Qty Key" value="{{ old('qty', 0) }}" required autofocus>
                            @error('qty')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('key.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
