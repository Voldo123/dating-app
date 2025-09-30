@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center mb-6">
        <div class="w-24 h-24 bg-rose-200 rounded-full flex items-center justify-center">
            <span class="text-rose-600 font-bold text-3xl">
                {{ substr($user->name, 0, 1) }}
            </span>
        </div>
        <div class="ml-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
            <div class="flex items-center space-x-4 text-gray-600 mt-2">
                @if($user->age)
                    <span>{{ $user->age }} лет</span>
                @endif
                @if($user->gender)
                    <span>• {{ $user->gender }}</span>
                @endif
                @if($user->city)
                    <span>• {{ $user->city }}</span>
                @endif
            </div>
        </div>
    </div>

    @if($user->about)
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">О себе</h2>
            <p class="text-gray-600 bg-rose-50 p-4 rounded-lg">{{ $user->about }}</p>
        </div>
    @endif

    @if($user->telegram)
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Контакты</h2>
            <a href="https://t.me/{{ $user->telegram }}" 
               target="_blank"
               class="inline-flex items-center text-blue-500 hover:text-blue-600">
                <span class="mr-2">✈️</span> Telegram: {{ $user->telegram }}
            </a>
        </div>
    @endif

    <div class="flex space-x-4">
        <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            ← Назад
        </a>
        
        @if(Auth::id() !== $user->id)
            <a href="{{ route('feed.index') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-lg">
                Вернуться в ленту
            </a>
        @endif
    </div>
</div>
@endsection