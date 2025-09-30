@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <div class="text-center mb-6">
        <div class="text-5xl mb-3">🔑</div>
        <h2 class="text-2xl font-bold">Вход</h2>
    </div>
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <input type="email" name="email" placeholder="Email" class="input" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
        </div>

        <div>
            <input type="password" name="password" placeholder="Пароль" class="input" required>
            @error('password')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
        </div>

        <button class="btn btn-rose w-full">Войти</button>
    </form>
    <p class="mt-4 text-center">
        Нет аккаунта? <a href="{{ route('register.show') }}" class="text-rose-600 font-semibold">Создать</a>
    </p>
</div>
@endsection
