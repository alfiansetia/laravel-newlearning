@extends('layouts.template', ['title' => 'Course'])

@section('content')
    @php
        $user = auth()->user();
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6">
                                <h4 class="card-title">Course
                                    @if ($user->role == 'admin')
                                        <a href="{{ route('course.create') }}" class="btn btn-sm btn-info">Create</a>
                                    @endif
                                    <a href="{{ route('list.course.step.create') }}" class="btn btn-sm btn-info">Create
                                        Step</a>
                                </h4>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="subcat" id="subcat" class="form-control form-control-sm">
                                        <option value="">Filter Sub Category</option>
                                        @foreach ($subcategories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request('subcat') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="Search User" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover" style="width: 100%" id="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Sub Category</th>
                                <th>Image</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Content Count</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->subcategory->name }}</td>
                                    <td><img src="{{ $item->image }}" alt="" width="100"></td>
                                    <td class="text-center">
                                        <img src="{{ asset('images/dollar.png') }}" alt=""
                                            style="max-width: 20px;max-height: 20px;"> {{ $item->price }}
                                    </td>
                                    <td class="text-center">{{ $item->status }}</td>
                                    <td class="text-center">{{ $item->contents_count }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                                id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="ti-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                @if ($user->role == 'admin')
                                                    <a class="dropdown-item"
                                                        href="{{ route('course.edit', $item->id) }}">Edit</a>
                                                @endif
                                                <a class="dropdown-item"
                                                    href="{{ route('list.course.step.edit', $item->id) }}">Edit
                                                    Step</a>
                                                @if ($user->role == 'admin')
                                                    <button type="button"
                                                        onclick="deleteData('{{ route('course.destroy', $item->id) }}')"
                                                        class="dropdown-item">Delete</button>
                                                @endif
                                                @if ($user->role == 'admin')
                                                    @if ($item->status == 'pending')
                                                        <button type="button"
                                                            onclick="accData('{{ route('course.acc', $item->id) }}')"
                                                            class="dropdown-item">ACC</button>
                                                        <button type="button"
                                                            onclick="rejectData('{{ route('course.reject', $item->id) }}')"
                                                            class="dropdown-item">Reject</button>
                                                    @endif
                                                    @if ($item->status == 'reject')
                                                        <button type="button"
                                                            onclick="accData('{{ route('course.acc', $item->id) }}')"
                                                            class="dropdown-item">ACC</button>
                                                    @endif
                                                    @if ($item->status == 'publish')
                                                        <button type="button"
                                                            onclick="rejectData('{{ route('course.reject', $item->id) }}')"
                                                            class="dropdown-item">Reject</button>
                                                    @endif
                                                @endif
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

    <form action="" method="POST" id="form_acc">
        @csrf
    </form>

    <form action="" method="POST" id="form_reject">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('jslib')
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    <script>
        function accData(action) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Your data will be Acc!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="ti-thumb-up"></i> Yes!',
                confirmButtonAriaLabel: 'Thumbs up, Yes!',
                cancelButtonText: '<i class="ti-thumb-down"></i> No',
                cancelButtonAriaLabel: 'Thumbs down',
                customClass: 'animated tada',
                showClass: {
                    popup: 'animate__animated animate__tada'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_acc').attr('action', action)
                    $('#form_acc').submit()
                }
            })
        }

        function rejectData(action) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Your data will be Reject!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="ti-thumb-up"></i> Yes!',
                confirmButtonAriaLabel: 'Thumbs up, Yes!',
                cancelButtonText: '<i class="ti-thumb-down"></i> No',
                cancelButtonAriaLabel: 'Thumbs down',
                customClass: 'animated tada',
                showClass: {
                    popup: 'animate__animated animate__tada'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_reject').attr('action', action)
                    $('#form_reject').submit()
                }
            })
        }
    </script>
@endpush
