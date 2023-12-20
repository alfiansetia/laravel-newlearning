@extends('layouts.template', ['title' => 'Content'])

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Content</h4>
                    <form class="forms-sample" id="form" action="{{ route('content.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select name="course" id="course" class="form-control @error('course') is-invalid @enderror"
                                required>
                                <option value="">Select Course</option>
                                @foreach ($courses as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $data->course_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" placeholder="Title" value="{{ $data->title }}" required autofocus>
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
                            <br>
                            <video width="200" height="200" controls>
                                <source src="{{ $data->file }}" type="video/mp4" id="file-video">
                                Your browser does not support the video tag.
                            </video>
                            @error('file')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="detail" id="summernote">{{ $data->detail }}</textarea>
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
