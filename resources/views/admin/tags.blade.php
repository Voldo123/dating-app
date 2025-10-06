@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <!-- Заголовок -->
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">🏷️</div>
        <h1 class="text-3xl font-bold text-gray-900">Управление тегами</h1>
        <p class="text-gray-600 mt-2">Создавайте и управляйте тегами для пользователей</p>
    </div>

    <!-- Форма добавления тега -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-rose-100">
        <h2 class="text-xl font-semibold mb-4 flex items-center">
            <span class="mr-2">➕</span> Добавить новый тег
        </h2>
        <form method="POST" action="{{ route('admin.tags.store') }}" class="flex gap-4 items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Название тега</label>
                <input type="text" name="name" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-transparent transition"
                       placeholder="Например: Путешествия, Спорт, Искусство..." 
                       required>
                @error('name')
                    <p class="text-sm text-red-600 mt-2 flex items-center">
                        <span class="mr-1">❌</span> {{ $message }}
                    </p>
                @enderror
            </div>
            <button type="submit" class="btn btn-rose whitespace-nowrap px-6 py-3 rounded-xl">
                <span class="mr-2">➕</span> Добавить
            </button>
        </form>
    </div>

    <!-- Список тегов -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-rose-50 to-pink-50">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <span class="mr-2">📋</span> 
                Список тегов
                <span class="ml-2 bg-rose-500 text-white px-3 py-1 rounded-full text-sm">
                    {{ $tags->count() }}
                </span>
            </h2>
        </div>
        
        @if($tags->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($tags as $tag)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-rose-50 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-rose-100 to-pink-200 rounded-xl flex items-center justify-center mr-4">
                                <span class="text-xl text-rose-600">#</span>
                            </div>
                            <div>
                                <span class="text-lg font-semibold text-gray-900">{{ $tag->name }}</span>
                                <p class="text-sm text-gray-500 mt-1">
                                    <span class="inline-flex items-center">
                                        <span class="mr-1">👥</span>
                                        Используется <span class="font-medium text-rose-600 mx-1">{{ $tag->users->count() }}</span> пользователем(ями)
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('admin.tags.destroy', $tag->id) }}"
                              onsubmit="return confirm('Вы уверены, что хотите удалить тег «{{ $tag->name }}»?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl transition-colors duration-200 flex items-center">
                                <span class="mr-2">🗑️</span> Удалить
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-8xl mb-4 text-gray-300">🏷️</div>
                <p class="text-xl text-gray-600 mb-2">Тегов пока нет</p>
                <p class="text-gray-500">Добавьте первый тег с помощью формы выше</p>
            </div>
        @endif
    </div>

    <!-- Популярные теги -->
    @if($tags->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg p-6 mt-8">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                <span class="mr-2">🔥</span> Самые популярные теги
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($tags->sortByDesc(function($tag) { return $tag->users->count(); })->take(6) as $tag)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl border border-rose-100">
                        <div class="flex items-center">
                            <span class="text-lg font-medium text-gray-900">#{{ $tag->name }}</span>
                        </div>
                        <span class="bg-rose-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $tag->users->count() }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Кнопка возврата -->
    <div class="text-center mt-8">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-gray inline-flex items-center">
            <span class="mr-2">⬅️</span> Назад в админ-панель
        </a>
    </div>
</div>

<style>
.gradient-border {
    background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
    border: 1px solid transparent;
    background-clip: padding-box;
    position: relative;
}

.gradient-border::after {
    content: '';
    position: absolute;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: -1px;
    background: linear-gradient(135deg, #f472b6 0%, #fb7185 100%);
    border-radius: inherit;
    z-index: -1;
}
</style>
@endsection