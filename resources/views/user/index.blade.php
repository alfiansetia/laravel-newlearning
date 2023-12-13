@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-8">
                            <h4 class="card-title">Hoverable Table</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search User"
                                            value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="text-center">Verify</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone ?? '-' }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-success">{{ !empty($item->email_verified_at) ? 'Verified' : 'Unverified' }}</span>
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
                                                        href="{{ route('user.edit', $item->id) }}">Edit</a>
                                                    <button type="button" class="dropdown-item">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
@endsection
