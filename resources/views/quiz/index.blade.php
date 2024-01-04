@extends('layouts.template', ['title' => 'Quiz'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6">
                                <h4 class="card-title">Quiz
                                    <a href="{{ route('quiz.create') }}" class="btn btn-sm btn-info">Create</a>
                                </h4>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="course" id="course" class="form-control form-control-sm">
                                        <option value="">Filter Course</option>
                                        @foreach ($courses as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request('course') == $item->id ? 'selected' : '' }}>{{ $item->name }}
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
                                <th>Course</th>
                                <th>Question</th>
                                <th class="text-center">Option Count</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td>{{ $item->course->name ?? '' }}</td>
                                    <td>{{ $item->question }}</td>
                                    <td class="text-center">{{ $item->options_count }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                                id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="ti-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                <a class="dropdown-item" href="{{ route('quiz.edit', $item->id) }}">Edit</a>
                                                <button type="button"
                                                    onclick="deleteData('{{ route('quiz.destroy', $item->id) }}')"
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
@endsection

@push('jslib')
    <script src="{{ asset('backend/js/custom.js') }}"></script>
@endpush
