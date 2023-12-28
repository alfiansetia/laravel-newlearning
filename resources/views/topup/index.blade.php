@extends('layouts.template', ['title' => 'Topup'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-8">
                            <h4 class="card-title">Topup Point
                                <button type="button" class="btn btn-sm btn-info">Create</button>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="Search User" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Code</th>
                                    <th>Point</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->point ?? '-' }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-{{ $item->status == 'done' ? 'success' : ($item->status == 'pending' ? 'warning' : 'danger') }}">{{ $item->status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                                    id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                    <a class="dropdown-item"
                                                        href="{{ route('topup.edit', $item->id) }}">Edit</a>
                                                    <button type="button"
                                                        onclick="deleteData('{{ route('topup.destroy', $item->id) }}')"
                                                        class="dropdown-item">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        No Data!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center pb-5">
        {{ $data->links() }}
    </div>

    <form action="" method="POST" id="form_delete">
        @csrf
        @method('DELETE')
    </form>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Topup Point</h4>
                    <form class="forms-sample" id="form" action="{{ route('topup.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                id="amount" placeholder="Amount" value="{{ old('amount', 200) }}" min="200"
                                required autofocus>
                            @error('amount')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2" id="pay-button">Submit</button>
                        <a href="{{ route('user.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('jslib')
    <script src="{{ asset('backend/js/custom.js') }}"></script>
@endpush
