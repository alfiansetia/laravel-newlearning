@extends('layouts.template', ['title' => 'Setting Profile'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Company Setting</h4>
                    <form class="forms-sample" id="form" action="{{ route('setting.company.update') }}" method="POST"
                        enctype="multipart/form-data">
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
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                id="logo" placeholder="Logo">
                            <img src="{{ $data->logo }}" alt="" width="100">
                            @error('logo')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('home') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Slider <a href="{{ route('slider.create') }}"
                            class="btn btn-sm btn-primary">Create</a>
                    </h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Image</th>
                                <th class="text-center">Show</th>
                                <th class="text-center">Action</th>
                            </tr>
                        <tbody>
                            @foreach ($sliders as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td><img src="{{ $item->image }}" alt="" height="100"></td>
                                    <td class="text-center">{{ $item->show }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                                id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="ti-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                <a class="dropdown-item"
                                                    href="{{ route('slider.edit', $item->id) }}">Edit</a>
                                                <button type="button"
                                                    onclick="deleteData('{{ route('slider.destroy', $item->id) }}')"
                                                    class="dropdown-item">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="POST" id="form_delete">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('jslib')
    <script src="{{ asset('backend/js/custom.js') }}"></script>
@endpush
