<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Vstrechka') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-rose-50 text-gray-800 min-h-screen flex flex-col">
    <header class="bg-rose-200 p-4 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Логотип/название как ссылка на главную -->
            <a href="{{ route('welcome') }}" class="text-xl font-bold text-rose-600 hover:text-rose-800 transition">
                Vstrechka
            </a>

            <nav class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('feed.index') }}" class="nav-link">Лента</a>
                    <a href="{{ route('matches.index') }}" class="nav-link">Мэтчи</a>
                    <a href="{{ route('search.index') }}" class="nav-link">Поиск</a>
                    <a href="{{ route('profile.show', Auth::user()) }}" class="nav-link">Профиль</a>

                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-purple flex items-center">
                            ⚙️ <span class="ml-1">Админка</span>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-rose-600 transition">Выйти</button>
                    </form>
                @else
                    <a href="{{ route('login.show') }}" class="nav-link">Войти</a>
                    <a href="{{ route('register.show') }}" class="btn btn-rose">Регистрация</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="p-6 flex-1">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>