@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto text-center">
    <div class="bg-white rounded-xl shadow-lg p-10">
        <div class="text-6xl mb-4">💘</div>
        <h1 class="text-4xl font-extrabold text-rose-600">Добро пожаловать в Vstrechka</h1>
        <p class="mt-4 text-gray-600">Твоё место для знакомств, общения и новых встреч</p>

        <div class="mt-8 flex justify-center gap-4">
            @if(auth()->check())
                <!-- Если пользователь залогинен -->
                <a href="{{ route('feed.index') }}" class="btn btn-rose">Лента</a>
                <a href="{{ route('matches.index') }}" class="btn btn-gray">Мэтчи</a>
            @else
                <!-- Если не залогинен -->
                <a href="{{ route('register.show') }}" class="btn btn-rose">Создать аккаунт</a>
                <a href="{{ route('login.show') }}" class="btn btn-gray">Войти</a>
            @endif
        </div>
    </div>
</div>
@endsection