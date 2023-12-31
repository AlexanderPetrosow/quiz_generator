@extends('layouts.app')

@section('content')

    <!-- Проверяем, есть ли флэш-сообщение в сессии -->
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <h3>Введите ключ для доступа к тесту</h3>

    <form action="/questions/key" method="GET">
        <div class="mb-3">
            <label for="unique_key" class="form-label">Уникальный ключ</label>
            <input type="text" class="form-control" id="unique_key" name="unique_key" required>
        </div>
        <button type="submit" class="btn btn-primary">Начать тест</button>
    </form>
@endsection
