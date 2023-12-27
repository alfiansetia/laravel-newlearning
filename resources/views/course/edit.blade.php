@extends('layouts.template', ['title' => 'Course'])

@section('content')
    <form class="forms-sample" id="form" action="{{ route('course.update', $data->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Course</h4>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Name" value="{{ $data->name }}" required autofocus>
                            @error('name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subcategory">Sub Category</label>
                            <select class="form-control @error('subcategory') is-invalid @enderror" name="subcategory"
                                id="subcategory" required>
                                <option value="">Select Sub Category</option>
                                @foreach ($subcategories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $data->subcategory_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mentor">Mentor</label>
                            <select class="form-control @error('mentor') is-invalid @enderror" name="mentor" id="mentor"
                                required>
                                <option value="">Select Mentor</option>
                                @foreach ($mentors as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $data->mentor_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mentor')
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
                            @if (!empty($data->getRawOriginal('image')))
                                <img src="{{ $data->image }}" alt="{{ $data->name }}" width="200" class="mt-2">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                id="price" placeholder="Price" value="{{ $data->price ?? 0 }}" min="1" required>
                            @error('price')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <textarea name="subtitle" id="subtitle">{{ $data->subtitle }}</textarea>
                            @error('subtitle')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('course.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Materi Of Course</h4>
                        <div class="form-group">
                            <label for="header">Header</label>
                            <input type="text" name="header" class="form-control @error('header') is-invalid @enderror"
                                id="header" placeholder="header" value="{{ $data->header_materi }}" required autofocus>
                            @error('header')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image_materi">Image</label>
                            <input type="file" id="image_materi" name="image_materi" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text"
                                    class="form-control file-upload-info @error('image_materi') is-invalid @enderror"
                                    disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                            @error('image_materi')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                            @if (!empty($data->getRawOriginal('image_materi')))
                                <img src="{{ $data->image_materi }}" alt="{{ $data->name }}" width="200"
                                    class="mt-2">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="detail">Detail Materi</label>
                            <textarea name="detail" id="detail">{{ $data->detail_materi }}</textarea>
                            @error('detail')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('jslib')
    <script src="{{ asset('backend/js/file-upload.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endpush

@push('js')
    <script>
        var toolbar = [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ol', 'ul', 'paragraph', 'height']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
        ];

        $('#detail').summernote({
            placeholder: 'Detail Materi',
            tabsize: 2,
            height: 200,
            toolbar: toolbar
        });
        $('#subtitle').summernote({
            placeholder: 'Subtitle Course',
            tabsize: 2,
            height: 200,
            toolbar: toolbar
        });
    </script>
@endpush
