@extends('layouts.template', ['title' => 'Content'])

@section('content')
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('list.course.step.create') }}">Create Course</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="">Create Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('list.course.step.quiz', $course->id) }}">Create Quiz</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-lg-12 mt-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Content</h4>
                    <form class="forms-sample" id="form" action="{{ route('content.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" placeholder="Title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" id="file" name="file" class="file-upload-default" required>
                            <div class="input-group col-xs-12">
                                <input type="text"
                                    class="form-control file-upload-info @error('file') is-invalid @enderror" disabled
                                    placeholder="Upload File">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                            @error('file')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="detail" id="summernote">{{ old('detail') }}</textarea>
                            @error('detail')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('content.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Content</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($course->contents ?? [] as $key => $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                                    id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                    <a class="dropdown-item"
                                                        href="{{ route('content.edit', $item->id) }}">Edit</a>
                                                    <button type="button"
                                                        onclick="deleteData('{{ route('content.destroy', $item->id) }}')"
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
@endsection
@push('jslib')
    <script src="{{ asset('backend/js/file-upload.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endpush

@push('js')
    <script>
        $('#summernote').summernote({
            placeholder: 'Detail Content',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endpush
