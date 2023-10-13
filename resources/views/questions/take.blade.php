<script src="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/dist/index.min.js"></script>

@extends('layouts.app')

@section('content')
    <h3>{{ $question->question_text }}</h3>
    <form action="{{ route('questions.answer', $question->id) }}" method="POST">
        @csrf
        <div id="answers">
            @foreach ($question->answers as $answer)
                <div>
                    @if ($question->type == 'radio')
                        <input type="radio" name="selected_answers[]" value="{{ $answer->id }}"
                            id="answer_{{ $answer->id }}">
                    @else
                        <input type="checkbox" name="selected_answers[]" value="{{ $answer->id }}"
                            id="answer_{{ $answer->id }}">
                    @endif
                    <label for="answer_{{ $answer->id }}">{{ $answer->answer_text }}</label>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="selected_answer" id="selected_answer" value="">
        <button type="submit" class="btn btn-primary mt-4">Готово</button>
    </form>

    <script>
        document.querySelectorAll('.answer-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    document.getElementById('selected_answer').value = '';
                } else {
                    document.querySelectorAll('.answer-btn.selected').forEach(b => b.classList.remove(
                        'selected'));
                    this.classList.add('selected');
                    document.getElementById('selected_answer').value = this.getAttribute('data-answer-id');
                }
            });
        });
    </script>

    <style>
        .answer-btn {
            display: block;
            margin: 10px 0;
            background-color: #f1f1f1;
        }

        .answer-btn.selected {
            background-color: #4CAF50;
            color: white;
        }
    </style>
@endsection
