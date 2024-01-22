@extends('layouts.template', ['title' => 'Quiz'])

@section('content')
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('list.course.step.edit', $course->id) }}">Edit Course</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('list.course.step.content', $course->id) }}">Create Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="">Create Quiz</a>
        </li>
    </ul>
    <form class="forms-sample" id="form" action="{{ route('list.course.step.quiz.save', $course->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Quiz</h4>
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" id="question" placeholder="Question" required autofocus>{{ old('question') }}</textarea>
                            @error('question')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button id="btn_submit" type="submit" class="btn btn-primary mr-2">Submit</button>
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
                            @for ($i = 0; $i < 5; $i++)
                                <div class="form-group option">
                                    <div>
                                        <label for="value">Value</label>
                                        <input type="text" name="value[{{ $i }}]" class="form-control"
                                            placeholder="Value" required>
                                    </div>
                                    <div class="answers-group">
                                        <label>Is Answer</label><br>
                                        <label>
                                            <input type="radio" name="answer[{{ $i }}]" value="yes"> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="answer[{{ $i }}]" value="no" checked>
                                            No
                                        </label>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        {{-- <button type="button" class="btn btn-primary mt-3" id="addOption">Add Option</button>
                        <button type="button" class="btn btn-danger mt-3" id="resetOptions">Reset Options</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Quiz</h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" style="width: 100%" id="table">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th class="text-center">Option Count</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($course->quizzes as $key => $item)
                                    <tr>
                                        <td>{{ Str::limit($item->question, 50) }}</td>
                                        <td class="text-center">{{ count($item->options) }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                                    id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                    <a class="dropdown-item"
                                                        href="{{ route('quiz.edit', $item->id) }}">Edit</a>
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
    <form action="" method="POST" id="form_delete">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('jslib')
    <script src="{{ asset('backend/js/file-upload.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#btn_submit').prop('disabled', true)
            $('#form input').change(function() {
                var count = $('input[name^="answer["][value="yes"]:checked').length;
                if (count > 0) {
                    $('#btn_submit').prop('disabled', false)
                } else {
                    $('#btn_submit').prop('disabled', true)
                }
            });
        });
        let optionIndex = 5;

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
            while (options.length > 5) {
                optionsContainer.removeChild(options[options.length - 1]);
            }
        });
    </script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>
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
