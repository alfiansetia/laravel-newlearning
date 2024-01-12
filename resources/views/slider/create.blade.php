@extends('layouts.template', ['title' => 'Slider'])

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Slider</h4>
                    <form class="forms-sample" id="form" action="{{ route('slider.store') }}" method="POST"
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
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text"
                                    class="form-control file-upload-info @error('image') is-invalid @enderror" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                            @error('image')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="subtitle" id="summernote">{{ old('subtitle') }}</textarea>
                            @error('subtitle')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="show">Show</label>
                            <select name="show" id="show" class="form-control @error('show') is-invalid @enderror"
                                required>
                                <option {{ old('show') == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                                <option {{ old('show') == 'no' ? 'selected' : '' }} value="no">No</option>
                            </select>
                            @error('link')
                                <div show="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" name="link" class="form-control @error('link') is-invalid @enderror"
                                id="link" placeholder="Link" value="{{ old('link') }}">
                            @error('link')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('slider.index') }}" class="btn btn-light">Cancel</a>
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
            placeholder: 'Subtitle',
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
