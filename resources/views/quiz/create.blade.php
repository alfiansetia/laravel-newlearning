@extends('layouts.template', ['title' => 'Quiz'])

@section('content')
    <form class="forms-sample" id="form" action="{{ route('quiz.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Quiz</h4>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select class="form-control @error('course') is-invalid @enderror" name="course" id="course"
                                required>
                                <option value="">Select Course</option>
                                @foreach ($courses as $item)
                                    <option value="{{ $item->id }}" {{ old('course') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" placeholder="Title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" id="question" placeholder="Question" required>{{ old('question') }}</textarea>
                            @error('question')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('quiz.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Options Of Quiz</h4>
                        <div id="options-container">
                            <!-- Container untuk input dinamis -->
                            <div class="form-group option">
                                <div>
                                    <label for="value">Value</label>
                                    <input type="text" name="value[0]" class="form-control" placeholder="Value" required>
                                </div>
                                <div class="answers-group">
                                    <label>Is Answer</label><br>
                                    <label>
                                        <input type="radio" name="answer[0]" value="yes"> Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="answer[0]" value="no" checked> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-3" id="addOption">Add Option</button>
                        <button type="button" class="btn btn-danger mt-3" id="resetOptions">Reset Options</button>
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
        let optionIndex = 1;

        document.getElementById('addOption').addEventListener('click', function() {
            let optionsContainer = document.getElementById('options-container');
            let newOption = document.createElement('div');
            newOption.classList.add('form-group', 'option');
            newOption.innerHTML = `
                <div>
                    <label for="value">Value</label>
                    <input type="text" name="value[${optionIndex}]" class="form-control" placeholder="Value" required>
                </div>
                <div class="answers-group">
                    <label>Is Answer</label><br>
                    <label>
                        <input type="radio" name="answer[${optionIndex}]" value="yes"> Yes
                    </label>
                    <label>
                        <input type="radio" name="answer[${optionIndex}]" value="no" checked> No
                    </label>
                </div>
            `;
            optionsContainer.appendChild(newOption);
            optionIndex++;
        });

        document.getElementById('resetOptions').addEventListener('click', function() {
            var optionsContainer = document.getElementById('options-container');
            var options = optionsContainer.getElementsByClassName('option');
            while (options.length > 1) {
                optionsContainer.removeChild(options[options.length - 1]);
            }
        });
    </script>

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

        $('#question').summernote({
            placeholder: 'Subtitle Course',
            tabsize: 2,
            height: 200,
            toolbar: toolbar
        });
    </script>
@endpush
