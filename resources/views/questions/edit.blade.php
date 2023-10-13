@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3>Редактировать вопрос</h3>

    <form action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question_text" class="form-label">Текст вопроса</label>
            <input type="text" class="form-control" id="question_text" name="question_text"
                value="{{ $question->question_text }}">
        </div>

        <div class="answers-section">
            @foreach ($answers as $answer)
                <div class="mb-3">
                    <label class="form-label">Ответ</label>
                    <input type="text" class="form-control" name="answers[{{ $answer->id }}]"
                        value="{{ $answer->answer_text }}">
                    <input type="number" class="form-control mt-2" name="order_ids[{{ $answer->id }}]"
                        value="{{ $answer->order_id }}" placeholder="Порядковый номер">
                    <input type="checkbox" name="correct_answers[{{ $answer->id }}]" value="1"
                        @if ($answer->is_correct) checked @endif> Это правильный ответ?
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="addMoreAnswers">Добавить еще ответ</button>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
    <script>
        document.getElementById('addMoreAnswers').addEventListener('click', function() {
            const answersContainer = document.querySelector('.answers-section');
            const newAnswerDiv = document.createElement('div');
            newAnswerDiv.classList.add('mb-3');

            const newLabel = document.createElement('label');
            newLabel.classList.add('form-label');
            newLabel.innerText = 'Ответ';

            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.name = 'new_answers[]';
            newInput.classList.add('form-control');

            const newCheckboxLabel = document.createElement('label');
            newCheckboxLabel.innerText = ' Это правильный ответ?';

            const newCheckbox = document.createElement('input');
            newCheckbox.type = 'checkbox';
            newCheckbox.name = 'new_correct_answers[]';
            newCheckbox.value = '1';

            const orderLabel = document.createElement('label');
            orderLabel.innerText = 'Порядковый номер';
            orderLabel.classList.add('mt-2');

            const orderInput = document.createElement('input');
            orderInput.type = 'number';
            orderInput.name = 'new_order_ids[]';
            orderInput.classList.add('form-control', 'mt-2');

            newAnswerDiv.appendChild(newLabel);
            newAnswerDiv.appendChild(newInput);
            newAnswerDiv.appendChild(orderLabel);
            newAnswerDiv.appendChild(orderInput);
            newAnswerDiv.appendChild(newCheckbox);
            newAnswerDiv.appendChild(newCheckboxLabel);
            answersContainer.appendChild(newAnswerDiv);
        });
    </script>
@endsection
