@extends('layouts.frontend_app')

@section('content')
    <div class="container mt-3">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($data->status == 'reject')
                                <div class="alert alert-danger" role="alert">
                                    Your Upgrade was Reject!
                                </div>
                            @endif
                            <h4 class="mb-2">Upgrade to Mentor</h4>
                            @if (!empty($data->date))
                                <h5 class="mb-2 pt-2 pb-2">Date : {{ $data->date }}</h5>
                                <h5 class="mb-2 pt-2 pb-2">Status : <span
                                        class="badge badge-{{ $data->status == 'acc' ? 'success' : ($data->status == 'pending' ? 'warning' : 'danger') }}">{{ $data->status }}</span>
                                </h5>
                            @endif
                            <form action="{{ route('index.upgrade.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Reason</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="10"
                                            required minlength="200" maxlength="1000">{{ old('reason', $data->reason) }}</textarea>
                                        @error('reason')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">CV </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="cv"
                                            class="form-control @error('cv') is-invalid @enderror" value="" required>
                                        @error('cv')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                        <a href="{{ route('upgrade.edit', $data->id) }}"
                                            class="btn btn-secondary px-4">Download CV</a>
                                        <a href="{{ route('index.profile') }}" class="btn btn-secondary px-4">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
