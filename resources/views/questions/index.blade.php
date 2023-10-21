@extends('layouts.app')

@section('content')
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Добавить вопрос</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Вопрос</th>
                <th scope="col">Тип</th> <!-- Новый столбец для типа вопроса -->
                <th scope="col">Анонимный</th> <!-- Новый столбец для анонимности -->
                <th scope="col">Ключ</th>
                <th scope="col">Дата создания</th>
                <th scope="col">Дата обновления</th>
                @if ($isAdmin)
                    <th scope="col">Имя создателя</th>
                @endif
                <th scope="col">Действия</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <th scope="row">{{ $question->id }}</th>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $question->answer_type == 'radio' ? 'Радиокнопка' : 'Чекбокс' }}</td> <!-- Тип вопроса -->
                    <td>{{ $question->is_anonymous ? 'Да' : 'Нет' }}</td> <!-- Анонимность -->
                    <td>{{ $question->unique_key }}</td>
                    <td>{{ $question->created_at }}</td>
                    <td>{{ $question->updated_at }}</td>
                    @if ($isAdmin)
                        <td>id:{{ optional($question->user)->id }} {{ optional($question->user)->name }}
                            {{ optional($question->user)->surname }}</td>
                    @endif
                    <td>
                        <a href="{{ route('questions.edit', $question->id) }}"
                            class="btn btn-warning btn-sm">Редактировать</a>
                        

                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>

                        <a href="{{ route('questions.show', $question->id) }}" class="btn btn-info btn-sm">Посмотреть</a>
                        <a href="{{ route('questions.qrcode', $question->unique_key) }}" class="btn btn-success btn-sm">Скачать QR-код</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-danger').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    if (!confirm('Вы уверены, что хотите удалить этот вопрос?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
