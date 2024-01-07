@extends('layouts.template', ['title' => 'Quiz'])

@section('content')
    <form class="forms-sample" id="form" action="{{ route('quiz.update', $data->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Quiz</h4>
                        @if (auth()->user()->role == 'admin')
                            <div class="form-group">
                                <label for="course">Course</label>
                                <select class="form-control @error('course') is-invalid @enderror" name="course"
                                    id="course" required>
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
                        @endif
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" id="question" placeholder="Question" required autofocus>{{ $data->question }}</textarea>
                            @error('question')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        @if (auth()->user()->role == 'admin')
                            <a href="{{ route('quiz.index') }}" class="btn btn-light">Cancel</a>
                        @else
                            <a href="{{ route('list.course.step.quiz', $data->course_id) }}"
                                class="btn btn-light">Cancel</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Options Of Quiz</h4>
                        <div id="options-container">
                            @forelse ($data->options as $i => $item)
                                <div class="form-group option">
                                    <div>
                                        <label for="value">Value</label>
                                        <input type="text" name="value[{{ $i }}]" class="form-control"
                                            placeholder="Value" value="{{ $item->value }}" required>
                                    </div>
                                    <div>
                                        <label>Is Answer</label><br>
                                        <label>
                                            <input type="radio" name="answer[{{ $i }}]" value="yes"
                                                {{ $item->is_answer == 'yes' ? 'checked' : '' }}> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="answer[{{ $i }}]" value="no"
                                                {{ $item->is_answer == 'no' ? 'checked' : '' }}> No
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="form-group option">
                                    <div>
                                        <label for="value">Value</label>
                                        <input type="text" name="value[0]" class="form-control" placeholder="Value"
                                            required>
                                    </div>
                                    <div>
                                        <label>Is Answer</label><br>
                                        <label>
                                            <input type="radio" name="answer[0]" value="yes"> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="answer[0]" value="no" checked> No
                                        </label>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" class="btn btn-primary mt-3" id="addOption">Add Option</button>
                        <button type="button" class="btn btn-danger mt-3" id="resetOptions">Reset Options</button>
                        <a href="" class="btn btn-danger mt-3" id="">Reload Options</a>
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
        let js = @json($data->options);
        let optionIndex = js.length

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
            console.log(optionIndex);
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
