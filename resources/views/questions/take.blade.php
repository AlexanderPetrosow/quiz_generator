<script src="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/dist/index.min.js"></script>

@extends('layouts.app')

@section('content')
    <h3>{{ $question->question_text }}</h3>

    @if (!$question->is_anonymous && !auth()->check())
        <div class="non-anonymous-warning">
            Этот опрос не анонимный. Пожалуйста, введите ваше имя и номер телефона:
            <input type="text" id="user_name" placeholder="Ваше имя">
            <input type="text" id="user_phone" placeholder="Ваш номер телефона">
            <button id="continue">Продолжить</button>
        </div>
    @endif

    <form action="{{ route('questions.answer', $question->id) }}" method="POST" id="survey-form">
        @csrf

        <!-- Дополнительные скрытые поля для имени и номера телефона -->
        <input type="hidden" name="name" id="name">
        <input type="hidden" name="phone" id="phone">

        <div id="answers">
            @foreach ($question->answers as $answer)
                <div>
                    @if ($question->answer_type == 'radio')
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
        // Если пользователь не авторизован и опрос не анонимный
        if (!{{ $question->is_anonymous }} && !{{ auth()->check() ? 'true' : 'false' }}) {
            document.getElementById('survey-form').style.display = 'none'; // Скрываем форму опроса

            document.getElementById('continue').addEventListener('click', function() {
                var name = document.getElementById('user_name').value;
                var phone = document.getElementById('user_phone').value;
                if (name && phone) {
                    document.getElementById('name').value = name;
                    document.getElementById('phone').value = phone;
                    document.querySelector('.non-anonymous-warning').style.display =
                        'none'; // Скрываем предупреждение
                    document.getElementById('survey-form').style.display = 'block'; // Показываем форму опроса
                } else {
                    alert('Пожалуйста, введите ваше имя и номер телефона.');
                }
            });
        }
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
@endsection
