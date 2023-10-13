<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/chart.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light  bg-main">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('img/logo.png') }}" width="200px"></a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Оставьте это пустым, если вы хотите добавить другие ссылки в будущем -->
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            Главная
                        </a>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('questions.enterKey') }}">
                            Найти опросник
                        </a>

                        @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('questions.index') }}">
                            Вопросы
                        </a>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            Пользователи
                        </a>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Выход
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Войти
                        </a>
                        @endif
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
