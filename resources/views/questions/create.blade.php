@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Добавить вопрос</h3>
        <form action="{{ route('questions.store') }}" method="POST" id="questionForm">

            @csrf
            <div class="mb-3">
                <label for="question_text" class="form-label">Текст вопроса</label>
                <input type="text" class="form-control" id="question_text" name="question_text">
            </div>

            <h4>Ответы</h4>
            <div id="answersContainer" class="mb-3">

            </div>

            <button type="button" class="btn btn-secondary mb-3" id="addAnswer">Добавить вариант ответа</button>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>

        <script>
            document.getElementById('addAnswer').addEventListener('click', function() {
                const answersContainer = document.getElementById('answersContainer');
                const newAnswerDiv = document.createElement('div');
                const removeButton = document.createElement('button');
                removeButton.innerText = 'Удалить';
                removeButton.type = 'button';
                removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'removeAnswer');
                newAnswerDiv.appendChild(removeButton);
                newAnswerDiv.classList.add('mb-3', 'answer-input');

                const newAnswerNumber = answersContainer.getElementsByClassName('answer-input').length;

                const newLabel = document.createElement('label');
                newLabel.classList.add('form-label');
                newLabel.innerText = 'Ответ ' + newAnswerNumber;

                const newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.name = 'answers[]';
                newInput.classList.add('form-control');

                const newCheckboxLabel = document.createElement('label');
                newCheckboxLabel.innerText = 'Это правильный ответ?';

                const newCheckbox = document.createElement('input');
                newCheckbox.type = 'checkbox';
                newCheckbox.name = 'correct_answers[' + newAnswerNumber + ']';
                newCheckbox.value = '1';

                newAnswerDiv.appendChild(newLabel);
                newAnswerDiv.appendChild(newInput);
                newAnswerDiv.appendChild(newCheckboxLabel);
                newAnswerDiv.appendChild(newCheckbox);
                answersContainer.appendChild(newAnswerDiv);

                const orderLabel = document.createElement('label');
                // orderLabel.innerText = 'Порядковый номер';

                const orderInput = document.createElement('input');
                orderInput.type = 'number';
                orderInput.value = 0;
                orderInput.name = 'order_ids[]';
                orderInput.classList.add('form-control', 'mt-2');

                newAnswerDiv.appendChild(orderLabel);
                newAnswerDiv.appendChild(orderInput);

                document.addEventListener('click', function(event) {
                    if (event.target && event.target.classList.contains('removeAnswer')) {
                        event.target.parentNode.remove();
                    }
                });

            });
        </script>
    @endsection
