@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-center mb-6">🔍 Поиск людей</h2>

    <form action="{{ route('search.results') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Пол -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Пол</label>
            <div class="flex space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="gender" value="Мужчина" class="text-rose-500 focus:ring-rose-500">
                    <span class="ml-2">👨 Мужской</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="Женщина" class="text-rose-500 focus:ring-rose-500">
                    <span class="ml-2">👩 Женский</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="" checked class="text-rose-500 focus:ring-rose-500">
                    <span class="ml-2">🤷 Не важно</span>
                </label>
            </div>
        </div>

        <!-- Возраст -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Возраст от</label>
                <input type="number" name="age_from" min="18" max="100" 
                       class="input" placeholder="18">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Возраст до</label>
                <input type="number" name="age_to" min="18" max="100" 
                       class="input" placeholder="35">
            </div>
        </div>

        <!-- Город -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Город</label>
            <input type="text" name="city" list="cities" class="input" placeholder="Начните вводить город...">
            <datalist id="cities">
                @foreach($cities as $city)
                    <option value="{{ $city }}">
                @endforeach
            </datalist>
        </div>

        <!-- Теги -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Интересы (можно выбрать несколько)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-3">
                @foreach($tags as $tag)
                    <label class="flex items-center">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                               class="rounded border-gray-300 text-rose-500 focus:ring-rose-500">
                        <span class="ml-2 text-sm">#{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Кнопки -->
        <div class="flex space-x-4 pt-4">
            <button type="submit" class="btn btn-rose flex-1">
                🔍 Найти людей
            </button>
            <a href="{{ route('search.index') }}" class="btn btn-gray flex-1">
                🗑️ Сбросить
            </a>
        </div>
    </form>
</div>
@endsection