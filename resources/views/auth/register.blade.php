@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <div class="text-center mb-6">
        <div class="text-5xl mb-3">✨</div>
        <h2 class="text-2xl font-bold">Регистрация</h2>
    </div>
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <input type="text" name="name" placeholder="Имя" class="input" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-sm text-red-600 mt-1">❌ {{ $message }}</p>
            @enderror
        </div>
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
        <div>
            <input type="password" name="password_confirmation" placeholder="Подтверждение пароля" class="input" required>
        </div>
        <button class="btn btn-rose w-full">Зарегистрироваться</button>
    </form>
    <p class="mt-4 text-center">
        Есть аккаунт? <a href="{{ route('login.show') }}" class="text-rose-600 font-semibold">Войти</a>
    </p>
</div>
@endsection
