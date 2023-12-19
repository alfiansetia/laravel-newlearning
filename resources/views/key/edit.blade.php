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
                            <label for="user">User</label>
                            <select name="user" id="user" class="form-control @error('user') is-invalid @enderror"
                                required>
                                <option value="">Select user</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}" {{ $data->user_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} - {{ $item->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="value">Value</label>
                            <input type="text" name="value" class="form-control @error('value') is-invalid @enderror"
                                id="value" placeholder="Value" value="{{ $data->value }}" required readonly disabled>
                            @error('value')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="">Select Status</option>
                                <option value="available" {{ $data->status == 'available' ? 'selected' : '' }}>Available
                                </option>
                                <option value="unavailable" {{ $data->status == 'unavailable' ? 'selected' : '' }}>
                                    Unavailable</option>
                            </select>
                            @error('status')
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
